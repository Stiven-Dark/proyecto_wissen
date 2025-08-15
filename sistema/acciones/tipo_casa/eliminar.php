<?php
require_once '../../bd/conexion2.php';

if(isset($_POST['id'])){
    $id=$_POST['id'];
    try {
        $sql="UPDATE tipo_casa d SET estado='0' WHERE id=:id";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Tipo de documento eliminado correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el registro.']);
        }
    }catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}else{ 
    echo json_encode(['status' => 'error', 'message' => 'ID no recibido.']);
}
?>