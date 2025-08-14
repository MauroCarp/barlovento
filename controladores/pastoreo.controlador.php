<?php
class ControladorPastoreo{

	/*=============================================
	CARGAR PLANILLA 
	=============================================*/

	static public function ctrCargarArchivo(){

        if( isset($_POST["btnCargar"]) ){
            
            require_once('extensiones/excel/php-excel-reader/excel_reader2.php');
            require_once('extensiones/excel/SpreadsheetReader.php');
            
            $error = false;

            
            if (isset($_FILES['nuevosDatosPastoreo'])){

                $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

                if(in_array($_FILES["nuevosDatosPastoreo"]["type"],$allowedFileType)){

                    $ruta = "carga/" . $_FILES['nuevosDatosPastoreo']['name'];
                    move_uploaded_file($_FILES['nuevosDatosPastoreo']['tmp_name'], $ruta);

                    $Reader = new SpreadsheetReader($ruta);	

                    $sheetCount = count($Reader->sheets());
                    
                    $rowNumber = 0;

                    $rowValida = false;

                    $data = array();

                    $fechaRegistro = '';

                    for($i=0;$i<$sheetCount;$i++){

                        $Reader->ChangeSheet($i);

                        foreach ($Reader as $Row){

                            if($rowNumber == 0){
                            
                                $fechaRegistro = DateTime::createFromFormat('m-d-y', $Row[3])->format('Y-m-d');

                            }

                            if($rowNumber == 3){
                                $rowValida = true;
                            }

                            if($rowValida){

                                if($Row[0] == '') break;

                                $data[] = array('celula'=>"'" . ControladorPastoreo::ctrGetCelula($Row[0]) . "'",
                                                'lote'=>$Row[0],
                                                'parcela'=>($Row[0] != 14) ? $Row[1] : 0,
                                                'ingresoPlanificado'=> "'" . DateTime::createFromFormat('m-d-y', $Row[2])->format('Y-m-d') . "'",
                                                'salidaPlanificado'=> "'" . DateTime::createFromFormat('m-d-y', $Row[3])->format('Y-m-d') . "'",
                                                'fechaRegistro'=> "'" . $fechaRegistro . "'"  
                                );


                            }

                            $rowNumber++;
                            
                        }		

                    }

                    $tabla = 'pastoreos';

                    for ($i=0; $i < sizeof($data); $i++) { 
                        $data[$i] = "(" . implode(',',$data[$i]) . ")";
                    }

                    $resultado = ModeloPastoreo::mdlCargarRegistros($tabla,implode(',',$data));
                  
                    if($resultado == "ok"){
                        echo'<script>

                                swal({
                                    type: "success",
                                    title: "Los datos han sido cargados correctamente",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                    }).then(function(result) {
                                                if (result.value) {

                                                window.location = "pastoreo";

                                                }
                                            })

                                </script>';
                    }else{
                        echo'<script>

                                swal({
                                        type: "error",
                                        title: "Hubo un error, los datos no fueron cargados.",
                                        showConfirmButton: true,
                                        confirmButtonText: "Cerrar"
                                        }).then(function(result) {
                                        if (result.value) {

                                        window.location = "pastoreo";

                                        }
                                    })

                            </script>';
                    }

                }
            }

            die();
        }

	}

    /*=============================================
	MOSTRAR DATOS 
	=============================================*/

	static public function ctrMostrarRegistros($item,$valor){

		$tabla = "pastoreos";

        // list($lote,$parcela) = explode('.',$id);

        // $item = 'lote';
        // $item2 = 'parcela';

		return ModeloPastoreo::mdlMostrarRegistros($tabla,$item,$valor);

	}
	

	/*=============================================
	CARGAR REGISTRO 
	=============================================*/

	static public function ctrCargarRegistro(){

		$tabla = "pastoreos";

        if(isset($_POST['cargarPastoreo'])){
            
            if($_POST['entradaReal'] == ''){

                echo'<script>
                
                swal({
                    type: "error",
                    title: "La fecha de entrada Real no puede ir vacia",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        
                        window.location.href = `index.php?ruta=pastoreo`;
                    }
                })';

            }

            $salidaReal = ($_POST['salidaReal'] == '') ? null : $_POST['salidaReal'];

            $data = array('ingresoReal'=>$_POST['entradaReal'],'salidaReal'=>$salidaReal);

            $respuesta = ModeloPastoreo::mdlEditarRegistro($tabla,$data,'id',$_POST['idRegistro']);

            if($respuesta == 'ok'){
                
                echo'<script>
                
                swal({
                    type: "success",
                    title: "Registro actualizado correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        
                        window.location.href = `index.php?ruta=pastoreo`;
                    }
                })
                
                </script>';

            }else{
                
                echo'<script>
    
                    swal({
                            type: "error",
                            title: "¡Hubo un error al modificar el registro!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                            }).then(function(result) {
                            if (result.value) {
                                
                                window.location.href = `index.php?ruta=pastoreo`;
                                
    
                            }
                        })
    
                    </script>';
            }

        }

	}
	
	/*=============================================
	CARGAR REGISTRO 
	=============================================*/

	static public function ctrEliminarRegistro($item,$id){

		$tabla = "pastoreos";
            
        return ModeloPastoreo::mdlEliminarRegistro($tabla,$item,$id);

	}

	static public function ctrGetCelula($lote){
        
        switch ($lote) {
            case '15':
            case '11':
                $celula = 'roja';        
                break;

            case '1':
            case '2':
            case '12':
            case '13':
            case '14':
                $celula = 'amarilla';        
                break;

            case '3':
            case '4':
                $celula = 'naranja';        
                break;
            
        }

        return $celula;
    }
	
	
}

