// Jsquery para el menu
$(document).ready(function() {
  const $abrirMenu = $("#abrirMenu");
  const $menu = $("#menuDesplegable");

  $abrirMenu.hover(
    function() {
      $menu.addClass("visible");
    }
  );

  $menu.mouseleave(function() {
    $menu.removeClass("visible");
  });
});