<?php
/**
 * Plugin Name: OnPage.dev
 * Plugin URI: https://github.com/seoonpage/seo-mcp-server/tree/main/wordpress/onpage-dev
 * Description: Approve SEO fixes from your AI assistant with one click. OnPage.dev proposes, you approve, the plugin writes them through Yoast, Rank Math or its own tags, and every change can be undone.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: OnPage.dev
 * Author URI: https://onpage.dev
 * License: MIT
 * Text Domain: onpage-dev
 */

if (!defined('ABSPATH')) {
	exit;
}

const ONPAGE_DEV_HISTORY_MAX = 200;
const ONPAGE_DEV_VERSION = '1.1.0';
const ONPAGE_DEV_CONTENT_MAX = 200000;

function onpage_dev_api($path) {
	return apply_filters('onpage_dev_api_base', 'https://onpage.dev') . '/wp/v1' . $path;
}

function onpage_dev_request($method, $path, $body = null) {
	$auth = get_option('onpage_dev_site_id') . '.' . get_option('onpage_dev_secret');
	$args = array(
		'method' => $method,
		'timeout' => 15,
		'headers' => array('Authorization' => 'Bearer ' . $auth, 'Content-Type' => 'application/json', 'X-OnPage-Plugin' => ONPAGE_DEV_VERSION),
	);
	if (null !== $body) {
		$args['body'] = wp_json_encode($body);
	}
	$res = wp_remote_request(onpage_dev_api($path), $args);
	if (is_wp_error($res)) {
		return $res;
	}
	$code = wp_remote_retrieve_response_code($res);
	$data = json_decode(wp_remote_retrieve_body($res), true);
	if ($code >= 400 || !is_array($data)) {
		return new WP_Error('onpage_dev', is_array($data) && isset($data['error']) ? sanitize_text_field($data['error']) : 'OnPage.dev answered with status ' . $code);
	}
	return $data;
}

function onpage_dev_seo_plugin() {
	if (defined('WPSEO_VERSION')) {
		return 'yoast';
	}
	if (class_exists('RankMath')) {
		return 'rankmath';
	}
	return 'onpage';
}

function onpage_dev_meta_key($field, $via) {
	$keys = array(
		'yoast' => array('title' => '_yoast_wpseo_title', 'meta_description' => '_yoast_wpseo_metadesc', 'canonical' => '_yoast_wpseo_canonical', 'og_title' => '_yoast_wpseo_opengraph-title', 'og_description' => '_yoast_wpseo_opengraph-description', 'og_image' => '_yoast_wpseo_opengraph-image'),
		'rankmath' => array('title' => 'rank_math_title', 'meta_description' => 'rank_math_description', 'canonical' => 'rank_math_canonical_url', 'og_title' => 'rank_math_facebook_title', 'og_description' => 'rank_math_facebook_description', 'og_image' => 'rank_math_facebook_image'),
	);
	if ('jsonld' === $field) {
		return '_onpage_dev_jsonld';
	}
	return isset($keys[$via][$field]) ? $keys[$via][$field] : '_onpage_dev_' . $field;
}

function onpage_dev_post_for($url) {
	$url = esc_url_raw($url);
	if (!$url || wp_parse_url($url, PHP_URL_HOST) !== wp_parse_url(home_url(), PHP_URL_HOST)) {
		return 0;
	}
	$id = url_to_postid($url);
	if (!$id && untrailingslashit($url) === untrailingslashit(home_url())) {
		$id = (int) get_option('page_on_front');
	}
	return $id;
}

function onpage_dev_clean($field, $value) {
	if ('post_content' === $field) {
		return is_string($value) && '' !== trim($value) && strlen($value) <= ONPAGE_DEV_CONTENT_MAX ? wp_kses_post($value) : null;
	}
	if ('new_post' === $field) {
		if (!is_array($value) || !isset($value['title'], $value['content']) || !is_string($value['title']) || !is_string($value['content']) || '' === trim($value['title']) || '' === trim($value['content']) || strlen($value['content']) > ONPAGE_DEV_CONTENT_MAX) {
			return null;
		}
		return array(
			'title' => mb_substr(sanitize_text_field($value['title']), 0, 200),
			'content' => wp_kses_post($value['content']),
			'slug' => isset($value['slug']) && is_string($value['slug']) ? sanitize_title($value['slug']) : '',
			'excerpt' => isset($value['excerpt']) && is_string($value['excerpt']) ? mb_substr(sanitize_textarea_field($value['excerpt']), 0, 400) : '',
			'type' => isset($value['type']) && 'page' === $value['type'] ? 'page' : 'post',
		);
	}
	if ('image_alt' === $field) {
		if (!is_array($value) || !isset($value['src'], $value['alt'])) {
			return null;
		}
		return array('src' => esc_url_raw($value['src']), 'alt' => mb_substr(sanitize_text_field($value['alt']), 0, 150));
	}
	if (!is_string($value)) {
		return null;
	}
	if ('jsonld' === $field) {
		$data = json_decode($value, true);
		return is_array($data) && strlen($value) <= 20000 ? $data : null;
	}
	if ('canonical' === $field || 'og_image' === $field) {
		$url = esc_url_raw($value, array('https'));
		return $url && wp_http_validate_url($url) ? $url : null;
	}
	$limits = array('title' => 200, 'meta_description' => 400, 'og_title' => 200, 'og_description' => 400);
	if (!isset($limits[$field])) {
		return null;
	}
	$text = sanitize_text_field($value);
	return '' !== $text ? mb_substr($text, 0, $limits[$field]) : null;
}

function onpage_dev_history_add($entry) {
	$history = get_option('onpage_dev_history', array());
	array_unshift($history, $entry);
	update_option('onpage_dev_history', array_slice($history, 0, ONPAGE_DEV_HISTORY_MAX), false);
}

function onpage_dev_apply($set, $picked) {
	$post_id = onpage_dev_post_for($set['url']);
	$via = onpage_dev_seo_plugin();
	$result = array();
	foreach ($set['changes'] as $i => $change) {
		$field = isset($change['field']) ? sanitize_key($change['field']) : '';
		if (!in_array($i, $picked, true)) {
			$result[] = array('field' => $field, 'ok' => false, 'error' => 'not approved');
			continue;
		}
		$value = onpage_dev_clean($field, isset($change['value']) ? $change['value'] : null);
		if (null === $value) {
			$result[] = array('field' => $field, 'ok' => false, 'error' => 'value refused by the plugin');
			continue;
		}
		if ('new_post' === $field) {
			if (!current_user_can('page' === $value['type'] ? 'edit_pages' : 'edit_posts')) {
				$result[] = array('field' => $field, 'ok' => false, 'error' => 'not allowed to create a ' . $value['type']);
				continue;
			}
			$new_id = wp_insert_post(wp_slash(array('post_title' => $value['title'], 'post_content' => $value['content'], 'post_excerpt' => $value['excerpt'], 'post_name' => $value['slug'], 'post_type' => $value['type'], 'post_status' => 'draft', 'post_author' => get_current_user_id())), true);
			if (is_wp_error($new_id)) {
				$result[] = array('field' => $field, 'ok' => false, 'error' => $new_id->get_error_message());
				continue;
			}
			onpage_dev_history_add(array('at' => time(), 'set' => $set['id'], 'post' => $new_id, 'key' => 'new_post', 'old' => '', 'new' => $value['title'], 'field' => $field));
			$result[] = array('field' => $field, 'ok' => true, 'via' => 'draft', 'post_id' => $new_id, 'url' => get_preview_post_link($new_id));
			continue;
		}
		if ('post_content' === $field) {
			if (!$post_id || !current_user_can('edit_post', $post_id)) {
				$result[] = array('field' => $field, 'ok' => false, 'error' => 'no post or page for this URL');
				continue;
			}
			$prev = '_onpage_dev_prev_' . substr(md5($set['id']), 0, 12);
			update_post_meta($post_id, $prev, wp_slash(get_post_field('post_content', $post_id, 'raw')));
			$saved = wp_update_post(wp_slash(array('ID' => $post_id, 'post_content' => $value)), true);
			if (is_wp_error($saved)) {
				delete_post_meta($post_id, $prev);
				$result[] = array('field' => $field, 'ok' => false, 'error' => $saved->get_error_message());
				continue;
			}
			onpage_dev_history_add(array('at' => time(), 'set' => $set['id'], 'post' => $post_id, 'key' => $prev, 'old' => '', 'new' => md5(get_post_field('post_content', $post_id, 'raw')), 'field' => $field));
			$result[] = array('field' => $field, 'ok' => true, 'via' => 'post content', 'url' => get_permalink($post_id));
			continue;
		}
		if ('image_alt' === $field) {
			$src = preg_replace('/-\d+x\d+(\.[a-z0-9]+)$/i', '$1', $value['src']);
			$att = attachment_url_to_postid($src);
			if (!$att || !current_user_can('edit_post', $att)) {
				$result[] = array('field' => $field, 'ok' => false, 'error' => 'image not in the media library');
				continue;
			}
			$old = (string) get_post_meta($att, '_wp_attachment_image_alt', true);
			update_post_meta($att, '_wp_attachment_image_alt', $value['alt']);
			onpage_dev_history_add(array('at' => time(), 'set' => $set['id'], 'post' => $att, 'key' => '_wp_attachment_image_alt', 'old' => $old, 'new' => $value['alt'], 'field' => $field));
			$result[] = array('field' => $field, 'ok' => true, 'via' => 'media library', 'old' => $old);
			continue;
		}
		if (!$post_id || !current_user_can('edit_post', $post_id)) {
			$result[] = array('field' => $field, 'ok' => false, 'error' => 'no post or page for this URL');
			continue;
		}
		$key = onpage_dev_meta_key($field, $via);
		$old = get_post_meta($post_id, $key, true);
		update_post_meta($post_id, $key, wp_slash($value));
		onpage_dev_history_add(array('at' => time(), 'set' => $set['id'], 'post' => $post_id, 'key' => $key, 'old' => $old, 'new' => $value, 'field' => $field));
		$result[] = array('field' => $field, 'ok' => true, 'via' => 'jsonld' === $field ? 'onpage' : $via, 'old' => is_string($old) ? $old : '');
	}
	if ($post_id) {
		clean_post_cache($post_id);
	}
	return $result;
}

function onpage_dev_undo($set_id) {
	$history = get_option('onpage_dev_history', array());
	$all = true;
	foreach ($history as $i => $h) {
		if ($h['set'] !== $set_id || !empty($h['undone']) || !current_user_can('edit_post', $h['post'])) {
			continue;
		}
		if ('new_post' === $h['field']) {
			if (!in_array(get_post_status($h['post']), array('draft', 'pending', 'auto-draft'), true)) {
				$all = false;
				continue;
			}
			wp_trash_post($h['post']);
		} elseif ('post_content' === $h['field']) {
			if (md5(get_post_field('post_content', $h['post'], 'raw')) !== $h['new']) {
				$all = false;
				continue;
			}
			wp_update_post(wp_slash(array('ID' => $h['post'], 'post_content' => get_post_meta($h['post'], $h['key'], true))));
			delete_post_meta($h['post'], $h['key']);
		} elseif ('' === $h['old'] || null === $h['old']) {
			delete_post_meta($h['post'], $h['key']);
		} else {
			update_post_meta($h['post'], $h['key'], wp_slash($h['old']));
		}
		clean_post_cache($h['post']);
		$history[$i]['undone'] = time();
	}
	update_option('onpage_dev_history', $history, false);
	return $all;
}

function onpage_dev_own($field) {
	if (!is_singular() || 'onpage' !== onpage_dev_seo_plugin()) {
		return '';
	}
	return (string) get_post_meta(get_queried_object_id(), '_onpage_dev_' . $field, true);
}

add_filter('pre_get_document_title', function ($title) {
	$own = onpage_dev_own('title');
	return '' !== $own ? $own : $title;
}, 20);

add_filter('get_canonical_url', function ($url) {
	$own = onpage_dev_own('canonical');
	return '' !== $own ? $own : $url;
});

add_action('wp_head', function () {
	foreach (array('meta_description' => 'name="description"', 'og_title' => 'property="og:title"', 'og_description' => 'property="og:description"', 'og_image' => 'property="og:image"') as $field => $attr) {
		$value = onpage_dev_own($field);
		if ('' !== $value) {
			echo '<meta ' . $attr . ' content="' . esc_attr($value) . '">' . "\n";
		}
	}
	if (is_singular()) {
		$data = get_post_meta(get_queried_object_id(), '_onpage_dev_jsonld', true);
		if (is_array($data) && $data) {
			echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) . "</script>\n";
		}
	}
}, 2);

add_action('admin_menu', function () {
	add_management_page('OnPage.dev', 'OnPage.dev', 'manage_options', 'onpage-dev', 'onpage_dev_page');
});

add_action('admin_post_onpage_dev', function () {
	if (!current_user_can('manage_options')) {
		wp_die('Not allowed.');
	}
	check_admin_referer('onpage_dev');
	$do = isset($_POST['do']) ? sanitize_key(wp_unslash($_POST['do'])) : '';
	$note = '';
	if ('connect' === $do) {
		$res = wp_remote_post(onpage_dev_api('/register'), array('timeout' => 15, 'headers' => array('Content-Type' => 'application/json'), 'body' => wp_json_encode(array('home' => home_url()))));
		$data = is_wp_error($res) ? null : json_decode(wp_remote_retrieve_body($res), true);
		if (is_array($data) && isset($data['site_id'], $data['secret'], $data['site_key'])) {
			update_option('onpage_dev_site_id', sanitize_text_field($data['site_id']), false);
			update_option('onpage_dev_secret', sanitize_text_field($data['secret']), false);
			update_option('onpage_dev_site_key', sanitize_text_field($data['site_key']), false);
			$note = 'connected';
		} else {
			$note = 'connect-failed';
		}
	}
	if ('decide' === $do && isset($_POST['set'])) {
		$set_id = sanitize_text_field(wp_unslash($_POST['set']));
		$pending = onpage_dev_request('GET', '/changes');
		$set = null;
		foreach (is_wp_error($pending) ? array() : $pending['changes'] as $s) {
			if ($s['id'] === $set_id) {
				$set = $s;
			}
		}
		if ($set) {
			$approve = isset($_POST['approve']);
			$picked = $approve && isset($_POST['pick']) ? array_map('intval', (array) wp_unslash($_POST['pick'])) : array();
			$result = $approve ? onpage_dev_apply($set, $picked) : array();
			$ok = count(array_filter($result, function ($r) {
				return $r['ok'];
			}));
			onpage_dev_request('POST', '/changes/' . rawurlencode($set_id), array('status' => $ok ? 'applied' : 'rejected', 'result' => $result));
			$note = $ok ? 'applied' : 'rejected';
		}
	}
	if ('undo' === $do && isset($_POST['set'])) {
		$set_id = sanitize_text_field(wp_unslash($_POST['set']));
		$all = onpage_dev_undo($set_id);
		onpage_dev_request('POST', '/changes/' . rawurlencode($set_id), array('status' => 'undone', 'result' => array()));
		$note = $all ? 'undone' : 'undone-partly';
	}
	if ('disconnect' === $do) {
		onpage_dev_request('DELETE', '/site');
		foreach (array('onpage_dev_site_id', 'onpage_dev_secret', 'onpage_dev_site_key') as $o) {
			delete_option($o);
		}
		$note = 'disconnected';
	}
	wp_safe_redirect(add_query_arg('onpage', $note, admin_url('tools.php?page=onpage-dev')));
	exit;
});

function onpage_dev_show($value) {
	if (is_array($value)) {
		return isset($value['src'], $value['alt']) ? $value['alt'] . ' (' . basename((string) wp_parse_url($value['src'], PHP_URL_PATH)) . ')' : 'JSON-LD';
	}
	return (string) $value;
}

function onpage_dev_current($set, $field) {
	$post_id = onpage_dev_post_for($set['url']);
	if (!$post_id || 'image_alt' === $field) {
		return '';
	}
	$value = get_post_meta($post_id, onpage_dev_meta_key($field, onpage_dev_seo_plugin()), true);
	if ('' === $value && 'title' === $field) {
		return get_the_title($post_id) . ' (post title)';
	}
	return is_array($value) ? 'JSON-LD' : (string) $value;
}

function onpage_dev_words($html) {
	return count(preg_split('/\s+/u', trim(wp_strip_all_tags(preg_replace('/<[^>]+>/', ' ', (string) $html))), -1, PREG_SPLIT_NO_EMPTY));
}

function onpage_dev_paras($html) {
	preg_match_all('#<(p|li|h[1-6])\b[^>]*>(.*?)</\1>#is', (string) $html, $m);
	return array_values(array_filter(array_map(function ($t) {
		return trim(preg_replace('/\s+/u', ' ', wp_strip_all_tags($t)));
	}, $m[2])));
}

function onpage_dev_box($html) {
	return '<div style="max-height:420px;overflow:auto;border:1px solid #dcdcde;padding:8px 12px;background:#fff">' . wp_kses_post($html) . '</div>';
}

function onpage_dev_content_now($set, $field) {
	if ('new_post' === $field) {
		return 'New draft';
	}
	$id = onpage_dev_post_for($set['url']);
	return $id ? onpage_dev_words(get_post_field('post_content', $id, 'raw')) . ' words' : '';
}

function onpage_dev_content_new($set, $c) {
	$v = $c['value'];
	if ('new_post' === sanitize_key($c['field'])) {
		$html = is_array($v) && isset($v['content']) ? (string) $v['content'] : '';
		$type = is_array($v) && isset($v['type']) && 'page' === $v['type'] ? 'page' : 'post';
		$title = is_array($v) && isset($v['title']) ? (string) $v['title'] : '';
		return esc_html($title . ' (' . $type . ', saved as a draft)') . '<br>' . esc_html(onpage_dev_words($html) . ' words') . '<details><summary>Read it</summary>' . onpage_dev_box($html) . '</details>';
	}
	$html = (string) $v;
	$id = onpage_dev_post_for($set['url']);
	$old = $id ? onpage_dev_paras(get_post_field('post_content', $id, 'raw')) : array();
	$new = onpage_dev_paras($html);
	$added = array_values(array_diff($new, $old));
	$removed = array_values(array_diff($old, $new));
	$out = esc_html(onpage_dev_words($html) . ' words, new or changed paragraphs: ' . count($added) . ', removed: ' . count($removed) . '. Approving updates the live post.');
	$out .= '<details><summary>Show the changes</summary>';
	foreach (array_slice($removed, 0, 30) as $p) {
		$out .= '<p style="background:#fcf0f1;margin:4px 0;padding:4px 8px"><del>' . esc_html($p) . '</del></p>';
	}
	foreach (array_slice($added, 0, 30) as $p) {
		$out .= '<p style="background:#edfaef;margin:4px 0;padding:4px 8px"><ins>' . esc_html($p) . '</ins></p>';
	}
	return $out . '</details><details><summary>Read the new text</summary>' . onpage_dev_box($html) . '</details>';
}

function onpage_dev_page() {
	$key = get_option('onpage_dev_site_key');
	$messages = array('connected' => 'Connected. Give the site key to your AI assistant.', 'connect-failed' => 'Could not reach OnPage.dev. Try again in a minute.', 'applied' => 'Changes written. Clear your page cache if you use one.', 'rejected' => 'Changes rejected.', 'undone' => 'Changes undone.', 'undone-partly' => 'Undone, except content that was edited or published since. Use the post revisions for those.', 'disconnected' => 'Disconnected.');
	$note = isset($_GET['onpage']) ? sanitize_key(wp_unslash($_GET['onpage'])) : '';
	echo '<div class="wrap"><h1>OnPage.dev</h1>';
	if (isset($messages[$note])) {
		echo '<div class="notice notice-info"><p>' . esc_html($messages[$note]) . '</p></div>';
	}
	if (!$key) {
		echo '<p>Connect this site so your AI assistant can send SEO fixes here for your approval. Nothing changes until you approve it.</p>';
		echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
		wp_nonce_field('onpage_dev');
		echo '<input type="hidden" name="action" value="onpage_dev"><input type="hidden" name="do" value="connect">';
		submit_button('Connect to OnPage.dev');
		echo '</form><p class="description">Connecting sends only this site address to onpage.dev. OnPage.dev never logs in to this site: the plugin fetches proposed changes and writes only the ones you approve.</p></div>';
		return;
	}
	echo '<h2>Site key</h2><p>Give this key to your AI assistant (Claude, ChatGPT, Cursor or another client with OnPage.dev connected), for example: <em>send the fixes for my home page to WordPress, site key ...</em></p>';
	echo '<p><input type="text" class="regular-text code" readonly onfocus="this.select()" value="' . esc_attr($key) . '"></p>';
	echo '<p>SEO fields are written through <strong>' . esc_html(array('yoast' => 'Yoast SEO', 'rankmath' => 'Rank Math', 'onpage' => 'this plugin')[onpage_dev_seo_plugin()]) . '</strong>.</p>';
	$pending = onpage_dev_request('GET', '/changes');
	echo '<h2>Waiting for approval</h2>';
	if (is_wp_error($pending)) {
		echo '<p>' . esc_html($pending->get_error_message()) . '</p>';
	} elseif (empty($pending['changes'])) {
		echo '<p>Nothing waiting.</p>';
	} else {
		foreach ($pending['changes'] as $set) {
			echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '" style="margin:0 0 24px">';
			wp_nonce_field('onpage_dev');
			echo '<input type="hidden" name="action" value="onpage_dev"><input type="hidden" name="do" value="decide"><input type="hidden" name="set" value="' . esc_attr($set['id']) . '">';
			echo '<h3><a href="' . esc_url($set['url']) . '" target="_blank" rel="noopener">' . esc_html($set['url']) . '</a></h3>';
			if (!empty($set['note'])) {
				echo '<p>' . esc_html($set['note']) . '</p>';
			}
			if (!onpage_dev_post_for($set['url']) && !in_array('new_post', wp_list_pluck($set['changes'], 'field'), true)) {
				echo '<p><strong>No post or page found for this URL.</strong> Only image alt texts can be written.</p>';
			}
			echo '<table class="widefat striped"><thead><tr><th style="width:2em"></th><th>Field</th><th>Now</th><th>New</th></tr></thead><tbody>';
			foreach ($set['changes'] as $i => $c) {
				$field = sanitize_key($c['field']);
				if ('post_content' === $field || 'new_post' === $field) {
					echo '<tr><td><input type="checkbox" name="pick[]" value="' . (int) $i . '" checked aria-label="Approve ' . esc_attr($field) . '"></td><td>' . esc_html('new_post' === $field ? 'New post' : 'Post text') . '</td><td>' . esc_html(onpage_dev_content_now($set, $field)) . '</td><td>' . onpage_dev_content_new($set, $c) . '</td></tr>';
					continue;
				}
				$new = 'jsonld' === $field ? wp_json_encode(json_decode((string) $c['value'], true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : onpage_dev_show($c['value']);
				echo '<tr><td><input type="checkbox" name="pick[]" value="' . (int) $i . '" checked aria-label="Approve ' . esc_attr($field) . '"></td><td>' . esc_html($field) . '</td><td>' . esc_html(onpage_dev_current($set, $field)) . '</td><td>' . ('jsonld' === $field ? '<details><summary>Show JSON-LD</summary><pre style="white-space:pre-wrap">' . esc_html($new) . '</pre></details>' : esc_html($new)) . '</td></tr>';
			}
			echo '</tbody></table><p><button class="button button-primary" name="approve" value="1">Approve selected</button> <button class="button" name="reject" value="1">Reject all</button></p></form>';
		}
	}
	$done = array();
	foreach (get_option('onpage_dev_history', array()) as $h) {
		if (empty($h['undone'])) {
			$done[$h['set']][] = $h;
		}
	}
	if ($done) {
		echo '<h2>Applied</h2><table class="widefat striped"><thead><tr><th>When</th><th>Page</th><th>Fields</th><th></th></tr></thead><tbody>';
		foreach (array_slice($done, 0, 30, true) as $set_id => $rows) {
			echo '<tr><td>' . esc_html(wp_date('Y-m-d H:i', $rows[0]['at'])) . '</td><td>' . esc_html(get_the_title($rows[0]['post'])) . '</td><td>' . esc_html(implode(', ', array_unique(wp_list_pluck($rows, 'field')))) . '</td><td><form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
			wp_nonce_field('onpage_dev');
			echo '<input type="hidden" name="action" value="onpage_dev"><input type="hidden" name="do" value="undo"><input type="hidden" name="set" value="' . esc_attr($set_id) . '"><button class="button">Undo</button></form></td></tr>';
		}
		echo '</tbody></table>';
	}
	echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '" style="margin-top:32px">';
	wp_nonce_field('onpage_dev');
	echo '<input type="hidden" name="action" value="onpage_dev"><input type="hidden" name="do" value="disconnect"><button class="button-link button-link-delete">Disconnect this site</button></form></div>';
}
