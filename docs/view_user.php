<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'user') {
    echo "Acceso restringido. No eres usuario regular.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio Maria Reyes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/output.css">

    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    Montagu: ["'Montagu Slab'", "serif"],
                    Montserrat: ["'Montserrat'", "sans-serif"]
                },
                colors: {
                    verdin: "#00b894"
                }
            }
        }
    }
    </script>
</head>

<body class="bg-white font-Montserrat">
    <header class="bg-[#f45c33] text-white p-4 shadow-md">
        <div class="flex justify-between items-center container mx-auto">
            <a href="view_user.php" class="flex items-center space-x-2">
                <img src="https://i.ibb.co/q0wGMR8/logo-pizzeria.png" alt="Logo MariaReyes" class="h-12">
                <span class="text-2xl font-Montagu">Maria Reyes</span>
            </a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="view_user.php" class="hover:underline">Inicio</a>
                <a href="view_menu_pizzas.php" class="hover:underline">Menú</a>
                <a href="view_pedido.php" class="hover:underline">Tu pedido</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-12 px-4">
        <h1 class="text-6xl text-center font-Montagu leading-tight mb-8">
            La mejor pizza de Motul<br>
            hasta la puerta de tu casa <span class="text-[#f45c33]">¡ordena YA!</span>
        </h1>

        <div class="text-center space-x-4 my-4">
            <a href="view_menu_pizzas.php"
                class="bg-[#f45c33] text-white px-6 py-2 rounded-full font-Montserrat shadow-md hover:bg-orange-600 transition">
                Ver menú
            </a>
            <a href="logout.php"
                class="bg-gray-200 text-[#f45c33] px-6 py-2 rounded-full font-Montserrat shadow-md hover:bg-gray-300 transition">
                Cerrar sesión
            </a>
        </div>

<!-- Galería -->
<section class="mt-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="overflow-hidden rounded-xl shadow-lg h-[300px] w-full">
            <img src="https://i.ibb.co/r7QQPpb/16.jpg" alt="MariaReyes2"
                class="w-full h-full object-cover hover:scale-105 transition duration-300">
        </div>
        <div class="overflow-hidden rounded-xl shadow-lg h-[300px] w-full">
            <img src="https://i.ibb.co/xGf7tm0/1.jpg" alt="MariaReyes1"
                class="w-full h-full object-cover hover:scale-105 transition duration-300">
        </div>
        <div class="overflow-hidden rounded-xl shadow-lg h-[300px] w-full">
            <img src="https://i.ibb.co/q7KccnG/9.jpg" alt="MariaReyes3"
                class="w-full h-full object-cover hover:scale-105 transition duration-300">
        </div>
    </div>
</section>


        <!-- Promociones -->
        <section class="mt-16 bg-[#fff3ef] p-8 rounded-2xl shadow-md">
            <h2 class="text-4xl font-Montagu text-[#f45c33] mb-6">Promociones</h2>
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden flex flex-col md:flex-row">
                <img class="w-full md:w-1/2 object-cover" src="https://i.ibb.co/DLkj9YK/12.jpg" alt="Promo pizza">
                <div class="p-6">
                    <h3 class="text-2xl font-Montserrat text-[#f45c33]">Promo x</h3>
                    <p class="font-Montserrat mt-2 text-gray-700">
                        ¡Aprovecha nuestra promo especial de esta semana! Llévate 2 pizzas familiares por solo $199. 🍕🔥
                    </p>
                </div>
            </div>
        </section>
    </main>

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