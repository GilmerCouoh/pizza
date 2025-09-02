<?php
require '../conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$estatus = $data['estatus'];

$stmt = $conn->prepare("UPDATE pedidos SET estatus = ?, fecha_actualizacion = NOW() WHERE id = ?");
$stmt->bind_param("si", $estatus, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
