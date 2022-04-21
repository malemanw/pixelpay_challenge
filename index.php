<?php
require "config.php";
require "funciones.class.php";
$funciones = new funciones($mysqli);
$modulo = isset($_GET["modulo"]) ? $_GET["modulo"]: "inicio";
require "temas/index.php";
?>