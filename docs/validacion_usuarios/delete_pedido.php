<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM pedidos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: crud_pedidos.php");
    exit;
}
?>
