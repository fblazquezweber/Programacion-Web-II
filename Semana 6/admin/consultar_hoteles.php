<?php
require '../conexion.php';

$conn = Database::getConnection(); // Obtener la conexión

$query = "SELECT * FROM hotel";
$result = $conn->query($query);

if ($result->rowCount() > 0) { // Usar rowCount() en PDO
    echo '<table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Habitaciones Disponibles</th>
                <th>Tarifa por Noche</th>
            </tr>';

    while ($row = $result->fetch()) { // Usar fetch() en PDO
        echo '<tr>
                <td>'.$row["id_hotel"].'</td>
                <td>'.$row["nombre"].'</td>
                <td>'.$row["ubicacion"].'</td>
                <td>'.$row["habitaciones_disponibles"].'</td>
                <td>$'.number_format($row["tarifa_noche"], 2).'</td>
              </tr>';
    }
    echo '</table>';
} else {
    echo '<p class="sin-resultados">No hay hoteles registrados</p>';
}
?>



