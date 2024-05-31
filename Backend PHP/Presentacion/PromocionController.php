<?php

require_once __DIR__ . '/../LogicaNegocio/PromocionBusiness.php';
require_once __DIR__ . '/../Dominio/Promocion.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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

    if (isset($input['METHOD'])) {
        switch ($input['METHOD']) {
            case 'POST':
                unset($input['METHOD']);
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
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;

            case 'PUT':
                unset($input['METHOD']);
                $id = $_GET['id'];
                $promocion = new Promocion(
                    $id,
                    $input['cupon_id'],
                    $input['descripcion'],
                    $input['fecha_inicio'],
                    $input['fecha_vencimiento'],
                    $input['descuento']
                );
                
                try {
                    $promocionBusiness->actualizarPromocion($promocion);
                    header("HTTP/1.1 200 OK");
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                unset($input['METHOD']);
                $id = $_GET['id'];
                
                try {
                    $promocionBusiness->eliminarPromocion($id);
                    header("HTTP/1.1 200 OK");
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;
                
            default:
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(["error" => "Método no soportado"]);
                break;
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["error" => "Método no especificado"]);
    }
    exit();
}

header("HTTP/1.1 405 Method Not Allowed");
echo json_encode(["error" => "Método no permitido"]);

?>
