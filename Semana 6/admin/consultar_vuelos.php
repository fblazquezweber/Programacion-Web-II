<?php
require '../conexion.php'; // Asegúrate de que el archivo esté en la ruta correcta

try {
    $conn = Database::getConnection(); // Obtener la conexión con PDO

    $query = "SELECT id_vuelo, origen, destino, fecha, plazas_disponibles, precio FROM vuelo ORDER BY fecha ASC";
    $stmt = $conn->query($query); // Ejecutar la consulta con PDO
    
    echo '<div class="tabla-resultados">';
    
    if ($stmt->rowCount() > 0) { // rowCount() en lugar de num_rows
        echo '<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th>Plazas Disponibles</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>';
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // fetch() en lugar de fetch_assoc()
            echo '<tr>
                    <td>'.htmlspecialchars($row["id_vuelo"]).'</td>
                    <td>'.htmlspecialchars($row["origen"]).'</td>
                    <td>'.htmlspecialchars($row["destino"]).'</td>
                    <td>'.htmlspecialchars($row["fecha"]).'</td>
                    <td>'.htmlspecialchars($row["plazas_disponibles"]).'</td>
                    <td>$'.number_format(floatval($row["precio"]), 2).'</td>
                  </tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<p class="sin-resultados">No hay vuelos registrados actualmente</p>';
    }
    
    echo '</div>';
    
} catch (Exception $e) {
    echo '<p class="error-consulta">Error al cargar los datos: '.htmlspecialchars($e->getMessage()).'</p>';
}
?>
