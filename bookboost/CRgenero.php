<?php
session_start();
include("conexion.php");


// Insertar nuevo género si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_genero'])) {
    $nuevo_genero = trim($_POST['nuevo_genero']);
    if ($nuevo_genero !== "") {
        $stmt = $conn->prepare("INSERT INTO genero (nombre_genero) VALUES (?)");
        $stmt->bind_param("s", $nuevo_genero);
        $stmt->execute();
    }
}

// Eliminar género si se envió el ID
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM genero WHERE id_genero = $id");
}

// Obtener todos los géneros
$generos = $conn->query("SELECT * FROM genero");
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CRgenero.css">
    
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

<main class="main-container">
 <section id="Cr-reseñas">
    <div class="Edicion de generos de libro">
        <h3><strong>Edición de géneros de libros</strong></h3>
        <div class="ED-generos">
          <h4><strong>Lista de géneros actuales</strong></h4>
          <?php while ($g = $generos->fetch_assoc()): ?>
            <div class="genero-item" style="margin-bottom: 10px;">
              <h5 class="Titulo-gen"><strong><?php echo htmlspecialchars($g['nombre_genero']); ?></strong></h5>
              <a href="?eliminar=<?php echo $g['id_genero']; ?>" onclick="return confirm('¿Eliminar este género?');">
                <button class="P-eliminar">Eliminar</button>
              </a>
            </div>
          <?php endwhile; ?>
          
          <form method="POST" style="margin-top: 20px;">
  <h3><strong>Género del libro que desea agregar</strong></h3>
  <input type="text" name="nuevo_genero" class="texto" placeholder="Nombre del género">
  <button type="submit" class="P-anadir">Añadir</button>
</form>




            

        </div>
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
    <script src="menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>