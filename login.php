<?php
require_once 'sistema/bd/conexion2.php';

if(isset($_POST['acceder'])){
    try {
        $email = trim($_POST['username']); 
        $password = trim($_POST['Password']);
    
        if(empty($email) || empty($password)){
            $_SESSION['error'] = 'Por facor complete todos los campos';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = 'Por favor ingrese un email válido';
        }

        else {
            $sql="SELECT u.id, u.nombre, u.correo, u.telefono, u.contrasena, u.estado, tr.id_rol, tr.nombre_rol, tr.estado as rol_activo FROM usuarios u  
            JOIN tipo_rol tr on u.rol = tr.id_rol
            WHERE  u.correo = :email";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':email',$email);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!$usuario){
                $_SESSION['error'] = 'Credenciales incorrectas';
                error_log("Intento de login fallido - Email no encontrado: " . $email . " - IP: " . $_SERVER['REMOTE_ADDR']);
            } elseif($usuario['estado'] != 1){
                $_SESSION['error'] = 'Su cuenta está desactivada. Contacte al administrador';
            } elseif($usuario['rol_activo'] != 1) {
                $_SESSION['error'] = 'Su rol está desactivado. Contacte al administrador';
            }

            else{
                $password_valido = false;

                if(password_verify($password,$usuario['contrasena'])){
                    $password_valido = true;
                }
                // Método 2: Si usas hash MD5/SHA1 (menos seguro, pero común)
                elseif ($usuario['contrasena'] === md5($password)) {
                    $password_valido = true;
                }
                elseif ($usuario['contrasena'] === sha1($password)) {
                    $password_valido = true;
                }
                elseif ($usuario['contrasena'] === hash('sha256', $password)) {
                    $password_valido = true;
                }
                // Método 3: Si la contraseña está en texto plano (desarrollo)
                elseif ($usuario['contrasena'] === $password) {
                    $password_valido = true;
                }


                if($password_valido){
                    $_SESSION['user_id'] = $usuario['id'];
                    $_SESSION['user_nombre'] = $usuario['nombre'];
                    $_SESSION['user_correo'] = $usuario['correo'];
                    $_SESSION['user_telefono'] = $usuario['telefono'];
                    $_SESSION['user_rol_id'] = $usuario['id_rol'];
                    $_SESSION['user_rol_nombre'] = $usuario['nombre_rol'];
                    $_SESSION['login_time'] = time();
                    $_SESSION['last_activity'] = time();    
                    
                    try{
                        $logs_sql="INSERT INTO logs (usuario_id, ip_address, user_agent, accion, tabla, descripcion, nivel, modulo, timestamp) VALUES (:user_id, :ip, :user_agent, 'LOGIN', 'usuarios', 'login exitoso', 'INFO', 'AUTH',  NOW())";
                        $stmt_logs=$conn->prepare($logs_sql);
                        $stmt_logs->bindParam('user_id', $usuario['id']);
                        $stmt_logs->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
                        $stmt_logs->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
                        $stmt-> execute();
                    } catch (Exception $e) {
                        error_log("Error al insertar log: " . $e->getMessage());
                    }

                    header('location: sistema/index.php');
                }
                else {
                    // Contraseña incorrecta
                    $_SESSION['error'] = 'Credenciales incorrectas';
                    
                    // Log del intento fallido
                    error_log("Login fallido - Password incorrecto para: " . $email . " - IP: " . $_SERVER['REMOTE_ADDR']);
                }
            }
        }
    } catch (PDOException  $e){
        $_SESSION['error'] = 'Error de conexión. Intente nuevamente';
        error_log("Error en login: " . $e->getMessage());
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error inesperado. Contacte al administrador';
        error_log("Error general en login: " . $e->getMessage());
    }
}

try{ 
    $empresa_sql="SELECT imagen FROM empresa";
    $stmt_empresa=$conn->prepare($empresa_sql);
    $stmt_empresa->execute();
    $row = $stmt_empresa->fetch();
    $rutaImagen = isset($row['imagen']) ? $row['imagen'] : 'assets/img/Logo.png';
} catch (PDOException $e) {
    $rutaImagen = '.assets/img/Logo.png';
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        :root {
            --primary-color: #7dee3bff;
            --primary-hover: #005f92;
            --bg-gradient: linear-gradient(135deg, #e3f2fd 0%, #f5fbff 100%);
            --card-shadow: 0 10px 30px rgba(0, 80, 130, 0.18);
            --input-bg: rgba(249, 251, 253, 0.9);
            --text-primary: #2d3a4a;
            --text-secondary: #5a6a7a;
            --border-radius: 12px;
            --transition-smooth: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
            background-color: rgba(235, 245, 255, 0.6);
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .card {
            width: 100%;
            border: none;
            border-radius: var(--border-radius);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: var(--card-shadow), 0 1px 5px rgba(0, 0, 0, 0.05);
            padding: 35px;
            transition: var(--transition-smooth);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 80, 130, 0.25);
        }

        .logo-container {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 20px;
            perspective: 1000px;
        }

        .logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
            border: 4px solid rgba(0, 119, 182, 0.8);
            padding: 4px;
            background-color: white;
            box-shadow: 0 8px 20px rgba(0, 119, 182, 0.25);
            transition: var(--transition-smooth);
        }

        .title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-size: 1.7rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 25px;
            letter-spacing: 0.2px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #d1e3f5;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition-smooth);
            background: var(--input-bg);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            color: var(--text-primary);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.15);
            background: white;
        }

        .btn-primary {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0077b6 0%, #005f92 100%);
            border: none;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            margin-top: 10px;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 15px rgba(0, 119, 182, 0.25);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 119, 182, 0.35);
            background: linear-gradient(135deg, #0088cc 0%, #0077b6 100%);
        }

        .btn-primary:active {
            transform: translateY(1px);
            box-shadow: 0 2px 10px rgba(0, 119, 182, 0.2);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover::after {
            left: 100%;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .footer-text a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .footer-text a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .alert-danger {
            border-radius: 10px;
            border-left: 4px solid #dc3545;
            padding: 12px 15px;
            margin-bottom: 20px;
            background: rgba(220, 53, 69, 0.1);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @media (max-width: 480px) {
            .card {
                padding: 25px;
            }
            
            .logo-container {
                width: 110px;
                height: 110px;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .form-control {
                padding: 10px 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="text-center">
                <div class="logo-container">
                    <img src="<?php echo $rutaImagen; ?>" alt="Logo" class="logo" id="logo">
                </div>
                <h4 class="title">Bienvenido</h4>
                <p class="subtitle">Por favor, inicie sesión para continuar</p>
            </div>

            <!-- Mostrar error si existe -->
            <?php
            if(isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error:</strong> ' . $_SESSION['error'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                unset($_SESSION['error']); // Limpiar el error después de mostrarlo
            }
            ?>

            <?php
            if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Sesión cerrada!</strong> Has cerrado sesión exitosamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
            }

            if (isset($_GET['timeout']) && $_GET['timeout'] === '1') {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Sesión expirada!</strong> Su sesión ha expirado por inactividad.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
            }
            ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="username" placeholder="ejemplo@correo.com" name="username" required>
                </div>
                <div class="form-group">
                    <label for="Password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="Password" placeholder="Ingrese su contraseña" name="Password">
                </div>
                <button type="submit" class="btn btn-primary" name="acceder">Iniciar sesión</button>
            </form>
            <div class="footer-text">
                <span>¿Olvidaste tu contraseña? <a href="#">Recuperar</a></span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efecto 3D suave para el logo
        const logo = document.getElementById('logo');
        const logoContainer = document.querySelector('.logo-container');
        
        document.addEventListener('mousemove', (e) => {
            if (!logo) return;
            
            // Calcular la posición relativa del mouse
            const containerRect = logoContainer.getBoundingClientRect();
            const containerCenterX = containerRect.left + containerRect.width / 2;
            const containerCenterY = containerRect.top + containerRect.height / 2;
            
            // Calcular la distancia desde el centro (entre -1 y 1)
            const maxRotation = 10; // Grados máximos de rotación
            const maxMovement = 5; // Píxeles máximos de movimiento
            
            // Solo aplicar efecto si el mouse está cerca del logo
            const distanceX = e.clientX - containerCenterX;
            const distanceY = e.clientY - containerCenterY;
            const distance = Math.sqrt(distanceX * distanceX + distanceY * distanceY);
            
            if (distance < containerRect.width * 2) {
                const rotateY = maxRotation * (distanceX / containerRect.width);
                const rotateX = -maxRotation * (distanceY / containerRect.height);
                
                requestAnimationFrame(() => {
                    logo.style.transform = `
                        perspective(1000px)
                        rotateX(${rotateX}deg)
                        rotateY(${rotateY}deg)
                        scale(1.05)
                    `;
                });
            } else {
                // Regresar a posición normal cuando el mouse está lejos
                logo.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
            }
        });
        
        // Regresar a estado normal cuando el mouse sale de la ventana
        document.addEventListener('mouseleave', () => {
            if (!logo) return;
            logo.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
        });
    </script>
</body>
</html>