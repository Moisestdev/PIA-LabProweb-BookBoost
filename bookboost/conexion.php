<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "mydb";

$conn = new mysqli($host, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Opcional para probar si conecta:
// echo "Conexión exitosa";
?>
