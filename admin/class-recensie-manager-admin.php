<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
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
 * @author     Your Name <email@example.com>
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
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->recensie_manager, plugin_dir_url(__FILE__) . 'css/recensie-manager-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->recensie_manager, plugin_dir_url(__FILE__) . 'js/recensie-manager-admin.js', array('jquery'), $this->version, false);
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
			// 'register_meta_box_cb'=>'example_metabox',
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
		add_meta_box('recman_metabox', 'Recensie details', array($this,'apply_meta_boxes_content'), 'recman_review', 'normal', 'high');
	}

	/**
	 * Apply metaboxes content
	 *
	 * @since    1.0.0
	 */
	public function apply_meta_boxes_content()
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
}
}
