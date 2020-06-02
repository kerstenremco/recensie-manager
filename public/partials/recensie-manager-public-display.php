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

<div id="mySidenav" class="sidenav" style="width: 0px;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="color: <?php echo get_option('recman_button_color'); ?>">&times;</a>
  <?php
  // Load all reviews in divs for frontend
  global $reviews_to_show;
  $count = 1;
  $dont_show = '';
  foreach ($reviews_to_show as $review) {
    echo '<div class="sidebar-content '.$dont_show.'" id="recman-review-'.$count.'">';
    echo '<h3>' . $review->post_title . '</h3>';
    echo '<p>'.get_post_meta($review->ID, 'review', true).'</p>';
    $stars = get_post_meta($review->ID, 'stars', true);
    for($i=0; $i < $stars; $i++) echo '<i class="rating__icon rating__icon--star fa fa-star"></i>';
    echo '<br />';
    echo '<p class="sidebar-content-name">'.get_post_meta($review->ID, 'name', true).'</p>';
    echo '</div>';
    $count++;
    $dont_show = 'hide-review';
  }
  ?>
  
  <div class="navbar">
    <a href="#" onClick="prevReview()" style="background-color: <?php echo get_option('recman_nav_color'); ?>">Vorige</a>
    <a href="#" onClick="nextReview()" style="background-color: <?php echo get_option('recman_nav_color'); ?>">Volgende</a>
  </div>
</div>

<!-- Use any element to open the sidenav -->
<a href="#" class="recman_float" onclick="openNav()" style="background-color: <?php echo get_option('recman_button_color'); ?>">
  <p class="recman_my-float"><?php echo get_option('recman_button_text'); ?></p>
</a>

<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page 
<div id="main">
  ...
</div>
-->