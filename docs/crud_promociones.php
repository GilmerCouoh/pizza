<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado.";
    exit;
}
?>

<h2>CRUD de [Recurso]</h2>
<p>En esta sección podrás administrar los [usuarios/pizzas/pedidos/promociones].</p>
