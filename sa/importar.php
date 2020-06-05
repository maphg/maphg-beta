<?php
include 'libs/conexion.php';
$conn = new Conexion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAPHG</title>
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/clases.css">
    </head>
    <body>
        <section>
            <div class="columns">
<!--                <div class="column">
                    <select id="cbTipo">
                        <option value="sinOrden">Pedidos sin orden de compra</option>
                        <option value="conOrden">Pedidos con orden de compra</option>
                    </select>
                </div>-->
                <div class="column">
                    <input id="txtFile" type="file" name="txtFile" onchange="importarStock();">
                </div>
            </div>            
        </section>
        <section>
            <div class="columns">
                <div class="column">
                    <h1 id="loading" style="display: none;">Cargando...</h1>
                </div>
            </div>
        </section>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="js/stock.js"></script>
</html>
