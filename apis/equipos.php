<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: http:localhost");

#ARRAY GLOBAL
$array = array();
$array['status'] = '404';

#PETICIÓN
$peticion = '';

#OBTIENE EL TIPO DE PETICIÓN
if ($_SERVER['REQUEST_METHOD'])
  $peticion = $_SERVER['REQUEST_METHOD'];


if ($peticion === "GET") {
  $array['status'] = 'ok';

  $idEquipoX = $_GET['idEquipo'];

  $query = "SELECT 
  e.id,
  e.id_equipo_principal,
  e.equipo,
  e.cod2bend,
  e.cantidad,
  e.matricula,
  e.serie,
  e.categoria,
  e.local_equipo,
  e.jerarquia,
  e.id_marca,
  e.modelo,
  e.numero_serie,
  e.codigo_fabricante,
  e.codigo_interno_compras,
  e.largo_cm,
  e.ancho_cm,
  e.alto_cm,
  e.potencia_electrica_hp,
  e.potencia_electrica_kw,
  e.voltaje_v,
  e.frecuencia_hz,
  e.caudal_agua_m3h,
  e.caudal_agua_gph,
  e.carga_mca,
  e.potencia_energetica_frio_kw,
  e.potencia_energetica_frio_tr,
  e.potencia_energetica_calor_kcal	,
  e.caudal_aire_m3h,
  e.caudal_aire_cfm,
  e.coste,
  e.id_fases,
  e.capacidad,
  e.fecha_instalacion,
  e.fecha_compra,
  e.años_garantia,
  e.años_vida_util,
  e.status,
  e.fecha_modificado,
  e.clasificacion,
  e.id_tipo,
  destino.id 'idDestino',
  destino.destino,
  seccion.id 'idSeccion',
  seccion.seccion,
  subseccion.id 'idSubseccion',
  subseccion.grupo 'subseccion'
  FROM t_equipos_america e
  INNER JOIN c_destinos destino ON e.id_destino = destino.id
  INNER JOIN c_secciones seccion ON e.id_seccion = seccion.id
  INNER JOIN c_subsecciones subseccion ON e.id_subseccion = subseccion.id
  WHERE e.id = $idEquipoX and e.activo = 1 and e.status NOT IN('BAJA')";
  if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $x) {

      #DATOS DE EQUIPO
      $idEquipo = intval($x['id']);
      $equipo = $x['equipo'];
      $idEquipoPrincipal = $x['id_equipo_principal'];
      $cod2bend = $x['cod2bend'];
      $cantidad = $x['cantidad'];
      $matricula = $x['matricula'];
      $serie = $x['serie'];
      $categoria = $x['categoria'];
      $localEequipo = $x['local_equipo'];
      $idTipo = intval($x['id_tipo']);
      $idMarca = intval($x['id_marca']);
      $jerarquia = $x['jerarquia'];
      $modelo = $x['modelo'];
      $numeroSerie = $x['numero_serie'];
      $codigoFabricante = $x['codigo_fabricante'];
      $codigoInternoCompras = $x['codigo_interno_compras'];
      $largo_cm = $x['largo_cm'];
      $ancho_cm = $x['ancho_cm'];
      $alto_cm = $x['alto_cm'];
      $potencia_electrica_hp = $x['potencia_electrica_hp'];
      $potencia_electrica_kw = $x['potencia_electrica_kw'];
      $voltaje_v = $x['voltaje_v'];
      $frecuencia_hz = $x['frecuencia_hz'];
      $caudal_agua_m3h = $x['caudal_agua_m3h'];
      $caudal_agua_gph = $x['caudal_agua_gph'];
      $carga_mca = $x['carga_mca'];
      $potencia_energetica_frio_kw = $x['potencia_energetica_frio_kw'];
      $potencia_energetica_frio_tr = $x['potencia_energetica_frio_tr'];
      $potencia_energetica_calor_kcal = $x['potencia_energetica_calor_kcal'];
      $caudal_aire_m3h = $x['caudal_aire_m3h'];
      $caudal_aire_cfm = $x['caudal_aire_cfm'];
      $coste = $x['coste'];
      $idFases = $x['id_fases'];
      $capacidad = $x['capacidad'];
      $fechaInstalacion = $x['fecha_instalacion'];
      $fechaCompra = $x['fecha_compra'];
      $añosGarantia = $x['años_garantia'];
      $añosVidaUtil = $x['años_vida_util'];
      $status = $x['status'];
      $fechaModificado = $x['fecha_modificado'];
      $clasificacion = $x['clasificacion'];

      #DATOS COMPLEMENTARIOS
      $idDestino = $x['idDestino'];
      $destino = $x['destino'];
      $idSeccion = $x['idSeccion'];
      $seccion = $x['seccion'];
      $idSubseccion = $x['idSubseccion'];
      $subseccion = $x['subseccion'];

      #MARCA DEL EQUIPO
      $marca = '';
      $query = "SELECT marca FROM c_marcas WHERE id = $idMarca";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $marca = $x['marca'];
        }
      }

      #TIPO EQUIPO
      $tipo = '';
      $query = "SELECT tipo FROM c_tipos WHERE id = $idTipo";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $marca = $x['tipo'];
        }
      }

      #FASE DEL EQUIPO (GP, TRS, ZI, ETC..)
      $fase = '';
      $query = "SELECT fase FROM c_tipos WHERE id = $idFases";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $fase = $x['fase'];
        }
      }

      #FOTO GRAFIAS DEL EQUIPO
      $adjuntos = array();
      $query = "SELECT a.id, a.url_adjunto, a.fecha, c.nombre, c.apellido
      FROM t_equipos_america_adjuntos a
      INNER JOIN t_users u ON a.subido_por = u.id
      INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
      WHERE a.id_equipo = $idEquipo and a.activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $idAdjunto = intval($x['id']);
          $url = $x['url_adjunto'];
          $extension = pathinfo($url, PATHINFO_EXTENSION);
          $fecha = $x['fecha'];
          $subidoPor = $x['nombre'] . " " . $x['apellido'];

          if ($fecha > '0000:00:00')
            $fecha = (new \DateTime($fecha))->format('Y-m-d');

          $adjuntos[] = array(
            "idAdjunto" => $idAdjunto,
            "url" => $url,
            "extension" => $extension,
            "fecha" => $fecha,
            "subidoPor" => $subidoPor
          );
        }
      }

      #COMENTARIOS DEL EQUIPO
      $comentarios = array();
      $query = "SELECT c.id, c.comentarios, c.fecha, colab.nombre, colab.apellido
      FROM t_equipos_america_comentarios c
      INNER JOIN t_users u ON c.id_usuario = u.id
      INNER JOIN t_colaboradores colab ON u.id_colaborador = colab.id
      WHERE c.id_equipo = $idEquipo and c.status IN('1', 'A')";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $idComentario = intval($x['id']);
          $comentario = $x['comentarios'];
          $fecha = $x['fecha'];
          $comentarioDe = $x['nombre'] . " " . $x['apellido'];

          $comentarios[] = array(
            "idComentario" => $idComentario,
            "comentario" => $comentario,
            "fecha" => $fecha,
            "comentarioDe" => $comentarioDe,
          );
        }
      }

      #MATERIALES ASIGNADOS AL EQUIPO
      $materialesPreventivo = array();
      $materialesIncidencias = array();
      $query = "SELECT 
      m.id,
      m.id_item_global,
      m.cantidad,
      m.tipo_asignacion,
      m.fecha,
      mg.cod2bend, 
      mg.descripcion_cod2bend,
      mg.descripcion_servicio_tecnico,
      c.nombre,
      c.apellido
      FROM t_equipos_materiales m
      INNER JOIN t_subalmacenes_items_globales mg ON m.id_item_global = mg.id
      INNER JOIN t_users u ON m.id_usuario = u.id
      INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
      WHERE m.id_equipo = $idEquipo and m.activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $idRegistro = intval($x['id']);
          $idMaterialGlobal = $x['id_item_global'];
          $cantidad = floatval($x['cantidad']);
          $tipoAsignacion = $x['tipo_asignacion'];
          $fecha = $x['fecha'];
          $cod2bend = $x['cod2bend'];
          $descripcionCod2bend = $x['descripcion_cod2bend'];
          $descripcionServicioTecnico = $x['descripcion_servicio_tecnico'];
          $asingadoPor = $x['nombre'] . " " . $x['apellido'];

          #ASINGACIÓN PREVENTIVO
          if ($tipoAsignacion === "PREVENTIVO") {
            $materialesPreventivo[] = array(
              "idRegistro" => $idRegistro,
              "idMaterialGlobal" => $idMaterialGlobal,
              "cantidad" => $cantidad,
              "tipoAsignacion" => $tipoAsignacion,
              "fecha" => $fecha,
              "cod2bend" => $cod2bend,
              "descripcionCod2bend" => $descripcionCod2bend,
              "descripcionServicioTecnico" => $descripcionServicioTecnico,
              "asingadoPor" => $asingadoPor,
            );
          }

          #ASINGACIÓN INCIDENCIAS
          if ($tipoAsignacion === "INCIDENCIA") {
            $materialesIncidencias[] = array(
              "idRegistro" => $idRegistro,
              "idMaterialGlobal" => $idMaterialGlobal,
              "cantidad" => $cantidad,
              "tipoAsignacion" => $tipoAsignacion,
              "fecha" => $fecha,
              "cod2bend" => $cod2bend,
              "descripcionCod2bend" => $descripcionCod2bend,
              "descripcionServicioTecnico" => $descripcionServicioTecnico,
              "asingadoPor" => $asingadoPor,
            );
          }
        }
      }

      #INCIDENCIAS ASIGNADAS AL EQUIPO
      $incidencias = array();
      $query = "SELECT 
      i.id, 
      i.actividad, 
      i.tipo_incidencia,
      i.status,
      i.responsable,
      i.responsable_empresa,
      i.fecha_creacion,
      i.fecha_realizado,
      i.ultima_modificacion,
      i.rango_fecha,
      i.status_material,
      i.status_trabajare,
      i.departamento_calidad,
      i.departamento_compras,
      i.departamento_direccion,
      i.departamento_finanzas,
      i.departamento_rrhh,
      i.energetico_electricidad,
      i.energetico_agua,
      i.energetico_diesel,
      i.energetico_gas,
      i.cod2bend,
      i.codsap,
      i.bitacora_gp,
      i.bitacora_trs,
      i.bitacora_zi,
      i.status_ep,
      i.fecha_llegada,
      i.orden_compra,
      i.coste,
      c.nombre,
      c.apellido
      FROM t_mc i
      INNER JOIN t_users u ON i.creado_por = u.id
      INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
      WHERE i.id_equipo = $idEquipo";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $idIncidencia = intval($x['id']);
          $incidencia = $x['actividad'];
          $tipoIncidencia = $x['tipo_incidencia'];
          $status = $x['status'];
          $creadoPor = $x['nombre'] . " " . $x['apellido'];
          $idResponsables = $x['responsable'];

          #FECHAS
          $fechaCreacion = $x['fecha_creacion'];
          $fechaSolucionado = $x['fecha_realizado'];
          $ultimaModificacion = $x['ultima_modificacion'];
          $rangoFecha = $x['rango_fecha'];

          #COMPROBANDO STATUS DE INCIENCIA (PENDIENTE)
          if ($status == "N" || $status == "PENDIENTE" || $status == "P")
            $status = "PENDIENTE";

          #COMPROBANDO STATUS DE INCIENCIA (SOLUCIONADO)
          if ($status == "F" || $status == "SOLUCIONADO")
            $status = "SOLUCIONADO";

          #RESPONSABLES DE LA INCIDENCIA
          $responsables = array();
          $query = "SELECT u.id,
            c.nombre,
            c.apellido
            FROM t_users u
            INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
            WHERE u.id IN($idResponsables)";
          if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
              $idUsuario = intval($x['id']);
              $responsable = $x['nombre'] . ' ' . $x['apellido'];

              $responsables[] = array(
                "idUsuario" => $idUsuario,
                "responsable" => $responsable
              );
            }
          }

          $incidencias[] = array(
            "idIncidencia" => $idIncidencia,
            "incidencia" => $incidencia,
            "tipoIncidencia" => $tipoIncidencia,
            "status" => $status,
            "fechaCreacion" => $fechaCreacion,
            "fechaSolucionado" => $fechaSolucionado,
            "ultimaModificacion" => $ultimaModificacion,
            "rangoFecha" => $rangoFecha,
            "creadoPor" => $creadoPor,
            "responsables" => $responsables,
          );
        }
      }


      #PREVENTIVOS ASIGNADOS AL EQUIPO
      $preventivos = array();

      $array['equipo'] = array(
        "idEquipo" => $idEquipo,
        "equipo" => $equipo,
        "detalles" => array(
          "cod2bend" => $cod2bend,
          "cantidad" => $cantidad,
          "matricula" => $matricula,
          "serie" => $serie,
          "categoria" => $categoria,
          "localEequipo" => $localEequipo,
          "jerarquia" => $jerarquia,
          "modelo" => $modelo,
          "numeroSerie" => $numeroSerie,
          "codigoFabricante" => $codigoFabricante,
          "codigoInternoCompras" => $codigoInternoCompras,
          "largo_cm" => $largo_cm,
          "ancho_cm" => $ancho_cm,
          "alto_cm" => $alto_cm,
          "potencia_electrica_hp" => $potencia_electrica_hp,
          "potencia_electrica_kw" => $potencia_electrica_kw,
          "voltaje_v" => $voltaje_v,
          "frecuencia_hz" => $frecuencia_hz,
          "caudal_agua_m3h" => $caudal_agua_m3h,
          "caudal_agua_gph" => $caudal_agua_gph,
          "carga_mca" => $carga_mca,
          "potencia_energetica_frio_kw" => $potencia_energetica_frio_kw,
          "potencia_energetica_frio_tr" => $potencia_energetica_frio_tr,
          "potencia_energetica_calor_kcal" => $potencia_energetica_calor_kcal,
          "caudal_aire_m3h" => $caudal_aire_m3h,
          "caudal_aire_cfm" => $caudal_aire_cfm,
          "coste" => $coste,
          "capacidad" => $capacidad,
          "fechaInstalacion" => $fechaInstalacion,
          "fechaCompra" => $fechaCompra,
          "añosGarantia" => $añosGarantia,
          "añosVidaUtil" => $añosVidaUtil,
          "status" => $status,
          "fechaModificado" => $fechaModificado,
          "clasificacion" => $clasificacion,
          "marca" => $marca,
          "tipo" => $tipo,
          "fase" => $fase,
        ),
        "adjuntos" => $adjuntos,
        "comentarios" => $comentarios,
        "incidencias" => $incidencias,
        "preventivos" => $preventivos,
        "materialesPreventivo" => $materialesPreventivo,
        "materialesIncidencias" => $materialesIncidencias,
      );
    }
  }
}

if ($peticion === "POST") {

  #VARIABLES POR METODO $_POST
  $_POST = json_decode(file_get_contents('php://input'), true);
  $idUsuario = $_POST['idUsuario'];
  $idDestino = $_POST['idDestino'];
  $action = $_POST['action'];

  #STUA DE RESPUESTA DEL SERVER
  $array['status'] = 'ok';

  if ($action == "planner") {
  }
}
echo json_encode($array);