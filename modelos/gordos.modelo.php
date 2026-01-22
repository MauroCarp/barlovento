<?php
require_once "conexion.php";

class ModeloGordos{

  // Inserta una fila en gordosResumen
  static public function mdlInsertResumen($datos){
      
    $sql = "INSERT INTO gordosResumen(fecha, mes, tipo, categoria, kg, cantidad, posicion) VALUES $datos";

    $stmt = Conexion::conectar()->prepare($sql);
    
    return $stmt->execute();

  }

  // Inserta una fila en gordos
  static public function mdlInsertGordos($datos){

    $sql = "INSERT INTO gordos(fecha, mes, oferta, demanda, tipo) VALUES $datos";
    
    var_dump($sql);

    $stmt = Conexion::conectar()->prepare($sql);

    return $stmt->execute();
    
  }

}
