<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/admin
 */
class Recensie_Manager_Admin
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

	private $options = array(
		'recman_display' => array('Laat widget zien op', 'radio', array(
			'Alleen op specifieke pagina\'s' => 'shortcode',
			'Op alle pagina\'s' => 'all'
		), null),
		'recman_nav_color' => array('(Navigatieknoppen widget) Kleur', 'text', null, 'sanitize_option_color'),
		'recman_nav_text_color' => array('(Navigatieknoppen widget) Tekstkleur', 'text', null, 'sanitize_option_color'),
		'recman_button_text' => array('(floating button) Tekst', 'text', null, null),
		'recman_button_icon' => array('(floating button) Icoon', 'text', null, null),
		'recman_button_color' => array('(floating button) Kleur', 'text', null, 'sanitize_option_color'),
		'recman_button_text_color' => array('(floating button) tekstkleur', 'text', null, 'sanitize_option_color'),
		'recman_button_text_size' => array('(floating button) Tekstgrootte button', 'text', null, 'sanitize_option_fontsize'),
		'recman_widget_title_size' => array('(widget) Tekstgrootte reviewtitel', 'text', null, 'sanitize_option_fontsize'),
		'recman_widget_title_letterspacing' => array('(widget) Letterspacing reviewtitel', 'text', null, 'sanitize_option_fontsize'),
		'recman_widget_title_color' => array('(widget) Tekstkleur reviewtitel', 'text', null, 'sanitize_option_color'),
		'recman_widget_body_size' => array('(widget) Tekstgrootte review', 'text', null, 'sanitize_option_fontsize'),
		'recman_widget_body_color' => array('(widget) Tekstkleur review', 'text', null, 'sanitize_option_color'),
		'recman_widget_name_size' => array('(widget) Tekstgrootte naam', 'text', null, 'sanitize_option_fontsize'),
		'recman_widget_name_color' => array('(widget) Tekstkleur naam', 'text', null, 'sanitize_option_color'),
		'recman_widget_stars_size' => array('(widget) Grootte in px sterren', 'text', null, 'sanitize_option_fontsize'),
		'recman_widget_stars_color' => array('(widget) Kleur sterren', 'text', null, 'sanitize_option_color'),
		'recman_form_name_text' => array('(formulier) Tekst naam', 'text', null, null),
		'recman_form_review_text' => array('(formulier) Tekst review', 'text', null, null),
		'recman_form_review_short' => array('(formulier) Tekst review in één zin', 'text', null, null),
		'recman_form_stars' => array('(formulier) Tekst sterren', 'text', null, null),
		'recman_form_stars_color' => array('(formulier) Kleur sterren', 'text', null, 'sanitize_option_color'),
		'recman_form_stars_size' => array('(formulier) Grootte in px sterren', 'text', null, 'sanitize_option_fontsize'),
		'recman_form_submit_text' => array('(formulier) Tekst button', 'text', null, null),
		'recman_form_text_size' => array('(formulier) Tekstgrootte button', 'text', null, 'sanitize_option_fontsize'),
		'recman_form_submit_text_letterspacing' => array('(formulier) letterspacing button', 'text', null, 'sanitize_option_fontsize'),
		'recman_form_submit_color' => array('(formulier) Kleur button', 'text', null, 'sanitize_option_color'),
		'recman_form_submitted_text' => array('(formulier) Tekst na inzenden formulier', 'text', null, null)
	);

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $recensie_manager       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($recensie_manager, $version)
	{

		$this->recensie_manager = $recensie_manager;
		$this->version = $version;
	}

	/**
	 * Register post type for review
	 *
	 * @since    1.0.0
	 */
	public function register_post_type()
	{
		register_post_type('recman_review', array(
			'labels' => array(
				'name' => __('Recensies'),
				'signular_name' => __('Recensie'),
				'add_new' => __('Voeg recensie toe'),
				'add_new_item' => __('Voeg recensie toe'),
				'edit_item' => __('Bewerk recensie')
			),
			'public' => true,
			'exclude_from_search' => true,
			'has_archive' => false,
			'supports' => array('title'),
			'rewrite' => array('slug' => 'recensie')
		));
	}

	/**
	 * Apply filter for custom review post type title
	 *
	 * @since    1.0.0
	 */
	public function filter_title($title)
	{
		$screen = get_current_screen();
		if ($screen->post_type == "recman_review") {
			$title = "Beknopte samenvatting review (max 100 letters)";
		}
		return $title;
	}

	/**
	 * Apply metaboxes on custom post type
	 *
	 * @since    1.0.0
	 */
	public function apply_meta_boxes()
	{
		add_meta_box('recman_metabox', 'Recensie details', array($this, 'apply_metabox_content'), 'recman_review', 'normal', 'high');
		add_meta_box('recman_metabox_widget', 'Recensie manager', array($this, 'apply_metabox_content_widget'), 'page', 'side', 'low');
	}

	/**
	 * Apply metaboxes content
	 *
	 * @since    1.0.0
	 */
	public function apply_metabox_content()
	{
		global $post;
		$name = get_post_meta($post->ID, 'name', true);
		$review = get_post_meta($post->ID, 'review', true);
		$stars = get_post_meta($post->ID, 'stars', true);
		$visable = get_post_meta($post->ID, 'visable', true) == true ? 'checked' : '';
?>
		<label for="name">Naam</label>
		<input type="text" name="name" placeholder="Naam gast" class="widefat" value="<?php echo $name; ?>" />
		<label for="review">Recensie</label>
		<textarea name="review" class="widefat" placeholder="Recensie" rows="8"><?php echo $review; ?></textarea>
		<label for="stars">Aantal sterren</label>
		<input type="number" id="stars" name="stars" min="1" max="5" placeholder="5" value="<?php echo $stars; ?>">
		<br />
		<input type="checkbox" id="visable" name="visable" <?php echo $visable; ?>> Zichtbaar op website
<?php
	}

	/**
	 * Apply metaboxes content
	 *
	 * @since    1.0.0
	 */
	public function apply_metabox_content_widget($post)
	{
		if (get_option('recman_display') === 'all') echo '<i>De recensie-widget wordt momenteel op alle pagina\'s getoond. Deze instelling kan worden aangepast onder instellingen';
		else {
			$checked = get_post_meta($post->ID, 'recman_show_widget', true) ? 'checked=checked' : '';
			echo '<input type="checkbox" name="recman_show_widget" value="1" ' . $checked . '> Laat recensie widget zien op deze pagina';
		}
	}

	/**
	 * Save metadate on post
	 *
	 * @since    1.0.0
	 */
	function metadata_save($post_id)
	{
		$is_autosave = wp_is_post_autosave($post_id);
		$is_revision = wp_is_post_revision($post_id);
		if ($is_autosave || $is_revision) return;
		$post = get_post($post_id);

		if ($post->post_type == "recman_review") {
			if (array_key_exists('name', $_POST)) {
				update_post_meta($post_id, 'name', $_POST['name']);
			}
			if (array_key_exists('review', $_POST)) {
				update_post_meta($post_id, 'review', $_POST['review']);
			}
			if (array_key_exists('stars', $_POST)) {
				update_post_meta($post_id, 'stars', $_POST['stars']);
			}
			$visable = array_key_exists('visable', $_POST);
			update_post_meta($post_id, 'visable', $visable);
		}

		if ($post->post_type == "page") {
			if (array_key_exists('recman_show_widget', $_POST)) {
				update_post_meta($post_id, 'recman_show_widget', true);
			} else {
				update_post_meta($post_id, 'recman_show_widget', false);
			}
		}
	}

	/**
	 * Register settings page
	 *
	 * @since    1.0.0
	 */
	function register_options_page()
	{
		// Register options
		foreach($this->options as $key=>$option) {
			$args = array();
			if($option[3]) $args['sanitize_callback'] = array($this, $option[3]);
			register_setting('general', $key, $args);
		}
		// Add settings field
		add_settings_section('recman_options', 'Recensie Manager', array($this, 'show_options_page_subheading'), 'general');
		foreach($this->options as $key=>$option) {
			add_settings_field($key, $option[0], array($this, 'get_optionfield_display'), 'general', 'recman_options', array($key, $option));
		}
	}

	/**
	 * Render settings page
	 *
	 * @since    1.0.0
	 */
	function show_options_page_subheading()
	{
		echo '<i>Bij problemen met de recensie manager, neem contact op met Remco Kersten</i>';
	}

	function get_optionfield_display($option)
	{
		// Options. Set by activation!
		// Option name => array('Name for admin panel', 'type input', array(options) 'Sanitazion filter')
			$option_value = get_option($option[0]);
			switch ($option[1][1]) {
				case 'text':
					echo '<input name="' . $option[0] . '" type="text" value="' . $option_value . '" class="regular-text">';
					break;
				case 'radio':
					foreach ($option[1][2] as $detail => $value) {
						$checked = $option_value === $value ? 'checked="checked"' : '';
						echo '<input type="radio" name="' . $option[0] . '" value="' . $value . '" class="tog" '.$checked.'>' . $detail . '<br />';
					}
					break;
				default:
					echo '<p>Error: Unknown optiontype</p>';
			}
	}

	function sanitize_option_color($input)
	{
		// Remove # if in input
		global $option;
		if (!is_numeric($input[0])) $input = substr($input, 1);
		if (strlen($input) !== 6) {
			$input = get_option($option);
			add_settings_error($option, '1', 'Recensie Manager: Geen geldige kleur ingevoerd voor optie <i>'.$this->options[$option][0].'</i>. Voer een kleurcode als volgt in: #123456');
		} else {
			$input = '#' . $input;
		}
		return $input;
	}

	function sanitize_option_fontsize($input)
	{
		global $option;
		if (!is_numeric($input)) {
			$input = get_option($option);
			add_settings_error($option, '1', 'Recensie Manager: Geen geldige fontsize ingevoerd voor optie <i>'.$this->options[$option][0].'</i>. Voer een fontsize als volgt in: 18px');
		}
		return $input;
	}
	//sanitize_option_fontsize

	/**
	 * Handle save input
	 *
	 * @since    1.0.0
	 */
	function handle_options_post()
	{
		if (!array_key_exists('recman_options_submit', $_POST)) return;
	}
}
