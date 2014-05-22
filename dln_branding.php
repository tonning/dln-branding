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
 * Version:           0.0.2
 * Author:            Kristoffer Tonning
 * Author URI:        
 * Text Domain:       dln_branding
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: tonning/dln-branding
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
