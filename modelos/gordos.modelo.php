<?php
require_once "conexion.php";

class ModeloGordos{

  // Inserta una fila en gordosResumen
  static public function mdlInsertResumen($datos){
    $sql = "INSERT INTO gordosResumen(fecha, mes, tipo, categoria, kg, cantidad, posicion)
            VALUES(:fecha, :mes, :tipo, :categoria, :kg, :cantidad, :posicion)";
    $stmt = Conexion::conectar()->prepare($sql);
    $stmt->bindParam(':fecha', $datos['fecha']);
    $stmt->bindParam(':mes', $datos['mes']);
    $stmt->bindParam(':tipo', $datos['tipo']);
    $stmt->bindParam(':categoria', $datos['categoria']);
    $stmt->bindParam(':kg', $datos['kg']);
    $stmt->bindParam(':cantidad', $datos['cantidad']);
    $stmt->bindParam(':posicion', $datos['posicion']);
    return $stmt->execute();
  }

  // Inserta una fila en gordos
  static public function mdlInsertGordos($datos){
    $sql = "INSERT INTO gordos(fecha, mes, oferta, demanda, tipo)
            VALUES(:fecha, :mes, :oferta, :demanda, :tipo)";
    $stmt = Conexion::conectar()->prepare($sql);
    $stmt->bindParam(':fecha', $datos['fecha']);
    $stmt->bindParam(':mes', $datos['mes']);
    $stmt->bindParam(':oferta', $datos['oferta']);
    $stmt->bindParam(':demanda', $datos['demanda']);
    $stmt->bindParam(':tipo', $datos['tipo']);
    return $stmt->execute();
  }

}
