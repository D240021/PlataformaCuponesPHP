<?php

require_once __DIR__ . '/../LogicaNegocio/EmpresaBusiness.php';
require_once __DIR__ . '/../Dominio/Empresa.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$empresaBusiness = new EmpresaBusiness();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $empresa = $empresaBusiness->obtenerEmpresa($id);
            header("HTTP/1.1 200 OK");
            echo json_encode($empresa);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        try {
            $empresas = $empresaBusiness->obtenerEmpresas();
            header("HTTP/1.1 200 OK");
            echo json_encode($empresas);
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
                $empresa = new Empresa(null, $input['nombre'], $input['direccion'], $input['cedula'], $input['fecha_creacion'], $input['correo'], $input['telefono'], $input['imagen'], $input['contrasenna']);
                $empresa->isHabilitado = $input['isHabilitado'];
                
                try {
                    $empresaBusiness->crearEmpresa($empresa);
                    header("HTTP/1.1 201 Created");
                    echo json_encode(["mensaje" => "Empresa creada exitosamente", "empresa" => $empresa]);
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;

            case 'PUT':
                unset($input['METHOD']);
                $id = $_GET['id'];
                
                if (isset($input['contrasenna']) && count($input) == 2) { // Si solo se está actualizando la contraseña
                    $contrasenna = $input['contrasenna'];
                    try {
                        $empresaBusiness->actualizarContrasennaEmpresa($id, $contrasenna);
                        header("HTTP/1.1 200 OK");
                        echo json_encode(["mensaje" => "Contraseña actualizada exitosamente"]);
                    } catch (Exception $e) {
                        header("HTTP/1.1 400 Bad Request");
                        echo json_encode(["error" => $e->getMessage()]);
                    }
                } else { // Actualización de otros datos de la empresa
                    $empresa = new Empresa();
                    $empresa->id = $id;
                    $empresa->nombre = $input['nombre'];
                    $empresa->direccion = $input['direccion'];
                    $empresa->cedula = $input['cedula'];
                    $empresa->fecha_creacion = $input['fecha_creacion'];
                    $empresa->correo = $input['correo'];
                    $empresa->telefono = $input['telefono'];
                    $empresa->imagen = $input['imagen'];
                    $empresa->contrasenna = $input['contrasenna'];
                    $empresa->isHabilitado = $input['isHabilitado'];
                    
                    try {
                        $empresaBusiness->actualizarEmpresa($empresa);
                        header("HTTP/1.1 200 OK");
                        echo json_encode(["mensaje" => "Empresa actualizada exitosamente"]);
                    } catch (Exception $e) {
                        header("HTTP/1.1 400 Bad Request");
                        echo json_encode(["error" => $e->getMessage()]);
                    }
                }
                break;

            case 'DELETE':
                unset($input['METHOD']);
                $id = $_GET['id'];
                
                try {
                    $empresaBusiness->eliminarEmpresa($id);
                    header("HTTP/1.1 200 OK");
                    echo json_encode(["mensaje" => "Empresa eliminada exitosamente"]);
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
