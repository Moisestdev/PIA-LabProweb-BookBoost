<?php
session_start();
include("conexion.php");

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$stmt = $conn->prepare("SELECT id_usuario, rol_usuario, correo_usuario FROM usuario WHERE correo_usuario = ? AND contraseña_usuario = ?");
$stmt->bind_param("ss", $correo, $contrasena);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['rol_usuario'] = $fila['rol_usuario'];  // ← NECESARIO PARA accesar como admin
    $_SESSION['correo'] = $fila['correo_usuario'];
    header("Location: lobby.php");
    exit();
} else {
    echo "Credenciales incorrectas.";
}

$stmt->close();
$conn->close();
?>
