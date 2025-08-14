<?php

require_once "conexion.php";

class ModeloPastoreo{

	/*=============================================
	MOSTRAR Datos
	=============================================*/

	static public function mdlMostrarRegistros($tabla,$item,$valor){
			
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY ingresoPlanificado ASC");
        $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
        // $stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();
		
	}
	
    static public function mdlCargarRegistros($tabla,$data){
			
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(celula,lote,parcela,ingresoPlanificado,salidaPlanificado,registroDate) VALUES $data");

		if($stmt->execute()){
            
            return "ok";	
            
        }else{
            
            return $stmt->errorInfo();
            
        }
    }
    
	static public function mdlEditarRegistro($tabla,$data,$item,$valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ingresoReal = :ingresoReal, salidaReal = :salidaReal WHERE $item = :$item");
            
        $stmt->bindParam(":ingresoReal", $data['ingresoReal'], PDO::PARAM_STR);
        $stmt->bindParam(":salidaReal", $data['salidaReal'], PDO::PARAM_STR);
        $stmt->bindParam(":$item", $valor, PDO::PARAM_STR);

        if($stmt->execute()){
            
            return "ok";	
            
        }else{
            
            return $stmt->errorInfo();
            
        }
    }

	static public function mdlEliminarRegistro($tabla,$item,$valor){
	
    
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{
			return $stmt->	errorInfo();
			return "error";	

		}

		$stmt = null;
    }
}