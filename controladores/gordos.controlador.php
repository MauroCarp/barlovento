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
                                                            
                    $rowNumber = 0;

                    $data = array();
                    
                    $Reader = new SpreadsheetReader($ruta);	
                    
                    $sheetCount = count($Reader->sheets());

                    for($i=0;$i<$sheetCount;$i++){

                        if($i == 1 || $i == 2){

                            $Reader->ChangeSheet($i);
    
                            foreach ($Reader as $Row){     
                                
                                    var_dump($Row[0]);
                                    
                              
                                    // if($rowValida){
    
                                    //     $arr = array('idEjecucion'=>$idEjecucion,
                                    //                 'lote'=>"'" . $Row[2] . "'",
                                    //                 'rinde'=> $Row[15],
                                    //                 'cultivo'=>"'" . $cultivo . "'",
                                    //                 'has'=>"'" . number_format(str_replace(',','',$Row[1]),0,'.','') . "'",
                                    //                 'costoLabor'=>"'" . number_format(str_replace(',','',$Row[2]),2,'.','') . "'",
                                    //                 'costoInsumo'=>"'" . number_format(str_replace(',','',$Row[4]),2,'.','') . "'",
                                    //                 'campo'=>"'" . $_POST[$key.'campo'] . "'",
                                    //                 'etapa'=>"'" . $etapa . "'"
                                    //     );
    
    
                                    //     $data[] = "(" . implode(',',$arr) . ")";
    
                                    // }
    
                            }
    
                            $rowNumber++;

                        }
                            
                    }
                    die;
                    $respuesta[] = ModeloGordos::mdlInsertResumen($tabla,implode(',',$data));
                    $respuesta[] = ModeloGordos::mdlInsertGordos($tabla,implode(',',$data));

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

                            window.location = "index.php?ruta=agro/agro&campania=' . $campania . '"
                        }
                    })

            </script>';
            die; 
        }
        
    }  

  }
  
}
