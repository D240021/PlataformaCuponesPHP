<?php

require_once __DIR__ . '/../AccesoDatos/EmpresaData.php';
require_once __DIR__ . '/../Dominio/Empresa.php';

class EmpresaBusiness {
    private $empresaData;

    public function __construct() {
        $this->empresaData = new EmpresaData();
    }

    public function crearEmpresa($empresa) {

        if (empty($empresa->nombre) || empty($empresa->direccion) || empty($empresa->cedula) || empty($empresa->fecha_creacion) || empty($empresa->correo) || empty($empresa->telefono) || empty($empresa->imagen) || empty($empresa->contrasenna)) {
            throw new Exception("Todos los campos son obligatorios");
        }

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

    public function autenticarEmpresa($cedula, $contrasenna) {
        if (empty($cedula) || empty($contrasenna)) {
            throw new Exception("Cédula y contraseña son obligatorios");
        }
    
        $empresa = $this->empresaData->obtenerEmpresaPorCedulaYContrasenna($cedula, $contrasenna);
        return $empresa;
    }    

    public function actualizarEmpresa($empresa) {
        if (empty($empresa->id) || !is_numeric($empresa->id)) {
            throw new Exception("ID de empresa inválido");
        }

        if (empty($empresa->nombre) || empty($empresa->direccion) || empty($empresa->cedula) || empty($empresa->fecha_creacion) || empty($empresa->correo) || empty($empresa->telefono) || empty($empresa->imagen) || empty($empresa->contrasenna)) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $this->empresaData->actualizarEmpresa($empresa);
    }

    public function actualizarContrasennaEmpresa($id, $contrasenna) {

        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de empresa inválido");
        }

        if (empty($contrasenna)) {
            throw new Exception("La contraseña no debe estar vacía");
        }

        $this->empresaData->actualizarContrasennaEmpresa($id, $contrasenna);
    }

    public function eliminarEmpresa($id) {
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("ID de empresa inválido");
        }

        $this->empresaData->eliminarEmpresa($id);
    }
}

?>
