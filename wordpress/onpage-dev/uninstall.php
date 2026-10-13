<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}
$onpage_dev_id = get_option('onpage_dev_site_id');
if ($onpage_dev_id) {
	wp_remote_request(apply_filters('onpage_dev_api_base', 'https://onpage.dev') . '/wp/v1/site', array('method' => 'DELETE', 'timeout' => 10, 'headers' => array('Authorization' => 'Bearer ' . $onpage_dev_id . '.' . get_option('onpage_dev_secret'))));
}
foreach (array('onpage_dev_site_id', 'onpage_dev_secret', 'onpage_dev_site_key', 'onpage_dev_history') as $onpage_dev_option) {
	delete_option($onpage_dev_option);
}
