<?php
require 'conexion.php';

$query = "SELECT * FROM pedidos ORDER BY fecha_creacion DESC";
$result = mysqli_query($conn, $query);

$pedidos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['detalle_pedido'] = json_decode($row['detalle_pedido'], true);
    $pedidos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <!-- Mensaje flotante -->
    <div id="mensaje" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded shadow-lg hidden z-50">
        Estatus actualizado correctamente
    </div>

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Pedidos</h1>

        <?php if (!empty($pedidos)): ?>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Detalle</th>
                        <th class="px-4 py-2 border">Total</th>
                        <th class="px-4 py-2 border">Cliente</th>
                        <th class="px-4 py-2 border">Teléfono</th>
                        <th class="px-4 py-2 border">Dirección</th>
                        <th class="px-4 py-2 border">Estatus</th>
                        <th class="px-4 py-2 border">Fecha</th>
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                    <?php
                    $bgClass = match($pedido['estatus']) {
                        'pendiente' => 'bg-yellow-100',
                        'enviado' => 'bg-blue-100',
                        'entregado' => 'bg-green-100',
                        default => 'bg-white',
                    };
                    ?>
                    <tr id="row-<?= $pedido['id'] ?>" class="<?= $bgClass ?> hover:bg-gray-100 transition duration-300">
                        <td class="px-4 py-2 border"><?= $pedido['id'] ?></td>
                        <td class="px-4 py-2 border text-sm">
                            Producto: <?= $pedido['detalle_pedido']['producto'] ?? 'N/A' ?><br>
                            Tamaño: <?= $pedido['detalle_pedido']['tamaño'] ?? 'N/A' ?><br>
                            Precio: <?= $pedido['detalle_pedido']['precio_unitario'] ?? 'N/A' ?><br>
                            Cantidad: <?= $pedido['detalle_pedido']['cantidad'] ?? 'N/A' ?>
                        </td>
                        <td class="px-4 py-2 border"><?= number_format($pedido['total'], 2) ?> MXN</td>
                        <td class="px-4 py-2 border"><?= $pedido['cliente'] ?></td>
                        <td class="px-4 py-2 border"><?= $pedido['telefono'] ?></td>
                        <td class="px-4 py-2 border"><?= $pedido['direccion'] ?></td>
                        <td class="px-4 py-2 border">
                            <select data-id="<?= $pedido['id'] ?>" onchange="actualizarEstatus(this)" class="px-2 py-1 border rounded">
                                <option value="pendiente" <?= $pedido['estatus'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                <option value="enviado" <?= $pedido['estatus'] === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                                <option value="entregado" <?= $pedido['estatus'] === 'entregado' ? 'selected' : '' ?>>Entregado</option>
                            </select>
                        </td>
                        <td class="px-4 py-2 border"><?= $pedido['fecha_creacion'] ?></td>
                        <td class="px-4 py-2 border text-center">
                            <form action="delete_pedido.php" method="POST" onsubmit="return confirm('¿Eliminar este pedido?');">
                                <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-center text-blue-700">No hay pedidos disponibles.</p>
        <?php endif; ?>
    </div>
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
    <script>
    function actualizarEstatus(selectElement) {
        const id = selectElement.dataset.id;
        const estatus = selectElement.value;

        fetch('update_estatus.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&estatus=${estatus}`
        })
        .then(res => res.ok ? res.text() : Promise.reject('Error'))
        .then(() => {
            const row = document.getElementById('row-' + id);
            row.classList.remove('bg-yellow-100', 'bg-blue-100', 'bg-green-100');
            switch (estatus) {
                case 'pendiente': row.classList.add('bg-yellow-100'); break;
                case 'enviado': row.classList.add('bg-blue-100'); break;
                case 'entregado': row.classList.add('bg-green-100'); break;
            }

            const mensaje = document.getElementById('mensaje');
            mensaje.classList.remove('hidden');
            setTimeout(() => mensaje.classList.add('hidden'), 2000);
        })
        .catch(() => alert('Hubo un error al actualizar el estatus.'));
    }
    </script>

</body>
</html>
