<?php
require '../conexion.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM pedidos ORDER BY fecha_creacion DESC");

$pedidos = [];

while ($row = $result->fetch_assoc()) {
    $row['detalle_pedido'] = json_decode($row['detalle_pedido'], true);
    $pedidos[] = $row;
}

echo json_encode($pedidos);
