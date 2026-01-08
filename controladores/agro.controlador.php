<?php
error_reporting(E_ERROR | E_PARSE);

/**
 * Limpia y normaliza strings para prevenir problemas de encoding en BD
 * @param string $text - Texto a limpiar
 * @return string - Texto limpio y normalizado
 */
function limpiarTexto($text) {
    // Trim y convertir a minúsculas (UTF-8 safe)
    $text = mb_strtolower(trim($text), 'UTF-8');
    
    // Remover espacios
    $text = str_replace(' ', '', $text);
    
    // Remover caracteres especiales comunes que causan problemas
    $caracteresProblematicos = ['°', '°', '˚', 'º', '®', '™', '©'];
    $text = str_replace($caracteresProblematicos, '', $text);
    
    // Opcional: Normalizar caracteres acentuados si es necesario
    // $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    
    return $text;
}

function tipoEstInv($cultivo){

    switch ($cultivo) {
        case 'trigo':
        case 'carinata':
        case 'vicia':
        case 'triticale':
        case 'vicia-triticale':
        case 'triticale-vicia':
        case 'avena':
        case 'sevadilla':
        case 'camelina':
            $tipo = 'invernal';
            break;

        case 'maiz1':
        case 'maiz2':
        case 'soja1':
        case 'soja2':
            $tipo = 'estival';
            break;
    }

    return $tipo;

}

function tipoCultivo($cultivo){

    switch ($cultivo) {
        case 'trigo':
        case 'camelina':
        case 'carinata':
            $tipo = 'fina';
            break;

        case 'maiz1':
        case 'maiz2':
        case 'soja1':
        case 'soja2':
        case 'sorgo':
            $tipo = 'gruesa';
            break;

        case 'triticale':
        case 'sevadilla':
        case 'vicia':
        case 'avena':
            $tipo = 'cobertura';
            break;
    }

    return $tipo;

}

function getEtapa($etapa){

    switch ($etapa) {
        case 'Al 31 de Mayo':
            $value = 1;
            break;

        case 'Al 31 de Agosto':
            $value = 2;
            break;

        case 'Al 31 de Diciembre':
            $value = 3;
            break;
        
        default:
            $value = 1;
            break;
    }
    return $value;
}

class ControladorAgro{

	/*=============================================
	CARGAR ARCHIVO
	=============================================*/

	static public function ctrCargarArchivo(){

        
        require_once('extensiones/excel/php-excel-reader/excel_reader2.php');
        require_once('extensiones/excel/SpreadsheetReader.php');

        if(isset($_POST['btnCargar'])){
            
            $error = false;
            
            $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            
        // CARGA PLANIFIACION
            
            if(in_array($_FILES["nuevosDatosPlanificacion"]["type"],$allowedFileType)){
                
                $ruta = "carga/" . $_FILES['nuevosDatosPlanificacion']['name'];
                
                move_uploaded_file($_FILES['nuevosDatosPlanificacion']['tmp_name'], $ruta);
                                                        
                $rowNumber = 0;

                $data = array();
                $Reader = new SpreadsheetReader($ruta);
                $sheetCount = count($Reader->sheets());

                $tabla = 'planificaciones';
                $campania = $_POST['campania1'] . '/' . $_POST['campania2'];
                $resultado = ModeloAgro::mdlUltimaCarga($tabla,$campania);
                $lastUpload = (is_null($resultado['lastUpload'])) ? -1 : $resultado['lastUpload'];

                $dataPlanificacion = array('tipo'=>$lastUpload + 1,'campania'=>$campania);
                $cargaPlanificacion = ModeloAgro::mdlCargarPlanificacion($tabla,$dataPlanificacion);

                $arrLotesEjecucion = array();

                for($i=0;$i<$sheetCount;$i++){
                    $Reader->ChangeSheet($i);

                    foreach ($Reader as $Row){

                        // Limpiar y normalizar el cultivo
                        $cultivo = limpiarTexto($Row[1]);

                        if(trim($Row[1]) == 'EL PICHI') $campo = 'pichi';
                        if(trim($Row[1]) == 'LA BETY') $campo = 'bety';

                        if($rowNumber == 0) $rowValida = false;

                        if($rowValida && $cultivo != 'cerealesyoleaginosas' && $cultivo != 'elpichi' && $cultivo != 'labety' && $cultivo != ''){

                            $data[] = array('cultivo'=>$cultivo,
                                                 'tipo'=>tipoCultivo($cultivo),
                                                 'tipoEstInv'=>tipoEstInv($cultivo),
                                                 'lote'=>$Row[2],
                                                 'has'=>$Row[5],
                                                 'idPlanificacion'=>$cargaPlanificacion,
                                                 'campo'=> $campo
                            );

                            $arrLotesEjecucion[] = array('campania'=>"'" . $campania . "'",
                                                         'lote'=>"'" . $Row[2] . "'",
                                                         'cultivo'=>"'" . $cultivo . "'",
                                                         'campo'=>"'" . $campo . "'",
                                                         'etapa'=>"'" . tipoCultivo($cultivo) . "'");

                        }

                        if($rowNumber == 3)
                            $rowValida = true;

                        $rowNumber++;

                    }
                        
                }

                $campos = implode(',',array_keys($data[0]));
                $dataSql = array();

                foreach ($data as $value) {

                    $tmp = array();
        
                    foreach ($value as $val) {
                        $tmp[] = (is_numeric($val)) ? $val : "'" . $val . "'";
                    }
        
                    $dataSql[] = "(" . implode(',',$tmp) . ")";
                }
                
                foreach ($arrLotesEjecucion as $key => $value) {

                    $arrLotesEjecucion[$key] = "(" . implode(',',$value) . ")";

                }

                $arrLotesEjecucion = implode(',',$arrLotesEjecucion);

                $tabla = 'ejecucionLotes';
                $cargarLotesEjecucion = ModeloAgro::mdlCargarLotesEjecucion($tabla,$arrLotesEjecucion);

                $tabla = 'cultivosplanificacion';

                $respuesta = ModeloAgro::mdlCargarArchivo($tabla,$campos,implode(',',$dataSql));

                if($respuesta == 'ok'){
                    echo "<script> window.location = 'index.php?ruta=agro/agro&idPlanificacion=" . $cargaPlanificacion . "&accion=costosCultivos'</script>";
                }else{
                    
                    echo'<script>

                    swal({
                            type: "error",
                            title: "Hubo un error al cargar el excel.Informar",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                            }).then(function(result) {
                                    if (result.value) {
                                        localStorage.removeItem("campaniaAgro")
                                        window.location = "index.php?ruta=agro/agro"

                                    }
                                })

                    </script>';
                die();
                }

            }
        
        }

	}


    /*=============================================
	CARGAR EJECUCION
	=============================================*/

	static public function ctrCargarEjecucion(){

        
        require_once('extensiones/excel/php-excel-reader/excel_reader2.php');
        require_once('extensiones/excel/SpreadsheetReader.php');

        if(isset($_POST['btnCargarEjecucion'])){
            
            $error = false;
            
            $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            $etapa = $_POST['etapaEjecucion'];

            
            // CARGA Ejecucion
            $arrLotesCargados = array();

            $campania = $_POST['campania'];

            foreach ($_FILES as $key => $file) {
                
                if($file['size'] > 0){

                    if(in_array($file["type"],$allowedFileType))
                        
                        $ruta = "carga/" . $file['name'];
                        
                        move_uploaded_file($file['tmp_name'], $ruta);
                                                                
                        $rowNumber = 0;

                        $data = array();
                        
                        $Reader = new SpreadsheetReader($ruta);	
                        
                        $sheetCount = count($Reader->sheets());
                
                        $tabla = 'ejecucion';
                     
                        // Validar si la campaña ya está cargada en la tabla
                        $existeEjecucion = ModeloAgro::mdlMostrarEjecucion($tabla, $campania);

                        if (!empty($existeEjecucion) && $existeEjecucion[0] == 1) {
                            $idEjecucion = $existeEjecucion[1];
                        } else {
                            $idEjecucion = ModeloAgro::mdlCargarEjecucion($tabla, $campania);
                        }

                        $data = array();

                        $explode = explode('_',$key);
                        $cultivo = $explode[1];
                        $lote = $explode[0];

                        $arrLotesCargados[] = array('lote'=>$lote,'campo'=>$_POST[$key.'campo']);
                    
                        for($i=0;$i<$sheetCount;$i++){
                
                            $Reader->ChangeSheet($i);

                            foreach ($Reader as $Row){     
                                
                                if($rowNumber == 0)
                                    $rowValida = false;

                                if($rowValida){

                                    if($Row[0] != 'Totales:' && trim($Row[0]) != ''){

                                        $arr = array('idEjecucion'=>$idEjecucion,
                                                     'lote'=>"'" . $lote . "'",
                                                     'labor'=>"'" . $Row[0] . "'",
                                                     'cultivo'=>"'" . $cultivo . "'",
                                                     'has'=>"'" . number_format(str_replace(',','',$Row[1]),0,'.','') . "'",
                                                     'costoLabor'=>"'" . number_format(str_replace(',','',$Row[2]),2,'.','') . "'",
                                                     'costoInsumo'=>"'" . number_format(str_replace(',','',$Row[4]),2,'.','') . "'",
                                                     'campo'=>"'" . $_POST[$key.'campo'] . "'",
                                                     'etapa'=>"'" . $etapa . "'"
                                            );


                                        $data[] = "(" . implode(',',$arr) . ")";

                                    }

                                }

                                if ($etapa == 'fina' && $rowNumber == 8) {
                                    $rowValida = true;
                                } elseif ($etapa == 'gruesa' && $rowNumber == 5) {
                                    $rowValida = true;
                                }


                                $rowNumber++;

                            }
                                
                        }
                    
                        $tabla = 'ejecucionLabores';

                        $respuesta = ModeloAgro::mdlCargarLabores($tabla,implode(',',$data));
                        
                        if($respuesta != 'ok'){
                          
                            echo'<script>

                            swal({
                                    type: "error",
                                    title: "Hubo un error al cargar los Lotes.Informar",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                    }).then(function(result) {
                                            if (result.value) {
                                                window.location = "index.php?ruta=agro/agro"

                                            }
                                        })

                            </script>';
                        die();
                        }

                    

                }

            }

            $tabla = 'ejecucionLotes';

            
            foreach ($arrLotesCargados as $key => $lote) {
                
                $validarLotes = ModeloAgro::mdlValidarLotes($tabla,$campania,$lote['lote'],$lote['campo'],$etapa);
            }
            
            echo'<script>

                swal({
                    type: "success",
                    title: "Lotes cargados correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then(function(result) {
                            if (result.value) {

                                window.location = "index.php?ruta=agro/agro&campania=' . $campania . '"
                            }
                        })

            </script>';
            die;            
        
        }

	}

	static public function ctrCargarEjecucionRindes(){

        require_once('extensiones/excel/php-excel-reader/excel_reader2.php');
        require_once('extensiones/excel/SpreadsheetReader.php');

        if(isset($_POST['btnCargarEjecucionRindes'])){

            $error = false;
            
            $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            $etapa = $_POST['etapaEjecucion'];

            
            // CARGA Ejecucion
            $arrLotesCargados = array();

            $campania = $_POST['campania'];

            foreach ($_FILES as $key => $file) {
                
                var_dump($_FILES);
                die;
                if($file['size'] > 0){

                    if(in_array($file["type"],$allowedFileType)){
                        
                        $ruta = "carga/" . $file['name'];
                        
                        move_uploaded_file($file['tmp_name'], $ruta);
                                                                
                        $rowNumber = 0;

                        $data = array();
                        
                        $Reader = new SpreadsheetReader($ruta);	
                        
                        $sheetCount = count($Reader->sheets());
                
                        $tabla = 'ejecucionrindes';
                     
                        $data = array();
                        
                        $idEjecucion = $_POST['idEjecucionRindes'];

                        $cultivo = str_replace('rindes_',$file['name']);

                        for($i=0;$i<$sheetCount;$i++){
                
                            $Reader->ChangeSheet($i);

                            foreach ($Reader as $Row){     
                                
                                if($Row[0] == 'Campo EL PICHI:' && $rowNumber == 6)
                                    $campo = 'elpichi';
                                
                                if($Row[0] == 'Campo LA BETY:')
                                    $campo = 'labety';

                                if($rowNumber > 7 && $Row[2] != '')
                                    $rowValida = true;

                                    if($rowValida){

                                        $arr = array('idEjecucion'=>$idEjecucion,
                                                    'lote'=>"'" . $Row[2] . "'",
                                                    'rinde'=> $Row[15],
                                                    'cultivo'=>"'" . $cultivo . "'",
                                                    'has'=>"'" . number_format(str_replace(',','',$Row[1]),0,'.','') . "'",
                                                    'costoLabor'=>"'" . number_format(str_replace(',','',$Row[2]),2,'.','') . "'",
                                                    'costoInsumo'=>"'" . number_format(str_replace(',','',$Row[4]),2,'.','') . "'",
                                                    'campo'=>"'" . $_POST[$key.'campo'] . "'",
                                                    'etapa'=>"'" . $etapa . "'"
                                        );


                                        $data[] = "(" . implode(',',$arr) . ")";

                                    }

                            }

                            $rowNumber++;
                                
                        }
                    
                         $respuesta = ModeloAgro::mdlCargarLabores($tabla,implode(',',$data));
                        
                        if($respuesta != 'ok'){
                           echo'<script>

                            swal({
                                    type: "error",
                                    title: "Hubo un error al cargar los Lotes.Informar",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                    }).then(function(result) {
                                            if (result.value) {
                                                window.location = "index.php?ruta=agro/agro"

                                            }
                                        })

                            </script>';
                            die();
                        }

                    

                    }

                }

                echo'<script>

                swal({
                    type: "success",
                    title: "Lotes cargados correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then(function(result) {
                            if (result.value) {

                                window.location = "index.php?ruta=agro/agro&campania=' . $campania . '"
                            }
                        })

                </script>';
                die; 
            }
            
        }  

    }



    /*=============================================
	CARGAR COSTOS
	=============================================*/

	static public function ctrCargarCostos($tabla,$dataSql){

        return $respuesta = ModeloAgro::mdlCargarCostos($tabla,$dataSql);
            
	}

    /*=============================================
	VER COSTOS
	=============================================*/

	static public function ctrMostrarCostos($tabla,$campania,$idPlanificacion){

        $costos = ModeloAgro::mdlMostrarCostos($tabla,$campania,$idPlanificacion);

        $dataCostos = array();

		foreach ($costos as $costo) {
			$dataCostos[$costo['cultivo']] = $costo['costo'];
 		}

        return $dataCostos;

	}

    /*=============================================
	VER DATA
	=============================================*/
    
	static public function ctrMostrarDataPlanificacion($tabla, $item, $valor, $item2 = null, $valor2 = null, $item3 = null, $valor3 = null){

        return $respuesta = ModeloAgro::mdlMostrarData($tabla, $item, $valor, $item2, $valor2, $item3, $valor3);

	}

    static public function ctrMostrarDataEjecucion($tabla, $item, $valor,$item2, $valor2){

        return $respuesta = ModeloAgro::mdlMostrarDataEjecucion($tabla, $item, $valor,$item2,$valor2);

	}

    /*=============================================
	ELIMINAR ARCHIVO
	=============================================*/
    
	static public function ctrEliminarArchivo(){
        
        if(isset($_GET['campo']) OR isset($_GET['seccion'])){

            if(isset($_GET['campo'])){
    
                $tabla = $_GET['tabla'];
                
                $item = 'campo';
                
                $value = strtoupper($_GET['campo']);
                
                $item2 = 'campania1';
                
                $value2 = $_GET['campania1'];
                
                $item3 = 'campania2';
                
                $value3 = $_GET['campania2'];
                
                $respuesta = ModeloAgro::mdlEliminarArchivo($tabla,$item,$value, $item2, $value2, $item3, $value3);
                
            }
            
            if(isset($_GET['seccion'])){
    
                $tabla = $_GET['seccion'];
                
                $item = null;
                
                $value = null;
                
                $item2 = 'campania1';
                
                $value2 = $_GET['campania1'];
                
                $item3 = 'campania2';
                
                $value3 = $_GET['campania2'];
                
                $respuesta = ModeloAgro::mdlEliminarArchivo($tabla,$item,$value, $item2, $value2, $item3, $value3);
                
            }

            if($respuesta == "ok"){

                echo'<script>

                swal({
                        type: "success",
                        title: "El archivo ha sido borrado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        }).then(function(result) {
                                if (result.value) {

                                window.location = "index.php?ruta=agro/agro";

                                }
                            })

                </script>';

            }else{

                echo'<script>

                swal({
                        type: "error",
                        title: "El archivo no ha sido borrado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        }).then(function(result) {
                                if (result.value) {

                                window.location = "index.php?ruta=agro/agro";

                                }
                            })

                </script>';
            
            }	

        }
    }

    
    /*=============================================
	ELIMINAR ARCHIVO
	=============================================*/
    
	static public function ctrCultivosUnicosPorPlanificacion($idPlanificacion){
        
        $tabla = 'cultivosplanificacion';

        $resultado = ModeloAgro::mdlCultivosUnicosPorPlanificacion($tabla,$idPlanificacion);

        $cultivos = array();

        foreach ($resultado as $key => $value) {
            $cultivos[] = $value['cultivo'];
        }

        return $cultivos;

    }

    static public function ctrMostrarCampanias($idPlanificacion = null, $campos = '*' ,$full = false){

        $tabla = 'planificaciones';

        return ModeloAgro::mdlMostrarCampanias($tabla,$idPlanificacion,$campos,$full);

    }

    static public function ctrMostrarCargasPorCampania($campania){

        $tabla = 'planificaciones';

        return ModeloAgro::mdlMostrarCargasPorCampania($tabla,$campania);

    }

    static public function ctrMostrarDataCultivosPlanificacion($idPlanificacion){

        $tabla = 'cultivosplanificacion';

        return ModeloAgro::mdlMostrarDataCultivosPlanificacion($tabla,$idPlanificacion);

    }

    static public function ctrGetCampaignId($campania,$cargaPlanificacion){

        $tabla = 'planificaciones';

		$idPlanificacion = ModeloAgro::mdlGetCampaignId($tabla,$campania,$cargaPlanificacion);

        return $idPlanificacion['id'];

    }

    static public function ctrGetLotes($campania){

        $tabla = 'ejecucionLotes';

		$lotes = ModeloAgro::mdlGetLotes($tabla,$campania);
        
        return $lotes;

    }

    static public function ctrMostrarEjecucion($campania){
        
        $tabla = 'ejecucion';
        
        $ejecucionValido = ModeloAgro::mdlMostrarEjecucion($tabla,$campania);

        return $ejecucionValido[0];
    
    }

    /*=============================================
	ESTADISTICAS (Planificación vs Ejecución)
	=============================================*/
    static public function ctrObtenerEstadisticas($campania, $cargaPlanificacion = null){

        $tablaPlan = 'planificaciones';
        if(is_null($cargaPlanificacion)){
            $ultima = ModeloAgro::mdlUltimaCarga($tablaPlan,$campania);
            $cargaPlanificacion = (is_null($ultima['lastUpload'])) ? 1 : $ultima['lastUpload'];
        }

        $idPlanificacion = ModeloAgro::mdlGetCampaignId($tablaPlan,$campania,$cargaPlanificacion)['id'];

        $cultivosPlan = ModeloAgro::mdlMostrarDataCultivosPlanificacion('cultivosplanificacion',$idPlanificacion);
        $costosRaw = ModeloAgro::mdlMostrarCostos($tablaPlan,$campania,$idPlanificacion);
        $costos = array();
        foreach ($costosRaw as $c) { $costos[$c['cultivo']] = floatval($c['costo']); }

        $mapDisplay = function($cultivo){
            switch ($cultivo) {
                case 'soja1': return 'Soja 1ra';
                case 'soja2': return 'Soja 2da';
                case 'maiz1': return 'Maíz';
                case 'maiz2': return 'Maíz 2da';
                case 'avena': return 'Avena Cobertura';
                case 'triticale-vicia':
                case 'vicia-triticale': return 'Vicia-Triticale';
                default: return ucfirst($cultivo);
            }
        };

        $tipoPlural = function($tipo){
            if($tipo === 'invernal') return 'invernales';
            if($tipo === 'estival') return 'estivales';
            return $tipo;
        };

        $planPorTipo = ['fina'=>['has'=>0,'dolares'=>0],'gruesa'=>['has'=>0,'dolares'=>0],'cobertura'=>['has'=>0,'dolares'=>0],'invernales'=>['has'=>0,'dolares'=>0],'estivales'=>['has'=>0,'dolares'=>0]];
        $planPorCultivo = [];

        foreach ($cultivosPlan as $row) {
            $cultivo = $row['cultivo'];
            $has = floatval($row['has']);
            $costoUnit = isset($costos[$cultivo]) ? floatval($costos[$cultivo]) : 0;
            $dolares = $has * $costoUnit;

            $tipo = $row['tipo'];
            $tipoEI = $tipoPlural(tipoEstInv($cultivo));

            if(isset($planPorTipo[$tipo])){
                $planPorTipo[$tipo]['has'] += $has;
                $planPorTipo[$tipo]['dolares'] += $dolares;
            }
            if(isset($planPorTipo[$tipoEI])){
                $planPorTipo[$tipoEI]['has'] += $has;
                $planPorTipo[$tipoEI]['dolares'] += $dolares;
            }
            if(!isset($planPorCultivo[$cultivo])) $planPorCultivo[$cultivo] = ['has'=>0,'dolares'=>0];
            $planPorCultivo[$cultivo]['has'] += $has;
            $planPorCultivo[$cultivo]['dolares'] += $dolares;
        }

        $totalPlanHas = array_reduce($planPorTipo, function($s,$v){ return $s + $v['has']; }, 0);

        $etapas = ['fina','gruesa','cobertura'];
        $ejecPorTipo = ['fina'=>['has'=>0,'dolares'=>0],'gruesa'=>['has'=>0,'dolares'=>0],'cobertura'=>['has'=>0,'dolares'=>0],'invernales'=>['has'=>0,'dolares'=>0],'estivales'=>['has'=>0,'dolares'=>0]];
        $ejecPorCultivoHasMax = [];
        $ejecPorCultivoCostos = [];

        foreach ($etapas as $etapa) {
            $rows = ModeloAgro::mdlMostrarDataEjecucion('ejecucion','campania',$campania,'etapa',$etapa);
            foreach ($rows as $r) {
                $cultivo = $r['cultivo'];
                $lote = trim($r['lote']);
                $has = floatval($r['has']);
                $cost = floatval($r['costoLabor']) + floatval($r['costoInsumo']);

                if(isset($ejecPorTipo[$etapa])){
                    $key = $lote.'|'.$cultivo;
                    if(!isset($ejecPorCultivoHasMax[$key])) $ejecPorCultivoHasMax[$key] = 0;
                    if($has > $ejecPorCultivoHasMax[$key]){
                        $ejecPorTipo[$etapa]['has'] += ($has - $ejecPorCultivoHasMax[$key]);
                        $ejecPorCultivoHasMax[$key] = $has;
                    }
                    $ejecPorTipo[$etapa]['dolares'] += $cost;
                }

                $tipoEI = $tipoPlural(tipoEstInv($cultivo));
                if(isset($ejecPorTipo[$tipoEI])){
                    $keyEI = $lote.'|'.$cultivo.'|'.$tipoEI;
                    if(!isset($ejecPorCultivoHasMax[$keyEI])) $ejecPorCultivoHasMax[$keyEI] = 0;
                    if($has > $ejecPorCultivoHasMax[$keyEI]){
                        $ejecPorTipo[$tipoEI]['has'] += ($has - $ejecPorCultivoHasMax[$keyEI]);
                        $ejecPorCultivoHasMax[$keyEI] = $has;
                    }
                    $ejecPorTipo[$tipoEI]['dolares'] += $cost;
                }

                $keyCultivo = $lote.'|'.$cultivo.'|cultivo';
                if(!isset($ejecPorCultivoHasMax[$keyCultivo])) $ejecPorCultivoHasMax[$keyCultivo] = 0;
                if($has > $ejecPorCultivoHasMax[$keyCultivo]){
                    if(!isset($ejecPorCultivoHasMax[$cultivo])) $ejecPorCultivoHasMax[$cultivo] = 0;
                    $ejecPorCultivoHasMax[$cultivo] += ($has - $ejecPorCultivoHasMax[$keyCultivo]);
                    $ejecPorCultivoHasMax[$keyCultivo] = $has;
                }
                if(!isset($ejecPorCultivoCostos[$cultivo])) $ejecPorCultivoCostos[$cultivo] = 0;
                $ejecPorCultivoCostos[$cultivo] += $cost;
            }
        }

        $totalEjecHas = $ejecPorTipo['fina']['has'] + $ejecPorTipo['gruesa']['has'] + $ejecPorTipo['cobertura']['has'];

        foreach ($planPorTipo as $k=>&$v) {
            $v['porcentaje'] = ($totalPlanHas > 0) ? round(($v['has']/$totalPlanHas)*100) : 0;
        }
        foreach ($ejecPorTipo as $k=>&$v) {
            $v['porcentaje'] = ($totalEjecHas > 0) ? round(($v['has']/$totalEjecHas)*100) : 0;
        }

        $cultivosOut = [];
        $cultivosKeys = array_unique(array_merge(array_keys($planPorCultivo), array_keys($ejecPorCultivoHasMax)));
        foreach ($cultivosKeys as $cultivo) {
            if($cultivo === '' || (is_string($cultivo) && strpos($cultivo,'|') !== false)) continue;
            $planHas = isset($planPorCultivo[$cultivo]) ? $planPorCultivo[$cultivo]['has'] : 0;
            $planDol = isset($planPorCultivo[$cultivo]) ? $planPorCultivo[$cultivo]['dolares'] : 0;
            $ejecHas = isset($ejecPorCultivoHasMax[$cultivo]) ? $ejecPorCultivoHasMax[$cultivo] : 0;
            $ejecDol = isset($ejecPorCultivoCostos[$cultivo]) ? $ejecPorCultivoCostos[$cultivo] : 0;

            $cultivosOut[] = [
                'nombre' => $mapDisplay($cultivo),
                'planificacion' => [
                    'has' => $planHas,
                    'dolares' => $planDol,
                    'porcentaje' => ($totalPlanHas>0)? round(($planHas/$totalPlanHas)*100) : 0
                ],
                'ejecucion' => [
                    'has' => $ejecHas,
                    'dolares' => $ejecDol,
                    'porcentaje' => ($totalEjecHas>0)? round(($ejecHas/$totalEjecHas)*100) : 0
                ]
            ];
        }

        return [
            'planificacion' => [
                'fina' => $planPorTipo['fina'],
                'gruesa' => $planPorTipo['gruesa'],
                'cobertura' => $planPorTipo['cobertura'],
                'invernales' => $planPorTipo['invernales'],
                'estivales' => $planPorTipo['estivales']
            ],
            'ejecucion' => [
                'fina' => $ejecPorTipo['fina'],
                'gruesa' => $ejecPorTipo['gruesa'],
                'cobertura' => $ejecPorTipo['cobertura'],
                'invernales' => $ejecPorTipo['invernales'],
                'estivales' => $ejecPorTipo['estivales']
            ],
            'cultivos' => $cultivosOut
        ];
    }

    

}

	