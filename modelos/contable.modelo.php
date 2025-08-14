<?php

require_once "conexion.php";

class ModeloContable{
	
	/*=============================================
	CARGAR ARCHIVO
	=============================================*/
	static public function mdlCargarArchivo($tabla,$data){
				
		if($data['planilla'] == 'paihuen'){
			
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(archivo,periodo,ganancias,perdidas,ventasAgricultura,activos,inmobiliario,comuna) VALUES(:archivo,:periodo,:ganancias,:perdidas,:ventasAgricultura,:activos,:inmobiliario,:comuna)");
			
			$stmt -> bindParam(":archivo", $data['archivo'], PDO::PARAM_STR);
			$stmt -> bindParam(":periodo", $data['periodo'], PDO::PARAM_STR);
			$stmt -> bindParam(":ganancias", $data['ganancias'], PDO::PARAM_STR);
			$stmt -> bindParam(":perdidas", $data['perdidas'], PDO::PARAM_STR);
			$stmt -> bindParam(":ventasAgricultura", $data['ventaAgricultura'], PDO::PARAM_STR);
			$stmt -> bindParam(":activos", $data['activos'], PDO::PARAM_STR);
			$stmt -> bindParam(":inmobiliario", $data['inmobiliario'], PDO::PARAM_STR);
			$stmt -> bindParam(":comuna", $data['comuna'], PDO::PARAM_STR);
		}else{
			
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(
			archivo,
			libro,
			periodo,
			activos,
			activoCorriente,
			ganancias,
			perdidas,
			perdidasDirectas,
			agricultura,
			ganaderia,
			resto,
			prestamos,
			tarjetas,
			mutuales,
			proveedores,
			seguros,
			deudaBancaria,
			deudaTotal,
			bienesDeCambio,
			cajaBancos,
			pasivoCorriente,
			pasivoTotal,
			sld,
			saldoTecnico,
			patrimonioNeto,
			ingresoBrutoMensual,
			cargasSocialesReales,
			inmobiliario,
			sueldos,
			honorarios,
			sgr,
			cerealPL,
			interesesPagados,
			vaquillonasNovillos,
			carneSubproductos,
			ganaderiaExportacion,
			produccionHacienda,
			directas,
			activosBiologicosGan,
			productosAgropecuarios,
			bienesUPP,
			buEstructura,
			buMoviles,
			buDiversos,
			buReproductores,
			buGastosEstructura,
			activoDisponibilidades,
			activoInversiones,
			activoMonedaExtranjera,
			activoCreditos,
			activoNoCorriente,
			activoNCBienesDeUso,
			activoNCOtrosCreditos,
            patrimonioNetoCapital,
            patrimonioNetoReservas,
            patrimonioNetoResultadosAcumulados,
            patrimonioNetoResultadosAcumulados2,
            patrimonioNetoResultadoEjercicio,
			perdidasIndirectas,
			perdidasFinancieras,
			perdidasImpuestos,
			gananciasFinancieras,
			precioDolar
			) VALUES(
				:archivo,
			:libro,
			:periodo,
			:activos,
			:activoCorriente,
			:ganancias,
			:perdidas,
			:perdidasDirectas,
			:agricultura,
			:ganaderia,
			:resto,
			:prestamos,
			:tarjetas,
			:mutuales,
			:proveedores,
			:seguros,
			:deudaBancaria,
			:deudaTotal,
			:bienesDeCambio,
			:cajaBancos,
			:pasivoCorriente,
			:pasivoTotal,
			:sld,
			:saldoTecnico,
			:patrimonioNeto,
			:ingresoBrutoMensual,
			:cargasSocialesReales,
			:inmobiliario,
			:sueldos,
			:honorarios,
			:sgr,
			:cerealPL,
			:interesesPagados,
			:vaquillonasNovillos,
			:carneSubproductos,
			:ganaderiaExportacion,
			:produccionHacienda,
			:directas,
			:activosBiologicosGan,
			:productosAgropecuarios,
			:bienesUPP,
			:buEstructura,
			:buMoviles,
			:buDiversos,
			:buReproductores,
			:buGastosEstructura,
			:activoDisponibilidades,
			:activoInversiones,
			:activoMonedaExtranjera,
			:activoCreditos,
			:activoNoCorriente,
			:activoNCBienesDeUso,
			:activoNCOtrosCreditos,
        	:patrimonioNetoCapital,
        	:patrimonioNetoReservas,
        	:patrimonioNetoResultadosAcumulados,
        	:patrimonioNetoResultadosAcumulados2,
        	:patrimonioNetoResultadoEjercicio,
			:perdidasIndirectas,
			:perdidasFinancieras,
			:perdidasImpuestos,
			:gananciasFinancieras,
			:precioDolar
			)");
			
			$stmt -> bindParam(":archivo", $data['archivo'], PDO::PARAM_STR);
			$stmt -> bindParam(":libro", $data['libro'], PDO::PARAM_STR);
			$stmt -> bindParam(":ganancias", $data['ganancias'], PDO::PARAM_STR);
			$stmt -> bindParam(":perdidas", $data['perdidas'], PDO::PARAM_STR);
			$stmt -> bindParam(":perdidasDirectas", $data['perdidasDirectas'], PDO::PARAM_STR);
			$stmt -> bindParam(":periodo", $data['periodo'], PDO::PARAM_STR);
			$stmt -> bindParam(":activos", $data['activos'], PDO::PARAM_STR);
			$stmt -> bindParam(":activoCorriente", $data['activoCorriente'], PDO::PARAM_STR);
			$stmt -> bindParam(":agricultura", $data['agricultura'], PDO::PARAM_STR);
			$stmt -> bindParam(":ganaderia", $data['ganaderia'], PDO::PARAM_STR);
			$stmt -> bindParam(":resto", $data['resto'], PDO::PARAM_STR);
			$stmt -> bindParam(":prestamos", $data['prestamos'], PDO::PARAM_STR);
			$stmt -> bindParam(":tarjetas", $data['tarjetas'], PDO::PARAM_STR);
			$stmt -> bindParam(":mutuales", $data['mutuales'], PDO::PARAM_STR);
			$stmt -> bindParam(":proveedores", $data['proveedores'], PDO::PARAM_STR);
			$stmt -> bindParam(":seguros", $data['seguros'], PDO::PARAM_STR);
			$stmt -> bindParam(":deudaBancaria", $data['deudaBancaria'], PDO::PARAM_STR);
			$stmt -> bindParam(":deudaTotal", $data['deudaTotal'], PDO::PARAM_STR);
			$stmt -> bindParam(":bienesDeCambio", $data['bienesDeCambio'], PDO::PARAM_STR);
			$stmt -> bindParam(":cajaBancos", $data['cajaBancos'], PDO::PARAM_STR);
			$stmt -> bindParam(":pasivoCorriente", $data['pasivoCorriente'], PDO::PARAM_STR);
			$stmt -> bindParam(":pasivoTotal", $data['pasivoTotal'], PDO::PARAM_STR);
			$stmt -> bindParam(":sld", $data['sld'], PDO::PARAM_STR);
			$stmt -> bindParam(":saldoTecnico", $data['saldoTecnico'], PDO::PARAM_STR);
			$stmt -> bindParam(":patrimonioNeto", $data['patrimonioNeto'], PDO::PARAM_STR);
			$stmt -> bindParam(":ingresoBrutoMensual", $data['ingresoBrutoMensual'], PDO::PARAM_STR);
			$stmt -> bindParam(":cargasSocialesReales", $data['cargasSocialesReales'], PDO::PARAM_STR);
			$stmt -> bindParam(":inmobiliario", $data['inmobiliario'], PDO::PARAM_STR);
			$stmt -> bindParam(":sueldos", $data['sueldos'], PDO::PARAM_STR);
			$stmt -> bindParam(":honorarios", $data['honorarios'], PDO::PARAM_STR);
			$stmt -> bindParam(":sgr", $data['sgr'], PDO::PARAM_STR);
			$stmt -> bindParam(":cerealPL", $data['cerealPL'], PDO::PARAM_STR);
			$stmt -> bindParam(":interesesPagados", $data['interesesPagados'], PDO::PARAM_STR);
			$stmt -> bindParam(":vaquillonasNovillos", $data['vaquillonasNovillos'], PDO::PARAM_STR);
			$stmt -> bindParam(":carneSubproductos", $data['carneSubproductos'], PDO::PARAM_STR);
			$stmt -> bindParam(":ganaderiaExportacion", $data['exportacion'], PDO::PARAM_STR);
			$stmt -> bindParam(":produccionHacienda", $data['produccionHacienda'], PDO::PARAM_STR);
			$stmt -> bindParam(":activosBiologicosGan", $data['activosBiologicosGan'], PDO::PARAM_STR);
			$stmt -> bindParam(":productosAgropecuarios", $data['productosAgropecuarios'], PDO::PARAM_STR);
			$stmt -> bindParam(":bienesUPP", $data['bienesUPP'], PDO::PARAM_STR);
			$stmt -> bindParam(":buEstructura", $data['buEstructura'], PDO::PARAM_STR);
			$stmt -> bindParam(":buMoviles", $data['buMoviles'], PDO::PARAM_STR);
			$stmt -> bindParam(":buDiversos", $data['buDiversos'], PDO::PARAM_STR);
			$stmt -> bindParam(":buReproductores", $data['buReproductores'], PDO::PARAM_STR);
			$stmt -> bindParam(":buGastosEstructura", $data['buGastosEstructura'], PDO::PARAM_STR);
			$stmt -> bindParam(":directas", $data['directas'], PDO::PARAM_STR);

			$stmt -> bindParam(":activoDisponibilidades", $data['activoDisponibilidades'], PDO::PARAM_STR);
			$stmt -> bindParam(":activoInversiones", $data['activoInversiones'], PDO::PARAM_STR);
			$stmt -> bindParam(":activoMonedaExtranjera", $data['activoMonedaExtranjera'], PDO::PARAM_STR);
			$stmt -> bindParam(":activoCreditos", $data['activoCreditos'], PDO::PARAM_STR);
			$stmt -> bindParam(":activoNoCorriente", $data['activoNoCorriente'], PDO::PARAM_STR);
			$stmt -> bindParam(":activoNCBienesDeUso", $data['activoNCBienesDeUso'], PDO::PARAM_STR);
			$stmt -> bindParam(":activoNCOtrosCreditos", $data['activoNCOtrosCreditos'], PDO::PARAM_STR);
            $stmt -> bindParam(":patrimonioNetoCapital", $data['patrimonioNetoCapital'], PDO::PARAM_STR);
            $stmt -> bindParam(":patrimonioNetoReservas", $data['patrimonioNetoReservas'], PDO::PARAM_STR);
            $stmt -> bindParam(":patrimonioNetoResultadosAcumulados", $data['patrimonioNetoResultadosAcumulados'], PDO::PARAM_STR);
            $stmt -> bindParam(":patrimonioNetoResultadosAcumulados2", $data['patrimonioNetoResultadosAcumulados2'], PDO::PARAM_STR);
            $stmt -> bindParam(":patrimonioNetoResultadoEjercicio", $data['patrimonioNetoResultadoEjercicio'], PDO::PARAM_STR);
			$stmt -> bindParam(":perdidasIndirectas", $data['perdidasIndirectas'], PDO::PARAM_STR);
			$stmt -> bindParam(":perdidasFinancieras", $data['perdidasFinancieras'], PDO::PARAM_STR);
			$stmt -> bindParam(":perdidasImpuestos", $data['perdidasImpuestos'], PDO::PARAM_STR);
			$stmt -> bindParam(":gananciasFinancieras", $data['gananciasFinancieras'], PDO::PARAM_STR);

			$stmt -> bindParam(":precioDolar", $data['precioDolar'], PDO::PARAM_STR);
			
		}

		if($stmt->execute()){
			
			return "ok";	
			
		}else{

			return $stmt->errorInfo();

		}
	
	}


	/*=============================================
	MOSTRAR DATOS
	=============================================*/
	
	static public function mdlMostrarDatos($tabla,$item,$valor,$item2,$valor2){

		if(is_array($valor2)){


			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND MONTH($item2) = :mes AND YEAR($item2) = :anio");
			
			$stmt -> bindParam(":".$item,$valor, PDO::PARAM_STR);
			
			$mes = $valor2[0];
			$anio = $valor2[1];

			$stmt -> bindParam(":mes", $mes, PDO::PARAM_STR);
			$stmt -> bindParam(":anio", $anio, PDO::PARAM_STR);

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		}	

		$stmt -> execute();

		return $stmt -> fetch();
		
	}


	    
    /*=============================================
    ULTIMO PERIODO
    =============================================*/
    
    static public function mdlUltimoPeriodo($libro,$tabla){
        
		$stmt = Conexion::conectar()->prepare("SELECT MAX(periodo) FROM $tabla");
		
		if($tabla != 'contablePaihuen'){
			
			$stmt = Conexion::conectar()->prepare("SELECT MAX(periodo) FROM $tabla WHERE libro = :$libro");

			$stmt -> bindParam(":".$libro, $libro, PDO::PARAM_STR);

		}
			
		$stmt -> execute();
		
		return $stmt -> fetch();
        
    }

    static public function mdlSetearDolar($tabla,$libro,$periodo,$promedioDolar){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET precioDolar = :precioDolar  WHERE periodo = :periodo AND libro = :libro");

		$stmt -> bindParam(":libro", $libro, PDO::PARAM_STR);
		$stmt -> bindParam(":precioDolar", $promedioDolar, PDO::PARAM_STR);
		$stmt -> bindParam(":periodo", $periodo, PDO::PARAM_STR);
	
		if($stmt->execute()){
			
			return "ok";	
			
		}else{
			
			return $stmt->errorInfo();

		}
	
	}

}

