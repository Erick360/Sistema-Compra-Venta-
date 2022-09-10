<?php
require_once("../config/conexion.php");

class usuarios extends Conectar {
//listado de usuarios
  public function get_usuarios(){
    $conectar=parent::conexion();
    parent::set_names();

    $sql = "select * from usuarios";
    $sql = $conectar->prepare($sql);
    $sql->execute();

    return $resultado=$sql->fetchAll();
  }

public function registrar_usuario($nombre,$apellido,$cedula,$telefono,$email,$direccion,$cargo,
$usuario,$password,$password2,$fecha_ingreso,$estado){

    $conectar = parent::conexion();
    parent::set_names();

    $sql = "insert into usuarios
    values(null,?,?,?,?,?,?,?,?,?,?,now(),?);";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1, $_POST["nombre"]);
      $sql->bindValue(2, $_POST["apellido"]);
      $sql->bindValue(3, $_POST["cedula"]);
      $sql->bindValue(4, $_POST["telefono"]);
      $sql->bindValue(5, $_POST["email"]);
      $sql->bindValue(6, $_POST["direccion"]);
      $sql->bindValue(7, $_POST["cargo"]);
      $sql->bindValue(8, $_POST["usuario"]);
      $sql->bindValue(9, $_POST["password"]);
      $sql->bindValue(10, $_POST["password2"]);
      $sql->bindValue(11, $_POST["estado"]);
      $sql->execute();
  }
  //funcion que editar informacion del usuario
  public function editar_usuario($id_usuario,$nombre,$apellido,$cedula,$telefono,$email,$direccion,$cargo,
$usuario,$password,$password2,$fecha_ingreso,$estado){
    $conectar=parent::conexion();
    parent::set_names();

      $sql = "update usuarios set
      nombres=?,
      apellidos=?,
      cedula=?,
      telefono=?,
      correo=?,
      direccion=?,
      cargo=?,
      usuario=?,
      password=?,
      password2=?,
      estado

      where
      id_usuario=?
      ";
      $sql = $conectar->prepare($sql);

      $sql->bindValue(1, $_POST["nombre"]);
      $sql->bindValue(2, $_POST["apellido"]);
      $sql->bindValue(3, $_POST["cedula"]);
      $sql->bindValue(4, $_POST["telefono"]);
      $sql->bindValue(5, $_POST["email"]);
      $sql->bindValue(6, $_POST["direccion"]);
      $sql->bindValue(7, $_POST["cargo"]);
      $sql->bindValue(8, $_POST["usuario"]);
      $sql->bindValue(9, $_POST["password"]);
      $sql->bindValue(10, $_POST["password2"]);
      $sql->bindValue(11, $_POST["estado"]);
      $sql->bindValue(12, $_POST["id_usuario"]);
      $sql->execute();
  }
//funcion que muestra los datos del usuario mediante su id
public function get_usuario_id($id_usuario){
$conectar=parent::conexion();
  parent::set_names();
    $sql = "select * from usuarios where id_usuario=? ";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario);
    $sql->execute();

    return $resultado=$sql->fetchAll();
}

//Funcion que edita el estado de los usuarios
public function estado_usuario($id_usuario,$estado){
  $conectar = parent::conexion();

//este parametro se envia via ajax
  if ($_POST["est"]==0) {
    $estado = 1;
  }else{
    $estado=0;
  }
  parent::set_names();

    $sql = "updates usuarios set
    estado=?
    where
     id_usuario=?
     ";

     $sql  = $conectar->prepare($sql);
     $sql->bindValue(1, $id_usuario);
     $sql->bindValue(2, $estado);
     $sql->execute();
   }//fin de mi funcion estado_usuario
//Funcion para validar informacion del usuario

public function get_cedula_correo_del_usuario($cedula,$email){
  $conectar = parent::conexion();
  parent::set_names();

    $sql = "select * from usuarios where cedula=? or correo=? ";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $cedula);
    $sql->bindValue(2, $email);
    $sql->execute();

    return $resultado=$sql->fetchAll();
  }//fin de mi funcion
}//Fin de mi clase
?>
