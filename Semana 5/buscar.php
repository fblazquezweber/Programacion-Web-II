<?php
session_start(); // Iniciar sesión

// Incluir la clase de filtrado
include 'filtroviaje.php';

// Inicializar la lista de viajes (normalmente estos datos vendrían de una base de datos)
$viajes = [
    new FiltroViaje('Hotel Sol', 'Barcelona', 'España', '2025-06-15', 7, 1200),
    new FiltroViaje('Playa Mar', 'Cancún', 'México', '2025-07-01', 5, 1500),
    new FiltroViaje('Grand Palace', 'París', 'Francia', '2025-06-20', 10, 2000),
    new FiltroViaje('Four Seasons', 'Madrid', 'España', '2025-06-21', 10, 2000),
    new FiltroViaje('The Ritz', 'Londres', 'Reino Unido', '2025-07-15', 5, 1500),
    new FiltroViaje('Hotel de Crillon', 'París', 'Francia', '2025-08-10', 7, 1800),
    new FiltroViaje('Hotel Sacher', 'Viena', 'Austria', '2025-09-05', 6, 1700),
    new FiltroViaje('Hotel Arts', 'Barcelona', 'España', '2025-06-30', 4, 1600),
    new FiltroViaje('Grand Hotel', 'Oslo', 'Noruega', '2025-07-20', 8, 2200)
];

// Obtener criterios de búsqueda desde el formulario
$criterios = [
    'pais' => isset($_GET['pais']) ? $_GET['pais'] : '',
    'ciudad' => isset($_GET['ciudad']) ? $_GET['ciudad'] : '',
    'nombreHotel' => isset($_GET['nombreHotel']) ? $_GET['nombreHotel'] : '',
    'fechaViaje' => isset($_GET['fechaViaje']) ? $_GET['fechaViaje'] : '',
    'duracion' => isset($_GET['duracion']) ? $_GET['duracion'] : ''
];

// Filtrar viajes según los criterios ingresados
$resultados = FiltroViaje::filtrarViajes($viajes, $criterios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Resultados de Búsqueda</h1>
</header>

<!-- Mostrar resultados de búsqueda -->
<div id="contenedor-resultado">
    <h2>Resultados de la búsqueda</h2>
    <?php if (count($resultados) > 0): ?>
        <div class="resultados">
            <?php foreach ($resultados as $viaje): ?>
                <div class="resultado">
                    <h3><?= htmlspecialchars($viaje->nombreHotel) ?></h3>
                    <p><strong>Ciudad:</strong> <?= htmlspecialchars($viaje->ciudad) ?></p>
                    <p><strong>País:</strong> <?= htmlspecialchars($viaje->pais) ?></p>
                    <p><strong>Fecha de Viaje:</strong> <?= htmlspecialchars($viaje->fechaViaje) ?></p>
                    <p><strong>Duración:</strong> <?= htmlspecialchars($viaje->duracion) ?> días</p>
                    <p><strong>Precio:</strong> $<?= htmlspecialchars($viaje->precio) ?></p> <!-- Mostrar el precio -->
                    <form method="post" action="agregar_carrito.php">
                        <input type="hidden" name="nombreHotel" value="<?= htmlspecialchars($viaje->nombreHotel) ?>">
                        <input type="hidden" name="ciudad" value="<?= htmlspecialchars($viaje->ciudad) ?>">
                        <input type="hidden" name="pais" value="<?= htmlspecialchars($viaje->pais) ?>">
                        <input type="hidden" name="fechaViaje" value="<?= htmlspecialchars($viaje->fechaViaje) ?>">
                        <input type="hidden" name="duracion" value="<?= htmlspecialchars($viaje->duracion) ?>">
                        <input type="hidden" name="precio" value="<?= htmlspecialchars($viaje->precio) ?>"> <!-- Agregar el precio al formulario -->
                        <button type="submit">Agregar al carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No se han encontrado resultados que coincidan con tu búsqueda.</p>
    <?php endif; ?>
</div>

<!-- Enlace para volver a la página principal -->
<div class="volver">
    <a href="index.html">Volver a la página principal</a>
</div>

</body>
</html>