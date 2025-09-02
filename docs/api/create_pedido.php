<?php
require '../conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$detalle_pedido = json_encode($data['detalle_pedido']);
$total = $data['total'];
$cliente = $data['cliente'];
$telefono = $data['telefono'];
$direccion = $data['direccion'];

$stmt = $conn->prepare("INSERT INTO pedidos (detalle_pedido, total, cliente, telefono, direccion) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sdsss", $detalle_pedido, $total, $cliente, $telefono, $direccion);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();