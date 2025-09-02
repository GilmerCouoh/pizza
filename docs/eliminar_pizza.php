<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    include 'conexion.php';

    // Eliminar imagen si existe
    $stmt_img = $conn->prepare("SELECT imagen FROM pizzas WHERE id = ?");
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $resultado_img = $stmt_img->get_result();
    if ($fila = $resultado_img->fetch_assoc()) {
        $imagen = $fila['imagen'];
        if (!empty($imagen) && file_exists("uploads/$imagen")) {
            unlink("uploads/$imagen"); // eliminar archivo de imagen
        }
    }

    // Eliminar la pizza de la base de datos
    $stmt = $conn->prepare("DELETE FROM pizzas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    echo "ok";
    exit;
} else {
    echo "ID no proporcionado.";
}
