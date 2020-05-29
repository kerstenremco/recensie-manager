<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Recensie_Manager
 * @subpackage Recensie_Manager/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
global $reviews_to_show;
$reviews_to_show = array();
$args = array(
  'posts_per_page' => -1,
  'post_type' => 'recman_review'
);
$reviews = get_posts($args);
foreach ($reviews as $review) {
  $show = get_post_meta($review->ID, 'visable', true);
  if ($show) array_push($reviews_to_show, $review);
}
?>
<div id="mySidenav" class="sidenav" style="width: 0px;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php
  global $reviews_to_show;
  $count = 1;
  $dont_show = '';
  foreach ($reviews_to_show as $review) {
    echo '<p class="' . $dont_show . '" id="recman-review-' . $count . '">' . $review->post_title . '</p>';
    $count++;
    $dont_show = 'hide-review';
  }
  ?>
  <div class="navbar">
    <a href="#" onClick="prevReview()">Vorige</a>
    <a href="#" onClick="nextReview()">Volgende</a>
  </div>
</div>

<!-- Use any element to open the sidenav -->
<a href="#" class="recman_float" onclick="openNav()">
  <p class="recman_my-float">Lees de recensies</p>
</a>

<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
<div id="main">
  ...
</div>