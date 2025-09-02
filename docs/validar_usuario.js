document.getElementById('usuario').addEventListener('input', function () {
    const usuario = this.value.trim();
    const usuarioError = document.getElementById('usuarioError');

    if (usuario === "") {
        usuarioError.textContent = "El nombre de usuario no puede estar vacío.";
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'validar_usuario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            usuarioError.textContent = respuesta.usuario_disponible
                ? "✅ Usuario disponible" : "❌ El usuario no está disponible";
            usuarioError.style.color = respuesta.usuario_disponible ? "green" : "red";
        }
    };
    xhr.send('usuario=' + encodeURIComponent(usuario));
});

function registrarUsuario(event) {
    event.preventDefault();

    const usuario = document.getElementById('usuario').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const usuarioError = document.getElementById('usuarioError');
    const emailError = document.getElementById('emailError');
    const usuarioSuccess = document.getElementById('usuarioSuccess');

    if (usuario === "" || email === "" || password === "") {
        usuarioError.textContent = "Todos los campos son obligatorios.";
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'registrar_usuario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.success) {
                usuarioSuccess.textContent = "🎉 " + respuesta.success;
                usuarioError.textContent = "";
                emailError.textContent = "";
                document.getElementById('registroForm').reset();
            } else {
                usuarioError.textContent = respuesta.error_usuario || "";
                emailError.textContent = respuesta.error_email || "";
            }
        }
    };

    xhr.send(`usuario=${encodeURIComponent(usuario)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`);
}
