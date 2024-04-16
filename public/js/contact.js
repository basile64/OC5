window.onload = function () {
  /////
  var hamburger = document.querySelector(".hamburger");
  var menu = document.querySelector(".link-navbar");

  hamburger.addEventListener("click", function () {
    menu.classList.toggle("hidden");
  });

  //////
  const firstNameInput = document.querySelector('input[name="userFirstName"]');
  const lastNameInput = document.querySelector('input[name="userLastName"]');
  const emailInput = document.querySelector('input[name="userEmail"]');
  const messageInput = document.querySelector('textarea[name="userMessage"]');
  const submitButton = document.getElementById("btn-login-user");

  function checkForm() {
    if (
      firstNameInput.value.trim() !== "" &&
      lastNameInput.value.trim() !== "" &&
      emailInput.value.trim() !== "" &&
      messageInput.value.trim() !== ""
    ) {
      submitButton.disabled = false;
    } else {
      submitButton.disabled = true;
    }
  }

  firstNameInput.addEventListener("input", checkForm);
  lastNameInput.addEventListener("input", checkForm);
  emailInput.addEventListener("input", checkForm);
  messageInput.addEventListener("input", checkForm);

  checkForm();
};
