<?php
require_once("../config/conexion.php");

class Categoria extends Conectar {
    public function get_categorias(){
        $conectar=parent::conexion();
        parent::set_names();
        $sql = "select * from categoria";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_categoria_por_id($id_categoria){
        $conectar=parent::conexion();
        parent::set_names();
        $sql = "select * from categoria where id_categoria=?";
        $sql->bindValue(1, $id_categoria);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }    

    //metodo para insertar registros 
    public function registrar_categoria($categoria,$estado,$id_usuario){
        $conectar=parent::conexion();
        parent::set_names();
        $sql = "insert into categoria values (null,?,?,?);";

        $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $_POST["categoria"]);
            $sql->bindValue(2, $_POST["estado"]);
            $sql->bindValue(3, $_POST["id_usuario"]);
            $sql->execute();
    }

    public function editar_categoria($id_categoria,$categoria,$estado,$id_usuario){
        $conectar=parent::conexion();
        parent::set_names();
        $sql = "update categoria set 
        categoria=?,
        estado=?,
        id_usuario=?
        
        where
        id_categoria=?";

        $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $_POST["categoria"]);
            $sql->bindValue(2, $_POST["estado"]);
            $sql->bindValue(3, $_POST["id_usuario"]);
            $sql->bindValue(4, $_POST["id_categoria"]);
            $sql->execute();
    }
    
    //metodo para activar y!o desactivar el estado de la categoria
    public function editar_estado($id_categoria, $estado){
        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
            $estado = 1;
        }else{
            $estado = 0;
        }
        $sql = "update categoria set 
        estado = ?
        where id_categoria=?";

        $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $estado);
            $sql->bindValue(2, $id_categoria);
            $sql->execute();
    }

    public function get_nombre_categoria($categoria){
        $conectar=parent::conexion();
        
        $sql = "select * from categoria where categoria=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $categoria);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>