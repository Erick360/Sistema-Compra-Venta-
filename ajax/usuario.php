<?php
//Realizamos el llamado de la conexion de base datos
require_once("../config/conexion.php");

//Realizamos el llamado a nuestro modelo usuarios
require_once("../models/Usuarios.php");

$usuarios = new Usuarios();

$id_usuario = isset($_POST["id_usuario"]);
$nombre = isset($_POST["nombre"]);
$apellido = isset($_POST["apellido"]);
$cedula = isset($_POST["cedula"]);
$telefono = isset($_POST["telefono"]);
$email = isset($_POST["email"]);
$direccion = isset($_POST["direccion"]);
$cargo = isset($_POST["cargo"]);
$usuario = isset($_POST["usuario"]);
$password = isset($_POST["password"]);
$password2 = isset($_POST["password2"]);
//este se envia a travez del formulario
$estado = isset($_POST["estado"]);

switch($_GET["op"]) {
  case "guardaryeditar":
    //verificamos si existe la cedula y correo
    $datos = $usarios->get_cedula_correo_del_usuario($_POST["cedula"] , $_POST["email"]);
    if ($password == $password2) {
      if (empty($_POST["id_usuario"])) {
        if (is_array($datos)==true and count($datos)==0) {
          $usuarios->registrar_usuario($nombre,$apellido,$cedula,$telefono,$email,$direccion,$cargo,
          $usuario,$password,$password2,$fecha_ingreso,$estado);

          $messages[] = "El usuario se registro correctamente";

        }else{
          $messages[] = "La cedula o el correo ya existe";
        }//fin de la validacion empty

      }else{
        $usuarios->editar_usuario($id_usuario,$nombre,$apellido,$cedula,$telefono,$email,$direccion,$cargo,
        $usuario,$password,$password2,$fecha_ingreso,$estado);

        $messages[] = "El usuario se edito correctamente";
      }//fin de mi validacion is_array

    }else{
      $errors[] = "La contraseña no coincide ";
    }//fin de mi validacion para passwords

//mensaje exitoso
if (isset($messages)) {
  ?>
    <div class="alert alert-sucess" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Bien Hecho!</strong>
        <?php
          foreach ($messages as $message) {
          echo $message;
        }
      ?>
    </div>
  <?php
}//fin de mi condicional success

//Mensaje Error
if (isset($errors)) {
  ?>
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Error!</strong>
    <?php
      foreach ($errors as $error) {
        echo $error;
      }
    ?>
  </div>
<?php
}//fin de mi condicional errors
    break;

    case "mostrar":
      //el parametro id_usunbario se envia por ajax cuando se edita el usuario
      $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);

      //validacion del idi del usuario
      if (is_array($datos)==true and count($datos)>0) {
        foreach ($datos as $row) {
          $output["cedula"] = $row["cedula"];
          $output["nombre"] = $row["nombre"];
          $output["apellido"] = $row["apellido"];
          $output["cargo"] = $row["cargo"];
          $output["usuario"] = $row["ususario"];
          $output["password"] = $row["password"];
          $output["password2"] = $row["password2"];
          $output["telefono"] = $row["telefono"];
          $output["correo"] = $row["correo"];
          $output["direccion"] = $row["direccion"];
          $output["estado"] = $row["estado"];
        }
        echo json_encode($output);
      }else {
        $errors[] = "El usuario no existe";
      }

      if (isset($errors)) {
        ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="cloase" data-dismiss="alert">$times;</button>
          <strong>Error!</strong>
          <?php
          foreach ($errors as $error) {
            echo $error;
          }
          ?>
         </div>
        <?php
      }

      break;

    case "activarydesactivar":

        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
        if (is_array($datos)==true and count($datos)>0) {
          $usuarios->editar_estado($_POST["id_usuario"], $_POST["est"]);
        }

        break;

    case "listar":

      $datos = $usuarios->get_usuarios();
      $data = Array();
      foreach ($datos as $row) {
        $sub_array = array();

        //estado del usuario
        $est = '';
        $atrib = "btn btn-success btn-md estado";
        if ($row["estado"]==0) {
          $est = 'INACTIVO';
          $atrib = "btn btn-warning btn-md estado";
        }else {
          if ($row["estado"]==1) {
            $est = 'ACTIVO';
          }
        }

        //Cargo
        if ($row["cargo"]==1) {
          $cargo = "ADMINISTRADOR";
        }else {
           if ($row["cargo"]==0) {
             $cargo = "EMPLEADO";
           }
        }

          $sub_array[] = $row["cedula"];
          $sub_array[] = $row["nombres"];
          $sub_array[] = $row["apellidos"];
          $sub_array[] = $row["usario"];
          $sub_array[] = $row["telefono"];
          $sub_array[] = $cargo;
          $sub_array[] = $row["correo"];
          $sub_array[] = $row["direccion"];
          $sub_array[] = date("d-m-Y",strtotime($row["fecha_ingreso"]));

          $sub_array[] = '<button type="button" onClick="cambiarEstado(
          '.$row["id_usuario"].','.$row["estado"].');"
          name="estado" id="'.$row["id_usuario"].'" class="'.$atrib.'">'
          .$est.'</button>';

          $sub_array[] = '<button type="button" onClick="mostrar('.$row["id_usuario"].');"
          id="'.$row["id_usuario"].'" class="btn btn-warning btn-md update"><i
          class="glyphicon glyphicon-edit"></i> Editar </button>';

          $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_usuario"].');"
          id="'.$row["id_usuario"].'" class="btn btn-danger btn-md"><i
          class="glyphicon glyphicon-edit"></i> Eliminar </button>';

          $data[] = $sub_array;
      }//fin de nuestro foreach

          $results =  array(
            "sEcho"=>1,//Informacion para Datatable
            "iTotalRecords"=>count($data),//enviamos el total de registros a Datatables
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
          echo json_encode($results);
      break;
}
 ?>
