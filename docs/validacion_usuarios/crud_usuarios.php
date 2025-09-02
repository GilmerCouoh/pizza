<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado.";
    exit;
}

include 'conexion.php';

// Filtros
$filtro_id = $_GET['id'] ?? '';
$filtro_username = $_GET['username'] ?? '';
$filtro_email = $_GET['email'] ?? '';
$filtro_rol = $_GET['role'] ?? '';
$filtro_estado = $_GET['estado'] ?? '';

// Orden
$orden_columna = $_GET['orden_columna'] ?? 'id';
$orden_direccion = $_GET['orden_direccion'] ?? 'ASC';

// Validación simple
$columnas_validas = ['id', 'username', 'email', 'role', 'estado'];
$orden_columna = in_array($orden_columna, $columnas_validas) ? $orden_columna : 'id';
$orden_direccion = strtoupper($orden_direccion) === 'DESC' ? 'DESC' : 'ASC';

// Consulta con filtros
$sql = "SELECT * FROM users WHERE 1=1";
$params = [];
$types = "";

if ($filtro_id !== '') {
    $sql .= " AND id = ?";
    $params[] = $filtro_id;
    $types .= "i";
}

if ($filtro_username !== '') {
    $sql .= " AND username LIKE ?";
    $params[] = "%$filtro_username%";
    $types .= "s";
}

if ($filtro_email !== '') {
    $sql .= " AND email LIKE ?";
    $params[] = "%$filtro_email%";
    $types .= "s";
}

if ($filtro_rol !== '') {
    $sql .= " AND role = ?";
    $params[] = $filtro_rol;
    $types .= "s";
}

if ($filtro_estado !== '') {
    $sql .= " AND estado = ?";
    $params[] = $filtro_estado;
    $types .= "s";
}

$sql .= " ORDER BY $orden_columna $orden_direccion";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();

// Función para generar enlaces de ordenamiento
function enlaceOrden($columna, $texto)
{
    global $orden_columna, $orden_direccion;
    $nueva_direccion = ($orden_columna === $columna && $orden_direccion === 'ASC') ? 'DESC' : 'ASC';
    $params = $_GET;
    $params['orden_columna'] = $columna;
    $params['orden_direccion'] = $nueva_direccion;
    $url = '?' . http_build_query($params);
    $flecha = ($orden_columna === $columna) ? ($orden_direccion === 'ASC' ? '↑' : '↓') : '';
    return "<a href=\"$url\" class=\"hover:underline font-semibold\">$texto $flecha</a>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    Montagu: ["'Montagu Slab'", "serif"],
                    Montserrat: ["'Montserrat'", "sans-serif"]
                }
            }
        }
    }
    </script>
</head>
<body class="bg-gray-100 font-sans">
<header class="bg-[#f45c33] text-white p-4">
        <div class="flex justify-between items-center">
            <a href="view_admin.php" class="flex items-center space-x-2">
                <img src="https://i.ibb.co/q0wGMR8/logo-pizzeria.png" alt="Logo MariaReyes" class="h-12">
                <span class="text-2xl font-Montagu">Maria Reyes</span>
            </a>
            <nav class="font-Montserrat hidden md:flex space-x-6">
                <a href="crud_usuarios.php" class="hover:underline">Usuarios</a>
                <a href="crud_pedidos.php" class="hover:underline">Lista de pedidos</a>
                <a href="crud_pizzas.php" class="hover:underline">Lista de pizzas</a>
            </nav>
        </div>
</header>
<div class="container mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-2xl mb-6 font-bold font-Montagu">CRUD de Usuarios</h1>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <input type="text" name="id" value="<?= htmlspecialchars($filtro_id) ?>" placeholder="ID" class="border p-2 w-full">
        <input type="text" name="username" value="<?= htmlspecialchars($filtro_username) ?>" placeholder="Usuario" class="border p-2 w-full">
        <input type="text" name="email" value="<?= htmlspecialchars($filtro_email) ?>" placeholder="Email" class="border p-2 w-full">

        <select name="role" class="border p-2 w-full">
            <option value="">Rol</option>
            <option value="user" <?= $filtro_rol === 'user' ? 'selected' : '' ?>>Usuario</option>
            <option value="admin" <?= $filtro_rol === 'admin' ? 'selected' : '' ?>>Administrador</option>
        </select>

        <select name="estado" class="border p-2 w-full">
            <option value="">Estado</option>
            <option value="activo" <?= $filtro_estado === 'activo' ? 'selected' : '' ?>>Activo</option>
            <option value="bloqueado" <?= $filtro_estado === 'bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
        </select>

        <div class="md:col-span-5 flex justify-end gap-2 mt-2">
            <button type="submit" class="bg-[#f45c33] text-white px-4 py-2 rounded">Buscar</button>
            <a href="crud_usuarios.php" class="bg-gray-400 text-white px-4 py-2 rounded">Limpiar</a>
        </div>
    </form>

    <table class="min-w-full bg-white border border-gray-300 rounded overflow-hidden">
        <thead class="bg-gray-200">
        <tr class="text-center">
            <th class="py-2 px-4"><?= enlaceOrden('id', 'ID') ?></th>
            <th class="py-2 px-4"><?= enlaceOrden('username', 'Usuario') ?></th>
            <th class="py-2 px-4"><?= enlaceOrden('email', 'Email') ?></th>
            <th class="py-2 px-4"><?= enlaceOrden('role', 'Rol') ?></th>
            <th class="py-2 px-4"><?= enlaceOrden('estado', 'Estado') ?></th>
            <th class="py-2 px-4">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($user = $resultado->fetch_assoc()): ?>
            <tr class="text-center border-t">
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role'] ?></td>
                <td><?= $user['estado'] === 'bloqueado' ? 'Bloqueado' : 'Activo' ?></td>
                <td class="space-x-2">
                    <a href="#" onclick="bloquearUsuario(<?= $user['id'] ?>, '<?= $user['estado'] === 'bloqueado' ? 'activar' : 'bloquear' ?>')" class="text-yellow-600 hover:underline">
                        <?= $user['estado'] === 'bloqueado' ? 'Desbloquear' : 'Bloquear' ?>
                    </a>
                    <a href="#" onclick="eliminarUsuario(<?= $user['id'] ?>)" class="text-red-600 hover:underline">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function eliminarUsuario(id) {
    if (confirm('¿Estás seguro de eliminar este usuario?')) {
        fetch('eliminar_usuario.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.text())
        .then(data => {
            alert('Usuario eliminado');
            location.reload();
        });
    }
}

function bloquearUsuario(id, accion) {
    fetch('bloquear_usuario.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&accion=${accion}`
    })
    .then(res => res.text())
    .then(data => {
        alert('Usuario actualizado');
        location.reload();
    });
}
</script>
<footer class="bg-[#f45c33] text-white py-8 mt-12">
        <div class="container mx-auto text-center">
            <p class="mb-4 font-light">© 2024 Maria Reyes. Todos los derechos reservados.</p>
            <div class="flex justify-center space-x-4 mb-4">
                <a href="https://www.facebook.com/MariaReyespizzeria/?locale=es_LA"
                    class="hover:text-verdin transition">Facebook</a>
                <a href="https://www.instagram.com/mariareyes7334/" class="hover:text-verdin transition">Instagram</a>
            </div>
            <div class="flex justify-center space-x-6 text-sm">
                <a href="#" class="hover:text-verdin transition">Política de privacidad</a>
                <a href="#" class="hover:text-verdin transition">Términos de uso</a>
                <a href="#" class="hover:text-verdin transition">Contacto</a>
            </div>
        </div>
</footer>
</body>
</html>
