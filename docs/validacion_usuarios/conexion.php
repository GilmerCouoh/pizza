<?php
$servername = "localhost";
$username = "root"; // O el usuario que configuraste
$password = "Server123A"; // Si pusiste contraseña, agrégala aquí
$dbname = "pizzeria_db";

// Conexión a MySQL con mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>