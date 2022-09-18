<?php
class Conectar {
  protected $dbh;
  protected function conexion(){
  try {
    $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=dbproyecto","root","");
    return $conectar;

  } catch (Exception $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
  }//end of my function try
}//end of my function conexion

public function set_names(){
  return $this->dbh->query("SET NAMES 'utf8'");
}//this function evit tilde errors

public function Route(){
return "http://localhost/Proyecto/";
}
}//end of my class Conectar
 ?>
