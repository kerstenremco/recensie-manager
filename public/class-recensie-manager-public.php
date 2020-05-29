<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/public
 * @author     Your Name <email@example.com>
 */
class Recensie_Manager_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $recensie_manager    The ID of this plugin.
	 */
	private $recensie_manager;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $recensie_manager       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($recensie_manager, $version)
	{

		$this->recensie_manager = $recensie_manager;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Recensie_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Recensie_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->recensie_manager, plugin_dir_url(__FILE__) . 'css/recensie-manager-public.css', array(), $this->version, 'all');
		wp_enqueue_style('load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Recensie_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Recensie_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->recensie_manager, plugin_dir_url(__FILE__) . 'js/recensie-manager-public.js', array('jquery'), $this->version, false);
	}

	/**
	 * Register shortcode for form
	 *
	 * @since    1.0.0
	 */
	public function register_shortcode_form()
	{
		add_shortcode('recman_form', array($this, 'load_form'));
	}

	/**
	 * Load form template
	 *
	 * @since    1.0.0
	 */
	public function load_form()
	{
		ob_start();
		include_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/recensie-manager-public-display-form.php';
		return ob_get_clean();
	}

	/**
	 * Capture form input
	 *
	 * @since    1.0.0
	 */
	function capture_form()
	{
		global $post, $recman_submitted, $recman_error;
		$recman_error = array();
		if (array_key_exists('recman_submit', $_POST)) {
			// Controleer titel
			if (strlen($_POST['title']) > 0) {
				if (strlen($_POST['title']) > 50) {
					array_push($recman_error, 'Probeer de omschrijving van je verblijf iets korter te maken');
				}
			} else {
				array_push($recman_error, 'Kunt u uw verblijf in maximaal 5 woorden omschrijven?');
			}
			// Controleer naam
			if (strlen($_POST['guestname']) > 0) {
				if (strlen($_POST['guestname']) > 50) {
					array_push($recman_error, 'Uw achternaam mag uit maximaal 50 karakters bestaan');
				}
			} else {
				array_push($recman_error, 'Wat is uw achternaam?');
			}
			// Controleer recensie
			if (strlen($_POST['review']) > 0) {
				if (strlen($_POST['review']) > 1000) {
					array_push($recman_error, 'Uw review is iets te lang');
				}
			} else {
				array_push($recman_error, 'Wat vond u van uw verblijf?');
			}
			// Controleer sterren
			if ($_POST['rating3'] < 1 || $_POST['rating3'] > 5) {
				array_push($recman_error, 'Hoeveel sterren geeft u uw verblijf bij ons?');
			}

			if ($recman_error == null) {
				$post = array(
					'post_title' => wp_strip_all_tags($_POST['title']),
					'post_type' => 'recman_review',
					'post_status' => 'pending',
					'meta_input' => array(
						'name' => wp_strip_all_tags($_POST['guestname']),
						'review' => wp_strip_all_tags($_POST['review']),
						'stars' => wp_strip_all_tags($_POST['rating3'])
					)
				);
				wp_insert_post($post);
				$recman_submitted = true;
			}
		}
	}

		/**
	 * Register shortcode for sidebar
	 *
	 * @since    1.0.0
	 */
	public function register_shortcode_sidebar()
	{
		add_shortcode('recman_sidebar', array($this, 'load_sidebar'));
	}

	/**
	 * Load sidebar template
	 *
	 * @since    1.0.0
	 */
	public function load_sidebar()
	{
		ob_start();
		include_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/recensie-manager-public-display.php';
		return ob_get_clean();
	}
}
