var review = 1;
function openNav() {
  document.getElementById("recmanWidget").style.width = "300px";
}

function closeNav() {
  document.getElementById("recmanWidget").style.width = "0";
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