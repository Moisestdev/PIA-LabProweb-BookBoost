<?php
session_start();
include("conexion.php");

$id_genero = $_GET['id'] ?? 0;

// Obtener nombre del género
$genero_nombre = "Género desconocido";
$stmt = $conn->prepare("SELECT nombre_genero FROM genero WHERE id_genero = ?");
$stmt->bind_param("i", $id_genero);
$stmt->execute();
$res = $stmt->get_result();
if ($fila = $res->fetch_assoc()) {
    $genero_nombre = $fila['nombre_genero'];
}

// Obtener libros del género
$stmt = $conn->prepare("SELECT id_libro, nombre_libro, portada_url FROM libro WHERE id_genero = ?");
$stmt->bind_param("i", $id_genero);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Libros de género: <?php echo htmlspecialchars($genero_nombre); ?></title>
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

<main class="reseñas">
  <h2>Libros de género: "<?php echo htmlspecialchars($genero_nombre); ?>"</h2>
  <div class="cards">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($fila = $result->fetch_assoc()): ?>
        <div class="card">
          <div class="img-placeholder" style="background-image: url('<?php echo $fila['portada_url']; ?>'); background-size: cover; background-position: center; height: 200px;"></div>
          <h3><?php echo htmlspecialchars($fila['nombre_libro']); ?></h3>
          <a href="libro.php?id=<?php echo $fila['id_libro']; ?>"><button>Ver reseñas</button></a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No se encontraron libros para este género.</p>
    <?php endif; ?>
  </div>
</main>

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
</html>
