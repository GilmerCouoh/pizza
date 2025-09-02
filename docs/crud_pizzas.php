<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado.";
    exit;
}

// Si estás editando una pizza
$pizzaToEdit = isset($_GET['edit']) ? obtenerPizzaPorId($_GET['edit']) : null;

function obtenerPizzaPorId($id)
{
    include 'conexion.php';
    $stmt = $conn->prepare("SELECT * FROM pizzas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CRUD de Pizzas</title>
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
    <div class="container mx-auto mt-10 p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">CRUD de Pizzas</h1>

        <form id="formPizza" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="id" value="<?= $pizzaToEdit['id'] ?? '' ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= $pizzaToEdit['nombre'] ?? '' ?>" required
                class="border p-2 w-full">

            <label>Descripción:</label>
            <textarea name="descripcion" required
                class="border p-2 w-full"><?= $pizzaToEdit['descripcion'] ?? '' ?></textarea>

            <label>Precio Chico:</label>
            <input type="number" step="0.01" max="99999999.99" name="precio_pequeno"
                value="<?= $pizzaToEdit['precio_pequeno'] ?? '' ?>" required class="border p-2 w-full">

            <label>Precio Mediano:</label>
            <input type="number" step="0.01" max="99999999.99" name="precio_mediano"
                value="<?= $pizzaToEdit['precio_mediano'] ?? '' ?>" required class="border p-2 w-full">

            <label>Precio Grande:</label>
            <input type="number" step="0.01" max="99999999.99" name="precio_grande"
                value="<?= $pizzaToEdit['precio_grande'] ?? '' ?>" required class="border p-2 w-full">

            <label>Imagen:</label>
            <input type="file" name="imagen" class="border p-2 w-full">
            <input type="hidden" name="imagen_actual" value="<?= $pizzaToEdit['imagen'] ?? '' ?>">

            <?php if (!empty($pizzaToEdit['imagen'])): ?>
                <img src="uploads/<?= $pizzaToEdit['imagen'] ?>" width="100" class="rounded">
            <?php endif; ?>

            <label>Etiqueta:</label>
            <select name="etiqueta" class="border p-2 w-full">
                <option value="">Seleccionar</option>
                <option value="nueva" <?= (isset($pizzaToEdit['etiqueta']) && $pizzaToEdit['etiqueta'] == 'nueva') ? 'selected' : '' ?>>Nueva</option>
                <option value="de temporada" <?= (isset($pizzaToEdit['etiqueta']) && $pizzaToEdit['etiqueta'] == 'de temporada') ? 'selected' : '' ?>>De temporada</option>
                <option value="en descuento" <?= (isset($pizzaToEdit['etiqueta']) && $pizzaToEdit['etiqueta'] == 'en descuento') ? 'selected' : '' ?>>En descuento</option>
            </select>


            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">
                <?= isset($pizzaToEdit) ? 'Actualizar' : 'Guardar' ?>
            </button>
        </form>


        <hr class="my-6">

        <h2 class="text-xl font-semibold mb-4">Listado de Pizzas</h2>

        <table class="min-w-full bg-white border border-gray-300 rounded overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Nombre</th>
                    <th class="py-2 px-4 border-b">Descripción</th>
                    <th class="py-2 px-4 border-b">Precio Chico</th>
                    <th class="py-2 px-4 border-b">Precio Mediano</th>
                    <th class="py-2 px-4 border-b">Precio Grande</th>
                    <th class="py-2 px-4 border-b">Imagen</th>
                    <th class="py-2 px-4 border-b">Etiqueta</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conexion.php';
                $resultado = $conn->query("SELECT * FROM pizzas");
                while ($pizza = $resultado->fetch_assoc()):
                    ?>
                    <tr class="text-center border-b">
                        <td class="py-2 px-4"><?= $pizza['id'] ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($pizza['nombre']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($pizza['descripcion']) ?></td>
                        <td class="py-2 px-4">$<?= number_format($pizza['precio_pequeno'], 2) ?></td>
                        <td class="py-2 px-4">$<?= number_format($pizza['precio_mediano'], 2) ?></td>
                        <td class="py-2 px-4">$<?= number_format($pizza['precio_grande'], 2) ?></td>
                        <td class="py-2 px-4">
                            <?php if (!empty($pizza['imagen'])): ?>
                                <img width="100" src="uploads/<?= $pizza['imagen'] ?>" class="w-20 h-auto rounded mx-auto">
                            <?php else: ?>
                                No hay imagen
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4"><?= htmlspecialchars($pizza['etiqueta']) ?></td>
                        <td class="py-2 px-4">
                            <a href="crud_pizzas.php?edit=<?= $pizza['id'] ?>"
                                class="text-blue-500 hover:underline">Editar</a>
                                <a href="#" class="text-red-500 hover:underline" onclick="eliminarPizza(<?= $pizza['id'] ?>)">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

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
        document.getElementById('formPizza').addEventListener('submit', function(e) {
    e.preventDefault(); // evitar que se recargue la página

    const form = e.target;
    const formData = new FormData(form);

    fetch('guardar_pizza.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert('Pizza guardada/actualizada exitosamente');
        window.location.reload(); // opcional: podrías actualizar solo la tabla si prefieres
    })
    .catch(err => {
        console.error('Error al guardar pizza:', err);
        alert('Hubo un error al guardar la pizza.');
    });
});
function eliminarPizza(id) {
    if (confirm('¿Estás seguro de eliminar esta pizza?')) {
        fetch('eliminar_pizza.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(response => response.text())
        .then(data => {
            // Puedes mostrar un mensaje o actualizar solo la tabla
            alert('Pizza eliminada correctamente.');
            location.reload();
        })
        .catch(error => {
            console.error('Error eliminando la pizza:', error);
        });
    }
}
</script>

</body>

</html>