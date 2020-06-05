<?php
session_start();
// Almacena el permiso para agregar configuraciones especiales.
$superAdmin = $_SESSION['super_admin'];

date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
include 'libs/subalmacenesItemsPD.php';

$conn = new Conexion();
$conn->conectar();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
} else {
    $conn->conectar();
    $idUsuario = $_SESSION['usuario'];
    //Obtener datos del usuario
    $query = "SELECT * FROM t_users WHERE id = $idUsuario";
    try {
        $resp = $conn->obtDatos($query);
        if ($conn->filasConsultadas > 0) {
            foreach ($resp as $dts) {
                $idColaborador = $dts['id_colaborador'];
                $idPermiso = $dts['id_permiso'];
                $idDestino = $dts['id_destino'];
                $idFase = $dts['fase'];

                $query = "SELECT * FROM c_permisos WHERE id = $idPermiso";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $permiso = $dts['permiso'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }
                $accesoSA = "";
                $query = "SELECT * FROM c_acciones_usuarios WHERE id_usuario = $idUsuario";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $accesoSA = $dts['acceso_sa'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

                if ($accesoSA != "") {
                    $subalmacenes = explode(",", $accesoSA);
                } else {
                    $subalmacenes = [];
                }

                //Obtener datos del colaborador
                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $nombre = $dts['nombre'];
                            $apellido = $dts['apellido'];
                            $telefono = $dts['telefono'];
                            $email = $dts['email'];
                            $idCargo = $dts['id_cargo'];
                            $idSeccion = $dts['id_seccion'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }
            }
        }
    } catch (Exception $ex) {
        echo $ex;
    }
}
if ($idDestino == 10) {
    if (isset($_SESSION['idDestino'])) {
        $idDestinoT = $_SESSION['idDestino'];
    } else {
        $idDestinoT = $idDestino;
    }
} else {
    $idDestinoT = $idDestino;
}

$query = "SELECT * FROM c_destinos WHERE id = $idDestinoT";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $bandera = $dts['bandera'];
            $destino = $dts['destino'];
            $gp = $dts['gp'];
            $trs = $dts['trs'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAPHG</title>
        <link rel="icon" href="svg/logo6.png">
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/clases.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
        <style>
        .container-scroll {
            overflow-x: scroll;
            overflow-y: hidden;
            white-space: nowrap;
        }

        .btn-opciones {
            text-align: center;
            background: #f5f5f5;
            cursor: pointer;
        }

        #subalmacen-opcion {
            text-align: center;
            margin-bottom: 40px;
            margin-left: auto;
            margin-right: auto;
        }
        </style>
    </head>

    <body>


        <section class="">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column has-text-centered">
                            <img src="svg/logon.svg" width="190px" alt="" onclick="paginaInicio();">
                        </div>
                    </div>
                    <br>
                    <?php
                    if($superAdmin == 1){
                        $data ="                 
                            <div class=\"columns\">
                                <div class=\"column btn-opciones\">
                                    <div class=\"field is-grouped is-grouped-centered\">
                                        <p class=\"control\" onclick=\"agregarSubalmacen();\">
                                            <a class=\"button is-primary\">
                                                Agregar Subalmacén
                                            </a>
                                        </p>
                                        <p class=\"control\" onclick=\"modificarSubalmacen();\">
                                            <a class=\"button is-warning\">
                                                Editar Subalmacén
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class=\"column is-1 btn-opciones\">
                                    <span class=\"icon is-large\" onclick=\"paginaInicio();\">
                                        <i class=\"fas fa-sign-out fa-2x\"></i>
                                    </span>
                                </div>
                            </div>
                        ";
                        echo $data;
                    }else{
                        $data ="                 
                            <div class=\"columns\">
                                <div class=\"column is-right is-12 has-text-right\">
                                    <a class=\"icon is-large\" onclick=\"paginaInicio();\">
                                        Inicio <i class=\" mx-4 fas fa-sign-out fa-2x\"></i>
                                    </a>
                                </div>
                            </div>
                        ";
                        echo $data;                        
                    } 
                    ?>

                    <br>
                    <div class="columns mx-5 is-centered">
                        <div class="column">
                            <div class="columns">
                                <div class="column has-text-centered">
                                    <h1 class="title">GP</h1>
                                </div>
                            </div>
                            <?php
                        $fase = "GP";
                        if ($idDestinoT == 10) {
                            $query = "SELECT * FROM t_subalmacenes "
                                . "WHERE fase = '$fase' "
                                . "ORDER BY nombre";
                        } else {
                            $query = "SELECT * FROM t_subalmacenes "
                                . "WHERE fase = '$fase' "
                                . "AND id_destino = $idDestinoT "
                                . "ORDER BY nombre";
                        }

                        if ($fase == "GP") {
                            $bgButton = "is-gp";
                        } else if ($fase == "TRS") {
                            $bgButton = "is-trs";
                        } else {
                            $bgButton = "is-zi";
                        }
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $idSubalmacen = $dts['id'];
                                    $nombreSA = $dts['nombre'];
                                    echo "<div class=\"columns\">"
                                        . "<div class = \"column has-text-centered\">"
                                        . "<a class = \"button is-large $bgButton is-fullwidth\" href = \"menu.php?idSubalmacen=$idSubalmacen\"><span class = \"icon is-medium\"><i class = \"fas fa-sign-in-alt\"></i></span><span>$nombreSA</span></a>"
                                        . "</div>"
                                        . "</div>";
                                }
                            }
                        } catch (Exception $ex) {
                            echo $ex;
                            exit($ex);
                        }
                        ?>
                        </div>
                        <div class="column">
                            <div class="columns">
                                <div class="column has-text-centered">
                                    <h1 class="title">TRS</h1>
                                </div>
                            </div>
                            <?php
                        $fase = "TRS";
                        if ($idDestinoT == 10) {
                            $query = "SELECT * FROM t_subalmacenes "
                                . "WHERE fase = '$fase' "
                                . "ORDER BY nombre";
                        } else {
                            $query = "SELECT * FROM t_subalmacenes "
                                . "WHERE fase = '$fase' "
                                . "AND id_destino = $idDestinoT "
                                . "ORDER BY nombre";
                        }

                        if ($fase == "GP") {
                            $bgButton = "is-gp";
                        } else if ($fase == "TRS") {
                            $bgButton = "is-trs";
                        } else {
                            $bgButton = "is-zi";
                        }
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $idSubalmacen = $dts['id'];
                                    $nombreSA = $dts['nombre'];
                                    echo "<div class=\"columns\">"
                                        . "<div class = \"column has-text-centered\">"
                                        . "<a class = \"button is-large $bgButton is-fullwidth\" href = \"menu.php?idSubalmacen=$idSubalmacen\"><span class = \"icon is-medium\"><i class = \"fas fa-sign-in-alt\"></i></span><span>$nombreSA</span></a>"
                                        . "</div>"
                                        . "</div>";
                                }
                            }
                        } catch (Exception $ex) {
                            echo $ex;
                            exit($ex);
                        }
                        ?>
                        </div>
                        <div class="column">
                            <div class="columns">
                                <div class="column has-text-centered">
                                    <h1 class="title">ZONA INDUSTRIAL</h1>
                                </div>
                            </div>
                            <?php
                        $fase = "ZI";
                        if ($idDestinoT == 10) {
                            $query = "SELECT * FROM t_subalmacenes "
                                . "WHERE fase = '$fase' "
                                . "ORDER BY nombre";
                        } else {
                            $query = "SELECT * FROM t_subalmacenes "
                                . "WHERE fase = '$fase' "
                                . "AND id_destino = $idDestinoT "
                                . "ORDER BY nombre";
                        }

                        if ($fase == "GP") {
                            $bgButton = "is-gp";
                        } else if ($fase == "TRS") {
                            $bgButton = "is-trs";
                        } else {
                            $bgButton = "is-zi";
                        }
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $idSubalmacen = $dts['id'];
                                    $nombreSA = $dts['nombre'];
                                    echo "<div class=\"columns\">"
                                        . "<div class = \"column has-text-centered\">"
                                        . "<a class = \"button is-large $bgButton is-fullwidth\" href = \"menu.php?idSubalmacen=$idSubalmacen\"><span class = \"icon is-medium\"><i class = \"fas fa-sign-in-alt\"></i></span><span>$nombreSA</span></a>"
                                        . "</div>"
                                        . "</div>";
                                }
                            }
                        } catch (Exception $ex) {
                            echo $ex;
                            exit($ex);
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="modal-subalmacen" class="modal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p id="titulo-modal" class="modal-card-title">Modal title</p>
                    <button class="delete is-large cerrar-modal" aria-label="close"></button>
                </header>
                <section class="modal-card-body">

                    <div id="subalmacen-opcion" class="column field is-grouped is-grouped-centered">
                        <div class="control">
                            <div class="select">
                                <select id="optionId" onclick="obtenerSubalmacen();" name="" id="">
                                    <option value="">Seleccione el Subalmacén</option>
                                    <?php
                                if ($idDestinoT == 10) {
                                    $query = "SELECT* FROM t_subalmacenes  WHERE fase!='GP-eliminado' and fase!='TRS-eliminado' and fase!='ZI-eliminado'  ORDER BY nombre";
                                } else {
                                    $query = "SELECT* FROM t_subalmacenes WHERE id_destino=$idDestinoT  and fase!='GP-eliminado' and fase!='TRS-eliminado' and fase != 'ZI-eliminado'";
                                }
                                $result = mysqli_query($conn_2020, $query);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value=\"" . $row['id'] . "\">" . $row['nombre'] . "</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field is-grouped is-grouped-centered mb-4">
                        <div class="control">
                            <div class="select">
                                <select id="selectFase">
                                    <option value="">Seleccione la Fase</option>
                                    <option value="1">GP</option>
                                    <option value="2">TRS</option>
                                    <option value="3">ZI</option>
                                </select>
                            </div>
                        </div>

                        <div class="control">
                            <div class="select">
                                <select id="inputDestino">
                                    <option value="">Seleccione el Destino</option>
                                    <option value="1">RM</option>
                                    <option value="7">CMU</option>
                                    <option value="2">PVR</option>
                                    <option value="6">MBJ</option>
                                    <option value="5">PUJ</option>
                                    <option value="11">CAP</option>
                                    <option value="3">SDQ</option>
                                    <option value="4">SSA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input id="inputSubalmacen" class="input is-info" type="text"
                                placeholder="Nombre del Subalmacén">
                        </div>
                    </div>
                </section>
                <footer class="modal-card has-background-white">
                    <div class="control column has-text-centered">
                        <button id="btn-operacion" class="mx-2 button is-success is-medium"
                            onclick="subalmacen('');"></button>
                        <button id="btn-eliminar" class="mx-2 button is-danger is-medium"
                            onclick="subalmacen('eliminarSubalmacen');">Eliminar</button>
                        <button class="mx-2 button is-warning is-medium cerrar-modal">Cancelar</button>
                    </div>
                </footer>
            </div>
        </div>


    </body>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/bulmajs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../js/alertasSweet.js"></script>

    <script>
    function recargarPagina() {
        location.href = 'index.php';
    }

    function paginaInicio() {
        location.href = '../index.php';
    }


    $(".cerrar-modal").click(function() {
        $("#modal-subalmacen").removeClass(" is-active");
        $("#titulo-modal").html("");
    });



    function agregarSubalmacen() {
        $("#modal-subalmacen").addClass(" is-active");
        $("#btn-operacion").val("Agregar");
        $("#btn-operacion").html("Agregar");
        $("#titulo-modal").html("Nuevo Subalmacén");
        $("#subalmacen-opcion").css("display", "none");
        $("#btn-eliminar").addClass("modal");
    }



    function modificarSubalmacen() {
        $("#modal-subalmacen").addClass(" is-active");
        $("#btn-operacion").val("Actualizar");
        $("#btn-operacion").html("Actualizar");
        $("#titulo-modal").html("Modificar Subalmacén");
        $("#subalmacen-opcion").css("display", "flex");
        $("#btn-eliminar").removeClass("modal");
    }


    function obtenerSubalmacen() {
        var action = "consultaSubalmacen";
        var idSubalmacen = $("#optionId").val();

        $.ajax({

            type: "post",
            url: "libs/crud.php",
            data: {
                action: action,
                idSubalmacen: idSubalmacen
            },
            dataType: 'json',

            success: function(data) {
                $("#selectFase").val(data.fase);
                $("#inputSubalmacen").val(data.nombreSubalmacen);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Datos Obtenidos '
                })
            }
        });
    }


    function subalmacen(eliminarSubalmacen) {
        var action = $("#btn-operacion").val();
        var idDestino = $("#inputDestino").val();
        var idFase = $("#selectFase").val();
        var subalmacen = $("#inputSubalmacen").val();

        if (idFase != '' && subalmacen != '' && idDestino > 0) {

            if (action == "Agregar") {

                $.ajax({
                    type: "post",
                    url: "libs/crud.php",
                    data: {
                        action: action,
                        idDestino: idDestino,
                        idFase: idFase,
                        subalmacen: subalmacen
                    },

                    success: function(datos) {
                        if (datos = 1) {
                            alertaImg('Se agrego un Almacén', 'has-text-success', 'success', 3000);
                        } else {
                            alertaImg(datos, 'has-text-danger', 'error', 3000);
                        }
                        setTimeout(function() {
                            recargarPagina();
                        }, 1200);
                    }
                });
            }

            if (action == "Actualizar") {
                var idSubalmacen = $("#optionId").val();
                console.log(idSubalmacen);

                $.ajax({

                    type: "post",
                    url: "libs/crud.php",
                    data: {
                        action: action,
                        idDestino: idDestino,
                        idFase: idFase,
                        subalmacen: subalmacen,
                        idSubalmacen: idSubalmacen
                    },

                    success: function(datos) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Subalmacén Actualizado! '
                        })

                        setTimeout(function() {
                            recargarPagina();
                        }, 1200);
                    }
                });
            }

            if (eliminarSubalmacen == "eliminarSubalmacen") {
                var idSubalmacen = $("#optionId").val();
                var action = "eliminarSubalmacen";

                $.ajax({

                    type: "post",
                    url: "libs/crud.php",
                    data: {
                        action: action,
                        idDestino: idDestino,
                        idFase: idFase,
                        subalmacen: subalmacen,
                        idSubalmacen: idSubalmacen
                    },

                    success: function(datos) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Subalmacén Eliminado! '
                        })

                        setTimeout(function() {
                            recargarPagina();
                        }, 1200);
                    }
                });
            }
        } else {
            alertaImg('Algunos Campos Vacios', 'has-text-info', 'question', 3000);
        }

    }
    </script>

</html>