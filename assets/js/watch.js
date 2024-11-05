document.getElementById("likeBtn").addEventListener("click", function () {
  var likeCount = document.getElementById("likeCount");
  var dislikeCount = document.getElementById("dislikeCount");
  var likeBtn = document.getElementById("likeBtn");
  var dislikeBtn = document.getElementById("dislikeBtn");
  var liked = likeBtn.classList.contains("liked");
  var disliked = dislikeBtn.classList.contains("disliked");

  if (liked) {
    likeCount.textContent = parseInt(likeCount.textContent) - 1;
    likeBtn.classList.remove("liked");
  } else {
    likeCount.textContent = parseInt(likeCount.textContent) + 1;
    likeBtn.classList.add("liked");
    if (disliked) {
      dislikeCount.textContent = parseInt(dislikeCount.textContent) - 1;
      dislikeBtn.classList.remove("disliked");
    }
  }

  // Kirim permintaan AJAX untuk memperbarui like di server
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../videos/update_likes.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("video_id=" + video_id + "&action=" + (liked ? "unlike" : "like"));
});

document.getElementById("dislikeBtn").addEventListener("click", function () {
  var likeCount = document.getElementById("likeCount");
  var dislikeCount = document.getElementById("dislikeCount");
  var likeBtn = document.getElementById("likeBtn");
  var dislikeBtn = document.getElementById("dislikeBtn");
  var liked = likeBtn.classList.contains("liked");
  var disliked = dislikeBtn.classList.contains("disliked");

  if (disliked) {
    dislikeCount.textContent = parseInt(dislikeCount.textContent) - 1;
    dislikeBtn.classList.remove("disliked");
  } else {
    dislikeCount.textContent = parseInt(dislikeCount.textContent) + 1;
    dislikeBtn.classList.add("disliked");
    if (liked) {
      likeCount.textContent = parseInt(likeCount.textContent) - 1;
      likeBtn.classList.remove("liked");
    }
  }

  // Kirim permintaan AJAX untuk memperbarui dislike di server
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../videos/update_likes.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(
    "video_id=" + video_id + "&action=" + (disliked ? "undislike" : "dislike")
  );
});

document.getElementById("subscribeBtn").addEventListener("click", function () {
  var subscribeBtn = document.getElementById("subscribeBtn");
  var subscribed = subscribeBtn.classList.contains("subscribed");

  if (subscribed) {
    subscribeBtn.classList.remove("subscribed");
    subscribeBtn.textContent = "Subscribe";
  } else {
    subscribeBtn.classList.add("subscribed");
    subscribeBtn.textContent = "Subscribed";
  }

  // Kirim permintaan AJAX untuk memperbarui subscriber di server
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../videos/update_subscribe.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(
    "user_id=" +
      user_id +
      "&action=" +
      (subscribed ? "unsubscribe" : "subscribe")
  );
});
