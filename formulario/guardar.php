<?php
ob_start();

include 'conexion_1.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario_usu'], $_POST['password_usu'], $_POST['rol'])) {

    $usuario = $_POST['usuario_usu'];
    $password = $_POST['password_usu'];
    $rol = $_POST['rol'];
 
    // IMPORTANTE: Hashear la contraseña antes de guardarla
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario_usu, password_usu, rol) VALUES (?, ?, ?)");

    if ($stmt === false) {
        die("Error en la preparación: " . $conn->errorInfo()[2]);
    }
    
    // Ejecutar con los parámetros
    if ($stmt->execute([$usuario, $password_hash, $rol])) {
        ob_end_clean();
		header("Location: formulario_personal.php");
        exit();
    } else {
        $error = $stmt->errorInfo();
        echo "Error al ejecutar: " . $error[2];
    }
    
} else {
    echo "Error: acceso no permitido o faltan datos.";
}

ob_end_flush();
?>