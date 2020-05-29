(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

var review = 1;
/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "400px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function nextReview() {
  var currentReview = document.getElementById(`recman-review-${review}`);
  var next = document.getElementById(`recman-review-${review+1}`);
  if(next == null) return;
  currentReview.classList.add("hide-review");  
  next.classList.remove("hide-review");
  review++;
}

function prevReview() {
  var currentReview = document.getElementById(`recman-review-${review}`);
  var prev = document.getElementById(`recman-review-${review-1}`);
  if(prev == null) return;
  currentReview.classList.add("hide-review");  
  prev.classList.remove("hide-review");
  review--;
}