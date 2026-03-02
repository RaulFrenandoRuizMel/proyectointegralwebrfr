<?php
ob_start();

include 'conexion_1.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usu'],$_POST['maestro'], $_POST['correo'], $_POST['celular'])) {

    $id_usu = $_POST['id_usu'];

    $maestro = $_POST['maestro'];

    $correo  = $_POST['correo'];

    $celular     = $_POST['celular'];
 
    //Guarda los tres datos enviados desde el formualrio eb variable php para usuarios despues.

    $stmt = $conn->prepare("INSERT INTO personal (id_usu, maestro, correo, celular) VALUES (?,?,?,?)");

    if($stmt === false){
        die("X Error en la consulta SQL: " . $conn->error);
    }
    if(headers_sent($file,$line)){
        die("Headers ya enviados en $file linea $line");
    }
    if ($stmt->execute([$id_usu, $maestro, $correo, $celular])){
        ob_end_clean();
        header("Location: formulario_grupo.php");
        exit();
    }else{
            $error = $stmt->errorInfo();
            echo "Error al ejectiutar: ". $error[2];
            }
}else{
        echo "Error acceso no permitido o falta datos.";
}
?>