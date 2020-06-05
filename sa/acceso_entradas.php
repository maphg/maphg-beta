<?php
$idSubalmacen = $_GET['idSubalmacen'];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAPHG</title>
        <link rel="icon" href="svg/logo6.png">
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <style>
            .container-scroll {
                overflow-x: scroll;
                overflow-y: hidden;
                white-space: nowrap;
            }
        </style>
    </head>

    <body>


        <section class="hero is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column has-text-centered">
                            <img src="svg/logon.svg" width="190px" alt="">
                        </div>
                    </div>
                    <div class="columns is-centered">

                        <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                            
                                <div class="field">
                                    <label for="" class="label">Código de acceso</label>
                                    <div class="control has-icons-left">
                                        <input id="txtCodigoAcceso" type="number" placeholder="codigo de acceso" class="input is-large" required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="field">
                                    <button id="btnLogin" type="button" class="button is-fullwidth" onclick="validarAcceso(<?php echo $idSubalmacen; ?>, 'entradas');">
                                        Acceder
                                    </button>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="js/bulmajs.js"></script>
    <script src="js/acceso.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</html>
