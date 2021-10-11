<?php
class IncidenciasGenerales extends Conexion
{
   public static function totalRangoFechaStatus(
      $idDestino,
      $idSeccion,
      $idSubseccion,
      $fechaInicio,
      $fechaFin,
      $fecha = 'TODOS',
      $status = 'TODOS'
   ) { {
         // DEVULVE EL TOTAL DE INCIDENCIAS ENCONTRADAS CON RANGO DE FECHA Y STATUS
         $conexion = new Conexion();
         $conexion->conectar();

         #FILTRO SECCIÓN
         if ($idSeccion === 0)
            $filtroSeccion = "";
         else
            $filtroSeccion = "and i.id_seccion = $idSeccion";

         #FILTRO SUBSECCIÓN
         if ($idSubseccion === 0)
            $filtroSubseccion = "";
         else
            $filtroSubseccion = "and i.id_subseccion = $idSubseccion";

         #STATUS PENDIENTE
         if ($status === 'PENDIENTE')
            $filtroStatus = "and i.status IN('N', 'PENDIENTE', 'P')";

         #STATUS SOLUCIONADO
         if ($status === 'SOLUCIONADO')
            $filtroStatus = "and i.status IN('F', 'FINALIZADO', 'SOLUCIONADO')";

         #STATUS TODOS
         if ($status === 'TODOS')
         $filtroStatus = "and i.status IN('N', 'PENDIENTE', 'P', 'F', 'FINALIZADO', 'SOLUCIONADO')";

         #FECHA CREADO
         if ($fecha === 'CREADO')
            $filtroFecha = "and i.fecha BETWEEN '$fechaInicio' and '$fechaFin'";

         #FECHA CREADO
         if ($fecha === 'SOLUCIONADO')
            $filtroFecha = "and i.fecha_finalizado BETWEEN '$fechaInicio' and '$fechaFin'";

         #FECHA CREADO
         if ($fecha === 'TODOS')
            $filtroFecha = "";

         $query = "SELECT
         i.id,
         i.titulo 'actividad',
         i.tipo_incidencia,
         i.status,
         i.activo,
         i.id_usuario 'creado_por',
         i.responsable,
         i.fecha 'fecha_creacion',
         i.fecha_finalizado,
         d.id 'idDestino',
         d.destino,
         sec.id 'idSeccion',
         sec.seccion,
         sub.id 'idSubseccion',
         sub.grupo 'subseccion'
         FROM t_mp_np AS i
         INNER JOIN c_destinos AS d ON i.id_destino = d.id
         INNER JOIN c_secciones AS sec ON i.id_seccion = sec.id
         INNER JOIN c_subsecciones AS sub ON i.id_subseccion = sub.id
         WHERE i.id_destino = ? and i.activo = 1 and i.id_equipo = 0
         $filtroSeccion $filtroStatus $filtroFecha $filtroSubseccion";

         $prepare = mysqli_prepare($conexion->con, $query);
         $prepare->bind_param("i", $idDestino);
         $prepare->execute();
         $response = $prepare->get_result();

         #ARRAYS
         $array = array();

         foreach ($response as $x) {
            $idIncidencia = $x['id'];
            $incidencia = $x['actividad'];
            $tipoIncidencia = $x['tipo_incidencia'];
            $status = $x['status'];
            $creadoPor = $x['creado_por'];
            $responsable = $x['responsable'];
            $fechaCreado = $x['fecha_creacion'];
            $fechaFinalizado = $x['fecha_finalizado'];
            $idDestinoX = $x['idDestino'];
            $destino = $x['destino'];
            $idSeccion = $x['idSeccion'];
            $seccion = $x['seccion'];
            $idSubseccion = $x['idSubseccion'];
            $subseccion = $x['subseccion'];
            $idEquipo = 0;
            $equipo = "";
            $activo = $x['activo'];

            if ($status === 'N' || $status === 'PENDIENTE' || $status === 'PROCESO')
               $status = 'PENDIENTE';
            else
               $status = 'SOLUCIONADO';

            #RESULTADO FINAL DE PROYECTOS
            $array[] =
               array(
                  "idIncidencia" => $idIncidencia,
                  "incidencia" => $incidencia,
                  "tipoIncidencia" => $tipoIncidencia,
                  "status" => $status,
                  "fechaCreado" => $fechaCreado,
                  "fechaFinalizado" => $fechaFinalizado,
                  "idDestino" => $idDestinoX,
                  "destino" => $destino,
                  "idSeccion" => $idSeccion,
                  "seccion" => $seccion,
                  "idSubseccion" => $idSubseccion,
                  "subseccion" => $subseccion,
                  "idEquipo" => $idEquipo,
                  "equipo" => $equipo,
                  "activo" => $activo
               );
         }
         return $array;
      }
   }
}
