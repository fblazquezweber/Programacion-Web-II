<?php
require '../conexion.php';

$conn = Database::getConnection();

try {
    $query = "SELECT h.id_hotel, h.nombre, h.ubicacion, 
                     COUNT(r.id_reserva) as total_reservas
              FROM hotel h
              LEFT JOIN reserva r ON h.id_hotel = r.id_hotel
              GROUP BY h.id_hotel
              ORDER BY total_reservas DESC";  // Ordena de mayor a menor

    $result = $conn->query($query);

    if ($result->rowCount() > 0) {
        echo '<table>
                <tr>
                    <th>Hotel</th>
                    <th>Ubicación</th>
                    <th>Total Reservas</th>
                </tr>';

        while ($row = $result->fetch()) {
            echo '<tr>
                    <td>'.$row["nombre"].'</td>
                    <td>'.$row["ubicacion"].'</td>
                    <td>'.$row["total_reservas"].'</td>
                  </tr>';
        }
        echo '</table>';
    } else {
        echo '<p class="sin-resultados">No hay reservas registradas</p>';
    }
} catch(PDOException $e) {
    echo '<p class="error-consulta">Error: '.$e->getMessage().'</p>';
}
?>