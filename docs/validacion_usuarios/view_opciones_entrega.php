<?php
$pizza_id = $_GET['pizza_id'] ?? null;
$size = $_GET['size'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones de Entrega</title>
    <link rel="stylesheet" href="css/output.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Montagu+Slab&display=swap" rel="stylesheet">
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
    };
    </script>
</head>

<body class="bg-[#f6af89] min-h-screen">
    <header class="bg-[#f45c33] text-white p-4">
        <div class="flex justify-between items-center">
            <a href="view_user.php" class="flex items-center space-x-2">
                <img src="https://i.ibb.co/q0wGMR8/logo-pizzeria.png" alt="Logo" class="h-12">
                <span class="text-2xl font-Montagu">Maria Reyes</span>
            </a>
            <nav class="font-Montserrat hidden md:flex space-x-6">
                <a href="inicio.php" class="hover:underline">Inicio</a>
                <a href="view_menu_pizzas.php" class="hover:underline">Menú</a>
                <a href="view_pedido.php" class="hover:underline">Tu pedido</a>
            </nav>
        </div>
    </header>

    <main class="pt-16 flex flex-col items-center space-y-24">
        <h1 class="text-3xl font-bold text-white font-Montserrat">¿Cómo deseas tu pizza?</h1>
        <div class="flex justify-center space-x-16">
            <!-- A domicilio -->
            <a href="view_a_domicilio.php?pizza_id=<?= $pizza_id ?>&size=<?= $size ?>" class="flex flex-col items-center group">
                <div class="w-52 h-52 bg-white rounded-full shadow-lg flex items-center justify-center transform group-hover:scale-110 transition duration-200">
                    <img src="https://image.winudf.com/v2/image/Y29tLmNvZGVhcGlrLmFwcHMubHRyYW5zZHJpdmVyX2ljb25fMTUzNjEwMjYxM18wNzk/icon.png?w=160&fakeurl=1"
                         alt="Dibujo de moto" class="w-40 h-40">
                </div>
                <span class="text-lg font-medium mt-4 font-Montserrat">A domicilio</span>
            </a>

            <!-- Recoger en tienda -->
            <a href="view_a_establecimiento.php?pizza_id=<?= $pizza_id ?>&size=<?= $size ?>" class="flex flex-col items-center group">
                <div class="w-52 h-52 bg-white rounded-full shadow-lg flex items-center justify-center transform group-hover:scale-110 transition duration-200">
                    <img src="https://th.bing.com/th/id/R.40fa5ec46a7eb75b1dfcfc5b870067ec?rik=JwV57ExwKRc0qw&pid=ImgRaw&r=0" alt="Dibujo de tienda" class="w-40 h-40">
                </div>
                <span class="text-lg font-medium mt-4 font-Montserrat">Recoger en tienda</span>
            </a>
        </div>
    </main>
</body>
</html>
