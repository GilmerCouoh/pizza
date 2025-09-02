<?php
include 'conexion.php';

$usuario = trim($_POST['usuario'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($usuario) || empty($password)) {
    echo json_encode(['error' => 'Todos los campos son obligatorios']);
    exit;
}

// Buscar usuario, su contraseña, rol y estado
$stmt = $conn->prepare("SELECT ID, PASSWORD, ROLE, ESTADO FROM pizzeria_db.USERS WHERE USERNAME = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verificamos si está bloqueado
    if ($user['ESTADO'] === 'bloqueado') {
        echo json_encode(['error' => 'Tu cuenta ha sido bloqueada.']);
        exit;
    }

    // Verificamos la contraseña
    if (password_verify($password, $user['PASSWORD'])) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['rol'] = $user['ROLE'];

        echo json_encode([
            'success' => 'Inicio de sesión exitoso',
            'role' => $user['ROLE']
        ]);
    } else {
        echo json_encode(['error' => 'Contraseña incorrecta']);
    }
} else {
    echo json_encode(['error' => 'Usuario no encontrado']);
}

$stmt->close();
$conn->close();
?>
