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
 * @author     Your Name <email@example.com>
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
		$options = array(
			'recman_display'=>'all',
			'recman_nav_color'=>'#ff6781',
			'recman_nav_text_color'=>'#ffffff',
			'recman_button_text'=>'Lees recensies',
			'recman_button_icon'=>'star',
			'recman_button_color'=>'#cd2653',
			'recman_button_text_color'=>'#ffffff',
			'recman_button_text_size'=>'14',
			'recman_widget_title_size'=>'20',
			'recman_widget_title_letterspacing'=>'0',
			'recman_widget_title_color'=>'#000000',
			'recman_widget_body_size'=>'16',
			'recman_widget_body_color'=>'#818181',
			'recman_widget_name_size'=>'14',
			'recman_widget_name_color'=>'#818181',
			'recman_widget_stars_size'=>'14',
			'recman_widget_stars_color'=>'#F0AB00',
			'recman_form_name_text'=>'Wat is uw achternaam?',
			'recman_form_review_text'=>'Wat vond u van uw verblijf bij ons?',
			'recman_form_review_short'=>'Kunt u uw verblijf in één zin omschrijven?',
			'recman_form_stars'=>'Hoeveel sterren geeft u uw verblijf?',
			'recman_form_stars_color'=>'#F0AB00',
			'recman_form_stars_size'=>'34',
			'recman_form_submit_text'=>'VERSTUREN',
			'recman_form_text_size'=>'20',
			'recman_form_submit_text_letterspacing'=>'1',
			'recman_form_submit_color'=>'#cd2653',
			'recman_form_submitted_text'=>'Hartelijk bedankt voor uw review, en graag tot snel!'
		);
		foreach($options as $key=>$option) {
			if(!get_option($key)) add_option($key, $option);
		}
	}

}
