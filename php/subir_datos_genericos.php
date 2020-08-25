<?php
include 'conexion.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "cargarDatosX") {

        // Nombre de las Columnas.
        $columna1 = $_POST['columna1'];
        $columna2 = $_POST['columna2'];
        $columna3 = $_POST['columna3'];
        $columna4 = $_POST['columna4'];
        $columna5 = $_POST['columna5'];
        $columna6 = $_POST['columna6'];
        $columna7 = $_POST['columna7'];
        $columna8 = $_POST['columna8'];
        $columna9 = $_POST['columna9'];
        $columna10 = $_POST['columna10'];
        $columna11 = $_POST['columna11'];
        $columna12 = $_POST['columna12'];
        $columna13 = $_POST['columna13'];
        $columna14 = $_POST['columna14'];
        $columna15 = $_POST['columna15'];
        $columna16 = $_POST['columna16'];
        $columna17 = $_POST['columna17'];
        $columna18 = $_POST['columna18'];
        $columna19 = $_POST['columna19'];
        $columna20 = $_POST['columna20'];
        $columna21 = $_POST['columna21'];
        $columna22 = $_POST['columna22'];
        $columna23 = $_POST['columna23'];
        $columna24 = $_POST['columna24'];
        $columna25 = $_POST['columna25'];
        $columna26 = $_POST['columna26'];
        $columna27 = $_POST['columna27'];
        $columna28 = $_POST['columna28'];
        $columna29 = $_POST['columna29'];
        $columna30 = $_POST['columna30'];

        // Valor de las columnas.
        $valorColumna1 = $_POST['valorColumna1'];
        $valorColumna2 = $_POST['valorColumna2'];
        $valorColumna3 = $_POST['valorColumna3'];
        $valorColumna4 = $_POST['valorColumna4'];
        $valorColumna5 = $_POST['valorColumna5'];
        $valorColumna6 = $_POST['valorColumna6'];
        $valorColumna7 = $_POST['valorColumna7'];
        $valorColumna8 = $_POST['valorColumna8'];
        $valorColumna9 = $_POST['valorColumna9'];
        $valorColumna10 = $_POST['valorColumna10'];
        $valorColumna11 = $_POST['valorColumna11'];
        $valorColumna12 = $_POST['valorColumna12'];
        $valorColumna13 = $_POST['valorColumna13'];
        $valorColumna14 = $_POST['valorColumna14'];
        $valorColumna15 = $_POST['valorColumna15'];
        $valorColumna16 = $_POST['valorColumna16'];
        $valorColumna17 = $_POST['valorColumna17'];
        $valorColumna18 = $_POST['valorColumna18'];
        $valorColumna19 = $_POST['valorColumna19'];
        $valorColumna20 = $_POST['valorColumna20'];
        $valorColumna21 = $_POST['valorColumna21'];
        $valorColumna22 = $_POST['valorColumna22'];
        $valorColumna23 = $_POST['valorColumna23'];
        $valorColumna24 = $_POST['valorColumna24'];
        $valorColumna25 = $_POST['valorColumna25'];
        $valorColumna26 = $_POST['valorColumna26'];
        $valorColumna27 = $_POST['valorColumna27'];
        $valorColumna28 = $_POST['valorColumna28'];
        $valorColumna29 = $_POST['valorColumna29'];
        $valorColumna30 = $_POST['valorColumna30'];

        // Tabla
        $tabla = $_POST['tabla'];

        // Nivel Inicial.
        $nivel = 0;
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $total5 = 0;
        $total6 = 0;
        $total7 = 0;
        $total8 = 0;
        $total9 = 0;
        $total10 = 0;
        $total11 = 0;
        $total12 = 0;
        $total13 = 0;
        $total14 = 0;
        $total15 = 0;
        $total16 = 0;
        $total17 = 0;
        $total18 = 0;
        $total19 = 0;
        $total20 = 0;
        $total21 = 0;
        $total22 = 0;
        $total23 = 0;
        $total24 = 0;
        $total25 = 0;
        $total26 = 0;
        $total27 = 0;
        $total28 = 0;
        $total29 = 0;
        $total30 = 0;

        // Proceso 1
        echo "Cantidad de Registros por Columna:";
        if ($columna1 != "" and $valorColumna1 != "") {
            $valorColumna1 = explode("\n", $valorColumna1);
            $total1 = count($valorColumna1);
            $nivel = 1;
            echo "<br>" . "Columna 1: " . $total1;
        }

        if ($columna2 != "" and $valorColumna2 != "") {
            $valorColumna2 = explode("\n", $valorColumna2);
            $total2 = count($valorColumna2);
            $nivel = 2;
            $separacion2 = ",";
            echo "<br>" . "Columna 2: " . $total2;
        } else {
            $separacion2 = "";
        }

        if ($columna3 != "" and $valorColumna3 != "") {
            $valorColumna3 = explode("\n", $valorColumna3);
            $total3 = count($valorColumna3);
            $nivel = 3;
            $separacion3 = ",";
            echo "<br>" . "Columna 3: " . $total3;
        } else {
            $separacion3 = "";
        }


        if ($columna4 != "" and $valorColumna4 != "") {
            $valorColumna4 = explode("\n", $valorColumna4);
            $total4 = count($valorColumna4);
            $nivel = 4;
            $separacion4 = ",";
            echo "<br>" . "Columna 4: " . $total4;
        } else {
            $separacion4 = "";
        }


        if ($columna5 != "" and $valorColumna5 != "") {
            $valorColumna5 = explode("\n", $valorColumna5);
            $total5 = count($valorColumna5);
            $nivel = 5;
            $separacion5 = ",";
            echo "<br>" . "Columna 5: " . $total5;
        } else {
            $separacion5 = "";
        }


        if ($columna6 != "" and $valorColumna6 != "") {
            $valorColumna6 = explode("\n", $valorColumna6);
            $total6 = count($valorColumna6);
            $nivel = 6;
            $separacion6 = ",";
            echo "<br>" . "Columna 6: " . $total6;
        } else {
            $separacion6 = "";
        }


        if ($columna7 != "" and $valorColumna7 != "") {
            $valorColumna7 = explode("\n", $valorColumna7);
            $total7 = count($valorColumna7);
            $nivel = 7;
            $separacion7 = ",";
            echo "<br>" . "Columna 7: " . $total7;
        } else {
            $separacion7 = "";
        }


        if ($columna8 != "" and $valorColumna8 != "") {
            $valorColumna8 = explode("\n", $valorColumna8);
            $total8 = count($valorColumna8);
            $nivel = 8;
            $separacion8 = ",";
            echo "<br>" . "Columna 8: " . $total8;
        } else {
            $separacion8 = "";
        }


        if ($columna9 != "" and $valorColumna9 != "") {
            $valorColumna9 = explode("\n", $valorColumna9);
            $total9 = count($valorColumna9);
            $nivel = 9;
            $separacion9 = ",";
            echo "<br>" . "Columna 9: " . $total9;
        } else {
            $separacion9 = "";
        }


        if ($columna10 != "" and $valorColumna10 != "") {
            $valorColumna10 = explode("\n", $valorColumna10);
            $total10 = count($valorColumna10);
            $nivel = 10;
            $separacion10 = ",";
            echo "<br>" . "Columna 10: " . $total10;
        } else {
            $separacion10 = "";
        }


        if ($columna11 != "" and $valorColumna11 != "") {
            $valorColumna11 = explode("\n", $valorColumna11);
            $total11 = count($valorColumna11);
            $nivel = 11;
            $separacion11 = ",";
            echo "<br>" . "Columna 11: " . $total11;
        } else {
            $separacion11 = "";
        }


        if ($columna12 != "" and $valorColumna12 != "") {
            $valorColumna12 = explode("\n", $valorColumna12);
            $total12 = count($valorColumna12);
            $nivel = 12;
            $separacion12 = ",";
            echo "<br>" . "Columna 12: " . $total12;
        } else {
            $separacion12 = "";
        }


        if ($columna13 != "" and $valorColumna13 != "") {
            $valorColumna13 = explode("\n", $valorColumna13);
            $total13 = count($valorColumna13);
            $nivel = 13;
            $separacion13 = ",";
            echo "<br>" . "Columna 13: " . $total13;
        } else {
            $separacion13 = "";
        }


        if ($columna14 != "" and $valorColumna14 != "") {
            $valorColumna14 = explode("\n", $valorColumna14);
            $total14 = count($valorColumna14);
            $nivel = 14;
            $separacion14 = ",";
            echo "<br>" . "Columna 14: " . $total14;
        } else {
            $separacion14 = "";
        }


        if ($columna15 != "" and $valorColumna15 != "") {
            $valorColumna15 = explode("\n", $valorColumna15);
            $total15 = count($valorColumna15);
            $nivel = 15;
            $separacion15 = ",";
            echo "<br>" . "Columna 15: " . $total5;
        } else {
            $separacion15 = "";
        }


        if ($columna16 != "" and $valorColumna16 != "") {
            $valorColumna16 = explode("\n", $valorColumna16);
            $total16 = count($valorColumna16);
            $nivel = 16;
            $separacion16 = ",";
            echo "<br>" . "Columna 16: " . $total16;
        } else {
            $separacion16 = "";
        }


        if ($columna17 != "" and $valorColumna17 != "") {
            $valorColumna17 = explode("\n", $valorColumna17);
            $total17 = count($valorColumna17);
            $nivel = 17;
            $separacion17 = ",";
            echo "<br>" . "Columna 17: " . $total17;
        } else {
            $separacion17 = "";
        }


        if ($columna18 != "" and $valorColumna18 != "") {
            $valorColumna18 = explode("\n", $valorColumna18);
            $total18 = count($valorColumna18);
            $nivel = 18;
            $separacion18 = ",";
            echo "<br>" . "Columna 18: " . $total18;
        } else {
            $separacion18 = "";
        }


        if ($columna19 != "" and $valorColumna19 != "") {
            $valorColumna19 = explode("\n", $valorColumna19);
            $total19 = count($valorColumna19);
            $nivel = 19;
            $separacion19 = ",";
            echo "<br>" . "Columna 19: " . $total19;
        } else {
            $separacion19 = "";
        }


        if ($columna20 != "" and $valorColumna20 != "") {
            $valorColumna20 = explode("\n", $valorColumna20);
            $total20 = count($valorColumna20);
            $nivel = 20;
            $separacion20 = ",";
            echo "<br>" . "Columna 20: " . $total20;
        } else {
            $separacion20 = "";
        }


        if ($columna21 != "" and $valorColumna21 != "") {
            $valorColumna21 = explode("\n", $valorColumna21);
            $total21 = count($valorColumna21);
            $nivel = 21;
            $separacion21 = ",";
            echo "<br>" . "Columna 21: " . $total21;
        } else {
            $separacion21 = "";
        }

        if ($columna22 != "" and $valorColumna22 != "") {
            $valorColumna22 = explode("\n", $valorColumna22);
            $total22 = count($valorColumna22);
            $nivel = 22;
            $separacion22 = ",";
            echo "<br>" . "Columna 22: " . $total20;
        } else {
            $separacion22 = "";
        }

        if ($columna23 != "" and $valorColumna23 != "") {
            $valorColumna23 = explode("\n", $valorColumna23);
            $total23 = count($valorColumna23);
            $nivel = 23;
            $separacion23 = ",";
            echo "<br>" . "Columna 23: " . $total23;
        } else {
            $separacion23 = "";
        }

        if ($columna24 != "" and $valorColumna24 != "") {
            $valorColumna24 = explode("\n", $valorColumna24);
            $total24 = count($valorColumna24);
            $nivel = 24;
            $separacion24 = ",";
            echo "<br>" . "Columna 24: " . $total24;
        } else {
            $separacion24 = "";
        }

        if ($columna25 != "" and $valorColumna25 != "") {
            $valorColumna25 = explode("\n", $valorColumna25);
            $total25 = count($valorColumna25);
            $nivel = 25;
            $separacion25 = ",";
            echo "<br>" . "Columna 25: " . $total25;
        } else {
            $separacion25 = "";
        }

        if ($columna26 != "" and $valorColumna26 != "") {
            $valorColumna26 = explode("\n", $valorColumna26);
            $total26 = count($valorColumna26);
            $nivel = 26;
            $separacion26 = ",";
            echo "<br>" . "Columna 26: " . $total26;
        } else {
            $separacion26 = "";
        }

        if ($columna27 != "" and $valorColumna27 != "") {
            $valorColumna27 = explode("\n", $valorColumna27);
            $total27 = count($valorColumna27);
            $nivel = 27;
            $separacion27 = ",";
            echo "<br>" . "Columna 27: " . $total27;
        } else {
            $separacion27 = "";
        }

        if ($columna28 != "" and $valorColumna28 != "") {
            $valorColumna28 = explode("\n", $valorColumna28);
            $total28 = count($valorColumna28);
            $nivel = 28;
            $separacion28 = ",";
            echo "<br>" . "Columna 28: " . $total28;
        } else {
            $separacion28 = "";
        }

        if ($columna29 != "" and $valorColumna29 != "") {
            $valorColumna29 = explode("\n", $valorColumna29);
            $total29 = count($valorColumna29);
            $nivel = 29;
            $separacion29 = ",";
            echo "<br>" . "Columna 29: " . $total29;
        } else {
            $separacion29 = "";
        }

        if ($columna30 != "" and $valorColumna30 != "") {
            $valorColumna30 = explode("\n", $valorColumna30);
            $total20 = count($valorColumna30);
            $nivel = 30;
            $separacion30 = ",";
            echo "<br>" . "Columna 30: " . $total30;
        } else {
            $separacion30 = "";
        }


        // Proceso 2.
        $sumaTotal = $total1 + $total2 + $total3 + $total4 + $total5 + $total6 + $total7 + $total8 + $total9 + $total10 + $total11 + $total12 + $total13 + $total14 + $total15 + $total16 + $total17 + $total18 + $total19 + $total20 + $total21 + $total22 + $total23 + $total24 + $total25 + $total26 + $total27 + $total28 + $total29 + $total30;

        if ($sumaTotal > 0) {
            $totalGlobal = $sumaTotal / $nivel;
        } else {
            $totalGlobal = -1;
            echo "<br>" . "Error en Proceso 1";
        }

        if ($total1 == $totalGlobal) {
            $totalGlobal = 1;
            $iAux = $total1;
        } else {
            $totalGlobal = 0;
            echo "<br><br>" . "Error en Proceso 2: <br> Cantidad de Filas NO Valido ";
        }


        // Proceso 3
        if ($nivel >= 1 and $totalGlobal == 1 and $tabla != "") {
            $query = "SELECT $columna1 $separacion2 $columna2 $separacion3 $columna3 $separacion4 $columna4 $separacion5 $columna5 $separacion6 $columna6 $separacion7 $columna7 $separacion8 $columna8 $separacion9 $columna9 $separacion10 $columna10 $separacion11 $columna11 $separacion12 $columna12 $separacion13 $columna13 $separacion14 $columna14 $separacion15 $columna15 $separacion16 $columna16 $separacion17 $columna17 $separacion18 $columna18 $separacion19 $columna19 $separacion20 $columna20 $separacion21 $columna21 $separacion22 $columna22 $separacion23 $columna23 $separacion24 $columna24 $separacion25 $columna25 $separacion26 $columna26 $separacion27 $columna27 $separacion28 $columna28 $separacion29 $columna29 $separacion30 $columna30 FROM $tabla WHERE id = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $comprovacionColummnas = 1;
            } else {
                $comprovacionColummnas = 0;
                echo "<br><br>" . "Error en Proceso 3: <br> Columnas Desconocidas";
            }
        } else {
            $comprovacionColummnas = 0;
            echo "<br><br>" . "Error en Proceso 3: <br> Columnas Desconocidas";
        }


        // Proceso 4
        echo "<br><br><br> Reporte de Registros: <br>";
        if ($nivel >= 1 and $totalGlobal == 1 and $comprovacionColummnas == 1 and $tabla != "") {
            $contadorRegistro = 0;
            if ($nivel == 1) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $query = "INSERT INTO $tabla ($columna1) VALUE('$valor1')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 2) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $query = "INSERT INTO $tabla ($columna1, $columna2) VALUES('$valor1', '$valor2')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 3) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3) VALUES('$valor1', '$valor2', '$valor3')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 4) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4) VALUES('$valor1', '$valor2', '$valor3', '$valor4')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 5) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    // echo $nivel;
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5) VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 6) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6) VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 7) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7) VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 8) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8) VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 9) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9) VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 10) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10) VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 11) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 12) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 13) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 14) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 15) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];


                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 16) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 17) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 18) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 19) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 20) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 21) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 22) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 23) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 24) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];
                    $valor24 = $valorColumna24[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23, $columna24) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23', '$valor24')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 25) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];
                    $valor24 = $valorColumna24[$i];
                    $valor25 = $valorColumna25[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23, $columna24, $columna25) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23', '$valor24', '$valor25')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 26) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];
                    $valor24 = $valorColumna24[$i];
                    $valor25 = $valorColumna25[$i];
                    $valor26 = $valorColumna26[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23, $columna24, $columna25, $columna26) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23', '$valor24', '$valor25', '$valor26')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 27) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];
                    $valor24 = $valorColumna24[$i];
                    $valor25 = $valorColumna25[$i];
                    $valor26 = $valorColumna26[$i];
                    $valor27 = $valorColumna27[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23, $columna24, $columna25, $columna26, $columna27) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23', '$valor24', '$valor25', '$valor26', '$valor27')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 28) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];
                    $valor24 = $valorColumna24[$i];
                    $valor25 = $valorColumna25[$i];
                    $valor26 = $valorColumna26[$i];
                    $valor27 = $valorColumna27[$i];
                    $valor28 = $valorColumna28[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23, $columna24, $columna25, $columna26, $columna27, $columna28) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23', '$valor24', '$valor25', '$valor26', '$valor27', '$valor28')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 29) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];
                    $valor24 = $valorColumna24[$i];
                    $valor25 = $valorColumna25[$i];
                    $valor26 = $valorColumna26[$i];
                    $valor27 = $valorColumna27[$i];
                    $valor28 = $valorColumna28[$i];
                    $valor29 = $valorColumna29[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23, $columna24, $columna25, $columna26, $columna27, $columna28, $columna29) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23', '$valor24', '$valor25', '$valor26', '$valor27', '$valor28', '$valor29')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            } elseif ($nivel == 30) {
                for ($i = 0; $i <= ($iAux - 1); $i++) {
                    $valor1 = $valorColumna1[$i];
                    $valor2 = $valorColumna2[$i];
                    $valor3 = $valorColumna3[$i];
                    $valor4 = $valorColumna4[$i];
                    $valor5 = $valorColumna5[$i];
                    $valor6 = $valorColumna6[$i];
                    $valor7 = $valorColumna7[$i];
                    $valor8 = $valorColumna8[$i];
                    $valor9 = $valorColumna9[$i];
                    $valor10 = $valorColumna10[$i];
                    $valor11 = $valorColumna11[$i];
                    $valor12 = $valorColumna12[$i];
                    $valor13 = $valorColumna13[$i];
                    $valor14 = $valorColumna14[$i];
                    $valor15 = $valorColumna15[$i];
                    $valor16 = $valorColumna16[$i];
                    $valor17 = $valorColumna17[$i];
                    $valor18 = $valorColumna18[$i];
                    $valor19 = $valorColumna19[$i];
                    $valor20 = $valorColumna20[$i];
                    $valor21 = $valorColumna21[$i];
                    $valor22 = $valorColumna22[$i];
                    $valor23 = $valorColumna23[$i];
                    $valor24 = $valorColumna24[$i];
                    $valor25 = $valorColumna25[$i];
                    $valor26 = $valorColumna26[$i];
                    $valor27 = $valorColumna27[$i];
                    $valor28 = $valorColumna28[$i];
                    $valor29 = $valorColumna29[$i];
                    $valor30 = $valorColumna30[$i];

                    $query = "INSERT INTO $tabla ($columna1, $columna2, $columna3, $columna4, $columna5, $columna6, $columna7, $columna8, $columna9, $columna10, $columna11, $columna12, $columna13, $columna14, $columna15, $columna16, $columna17, $columna18, $columna19, $columna20, $columna21, $columna22, $columna23, $columna24, $columna25, $columna26, $columna27, $columna28, $columna29, $columna30) 
                    VALUES('$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$valor7', '$valor8', '$valor9', '$valor10', '$valor11', '$valor12', '$valor13', '$valor14', '$valor15', '$valor16', '$valor17', '$valor18', '$valor19', '$valor20', '$valor21', '$valor22', '$valor23', '$valor24', '$valor25', '$valor26', '$valor27', '$valor28', '$valor29', '$valor30')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $contadorRegistro++;
                    } else {
                        echo "<br>" . "Registro Error Fila: $contadorRegistro";
                    }
                }
            }
            echo "<br><br> Registros Capturados: " . $contadorRegistro;
        } else {
            echo "<br>" . "Error en Proceso 4";
        }
    }
}
