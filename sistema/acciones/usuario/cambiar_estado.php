<?php
header('Content-Type: application/json');
//ESTE HEDEAR SIRVE PARA EVITAR QUE EL NAVEGADOR ALMACENE EN CACHE LA RESPUESTA
header('Cache-Control: no-cache, must-revalidate');

require_once '../../bd/conexion2.php';

try {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        throw new Exception('Método no permitido');
    }
    
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $estadoInput =  isset($_POST['estado']) ? ($_POST['estado']) : null;

    //convertir el estado a texto (String)
    $estado = ($estadoInput == 1 || $estadoInput== '1')? '1' : '0';


    if ($id <= 0) {
        throw new Exception('ID invalido');
    }
    
    if ($estadoInput !== 0 && $estadoInput !== 1 && $estadoInput !== '0' && $estadoInput !== '1') {
        throw new Exception('Estado no válido');
    }
    
    $sqlVerificar = "SELECT id, nombre, estado FROM usuarios WHERE id = :id";
    $stmtVerificar = $conn -> prepare($sqlVerificar);
    $stmtVerificar->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtVerificar -> execute();

    $usuarios=$stmtVerificar->fetch(PDO::FETCH_ASSOC);

    if (!$usuarios) {
        throw new Exception('Usuario no encontrado');
    }

    //ENUM RECIBE TEXTO, NO ENTEROS
    // Verificar si ya tiene el estado que se quiere asignar
    if ($usuarios['estado'] === $estado) {
        $estadoTexto = $estado === '1' ? 'activo' : 'inactivo';
        throw new Exception("El usuario ya se encuentra {$estadoTexto}");
    }

    $sqlActualizar="UPDATE usuarios SET estado = :estado WHERE id= :id";
    $stmtActualizar = $conn -> prepare($sqlActualizar);
    $stmtActualizar ->bindParam(':estado',$estado, PDO::PARAM_STR);
    $stmtActualizar ->bindParam(':id', $id, PDO::PARAM_INT);
    if($stmtActualizar->execute()){
        $accion= $estado === '1' ? 'activo' : 'inactivo';
        $response = [
            'status' => 'success',
            'message' => "Usuario '{$usuarios['nombre']}' {$accion} correctamente"
        ];
    } else {
        throw new Exception('Error al actualizar el estado del usuario');
    }
    
}catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
} catch (PDOException $e) {
    $response = [
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ];
}

// Enviar respuesta JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
?>