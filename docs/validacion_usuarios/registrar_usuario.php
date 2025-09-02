<?php
include 'conexion.php';

$usuario = trim($_POST['usuario'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

$errores = [];

// Validaciones
if (empty($usuario)) $errores['error_usuario'] = 'El nombre de usuario no puede estar vacío.';
if (empty($email)) $errores['error_email'] = 'El correo no puede estar vacío.';
if (empty($password)) $errores['error_password'] = 'La contraseña no puede estar vacía.';

if (!empty($errores)) {
    echo json_encode($errores);
    exit;
}

// Verifica si el usuario o correo ya existen
$stmt = $conn->prepare("SELECT USERNAME, EMAIL FROM pizzeria_db.USERS WHERE USERNAME = ? OR EMAIL = ?");
$stmt->bind_param("ss", $usuario, $email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if ($row['USERNAME'] === $usuario) $errores['error_usuario'] = 'Este usuario ya está registrado.';
    if ($row['EMAIL'] === $email) $errores['error_email'] = 'Este correo ya está registrado.';
}

if (!empty($errores)) {
    echo json_encode($errores);
    exit;
}

// Insertar nuevo usuario
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO pizzeria_db.USERS (USERNAME, EMAIL, PASSWORD, CREATED_AT, UPDATED_AT) VALUES (?, ?, ?, NOW(), NOW())");
$stmt->bind_param("sss", $usuario, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Usuario registrado correctamente']);
} else {
    echo json_encode(['error' => 'Hubo un problema al registrar el usuario']);
}

$stmt->close();
$conn->close();
?>
