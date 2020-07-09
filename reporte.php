<?php include 'php/conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTE</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwind.css">
</head>

<body>
    <?php
    $secciones = "";
    $query = "CALL obtenerSubseccionesDestinoSeccion(1,24)";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $row) {
            $secciones = $row['seccion'];

            echo "0" . $secciones . "<br>";
        }
        $result->close();
        $conn_2020->next_result();
    }

    $query2 = "CALL obtenerSubseccionesDestinoSeccion(1,24)";
    if ($result2 = mysqli_query($conn_2020, $query2)) {
        foreach ($result2 as $row2) {
            $secciones = $row2['seccion'];

            echo "1" . $secciones . "<br>";
        }
        $result2->close();
        $conn_2020->next_result();
    }
    ?>
</body>

</html>