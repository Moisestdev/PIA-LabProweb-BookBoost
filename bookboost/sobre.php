<?php
session_start();
include("conexion.php");

// Validación segura para evitar errores si no existe la variable
$correo_usuario = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;
$rol_usuario = isset($_SESSION['rol_usuario']) ? $_SESSION['rol_usuario'] : null;
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sobre nosotros</title>
  <link rel="stylesheet" href="sobre.css" />
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

  <main class="main-container about">
    <div class="about-content">
      <section class="equipo">
        <h1>Sobre nosotros</h1>
        <div class="box">
          <p>
            La razón por lo que se creó la página web es para 
            facilitar el descubrimiento de libros basado en gustos y preferencias de los usuarios. <br>
            En un mundo donde la lectura disminuyo notablemente, siendo nuestra misión promover la
            lectura y ofrecer recomendaciones
             para que los lectores conecten con libros que realmente disfruten. 
            Además de crear una comunidad activa donde los usuarios puedan compartir reseñas, 
            opiniones y calificaciones acerca de un libro. <br>
            Al proporcionar una plataforma fácil de utilizar, queremos ayudar a las personas a redescubrir el placer de leer, 
            explorar nuevos géneros y autores, fomentando con una comunidad activa de lectores.<br>
            Cada recomendación que se realice tendrá en cuenta tus intereses, estilo de lectura y 
            emociones para que cada libro sea una nueva experiencia.
          </p>
        </div>
      </section>

      <section class="integrantes">
        <h2>Integrantes</h2>

        <div class="integrante-card">
          <div>
            <strong>Anthony Uriel Mendoza Miranda</strong><br>
            Carrera: ITS<br>
            Matricula: 2132279<br>

          </div>
        </div>

        <div class="integrante-card">
          <div>
            <strong>Moises Abdiel Torres Mendez</strong><br>
            Carrera: ITS<br>
            Matricula: 2104976 <br>
          </div>
        </div>

        <div class="integrante-card">
          <div>
            <strong>Christian Sanchez Hernandez</strong><br>
            Carrera: ITS<br>
            Matricula: 2058350 <br>
          </div>
        </div>


      </section>
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
