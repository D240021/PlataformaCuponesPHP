<?php

// Encabezados CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Manejo de solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../LogicaNegocio/CuponBusiness.php';
require_once __DIR__ . '/../Dominio/Cupon.php';

$cuponBusiness = new CuponBusiness();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $cupon = $cuponBusiness->obtenerCupon($id);
            header("HTTP/1.1 200 OK");
            echo json_encode($cupon);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else if (isset($_GET['no_vencidos'])) {
        try {
            $cupones = $cuponBusiness->obtenerCuponesNoVencidos();
            header("HTTP/1.1 200 OK");
            echo json_encode($cupones);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else if (isset($_GET['empresa_id'])) {
        $empresa_id = $_GET['empresa_id'];
        try {
            $cupones = $cuponBusiness->obtenerCuponesPorEmpresa($empresa_id);
            header("HTTP/1.1 200 OK");
            echo json_encode($cupones);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        try {
            $cupones = $cuponBusiness->obtenerCupones();
            header("HTTP/1.1 200 OK");
            echo json_encode($cupones);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    exit();
}

if ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["error" => "JSON recibido no es válido"]);
        exit();
    }

    if (isset($input['METHOD'])) {
        switch ($input['METHOD']) {
            case 'POST':
                unset($input['METHOD']);
                try {
                    $cupon = new Cupon(
                        null,
                        $input['codigo'],
                        $input['nombre'],
                        $input['precio'],
                        $input['empresa_id'],
                        $input['estado'],
                        $input['imagen'],
                        $input['categoria_id'],
                        $input['fecha_inicio'],
                        $input['fecha_vencimiento'],
                        $input['fecha_creacion']
                    );

                    $cuponBusiness->crearCupon($cupon);
                    header("HTTP/1.1 201 Created");
                    echo json_encode(["message" => "Cupón creado con éxito"]);
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;

            case 'PUT':
                unset($input['METHOD']);
                if (isset($input['cupon']) && is_array($input['cupon'])) {
                    try {
                        $cuponData = $input['cupon'];
                        $cupon = new Cupon(
                            $cuponData['id'],
                            $cuponData['codigo'],
                            $cuponData['nombre'],
                            $cuponData['precio'],
                            $cuponData['empresa_id'],
                            $cuponData['estado'],
                            $cuponData['imagen'],
                            $cuponData['categoria_id'],
                            $cuponData['fecha_inicio'],
                            $cuponData['fecha_vencimiento'],
                            $cuponData['fecha_creacion']
                        );
                        $cuponBusiness->actualizarCupon($cupon);
                        header("HTTP/1.1 200 OK");
                        echo json_encode(["message" => "Cupón actualizado con éxito"]);
                    } catch (Exception $e) {
                        header("HTTP/1.1 400 Bad Request");
                        echo json_encode(["error" => $e->getMessage()]);
                    }
                } else {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => "Formato de datos inválido"]);
                }
                break;

            case 'DELETE':
                unset($input['METHOD']);
                if (isset($input['id'])) {
                    $id = $input['id'];
                    try {
                        $cuponBusiness->eliminarCupon($id);
                        header("HTTP/1.1 200 OK");
                        echo json_encode(["message" => "Cupón eliminado con éxito"]);
                    } catch (Exception $e) {
                        header("HTTP/1.1 400 Bad Request");
                        echo json_encode(["error" => $e->getMessage()]);
                    }
                } else {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => "ID de cupón no especificado"]);
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
