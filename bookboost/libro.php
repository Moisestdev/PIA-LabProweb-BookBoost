<?php
session_start();
include("conexion.php");

$id_libro = $_GET['id']; // default a libro con ID 1 si no se pasa por URL

// Obtener datos del libro
$stmt = $conn->prepare("
  SELECT l.nombre_libro, l.portada_url, a.nombre_autor, g.nombre_genero
  FROM libro l
  LEFT JOIN autor a ON l.id_autores = a.id_autores
  LEFT JOIN genero g ON l.id_genero = g.id_genero
  WHERE l.id_libro = ?
");




$stmt->bind_param("i", $id_libro);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();

// Obtener reseñas del libro
$sql = "SELECT r.contenido_reseña, u.nombre_usuario
        FROM reseña r
        JOIN usuario u ON r.id_usuario = u.id_usuario
        WHERE r.id_libro = ?
        ORDER BY r.fecha_reseña DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_libro);
$stmt->execute();
$resenas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Título del libro</title>
  <link rel="stylesheet" href="libro.css" />
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
  <main class="main-container libro-detalle">
    <h1><?php echo htmlspecialchars($libro['nombre_libro']); ?></h1>


    <section class="descripcion-libro">
      <div class="img-libro">
        <img src="<?php echo $libro['portada_url']; ?>" alt="Imagen del libro">
      </div>
      <div class="info-libro">
  <h2><?php echo htmlspecialchars($libro['nombre_libro']); ?></h2>
  <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['nombre_autor']); ?></p>
  <p><strong>Género:</strong> <?php echo htmlspecialchars($libro['nombre_genero']); ?></p>
</div>


    </section>

    <section class="resenas-libro">
      <h3>Reseñas acerca del libro</h3>
    
      <?php if ($resenas->num_rows > 0): ?>
        <?php while ($r = $resenas->fetch_assoc()): ?>
          <div class="resena">
            
            <div>
              <strong><?php echo htmlspecialchars($r['nombre_usuario']); ?></strong><br>
              <?php echo htmlspecialchars($r['contenido_reseña']); ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No hay reseñas para este libro todavía.</p>
      <?php endif; ?>
    
<div class="btn-resena">
  <a href="reseña.php?id=<?php echo urlencode($id_libro); ?>&titulo=<?php echo urlencode($libro['nombre_libro']); ?>&genero=<?php echo urlencode($libro['nombre_genero']); ?>">
    <button>Agregar reseña</button>
  </a>
</div>

    </section>
    
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
</body>
<script src="menu.js"></script>
</html>
