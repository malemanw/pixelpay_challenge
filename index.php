<?php
require "config.php";
$modulo = isset($_GET["modulo"]) ? $_GET["modulo"]: "inicio";
require "temas/index.php";
?>