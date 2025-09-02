<?php 
// view_pedido.php
$pizza_id = $_POST['pizza_id'] ?? null;
$size = $_POST['size'] ?? null;
$name = $_POST['fname'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$reference = $_POST['reference'] ?? '';
$entrega = strtolower($_POST['entrega'] ?? '');
$cantidad = intval($_POST['cantidad'] ?? 1);

$mysqli = new mysqli("localhost", "root", "Server123A", "pizzeria_db");
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("SELECT * FROM pizzas WHERE id = ?");
$stmt->bind_param("i", $pizza_id);
$stmt->execute();
$result = $stmt->get_result();
$pizza = $result->fetch_assoc();
$stmt->close();

$precio = 0;
$total = 0;
if ($size && $pizza) {
    $precio = $pizza["precio_$size"];
    $total = $precio * $cantidad;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function actualizarTotal(precioUnitario) {
            const cantidadInput = document.getElementById('cantidad');
            const totalSpan = document.getElementById('total');
            const hiddenTotal = document.getElementById('total_hidden');
            cantidadInput.addEventListener('input', function () {
                const cantidad = parseInt(this.value) || 1;
                const nuevoTotal = precioUnitario * cantidad;
                totalSpan.textContent = '$' + nuevoTotal.toFixed(2);
                hiddenTotal.value = nuevoTotal.toFixed(2);
            });
        }
    </script>
</head>
<body class="bg-gray-100 p-6" onload="actualizarTotal(<?php echo $precio; ?>)">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-green-700">Resumen del Pedido</h1>

        <?php if ($pizza): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <img src="uploads/<?php echo $pizza['imagen']; ?>" alt="<?php echo $pizza['nombre']; ?>" class="w-full rounded-lg shadow">
                </div>
                <div>
                    <h2 class="text-2xl font-semibold mb-2"><?php echo $pizza['nombre']; ?></h2>
                    <p class="mb-1">Tamaño: <span class="font-medium"><?php echo ucfirst($size); ?></span></p>

                    <form id="form_confirmar" action="procesar_pedido.php" method="POST">
                        <div class="mb-2">
                            <label for="cantidad" class="font-medium">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" min="1" value="<?php echo $cantidad; ?>" class="border rounded px-2 py-1 w-20 ml-2">
                        </div>

                        <p class="mb-1">Precio unitario: <span class="font-bold text-green-700">$<?php echo number_format($precio, 2); ?></span></p>
                        <p class="mb-1">Total: <span id="total" class="font-bold text-green-900 text-lg">$<?php echo number_format($total, 2); ?></span></p>

                        <p class="mt-4 text-gray-700"><?php echo $pizza['descripcion']; ?></p>

                        <div class="border-t pt-4 mt-4">
                            <h3 class="text-xl font-semibold mb-3">Datos de Entrega</h3>
                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($name); ?></p>
                            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($phone); ?></p>
                            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($address); ?></p>
                            <p><strong>Referencia:</strong> <?php echo htmlspecialchars($reference); ?></p>
                        </div>

                        <!-- Campos ocultos -->
                        <input type="hidden" name="pizza_id" value="<?php echo $pizza_id; ?>">
                        <input type="hidden" name="size" value="<?php echo $size; ?>">
                        <input type="hidden" name="fname" value="<?php echo htmlspecialchars($name); ?>">
                        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                        <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
                        <input type="hidden" name="reference" value="<?php echo htmlspecialchars($reference); ?>">
                        <input type="hidden" name="entrega" value="<?php echo $entrega; ?>">
                        <input type="hidden" name="precio" value="<?php echo $precio; ?>">
                        <input type="hidden" id="total_hidden" name="total" value="<?php echo $total; ?>">

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                                Confirmar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p class="text-red-600 text-center">No se encontró la pizza seleccionada.</p>
        <?php endif; ?>
    </div>
</body>
</html>
