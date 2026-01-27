<?php
require_once __DIR__ . '/../modelos/gordos.modelo.php';

class ControladorGordos{

  // Obtiene datos para el panel principal desde DB
  static public function ctrMostrarData(){


    $tabla = "gordos";

    $data = ModeloGordos::mdlMostrarData($tabla);
    
    return $data;

  }

  // Carga desde un archivo CSV con encabezados
  // Si contiene columnas categoria y kg => gordosResumen
  // Si contiene oferta y demanda => gordos
  static public function ctrCargarExcel(){

      
    if(isset($_POST['cargarGordos'])){

        require_once('extensiones/excel/php-excel-reader/excel_reader2.php');
        require_once('extensiones/excel/SpreadsheetReader.php');
        
        $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        foreach ($_FILES as $key => $file) {
            
            if($file['size'] > 0){

                if(in_array($file["type"],$allowedFileType)){
                    
                    $ruta = "carga/" . $file['name'];
                    
                    move_uploaded_file($file['tmp_name'], $ruta);
                                                            
                    // Helper: convierte serial Excel o texto a Y-m-d
                    $excelSerialToDate = function($serial){
                        if(is_numeric($serial)){
                            $ts = ((float)$serial - 25569) * 86400; // 25569 días hasta epoch
                            return gmdate('Y-m-d', (int)$ts);
                        }
                        $s = trim((string)$serial);
                        if(preg_match('/^\d{4}-\d{2}-\d{2}$/', $s)) return $s;
                        if(preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $s, $m)){
                            return sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
                        }
                        return date('Y-m-d');
                    };

                    $data = array();
                    
                    $Reader = new SpreadsheetReader($ruta);	
                    
                    $sheetCount = count($Reader->sheets());

                    $objResumen = array();

                    $objResumenMensual = array();

                    $objGordos = array();

                    $nResumen = 0;

                    $nGordos = 0;   

                    for($i=0;$i<$sheetCount;$i++){

                        if($i == 1 || $i == 2){

                            $Reader->ChangeSheet($i);
    
                            $rowNumber = 0;
                            foreach ($Reader as $Row){     
                                
                                if($i == 1){
                                  
                                    if($rowNumber == 1)
                                        $fecha = isset($Row[2]) ? $excelSerialToDate($Row[2]) : date('Y-m-d');
                                        
                                    if($rowNumber >= 3 && $rowNumber < 12){
                                            
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[4]."'","'Exportacion'","'Novillos'","'".$Row[2]."'",$Row[3],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[7]."'","'Campo Pastoreo'","'Novillos'","'".$Row[5]."'",$Row[6],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[10]."'","'Mercado Interno'","'Novillos'","'".$Row[8]."'",$Row[9],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[13]."'","'Mercado Interno'","'Toros'","'".$Row[11]."'",$Row[12],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[16]."'","'Mercado Interno'","'Vaquillonas'","'".$Row[14]."'",$Row[15],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[19]."'","'Novillitos'","'Hoteleria'","'".$Row[17]."'",$Row[18],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[22]."'","'Vaquillonas'","'Hoteleria'","'".$Row[20]."'","'".$Row[21]."'",$nResumen)) . ')';

                                        $nResumen++;

                                    } 
                                    
                                    if($rowNumber >= 16 && $rowNumber < 22){
                                     
                                        $mes = ($Row[2] != '') ? $Row[2] : '-';
                                        $feedlot = ($Row[4] != '') ? $Row[4] : 0;
                                        $campo = ($Row[5] != '') ? $Row[5] : 0;
                                        $hotel = ($Row[6] != '') ? $Row[6] : 0;
                                        $novillos = ($Row[8] != '') ? $Row[8] : 0;
                                        $vaquillona = ($Row[9] != '') ? $Row[9] : 0;
                                        $hotel2 = ($Row[10] != '') ? $Row[10] : 0;

                                        $objResumenMensual[] = '(' . implode(',',array("'".$mes."'","'exportacion'","'".$feedlot."'","'".$campo."'",$hotel)) . ')';
                                        $objResumenMensual[] = '(' . implode(',',array("'".$mes."'","'interno'","'".$novillos."'","'".$vaquillona."'",$hotel2)) . ')';

                                    } 
                                    
                                    $rowNumber++;
                                }

                                if($i == 2){
                                    
                                    if($rowNumber == 1)
                                        $fecha = isset($Row[2]) ? $excelSerialToDate($Row[2]) : date('Y-m-d');
                                        
                                    if($rowNumber > 1 && $rowNumber < 13){
                                        
                                        $objGordos[] = "(" . implode(',',array("'".$fecha."'","'".$Row[0]."'","'".$Row[2]."'","'".$Row[1]."'","'Mercado Externo'")) . ")";

                                        $objGordos[] = "(" . implode(',',array("'".$fecha."'","'".$Row[0]."'","'".$Row[6]."'","'".$Row[5]."'","'Mercado Interno'")) . ")";

                                    }
                                    
                                    $rowNumber++;
                                }

                            }
                        }

                    }

                    $respuesta[] = ModeloGordos::mdlInsertResumen(implode(',',$objResumen));

                    $respuesta[] = ModeloGordos::mdlInsertResumenMensual(implode(',',$objResumenMensual));

                    $respuesta[] = ModeloGordos::mdlInsertGordos(implode(',',$objGordos));

                    $todosOk = !empty($respuesta) && array_reduce($respuesta, function($acc, $val) {
                        return $acc && $val === 'ok';
                    }, true);

                    if(!$todosOk){
                        echo'<script>,

                        swal({
                                type: "error",
                                title: "Hubo un error al cargar.Informar",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                                }).then(function(result) {
                                        if (result.value) {
                                            window.location = "index.php"

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
                title: "Datos cargados correctamente",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
                }).then(function(result) {
                        if (result.value) {

                            window.location = "index.php?ruta=panelGordos"
                        }
                    })

            </script>';
            die; 
        }
        
    }  

  }
  
    // Devuelve data formateada para vistas/modulos/resumen.php
    static public function ctrResumenData(){

        $map = [
            'exportacion' => ['tipo' => 'Exportacion', 'categoria' => 'Novillos'],
            'campo' => ['tipo' => 'Campo Pastoreo', 'categoria' => 'Novillos'],
            'mi_novillos' => ['tipo' => 'Mercado Interno', 'categoria' => 'Novillos'],
            'toros_mi' => ['tipo' => 'Mercado Interno', 'categoria' => 'Toros'],
            'vq_mi' => ['tipo' => 'Mercado Interno', 'categoria' => 'Vaquillonas'],
            // Estos dos pueden variar según cómo se cargó el Excel; se intentan valores comunes
            'nt_hotel' => ['tipo' => 'Novillitos', 'categoria' => 'Hoteleria'],
            'vq_hotel' => ['tipo' => 'Vaquillonas', 'categoria' => 'Hoteleria'],
        ];

        $superiores = [];

        foreach($map as $key => $tc){
            $rows = ModeloGordos::mdlFilasKgPorTipoCategoria($tc['tipo'], $tc['categoria']);
            $filas = [];
            foreach($rows as $r){
                $filas[] = ['kg' => $r['kg'], 'cab' => (int)$r['cantidad'], 'mes'=> ($r['mes'] ?? '') ];
            }
            $superiores[$key] = ['filas' => $filas];
        }


        // Construir estructura mensual usando gordosresumenmensual:
        // Para cada mes:
        // - EXPO: tomar fila donde tipo = 'exportacion' y mapear feedlot/campo/hotel
        // - MI: tomar fila donde tipo = 'interno' y mapear nt/vq/hotel
        $mensualRaw = ModeloGordos::mdlResumenMensual();
        $byMes = [];
        foreach($mensualRaw as $r){
            $mes = $r['mes'];
            $tipo = strtolower(trim($r['tipo']));
            $feedlot = (int)($r['feedlot_novillos'] ?? 0);
            $campo = (int)($r['campo_vaquillona'] ?? 0);
            $hotel = (int)($r['hotel'] ?? 0);
            if(!isset($byMes[$mes])){
                $byMes[$mes] = [
                    'expo' => ['total'=>0,'feedlot'=>0,'campo'=>0,'hotel'=>0],
                    'mi' => ['total'=>0,'nt'=>0,'vq'=>0,'hotel'=>0]
                ];
            }
            if($tipo === 'exportacion'){
                $byMes[$mes]['expo']['feedlot'] = $feedlot;
                $byMes[$mes]['expo']['campo'] = $campo;
                $byMes[$mes]['expo']['hotel'] = $hotel;
            } elseif($tipo === 'interno' || $tipo === 'mercado interno'){
                $byMes[$mes]['mi']['nt'] = $feedlot; // en MI, 'feedlot_novillos' representa NT
                $byMes[$mes]['mi']['vq'] = $campo;   // en MI, 'campo_vaquillona' representa VQ
                $byMes[$mes]['mi']['hotel'] = $hotel;
            }
        }

        // calcular totales por bloque
        $mensual = [];
        foreach($byMes as $mes => $vals){
            $expo = $vals['expo'];
            $expo['total'] = ($expo['feedlot'] + $expo['campo'] + $expo['hotel']);
            $mi = $vals['mi'];
            $mi['total'] = ($mi['nt'] + $mi['vq'] + $mi['hotel']);
            $mensual[] = [ 'mes'=>$mes, 'expo'=>$expo, 'mi'=>$mi ];
        }

        return [
            'superiores' => $superiores,
            'mensual' => $mensual
        ];
    }
  
}
  
