<?php
session_start(); // Iniciar sesión

// Verificar si se ha solicitado vaciar el carrito
if (isset($_GET['vaciar_carrito'])) {
    $_SESSION['carrito'] = []; // Vaciar el carrito
    header('Location: ver_carrito.php'); // Redirigir para evitar reenvío del formulario
    exit();
}

// Verificar si se ha solicitado eliminar un paquete
if (isset($_GET['eliminar'])) {
    $indice = $_GET['eliminar']; // Obtener el índice del paquete a eliminar
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]); // Eliminar el paquete
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
    }
    header('Location: ver_carrito.php'); // Redirigir para evitar reenvío del formulario
    exit();
}

// Mostrar el contenido del carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>Tu carrito está vacío.</p>";
} else {
    echo "<h2>Paquetes en tu carrito:</h2>";
    echo "<ul>";
    foreach ($_SESSION['carrito'] as $indice => $paquete) {
        echo "<li>";
        echo "<strong>Hotel:</strong> " . ($paquete['nombreHotel'] ?? 'No disponible') . "<br>";
        echo "<strong>Ciudad:</strong> " . ($paquete['ciudad'] ?? 'No disponible') . "<br>";
        echo "<strong>País:</strong> " . ($paquete['pais'] ?? 'No disponible') . "<br>";
        echo "<strong>Fecha de Viaje:</strong> " . ($paquete['fechaViaje'] ?? 'No disponible') . "<br>";
        echo "<strong>Duración:</strong> " . ($paquete['duracion'] ?? 'No disponible') . " días<br>";
        echo "<strong>Precio:</strong> $" . ($paquete['precio'] ?? 'No disponible') . "<br>";
        echo "<a href='ver_carrito.php?eliminar=$indice'>Eliminar</a>"; // Enlace para eliminar el paquete
        echo "</li>";
    }
    echo "</ul>";

    // Botón para vaciar el carrito
    echo '<form method="get" action="ver_carrito.php">';
    echo '<input type="hidden" name="vaciar_carrito" value="1">';
    echo '<button type="submit">Vaciar Carrito</button>';
    echo '</form>';
}
?>