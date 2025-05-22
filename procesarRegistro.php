<?php
include("conexion.php");

// Obtener datos del formulario
$correo = $_POST['correo'];
$edad = $_POST['edad'];
$contrasena = $_POST['contrasena'];
$ocupacion = $_POST['ocupacion'];
$rol = 2; // ID del rol lector por defecto

// Preparar sentencia segura
$stmt = $conn->prepare("INSERT INTO usuario (correo_usuario, edad_usuario, contraseña_usuario, ocupacion_usuario, rol_usuario, nombre_usuario) 
                        VALUES (?, ?, ?, ?, ?)");

$stmt->bind_param("sisii", $correo, $edad, $contrasena, $ocupacion, $rol, $nombre);

if ($stmt->execute()) {
    header("Location: Registro.html"); // Redirige después de registrar
    exit();
} else {
    echo "Error al registrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
