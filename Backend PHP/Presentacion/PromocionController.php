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

if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $promocion = $promocionBusiness->obtenerPromocion($id);
            header("HTTP/1.1 200 OK");
            echo json_encode($promocion);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } elseif (isset($_GET['cupon_id'])) {
        $cupon_id = $_GET['cupon_id'];
        try {
            $promociones = $promocionBusiness->obtenerPromocionesCuponID($cupon_id);
            header("HTTP/1.1 200 OK");
            echo json_encode($promociones);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        try {
            $promociones = $promocionBusiness->obtenerPromociones();
            header("HTTP/1.1 200 OK");
            echo json_encode($promociones);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    exit();
}

if ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $response = [
        'status' => 'error',
        'message' => '',
        'data' => null
    ];

    if (isset($input['METHOD'])) {
        switch ($input['METHOD']) {
            case 'POST':
                unset($input['METHOD']);
                if (!isset($input['cupon_id'], $input['descripcion'], $input['fecha_inicio'], $input['fecha_vencimiento'], $input['descuento'])) {
                    header("HTTP/1.1 400 Bad Request");
                    $response['message'] = 'Datos incompletos para crear la promoción';
                    $response['data'] = $input;
                    echo json_encode($response);
                    exit();
                }
                $promocion = new Promocion(
                    null,
                    $input['cupon_id'],
                    $input['descripcion'],
                    $input['fecha_inicio'],
                    $input['fecha_vencimiento'],
                    $input['descuento']
                );

                try {
                    $promocionBusiness->crearPromocion($promocion);
                    header("HTTP/1.1 201 Created");
                    $response['status'] = 'success';
                    $response['message'] = 'Promoción creada exitosamente';
                    echo json_encode($response);
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    $response['message'] = 'Error creando promoción';
                    $response['data'] = $e->getMessage();
                    echo json_encode($response);
                }
                break;

            case 'DELETE':
                unset($input['METHOD']);
                if (!isset($input['id'])) {
                    header("HTTP/1.1 400 Bad Request");
                    $response['message'] = 'ID de promoción no especificado';
                    $response['data'] = $input;
                    echo json_encode($response);
                    exit();
                }
                $id = $input['id'];

                try {
                    $promocionBusiness->eliminarPromocion($id);
                    header("HTTP/1.1 200 OK");
                    $response['status'] = 'success';
                    $response['message'] = 'Promoción eliminada exitosamente';
                    echo json_encode($response);
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    $response['message'] = 'Error eliminando promoción';
                    $response['data'] = $e->getMessage();
                    echo json_encode($response);
                }
                break;

            default:
                header("HTTP/1.1 400 Bad Request");
                $response['message'] = 'Método no soportado';
                $response['data'] = $input;
                echo json_encode($response);
                break;
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        $response['message'] = 'Método no especificado';
        echo json_encode($response);
    }
    exit();
}


header("HTTP/1.1 405 Method Not Allowed");
echo json_encode(["error" => "Método no permitido"]);
?>
