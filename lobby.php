<?php
session_start();

// Si el usuario no está autenticado, lo regresamos
if (!isset($_SESSION['id_usuario'])) {
    header("Location: IS.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página general</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <header class="header">
    <div class="nav-container">
      <div class="logo"></div>
      <button id="abrirMenu"class="menu-btn">☰ Menú</button>
      <input type="text" placeholder="Buscar" class="search-bar">
      <a >Bienvenido, <?php echo $_SESSION['correo']; ?> 👋</a>
      <a href="Perfil.php">Perfil</a>
      <button class="add-btn">+</button>
    </div>
  </header>

  <main>
    <section class="carousel">
      <div class="carousel-item destacado">
        <button class="arrow left">←</button>
        <div class="text">
          <h2>DESTACADOS</h2>
          <p>Descripción breve</p>
        </div>
      </div>

    </section>

    <section class="reseñas">
      <h2>Reseñas destacadas de libros</h2>
      <div class="cards">
        <div class="card"><div class="img-placeholder"></div><h3>Título</h3><button>Button</button></div>
        <div class="card"><div class="img-placeholder"></div><h3>Título</h3><button>Button</button></div>
        <div class="card"><div class="img-placeholder"></div><h3>Título</h3><button>Button</button></div>
        <div class="card"><div class="img-placeholder"></div><h3>Título</h3><button>Button</button></div>
        <div class="card"><div class="img-placeholder"></div><h3>Título</h3><button>Button</button></div>

<!-- Menú desplegable -->
<div id="menuDesplegable" class="menu-desplegable oculto">
    <div class="menu-content">
      <div class="menu-header">
        <div class="logo"></div>
        <input type="text" placeholder="Buscar" class="search-bar">
        <button id="cerrarMenu" class="close-btn">✕</button>
      </div>
  
      <div class="menu-columns">
        <div class="column">
          <h2><img src="icon.png" alt="" class="icono"> Géneros</h2>
          <ul>
            <li>Suspenso y misterio</li>
            <li>Romance</li>
            <li>Ciencia ficción</li>
            <li>Divulgación científica</li>
            <li>Leyenda y aventura</li>
          </ul>
        </div>
        <div class="column">
          <h2><img src="icon.png" alt="" class="icono"> Sobre nosotros</h2>
          <ul>
            <li>Contacto</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="menu.js"></script>

</body>