<?php
/**
 * DLN Branding
 *
 * Branding of Dream Lab Nine websites
 *
 * @package   DLN_Branding
 * @author    Kristoffer Tonning <tonning.public@gmail.com>
 * @license   GPL-2.0+
 * @link      http://dreamlabnine.com
 * @copyright 2014 Kristoffer Tonning
 *
 * @wordpress-plugin
 * Plugin Name:       DLN Branding
 * Plugin URI:        http://dreamlabnine.com
 * Description:       Branding of Dream Lab Nine websites
 * Version:           1.1.0
 * Author:            Kristoffer Tonning
 * Author URI:        http://kristoffertonning.com
 * Text Domain:       dln_branding
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: tonning/dln-branding
 * GitHub Branch: master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-dln_branding.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'DLN_Branding', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DLN_Branding', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'DLN_Branding', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-dln_branding-admin.php' );
	add_action( 'plugins_loaded', array( 'DLN_Branding_Admin', 'get_instance' ) );

}

// Global Variables
$home_url = 'http://dreamlabnine.com';
$assets_dir = $home_url . '/dln-branding';
$logo_dir = $assets_dir . '/images/logos';
$icon_dir = $assets_dir . '/images/icons';
$name = 'Dream Lab Nine';


// Change to custom logo
function login_logo() {
	global $logo_dir; ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo $logo_dir; ?>/login_logo.png);
            width: 319px !important;
            height: 66px !important;
            background-size: 319px 66px !important;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'login_logo' );


// Set logo link
function login_logo_url() {
	global $home_url;
    return $home_url;
}
add_filter( 'login_headerurl', 'login_logo_url' );


// Add title to the logo
function login_logo_url_title() {
	global $name;
    return 'Built by ' . $name;
}
add_filter( 'login_headertitle', 'login_logo_url_title' );


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


// Add link to support site
function admin_bar_support_link( $wp_admin_bar ) {
	$args = array(
		'id'    => 'Support',
		'title' => 'Need help? Click here for step-by-step tutorials.',
		'href'  => 'http://support.dreamlabnine.com',
		'meta'  => array( 'target' => '_blank' )
	);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'admin_bar_support_link', 1 );


// Remove WP logo from menu bar
function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
}
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );


// Set custom footer text
function change_footer_admin () {
	global $name, $home_url;
	return '<a href="' . $home_url . '">' . $name . '</a> © 2012-' . date('Y') . ' — All Rights Reserved.';
}
add_filter('admin_footer_text', 'change_footer_admin');


// Replace WordPress 'Howdy' with 'Hi'
function replace_howdy( $wp_admin_bar ) {
	$my_account=$wp_admin_bar->get_node('my-account');
	$new_title = str_replace( 'Howdy,', 'Hi,', $my_account->title );
	$wp_admin_bar->add_node( array(
		'id' => 'my-account',
		'title' => $new_title,
	) );
}
add_filter( 'admin_bar_menu', 'replace_howdy', 25 );


// First, create a function that includes the path to your favicon
function add_admin_favicon() {
	global $icon_dir, $home_url;
  	$favicon_url = $icon_dir . '/favicon.gif';
	echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}
  
// Now, just make sure that function runs when you're on the login page and admin pages  
add_action('login_head', 'add_admin_favicon');
add_action('admin_head', 'add_admin_favicon');
