<?php

// Segunda parte del conexion 5

// Utilizacion de archivs externos y separacion de credenciales

// configuraciones

require 'conexion_5_1.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("La conexion ha fallado: ". $conn->connect_error);
}

echo "Si la pagia esta en blanco, siginfica que algo esta mal, sino, pues hola :)";
?>