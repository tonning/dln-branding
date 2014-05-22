<?php // Silence is golden

// Global Variables
$home_url = 'http://dreamlabnine.com';
$assets_dir = $home_url . '/dln-branding';
$logo_dir = $assets_dir . '/images/logos';
$icon_dir = $assets_dir . '/images/icons';
$name = 'Dream Lab Nine';


// Add custom logo to admin bar 
function add_to_admin_bar () {
	global $wp_admin_bar, $logo_dir;

	$title = '<img src="' . $logo_dir . '/admin_bar_logo.png' . '"/>';
	$link = 'http://dreamlabnine.com';

	$wp_admin_bar->add_menu(array(
		'id' => 'logo',
		'title' => $title,
		'href' => $link,
	));
}
add_action('admin_bar_menu', 'add_to_admin_bar', 1);

?>