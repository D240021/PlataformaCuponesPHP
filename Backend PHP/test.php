<?php

require_once 'LogicaNegocio/EmpresaBusiness.php';
require_once 'Dominio/Empresa.php';

// Crear una instancia de EmpresaBusiness
$empresaBusiness = new EmpresaBusiness();

// Crear una nueva empresa para la prueba
$empresa = new Empresa(null, "Empresa de Prueba", "Calle de Prueba 123", "123456789", "2024-01-01", "prueba@empresa.com", "555-5555");

try {
    // Prueba de creación de empresa
    echo "Creando empresa...\n";
    $empresaBusiness->crearEmpresa($empresa);

    // Prueba de obtención de todas las empresas
    echo "Obteniendo todas las empresas...\n";
    $empresas = $empresaBusiness->obtenerEmpresas();
    print_r($empresas);

    // Prueba de obtención de una empresa por ID
    $empresaCreada = end($empresas); // Asumimos que la empresa creada es la última en la lista
    $idEmpresaCreada = $empresaCreada['id'];
    echo "Obteniendo empresa con ID: $idEmpresaCreada...\n";
    $empresaObtenida = $empresaBusiness->obtenerEmpresa($idEmpresaCreada);
    print_r($empresaObtenida);

    // Prueba de actualización de empresa
    echo "Actualizando empresa con ID: $idEmpresaCreada...\n";
    $empresaObtenida['nombre'] = "Empresa de Prueba Actualizada";
    $empresaActualizada = new Empresa(
        $empresaObtenida['id'],
        $empresaObtenida['nombre'],
        $empresaObtenida['direccion'],
        $empresaObtenida['cedula'],
        $empresaObtenida['fecha_creacion'],
        $empresaObtenida['correo'],
        $empresaObtenida['telefono']
    );
    $empresaBusiness->actualizarEmpresa($empresaActualizada);

    // Verificar la actualización
    $empresaObtenidaActualizada = $empresaBusiness->obtenerEmpresa($idEmpresaCreada);
    echo "Empresa actualizada:\n";
    print_r($empresaObtenidaActualizada);

    // Prueba de eliminación de empresa
    echo "Eliminando empresa con ID: $idEmpresaCreada...\n";
    $empresaBusiness->eliminarEmpresa($idEmpresaCreada);

    // Verificar la eliminación
    try {
        $empresaObtenida = $empresaBusiness->obtenerEmpresa($idEmpresaCreada);
        if ($empresaObtenida) {
            echo "Error: La empresa no fue eliminada correctamente\n";
        }
    } catch (Exception $e) {
        echo "Empresa eliminada correctamente\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
