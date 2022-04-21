<?php

class funciones{
    var $mysqli;
    
    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    function modulo($idmodulo){
        if(file_exists("views/$idmodulo.php")){
            require "views/$idmodulo.php";
        }else{
            echo "<img src=\"https://www.gstatic.com/youtube/src/web/htdocs/img/monkey.png\">";
        }
    }
}
?>