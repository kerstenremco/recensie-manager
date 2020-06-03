<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 *
 * @package    Recensie_Manager
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$plugin_options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'recman_%'" );

foreach( $plugin_options as $option ) {
    delete_option( $option->option_name );
}