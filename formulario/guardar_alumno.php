<?php
ob_start();

include 'conexion_1.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_grupo'],$_POST['nombre_alu'], $_POST['apellidos_alu'])) {

    $id_grupo = $_POST['id_grupo'];

    $nombres = $_POST['nombre_alu'];

    $apellidos = $_POST['apellidos_alu'];

    //Guarda los tres datos enviados desde el formualrio eb variable php para usuarios despues.

    $stmt = $conn->prepare("INSERT INTO alumnos (id_grupo, nombre_alu, apellidos_alu) VALUES (?,?,?)");

    if($stmt === false){
        die("X Error en la consulta SQL: " . $conn->error);
    }
    if(headers_sent($file,$line)){
        die("Headers ya enviados en $file linea $line");
    }
    if ($stmt->execute([$id_grupo, $nombres, $apellidos])){
        ob_end_clean();
        header("Location: formulario_alumno.php");
        exit();
    }else{
            $error = $stmt->errorInfo();
            echo "Error al ejectiutar: ". $error[2];
            }
}else{
        echo "Error acceso no permitido o falta datos.";
}
?>