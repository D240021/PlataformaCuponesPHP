<?php

require_once 'LogicaNegocio/EmpresaBusiness.php';
require_once 'Dominio/Empresa.php';

// Crear una instancia de EmpresaBusiness
$empresaBusiness = new EmpresaBusiness();

try {
    // Crear una nueva empresa
    echo "Creando una nueva empresa...\n";
    $nuevaEmpresa = new Empresa(
        null,               // id, se generará automáticamente
        "Empresa XYZ",      // nombre
        "Dirección XYZ",    // dirección
        "123456789",        // cedula
        date("Y-m-d"),      // fecha_creacion
        "email@empresa.com",// correo
        "123456789",        // telefono
        "http://example.com/imagen.jpg", // imagen
        "password123",      // contrasenna
        "Activo"            // estado
    );

    // Llamar al método crearEmpresa
    $empresaBusiness->crearEmpresa($nuevaEmpresa);
    echo "Empresa creada con éxito.\n";

    // Obtener todas las empresas para verificar que la empresa se haya creado correctamente
    echo "Obteniendo todas las empresas...\n";
    $empresas = $empresaBusiness->obtenerEmpresas();
    echo json_encode($empresas, JSON_PRETTY_PRINT);

    // Obtener la última empresa creada por su ID
    echo "Obteniendo la última empresa creada...\n";
    if (!empty($empresas)) {
        $empresaId = end($empresas)['id']; // Obtener el último ID de empresa creada
        $empresaArray = $empresaBusiness->obtenerEmpresa($empresaId);
        echo json_encode($empresaArray, JSON_PRETTY_PRINT);
    } else {
        echo "No se encontró ninguna empresa para probar.\n";
    }

    // Actualizar la empresa
    echo "Actualizando la última empresa creada...\n";
    $empresaParaActualizar = new Empresa(
        $empresaId,               // id
        "Empresa XYZ Modificada", // nombre modificado
        "Dirección XYZ Modificada",// dirección modificada
        "123456789",              // cedula (sin cambios)
        date("Y-m-d"),            // fecha_creacion (sin cambios)
        "email_modificado@empresa.com", // correo modificado
        "987654321",              // telefono modificado
        "http://example.com/imagen_modificada.jpg", // imagen modificada
        "password456",            // contrasenna modificada
        "Inactivo"                // estado modificado
    );

    // Llamar al método actualizarEmpresa
    $empresaBusiness->actualizarEmpresa($empresaParaActualizar);
    echo "Empresa actualizada con éxito.\n";

    // Verificar que la empresa se haya actualizado correctamente
    echo "Obteniendo la empresa actualizada por ID...\n";
    $empresaActualizada = $empresaBusiness->obtenerEmpresa($empresaId);
    echo json_encode($empresaActualizada, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
}

?>
