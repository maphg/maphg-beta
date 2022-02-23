<?php
// Registro de Staff para COVID

class StaffCovid extends Conexion
{

   public static function all($idDestino, $año, $mes)
   {
      // OBTIENE TODO LOS DATOS POR AÑO Y DESTINO.

      $conexion = new Conexion();
      $conexion->conectar();

      $filtroMes = $mes === "TODOS" ? "" : "and mes = '$mes'";


      $query = "SELECT staff.id 'idRegistro', staff.fecha_creado 'fechaCreado', staff.mes, staff.año,
      staff.numero_faltantes 'numeroFaltantes', staff.porcentaje_faltantes_vs_staffing 'porcentajeFaltantes',
      staff.numero_empleados_covid 'numeroEmpleadosCovid', staff.incapacidades_medica 'incapacidadesMedica',
      staff.observaciones, staff.activo, col.nombre, col.apellido, destino.destino
      FROM t_registro_staff AS staff
      INNER JOIN c_destinos AS destino ON staff.id_destino = destino.id
      INNER JOIN t_users AS u ON staff.creado_por = u.id
      INNER JOIN t_colaboradores AS col ON u.id_colaborador = col.id
      WHERE staff.id_destino = ? and staff.año = ? and staff.activo = 1 $filtroMes";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("ii", $idDestino, $año);
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

   #CREAR REGISTRO
   public function crear()
   {
      $this->conectar();

      $query = "INSERT INTO t_registro_staff(id_destino, creado_por, fecha_creado, mes, año, numero_faltantes, porcentaje_faltantes_vs_staffing, numero_empleados_covid, incapacidades_medica, observaciones, activo)
      VALUES(?,?,?,?,?,?,?,?,?,?,?)";

      $prepare = mysqli_prepare($this->con, $query);
      $prepare->bind_param(
         "iissiidiisi",
         $this->idDestino,
         $this->idUsuario,
         $this->fechaActual,
         $this->mes,
         $this->año,
         $this->numeroFaltantes,
         $this->porcentajeFaltantes,
         $this->numeroEmpleadosCovid,
         $this->incapacidadesMedica,
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
         numero_faltantes = ?,
         porcentaje_faltantes_vs_staffing = ?,
         numero_empleados_covid = ?,
         incapacidades_medica = ?,
         observaciones = ?,
         modificado_por = ?,
         fecha_modificado = ?
         WHERE id = ?";
         $prepare = mysqli_prepare($this->con, $query);
         $prepare->bind_param(
            "idiisisi",
            $this->numeroFaltantes,
            $this->porcentajeFaltantes,
            $this->numeroEmpleadosCovid,
            $this->incapacidadesMedica,
            $this->observaciones,
            $this->idUsuario,
            $this->fechaActual,
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
}
