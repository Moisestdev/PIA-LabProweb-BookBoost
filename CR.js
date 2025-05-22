document.addEventListener("DOMContentLoaded", function () {
  const fileInput = document.getElementById("fileInput");
  const addImageBtn = document.getElementById("addImageBtn");
  const removeImageBtn = document.getElementById("removeImageBtn");
  const previewImage = document.getElementById("previewImage");

  // Imagen por defecto (ajústalo si tu placeholder es diferente)
  const defaultImage = "placeholder.png";

  // Clic en "Añadir imagen del libro"
  addImageBtn.addEventListener("click", () => {
    fileInput.click();
  });

  // Al seleccionar un archivo
  fileInput.addEventListener("change", (event) => {
    const file = event.target.files[0];
    if (file && file.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImage.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      alert("Por favor selecciona una imagen válida.");
    }
  });

  // Clic en "Eliminar imagen del libro"
  removeImageBtn.addEventListener("click", () => {
    fileInput.value = "";
    previewImage.src = defaultImage;
  });
});
