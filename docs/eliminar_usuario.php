<?php
include 'conexion.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'ID de usuario no proporcionado']);
    exit;
}

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['success' => "Usuario eliminado correctamente"]);
} else {
    echo json_encode(['error' => "No se pudo eliminar el usuario"]);
}

$stmt->close();
$conn->close();
?>
