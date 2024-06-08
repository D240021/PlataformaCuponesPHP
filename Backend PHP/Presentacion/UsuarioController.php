<?php

require_once __DIR__ . '/../LogicaNegocio/UsuarioBusiness.php';
require_once __DIR__ . '/../Dominio/Usuario.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

$usuarioBusiness = new UsuarioBusiness();

$method = $_SERVER['REQUEST_METHOD'];

// Manejar la solicitud OPTIONS para CORS
if ($method == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

if ($method == 'POST' && isset($_GET['action']) && $_GET['action'] == 'auth') {
    $input = json_decode(file_get_contents('php://input'), true);
    try {
        $usuario = $usuarioBusiness->autenticarUsuario($input['username'], $input['contrasena']);
        header("HTTP/1.1 200 OK");
        echo json_encode($usuario);
    } catch (Exception $e) {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}

header("HTTP/1.1 405 Method Not Allowed");
echo json_encode(["error" => "Método no permitido"]);

?>
