<?php

require_once "conexion.php";

class ModeloTrazabilidad{

	static public function mdlMostrarFaenas($tabla, $item, $valor){
		
		if($item != null){

			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY created_at ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
			
		}else{
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY created_at ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}
		
		$stmt = null;

	}

	static public function mdlNuevaFaena($tabla,$datos){

		$conexion = Conexion::conectar(); 
		$stmt = $conexion->prepare("INSERT INTO $tabla(nombre, fecha,frigorifico) VALUES (:nombre, :fecha, :frigorifico)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":frigorifico", $datos["frigorifico"], PDO::PARAM_STR);
		
		if($stmt->execute()){ 
			
			return $conexion->lastInsertId();
			
		}else{
			
			return $stmt->errorInfo();
			
		}
		
	}

	static public function mdlCargarExcel($tabla,$campos,$datos){

		$conexion = Conexion::conectar(); 
		$stmt = $conexion->prepare("INSERT INTO " . $tabla . "(idFaena, " . $campos . ") VALUES " . $datos );
	
		if($stmt->execute()){ 

			return 'ok';
			
		}else{
			
			return $stmt->errorInfo();
			
		}
		
	}

	static public function mdlEliminarFaena($idFaena){

		$conexion = Conexion::conectar(); 
		$stmt = $conexion->prepare("DELETE FROM faenas WHERE id = :id");

		$stmt->bindParam(":id", $idFaena, PDO::PARAM_STR);
		
		if($stmt->execute()){ 

			return 'ok';
			
		}else{
			
			return $stmt->errorInfo();
			
		}
		
	}

	static public function mdlDataReporte1($idFaena,$tabla,$tabla2 = null,$tabla3 = null){

		if($tabla != 'faenas'){
			
			$stmt = Conexion::conectar()->prepare("SELECT $tabla.rfid as rfidTD,
														  $tabla.mmGrasa,	
														  $tabla.peso,	
														  $tabla.sexo,	
														  $tabla.clasificacion,	
														  $tabla.aob,
														  $tabla.fecha as fechaTD,	
														  $tabla.refEco,	
														  $tabla2.rfid as rfidTrazabilidad,
														  $tabla2.correlacion,
														  $tabla2.garron,
														  $tabla2.kilos,
														  $tabla2.denominacion,
														  $tabla2.tipificacion,
														  $tabla2.gordo,
														  $tabla2.den,
														  $tabla3.* FROM $tabla INNER JOIN $tabla2 ON $tabla.rfid = $tabla2.rfid INNER JOIN $tabla3 ON $tabla.rfid = $tabla3.rfid WHERE $tabla.idFaena = :idFaena AND $tabla2.idFaena = :idFaena AND $tabla3.idFaena = :idFaena ORDER BY $tabla.rfid ASC");
	
			$stmt -> bindParam(":idFaena", $idFaena, PDO::PARAM_STR);
	
			$stmt -> execute();
	
			return $stmt -> fetchAll(); 
			
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id = :id");
	
			$stmt -> bindParam(":id", $idFaena, PDO::PARAM_STR);
	
			$stmt -> execute();
	
			return $stmt -> fetch(); 
			
		} 


	}

	static public function mdlMostrarAnimalesFaenas($tabla, $ids) {

		$conexion = Conexion::conectar();
		if($tabla == 'wcanimales'){

			$stmt = $conexion->prepare("SELECT * FROM $tabla WHERE idFaena IN (:idFaena) ORDER BY ingreso DESC");

		} else {
			
			$stmt = $conexion->prepare("SELECT * FROM $tabla WHERE idFaena IN (:idFaena) ORDER BY rfid ASC");

		}

		$stmt->bindParam(":idFaena", $ids, PDO::PARAM_STR);


		$stmt->execute();

		return $stmt->fetchAll();
	}


}