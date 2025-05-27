<?php
session_start();

// Si el usuario no está autenticado, lo regresamos
if (!isset($_SESSION['id_usuario'])) {
    header("Location: IS.html");
    exit();
}  
include("conexion.php");

$sql = "SELECT l.id_libro, l.nombre_libro, l.portada_url 
        FROM libro l
        JOIN reseña r ON r.id_libro = l.id_libro
        GROUP BY l.id_libro
        ORDER BY COUNT(r.id_reseña) DESC
        LIMIT 5";

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
    <button id="abrirMenu" class="menu-btn">☰ Menú</button>
    <form method="GET" action="buscar.php" class="search-form" style="display: flex; gap: 5px;">
  <select name="filtro" class="filtro-selector">
    <option value="todos">Todos</option>
    <option value="genero">Género</option>
    <option value="autor">Autor</option>
  </select>
  <input type="text" name="q" placeholder="Buscar libro..." class="search-bar">
  <button type="submit">Buscar</button>
</form>

    <a>Bienvenido, <?php echo $_SESSION['correo']; ?> 👋</a>
    <a href="Perfil.php">Perfil</a>
    <button class="add-btn">+</button>
  </div>
</header>

  <main>
    <?php
// Ejecutamos de nuevo para obtener el primer libro destacado (si no lo quieres repetir, almacénalo antes)
$resultado = $conn->query($sql);
$destacado = $resultado->fetch_assoc();
?>
<section class="carousel">
  <div class="carousel-item destacado" style="position: relative; background-image: url('<?php echo $destacado['portada_url']; ?>'); background-size: cover; background-position: center; height: 400px; color: white;">
    <div class="text" style="position: absolute; bottom: 20px; left: 20px; background: rgba(0,0,0,0.5); padding: 10px;">
      <h2>📘 Libro destacado</h2>
      <h3><?php echo htmlspecialchars($destacado['nombre_libro']); ?></h3>
      <a href="libro.php?id=<?php echo $destacado['id_libro']; ?>">
        <button style="margin-top: 10px;">Ver reseñas</button>
      </a>
    </div>
  </div>
</section>


    <section class="reseñas">
      <h2>Reseñas destacadas de libros</h2>
      <div class="cards">
  <?php


  $resultado = $conn->query($sql);

  while ($fila = $resultado->fetch_assoc()):
  ?>
    <div class="card">
      <div class="img-placeholder" style="background-image: url('<?php echo $fila['portada_url']; ?>'); background-size: cover; background-position: center; height:300px;"></div>
      <h3><?php echo $fila['nombre_libro']; ?></h3>
      <a href="libro.php?id=<?php echo $fila['id_libro']; ?>">
  <button>Ver reseñas</button>
</a>

    </div>
  <?php endwhile; ?>
</div>


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
          <li><a href="eliminarlibro.php">Administrar libros</a></li>
          <li><a href="Graficos.php">Estadisticas</a></li>
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

</body>