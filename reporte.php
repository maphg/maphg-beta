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
                <th class="p-1 m-0">DESTINO</th>
                <th class="p-1 m-0">SECCIÓN</th>
                <th class="p-1 m-0">SUBSECCIÓN</th>
                <th class="p-1 m-0">TIPO EQUIPO</th>
                <th class="p-1 m-0">NOMBRE PLAN</th>
                <th class="p-1 m-0">ACTIVIDAD</th>
                <th class="p-1 m-0">PERIODO</th>
            </tr>
            <?php
            $contador = 0;
            $query = "
                SELECT c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, c_tipos.tipo, t_planes_mantto.nombre, t_planes_actividades.actividad, t_planes_mantto.periodicidad FROM t_equipos INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id INNER JOIN c_tipos ON t_equipos.id_tipo = c_tipos.id INNER JOIN t_planes_mantto ON t_equipos.id_tipo = t_planes_mantto.id_tipo_equipo INNER JOIN t_planes_actividades ON t_planes_mantto.id = t_planes_actividades.id_mantto WHERE t_equipos.status='A' AND c_tipos.status='A' ORDER BY c_destinos.destino ASC
            ";

            $result = mysqli_query($conn_2020, $query);
            while ($row = mysqli_fetch_array($result)) {
                $contador++;
                $destino = $row['destino'];
                $seccion = $row['seccion'];
                $grupo = $row['grupo'];
                $tipo = $row['tipo'];
                $nombre = $row['nombre'];
                $actividad = $row['actividad'];
                $periodicidad = $row['periodicidad'];

                echo "<tr>"
                    . "<td class=\"p-1 m-0\"> $contador </td>"
                    . "<td class=\"p-1 m-0\">$destino</td>"
                    . "<td class=\"p-1 m-0\">$seccion</td>"
                    . "<td class=\"p-1 m-0\">$grupo</td>"
                    . "<td class=\"p-1 m-0\">$tipo</td>"
                    . "<td class=\"p-1 m-0\">$nombre</td>"
                    . "<td class=\"p-1 m-0\">$actividad</td>"
                    . "<td class=\"p-1 m-0\">$periodicidad</td>"
                    . "</tr>";
            }
            ?>

        </table>
    </div>
</body>

</html>