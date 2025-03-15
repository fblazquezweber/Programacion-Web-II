<?php
// Incluir la clase de filtrado
include 'filtroviaje.php';

// Inicializar la lista de viajes (normalmente estos datos vendrían de una base de datos)
$viajes = [
    new FiltroViaje('Hotel Sol', 'Barcelona', 'España', '2025-06-15', 7),
    new FiltroViaje('Playa Mar', 'Cancún', 'México', '2025-07-01', 5),
    new FiltroViaje('Grand Palace', 'París', 'Francia', '2025-06-20', 10)
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
    <title>Agencia de Viajes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Bienvenido a la Agencia de Viajes</h1>
</header>

<!-- Formulario para registrar viaje -->
<div class="contenedor_registro">
    <h2>Registrar un Nuevo Viaje</h2>
    <form method="post" action="procesar.php">
        <input type="text" name="nombreHotel" placeholder="Nombre del Hotel" required>
        <input type="text" name="ciudad" placeholder="Ciudad" required>
        <input type="text" name="pais" placeholder="País" required>
        <input type="date" name="fechaViaje" required>
        <input type="number" name="duracion" placeholder="Duración (días)" min="1" required>
        <button type="submit">Registrar</button>
    </form>
</div>

<!-- Formulario de búsqueda -->
<div class="contenedor_busqueda">
    <h2>Buscar Viajes</h2>
    <form method="get" action="index.php">
        <input type="text" name="pais" placeholder="País" value="<?= isset($criterios['pais']) ? $criterios['pais'] : '' ?>">
        <input type="text" name="ciudad" placeholder="Ciudad" value="<?= isset($criterios['ciudad']) ? $criterios['ciudad'] : '' ?>">
        <input type="text" name="nombreHotel" placeholder="Hotel" value="<?= isset($criterios['nombreHotel']) ? $criterios['nombreHotel'] : '' ?>">
        <input type="date" name="fechaViaje" value="<?= isset($criterios['fechaViaje']) ? $criterios['fechaViaje'] : '' ?>">
        <input type="number" name="duracion" placeholder="Duración (días)" value="<?= isset($criterios['duracion']) ? $criterios['duracion'] : '' ?>">
        <button type="submit">Buscar</button>
    </form>
</div>

<!-- Mostrar resultados de búsqueda -->
<div id="contenedor-resultado">
    <h2>Resultados de la búsqueda</h2>
    <?php if (count($resultados) > 0): ?>
        <div class="resultados">
            <?php foreach ($resultados as $viaje): ?>
                <div class="resultado">
                    <h3><?= $viaje->nombreHotel ?></h3>
                    <p><strong>Ciudad:</strong> <?= $viaje->ciudad ?></p>
                    <p><strong>País:</strong> <?= $viaje->pais ?></p>
                    <p><strong>Fecha de Viaje:</strong> <?= $viaje->fechaViaje ?></p>
                    <p><strong>Duración:</strong> <?= $viaje->duracion ?> días</p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No se han encontrado resultados que coincidan con tu búsqueda.</p>
    <?php endif; ?>
</div>
</body>
</html>
