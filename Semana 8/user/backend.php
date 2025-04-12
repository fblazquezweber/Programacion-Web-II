<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/../conexion.php'; // Ruta correcta

try {
    $conn = Database::getConnection();
    
    $tipo = $_GET['tipo'] ?? 'todos';
    $resultados = [];
    
    if ($tipo === 'todos' || $tipo === 'vuelos') {
        $stmt = $conn->query("SELECT id_vuelo, origen, destino, fecha, plazas_disponibles, precio FROM vuelo");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['tipo'] = 'vuelo';
            $resultados[] = $row;
        }
    }
    
    if ($tipo === 'todos' || $tipo === 'hoteles') {
        $stmt = $conn->query("SELECT id_hotel, nombre, ubicacion, habitaciones_disponibles, tarifa_noche FROM hotel");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['tipo'] = 'hotel';
            $resultados[] = $row;
        }
    }
    
    echo json_encode([
        'success' => true,
        'data' => $resultados,
        'count' => count($resultados)
    ]);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>