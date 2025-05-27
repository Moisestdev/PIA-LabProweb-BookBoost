<?php
include("conexion.php");

$correo = $_POST['correo'];
$edad = $_POST['edad'];
$contrasena = $_POST['contrasena'];
$ocupacion = $_POST['ocupacion'];
$rol = 2;
$nombre = $_POST['nombre_usuario'];

$stmt = $conn->prepare("INSERT INTO usuario (nombre_usuario, correo_usuario, edad_usuario, contraseña_usuario, ocupacion_usuario, rol_usuario) 
                        VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssisis", $nombre, $correo, $edad, $contrasena, $ocupacion, $rol);

if ($stmt->execute()) {
    header("Location: Registro.html");
    exit();
} else {
    echo "Error al registrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
