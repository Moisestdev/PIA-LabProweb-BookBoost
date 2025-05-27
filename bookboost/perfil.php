<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: IS.html");
    exit();
}

include("conexion.php");

$id = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nuevo_nombre'])) {
        $nuevo_nombre = trim($_POST['nuevo_nombre']);
        if ($nuevo_nombre !== '') {
            $update = $conn->prepare("UPDATE usuario SET nombre_usuario = ? WHERE id_usuario = ?");
            $update->bind_param("si", $nuevo_nombre, $id);
            $update->execute();
            $update->close();
            header("Location: Perfil.php");
            exit();
        }
    }
    if (isset($_POST['nueva_resena'], $_POST['id_resena_editar'])) {
        $nueva_resena = trim($_POST['nueva_resena']);
        $id_resena = (int) $_POST['id_resena_editar'];
        if ($nueva_resena !== '') {
            $update = $conn->prepare("UPDATE reseña SET contenido_reseña = ? WHERE id_reseña = ? AND id_usuario = ?");
            $update->bind_param("sii", $nueva_resena, $id_resena, $id);
            $update->execute();
            $update->close();
            header("Location: Perfil.php");
            exit();
        }
    }
}

$stmt = $conn->prepare("SELECT correo_usuario, edad_usuario, ocupacion_usuario, rol_usuario, nombre_usuario FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();
$id_usuario = $_SESSION['id_usuario'];

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
  <style>
    .reseña-info p {
      word-wrap: break-word;
      overflow-wrap: anywhere;
      max-width: 100%;
      white-space: normal;
    }
  </style>
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
    <a href="logout.php">Cerrar sesión</a>
    <button class="add-btn">+</button>
  </div>
</header>

<main class="main-container">
  <h1>Mi Perfil</h1>

  <section class="perfil-usuario">
    <div class="perfil-info">
      <div class="perfil-desc">
        <h2><?php echo htmlspecialchars($datos['nombre_usuario']); ?></h2>
        <button onclick="mostrarPopup()">Editar perfil</button>
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
                <button onclick="editarResena(<?php echo $fila['id_reseña']; ?>, '<?php echo htmlspecialchars($fila['contenido_reseña'], ENT_QUOTES); ?>')">Editar reseña</button>
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
  </section>
</main>

<!-- Popup editar perfil -->
<div id="popupEditar" class="popup" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
  <form method="POST">
    <label for="nuevo_nombre">Nuevo nombre de usuario:</label>
    <input type="text" name="nuevo_nombre" id="nuevo_nombre" required>
    <div style="margin-top: 10px;">
      <button type="submit">Guardar</button>
      <button type="button" onclick="cerrarPopup()">Cancelar</button>
    </div>
  </form>
</div>

<!-- Popup editar reseña -->
<div id="popupResena" class="popup" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
  <form method="POST">
    <input type="hidden" name="id_resena_editar" id="id_resena_editar">
    <label for="nueva_resena">Editar reseña:</label>
    <textarea name="nueva_resena" id="nueva_resena" rows="4" required></textarea>
    <div style="margin-top: 10px;">
      <button type="submit">Guardar</button>
      <button type="button" onclick="cerrarResena()">Cancelar</button>
    </div>
  </form>
</div>

<script>
function mostrarPopup() {
  document.getElementById('popupEditar').style.display = 'block';
}
function cerrarPopup() {
  document.getElementById('popupEditar').style.display = 'none';
}
function editarResena(id, contenido) {
  document.getElementById('id_resena_editar').value = id;
  document.getElementById('nueva_resena').value = contenido;
  document.getElementById('popupResena').style.display = 'block';
}
function cerrarResena() {
  document.getElementById('popupResena').style.display = 'none';
}
</script>

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

<?php
$stmt->close();
$conn->close();
?>
<script src="menu.js"></script>
<script src="perfil.js"></script>
</body>
</html>
