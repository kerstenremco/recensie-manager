<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/public
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
		if (!array_key_exists('recman_submit', $_POST)) return;
		global $post, $recman_submitted, $recman_error;
		$recman_error = array();

		// Check title
		if (strlen($_POST['title']) < 1) array_push($recman_error, get_option('recman_form_review_short'));
		// Check name
		if (strlen($_POST['guestname']) < 1) array_push($recman_error, get_option('recman_form_name_text'));
		// Check review
		if (strlen($_POST['review']) < 1) array_push($recman_error, get_option('recman_form_review_text'));
		// Check stars
		if (!$_POST['rating3']) array_push($recman_error, get_option('recman_form_stars'));

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
			$message = 'Er is een nieuwe recensie geplaatst door '.$post['meta_input']['name'].'. De recensie is te vinden in de recensie manager op je WordPress website.';
			wp_mail(get_option('admin_email'), 'Nieuwe recensie', $message);
			$recman_submitted = true;
		}
	}

	/**
	 * Inject sidebar
	 * Only if set in settings
	 *
	 * @since    1.0.0
	 */
	public function inject_me()
	{
		$postid = get_queried_object_id();
		$display_widget = get_post_meta($postid, 'recman_show_widget', true);
		if (get_option('recman_display') !== 'all' && !$display_widget) return;
		include_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/recensie-manager-public-display.php';
	}
}
