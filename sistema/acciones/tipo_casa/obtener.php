<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // IMPORTANTE: No mostrar errores en pantalla

// Headers ANTES que cualquier output
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Verificar si el archivo de conexión existe
    $conexionPath = '../../bd/conexion2.php';
    if (!file_exists($conexionPath)) {
        throw new Exception('Archivo de conexión no encontrado');
    }
    
    require_once $conexionPath;

    // Verificar método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido. Solo POST.');
    }

    // Verificar parámetros
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception('ID es obligatorio');
    }

    $id = (int) $_POST['id'];
    
    if ($id <= 0) {
        throw new Exception('ID debe ser un número positivo');
    }

    // Verificar conexión a BD
    if (!isset($conn) || $conn === null) {
        throw new Exception('Error de conexión a la base de datos');
    }

    // Consultar registro
    $sql = "SELECT id, nombre, estado FROM tipo_casa WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$registro) {
        throw new Exception('No se encontró el tipo de documento');
    }

    // Respuesta exitosa - SOLO JSON
    echo json_encode([
        'status' => 'success',
        'message' => 'Datos obtenidos correctamente',
        'data' => [
            'id' => (int) $registro['id'],
            'nombre' => $registro['nombre'],
            'estado' => (int) $registro['estado']
        ]
    ]);

} catch (PDOException $e) {
    // Error de base de datos
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de base de datos',
        'error_code' => 'DB_ERROR'
    ]);

} catch (Exception $e) {
    // Error general
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_code' => 'GENERAL_ERROR'
    ]);
}