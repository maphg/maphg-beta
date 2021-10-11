<?php


class Usuarios extends Conexion
{
   public $idUsuario;
   public $nombre;
   public $apellido;
   public $cargo;
   public $foto;

   public static function getById($idUsuario)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT
      u.id 'idUsuario',
      colaborador.nombre,
      colaborador.apellido,
      colaborador.foto,
      cargo.id 'idCargo',
      cargo.cargo
      FROM t_users AS u
      INNER JOIN t_colaboradores AS colaborador ON u.id_colaborador = colaborador.id
      INNER JOIN c_cargos AS cargo ON colaborador.id_cargo = cargo.id
      WHERE u.id = ?";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idUsuario);
      $prepare->execute();
      $response = $prepare->get_result();

      return $response->fetch_object(Usuarios::class);
   }
}
