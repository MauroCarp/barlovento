<?php
require_once "conexion.php";

class ModeloGordos{

  // Inserta una fila en gordosResumen
  static public function mdlInsertResumen($datos){
    
    $sql = "DELETE FROM gordosresumen";
    $stmt = Conexion::conectar()->prepare($sql);
    $stmt->execute();
    $stmt = null;

    $sql = "INSERT INTO gordosresumen(fecha, mes, tipo, categoria, kg, cantidad, posicion) VALUES $datos";

    $stmt = Conexion::conectar()->prepare($sql);
    
    return $stmt->execute();

  }

  static public function mdlInsertResumenMensual($datos){
    
    $sql = "DELETE FROM gordosresumenmensual";
    $stmt = Conexion::conectar()->prepare($sql);
    $stmt->execute();
    $stmt = null;

    $sql = "INSERT INTO gordosresumenmensual(mes, tipo, feedlot_novillos, campo_vaquillona, hotel) VALUES $datos";

    $stmt = Conexion::conectar()->prepare($sql);
    
    return $stmt->execute();

  }

  // Inserta una fila en gordos
  static public function mdlInsertGordos($datos){

    $sql = "DELETE FROM gordos";
    $stmt = Conexion::conectar()->prepare($sql);
    $stmt->execute();
    $stmt = null;

    $sql = "INSERT INTO gordos(fecha, mes, oferta, demanda, tipo) VALUES $datos";
    
    $stmt = Conexion::conectar()->prepare($sql);

    return $stmt->execute();
    
  }

  static public function mdlMostrarData($tabla){

    $sql = "SELECT * FROM $tabla";
    
    $stmt = Conexion::conectar()->prepare($sql);
    
    $stmt -> execute();

    return $stmt -> fetchAll();
    
  }


  // Filas por kg para un tipo/categoría en una fecha
  static public function mdlFilasKgPorTipoCategoria($tipo, $categoria){
    $sql = "SELECT mes, kg, SUM(cantidad) AS cantidad FROM gordosresumen WHERE tipo = :tipo AND categoria = :categoria GROUP BY mes, kg ORDER BY MIN(posicion) ASC";
    $stmt = Conexion::conectar()->prepare($sql);
    $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Todas las filas agrupadas por mes, tipo y categoría (para armar "mensual")
  static public function mdlResumenMensual(){

    $sql = "SELECT * FROM gordosresumenmensual ORDER BY id ASC";

    $stmt = Conexion::conectar()->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  }



}
