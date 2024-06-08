<?php

header('Access-Control-Allow-Origin: *'); // Permite todas las solicitudes de origen
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Métodos permitidos
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Cabeceras permitidas
header('Content-Type: application/json');

// Manejo de solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../LogicaNegocio/TodoCuponBusiness.php';

$todoCuponBusiness = new TodoCuponBusiness();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $cupon = $todoCuponBusiness->obtenerTodoCuponID($id);
            header("HTTP/1.1 200 OK");
            echo json_encode($cupon);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        try {
            $cupones = $todoCuponBusiness->obtenerTodoCupones();
            header("HTTP/1.1 200 OK");
            echo json_encode($cupones);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    exit();
}

header("HTTP/1.1 405 Method Not Allowed");
echo json_encode(["error" => "Método no permitido"]);

?>
