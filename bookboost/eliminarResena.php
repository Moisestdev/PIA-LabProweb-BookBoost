<?php
session_start();
include("conexion.php");
$stmt = $conn->prepare("DELETE FROM reseña WHERE id_reseña = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id_reseña, $_SESSION['id_usuario']);

// Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: IS.html");
    exit();
}

// Validar que se recibió el id de la reseña
if (isset($_POST['id_reseña'])) {
    $id_reseña = $_POST['id_reseña'];

    // Eliminar la reseña
    $stmt = $conn->prepare("DELETE FROM reseña WHERE id_reseña = ?");
    $stmt->bind_param("i", $id_reseña);

    if ($stmt->execute()) {
        // Redirigir al perfil si se elimina con éxito
        header("Location: Perfil.php");
        exit();
    } else {
        echo "Error al eliminar la reseña.";
    }

    $stmt->close();
} else {
    echo "No se proporcionó una reseña válida.";
}

$conn->close();
?>
