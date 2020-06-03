<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/includes
 */
class Recensie_Manager_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Create options of not exist
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-recensie-manager-admin.php';
		$options = Recensie_Manager_Admin::$options;
		foreach($options as $key=>$option) {
			if(!get_option($key)) add_option($key, $option[4]);
		}
	}

}
