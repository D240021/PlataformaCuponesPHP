<?php
header('Access-Control-Allow-Origin: *'); // Permite todas las solicitudes de origen
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Cabeceras permitidas
header('Content-Type: application/json');

// Si el método es OPTIONS, termina la ejecución aquí
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../LogicaNegocio/PromocionBusiness.php';
require_once __DIR__ . '/../Dominio/Promocion.php';

$promocionBusiness = new PromocionBusiness();

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method == 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $promocion = $promocionBusiness->obtenerPromocion($id);
            echo json_encode($promocion);
        } elseif (isset($_GET['cupon_id'])) {
            $cupon_id = $_GET['cupon_id'];
            $promociones = $promocionBusiness->obtenerPromocionesCuponID($cupon_id);
            echo json_encode($promociones);
        } else {
            $promociones = $promocionBusiness->obtenerPromociones();
            echo json_encode($promociones);
        }
    } elseif ($method == 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['METHOD'])) {
            switch ($input['METHOD']) {
                case 'POST':
                    unset($input['METHOD']);
                    if (!isset($input['cupon_id'], $input['descripcion'], $input['fecha_inicio'], $input['fecha_vencimiento'], $input['descuento'], $input['estado'])) {
                        throw new Exception('Datos incompletos para crear la promoción');
                    }
                    $promocion = new Promocion(
                        null,
                        $input['cupon_id'],
                        $input['descripcion'],
                        $input['fecha_inicio'],
                        $input['fecha_vencimiento'],
                        $input['descuento'],
                        $input['estado']
                    );
                    $promocionBusiness->crearPromocion($promocion);
                    echo json_encode(['status' => 'success', 'message' => 'Promoción creada exitosamente']);
                    break;
                case 'PUT':
                    unset($input['METHOD']);
                    if (!isset($input['id'], $input['cupon_id'], $input['descripcion'], $input['fecha_inicio'], $input['fecha_vencimiento'], $input['descuento'], $input['estado'])) {
                        throw new Exception('Datos incompletos para actualizar la promoción');
                    }
                    $promocion = new Promocion(
                        $input['id'],
                        $input['cupon_id'],
                        $input['descripcion'],
                        $input['fecha_inicio'],
                        $input['fecha_vencimiento'],
                        $input['descuento'],
                        $input['estado']
                    );
                    $promocionBusiness->actualizarPromocion($promocion);
                    echo json_encode(['status' => 'success', 'message' => 'Promoción actualizada exitosamente']);
                    break;
                case 'DELETE':
                    unset($input['METHOD']);
                    if (!isset($input['id'])) {
                        throw new Exception('ID de promoción no especificado');
                    }
                    $id = $input['id'];
                    $promocionBusiness->eliminarPromocion($id);
                    echo json_encode(['status' => 'success', 'message' => 'Promoción eliminada exitosamente']);
                    break;
                default:
                    throw new Exception('Método no soportado');
            }
        } else {
            throw new Exception('Método no especificado');
        }
    } else {
        throw new Exception('Método no permitido');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
