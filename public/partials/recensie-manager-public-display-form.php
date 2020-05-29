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
global $recman_submitted, $recman_error;
if (!$recman_submitted) {
  echo '<div>';
  if ($recman_error) {
    echo '<div>';
    echo '<ul>';
    foreach ($recman_error as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    echo '</div>';
  }
?>
  <form method="post" action="" id="recman_form">
    <input type="text" id="guestname" name="guestname" placeholder="Wat is uw achternaam?" value="<?php echo $_POST['guestname']; ?>" />
    <textarea rows="8" id="review" name="review" placeholder="Wat vond u van uw verblijf bij ons?"><?php echo $_POST['review']; ?></textarea>
    <input type="text" id="title" name="title" placeholder="Kunt u uw verblijf in maximaal 5 woorden omschrijven?" value="<?php echo $_POST['title']; ?>" />
    <p class="desc">Hoeveel sterren geeft u uw verblijf?</p>
    <div class="rating-group">
      <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">
      <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio" <?php if ($_POST['rating3'] == 1) echo 'checked'; ?>>
      <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio" <?php if ($_POST['rating3'] == 2) echo 'checked'; ?>>
      <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio" <?php if ($_POST['rating3'] == 3) echo 'checked'; ?>>
      <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio" <?php if ($_POST['rating3'] == 4) echo 'checked'; ?>>
      <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
      <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio" <?php if ($_POST['rating3'] == 5) echo 'checked'; ?>>
    </div><br />
    <input type="submit" name="recman_submit" value="Versturen" />
  </form>

<?php
  echo '</div>';
} else {
?>
  <p class="recmansubmitted">Uw review is ontvangen! Bedankt en tot snel!</p>
<?php
}
?>