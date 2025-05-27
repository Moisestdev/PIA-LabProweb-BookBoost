<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edición de libro</title>
  <link rel="stylesheet" href="edicionLibro.css">
</head>
<body>

<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: IS.html");
    exit();
}
$id_libro = $_GET['id'] ?? null;

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? null;
    $resena = $_POST['resena'] ?? null;

    if (!$titulo || !$resena) {
        die("Faltan datos del formulario.");
    }

    $fecha = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO reseña (fecha_reseña, contenido_reseña, id_libro, id_usuario)
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $fecha, $resena, $titulo, $id_usuario);

    if ($stmt->execute()) {
        header("Location: lobby.php");
        exit();
    } else {
        echo "Error al guardar la reseña: " . $stmt->error;
    }

    $stmt->close();
}
?>



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
  <h1>Creación de reseña</h1>

  <form method="POST">

    <div class="libro-formulario">
      <div class="imagen-libro">
        <img id="portada" src="placeholder.png" alt="Portada" width="150">
      </div>

      <div class="campos-libro">
        <label for="titulo">Título de libro</label>
        <select id="titulo" name="titulo" required onchange="actualizarLibro()">
          <option value="">Selecciona un título</option>
          <?php
          $libros = $conn->query("SELECT id_libro, nombre_libro, id_genero, portada_url FROM libro");
          while ($row = $libros->fetch_assoc()):
          ?>
            <option value="<?= $row['id_libro'] ?>" 
                    data-genero="<?= $row['id_genero'] ?>" 
                    data-portada="<?= htmlspecialchars($row['portada_url']) ?>">
              <?= $row['nombre_libro'] ?>
            </option>
          <?php endwhile; ?>
        </select>

        <label for="genero">Género</label>
        <input type="text" id="genero" name="genero" readonly>


      </div>
    </div>

    <div class="reseña-area">
      <label for="resena"><strong>Reseña</strong></label>
      <textarea id="resena" name="resena" rows="5" required></textarea>
    </div>

    <div class="botones-final">
      <button type="submit">Crear reseña</button>
      <button type="reset">Cancelar</button>
    </div>
  </form>
</main>

<script>
  const generos = {
  <?php
    $generos = $conn->query("SELECT id_genero, nombre_genero FROM genero");
    while ($row = $generos->fetch_assoc()):
  ?>
    <?= $row['id_genero'] ?>: "<?= $row['nombre_genero'] ?>",
  <?php endwhile; ?>
  };

  function actualizarLibro() {
    const select = document.getElementById("titulo");
    const generoInput = document.getElementById("genero");
    const portadaImg = document.getElementById("portada");

    const option = select.options[select.selectedIndex];
    const generoId = option.getAttribute("data-genero");
    const portadaUrl = option.getAttribute("data-portada");

    generoInput.value = generos[generoId] || "";
    portadaImg.src = portadaUrl || "placeholder.png";
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
<?php $conn->close(); ?>

</body>
<script src="menu.js"></script>
</html>
