<?php

require_once __DIR__ . '/../AccesoDatos/TodoCuponData.php';

class TodoCuponBusiness {
    private $todoCuponData;

    public function __construct() {
        $this->todoCuponData = new TodoCuponData();
    }

    public function obtenerTodoCupones() {
        return $this->todoCuponData->obtenerTodoCupones();
    }

    public function obtenerTodoCuponID($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de cupón inválido");
        }
        return $this->todoCuponData->obtenerTodoCuponID($id);
    }
}

?>
