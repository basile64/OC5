document.addEventListener("DOMContentLoaded", function () {
  const avatarInput = document.getElementById("avatarUser");
  const avatarPreview = document.getElementById("avatarPreview");

  avatarInput.addEventListener("change", function () {
    if (avatarInput.files && avatarInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        avatarPreview.src = e.target.result;
      };
      reader.readAsDataURL(avatarInput.files[0]);
    }
  });
});
