<?php
$servidor = "localhost";
$basedatos = "pixelpay_1";
$usuario = "root";
$password = "";
$mysqli = new mysqli($servidor, $usuario, $password, $basedatos);
if($mysqli->connect_errno){
    echo $mysqli->connect_error;
}
mysqli_set_charset($mysqli, "utf8");
$urlweb = "http://localhost/pixelpay_reto1/";
?>