<?php
// Conexión a la base de datos (ajusta con tus credenciales)
$mysqli = new mysqli("localhost", "root", "Server123A", "pizzeria_db");

// Verifica conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Obtener las pizzas
$query = "SELECT * FROM pizzas";
$result = $mysqli->query($query);

$pizzas = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pizzas[] = $row;
    }
}

// Función para obtener clases de Tailwind según la etiqueta
function obtenerClasesEtiqueta($etiqueta) {
    switch (strtolower($etiqueta)) {
        case 'nueva':
            return 'bg-green-100 text-green-800';
        case 'de temporada':
            return 'bg-yellow-100 text-yellow-800';
        case 'en descuento':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Menú</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
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

<body class="bg-white">
    <header class="bg-[#f45c33] text-white p-4">
        <div class="flex justify-between items-center">
            <a href="view_user.php" class="flex items-center space-x-2">
                <img src="https://i.ibb.co/q0wGMR8/logo-pizzeria.png" alt="Logo MariaReyes" class="h-12">
                <span class="text-2xl font-Montagu">Maria Reyes</span>
            </a>
            <nav class="font-Montserrat hidden md:flex space-x-6">
                <a href="view_user.php" class="hover:underline">Inicio</a>
                <a href="view_menu_pizzas.php" class="hover:underline">Menú</a>
                <a href="view_pedido.php" class="hover:underline">Tu pedido</a>
            </nav>
        </div>
    </header>

    <main class="px-4 py-6">
        <h1 class="text-3xl font-Montagu mb-6">Menú de Pizzas</h1>
        <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($pizzas as $pizza): ?>
            <div class="bg-[#e9e9e9] rounded-lg shadow-md overflow-hidden">
                <img class="w-full h-64 object-cover"
                    src="<?= $pizza['imagen'] ? 'uploads/' . $pizza['imagen'] : 'https://i.ibb.co/DLkj9YK/12.jpg' ?>"
                    alt="<?= htmlspecialchars($pizza['nombre']) ?>">

                <div class="p-4">
                    <h2 class="text-xl font-Montserrat font-bold"><?= htmlspecialchars($pizza['nombre']) ?></h2>
                    <p class="text-gray-700"><?= htmlspecialchars($pizza['descripcion']) ?></p>
                    <p class="mt-2 text-gray-800 font-semibold">Precio Pequeño: $<?= $pizza['precio_pequeno'] ?></p>
                    <p class="text-gray-800 font-semibold">Precio Mediano: $<?= $pizza['precio_mediano'] ?></p>
                    <p class="text-gray-800 font-semibold">Precio Grande: $<?= $pizza['precio_grande'] ?></p>

                    <?php if (!empty($pizza['etiqueta'])): ?>
                        <span class="inline-block text-xs px-2 py-1 mb-2 rounded-full uppercase font-semibold tracking-wide <?= obtenerClasesEtiqueta($pizza['etiqueta']) ?>">
                            <?= htmlspecialchars($pizza['etiqueta']) ?>
                        </span>
                    <?php endif; ?>

                    <label for="size-<?= $pizza['id'] ?>" class="block mt-2 text-gray-700">Selecciona el tamaño:</label>
                    <select id="size-<?= $pizza['id'] ?>" class="w-full p-2 border rounded-lg mb-4">
                        <option value="pequeno">Pequeño</option>
                        <option value="mediano">Mediano</option>
                        <option value="grande">Grande</option>
                    </select>

                    <button onclick="orderPizza(<?= $pizza['id'] ?>)"
                        class="bg-[#ec7433] text-white w-full p-2 rounded-lg hover:bg-[#f45c33] font-Montserrat font-semibold">
                        Ordena ahora
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-[#f45c33] text-white text-center py-6 mt-10">
        <p>© 2024 Maria Reyes - Todos los derechos reservados</p>
        <div class="mt-2">
            <a href="#" class="mx-2 hover:underline">Política de privacidad</a>
            <a href="#" class="mx-2 hover:underline">Términos de uso</a>
            <a href="#" class="mx-2 hover:underline">Contacto</a>
        </div>
    </footer>

    <script>
    function orderPizza(pizzaId) {
        const size = document.getElementById(`size-${pizzaId}`).value;
        window.location.href = `view_opciones_entrega.php?pizza_id=${pizzaId}&size=${size}`;
    }
    </script>
</body>

</html>
