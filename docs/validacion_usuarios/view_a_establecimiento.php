<?php
$pizza_id = $_GET['pizza_id'] ?? '';
$size = $_GET['size'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido en tienda</title>
    <link rel="stylesheet" href="css/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montagu+Slab:opsz@16..144&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        Montagu: ["Montagu Slab"],
                        Montserrat: ["Montserrat"],
                    },
                },
            },
        };
    </script>
</head>

<body class="bg-[#f6af89] min-h-screen">
    <div>
        <!-- Header -->
        <header class="bg-[#f45c33] text-gray-50 font-medium">
            <div class="flex justify-between items-center p-4">
                <div id="logo" class="flex items-center">
                    <a href="view_user.php">
                        <img src="https://i.ibb.co/q0wGMR8/logo-pizzeria.png" alt="Logo MariaReyes" class="h-12">
                    </a>
                    <span class="ml-2 text-2xl font-Montagu">Maria Reyes</span>
                </div>

                <nav id="MainNav" class="hidden lg:block font-Montserrat">
                    <ul class="flex flex-col lg:flex-row lg:space-x-6 lg:justify-end">
                        <li><a href="index.php" class="block py-2 hover:border-b-4 border-b-orange-700">Inicio</a></li>
                        <li><a href="menu.php" class="block py-2 hover:border-b-4 border-b-orange-700">Menu</a></li>
                        <li><a href="pedido.php" class="block py-2 hover:border-b-4 border-b-orange-700">Tu pedido</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Formulario -->
        <form action="view_pedido.php" method="POST"
            class="max-w-xl mx-auto my-7 bg-[#e9e9e9] p-6 rounded-md shadow-lg font-Montserrat">

            <!-- Datos visibles -->
            <div class="mb-4">
                <label for="fname" class="block mb-2 font-medium">Nombre</label>
                <input type="text" id="fname" name="fname" class="w-full px-4 py-2 rounded-md bg-[#bebdbd]" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block mb-2 font-medium">Número de teléfono</label>
                <input type="text" id="phone" name="phone" class="w-full px-4 py-2 rounded-md bg-[#bebdbd]" required>
            </div>

            <!-- Mapa -->
            <div class="mb-4">
                <h2 class="font-bold text-lg">Nuestra ubicación</h2>
                <iframe class="w-full h-64 rounded-md"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1861.279872665679!2d-89.294145!3d21.090239!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f56827788fb6af9%3A0xe18234f1ebcfa614!2sPizzer%C3%ADa%20Maria%20Reyes!5e0!3m2!1ses!2smx!4v1733168700255!5m2!1ses!2smx"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!-- Datos ocultos -->
            <input type="hidden" name="pizza_id" value="<?php echo htmlspecialchars($pizza_id); ?>">
            <input type="hidden" name="size" value="<?php echo htmlspecialchars($size); ?>">
            <input type="hidden" name="address" value="En el establecimiento">
            <input type="hidden" name="reference" value="En el establecimiento">
            <input type="hidden" name="entrega" value="establecimiento">

            <div class="text-center">
                <button type="submit" class="bg-[#ec7433] rounded-md hover:bg-[#f45c33] px-8 py-2 font-bold text-white">
                    Ordenar
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-[#f45c33] text-gray-50 py-8">
        <div class="container mx-auto text-center">
            <p class="mb-4">© 2024 Maria Reyes Todos los derechos reservados</p>
            <div class="flex justify-center space-x-4 mb-4">
                <a href="https://www.facebook.com/MariaReyespizzeria/?locale=es_LA" class="hover:underline">Facebook</a>
                <a href="https://www.instagram.com/mariareyes7334/" class="hover:underline">Instagram</a>
            </div>
            <div class="flex justify-center space-x-6">
                <a href="#" class="hover:underline">Política de privacidad</a>
                <a href="#" class="hover:underline">Términos de uso</a>
                <a href="#" class="hover:underline">Contacto</a>
            </div>
        </div>
    </footer>
</body>
</html>
