document.addEventListener("DOMContentLoaded", () => {
  const abrirMenu = document.getElementById("abrirMenu");
  const cerrarMenu = document.getElementById("cerrarMenu");
  const menu = document.getElementById("menuDesplegable");

  abrirMenu.addEventListener("click", () => {
    menu.classList.add("visible");
  });

  cerrarMenu.addEventListener("click", () => {
    menu.classList.remove("visible");
  });
});
