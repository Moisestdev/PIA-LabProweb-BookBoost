<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: IS.html");
    exit();
}

include("conexion.php");

// Obtener los datos del usuario
$id = $_SESSION['id_usuario'];

$stmt = $conn->prepare("SELECT correo_usuario, edad_usuario, ocupacion_usuario, rol_usuario, nombre_usuario FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();
$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener las reseñas del usuario y el nombre del libro
$sql = "SELECT r.id_reseña, r.contenido_reseña, l.portada_url, l.id_libro, l.nombre_libro
        FROM reseña r
        JOIN libro l ON r.id_libro = l.id_libro
        WHERE r.id_usuario = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil</title>
  <link rel="stylesheet" href="Perfil.css" />
</head>
<body>

  <header class="header">
  <div class="nav-container">
      <div class="logo"></div>
      <button id="abrirMenu"class="menu-btn">☰ Menú</button>
      <form method="GET" action="buscar.php" class="search-form">
  <input type="text" name="q" placeholder="Buscar libro..." class="search-bar">
</form>
      <a>Bienvenido, <?php echo $_SESSION['correo']; ?> 👋</a>
      <a href="logout.php">Cerrar sesión</a>
      <button class="add-btn" onclick="window.location.href='reseña.php'">+</button>

    </div>
  </header>

<main class="main-container">
  <h1>Mi Perfil</h1>

  <section class="perfil-usuario">
    <div class="perfil-info">

      <div class="perfil-desc">
        <h2><?php echo $datos['nombre_usuario']; ?></h2>

      </div>
    </div>
  </section>

  <section class="perfil-reseñas">
    <h3>Mis reseñas</h3>

    <?php if ($resultado->num_rows > 0): ?>
    <?php while ($fila = $resultado->fetch_assoc()): ?>
  <div class="reseña-container">
  <div class="reseña">
    <img src="<?php echo $fila['portada_url']; ?>" alt="Libro" class="reseña-img">
    <div class="reseña-info">
    <strong><?php echo $fila['nombre_libro']; ?></strong>

      <p><?php echo $fila['contenido_reseña']; ?></p>
      <div class="reseña-botones">
        <form method="POST" action="editarResena.php" style="display:inline;">
          <input type="hidden" name="id_reseña" value="<?php echo $fila['id_reseña']; ?>">
          <button type="submit">Editar reseña</button>
        </form>

        <form method="POST" action="eliminarResena.php" style="display:inline;">
          <input type="hidden" name="id_reseña" value="<?php echo $fila['id_reseña']; ?>">
          <button type="submit">Eliminar reseña</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No hay reseñas aún.</p>
  <?php endif; ?>

</body>
</html>


    <div class="btn-row right">
      <button>Editar perfil</button>
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
<?php
$stmt->close();
$conn->close();
?>
<script src="menu.js"></script>
<script src="perfil.js"></script>
</html>


