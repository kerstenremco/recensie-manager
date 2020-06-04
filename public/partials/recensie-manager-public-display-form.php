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
global $recman_submitted, $recman_error;
if (!$recman_submitted) {
  // Not submitted, show form
  echo '<div>';
  if ($recman_error) {
    echo '<div id="recman-error" style="color: '.get_option('recman_form_text_color').';">';
    echo '<ul>';
    foreach ($recman_error as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '</div>';
  }
?>
  <form method="post" action="" id="recman_form">
    <input type="text" id="guestname" name="guestname" placeholder="<?php echo get_option('recman_form_name_text'); ?>" value="<?php echo $_POST['guestname']; ?>" />
    <textarea rows="8" id="review" name="review" placeholder="<?php echo get_option('recman_form_review_text'); ?>"><?php echo $_POST['review']; ?></textarea>
    <input type="text" id="title" name="title" placeholder="<?php echo get_option('recman_form_review_short'); ?>" value="<?php echo $_POST['title']; ?>" />
    <p class="desc" style="color: <?php echo get_option('recman_form_text_color'); ?>;"><?php echo get_option('recman_form_stars'); ?></p>
    <div class="rating-group">
      <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">
      <label aria-label="1 star" class="rating__label" for="rating3-1" style="font-size: <?php echo get_option('recman_form_stars_size'); ?>px;"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio" <?php if ($_POST['rating3'] == 1) echo 'checked'; ?>>
      <label aria-label="2 stars" class="rating__label" for="rating3-2" style="font-size: <?php echo get_option('recman_form_stars_size'); ?>px;"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio" <?php if ($_POST['rating3'] == 2) echo 'checked'; ?>>
      <label aria-label="3 stars" class="rating__label" for="rating3-3" style="font-size: <?php echo get_option('recman_form_stars_size'); ?>px;"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio" <?php if ($_POST['rating3'] == 3) echo 'checked'; ?>>
      <label aria-label="4 stars" class="rating__label" for="rating3-4" style="font-size: <?php echo get_option('recman_form_stars_size'); ?>px;"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio" <?php if ($_POST['rating3'] == 4) echo 'checked'; ?>>
      <label aria-label="5 stars" class="rating__label" for="rating3-5" style="font-size: <?php echo get_option('recman_form_stars_size'); ?>px;"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio" <?php if ($_POST['rating3'] == 5) echo 'checked'; ?>>
    </div><br />
    <input type="submit" name="recman_submit" style="<?php echo 'font-size: '.get_option('recman_form_text_size').'px; letter-spacing: '.get_option('recman_form_submit_text_letterspacing').'px; background-color: '.get_option('recman_form_submit_color').'; color: '.get_option('recman_form_submit_text_color').';'; ?>" value="<?php echo get_option('recman_form_submit_text'); ?>" />
  </form>
<?php

  echo '</div>';
} else {
  // Submitted, show thank you message
  echo '<p class="recmansubmitted" style="color: '.get_option('recman_form_text_color').';">'.get_option('recman_form_submitted_text').'</p>';
}
?>