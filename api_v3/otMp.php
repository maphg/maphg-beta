<?php
// Registro de Staff para COVID

class OtMp extends Conexion
{

   public static function ot($idUsuario, $idOt)
   {
      // OBTIENE TODO LOS DATOS POR AÑO Y DESTINO.

      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT mp.id 'idOt',
      mp.semana,
      mp.año,
      e.id 'idEquipo',
      mp.status,
      mp.fecha_creacion 'fechaCreacion',
      mp.fecha_finalizado 'fechaFinalizado',
      mp.creado_por idCreadoPor,
      CONCAT(c1.nombre, ' ', c1.apellido) 'creadoPor',
      mp.realizado_por 'idRealizadoPor',
      CONCAT(c2.nombre, ' ', c2.apellido) 'finalizadoPor',
      mp.comentario,
      mp.actividades_preventivo 'actividadesPreventivo',
      mp.actividades_preventivo_realizadas 'actividadesPreventivoRealizadasX',
      mp.actividades_check 'actividadesCheck',
      mp.actividades_check_realizadas 'actividadesCheckRealizadasX',
      mp.actividades_test 'actividadesTest',
      mp.actividades_test_realizadas 'actividadesTestRealizadasX',
      mp.actividades_extra 'actividadesExtra',
      e.equipo 'nombreEquipo',
      des.id 'idDestino',
      des.destino,
      tipo.tipo 'tipoEquipo',
      sec.id 'idSeccion',
      sec.seccion,
      sub.id 'idSubseccion',
      sub.grupo 'subseccion',
      plan.id 'idPlan',
      plan.tipo_plan 'tipoPlan',
      plan.grado 'gradoPlan',
      plan.descripcion 'descripcionPlan',
      frecuencia.frecuencia 'frecuenciaPlan'
      FROM t_mp_planificacion_iniciada AS mp
      INNER JOIN t_equipos_america AS e ON e.id = mp.id_equipo
      INNER JOIN c_destinos AS des ON e.id_destino = des.id
      INNER JOIN c_secciones AS sec ON e.id_seccion = sec.id
      INNER JOIN c_subsecciones AS sub ON e.id_subseccion = sub.id
      INNER JOIN c_tipos AS tipo ON e.id_tipo = tipo.id
      INNER JOIN t_mp_planes_mantenimiento AS plan ON mp.id_plan = plan.id
      INNER JOIN c_frecuencias_mp AS frecuencia ON plan.id_periodicidad = frecuencia.id
      INNER JOIN t_users AS u1 ON mp.creado_por = u1.id
      INNER JOIN t_colaboradores AS c1 ON u1.id_colaborador = c1.id
      LEFT JOIN t_users AS u2 ON mp.realizado_por = u2.id
      LEFT JOIN t_colaboradores AS c2 ON u2.id_colaborador = c2.id
      WHERE mp.id = ? and mp.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idOt);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         $idPlan = $x['idPlan'];
         $idOt = $x['idOt'];

         #RUTA URL QR (RUTA BASE: 'https://www.maphg.com/america/otMp/#/' + AQUÍ EL ID DE LA OT))
         $urlQr = "_PATH/";
         if (strpos($_SERVER['REQUEST_URI'], "america") == true)
            $urlQr = "https://www.maphg.com/america/otMp/#/$idOt";
         if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
            $urlQr = "https://www.maphg.com/europa/otMp/#/$idOt";

         $x['urlQr'] = str_replace(" ", "", $urlQr);

         #PREVENTIVO
         $actividadesPreventivoAll = explode(',', str_replace(" ", "", $x['actividadesPreventivo']));
         $actividadesPreventivoRealizadas = explode(';', str_replace(" ", "", $x['actividadesPreventivoRealizadasX']));

         #CHECKLIST
         $actividadesCheckAll = explode(',', str_replace(" ", "", $x['actividadesCheck']));

         $actividadesCheckRealizadas = explode(';', str_replace(" ", "", $x['actividadesCheckRealizadasX']));
         $actividadesCheckRealizadasX = array();

         foreach ($actividadesCheckRealizadas as $acrX) {
            $acrXTemp = explode("=", $acrX);

            $actividadesCheckRealizadasX[] = $acrXTemp;
         }

         #TEST
         $actividadesTestAll = explode(',', str_replace(" ", "", $x['actividadesTest']));
         $actividadesTestRealizadas = explode(';', $x['actividadesTestRealizadasX']);
         $actividadesTestRealizadasX = array();

         foreach ($actividadesTestRealizadas as $atrX) {
            $atrXTemp = explode("=", $atrX);

            $actividadesTestRealizadasX[] = $atrXTemp;
         }

         #ACTIVIDADES EXTRA
         $actividadesExtraAll = explode(';', $x['actividadesExtra']);


         #TODAS LAS ACTIVIDADES (PREVENTIVO, CHECKLIST, TEST Y EXTRA)
         $x['actividadesRealizadas'] = array();

         #TODAS LAS ACTIVIDADES TIPO PREVENTIVO.
         foreach ($actividadesPreventivoAll as $apa) {
            if ($apa != "") {
               $apaX = array();

               if (array_search($apa, $actividadesPreventivoRealizadas)  || $actividadesPreventivoRealizadas[0] == $apa) {
                  $apaX = OtMp::actividad($apa, "PREVENTIVO", "REALIZADO");
               } else {
                  $apaX = OtMp::actividad($apa, "PREVENTIVO", "BLANK");
               }

               if (count($apaX)) {
                  $x['actividadesRealizadas'][] = $apaX;
               }
            }
         }

         #TODAS LAS ACTIVIDADES TIPO CHECKLIST.
         foreach ($actividadesCheckAll as $aca) {

            if ($aca != "") {
               $acaX = OtMp::actividad($aca, "CHECKLIST", "BLANK");

               if (count($acaX)) {
                  foreach ($actividadesCheckRealizadasX as $acrx) {
                     if ($acrx[0] == $aca && $acrx[1] != "") {
                        $acaX['valor'] = $acrx[1];
                     }
                  }

                  $x['actividadesRealizadas'][] = $acaX;
               }
            }
         }

         #TODAS LAS ACTIVIDADES TIPO TEST.
         foreach ($actividadesTestAll as $ata) {
            if ($ata != "") {
               $ataX = OtMp::actividad($ata, "TEST", "BLANK");
               $x['zzzzzzz'][] = $ataX;

               if (count($ataX)) {
                  foreach ($actividadesTestRealizadasX as $acrx) {
                     $x['test'] = $ataX['valor'];
                     if ($acrx[0] == $ata && $acrx[1] != "") {
                        $ataX['valor'] = $acrx[1];
                     }
                  }

                  $x['actividadesRealizadas'][] = $ataX;
               }
            }
         }

         #ACTIVIDADES EXTRA
         foreach ($actividadesExtraAll as $key => $axa) {
            if ($axa != "") {
               $x['actividadesRealizadas'][] = array(
                  "idActividad" => $key,
                  "actividad" => $axa,
                  "valor" => "REALIZADO",
                  "tipo" => "PREVENTIVO"
               );
            }
         }

         #ADJUNTOS
         $x['adjuntos'] = OtMp::adjuntos($idOt);

         #MATERIALES
         $x['materialesRequeridos'] = OtMp::materiales($idPlan);

         #RESULTADO FINAL POR REGISTRO
         $array = $x;
      }
      return $array;
   }

   public static function otEquipo($idDestino, $idEquipo)
   {
      // OBTIENE TODO LOS DATOS POR AÑO Y DESTINO.

      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT mp.id 'idOt',
      mp.semana,
      mp.año,
      e.id 'idEquipo',
      mp.status,
      mp.fecha_creacion 'fechaCreacion',
      mp.fecha_finalizado 'fechaFinalizado',
      mp.creado_por idCreadoPor,
      CONCAT(c1.nombre, ' ', c1.apellido) 'creadoPor',
      mp.realizado_por 'idRealizadoPor',
      CONCAT(c2.nombre, ' ', c2.apellido) 'finalizadoPor',
      mp.comentario,
      mp.actividades_preventivo 'actividadesPreventivo',
      mp.actividades_preventivo_realizadas 'actividadesPreventivoRealizadasX',
      mp.actividades_check 'actividadesCheck',
      mp.actividades_check_realizadas 'actividadesCheckRealizadasX',
      mp.actividades_test 'actividadesTest',
      mp.actividades_test_realizadas 'actividadesTestRealizadasX',
      mp.actividades_extra 'actividadesExtra',
      e.equipo 'nombreEquipo',
      des.id 'idDestino',
      des.destino,
      tipo.tipo 'tipoEquipo',
      sec.id 'idSeccion',
      sec.seccion,
      sub.id 'idSubseccion',
      sub.grupo 'subseccion',
      plan.id 'idPlan',
      plan.tipo_plan 'tipoPlan',
      plan.grado 'gradoPlan',
      plan.descripcion 'descripcionPlan',
      frecuencia.frecuencia 'frecuenciaPlan'
      FROM t_mp_planificacion_iniciada AS mp
      INNER JOIN t_equipos_america AS e ON e.id = mp.id_equipo
      INNER JOIN c_destinos AS des ON e.id_destino = des.id
      INNER JOIN c_secciones AS sec ON e.id_seccion = sec.id
      INNER JOIN c_subsecciones AS sub ON e.id_subseccion = sub.id
      INNER JOIN c_tipos AS tipo ON e.id_tipo = tipo.id
      INNER JOIN t_mp_planes_mantenimiento AS plan ON mp.id_plan = plan.id
      INNER JOIN c_frecuencias_mp AS frecuencia ON plan.id_periodicidad = frecuencia.id
      INNER JOIN t_users AS u1 ON mp.creado_por = u1.id
      INNER JOIN t_colaboradores AS c1 ON u1.id_colaborador = c1.id
      LEFT JOIN t_users AS u2 ON mp.realizado_por = u2.id
      LEFT JOIN t_colaboradores AS c2 ON u2.id_colaborador = c2.id
      WHERE e.id_destino = ? and e.id = ? and mp.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("ii", $idDestino, $idEquipo);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         $idPlan = $x['idPlan'];
         $idOt = $x['idOt'];

         #RUTA URL QR (RUTA BASE: 'https://www.maphg.com/america/otMp/#/' + AQUÍ EL ID DE LA OT))
         $urlQr = "_PATH/";
         if (strpos($_SERVER['REQUEST_URI'], "america") == true)
            $urlQr = "https://www.maphg.com/america/ot_test/#/$idOt";
         if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
            $urlQr = "https://www.maphg.com/europa/ot_test/#/$idOt";

         $x['urlQr'] = str_replace(" ", "", $urlQr);

         #PREVENTIVO
         $actividadesPreventivoAll = explode(',', str_replace(" ", "", $x['actividadesPreventivo']));
         $actividadesPreventivoRealizadas = explode(';', str_replace(" ", "", $x['actividadesPreventivoRealizadasX']));

         #CHECKLIST
         $actividadesCheckAll = explode(',', str_replace(" ", "", $x['actividadesCheck']));
         $actividadesCheckRealizadas = explode(';', str_replace(" ", "", $x['actividadesCheckRealizadasX']));
         $actividadesCheckRealizadasX = array();

         foreach ($actividadesCheckRealizadas as $acrX) {
            $acrXTemp = explode("=", $acrX);

            $actividadesCheckRealizadasX[] = $acrXTemp;
         }

         #TEST
         $actividadesTestAll = explode(',', str_replace(" ", "", $x['actividadesTest']));
         $actividadesTestRealizadas = explode(';', $x['actividadesTestRealizadasX']);
         $actividadesTestRealizadasX = array();

         foreach ($actividadesTestRealizadas as $atrX) {
            $atrXTemp = explode("=", $atrX);

            $actividadesTestRealizadasX[] = $atrXTemp;
         }

         #ACTIVIDADES EXTRA
         $actividadesExtraAll = explode(';', $x['actividadesExtra']);


         #TODAS LAS ACTIVIDADES (PREVENTIVO, CHECKLIST, TEST Y EXTRA)
         $x['actividadesRealizadas'] = array();

         #TODAS LAS ACTIVIDADES TIPO PREVENTIVO.
         foreach ($actividadesPreventivoAll as $apa) {
            if ($apa != "") {
               $apaX = array();

               if (array_search($apa, $actividadesPreventivoRealizadas)) {
                  $apaX = OtMp::actividad($apa, "PREVENTIVO", "REALIZADO");
               } else {
                  $apaX = OtMp::actividad($apa, "PREVENTIVO", "BLANK");
               }

               if (count($apaX)) {
                  $x['actividadesRealizadas'][] = $apaX;
               }
            }
         }

         #TODAS LAS ACTIVIDADES TIPO CHECKLIST.
         foreach ($actividadesCheckAll as $aca) {
            if ($aca != "") {
               $acaX = OtMp::actividad($aca, "CHECKLIST", "BLANK");

               if (count($acaX)) {
                  foreach ($actividadesCheckRealizadasX as $acrx) {
                     $x['test'] = $acaX['valor'];
                     if ($acrx[0] == $aca && $acrx[1] != "") {
                        $acaX['valor'] = $acrx[1];
                     }
                  }

                  $x['actividadesRealizadas'][] = $acaX;
               }
            }
         }

         #TODAS LAS ACTIVIDADES TIPO TEST.
         foreach ($actividadesTestAll as $ata) {
            if ($ata != "") {
               $ataX = OtMp::actividad($aca, "TEST", "BLANK");

               if (count($ataX)) {
                  foreach ($actividadesTestRealizadasX as $acrx) {
                     $x['test'] = $ataX['valor'];
                     if ($acrx[0] == $ata && $acrx[1] != "") {
                        $ataX['valor'] = $acrx[1];
                     }
                  }

                  $x['actividadesRealizadas'][] = $ataX;
               }
            }
         }

         #ACTIVIDADES EXTRA
         foreach ($actividadesExtraAll as $key => $axa) {
            if ($axa != "") {
               $x['actividadesRealizadas'][] = array(
                  "idActividad" => $key,
                  "actividad" => $axa,
                  "valor" => "REALIZADO",
                  "tipo" => "PREVENTIVO"
               );
            }
         }

         #ADJUNTOS
         $x['adjuntos'] = OtMp::adjuntos($idOt);

         #MATERIALES
         $x['materialesRequeridos'] = OtMp::materiales($idPlan);

         #RESULTADO FINAL POR REGISTRO
         $array[] = $x;
      }
      return $array;
   }


   public static function actividad($idActividad, $tipo, $valor)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $tipoX = "";

      if ($tipo === "PREVENTIVO")
         $tipoX = "t_mp_planes_actividades_preventivos";
      if ($tipo === "TEST")
         $tipoX = "t_mp_planes_actividades_test";
      if ($tipo === "CHECKLIST")
         $tipoX = "t_mp_planes_actividades_checklist";


      $query = "SELECT id 'idActividad', descripcion_actividad 'actividad'
      FROM $tipoX
      WHERE id = ?";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idActividad);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         #RESULTADO FINAL POR REGISTRO
         $x['valor'] = $valor;
         $x['tipo'] = $tipo;

         $array = $x;
      }
      return $array;
   }


   public static function adjuntos($idOT)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      #RUTA ABSOLUTA PARA ENLACES
      $rutaAbsoluta = "_PATH/";
      if (strpos($_SERVER['REQUEST_URI'], "america") == true)
         $rutaAbsoluta = "https://www.maphg.com/america/planner/mp_ot/";
      if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
         $rutaAbsoluta = "https://www.maphg.com/europa/planner/mp_ot/";

      $query = "SELECT adj.id 'idAdjunto', adj.url 'nombreAdjunto', adj.fecha_subida 'fechaSubida',
      adj.id_usuario 'idSubidoPor', CONCAT(c.nombre, ' ',c.apellido) 'subidoPor' 
      FROM t_mp_planificacion_iniciada_adjuntos AS adj
      INNER JOIN t_users AS u ON adj.id_usuario = u.id
      INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
      WHERE adj.id_planificacion_iniciada = ? and adj.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idOT);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         #RESULTADO FINAL POR REGISTRO
         $x['url'] = $rutaAbsoluta . $x['nombreAdjunto'];
         $x['extension'] = pathinfo($x['url'], PATHINFO_EXTENSION);
         $array[] = $x;
      }
      return $array;
   }


   public static function materiales($idPlan)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT pm.id 'idRegistro', pm.cantidad_material 'cantidadMaterial', item.id 'idItem', item.cod2bend,
      item.descripcion_cod2bend 'descripcionCod2bend'
      FROM t_mp_planes_materiales AS pm
      INNER JOIN t_subalmacenes_items_globales AS item ON pm.id_item_global = item.id
      WHERE pm.id_plan = ? and pm.status = 'ACTIVO' and pm.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("s", $idPlan);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         #RESULTADO FINAL POR REGISTRO
         $array[] = $x;
      }

      return $array;
   }
}
