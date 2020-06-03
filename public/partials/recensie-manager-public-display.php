<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
// Load reviews
global $reviews_to_show;
$reviews_to_show = array();
$args = array(
  'posts_per_page' => -1,
  'post_type' => 'recman_review'
);
$reviews = get_posts($args);
// If review is checked to show on site, add to $reviews_to_show
foreach ($reviews as $review) {
  $show = get_post_meta($review->ID, 'visable', true);
  if ($show) array_push($reviews_to_show, $review);
}
?>

<div id="recmanWidget" class="recmanWidget" style="width: 0px;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="color: <?php echo get_option('recman_button_color'); ?>">&times;</a>
  <?php
  // Load all reviews in divs for frontend
  global $reviews_to_show;
  $count = 1;
  $dont_show = '';
  foreach ($reviews_to_show as $review) {
    echo '<div class="recmanWidget-content '.$dont_show.'" id="recman-review-'.$count.'">';
    echo '<h3 style="font-size: '.get_option('recman_widget_title_size').'px; letter-spacing: '.get_option('recman_widget_title_letterspacing').'px; color: '.get_option('recman_widget_title_color').'">' . $review->post_title . '</h3>';
    echo '<p style="font-size: '.get_option('recman_widget_body_size').'px; color: '.get_option('recman_widget_body_color').'">'.get_post_meta($review->ID, 'review', true).'</p>';
    $stars = get_post_meta($review->ID, 'stars', true);
    for($i=0; $i < $stars; $i++) echo '<i class="rating__icon rating__icon--star fa fa-star" style="font-size: '.get_option('recman_widget_stars_size').'px; color: '.get_option('recman_widget_stars_color').';"></i>';
    echo '<br />';
    echo '<p class="sidebar-content-name" style="font-size: '.get_option('recman_widget_name_size').'px; color: '.get_option('recman_widget_name_color').'">'.get_post_meta($review->ID, 'name', true).'</p>';
    echo '</div>';
    $count++;
    $dont_show = 'hide-review';
  }
  ?>
  
  <div class="recmanWidget-navbar">
    <a href="#" class="recmanWidget-navbar-link" onClick="prevReview()" style="<?php echo 'background-color: '.get_option('recman_nav_color').'; color: '.get_option('recman_nav_text_color').';'; ?>">Vorige</a>
    <a href="#" class="recmanWidget-navbar-link" onClick="nextReview()" style="<?php echo 'background-color: '.get_option('recman_nav_color').'; color: '.get_option('recman_nav_text_color').';'; ?>">Volgende</a>
  </div>
</div>

<!-- Use any element to open the sidenav -->
<a href="#" class="recman_float" onclick="openNav()" style="<?php $fontsize = get_option('recman_button_text_size'); echo 'background-color: '.get_option('recman_button_color').'; padding-top: '.$fontsize.'px; padding-bottom: '.$fontsize.'px; font-size: '.$fontsize.'px; color: '.get_option('recman_button_text_color').';'; ?>">
  <i class="fa <?php echo get_option('recman_button_icon'); ?>"></i><span><?php echo get_option('recman_button_text'); ?></span>
</a>