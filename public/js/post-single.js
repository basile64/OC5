window.onload = function () {
  var replyButtons = document.querySelectorAll(".reply-comment");

  replyButtons.forEach(function (replyButton) {
    replyButton.addEventListener("click", function () {
      var commentContainer = this.closest(".comment-container");
      var idComment = commentContainer.id;
      var form = document.querySelector(
        "#" + idComment + " .new-response-comment-container"
      );
      form.classList.toggle("hidden");
      replyButton.classList.toggle("active");
    });
  });
};
