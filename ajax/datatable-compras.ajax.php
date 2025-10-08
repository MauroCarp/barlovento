<?php

// Establecer content-type para JSON y deshabilitar output buffering automático
header('Content-Type: application/json; charset=utf-8');

// Función para logging
function logError($message, $data = null) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    if ($data !== null) {
        $logMessage .= " | Data: " . print_r($data, true);
    }
    $logMessage .= "\n";
    
    // Determinar la ruta correcta para el log
    $logPath = "compras_debug.log";
    if (basename(dirname($_SERVER['SCRIPT_NAME'])) === 'ajax') {
        // Si se ejecuta desde la carpeta ajax
        $logPath = "compras_debug.log";
    } else {
        // Si se ejecuta desde la raíz
        $logPath = "ajax/compras_debug.log";
    }
    
    file_put_contents($logPath, $logMessage, FILE_APPEND | LOCK_EX);
}

// Determinar la ruta base correcta
$basePath = "";
if (basename(dirname($_SERVER['SCRIPT_NAME'])) === 'ajax') {
    // Si se ejecuta desde la carpeta ajax, usar rutas relativas hacia arriba
    $basePath = "../";
} else {
    // Si se ejecuta desde la raíz, usar rutas directas
    $basePath = "";
}

// Log inicial
logError("=== INICIO DE SOLICITUD DATATABLE COMPRAS ===");
logError("Ruta base detectada", ["basePath" => $basePath, "script" => $_SERVER['SCRIPT_NAME']]);

try {
    require_once $basePath . "controladores/compras.controlador.php";
    logError("Controlador compras cargado correctamente");
} catch (Exception $e) {
    logError("ERROR al cargar controlador compras", $e->getMessage());
    echo '{"error": "Error al cargar controlador compras"}';
    exit;
}

try {
    require_once $basePath . "modelos/compras.modelo.php";
    logError("Modelo compras cargado correctamente");
} catch (Exception $e) {
    logError("ERROR al cargar modelo compras", $e->getMessage());
    echo '{"error": "Error al cargar modelo compras"}';
    exit;
}

try {
    require_once $basePath . "controladores/datos.controlador.php";
    logError("Controlador datos cargado correctamente");
} catch (Exception $e) {
    logError("ERROR al cargar controlador datos", $e->getMessage());
    echo '{"error": "Error al cargar controlador datos"}';
    exit;
}

try {
    require_once $basePath . "modelos/datos.modelo.php";
    logError("Modelo datos cargado correctamente");
} catch (Exception $e) {
    logError("ERROR al cargar modelo datos", $e->getMessage());
    echo '{"error": "Error al cargar modelo datos"}';
    exit;
}

class TablaCompras{

 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 

	public function mostrarTablaCompras(){

		logError("Iniciando método mostrarTablaCompras");

		$item = NULL;
		$valor = NULL;
		$orden = 'fecha';
		
		logError("Parámetros preparados", ["item" => $item, "valor" => $valor, "orden" => $orden]);
		
		try {
			$compras = ControladorDatosCompras::ctrMostrardatos($item, $valor,$orden);
			logError("Datos obtenidos del controlador", ["cantidad_registros" => count($compras)]);
		} catch (Exception $e) {
			logError("ERROR al obtener datos del controlador", $e->getMessage());
			echo '{"error": "Error al obtener datos de compras"}';
			return;
		}

        if(count($compras) == 0){
			logError("No se encontraron datos de compras");
  			echo '{"data": []}';
		  	return;
  		}	
		
		logError("Iniciando construcción del JSON", ["total_registros" => count($compras)]);
		
		try {
  			$datosJson = '{
			  "data": [';

			  for($i = 0; $i < count($compras); $i++){

				logError("Procesando registro", ["indice" => $i, "registro" => $compras[$i]]);

				// Validar que existen los campos necesarios
				if (!isset($compras[$i]['fecha'])) {
					logError("ERROR: Campo 'fecha' no existe en el registro", ["indice" => $i]);
					throw new Exception("Campo 'fecha' faltante en registro $i");
				}
				
				if (!isset($compras[$i]['consignatario'])) {
					logError("ERROR: Campo 'consignatario' no existe en el registro", ["indice" => $i]);
					throw new Exception("Campo 'consignatario' faltante en registro $i");
				}
				
				if (!isset($compras[$i]['proveedor'])) {
					logError("ERROR: Campo 'proveedor' no existe en el registro", ["indice" => $i]);
					throw new Exception("Campo 'proveedor' faltante en registro $i");
				}

				$fechaSQL = $compras[$i]['fecha'];

				$fecha = strtotime($compras[$i]['fecha']);
				if ($fecha === false) {
					logError("ERROR: Fecha inválida", ["fecha_original" => $compras[$i]['fecha'], "indice" => $i]);
					throw new Exception("Fecha inválida en registro $i: " . $compras[$i]['fecha']);
				}

	            $fecha = date('d-m-Y',$fecha);

				$kgIng = isset($compras[$i]['kgIng']) ? number_format($compras[$i]['kgIng'],2,',','.')." Kg." : "0,00 Kg.";

				$precioKg = isset($compras[$i]["precioKg"]) ? "$ ".number_format($compras[$i]["precioKg"],2,',','.') : "$ 0,00";

				logError("Datos procesados para registro", [
					"indice" => $i,
					"fecha" => $fecha,
					"consignatario" => $compras[$i]["consignatario"],
					"proveedor" => $compras[$i]["proveedor"],
					"kgIng" => $kgIng,
					"precioKg" => $precioKg
				]);

			  	$datosJson .='[
				      "<span class=\'hide\'>'.$fechaSQL.'</span> '.$fecha.'",
				      "'.ltrim($compras[$i]["consignatario"]).'",
				      "'.ltrim($compras[$i]["proveedor"]).'",
				      "'.(isset($compras[$i]["tropa"]) ? $compras[$i]["tropa"] : '').'",
				      "'.(isset($compras[$i]["cantidad"]) ? $compras[$i]["cantidad"] : '').'",
				      "'.$kgIng.'",
				      "'.$precioKg.'"
				    ],';

			  }

			  $datosJson = substr($datosJson, 0, -1);

			 $datosJson .=   '] 

			 }';
			
			logError("JSON construido exitosamente", ["longitud" => strlen($datosJson)]);
			echo $datosJson;
			
		} catch (Exception $e) {
			logError("ERROR durante la construcción del JSON", $e->getMessage());
			echo '{"error": "Error al procesar los datos: ' . $e->getMessage() . '"}';
			return;
		}


	}


}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
try {
	logError("Creando instancia de TablaCompras");
	$activarCompras = new TablaCompras();
	logError("Ejecutando mostrarTablaCompras");
	$activarCompras -> mostrarTablaCompras();
	logError("=== FIN DE SOLICITUD DATATABLE COMPRAS ===");
} catch (Exception $e) {
	logError("ERROR FATAL al ejecutar TablaCompras", $e->getMessage());
	echo '{"error": "Error fatal: ' . $e->getMessage() . '"}';
}

