<?php
include 'conexion.php';

$usuario = trim($_POST['usuario'] ?? '');
$respuesta = ['usuario_disponible' => true];

// Verifica si el usuario ya existe
if (!empty($usuario)) {
    $stmt = $conn->prepare("SELECT ID FROM pizzeria_db.USERS WHERE USERNAME = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $respuesta['usuario_disponible'] = ($result->num_rows === 0);
    $stmt->close();
}

echo json_encode($respuesta);
$conn->close();
?>
