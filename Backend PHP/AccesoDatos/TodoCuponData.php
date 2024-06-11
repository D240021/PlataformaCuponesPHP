<?php

require_once __DIR__ . '/../Conexion/Conexion.php';

class TodoCuponData {
    private $conexion;

    public function __construct() {
        $this->conexion = ConexionBD::obtenerInstancia()->obtenerConexion();
    }

    public function obtenerTodoCupones() {
        $sql = "SELECT 
                    cupon.id as cupon_id, cupon.codigo, cupon.nombre as cupon_nombre, cupon.precio, cupon.estado, cupon.imagen as cupon_imagen, cupon.categoria_id, cupon.fecha_inicio, cupon.fecha_vencimiento, cupon.fecha_creacion,
                    empresa.id as empresa_id, empresa.nombre as empresa_nombre, empresa.direccion, empresa.cedula as empresa_cedula, empresa.fecha_creacion as empresa_fecha_creacion, empresa.correo as empresa_correo, empresa.telefono as empresa_telefono, empresa.imagen as empresa_imagen, empresa.estado as empresa_estado,
                    promocion.id as promocion_id, promocion.descripcion as promocion_descripcion, promocion.fecha_inicio as promocion_fecha_inicio, promocion.fecha_vencimiento as promocion_fecha_vencimiento, promocion.descuento as promocion_descuento, promocion.estado as promocion_estado,
                    categoria.id as categoria_id, categoria.nombre as categoria_nombre
                FROM cupon 
                LEFT JOIN empresa ON cupon.empresa_id = empresa.id
                LEFT JOIN promocion ON cupon.id = promocion.cupon_id
                LEFT JOIN categoria ON cupon.categoria_id = categoria.id
                WHERE cupon.estado = 'Activo'";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->estructurarDatos($result);
    }

    public function obtenerTodoCuponID($id) {
        $sql = "SELECT 
                    cupon.id as cupon_id, cupon.codigo, cupon.nombre as cupon_nombre, cupon.precio, cupon.estado, cupon.imagen as cupon_imagen, cupon.categoria_id, cupon.fecha_inicio, cupon.fecha_vencimiento, cupon.fecha_creacion,
                    empresa.id as empresa_id, empresa.nombre as empresa_nombre, empresa.direccion, empresa.cedula as empresa_cedula, empresa.fecha_creacion as empresa_fecha_creacion, empresa.correo as empresa_correo, empresa.telefono as empresa_telefono, empresa.imagen as empresa_imagen, empresa.estado as empresa_estado,
                    promocion.id as promocion_id, promocion.descripcion as promocion_descripcion, promocion.fecha_inicio as promocion_fecha_inicio, promocion.fecha_vencimiento as promocion_fecha_vencimiento, promocion.descuento as promocion_descuento, promocion.estado as promocion_estado,
                    categoria.id as categoria_id, categoria.nombre as categoria_nombre
                FROM cupon 
                LEFT JOIN empresa ON cupon.empresa_id = empresa.id
                LEFT JOIN promocion ON cupon.id = promocion.cupon_id
                LEFT JOIN categoria ON cupon.categoria_id = categoria.id
                WHERE cupon.id = ? AND cupon.estado = 'Activo'";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->estructurarDatos($result);
    }

    private function estructurarDatos($data) {
        $cupones = [];
        foreach ($data as $row) {
            $idCupon = $row['cupon_id'];
            if (!isset($cupones[$idCupon])) {
                $cupones[$idCupon] = [
                    'idCupon' => $row['cupon_id'],
                    'nombreCupon' => $row['cupon_nombre'],
                    'codigo' => $row['codigo'],
                    'precio' => $row['precio'],
                    'estado' => $row['estado'],
                    'imagen' => $row['cupon_imagen'],
                    'categoria' => [
                        'idCategoria' => $row['categoria_id'],
                        'nombreCategoria' => $row['categoria_nombre']
                    ],
                    'fecha_inicio' => $row['fecha_inicio'],
                    'fecha_vencimiento' => $row['fecha_vencimiento'],
                    'fecha_creacion' => $row['fecha_creacion'],
                    'empresa' => [
                        'idEmpresa' => $row['empresa_id'] ?? null,
                        'nombreEmpresa' => $row['empresa_nombre'] ?? null,
                        'direccion' => $row['direccion'] ?? null,
                        'cedula' => $row['empresa_cedula'] ?? null,
                        'fecha_creacion' => $row['empresa_fecha_creacion'] ?? null,
                        'correo' => $row['empresa_correo'] ?? null,
                        'telefono' => $row['empresa_telefono'] ?? null,
                        'imagen' => $row['empresa_imagen'] ?? null,
                        'estado' => $row['empresa_estado'] ?? null
                    ],
                    'promociones' => []
                ];
            }

            // Agregar solo promociones activas
            if (!empty($row['promocion_id']) && $row['promocion_estado'] === 'Activo') {
                $cupones[$idCupon]['promociones'][] = [
                    'idPromocion' => $row['promocion_id'],
                    'descripcion' => $row['promocion_descripcion'],
                    'fecha_inicio' => $row['promocion_fecha_inicio'],
                    'fecha_vencimiento' => $row['promocion_fecha_vencimiento'],
                    'descuento' => $row['promocion_descuento'],
                    'estado' => $row['promocion_estado']
                ];
            }
        }
        return array_values($cupones);
    }
}

?>
