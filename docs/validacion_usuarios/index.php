<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario Maria Reyes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f6af89] min-h-screen flex items-center justify-center relative">

    <!-- Botón de regresar al login -->
    <div class="absolute top-4 right-4">
        <a href="/view_login.php"
           class="bg-[#f45c33] text-white font-semibold py-2 px-4 rounded-lg hover:underline">
            Volver al Login
        </a>
    </div>

    <!-- Contenedor del formulario -->
    <div class="bg-[#e9e9e9] p-8 rounded-lg shadow-md w-80">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Registro de usuario</h2>

        <form id="registroForm" onsubmit="registrarUsuario(event)" class="space-y-4">

            <!-- Usuario -->
            <div>
                <label for="usuario" class="block text-sm font-medium text-gray-700">Usuario</label>
                <input type="text" id="usuario" name="usuario" required
                       class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <span id="usuarioError" class="text-red-500 text-sm font-semibold"></span>
            </div>

            <!-- Correo -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
                <input type="email" id="email" name="email" required
                       class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <span id="emailError" class="text-red-500 text-sm font-semibold"></span>
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" required
                       class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Botón -->
            <div>
                <button type="submit"
                        class="w-full bg-[#f45c33] text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Registrar
                </button>
            </div>

            <!-- Éxito -->
            <div id="usuarioSuccess" class="text-green-600 text-sm font-semibold text-center"></div>
        </form>
    </div>

    <script src="validar_usuario.js"></script>
</body>
</html>