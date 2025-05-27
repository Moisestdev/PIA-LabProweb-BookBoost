<?php
session_start();
include("conexion.php");

// Verificar que el usuario sea administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 1) {
    die("Acceso denegado.");
}

// Si viene solicitud para eliminar un libro
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);

    // Eliminar el libro de la base de datos
    $stmt = $conn->prepare("DELETE FROM libro WHERE id_libro = ?");
    $stmt->bind_param("i", $id_eliminar);
    if ($stmt->execute()) {
        echo "<script>alert('Libro eliminado correctamente.'); window.location.href='eliminarlibro.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error al eliminar el libro.');</script>";
    }
}

// Obtener todos los libros con su género y autor
$sql = "
SELECT l.id_libro, l.nombre_libro, l.portada_url, g.nombre_genero, a.nombre_autor
FROM libro l
JOIN genero g ON l.id_genero = g.id_genero
JOIN autor a ON l.id_autor = a.id_autores
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Administrar libros</title>
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
  <h2>Administrar todos los libros</h2>
  <div class="cards">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($fila = $result->fetch_assoc()): ?>
        <div class="card">
          <div class="img-placeholder" style="background-image: url('<?php echo $fila['portada_url']; ?>'); background-size: cover; background-position: center; height: 200px;"></div>
          <h3><?php echo htmlspecialchars($fila['nombre_libro']); ?></h3>
          <p><strong>Autor:</strong> <?php echo htmlspecialchars($fila['nombre_autor']); ?></p>
          <p><strong>Género:</strong> <?php echo htmlspecialchars($fila['nombre_genero']); ?></p>
          <a href="eliminarlibro.php?eliminar=<?php echo $fila['id_libro']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">
            <button style="background-color: red; color: white;">Eliminar libro</button>
          </a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No hay libros registrados en la base de datos.</p>
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
