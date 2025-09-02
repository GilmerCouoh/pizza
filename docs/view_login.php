<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f6af89] min-h-screen flex items-center justify-center relative">

    <!-- Botón de registrarse -->
    <div class="absolute top-4 right-4">
        <a href="index.php"
           class="bg-[#f45c33] text-white font-semibold hover:underline py-2 px-4 rounded-lg">
            Registrarse
        </a>
    </div>

    <!-- Contenedor principal -->
    <div class="flex flex-col items-center">

        <!-- Logo (opcional, puedes quitarlo si no usas imagen) -->
        <img src="https://i.postimg.cc/3NY25rCG/logo.png" alt="logo pizza" class="mb-6 w-64 h-auto">

        <!-- Formulario de login -->
        <div class="bg-[#e9e9e9] p-8 rounded-lg shadow-md w-80">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Inicia Sesión</h2>

            <form id="loginForm" onsubmit="loginUsuario(event)" class="space-y-4">

                <!-- Usuario -->
                <div>
                    <label for="usuario" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required
                           class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
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
                        Iniciar sesión
                    </button>
                </div>

                <!-- Mensaje de respuesta -->
                <div id="loginMensaje" class="text-center text-sm font-semibold mt-2"></div>
            </form>

    <script>
        function loginUsuario(event) {
            event.preventDefault();

            const usuario = document.getElementById('usuario').value.trim();
            const password = document.getElementById('password').value.trim();
            const loginMensaje = document.getElementById('loginMensaje');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'procesar_login.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.success) {
                        loginMensaje.style.color = "green";
                        loginMensaje.textContent = "✅ " + respuesta.success;

                        // Redirigir según el rol
                        if (respuesta.role === 'admin') {
                            window.location.href = "view_admin.php";
                        } else {
                            window.location.href = "view_user.php";
                        }
                    } else {
                        loginMensaje.style.color = "red";
                        loginMensaje.textContent = "❌ " + respuesta.error;
                    }
                }
            };

            xhr.send(`usuario=${encodeURIComponent(usuario)}&password=${encodeURIComponent(password)}`);
        }
    </script>

</body>

</html>