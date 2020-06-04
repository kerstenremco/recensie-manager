<?php

/**
 * The plugin bootstrap file
 *
 *
 * @since             1.0.0
 * @package           Recensie_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Recensie Manager
 * Plugin URI:        http://remcokersten.nl/wordpress/recensie-manager/
 * Description:       Ontvang, beheer, bewerk en weergeef recensies van uw accomodatie
 * Version:           1.1.0
 * Author:            Remco Kersten
 * Author URI:        http://remcokersten.nl
 * Text Domain:       recensie-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'RECENSIE_MANAGER_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_recensie_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-recensie-manager-activator.php';
	Recensie_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_recensie_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-recensie-manager-deactivator.php';
	Recensie_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_recensie_manager' );
register_deactivation_hook( __FILE__, 'deactivate_recensie_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-recensie-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_recensie_manager() {

	$plugin = new Recensie_Manager();
	$plugin->run();

}
run_recensie_manager();
