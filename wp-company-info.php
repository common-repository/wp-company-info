<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             0.0.1
 * @package           WP_Company_Info
 *
 * @wordpress-plugin
 * Plugin Name:       WP Company Info
 * Plugin URI:        https://wordpress.org/plugins/wp-company-info
 * Description:       Allows you to input information specific to the company/website such as a logo image, address, phone number and social network links.
 * Version:           1.9.0
 * Author:            Brianna Deleasa
 * Author URI:        http://briannadeleasa.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-company-info
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


// Define some constants
define( 'WP_CONTACT_INFO_PLUGIN_FILE', __FILE__ );
define( 'WP_CONTACT_INFO_OPTION_KEY', 'wpci_options' );


// Include our template tags and helper functions
require_once 'includes/template-tags.php';
require_once 'includes/functions.php';


add_action( 'init', 'wp_contact_info_init', 10 );
/**
 * Starts up our plugin.
 *
 * @param none
 * @return none
 *
 * @since 0.0.1
 */
function wp_contact_info_init() {

    require_once 'classes/class-wp-company-info-branding.php';
    WP_Company_Info_Branding::init();

    require_once 'classes/class-wp-company-info-contact-info.php';
    WP_Company_Info_Contact_Info::init();

    require_once 'classes/class-wp-company-info-social-links.php';
    WP_Company_Info_Social_Links::init();

    require_once 'classes/class-wp-company-info-generic-shortcodes.php';
    WP_Company_Info_Generic_Shortcodes::init();

}


add_filter( 'init', 'wp_contact_info_cmb2_init' );
/**
 * Load the CMB2 plugin
 *
 * @param none
 * @return none
 *
 * @since 0.0.1
 */
function wp_contact_info_cmb2_init() {

    // Include the main CMB script
    require_once 'includes/cmb2/init.php';

    // Include some custom fields
	if ( ! has_filter( 'cmb2_render_address' ) ) {
		require_once 'includes/cmb2-address-field/cmb2-address-field.php';
	}

}


add_action( 'widgets_init', 'wp_company_info_social_network_widget' );
/**
 * Register the Social Network widget.
 *
 * @param none
 * @return none
 *
 * @since 0.0.8
 */
function wp_company_info_social_network_widget() {

    require_once 'classes/class-wp-company-info-social-network-widget.php';
    register_widget( 'WPCI_Social_Network_Widget' );

    require_once 'classes/class-wp-company-info-logo-widget.php';
    register_widget( 'WPCI_Logo_Widget' );

}


add_action( 'init', 'wp_contact_info_instructions' );
/**
 * Enables integration with the WP Admin Instructions plugin to
 * add instructions on editing the company information.
 *
 * @param none
 * @return none
 *
 * @since 0.0.1
 */
function wp_contact_info_instructions() {

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    // Get out now if the plugin isn't active
    if ( ! is_plugin_active( 'wp-admin-instructions/wp-admin-instructions.php' ) ) {
        return;
    }

    require_once 'plugin-addons/wp-admin-instructions/class-wp-company-info-instructions.php';
    WP_Company_Info_Instructions::init();

}


add_action( 'init', 'wp_company_info_enable_shortcodes_in_text_widgets' );
/**
 * Adding a filter on the output of any text widget content so users
 * can use shortcodes within the content.
 *
 * @param none
 * @return none
 *
 * @since 0.0.8
 */
function wp_company_info_enable_shortcodes_in_text_widgets() {
    add_filter('widget_text', 'do_shortcode');
}