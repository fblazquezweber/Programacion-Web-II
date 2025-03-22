<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreHotel = htmlspecialchars($_POST["nombreHotel"]);
    $ciudad = htmlspecialchars($_POST["ciudad"]);
    $pais = htmlspecialchars($_POST["pais"]);
    $fechaViaje = htmlspecialchars($_POST["fechaViaje"]);
    $duracion = htmlspecialchars($_POST["duracion"]);

    echo "<h1>Detalles de tu viaje</h1>";
    echo "<p><strong>Hotel:</strong> $nombreHotel</p>";
    echo "<p><strong>Ciudad:</strong> $ciudad</p>";
    echo "<p><strong>País:</strong> $pais</p>";
    echo "<p><strong>Fecha de Viaje:</strong> $fechaViaje</p>";
    echo "<p><strong>Duración:</strong> $duracion días</p>";
} else {
    echo "<p>No se enviaron datos válidos.</p>";
}
?>