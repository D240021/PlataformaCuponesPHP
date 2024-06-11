<?php

require_once __DIR__ . '/../Conexion/Conexion.php';

class EmpresaData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function crearEmpresa($empresa) {
        $sql = "INSERT INTO empresa (nombre, direccion, cedula, fecha_creacion, correo, telefono, imagen, contrasenna, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$empresa->nombre, $empresa->direccion, $empresa->cedula, $empresa->fecha_creacion, $empresa->correo, $empresa->telefono, $empresa->imagen, $empresa->contrasenna, $empresa->estado]);
    }

    public function obtenerEmpresaID($id) {
        $sql = "SELECT * FROM empresa WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $empresaData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($empresaData) {
            return new Empresa(
                $empresaData['id'],
                $empresaData['nombre'],
                $empresaData['direccion'],
                $empresaData['cedula'],
                $empresaData['fecha_creacion'],
                $empresaData['correo'],
                $empresaData['telefono'],
                $empresaData['imagen'],
                $empresaData['contrasenna'],
                $empresaData['estado']
            );
        } else {
            return null;
        }
    }
    

    public function obtenerEmpresaPorCedulaYContrasenna($cedula, $contrasenna) {
        $sql = "SELECT * FROM empresa WHERE cedula = ? AND contrasenna = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$cedula, $contrasenna]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }       

    public function obtenerEmpresas() {
        $sql = "SELECT * FROM empresa";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function actualizarEmpresa($empresa) {
        $sql = "UPDATE empresa SET nombre = ?, direccion = ?, cedula = ?, fecha_creacion = ?, correo = ?, telefono = ?, imagen = ?, contrasenna = ?, estado = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            $empresa->nombre, 
            $empresa->direccion, 
            $empresa->cedula, 
            $empresa->fecha_creacion, 
            $empresa->correo, 
            $empresa->telefono, 
            $empresa->imagen, 
            $empresa->contrasenna, 
            $empresa->estado, 
            $empresa->id
        ]);

        if ($empresa->estado === 'Inactivo') {
            $sqlCupon = "UPDATE cupon SET estado = 'Inactivo' WHERE empresa_id = ?";
            $stmtCupon = $this->conexion->prepare($sqlCupon);
            $stmtCupon->execute([$empresa->id]);
        }
    }
    

    public function actualizarContrasennaEmpresa($id, $contrasenna) {
        $sql = "UPDATE empresa SET contrasenna = ?, estado = 'Activo' WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$contrasenna, $id]);
    }
    

    public function eliminarEmpresa($id) {
        $sql = "DELETE FROM empresa WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>
