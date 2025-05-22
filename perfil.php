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
$sql = "SELECT r.id_reseña, r.contenido_reseña, l.portada_url, l.id_libro
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
      <input type="text" placeholder="Buscar" class="search-bar">
      <a>Bienvenido, <?php echo $_SESSION['correo']; ?> 👋</a>
      <a href="logout.php">Cerrar sesión</a>
      <button class="add-btn">+</button>
    </div>
  </header>

<main class="main-container">
  <h1>Mi Perfil</h1>

  <section class="perfil-usuario">
    <div class="perfil-info">

      <div class="perfil-desc">
        <h2><?php echo $datos['nombre_usuario']; ?></h2>
        <p>
          Sin descripcion
        </p>
      </div>
    </div>
  </section>

  <section class="perfil-reseñas">
    <h3>Mis reseñas</h3>

    <?php if ($resultado->num_rows > 0): ?>
    <?php while ($fila = $resultado->fetch_assoc()): ?>
      <div class="reseña-container">
        <div class="reseña">
          <img src="<?php echo $fila['portada_url']; ?>" alt="Libro">
          <div>
            <strong>a</strong>
            <p><?php echo $fila['contenido_reseña']; ?></p>
          </div>
        </div>
      </div>
      <div class="button">
              <form method="POST" action="editarResena.php" style="display:inline;">
                <input type="hidden" name="id_reseña" value="<?php echo $fila['id_reseña']; ?>">
                <button type="submit">Editar</button>
              </form>

              <form method="POST" action="eliminarResena.php" style="display:inline;">
                <input type="hidden" name="id_reseña" value="<?php echo $fila['id_reseña']; ?>">
                <button type="submit">Eliminar</button>
              </form>
            </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No hay reseñas aún.</p>
  <?php endif; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
    <div class="btn-row right">
      <button>Editar perfil</button>
    </div>
  </section>
</main>

</body>
<script src="perfil.js"></script>
</html>


