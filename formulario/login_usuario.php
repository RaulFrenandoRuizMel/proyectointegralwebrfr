<?php
session_start();
include 'conexion_1.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usu'], $_POST['password_usu'])) {
    
    $id_usu = $_POST['id_usu'];
    $password = $_POST['password_usu'];
    //$rol_seleccionado = $_POST['rol'];
    
    // Validar que no estén vacíos
    if (empty($id_usu) || empty($password)) {
        header("Location: index.php?error=vacio");
        exit();
    }
    
    try {
        // Buscar el usuario por ID
        $stmt = $conn->prepare("SELECT id_usu, usuario_usu, password_usu, rol FROM usuarios WHERE id_usu = ?");
        $stmt->execute([$id_usu]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si el usuario existe
        if ($user) {
            
            // Verificar contraseña
            if (password_verify($password, $user['password_usu'])) {
                
                // Login exitoso - Crear sesión
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id_usu'];
                $_SESSION['usuario'] = $user['usuario_usu'];
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['loggedin'] = true;
                
                // Redirigir directamente según el rol guardado en BD
                if ($user['rol'] == 'Admin') {
                    header("Location: formulario_usuario.html");
                    exit();
                } elseif ($user['rol'] == 'Docente') {
                    header("Location: formulario_alumno.php");
                    exit();
                } elseif ($user['rol'] == 'Usuario') {
                    header("Location: formulario_grupo.php");
                    exit();
                } else {
                    header("Location: index.php?error=rol");
                    exit();
                }
                
            } else {
                // Contraseña incorrecta
                header("Location: index.php?error=datos_contrasena");
                exit();
            }
            
        } else {
            // Usuario no encontrado
            header("Location: index.php?error=datos_usuario");
            exit();
        }
        
    } catch (PDOException $e) {
        die("Error en la consulta: " . $e->getMessage());
    }
    
} else {
    header("Location: index.php");
    exit();
}
?>