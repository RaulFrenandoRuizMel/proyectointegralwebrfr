<?php
$servername     = "fdb1028.awardspace.net";
$username       = "4554128_kinder";
$password       = "-)^ZU7fW6:Ei;;I[";
$dbname         = "4554128_kinder";
 
 
//crear conexion
$conn = new mysqli($servername, $username, $password, $dbname);
 
 
//verificar conexion
if($conn -> connect_error){
    die("La conexion ha fallado: ". $conn -> connect_error);
}
echo "Bienvenido tu conexion funciono";
 
 
?>