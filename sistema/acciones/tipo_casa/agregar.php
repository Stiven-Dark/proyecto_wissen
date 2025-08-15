<?php
// 1. CONFIGURACIÓN INICIAL
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
    $camposRequeridos = ['nombre', 'estado'];
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
            throw new Exception("El campo '$campo' es obligatorio.");
        }
    }

    // 4. SANITIZACIÓN Y VALIDACIÓN DE DATOS
    $nombre = trim($_POST['nombre']);
    $estado = (int) $_POST['estado'];

    // Validaciones específicas
    if (strlen($nombre) < 2) {
        throw new Exception('El nombre debe tener al menos 2 caracteres.');
    }

    if (strlen($nombre) > 100) {
        throw new Exception('El nombre no puede exceder los 100 caracteres.');
    }

    if (!in_array($estado, [0, 1])) {
        throw new Exception('El estado debe ser 0 (Inactivo) o 1 (Activo).');
    }

    // 5. VERIFICAR DUPLICADOS
    $sqlVerificar = "SELECT COUNT(*) as total FROM tipo_casa WHERE LOWER(nombre) = LOWER(:nombre)";
    $stmtVerificar = $conn->prepare($sqlVerificar);
    $stmtVerificar->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmtVerificar->execute();
    
    $resultado = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado['total'] > 0) {
        throw new Exception('Ya existe un tipo de casa con ese nombre.');
    }

    // 6. INSERTAR EN LA BASE DE DATOS
    $sqlInsertar = "INSERT INTO tipo_casa (nombre, estado) VALUES (:nombre, :estado)";
    $stmtInsertar = $conn->prepare($sqlInsertar);
    
    // Binding de parámetros
    $stmtInsertar->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmtInsertar->bindParam(':estado', $estado, PDO::PARAM_INT);
    
    // Ejecutar la inserción
    if ($stmtInsertar->execute()) {
        // 7. RESPUESTA EXITOSA
        $idInsertado = $conn->lastInsertId();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Tipo de casa agregado exitosamente.',
            'data' => [
                'id' => $idInsertado,
                'nombre' => $nombre,
                'estado' => $estado,
                'fecha_creacion' => date('Y-m-d H:i:s')
            ]
        ]);
        
        // Log opcional (buena práctica para auditoría)
        error_log("Tipo de casa creado: ID $idInsertado, Nombre: $nombre");
        
    } else {
        throw new Exception('Error al insertar el tipo de casa en la base de datos.');
    }

} catch (PDOException $e) {
    // 8. MANEJO DE ERRORES DE BASE DE DATOS
    error_log("Error PDO en agregar tipo casa: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de base de datos. Por favor, contacte al administrador.',
        'error_code' => 'DB_ERROR'
    ]);

} catch (Exception $e) {
    // 9. MANEJO DE ERRORES GENERALES
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_code' => 'VALIDATION_ERROR'
    ]);

} finally {
    // 10. LIMPIEZA (opcional, PDO maneja esto automáticamente)
    $conn = null;
}

?>