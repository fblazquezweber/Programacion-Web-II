<?php
session_start(); // Iniciar sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear un array con los datos del paquete turístico
    $paquete = [
        'nombreHotel' => $_POST['nombreHotel'],
        'ciudad' => $_POST['ciudad'],
        'pais' => $_POST['pais'],
        'fechaViaje' => $_POST['fechaViaje'],
        'duracion' => $_POST['duracion'],
        'precio' => $_POST['precio']
    ];

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Agregar el paquete al carrito
    $_SESSION['carrito'][] = $paquete;

    // Redirigir al usuario a la página del carrito
    header('Location: ver_carrito.php');
    exit();
} else {
    echo "<p>No se enviaron datos válidos.</p>";
}
?>