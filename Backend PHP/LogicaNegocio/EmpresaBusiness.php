<?php

require_once 'AccesoDatos/EmpresaData.php';
require_once 'Dominio/Empresa.php';

class EmpresaBusiness {
    private $empresaData;

    public function __construct() {
        $this->empresaData = new EmpresaData();
    }

    public function crearEmpresa($empresa) {
        // Validaciones
        if (empty($empresa->nombre) || empty($empresa->direccion) || empty($empresa->cedula) || empty($empresa->fecha_creacion) || empty($empresa->correo) || empty($empresa->telefono)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        // Llamada al método crearEmpresa de EmpresaData
        $this->empresaData->crearEmpresa($empresa);
    }

    public function obtenerEmpresa($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de empresa inválido");
        }

        return $this->empresaData->obtenerEmpresaID($id);
    }

    public function obtenerEmpresas() {
        return $this->empresaData->obtenerEmpresas();
    }

    public function actualizarEmpresa($empresa) {
        // Validaciones
        if (empty($empresa->id) || !is_numeric($empresa->id)) {
            throw new Exception("ID de empresa inválido");
        }

        if (empty($empresa->nombre) || empty($empresa->direccion) || empty($empresa->cedula) || empty($empresa->fecha_creacion) || empty($empresa->correo) || empty($empresa->telefono)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        // Llamada al método actualizarEmpresa de EmpresaData
        $this->empresaData->actualizarEmpresa($empresa);
    }

    public function eliminarEmpresa($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de empresa inválido");
        }

        $this->empresaData->eliminarEmpresa($id);
    }
}

?>
