<?php
session_start();
include("conexion.php");

// Verifica que el usuario sea admin
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol_usuario'] != 1) {
    die("Acceso denegado.");
}

$id_usuario = $_SESSION['id_usuario'];  // <- este valor sí está bien




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $genero = intval($_POST['genero']);
    $autor_nombre = trim($_POST['autor']);
    $imagen_url = trim($_POST['imagen_url']);

    if ($titulo !== "" && $genero !== "" && $autor_nombre !== "" && $imagen_url !== "") {
        // Buscar si el autor ya existe
        $stmt_buscar = $conn->prepare("SELECT id_autores FROM autor WHERE nombre_autor = ?");
        $stmt_buscar->bind_param("s", $autor_nombre);
        $stmt_buscar->execute();
        $result = $stmt_buscar->get_result();

        if ($row = $result->fetch_assoc()) {
            // El autor ya existe
            $id_autor = $row['id_autores'];
        } else {
            // El autor no existe, insertarlo
            $stmt_insert = $conn->prepare("INSERT INTO autor (nombre_autor) VALUES (?)");
            $stmt_insert->bind_param("s", $autor_nombre);
            $stmt_insert->execute();
            $id_autor = $conn->insert_id;
        }

        // Insertar el libro con el ID del autor
        $stmt_libro = $conn->prepare("
        INSERT INTO libro (nombre_libro, id_genero, id_autor, portada_url, id_usuario)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt_libro->bind_param("siisi", $titulo, $genero, $id_autor, $imagen_url, $id_usuario);
    

        if ($stmt_libro->execute()) {
            header("Location: perfil.php");
            exit();
        } else {
            echo "Error al guardar libro.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}


?>
