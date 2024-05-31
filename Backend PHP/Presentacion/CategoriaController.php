<?php

require_once __DIR__ . '/../LogicaNegocio/CategoriaBusiness.php';
require_once __DIR__ . '/../Dominio/Categoria.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$categoriaBusiness = new CategoriaBusiness();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $categoria = $categoriaBusiness->obtenerCategoria($id);
            header("HTTP/1.1 200 OK");
            echo json_encode($categoria);
        } catch (Exception $e) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        try {
            $categorias = $categoriaBusiness->obtenerCategorias();
            header("HTTP/1.1 200 OK");
            echo json_encode($categorias);
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
                $categoria = new Categoria(null, $input['nombre']);
                
                try {
                    $categoriaBusiness->crearCategoria($categoria);
                    header("HTTP/1.1 201 Created");
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
                break;

            case 'PUT':
                unset($input['METHOD']);
                $id = $_GET['id'];
                $categoria = new Categoria($id, $input['nombre']);
                
                try {
                    $categoriaBusiness->actualizarCategoria($categoria);
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
                    $categoriaBusiness->eliminarCategoria($id);
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
