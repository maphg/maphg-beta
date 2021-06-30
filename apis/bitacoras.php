<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: *");
if (isset($_GET['action'])) {

  #Variables Globales
  $action = $_GET['action'];
  $idDestino = $_GET['idDestino'];
  $idUsuario = $_GET['idUsuario'];
  $fechaActual = date('Y-m-d H:m:s');

  #FECHA CON LETRAS
  $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
  $dia = $dias[date('w', strtotime($fechaActual))];
  $num = date("j", strtotime($fechaActual));
  $anno = date("Y", strtotime($fechaActual));
  $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
  $mes = $mes[(date('m', strtotime($fechaActual)) * 1) - 1];
  $fechaTexto =  $dia . ' ' . $num . ' de ' . $mes . ' del ' . $anno . ', ' . date('H:m:s');

  $idPermisos = 0;
  $array = array();

  #OBTIENE BITACORAS HABILITADAS
  if ($action == "obtenerBitacoras") {
    #FECHAS PARA BUSQUEDA DE DATOS
    $fechaInicio = date('Y-m-d 00:00:01');
    $fechaFin = date('Y-m-d 23:59:00');

    $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $destino = $x['destino'];

        $array['info'] = array(
          "destino" => $destino,
          "fecha" => $fechaTexto,

        );
      }
    }

    $query = "SELECT 
    bitacora.id,
    destino.id idDestino,
    destino.destino,
    seccion.id idSeccion, 
    seccion.seccion, 
    subseccion.id idSubseccion,
    subseccion.grupo,
    tipo.id idTipo,
    tipo.tipo
    FROM t_bitacora_zi_habilitadas bitacora
    INNER JOIN c_destinos destino ON bitacora.id_destino = destino.id 
    INNER JOIN c_secciones seccion ON bitacora.id_seccion = seccion.id 
    INNER JOIN c_subsecciones subseccion ON bitacora.id_subseccion = subseccion.id 
    INNER JOIN c_tipos tipo ON bitacora.id_tipo = tipo.id 
    WHERE bitacora.id_destino = $idDestino and bitacora.activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idDestinoX = $x['idDestino'];
        $destino = $x['destino'];
        $idSeccion = $x['idSeccion'];
        $seccion = $x['seccion'];
        $idSubseccion = $x['idSubseccion'];
        $subseccion = $x['grupo'];
        $idTipo = $x['idTipo'];
        $tipo = $x['tipo'];

        #ARRAY DE EQUIPOS
        $activos = array();
        $query = "SELECT id, equipo
        FROM t_equipos_america
        WHERE id_destino = $idDestinoX and id_seccion = $idSeccion and id_subseccion = $idSubseccion and 
        id_tipo = $idTipo and status NOT IN('BAJA') and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idEquipo = $x['id'];
            $equipo = $x['equipo'];
            $bitacoras = array();
            $graficas = array();

            $query = "SELECT id, parametro, dato_minimo, dato_maximo, unidad_medida, horario_medicion_inicio_turno_1, horario_medicion_fin_turno_1, horario_medicion_inicio_turno_2, horario_medicion_fin_turno_2
            FROM t_bitacora_zi
            WHERE id_destino = $idDestinoX and id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_tipo = $idTipo and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
              foreach ($result as $x) {
                $idBitacora = $x['id'];
                $parametro = $x['parametro'];
                $unidadMedida = $x['unidad_medida'];
                $horario1 = $x['horario_medicion_inicio_turno_1'];
                $horario2 = $x['horario_medicion_fin_turno_1'];
                $horario3 = $x['horario_medicion_inicio_turno_2'];
                $horario4 = $x['horario_medicion_fin_turno_2'];

                #DATOS DEL DÍA ACTUAL
                $idRegistro = 0;
                $valor1 = 0;
                $fechaCaptura1 = '';
                $valor2 = 0;
                $fechaCaptura2 = '';
                $query = "SELECT id, dato_1, fecha_dato_1, dato_2, fecha_dato_2
                FROM t_bitacora_zi_datos
                WHERE id_destino = $idDestinoX and id_bitacora = $idBitacora and id_equipo = $idEquipo 
                and activo = 1  and fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin'";
                if ($result = mysqli_query($conn_2020, $query)) {
                  foreach ($result as $x) {
                    $idRegistro = $x['id'];
                    $valor1 = $x['dato_1'];
                    $fechaCaptura1 = $x['fecha_dato_1'];
                    $valor2 = $x['dato_2'];
                    $fechaCaptura2 = $x['fecha_dato_2'];
                  }
                }

                $bitacoras[] = array(
                  "idBitacora" => $idBitacora,
                  "idEquipo" => $idEquipo,
                  "idRegistro" => $idRegistro,
                  "parametro" => $parametro,
                  "unidadMedida" => $unidadMedida,
                  "valor1" => $valor1,
                  "fechaCaptura1" => $fechaCaptura1,
                  "valor2" => $valor2,
                  "fechaCaptura2" => $fechaCaptura2,
                  "horario1" => $horario1,
                  "horario2" => $horario2,
                  "horario3" => $horario3,
                  "horario4" => $horario4,
                );

                #GRAFICA
                $graficaFechas = array();
                $graficaValor1 = array();
                $graficaValor2 = array();
                $query = "SELECT id, dato_1, fecha_dato_1, dato_2, fecha_dato_2, fecha_creacion
                FROM t_bitacora_zi_datos
                WHERE id_destino = $idDestinoX and id_bitacora = $idBitacora and id_equipo = $idEquipo 
                and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                  foreach ($result as $x) {
                    $idRegistro = $x['id'];
                    $valor1 = $x['dato_1'];
                    $fechaCaptura1 = $x['fecha_dato_1'];
                    $valor2 = $x['dato_2'];
                    $fechaCaptura2 = $x['fecha_dato_2'];
                    $fechaCaptura = (new \DateTime($x['fecha_creacion']))->format('Y-m-d');

                    $graficaValor1[] = $valor1;
                    $graficaValor2[] = $valor2;
                    $graficaFechas[] = $fechaCaptura;
                  }
                }
                $graficas[] = array(
                  "parametro" => $parametro,
                  "graficaFechas" => $graficaFechas,
                  "graficaValor1" => $graficaValor1,
                  "graficaValor2" => $graficaValor2,

                );
              }
            }

            $activos[] = array(
              "idEquipo" => $idEquipo,
              "equipo" => $equipo,
              "bitacoras" => $bitacoras,
              "graficas" => $graficas
            );
          }
        }

        $array['data'][] = array(
          "idDestino" => $idDestinoX,
          "destino" => $destino,
          "idSeccion" => $idSeccion,
          "seccion" => $seccion,
          "idSubseccion" => $idSubseccion,
          "subseccion" => $subseccion,
          "idTipo" => $idTipo,
          "tipo" => $tipo,
          "activos" => $activos,
        );
      }
    }
    echo json_encode($array);
  }

  #ACTUALIZA LA BITACORA
  if ($action == "actualizarBitacora") {
    $x = json_decode(file_get_contents('php://input'), true);
    $idRegistro = $x['idRegistro'];
    $idEquipo = $x['idEquipo'];
    $idBitacora = $x['idBitacora'];
    $valor1 = $x['valor1'];
    $valor2 = $x['valor2'];
    $valor = $x['valor'];
    $resp = 0;

    # SI EL REGISTRO AUN NO EXISTE LO CREA SEGÚN EL VALOR 1.
    if ($idRegistro == 0 && $valor == "valor1") {
      $query = "INSERT INTO t_bitacora_zi_datos(id_destino, id_bitacora, id_equipo, capturado_por, dato_1, fecha_dato_1, dato_2, fecha_dato_2, fecha_creacion, activo) VALUES($idDestino, $idBitacora, $idEquipo, $idUsuario, $valor1, '$fechaActual', 0, '', '$fechaActual', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
        $resp = 1;
      }
    }

    # SI EL REGISTRO AUN NO EXISTE LO CREA SEGÚN EL VALOR 2.
    if ($idRegistro == 0 && $valor == "valor2") {
      $query = "INSERT INTO t_bitacora_zi_datos(id_destino, id_bitacora, id_equipo, capturado_por, dato_1, fecha_dato_1, dato_2, fecha_dato_2, fecha_creacion, activo) VALUES($idDestino, $idBitacora, $idEquipo, $idUsuario, 0, '', $valor2, '$fechaActual', '$fechaActual', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
        $resp = 1;
      }
    }

    #ACTUALIZA EL VALOR(DATO_1) Y FECHA(fecha_dato_1) 
    if ($idRegistro > 0 and $valor == "valor1") {
      $query = "UPDATE t_bitacora_zi_datos SET dato_1 = $valor1, fecha_dato_1 = '$fechaActual' 
      WHERE id = $idRegistro and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
        $resp = 1;
      }
    }

    #ACTUALIZA EL VALOR(DATO_2) Y FECHA(fecha_dato_2) 
    if ($idRegistro > 0 and $valor == "valor2") {
      $query = "UPDATE t_bitacora_zi_datos SET dato_2 = $valor2, fecha_dato_2 = '$fechaActual' 
      WHERE id = $idRegistro and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
        $resp = 1;
      }
    }

    echo json_encode($resp);
  }
}
