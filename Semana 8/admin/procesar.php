<?php
require '../conexion.php';

$conn = Database::getConnection(); // Obtiene la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST["tipo"];
    
    if ($tipo == "vuelo") {
        $origen = $_POST["origen"];
        $destino = $_POST["destino"];
        $fecha = $_POST["fecha"];
        $plazas = $_POST["plazas"];
        $precio = $_POST["precio"];
        
        $sql = "INSERT INTO vuelo (origen, destino, fecha, plazas_disponibles, precio) 
                VALUES ('$origen', '$destino', '$fecha', $plazas, $precio)";
        
    } elseif ($tipo == "hotel") {
        $nombre = $_POST["nombre"];
        $ubicacion = $_POST["ubicacion"];
        $habitaciones = $_POST["habitaciones"];
        $tarifa = $_POST["tarifa"];
        
        $sql = "INSERT INTO hotel (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) 
                VALUES ('$nombre', '$ubicacion', $habitaciones, $tarifa)";
    }

    try {
        $conn->query($sql);
        header("Location: gestion.php?success=1");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
