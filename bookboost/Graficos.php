<?php
session_start();
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficos y Estadisticas</title>
    <link rel="stylesheet" href="estadisticas.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <style>
      .chart {
        width: 100%;
        height: 400px;
        margin-top: 20px;
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
    <a>Bienvenido, <?php echo isset($_SESSION['correo']) ? htmlspecialchars($_SESSION['correo']) : 'Invitado'; ?> 👋</a>
    <a href="Perfil.php">Perfil</a>
    <button class="add-btn">+</button>
  </div>
</header>

<main class="main-container">
  <div class="title">
    <h2><strong>Graficos y estadisticas</strong></h2>
  </div>

  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div id="chart1" class="chart"></div>
      </div>
    </div>
  </div>

  <div class="filtro-container" style="margin-top: 20px;">
    <select id="tipoFiltro" class="form-select" style="width: 200px; display: inline-block;">
      <option value="ocupacion">Usuarios por ocupación</option>
      <option value="genero">Libros por género</option>
      <option value="autor">Libros por autor</option>
    </select>
    <button id="Filtrar" class="btn btn-primary">Filtrar</button>
  </div>
</main>

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

      <?php if (isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] == 1): ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
<script>
const initChart = async (tipo = 'ocupacion') => {
  try {
    const res = await fetch(`datos_estadisticas.php?tipo=${tipo}`);
    const data = await res.json();

    const chart1 = echarts.init(document.getElementById('chart1'));

    const option = {
      title: {
        text: data.titulo,
        left: 'center'
      },
      tooltip: {},
      xAxis: {
        type: 'category',
        data: data.labels
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        data: data.valores,
        type: 'bar',
        showBackground: true,
        backgroundStyle: {
          color: 'rgba(180, 180, 180, 0.2)'
        }
      }]
    };

    chart1.setOption(option);
  } catch (error) {
    console.error("Error al cargar datos del gráfico:", error);
  }
};

document.addEventListener('DOMContentLoaded', () => {
  initChart();
  document.getElementById('Filtrar').addEventListener('click', () => {
    const tipo = document.getElementById('tipoFiltro').value;
    initChart(tipo);
  });
});
</script>
<script src="menu.js"></script>
</body>
</html>