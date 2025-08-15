<?php
require_once '../bd/conexion2.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    try{
        $logs="INSERT INTO logs (usuario_id, ip_address, accion, descripcion, nivel, modulo, timestamp) VALUES (:user_id, :ip, 'LOGOUT', 'cierre de seccion', 'INFO', 'AUTH', NOW())";
        $stmt=$conn->prepare($logs);
        $stmt->bindParam('user_id', $user_id);
        $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
        stmt->execute();
    } catch (Exception $e) {
         error_log("Error en logout: " . $e->getMessage());
    }
}

//DESTRUIR A LA SESIÓN
$_SESSION = array();
session_destroy();

header('Location: ../../login.php?logout=success');
exit();
?>