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
    <div class="p-1 w-full">

        <table id="" class="">
            <tr>
                <th class="p-1 m-0">#</th>
                <th class="p-1 m-0">destino</th>
                <th class="p-1 m-0">tipo</th>
                <th class="p-1 m-0">equipo</th>
                <th class="p-1 m-0">lista_actividades_realizadas EQUIPO</th>
                <th class="p-1 m-0">fecha_registro </th>
            </tr>
            <?php
            $contador = 0;
            $query = "
            SELECT t_ordenes_trabajo.id 'OT', t_equipos.id, c_destinos.destino, c_tipos.tipo, t_equipos.equipo, t_ordenes_trabajo.lista_actividades_realizadas, t_ordenes_trabajo.fecha_realizado 
            FROM t_equipos 
            INNER JOIN c_tipos ON t_equipos.id_tipo = c_tipos.id 
            INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id 
            INNER JOIN t_mp_planeacion ON t_equipos.id = t_mp_planeacion.id_equipo 
            INNER JOIN t_ordenes_trabajo ON t_equipos.id = t_ordenes_trabajo.id_equipo 
            WHERE c_tipos.id IN(314,444,445,446,37) 
            and t_mp_planeacion.status = 'F' 
            and t_ordenes_trabajo.status = 'F'
            ";

            $result = mysqli_query($conn_2020, $query);
            while ($row = mysqli_fetch_array($result)) {
                $contador++;
                $OT = $row['OT'];
                $destino = $row['destino'];
                $tipo = $row['tipo'];
                $equipo = $row['equipo'];
                $lista_actividades_realizadas = $row['lista_actividades_realizadas'];
                $fecha_registro  = $row['fecha_realizado'];
                // explode(",", $lista_actividades_realizadas);
                // echo var_dump($lista_actividades_realizadas);

                foreach (explode(",", $lista_actividades_realizadas) as $key => $value) {
                    // echo $value;
                    if ($value > 0 and $value != "") {
                        $queryActividades = "SELECT actividad FROM t_planes_actividades WHERE id = $value";
                        if ($resultActividades = mysqli_query($conn_2020, $queryActividades)) {
                            if ($rowActividades = mysqli_fetch_array($resultActividades)) {
                                $actividades = $rowActividades['actividad'];
                                echo "<tr>"
                                    . "<td class=\"p-1 m-0\"> $contador </td>"
                                    . "<td class=\"p-1 m-0\">$destino</td>"
                                    . "<td class=\"p-1 m-0\">$tipo</td>"
                                    . "<td class=\"p-1 m-0\">$equipo</td>"
                                    . "<td class=\"p-1 m-0\">$actividades</td>"
                                    . "<td class=\"p-1 m-0\">$fecha_registro </td>"
                                    . "</tr>";
                            }
                        }
                    }
                }
            }
            ?>

        </table>
    </div>
</body>

</html>