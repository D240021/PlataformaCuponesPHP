<?php

require_once __DIR__ . '/../AccesoDatos/CategoriaData.php';
require_once __DIR__ . '/../Dominio/Categoria.php';

class CategoriaBusiness {
    private $categoriaData;

    public function __construct() {
        $this->categoriaData = new CategoriaData();
    }

    public function crearCategoria($categoria) {
        if (empty($categoria->nombre)) {
            throw new Exception("El nombre de la categoría es obligatorio");
        }

        $this->categoriaData->crearCategoria($categoria);
    }

    public function obtenerCategoria($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de categoría inválido");
        }

        return $this->categoriaData->obtenerCategoriaID($id);
    }

    public function obtenerCategorias() {
        return $this->categoriaData->obtenerCategorias();
    }

    public function actualizarCategoria($categoria) {
        if (empty($categoria->id) || !is_numeric($categoria->id)) {
            throw new Exception("ID de categoría inválido");
        }

        if (empty($categoria->nombre)) {
            throw new Exception("El nombre de la categoría es obligatorio");
        }

        $this->categoriaData->actualizarCategoria($categoria);
    }

    public function eliminarCategoria($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de categoría inválido");
        }

        $this->categoriaData->eliminarCategoria($id);
    }
}

?>
