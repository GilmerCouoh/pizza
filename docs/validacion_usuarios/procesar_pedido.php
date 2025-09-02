<?php
// procesar_pedido.php

$mysqli = new mysqli("localhost", "root", "Server123A", "pizzeria_db");
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$pizza_id = $_POST['pizza_id'] ?? null;
$size = $_POST['size'] ?? null;
$name = $_POST['fname'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$reference = $_POST['reference'] ?? '';
$entrega = $_POST['entrega'] ?? 'establecimiento';
$cantidad = intval($_POST['cantidad'] ?? 1);
$precio = floatval($_POST['precio'] ?? 0);
$total = floatval($_POST['total'] ?? 0);

// Buscar la pizza
$stmt = $mysqli->prepare("SELECT nombre FROM pizzas WHERE id = ?");
$stmt->bind_param("i", $pizza_id);
$stmt->execute();
$result = $stmt->get_result();
$pizza = $result->fetch_assoc();
$stmt->close();

if (!$pizza) {
    die("No se encontró la pizza.");
}

// Construir detalle del pedido como JSON
$detalle = [
    "producto" => $pizza['nombre'],
    "tamaño" => $size,
    "precio_unitario" => number_format($precio, 2),
    "cantidad" => $cantidad
];
$detalle_json = json_encode($detalle, JSON_UNESCAPED_UNICODE);

// Dirección completa (solo texto, aunque venga del formulario como campos separados)
$direccion_completa = $address . ' - ' . $reference;

// Insertar en la base de datos
$insert = $mysqli->prepare("INSERT INTO pedidos (detalle_pedido, total, cliente, telefono, direccion, estatus) VALUES (?, ?, ?, ?, ?, 'pendiente')");
$insert->bind_param("sdsss", $detalle_json, $total, $name, $phone, $direccion_completa);

if ($insert->execute()) {
    echo "<h1>¡Pedido registrado exitosamente!</h1>";
    echo "<p><a href='view_user.php'>Volver al inicio</a></p>";
} else {
    echo "Error al registrar el pedido: " . $insert->error;
}

$insert->close();
$mysqli->close();
?>
