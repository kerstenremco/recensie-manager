var review = 1;
/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
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