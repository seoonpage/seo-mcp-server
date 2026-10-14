<?php
require_once '/wordpress/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/template.php';
wp_set_current_user(1);
update_option('onpage_dev_site_key', 'wpk_' . str_repeat('a', 40));
$id = wp_insert_post(array('post_title' => 'Compost', 'post_content' => '<p>Keep this.</p><p>Drop this.</p>', 'post_status' => 'publish'));
$sets = array(
	array('id' => '00000000-0000-4000-8000-00000000000a', 'url' => get_permalink($id), 'note' => 'Refresh for "compost bin"', 'changes' => array(array('field' => 'post_content', 'value' => '<p>Keep this.</p><p>Add this.</p>'))),
	array('id' => '00000000-0000-4000-8000-00000000000b', 'url' => home_url('/'), 'note' => 'New post', 'changes' => array(array('field' => 'new_post', 'value' => array('title' => 'Raised bed soil', 'content' => '<p>Hello there.</p>', 'type' => 'post')))),
);
add_filter('pre_http_request', function () use ($sets) {
	return array('headers' => array(), 'body' => wp_json_encode(array('changes' => $sets)), 'response' => array('code' => 200, 'message' => 'OK'), 'cookies' => array(), 'filename' => null);
});
$errors = array();
set_error_handler(function ($no, $str, $file, $line) use (&$errors) {
	$errors[] = "$str ($file:$line)";
	return true;
});
ob_start();
onpage_dev_page();
$html = ob_get_clean();
restore_error_handler();
file_put_contents('/out/page.html', '<!doctype html><meta charset="utf-8"><body style="font:14px sans-serif;max-width:1100px;margin:20px">' . $html);
file_put_contents('/out/page-errors.json', wp_json_encode($errors));
