<?php
$servername     = "fdb1028.awardspace.net";
$username       = "4554128_kinder";
$password       = "-)^ZU7fW6:Ei;;I[";
$dbname         = "4554128_kinder";

$conn = mysqli_init();

$conn->ssl_set(NULL, NULL, NULL, NULL, NULL);

if(!$conn->real_connect($servername, $username, $password, $dbname)){
    die("La conexion ha fallado: ". mysqli_connect_error());
}

echo "En efecto, esat conectado";
?>