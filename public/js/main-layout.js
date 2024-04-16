window.onload = function () {
  var hamburger = document.querySelector(".hamburger");
  var menu = document.querySelector(".link-navbar");

  hamburger.addEventListener("click", function () {
    menu.classList.toggle("hidden");
  });
};
