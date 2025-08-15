<?php
require_once '../../bd/conexion2.php';

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Habilitar CORS si es necesario (opcional)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // 2. VALIDACIÓN DEL MÉTODO HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido. Solo se acepta POST.');
    }

    // 3. VALIDACIÓN DE CAMPOS OBLIGATORIOS
    $camposRequeridos = ['id', 'nombre', 'estado'];
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || (is_string($_POST[$campo]) && empty(trim($_POST[$campo])))) {
            throw new Exception("El campo '$campo' es obligatorio.");
        }
    }

    // 4. SANITIZACIÓN Y VALIDACIÓN DE DATOS
    $id = (int) $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $estado = (int) $_POST['estado'];

    // Validaciones específicas
    if ($id <= 0) {
        throw new Exception('El ID debe ser un número positivo válido.');
    }

    if (strlen($nombre) < 2) {
        throw new Exception('El nombre debe tener al menos 2 caracteres.');
    }

    if (strlen($nombre) > 100) {
        throw new Exception('El nombre no puede exceder los 100 caracteres.');
    }

    if (!in_array($estado, [0, 1])) {
        throw new Exception('El estado debe ser 0 (Inactivo) o 1 (Activo).');
    }

    // 5. VERIFICAR QUE EL REGISTRO EXISTE
    $sqlExiste = "SELECT COUNT(*) as total FROM tipo_documento WHERE id = :id";
    $stmtExiste = $conn->prepare($sqlExiste);
    $stmtExiste->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtExiste->execute();
    
    $existeRegistro = $stmtExiste->fetch(PDO::FETCH_ASSOC);
    
    if ($existeRegistro['total'] == 0) {
        throw new Exception('El tipo de documento que intenta editar no existe.');
    }

    // 6. VERIFICAR DUPLICADOS (EXCLUYENDO EL REGISTRO ACTUAL)
    $sqlVerificar = "SELECT COUNT(*) as total FROM tipo_documento 
                     WHERE LOWER(nombre) = LOWER(:nombre) AND id != :id";
    $stmtVerificar = $conn->prepare($sqlVerificar);
    $stmtVerificar->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmtVerificar->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtVerificar->execute();
    
    $resultadoDuplicado = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
    
    if ($resultadoDuplicado['total'] > 0) {
        throw new Exception('Ya existe otro tipo de documento con ese nombre.');
    }

    // 7. OBTENER DATOS ANTERIORES PARA LOG
    $sqlAnterior = "SELECT nombre, estado FROM tipo_documento WHERE id = :id";
    $stmtAnterior = $conn->prepare($sqlAnterior);
    $stmtAnterior->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtAnterior->execute();
    $datosAnteriores = $stmtAnterior->fetch(PDO::FETCH_ASSOC);

    // 8. ACTUALIZAR EN LA BASE DE DATOS
    $sqlActualizar = "UPDATE tipo_documento 
                      SET nombre = :nombre, estado = :estado 
                      WHERE id = :id";
    $stmtActualizar = $conn->prepare($sqlActualizar);
    
    // Binding de parámetros
    $stmtActualizar->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmtActualizar->bindParam(':estado', $estado, PDO::PARAM_INT);
    $stmtActualizar->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Ejecutar la actualización
    if ($stmtActualizar->execute()) {
        // 9. VERIFICAR QUE SE AFECTARON FILAS
        $filasAfectadas = $stmtActualizar->rowCount();
        
        if ($filasAfectadas > 0) {
            // 10. RESPUESTA EXITOSA
            echo json_encode([
                'status' => 'success',
                'message' => 'Tipo de documento actualizado exitosamente.',
                'data' => [
                    'id' => $id,
                    'nombre_anterior' => $datosAnteriores['nombre'],
                    'nombre_nuevo' => $nombre,
                    'estado_anterior' => $datosAnteriores['estado'],
                    'estado_nuevo' => $estado,
                    'fecha_actualizacion' => date('Y-m-d H:i:s')
                ]
            ]);
            
            // Log detallado para auditoría
            $logMensaje = "Tipo documento actualizado - ID: $id, " .
                         "Nombre: '{$datosAnteriores['nombre']}' → '$nombre', " .
                         "Estado: {$datosAnteriores['estado']} → $estado";
            error_log($logMensaje);
            
        } else {
            // No se realizaron cambios (datos idénticos)
            echo json_encode([
                'status' => 'info',
                'message' => 'No se realizaron cambios. Los datos son idénticos a los existentes.',
                'data' => [
                    'id' => $id,
                    'nombre' => $nombre,
                    'estado' => $estado
                ]
            ]);
        }
        
    } else {
        throw new Exception('Error al actualizar el tipo de documento en la base de datos.');
    }

} catch (PDOException $e) {
    // 11. MANEJO DE ERRORES DE BASE DE DATOS
    error_log("Error PDO en editar tipo documento: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de base de datos. Por favor, contacte al administrador.',
        'error_code' => 'DB_ERROR'
    ]);

} catch (Exception $e) {
    // 12. MANEJO DE ERRORES GENERALES
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_code' => 'VALIDATION_ERROR'
    ]);

} finally {
    // 13. LIMPIEZA
    $conn = null;
}

/**
 * DIFERENCIAS CLAVE ENTRE AGREGAR Y EDITAR:
 * 
 * 1. VALIDACIONES ADICIONALES:
 *    - Verificar que el registro existe antes de actualizar
 *    - Validar duplicados excluyendo el registro actual
 *    - Manejar el caso de "sin cambios"
 * 
 * 2. OPERACIÓN SQL:
 *    - UPDATE en lugar de INSERT
 *    - WHERE con ID específico
 *    - rowCount() para verificar cambios
 * 
 * 3. AUDITORÍA:
 *    - Guardar datos anteriores antes del cambio
 *    - Log con valores antes y después
 *    - Registro detallado de la modificación
 * 
 * 4. RESPUESTAS:
 *    - Manejo de casos sin cambios
 *    - Información de valores anteriores y nuevos
 *    - Estados de respuesta más específicos
 */
?>