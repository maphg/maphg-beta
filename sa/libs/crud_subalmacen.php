<?php
include "conexion.php";
session_start();

if (isset($_POST['action'])) {
    // Variables Globales.
    $idDestino = $_SESSION['idDestino'];
    $idUsuario = $_SESSION['usuario'];
    $superAdmin = $_SESSION['super_admin'];

    $action = $_POST['action'];

    if ($action == "Agregar") {
        $idDestino = $_POST['idDestino'];
        $idFase = $_POST['idFase'];
        $subalmacen = $_POST['subalmacen'];

        switch ($idFase) {
            case 1:
                $fase = "GP";
                break;

            case 2:
                $fase = "TRS";
                break;

            case 3:
                $fase = "ZI";
                break;
        }


        $query = "INSERT INTO  t_subalmacenes(id_destino, id_fase, nombre, fase) VALUES($idDestino, $idFase, '$subalmacen', '$fase')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "1";
        } else {
            echo "0";
        }
    }

    if ($action == "Actualizar") {
        $idDestino = $_POST['idDestino'];
        $idFase = $_POST['idFase'];
        $subalmacen = $_POST['subalmacen'];
        $idSubalmacen = $_POST['idSubalmacen'];

        switch ($idFase) {
            case 1:
                $fase = "GP";
                break;

            case 2:
                $fase = "TRS";
                break;

            case 3:
                $fase = "ZI";
                break;
        }


        $query = "UPDATE  t_subalmacenes SET nombre='$subalmacen', id_fase=$idFase,  fase='$fase' WHERE id=$idSubalmacen";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Agregado";
        } else {
            echo "Error Agregar";
        }
    }

    if ($action == "eliminarSubalmacen") {
        $idDestino = $_POST['idDestino'];
        $idFase = $_POST['idFase'];
        $subalmacen = $_POST['subalmacen'];
        $idSubalmacen = $_POST['idSubalmacen'];

        switch ($idFase) {
            case 1:
                $fase = "GP-eliminado";
                break;

            case 2:
                $fase = "TRS-eliminado";
                break;

            case 3:
                $fase = "ZI-eliminado";
                break;
        }


        $query = "UPDATE  t_subalmacenes SET fase='$fase' WHERE id=$idSubalmacen";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Agregado";
        } else {
            echo "Error Agregar";
        }
    }



    if ($action == "consultaSubalmacen") {
        $arraSubalmacen = array();
        $dataGP = "";
        $dataTRS = "";
        $dataZI = "";

        $query = "SELECT 
        id, id_destino, id_fase, nombre, fase 
        FROM t_subalmacenes 
        WHERE id_destino=$idDestino AND activo = 1";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            $idSubalmacen = $row['id'];
            $idFase = $row['id_fase'];
            $nombre = $row['nombre'];
            $fase = $row['fase'];

            if ($superAdmin == 1) {
                if ($fase == "GP") {
                    $dataGP .= "
                        <div class=\"block-flex bg-blue-400 my-2 rounded-md\">
                        <a class = \"\" href = \"menu.php?idSubalmacen=$idSubalmacen\">
                        <button class=\"w-4/6 hover:bg-blue-500 text-gray-700 py-2 px-4 rounded-l text-left\">
                        <i class=\"fas fa-chevron-right\"></i>
                        $nombre
                        </button>
                        </a>
                        <span class=\"w-1/6 font-bold py-2 px-4 rounded-r\">
                        <i class=\"fas fa-edit hover:text-white\" onclick=\"editarSubalmacen($idSubalmacen, '$nombre');\">
                        </i>
                        
                        <i class=\"fas fa-trash hover:text-white\" onclick=\"eliminarSubalmacen($idSubalmacen, '$nombre');\">
                        </i>
                        </span>
                        </div>            
                    ";
                } elseif ($fase == "TRS") {
                    $dataTRS .= "
                        <div class=\"block-flex bg-blue-400 my-2 rounded-md\">
                        <a class = \"\" href = \"menu.php?idSubalmacen=$idSubalmacen\">
                        <button class=\"w-4/6 hover:bg-blue-500 text-gray-700 py-2 px-4 rounded-l\">
                        <i class=\"fas fa-chevron-right\"></i>
                        $nombre
                        </button>
                        </a>
                        <span class=\"w-1/6 font-bold py-2 px-4 rounded-r\">
                        <i class=\"fas fa-edit hover:text-white\" onclick=\"editarSubalmacen($idSubalmacen,'$nombre');\">
                        </i>
                        <i class=\"fas fa-trash hover:text-white\" onclick=\"eliminarSubalmacen($idSubalmacen, '$nombre');\">
                        </i>
                        </span>
                        </div>            
                    ";
                } elseif ($fase == "ZI") {
                    $dataZI .= "
                        <div class=\"block-flex bg-blue-400 my-2 rounded-md\">
                        <a class = \"\" href = \"menu.php?idSubalmacen=$idSubalmacen\">
                        <button class=\"w-4/6 hover:bg-blue-500 text-gray-700 py-2 px-4 rounded-l\">
                        <i class=\"fas fa-chevron-right\"></i>
                        $nombre
                        </button>
                        </a>
                        <span class=\"w-1/6 font-bold py-2 px-4 rounded-r\">
                        <i class=\"fas fa-edit hover:text-white\" onclick=\"editarSubalmacen($idSubalmacen, '$nombre');\">
                        </i>
                        
                        <i class=\"fas fa-trash hover:text-white\" onclick=\"eliminarSubalmacen($idSubalmacen, '$nombre');\">
                        </i>
                        </span>
                        </div>            
                    ";
                }
            } elseif ($superAdmin == 0) {
                if ($fase == "GP") {
                    $dataGP .= "
                    <a class = \"\" href = \"menu.php?idSubalmacen=$idSubalmacen\">
                        <button class=\"text-left block-flex bg-blue-400 my-2 rounded-md w-full py-2 px-4 hover:bg-blue-500 text-gray-700\">
                        <i class=\"fas fa-chevron-right\"></i>
                                $nombre
                        </button>      
                        </a>      
                    ";
                } elseif ($fase == "TRS") {
                    $dataTRS .= "
                    <a class = \"\" href = \"menu.php?idSubalmacen=$idSubalmacen\">
                        <button class=\"text-left block-flex bg-blue-400 my-2 rounded-md w-full py-2 px-4 hover:bg-blue-500 text-gray-700\">
                        <i class=\"fas fa-chevron-right\"></i>
                                $nombre 
                        </button> 
                        </a>           
                    ";
                } elseif ($fase == "ZI") {
                    $dataZI .= "
                    <a class = \"\" href = \"menu.php?idSubalmacen=$idSubalmacen\">
                    <button class=\"text-left block-flex bg-blue-400 my-2 rounded-md w-full py-2 px-4 hover:bg-blue-500 text-gray-700\">
                    <i class=\"fas fa-chevron-right\"></i>
                    $nombre
                    </button>            
                    </a>
                    ";
                }
            }
        }

        $arraSubalmacen['dataGP'] = $dataGP;
        $arraSubalmacen['dataTRS'] = $dataTRS;
        $arraSubalmacen['dataZI'] = $dataZI;

        echo json_encode($arraSubalmacen);
    }


    if ($action == "agregarSubalmacen") {
        // $idDestino Se obtiene de la session.
        $titulo = $_POST['titulo'];
        $fase = $_POST['fase'];
        $faseArray = array("GP" => 1, "TRS" => 2, "ZI" => 3);
        $idFase = $faseArray[$fase];

        $query = "INSERT INTO 
        t_subalmacenes(id_destino, id_fase, nombre, fase) 
        VALUES($idDestino, $idFase, '$titulo', '$fase')";

        if (mysqli_query($conn_2020, $query)) {
            echo "Se agrego Subalmacén ($titulo)";
        } else {
            echo "Error al agregar Subalmacén ($titulo)";
        }
    }


    // Nuevas funciones para la version Beta_2020.

    if ($action == "eliminar_Subalmacen") {
        $idSubalmacen = $_POST['idSubalmacen'];
        $query = "UPDATE t_subalmacenes SET activo = 0 WHERE id = $idSubalmacen";
        if (mysqli_query($conn_2020, $query)) {
            echo "Subalmacén Eliminado";
        } else {
            echo "Error al Eliminar Subalmacén";
        }
    }


    if ($action == "editarSubalmacen") {
        $idSubalmacen = $_POST['idSubalmacen'];
        $tituloSubalmacen = $_POST['tituloSubalmacen'];

        $query = "UPDATE t_subalmacenes SET nombre = '$tituloSubalmacen' WHERE id = $idSubalmacen";
        if (mysqli_query($conn_2020, $query)) {
            echo "Subalmacén Actualizado";
        } else {
            echo "Error al Actualizar";
        }
    }
}//Fin $action.