<?php

require_once __DIR__ . '/../LogicaNegocio/EmpresaBusiness.php';
require_once __DIR__ . '/../Dominio/Empresa.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$empresaBusiness = new EmpresaBusiness();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'OPTIONS') {
    http_response_code(200);
    exit();
}

function handleException($e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(["error" => $e->getMessage()]);
    exit();
}

try {
    if ($method == 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $empresa = $empresaBusiness->obtenerEmpresa($id);
            header("HTTP/1.1 200 OK");
            echo json_encode($empresa);
        } else {
            $empresas = $empresaBusiness->obtenerEmpresas();
            header("HTTP/1.1 200 OK");
            echo json_encode($empresas);
        }
        exit();
    }

    if ($method == 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if (isset($input['METHOD'])) {
            switch ($input['METHOD']) {
                case 'LOGIN':
                    $cedula = $input['cedula'] ?? null;
                    $contrasenna = $input['contrasenna'] ?? null;

                    if ($cedula === null || $contrasenna === null) {
                        header("HTTP/1.1 400 Bad Request");
                        echo json_encode(["error" => "Faltan campos obligatorios"]);
                        exit();
                    }

                    $empresa = $empresaBusiness->autenticarEmpresa($cedula, $contrasenna);
                    if ($empresa) {
                        header("HTTP/1.1 200 OK");
                        echo json_encode(['success' => true, 'empresa' => $empresa, 'estado' => $empresa['estado']]);
                    } else {
                        header("HTTP/1.1 401 Unauthorized");
                        echo json_encode(["success" => false, "message" => "Cédula o contraseña incorrectos"]);
                    }
                    break;

                case 'POST':
                    unset($input['METHOD']);
                    $empresa = new Empresa(null, $input['nombre'], $input['direccion'], $input['cedula'], $input['fecha_creacion'], $input['correo'], $input['telefono'], $input['imagen'], $input['contrasenna'], $input['estado']);
                    $empresaBusiness->crearEmpresa($empresa);
                    header("HTTP/1.1 201 Created");
                    echo json_encode(["mensaje" => "Empresa creada exitosamente", "empresa" => $empresa]);
                    break;

                case 'PUT':
                    unset($input['METHOD']);
                    $id = $input['id'] ?? null;

                    if ($id === null) {
                        header("HTTP/1.1 400 Bad Request");
                        echo json_encode(["error" => "Faltan campos obligatorios"]);
                        exit();
                    }

                    $empresa = new Empresa($id, $input['nombre'], $input['direccion'], $input['cedula'], $input['fecha_creacion'], $input['correo'], $input['telefono'], $input['imagen'], $input['contrasenna'], $input['estado']);
                    $empresaBusiness->actualizarEmpresa($empresa);
                    header("HTTP/1.1 200 OK");
                    echo json_encode(["mensaje" => "Empresa actualizada exitosamente"]);
                    break;

                case 'DELETE':
                    unset($input['METHOD']);
                    $id = $_GET['id'];

                    $empresaBusiness->eliminarEmpresa($id);
                    header("HTTP/1.1 200 OK");
                    echo json_encode(["mensaje" => "Empresa eliminada exitosamente"]);
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

} catch (Exception $e) {
    handleException($e);
}

?>
