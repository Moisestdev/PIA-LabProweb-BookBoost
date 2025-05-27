<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 1) {
    die("Acceso denegado.");
}
include("conexion.php");
$generos = $conn->query("SELECT id_genero, nombre_genero FROM genero");

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edición de libro</title>
  <link rel="stylesheet" href="CS.css" />
</head>
<body>

<header class="header">
    <div class="nav-container">
      <div class="logo"></div>
      <button id="abrirMenu"class="menu-btn">☰ Menú</button>
      <form method="GET" action="buscar.php" class="search-form">
  <input type="text" name="q" placeholder="Buscar libro..." class="search-bar">
</form>

      <a >Bienvenido, <?php echo $_SESSION['correo']; ?> 👋</a>
      <a href="Perfil.php">Perfil</a>
      <button class="add-btn">+</button>
    </div>
  </header>

  <main class="main-container">
    <h1>Creación de libro</h1>
    <form class="resena-form" method="POST" action="crearLibro.php">
      <div class="form-top">
        <div class="img-preview">
          <img id="previewImage" src="placeholder.png" alt="Imagen del libro" />
        </div>
    
        <div class="form-fields">
          <label for="titulo">Título de libro</label>
          <input type="text" name="titulo" id="titulo" required />
    
          <label for="genero">Género del libro</label>
<select name="genero" id="genero" required>
  <option value="">Selecciona un género</option>
  <?php while ($g = $generos->fetch_assoc()): ?>
    <option value="<?php echo $g['id_genero']; ?>">
      <?php echo htmlspecialchars($g['nombre_genero']); ?>
    </option>
  <?php endwhile; ?>
</select>

    
    
<label for="autor">Nombre del autor</label>
<input type="text" name="autor" id="autor" required />
    
          <label for="imagen_url">URL de la imagen</label>
          <input type="text" name="imagen_url" id="imagen_url" placeholder="https://..." required />
        </div>
      </div>
    
      <div class="btn-row right">
        <button type="submit">Crear libro</button>
        <button type="reset">Cancelar</button>
      </div>
    </form>
    
  </main>

  <input type="file" id="fileInput" accept="image/*" style="display: none;" />

<!-- Menú desplegable -->
<div id="menuDesplegable" class="menu-desplegable oculto">
    <div class="menu-content">
      <div class="menu-header">
        <div class="logo"></div>
        <form method="GET" action="buscar.php" class="search-form">
  <input type="text" name="q" placeholder="Buscar libro..." class="search-bar">
</form>

        <button id="cerrarMenu" class="close-btn">✕</button>
      </div>
  
      <div class="menu-columns">
      <div class="column">
  <h2>Géneros</h2>
  <ul>
<?php
$generos = $conn->query("SELECT id_genero, nombre_genero FROM genero");

while ($g = $generos->fetch_assoc()) {
  echo '<li><a href="genero.php?id=' . $g['id_genero'] . '">' . htmlspecialchars($g['nombre_genero']) . '</a></li>';
}
?>
</ul>

</div>
<?php if ($_SESSION['rol_usuario'] == 1): ?>
  <div class="admin-panel">
    <h2>Administrador</h2>
    <ul>
      <li><a href="CL.php">Publicación de libro</a></li>
      <li><a href="CRgenero.php">Edición de géneros de libro</a></li>
    </ul>
  </div>
<?php endif; ?>

        <div class="column">
          <h2>Sobre nosotros</h2>
          <ul>
          <li><a href="lobby.php">Inicio</a></li>
          <li><a href="sobre.php">Contacto</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<script src="menu.js"></script>
  <script src="CR.js"></script>
</body>
</html>