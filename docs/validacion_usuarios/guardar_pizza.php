<?php
include 'conexion.php';

$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio_pequeno = $_POST['precio_pequeno'];
$precio_mediano = $_POST['precio_mediano'];
$precio_grande = $_POST['precio_grande'];
$etiqueta = $_POST['etiqueta'] ?? null;

// Validación de precios
if ($precio_pequeno > 99999999.99 || $precio_mediano > 99999999.99 || $precio_grande > 99999999.99) {
    die("Uno de los precios es demasiado alto. Intenta con un número menor.");
}



// Procesar imagen si se subió
$imagenNombre = $_POST['imagen_actual'] ?? null; // Imagen actual por defecto

if (!empty($_FILES['imagen']['name'])) {
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $imagenNombre = uniqid() . "_" . basename($_FILES['imagen']['name']);
    $rutaDestino = "uploads/$imagenNombre";

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        die("Error al mover la imagen al servidor.");
    }
}


if ($id) {
    // Actualizar
    $sql = "UPDATE pizzas SET nombre=?, descripcion=?, precio_pequeno=?, precio_mediano=?, precio_grande=?, etiqueta=?";
    if ($imagenNombre) {
        $sql .= ", imagen=?";
    }
    $sql .= " WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($imagenNombre) {
        $stmt->bind_param("ssdddssi", $nombre, $descripcion, $precio_pequeno, $precio_mediano, $precio_grande, $etiqueta, $imagenNombre, $id);
    } else {
        $stmt->bind_param("ssddddi", $nombre, $descripcion, $precio_pequeno, $precio_mediano, $precio_grande, $etiqueta, $id);
    }
} else {
    // Insertar nuevo
    $stmt = $conn->prepare("INSERT INTO pizzas (nombre, descripcion, precio_pequeno, precio_mediano, precio_grande, imagen, etiqueta) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdddss", $nombre, $descripcion, $precio_pequeno, $precio_mediano, $precio_grande, $imagenNombre, $etiqueta);
}

$stmt->execute();
echo "ok";
