<?php
include("conexion.php");

session_start();

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$sql = "SELECT * FROM usuario WHERE correo_usuario = ? AND contraseña_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $correo, $contrasena);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    session_start();
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['correo'] = $usuario['correo_usuario'];
    $_SESSION['rol'] = $usuario['rol_usuario'];

    header("Location: lobby.php");
    exit();
}
 else {
    echo "Correo o contraseña incorrectos.";
}

$stmt->close();
$conn->close();
?>
