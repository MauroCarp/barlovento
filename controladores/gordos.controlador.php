<?php
require_once "modelos/gordos.modelo.php";

class ControladorGordos{

  // Obtiene datos para el panel principal desde DB
  static public function ctrObtenerPrincipal(){


    return [
      'fecha' => date('Y-m-d'),
    //   'meses' => $meses,
    //   'externo' => $externo,
    //   'interno' => $interno,
    ];
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
                                        
                                    if($rowNumber > 3 && $rowNumber < 12){
                                            
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[4]."'","'Exportacion'","'Novillos'","'".$Row[2]."'",$Row[3],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[7]."'","'Campo Pastoreo'","'Novillos'","'".$Row[5]."'",$Row[6],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[10]."'","'Mercado Interno'","'Novillos'","'".$Row[8]."'",$Row[9],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[13]."'","'Mercado Interno'","'Toros'","'".$Row[11]."'",$Row[12],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[16]."'","'Mercado Interno'","'Vaquillonas'","'".$Row[14]."'",$Row[15],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[19]."'","'Mercado Interno'","'Vaquillonas'","'".$Row[17]."'",$Row[18],$nResumen)) . ')';
                                        $objResumen[] = '(' . implode(',',array("'".$fecha."'","'".$Row[22]."'","'Vaquillonas'","'Hoteleria'","'".$Row[20]."'","'".$Row[21]."'",$nResumen)) . ')';

                                        $nResumen++;

                                    }

                                    // if($rowNumber > 18 && $rowNumber < 23){

                                    //     $objGordos[] = array(
                                    //         'fecha' => $fecha,
                                    //         'mes' => $Row[0],
                                    //         'oferta' => $Row[2],
                                    //         'demanda' => $Row[3],
                                    //         'tipo' => 'Exportacion',
                                    //     );

                                    // }
                   
                                    
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

                    // $respuesta[] = ModeloGordos::mdlInsertResumen(implode(',',$objResumen));
                    // var_dump($respuesta);
                    $respuesta[] = ModeloGordos::mdlInsertGordos(implode(',',$objGordos));
                    var_dump($respuesta);
                    die;

                    if($respuesta != 'ok'){
                        echo'<script>

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
  
}
  
