<?php
/**
 * @file uninstall.php
 *
 * Actions to take when uninstalling this plugin
 */

// Make sure this file is only accessible when uninstalling
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

$option_name = 'wpci_options';

// Delete the option from our database.
delete_option( $option_name );

// For site options in multisite
delete_site_option( $option_name );