<?php
global $mysqli;
global $urlweb;
?>
  <!DOCTYPE html>
  <html>
    <head>
        <title>PixelPay Reto!</title>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <link rel="stylesheet" href="<?php echo $urlweb?>temas/css/estilo.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta property="og:image" content="https://www.pixel.hn/themes/pixelpay-theme/assets/images/_commun/og-image.png" />
      <link rel="shortcut icon" href="https://www.pixel.hn/themes/pixelpay-theme/assets/images/_commun/favicon.ico" />
      <link rel="icon" type="image/png" href="https://www.pixel.hn/themes/pixelpay-theme/assets/images/_commun/favicon.png" />  
    </head>
    <body>
        <div id="barra_superior" class="z-depth-1">
        <img width="200px" height="45px" class="responsive-img" src="https://www.pixel.hn/themes/pixelpay-theme/assets/images/_commun/logo.svg" alt="">
        <span class="blue-text">Suite de soluciones de pago</span>
        </div>
    <div id="main" class="container center z-depth-5 grey lighten-4">
        <img width="200px" height="45px" class="responsive-img" src="https://www.pixel.hn/themes/pixelpay-theme/assets/images/_commun/logo.svg" alt=""><br>
        <img width="500px" class="responsive-img" src="https://img.mailinblue.com/3020056/images/rnb/original/61a6a137a8e459762d30abb5.png" alt="">
            <h2 class="blue-text flow-text"><b>Challenge: Lista de quehaceres</b></h2>
            <p class="grey-text text-darken-2">Desarrolla una aplicación web donde sea capaz de agregar ítems en una lista de quehaceres y poder completar ítems de la lista.</p>
<div id="controls">
<div class="row">
   <div class="col s12 l4 offset-l3">
         <div class="input-field">
            <i class="material-icons prefix">format_list_bulleted</i>
            <input id="txt_item" type="text" class="validate">
            <label for="txt_item">Ingrese su item</label>
      </div>
   </div>
   <div class="col s12 l4">
        <a class="btn btn-large rounded  blue darken-2" href="javascript:send()"><i class="material-icons left">send</i>Agregar</a>
    </div>
</div>
</div>
    <div class="" id="controls-2">
        <div class="row">
            <div class="col l12 s12">
            <a class="btn red rounded btn-large" href="javascript:eliminar_todo()"><i class="material-icons left">content_cut</i>Eliminar Todo</a>
            <a class="btn green rounded btn-large" href="javascript:eliminar_seleccionados()"><i class="material-icons left">format_line_spacing</i>Elimiar Seleccionados</a>
            </div>
        </div>
    </div>
            <table id="tbldata" class="centered highlight responsive-table">
        <thead>
          <tr>
              <th>Identificador</th>
              <th>Nombre</th>
              <th>Done</th>
          </tr>
        </thead>

        <tbody id="tbody">
          <?php
    $strsql="SELECT id, nombre, estado, fecha_creacion FROM to_do WHERE activo=1 ORDER BY estado DESC";
    if($stmt = $mysqli->prepare($strsql)){
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows>0){
            $stmt->bind_result($id, $nombre, $estado, $fecha_creacion);
            while($stmt->fetch()){
                ?>
        <tr id="item-<?php echo $id ?>">
            <td><?php echo $id ?></td>
            <td><?php echo $nombre ?></td>
            <td><label><input id="input-<?php echo $id ?>" class="checkbox" type="checkbox" onclick="estado('<?php echo $id ?>')"  <?php if ($estado==1) echo "checked"; ?> /><span></span></label></td>
        </tr>
            <?php
            }
        }else{
            echo "No hay datos a mostrar";
        }
    }else{
        echo "No se pudo preparar la consulta";
    }
    ?>
        </tbody>
      </table>
    </div>
    <div>
        <p class="blue-text">Powered by: Marco Aleman Watters.</p>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
        function estado(id) {
        var miCheckbox = document.getElementById("input-" + id);
        if (miCheckbox.checked) {
            var estado = 1;

        } else {
            var estado = 0;
        }
        var url = '<?php echo $urlweb?>api/to_do.php?accion=estado';
        var data = {
            id: id,
            estado: estado
        };
        console.log(data);
        fetch(url, {
                method: 'POST',
                body: JSON.stringify(data)
            }).then(res => res.json())
            .catch(error => M.toast({
                html: error.text
            }))
            .then(response => {
                M.toast({
                    html: response.text
                });
            });
    }

function send() {
    var item = document.getElementById("txt_item").value;
    if (item != "") {
        var url = '<?php echo $urlweb?>api/to_do.php?accion=agregar';
        var data = {
            item: item
        };
        fetch(url, {
                method: 'POST',
                body: JSON.stringify(data)
            }).then(res => res.json())
            .then(response => {
                M.toast({
                    html: response.text
                });
                document.getElementById("tbody").innerHTML += response.html;
                document.getElementById("txt_item").value = "";
            })
            .catch(error => M.toast({
                html: error.text
            }))
    } else {
        M.toast({
            html: "No puede dejar campos vacios"
        })
    }
}

function eliminar_todo() {
    var url = '<?php echo $urlweb?>api/to_do.php?accion=eliminar_todo';
    fetch(url, {
            method: 'POST'
        }).then(res => res.json())
        .then(response => {
            M.toast({
                html: response.text
            });
            document.getElementById("tbody").innerHTML = "";
        })
        .catch(error => M.toast({
            html: error.text
        }))
}

function eliminar_seleccionados() {
    var checks = document.querySelectorAll('.checkbox');
    var id_array = [];
    checks.forEach((e) => {
        if (e.checked == true) {
            id_array.push(e.id.slice(6));
            const element = document.getElementById("item-" + e.id.slice(6));
            element.remove();
        }
    });
    var url = '<?php echo $urlweb?>api/to_do.php?accion=eliminar_seleccionados';
    fetch(url, {
            method: 'POST',
            body: JSON.stringify(id_array)
        }).then(res => res.json())
        .then(response => {
            M.toast({
                html: response.text
            });

        })
        .catch(error => M.toast({
            html: error.text
        }))
} 
</script>
    </body>
  </html>
