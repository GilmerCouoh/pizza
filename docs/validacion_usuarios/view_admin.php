<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso restringido. No eres administrador.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        .menu {
            margin-top: 20px;
        }
        .menu a {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
            color: #0066cc;
            text-decoration: none;
        }
        .menu a:hover {
            text-decoration: underline;
        }
    </style>
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
<body>
<header class="bg-[#f45c33] text-white p-4">
        <div class="flex justify-between items-center">
            <a href="#" class="flex items-center space-x-2">
                <img src="https://i.ibb.co/q0wGMR8/logo-pizzeria.png" alt="Logo MariaReyes" class="h-12">
                <span class="text-2xl font-Montagu">Maria Reyes</span>
            </a>
        </div>
</header>
<section class="mt-16 bg-[#f45c33] p-8 rounded-2xl shadow-md">
<h1 class="text-center text-4xl  font-Montagu font-bold  m-12 text-white">Bienvenido administrador <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
</section>

<section class="bg-[#fff3ef] rounded-2xl shadow-md p-8 ml-80 mt-16 mr-80">
<div class="menu font-monserrat text-center">
    <h2 class="text-center text-3xl"> Menú de Gestión</h2>
    <a href="crud_usuarios.php" class="text-blue-600 visited:text-black"> CRUD de Usuarios</a>
    <a href="crud_pizzas.php" class="text-blue-600 visited:text-black"> CRUD de Pizzas</a>
    <a href="crud_pedidos.php" class="text-blue-600 visited:text-black"> CRUD de Pedidos</a>
    <a href="crud_promociones.php" class="text-blue-600 visited:text-black">CRUD de Promociones</a>
</div>
</section>
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

