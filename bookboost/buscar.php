<?php
session_start();
include("conexion.php");

$query = $_GET['q'] ?? '';
$filtro = $_GET['filtro'] ?? 'todos';

switch ($filtro) {
    case 'genero':
        $stmt = $conn->prepare("SELECT l.id_libro, l.nombre_libro, l.portada_url FROM libro l JOIN genero g ON l.id_genero = g.id_genero WHERE g.nombre_genero LIKE CONCAT('%', ?, '%')");
        break;
    case 'autor':
        $stmt = $conn->prepare("SELECT l.id_libro, l.nombre_libro, l.portada_url FROM libro l JOIN autor a ON l.id_autor = a.id_autores WHERE a.nombre_autor LIKE CONCAT('%', ?, '%')");
        break;
    default:
        $stmt = $conn->prepare("SELECT id_libro, nombre_libro, portada_url FROM libro WHERE nombre_libro LIKE CONCAT('%', ?, '%')");
}

$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultados de búsqueda</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header class="header">
  <div class="nav-container">
    <div class="logo"></div>
    <button id="abrirMenu" class="menu-btn">☰ Menú</button>
    <form method="GET" action="buscar.php" class="search-form" style="display: flex; gap: 5px;">
      <select name="filtro" class="filtro-selector">
        <option value="todos" <?= $filtro === 'todos' ? 'selected' : '' ?>>Todos</option>
        <option value="genero" <?= $filtro === 'genero' ? 'selected' : '' ?>>Género</option>
        <option value="autor" <?= $filtro === 'autor' ? 'selected' : '' ?>>Autor</option>
      </select>
      <input type="text" name="q" placeholder="Buscar libro..." class="search-bar" value="<?= htmlspecialchars($query) ?>">
      <button type="submit">Buscar</button>
    </form>

    <a>Bienvenido, <?php echo $_SESSION['correo']; ?> 👋</a>
    <a href="Perfil.php">Perfil</a>
    <button class="add-btn">+</button>
  </div>
</header>
<main class="reseñas">
  <h2>Resultados para "<?php echo htmlspecialchars($query); ?>"</h2>
  <div class="cards">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($fila = $result->fetch_assoc()): ?>
        <div class="card">
          <div class="img-placeholder" style="background-image: url('<?php echo $fila['portada_url']; ?>'); background-size: cover; background-position: center; height: 200px;"></div>
          <h3><?php echo $fila['nombre_libro']; ?></h3>
          <a href="libro.php?id=<?php echo $fila['id_libro']; ?>">
            <button>Ver reseñas</button>
          </a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No se encontraron resultados.</p>
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
            echo "<li><a href='genero.php?id=" . $g['id_genero'] . "'>" . htmlspecialchars($g['nombre_genero']) . "</a></li>";
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
