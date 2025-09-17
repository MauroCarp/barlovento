<?php

require_once "conexion.php";

class ModeloAgro{
	
	/*=============================================
	CARGAR ARCHIVO AGRO
	=============================================*/
	static public function mdlCargarArchivo($tabla,$campos,$data){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla($campos) VALUES $data");

		if($stmt->execute()){
			
			return "ok";	
			
		}else{
			
			return $stmt->errorInfo();
			
		}
	}

	/*=============================================
	CARGAR LABORES EJECUCION
		=============================================*/
	static public function mdlCargarLabores($tabla,$data){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idEjecucion,lote,labor,cultivo,has,costoLabor,costoInsumo,campo,etapa) VALUES $data");

		if($stmt->execute()){
			
			return "ok";	
			
		}else{
			
			return $stmt->errorInfo();
			
		}
	}

	/*=============================================
	CARGAR EJECUCION 
	=============================================*/
	static public function mdlCargarEjecucion($tabla,$campania){
		
		$conexion = Conexion::conectar(); 
		$stmt = $conexion->prepare("INSERT INTO $tabla(campania) VALUES (:campania)");
		$stmt->bindParam(":campania", $campania, PDO::PARAM_STR);

		if($stmt->execute()){
			
			return $conexion->lastInsertId();;	
			
		}else{
			
			$stmt = Conexion::conectar()->prepare("SELECT id FROM $tabla WHERE campania = :campania");
			$stmt->bindParam(":campania", $campania, PDO::PARAM_STR);
			$stmt->execute();
			$resp = $stmt->fetch();
			return $resp['id'];

		}
	}

	/*=============================================
	MOSTRAR COSTO
	=============================================*/
	static public function mdlMostrarCostos($tabla,$campania,$idPlanificacion){

		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN costocultivos ON $tabla.id = costocultivos.idPlanificacion WHERE $tabla.campania = '$campania' AND costocultivos.idPlanificacion = :idPlanificacion");
		
		$stmt->bindParam(":idPlanificacion", $idPlanificacion, PDO::PARAM_STR);
		
		$stmt -> execute();
		
		return $stmt -> fetchAll();


		$stmt = null;

	}

	/*=============================================
	CARGAR COSTO
	=============================================*/

	static public function mdlCargarCostos($tabla,$dataSql){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idPlanificacion,cultivo,costo) VALUES $dataSql");

		if($stmt->execute()){
			
			return "ok";	
			
		}else{
			return json_encode($stmt->errorInfo());			
		}
		

	}

	/*=============================================
	EDITAR COSTO
	=============================================*/

	static public function mdlEditarCosto($tabla,$item,$value,$item2,$value2,$item3,$value3,$costo){

		$tabla = 'costo'.$tabla;

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
		costo = :costo		
		WHERE $item = :$item AND $item2 = :$item2 AND $item3 = :$item3");
	
		$stmt->bindParam(":".$item, $value, PDO::PARAM_STR);
		$stmt->bindParam(":".$item2, $value2, PDO::PARAM_STR);
		$stmt->bindParam(":".$item3, $value3, PDO::PARAM_STR);
		$stmt->bindParam(":costo", $costo, PDO::PARAM_STR);

		if($stmt->execute()){
			
			return "ok";	
			
		}else{

			return $stmt->errorInfo();
			return 'error';
			
		}
		
		
		$stmt = null;
	

	}


	/*=============================================
	MOSTRAR DATA
	=============================================*/
	static public function mdlMostrarData($tabla, $item, $value, $item2, $value2, $item3, $value3){
		
		if($value3 != ''){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2 AND $item3 = :$item3 ");
			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $value2, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item3, $value3, PDO::PARAM_STR);
			
		}else if($value2 != ''){
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2");
			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $value2, PDO::PARAM_STR);			
			
		} else if($value != ''){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
			
		} else {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		}

		if($stmt -> execute()){
			
		};

		return $stmt -> fetchAll();

		$stmt = null;

	}

	/*=============================================
	CERRAR CAMPAÑA
	=============================================*/

	static public function mdlCerrarCampania($tabla,$item,$valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cerrada = 1 WHERE $item = :$item");
	
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

		if($stmt->execute()){
			
			return "ok";	
			
		}else{

			return $stmt->errorInfo();
			return 'error';
			
		}
		
		
		$stmt = null;
	

	}

	/*=============================================
	ELIMINAR ARCHIVO
	=============================================*/
	static public function mdlEliminarArchivo($tabla,$item,$value, $item2, $value2, $item3, $value3){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item AND $item2 = :$item2 AND $item3 = :$item3");
			
			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
			
		}else{
			
			$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item2 = :$item2 AND $item3 = :$item3");

		}
		
		$stmt -> bindParam(":".$item2, $value2, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item3, $value3, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{
			return $stmt->	errorInfo();
			return "error";	

		}


		$stmt = null;

	}

	/*=============================================
	ULTIMA PLANIFICACION CARGADA POR CAMPAÑA
	=============================================*/
	static public function mdlUltimaCarga($tabla,$campania){

		$stmt = Conexion::conectar()->prepare("SELECT MAX(tipo) as lastUpload FROM $tabla WHERE campania = :campania");
		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetch();
	}

	/*=============================================
	CARGAR PLANIFICACION
	=============================================*/
	static public function mdlCargarPlanificacion($tabla,$data){
		$conexion = Conexion::conectar();
		$stmt = $conexion->prepare("INSERT INTO $tabla(campania,tipo) VALUES(:campania,:tipo)");
		$stmt -> bindParam(":campania", $data['campania'], PDO::PARAM_STR);
		$stmt -> bindParam(":tipo", $data['tipo'], PDO::PARAM_STR);
		
		if($stmt->execute()){ 
			
			return $conexion->lastInsertId();
			
		}else{
			
			return $stmt->errorInfo();
			
		}
	
	}


	/*=============================================
	CULTIVOS
	=============================================*/
	static public function mdlCultivosUnicosPorPlanificacion($tabla,$idPlanificacion){

		$stmt = Conexion::conectar()->prepare("SELECT DISTINCT(cultivo) FROM $tabla WHERE idPlanificacion = :idPlanificacion");
		$stmt -> bindParam(":idPlanificacion", $idPlanificacion, PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetchAll();
	}


	static public function mdlMostrarCampanias($tabla, $idPlanificacion,$campos,$full){

		$where = (!is_null($idPlanificacion)) ? 'WHERE idPlanificacion = :idPlanificacion' : '';

		if($full){

		} else { 

			$stmt = Conexion::conectar()->prepare("SELECT $campos FROM $tabla $where");

		}

		if(!is_null($idPlanificacion)) $stmt -> bindParam(":idPlanificacion", $idPlanificacion, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetchAll();

	}

	static public function mdlMostrarCargasPorCampania($tabla, $campania){

		$stmt = Conexion::conectar()->prepare("SELECT tipo,created_at FROM $tabla WHERE campania = :campania ORDER BY created_at DESC");

		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetchAll();
	}

	static public function mdlMostrarDataCultivosPlanificacion($tabla, $idPlanificacion){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idPlanificacion = :idPlanificacion ORDER BY lote ASC");
		$stmt -> bindParam(":idPlanificacion", $idPlanificacion, PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetchAll();

	}

	static public function mdlGetCampaignId($tabla, $campania,$cargaPlanificacion){

		$stmt = Conexion::conectar()->prepare("SELECT id FROM $tabla WHERE tipo = :tipo AND campania = :campania");
		$stmt -> bindParam(":tipo", $cargaPlanificacion, PDO::PARAM_STR);
		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetch();

	}

	static public function mdlGetLotes($tabla, $campania){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE campania = :campania AND cargado = 0");

		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetchAll();

	}

	static public function mdlMostrarEjecucion($tabla, $campania){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*), id FROM $tabla WHERE campania = :campania");
		
		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetch();

	}

	static public function mdlMostrarDataEjecucion($tabla, $item,$valor,$item2,$valor2){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla e INNER JOIN ejecucionLabores el ON e.id = el.idEjecucion WHERE e.$item = :$item AND el.$item2 = :$item2");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		$stmt -> execute();
		
		return $stmt -> fetchAll();

	}

	/*=============================================
	CARGAR LOTES EJECUCION
	=============================================*/
	static public function mdlCargarLotesEjecucion($tabla,$data){

		$conexion = Conexion::conectar();
		$stmt = $conexion->prepare("INSERT INTO $tabla(campania,lote,cultivo,campo,etapa) VALUES $data");

		if($stmt->execute()){ 
			
			return 'ok';
			
		}else{
			
			return $stmt->errorInfo();
			
		}
	
	}

	/*=============================================
	VALIDAR LOTES EJECUCION
	=============================================*/
	static public function mdlValidarLotes($tabla,$campania,$lote,$campo,$etapa){

		$conexion = Conexion::conectar();
		$stmt = $conexion->prepare("UPDATE $tabla SET cargado = 1 WHERE campania = :campania AND REPLACE(TRIM(lote), ' ', '') = :lote AND campo = :campo AND etapa = :etapa");

		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);
		$stmt -> bindParam(":lote", $lote, PDO::PARAM_STR);
		$stmt -> bindParam(":campo", $campo, PDO::PARAM_STR);
		$stmt -> bindParam(":etapa", $etapa, PDO::PARAM_STR);

		if($stmt->execute()){ 
			
			return 'ok';
			
		}else{
			
			return $stmt->errorInfo();
			
		}
	
	}
	

}
