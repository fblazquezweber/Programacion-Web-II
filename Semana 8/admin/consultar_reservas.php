<?php
require '../conexion.php';

$conn = Database::getConnection(); // Obtener la conexión

// Consulta para obtener las reservas
$query = "SELECT r.id_reserva, c.nombre AS cliente, v.origen AS vuelo_origen, v.destino AS vuelo_destino, h.nombre AS hotel, r.fecha_reserva
          FROM reserva r
          LEFT JOIN cliente c ON r.id_cliente = c.id_cliente
          LEFT JOIN vuelo v ON r.id_vuelo = v.id_vuelo
          LEFT JOIN hotel h ON r.id_hotel = h.id_hotel";

$result = $conn->query($query);

if ($result->rowCount() > 0) { // Usar rowCount() en PDO
    echo '<table>
            <tr>
                <th>ID Reserva</th>
                <th>Cliente</th>
                <th>Vuelo Origen</th>
                <th>Vuelo Destino</th>
                <th>Hotel</th>
                <th>Fecha de Reserva</th>
            </tr>';

    while ($row = $result->fetch()) { // Usar fetch() en PDO
        echo '<tr>
                <td>'.$row["id_reserva"].'</td>
                <td>'.$row["cliente"].'</td>
                <td>'.$row["vuelo_origen"].'</td>
                <td>'.$row["vuelo_destino"].'</td>
                <td>'.$row["hotel"].'</td>
                <td>'.$row["fecha_reserva"].'</td>
              </tr>';
    }
    echo '</table>';
} else {
    echo '<p class="sin-resultados">No hay reservas registradas</p>';
}
?>
