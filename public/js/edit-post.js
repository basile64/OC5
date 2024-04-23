window.onload = function () {
  // Sélection des éléments du formulaire
  const titleInput = document.getElementById("input-title");
  const chapoInput = document.getElementById("textarea-chapo");
  const textInput = document.getElementById("textarea-text");
  const imageInput = document.getElementById("imgPost");
  const submitButton = document.getElementById("btn-edit-post");

  // Fonction pour vérifier si tous les champs sont remplis
  function checkForm() {
    const titleValue = titleInput.value.trim();
    const chapoValue = chapoInput.value.trim();
    const textValue = textInput.value.trim();

    // Si tous les champs sont remplis, activer le bouton de validation
    if (titleValue !== "" && chapoValue !== "" && textValue !== "") {
      submitButton.disabled = false;
    } else {
      // Sinon, désactiver le bouton de validation
      submitButton.disabled = true;
    }
  }

  var fileInput = document.getElementById("imgPost");

  // Ajout d'un écouteur d'événement pour l'événement change
  fileInput.addEventListener("change", function (event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function () {
      var dataURL = reader.result;
      var imagePreview = document.getElementById("imagePreview");
      imagePreview.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
  });

  // Écoute des événements de saisie sur chaque champ de formulaire
  titleInput.addEventListener("input", checkForm);
  chapoInput.addEventListener("input", checkForm);
  textInput.addEventListener("input", checkForm);
  imageInput.addEventListener("change", checkForm); // Utiliser l'événement 'change' pour le champ de l'image

  // Vérifier le formulaire lorsque la page est chargée
  checkForm();
};
