<?php
// Esto debe ser lo PRIMERO en el archivo
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Activar buffer para capturar posibles errores
ob_start();

session_start(); // Iniciar la sesión

try {
    // Verifica que la sesión esté activa y que id_cliente esté definido
    if (!isset($_SESSION['id_cliente'])) {
        throw new Exception('Usuario no autenticado', 401);
    }

    $id_cliente = $_SESSION['id_cliente']; // Obtén el ID del cliente desde la sesión

    // Verifica que el ID del cliente sea un valor válido
    if (empty($id_cliente) || !is_numeric($id_cliente)) {
        throw new Exception('ID de cliente inválido', 400);
    }

    require_once __DIR__.'/conexion_user.php';
    
    // Verificar conexión
    $pdo = PDOConnection::getConnection();
    if (!$pdo) {
        throw new Exception('No se pudo conectar a la base de datos', 500);
    }

    // Obtener y validar datos
    $input = file_get_contents('php://input');
    if ($input === false) {
        throw new Exception('Error al leer los datos de entrada', 400);
    }
    
    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Datos JSON inválidos: ' . json_last_error_msg(), 400);
    }
    
    if (!isset($data['total']) || !is_numeric($data['total'])) {
        throw new Exception('El campo total es requerido y debe ser numérico', 400);
    }
    
    // Extraer IDs de vuelo y hotel del carrito
    $id_vuelo = null;
    $id_hotel = null;
    
    if (isset($data['items']) && is_array($data['items'])) {
        foreach ($data['items'] as $item) {
            if ($item['tipo'] === 'vuelo') {
                $id_vuelo = (int)$item['id'];
            } elseif ($item['tipo'] === 'hotel') {
                $id_hotel = (int)$item['id'];
            }
        }
    }

    // Procesar transacción
    $pdo->beginTransaction();
    
    try {
        // Insertar reserva (usando el nombre correcto de la tabla: reserva)
        $stmt = $pdo->prepare("INSERT INTO reserva (id_cliente, id_vuelo, id_hotel) VALUES (:id_cliente, :id_vuelo, :id_hotel)");
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);

        $query = "SELECT habitaciones_disponibles FROM hotel WHERE id_hotel = $id_hotel";
        $result = $pdo->query($query);
        $disponibilidad = $result->fetch();
        if ($disponibilidad['habitaciones_disponibles'] > 0) {

            $update = $pdo->prepare("UPDATE hotel SET habitaciones_disponibles = habitaciones_disponibles - 1 WHERE id_hotel = :id_hotel");
            $update->bindParam(':id_hotel', $id_hotel, PDO::PARAM_INT);
            $update->execute();

        }   else {
            throw new Exception('Error al crear reserva: no hay habitaciones disponibles');
        }        

        // Manejo explícito de NULL
        if ($id_vuelo !== null) {
            $stmt->bindParam(':id_vuelo', $id_vuelo, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':id_vuelo', null, PDO::PARAM_NULL);
        }
        
        if ($id_hotel !== null) {
            $stmt->bindParam(':id_hotel', $id_hotel, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':id_hotel', null, PDO::PARAM_NULL);
        }
        
        if (!$stmt->execute()) {
            throw new Exception('Error al crear reserva: ' . implode(' ', $stmt->errorInfo()));
        }
        
        $reservaId = $pdo->lastInsertId();
        
        // Insertar transacción (usando el nombre correcto de la tabla: transaccion)
        $stmt = $pdo->prepare("INSERT INTO transaccion (id_reserva, id_cliente, monto) VALUES (?, ?, ?)");
        if (!$stmt->execute([$reservaId, $id_cliente, $data['total']])) {
            throw new Exception('Error al registrar transacción: ' . implode(' ', $stmt->errorInfo()));
        }
        
        $pdo->commit();
        
        // Respuesta exitosa
        echo json_encode([
            'success' => true,
            'message' => 'Pago procesado correctamente',
            'reserva_id' => $reservaId,
            'id_vuelo' => $id_vuelo,
            'id_hotel' => $id_hotel
        ]);

    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en la base de datos',
        'error' => $e->getMessage(),
        'error_info' => isset($e->errorInfo) ? $e->errorInfo : null
    ]);
} catch (Exception $e) {
    $code = method_exists($e, 'getCode') ? $e->getCode() : 400;
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => $code
    ]);
} finally {
    ob_end_flush();
}