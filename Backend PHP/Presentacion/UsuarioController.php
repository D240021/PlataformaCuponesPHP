<?php

require_once 'LogicaNegocio/UsuarioBusiness.php';
require_once 'Dominio/Usuario.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$usuarioBusiness = new UsuarioBusiness();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $usuario = $usuarioBusiness->obtenerUsuario($id);
            header("HTTP/1.1 200 OK");
            echo json_encode($usuario);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        try {
            $usuarios = $usuarioBusiness->obtenerUsuarios();
            header("HTTP/1.1 200 OK");
            echo json_encode($usuarios);
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
                $usuario = new Usuario(
                    null,
                    $input['nombre'],
                    $input['apellidos'],
                    $input['cedula'],
                    $input['fecha_nacimiento'],
                    $input['correo'],
                    $input['contrasena']
                );
                
                try {
                    $usuarioBusiness->crearUsuario($usuario);
                    header("HTTP/1.1 201 Created");
                    echo json_encode(["mensaje" => "Usuario creado exitosamente", "usuario" => $usuario]);
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;

            case 'PUT':
                unset($input['METHOD']);
                $id = $_GET['id'];
                $usuario = new Usuario(
                    $id,
                    $input['nombre'],
                    $input['apellidos'],
                    $input['cedula'],
                    $input['fecha_nacimiento'],
                    $input['correo'],
                    $input['contrasena']
                );
                
                try {
                    $usuarioBusiness->actualizarUsuario($usuario);
                    header("HTTP/1.1 200 OK");
                    echo json_encode(["mensaje" => "Usuario actualizado exitosamente"]);
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                unset($input['METHOD']);
                $id = $_GET['id'];
                
                try {
                    $usuarioBusiness->eliminarUsuario($id);
                    header("HTTP/1.1 200 OK");
                    echo json_encode(["mensaje" => "Usuario eliminado exitosamente"]);
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
