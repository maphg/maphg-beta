<?php
// Registro de Staff para COVID

class StaffCovid extends Conexion
{

   public static function all($idDestino, $año)
   {
      // OBTIENE TODO LOS DATOS POR AÑO Y DESTINO.

      $conexion = new Conexion();
      $conexion->conectar();

      $filtroDestino = "and staff.id_destino = $idDestino";

      if ($idDestino == 10)
         $filtroDestino = "";

      #ARRAY DE LOS MESES POR NUMERO DE MES.
      $meses = ["?", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];

      $query = "SELECT
      staff.id 'idRegistro',
      staff.fecha_creado 'fechaCreado',
      staff.fecha_estimada 'fechaEstimada',
      staff.mes,
      staff.año,
      staff.staff_aprovado 'staffAprobado',
      staff.staff_contratado 'staffContratado',
      staff.staff_faltante_con_covid 'staffFaltanteConCovid',
      staff.incapacidades_medicas 'incapacidadesMedicas',
      staff.observaciones,
      staff.activo,
      CONCAT(col.nombre, ' ', col.apellido) 'creadoPor',
      destino.pais,
      destino.id 'idDestino',
      destino.destino
      FROM t_registro_staff AS staff
      INNER JOIN c_destinos AS destino ON staff.id_destino = destino.id
      INNER JOIN t_users AS u ON staff.creado_por = u.id
      INNER JOIN t_colaboradores AS col ON u.id_colaborador = col.id
      WHERE staff.año = ? and staff.activo = 1 $filtroDestino
      ORDER BY staff.fecha_estimada ASC";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $año);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         if ($x['mes'] > 0)
            $x['mes'] = $meses[$x['mes']];

         #RESULTADO FINAL POR REGISTRO
         $array[] = $x;
      }
      return $array;
   }

   #CREAR REGISTRO
   public function crear()
   {
      $this->conectar();

      $query = "INSERT INTO t_registro_staff(id_destino, creado_por, fecha_creado, fecha_estimada, pais, mes, año, staff_aprovado, staff_contratado, staff_faltante_con_covid, incapacidades_medicas, observaciones, activo)
      VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

      $prepare = mysqli_prepare($this->con, $query);
      $prepare->bind_param(
         "iisssiiiiiisi",
         $this->idDestino,
         $this->creadoPor,
         $this->fechaActual,
         $this->fechaEstimada,
         $this->pais,
         $this->mes,
         $this->año,
         $this->staffAprobado,
         $this->staffContratado,
         $this->staffFaltanteConCovid,
         $this->incapacidadesMedicas,
         $this->observaciones,
         $this->activo
      );

      if ($prepare->execute())
         return true;
      else
         return false;
   }


   #ACTUALIZAR PROYECTO
   public function actualizar()
   {
      try {
         $this->conectar();
         $query = "UPDATE t_registro_staff SET
         fecha_estimada = ?,
         mes = ?,
         año = ?,
         staff_aprovado = ?,
         staff_contratado = ?,
         staff_faltante_con_covid = ?,
         incapacidades_medicas = ?,
         observaciones = ?,
         modificado_por = ?,
         fecha_modificado = ?,
         activo = ?
         WHERE id = ?";
         $prepare = mysqli_prepare($this->con, $query);
         $prepare->bind_param(
            "siiiiiisisii",
            $this->fechaEstimada,
            $this->mes,
            $this->año,
            $this->staffAprobado,
            $this->staffContratado,
            $this->staffFaltanteConCovid,
            $this->incapacidadesMedicas,
            $this->observaciones,
            $this->actualizadoPor,
            $this->fechaActual,
            $this->activo,
            $this->idRegistro
         );

         if ($prepare->execute())
            return true;
         else
            return false;
      } catch (\Throwable $th) {
         return $th;
      }
   }


   #OPCIONES DE DESTINO
   public static function opcionesDestino($idUsuario)
   {
      // OBTIENE TODO LOS DATOS POR AÑO Y DESTINO.

      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT id_destino 'idDestino'
      FROM t_users
      WHERE id = ? and activo = 1 LIMIT 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idUsuario);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();
      $idDestinoX = 0;

      foreach ($response as $x) {
         #RESULTADO FINAL POR REGISTRO
         $idDestinoX = intval($x['idDestino']);
      }

      $filtroDestino = "WHERE id IN($idDestinoX)";
      if ($idDestinoX === 10)
         $filtroDestino = "";

      #OBTENEMOS DATOS SEGÚN PERMISOS DE DESTINO
      $query = "SELECT id 'idDestino', destino FROM c_destinos $filtroDestino";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->execute();
      $response = $prepare->get_result();
      foreach ($response as $x) {
         #RESULTADO FINAL POR REGISTRO
         $array[] = $x;
      }


      return $array;
   }
}
