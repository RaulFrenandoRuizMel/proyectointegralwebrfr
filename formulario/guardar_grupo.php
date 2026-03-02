<?php
ob_start();

include 'conexion_1.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usu'],$_POST['grupo_grp'])) {

    $id_usu = $_POST['id_usu'];

    $grupo = $_POST['grupo_grp'];

    //Guarda los tres datos enviados desde el formualrio eb variable php para usuarios despues.

    $stmt = $conn->prepare("INSERT INTO grupo (id_usu, grupo_grp) VALUES (?,?)");

    if($stmt === false){
        die("X Error en la consulta SQL: " . $conn->error);
    }
    if(headers_sent($file,$line)){
        die("Headers ya enviados en $file linea $line");
    }
    if ($stmt->execute([$id_usu, $grupo])){
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