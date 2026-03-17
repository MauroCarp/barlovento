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

			if($full == 'distinct'){
				$stmt = Conexion::conectar()->prepare("SELECT DISTINCT(campania) FROM $tabla");
			}

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

	/*=============================================
	CARGAR PRODUCCION
	=============================================*/
	static public function mdlCargarProduccion($tabla,$campania){
		$conexion = Conexion::conectar(); 
		$stmt = $conexion->prepare("INSERT INTO $tabla(campania) VALUES (:campania)");
		$stmt->bindParam(":campania", $campania, PDO::PARAM_STR);
		if($stmt->execute()){
			return $conexion->lastInsertId();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT id FROM $tabla WHERE campania = :campania");
			$stmt->bindParam(":campania", $campania, PDO::PARAM_STR);
			$stmt->execute();
			$resp = $stmt->fetch();
			return $resp['id'];
		}
	}

	static public function mdlMostrarProduccion($tabla, $campania){
		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*), id FROM $tabla WHERE campania = :campania");
		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
	}

	static public function mdlObtenerProduccionPorCampania($tabla, $campania){
		$stmt = Conexion::conectar()->prepare("SELECT id,campania,lote,cultivo,campo,etapa,has,costo,rinde,flete FROM $tabla WHERE campania = :campania");
// return $stmt;
		$stmt -> bindParam(":campania", $campania, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}

	/*=============================================
	ELIMINAR REGISTRO DE PRODUCCION
	=============================================*/
	static public function mdlEliminarProduccion($tabla, $id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt -> bindParam(":id", $id, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return $stmt -> errorInfo();
		}
	}

	static public function mdlCargarLotesProduccion($tabla,$data){
		$conexion = Conexion::conectar();
		
		$stmt = $conexion->prepare("INSERT INTO $tabla(campania,lote,cultivo,campo,etapa,has,costo,rinde,flete) VALUES $data");

		if($stmt->execute()){ 
			return 'ok';
		}else{
			return $stmt->errorInfo();
		}
	}

	static public function mdlMostrarDataProduccion($tabla, $item,$valor,$item2,$valor2){
		if($valor2){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla p INNER JOIN produccionLotes pl ON p.id = pl.idProduccion WHERE p.$item = :$item AND pl.$item2 = :$item2");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT (SELECT SUM(pl2.cosecha) FROM $tabla p2 INNER JOIN produccionLotes pl2 ON p2.id = pl2.idProduccion WHERE p2.$item = :$item) AS totalCosecha, (SELECT AVG(pl3.rinde) FROM $tabla p3 INNER JOIN produccionLotes pl3 ON p3.id = pl3.idProduccion WHERE p3.$item = :$item) AS rindePromedio, (SELECT SUM(pl4.flete) FROM $tabla p4 INNER JOIN produccionLotes pl4 ON p4.id = pl4.idProduccion WHERE p4.$item = :$item) AS totalFlete");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
	}

	static public function mdlMostrarDataEjecucion($tabla, $item,$valor,$item2,$valor2){

		if($valor2){
			if($valor2 == 'cobertura'){
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla e INNER JOIN ejecucionLabores el ON e.id = el.idEjecucion WHERE e.$item = :$item AND el.$item2 = 'fina' AND el.cultivo != 'trigo' ");
				}else if($valor2 == 'fina'){
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla e INNER JOIN ejecucionLabores el ON e.id = el.idEjecucion WHERE e.$item = :$item AND el.$item2 = :$item2 AND el.cultivo = 'trigo' ");
				$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla e INNER JOIN ejecucionLabores el ON e.id = el.idEjecucion WHERE e.$item = :$item AND el.$item2 = :$item2");
				$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
			}
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT (SELECT SUM(has_unico) FROM ( SELECT el.lote, el.cultivo, MAX(el.has) AS has_unico FROM $tabla e INNER JOIN ejecucionLabores el ON e.id = el.idEjecucion WHERE e.$item = :$item GROUP BY el.lote, el.cultivo ) t) AS totalHas, (SELECT SUM(el2.costoLabor) + SUM(el2.costoInsumo) FROM $tabla e2 INNER JOIN ejecucionLabores el2 ON e2.id = el2.idEjecucion WHERE e2.$item = :$item) AS totalCosto");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		}

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


	static public function mdlEliminarCampania($tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla");
		$stmt -> execute();

		
		$stmt2 = Conexion::conectar()->prepare("DELETE FROM cultivosplanificacion");
		$stmt2 -> execute();

		$stmt3 = Conexion::conectar()->prepare("DELETE FROM ejecucionlabores");
		$stmt3 -> execute();

		$stmt4 = Conexion::conectar()->prepare("DELETE FROM ejecucionlotes");
		$stmt4 -> execute();

		$stmt5 = Conexion::conectar()->prepare("DELETE FROM costocultivos");
		$stmt5 -> execute();
		
		return 'ok';

	}

	static public function mdlConsultarEjecucion($tabla, $campo = '*', $where = ''){

		$stmt = Conexion::conectar()->prepare("SELECT $campo FROM $tabla $where");

		// return $stmt;
		$stmt -> execute();
		
		return $stmt -> fetchAll();

	}

}
