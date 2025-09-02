<?php
include 'conexion.php';

$id = $_POST['id'] ?? null;
$accion = $_POST['accion'] ?? null;

if (!$id || !$accion) {
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

$estado = ($accion === 'bloquear') ? 'bloqueado' : 'activo';

$sql = "UPDATE users SET estado = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $estado, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => "Usuario actualizado a '$estado'"]);
} else {
    echo json_encode(['error' => "Error al actualizar usuario"]);
}

$stmt->close();
$conn->close();
?>
