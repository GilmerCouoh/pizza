<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $estatus = $_POST['estatus'];

    $stmt = $conn->prepare("UPDATE pedidos SET estatus = ?, fecha_actualizacion = NOW() WHERE id = ?");
    $stmt->bind_param("si", $estatus, $id);
    $stmt->execute();
    $stmt->close();
    exit;
}
?>
