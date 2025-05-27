<?php
include("conexion.php");

$tipo = $_GET['tipo'] ?? 'ocupacion';
$datos = ["labels" => [], "valores" => [], "titulo" => ""];

switch ($tipo) {
  case 'genero':
    $sql = "SELECT g.nombre_genero AS etiqueta, COUNT(l.id_libro) AS total
            FROM libro l
            JOIN genero g ON l.id_genero = g.id_genero
            GROUP BY g.nombre_genero";
    $datos['titulo'] = "Libros por género";
    break;

  case 'autor':
    $sql = "SELECT a.nombre_autor AS etiqueta, COUNT(l.id_libro) AS total
            FROM libro l
            JOIN autor a ON l.id_autor = a.id_autores
            GROUP BY a.nombre_autor
            ORDER BY total DESC
            LIMIT 10"; // Opcional: limitar a los 10 más comunes
    $datos['titulo'] = "Libros por autor";
    break;

case 'ocupacion':
  $sql = "SELECT o.nombre_ocupacion AS etiqueta, COUNT(u.id_usuario) AS total
          FROM usuario u
          JOIN ocupacion o ON u.ocupacion_usuario = o.id_ocupacion
          GROUP BY o.nombre_ocupacion";
  $datos['titulo'] = "Usuarios por ocupación";
  break;

}

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $datos['labels'][] = $row['etiqueta'];
    $datos['valores'][] = (int)$row['total'];
}

header('Content-Type: application/json');
echo json_encode($datos);
?>
