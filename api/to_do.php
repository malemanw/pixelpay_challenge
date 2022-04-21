<?php
require "../config.php";
$text = "Error desconocido";
$html = "";
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "default";
switch($accion){
case "estado":
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $id = $data->id;
    if(isset($id)){
        $estado = $data->estado;
        $strsql = "UPDATE `to_do` SET estado=? where id=?";
        if($stmt = $mysqli->prepare($strsql)){
            $stmt->bind_param("ii", $estado, $id);
            $stmt->execute();
            if($stmt->errno == 0){
                $text= "El registro actualizó exitosamente!";
            }else{
                $text = "No se pudo eliminar el registro";
            }
        }else{
            $text= "No se ejecuto la consulta";
        }
    }else{
        $text= "No se recibieron parametros.";
    }

    break;
    case "agregar":
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $item = $data->item;
        if(isset($item)){
            $strsql = "INSERT INTO to_do (nombre) VALUES (?)";
            if($stmt = $mysqli->prepare($strsql)){
                $stmt->bind_param("s", $item);
                $stmt->execute();
                if($stmt->errno == 0){
                    $text= "El registro agregó exitosamente!";
                    $id = $stmt->insert_id;
                    $html = "<tr id=\"item-$id\"><td>$id</td><td>$item</td><td><label><input id=\"input-$id\" type=\"checkbox\" checked onclick=\"estado('$id')\" /><span></span></label></td></tr>";
                }else{
                    $text = "No se pudo eliminar el registro";
                }
            }else{
                $text= "No se ejecuto la consulta";
            }
        }else{
            $text= "No se recibieron parametros.";
        }
    break;
    case "eliminar_todo":
        $strsql = "UPDATE `to_do` SET activo=0";
        if($stmt = $mysqli->prepare($strsql)){
            $stmt->execute();
            if($stmt->errno == 0){
                $text= "Registros eliminados!";
                $html = "No hay datos a mostrar";
            }else{
                $text = "No se pudieron eliminar los registro";
            }
        }else{
            $text= "No se ejecuto la consulta";
        }

    break;
    case "eliminar_seleccionados":
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        if(isset($json)){
            foreach($data as $id){
            $strsql = "UPDATE `to_do` SET activo=0 where id=?";
            if($stmt = $mysqli->prepare($strsql)){
                $stmt->bind_param("i", $id);
                $stmt->execute();
                if($stmt->errno == 0){
                    $text= "Se eliminaron los items seleccionados!";
                }else{
                    $text = "No se pudo eliminar el registro";
                }
            }else{
                $text= "No se ejecuto la consulta";
            }
            }
        }else{
            $text= "No se recibieron parametros.";
        }
    break;
}   

$jsonreturn = array(
    "text"=>$text,
    "html"=>$html
);

echo json_encode($jsonreturn);
?>