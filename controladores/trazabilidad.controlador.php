<?php


class ControladorTrazabilidad{

	static public function ctrMostrarFaenas($item = null, $valor = null){

		$tabla = "faenas";

		$respuesta = ModeloTrazabilidad::MdlMostrarFaenas($tabla, $item, $valor);
		
		return $respuesta;
	}

	static function fechaExcel($date){

		$fecha = explode('/',$date);

		return $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];

	}

	static public function ctrNuevaFaena(){
		
		if(isset($_POST['btnCargarFaena'])){

			require_once('extensiones/excel/php-excel-reader/excel_reader2.php');
			require_once('extensiones/excel/SpreadsheetReader.php');
			
			$nombre = $_POST['nombreFaena'];
			
			if($_POST['nombreFaena'] =! '' && $_POST['fechaFaena'] != ''){

				$datosFaena = array('nombre'=>$nombre,'fecha'=>$_POST['fechaFaena'],'frigorifico'=>$_POST['frigorificoFaena']);
				$tabla = 'faenas';
				$idFaena = ModeloTrazabilidad::mdlNuevaFaena($tabla,$datosFaena);
				
				if(!is_array($idFaena)){

					if(isset($_FILES['excelWC']) && isset($_FILES['excelTrazabilidad'])){
					
						$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
			
						$dataTD = array();
						$dataWC = array();
						$dataTrazabilidad = array();
						$rfidsTemp = array();
									
						// if(isset($_FILES['excelTD'])){

						// 	// TOMA DE DATOS CARGA EXCEL TD
						// 	if(in_array($_FILES["excelTD"]["type"],$allowedFileType)){
				
						// 		$ruta = "carga/" . $_FILES['excelTD']['name'];
								
						// 		move_uploaded_file($_FILES['excelTD']['tmp_name'], $ruta);
																			
						// 		$rowNumber = 0;
								
						// 		$rowValida = false;
									
						// 		$Reader = new SpreadsheetReader($ruta);	
								
						// 		$sheetCount = count($Reader->sheets());
																
						// 		for ($i=0;$i<$sheetCount;$i++){
				
						// 			$Reader->ChangeSheet($i);
				
						// 			foreach ($Reader as $Row){
	
						// 				if($Row[0] == 'KG TOTAL' || ($rowNumber > 14 && $Row[0] == '')) $rowValida = false;
	
						// 				if ($rowValida){	
	
						// 					if(in_array($Row[1],$rfidsTemp)){
	
						// 						// echo '<script>
						// 						// 		alert("El RFID ' . $Row[1] . ' se repite en la planilla de Toma de Decisión. La carga de uno de ellos no sera realiazada")
						// 						// 		</script>';
						// 					}
	
						// 					$dataTD[] = array(
						// 						'rfid'	 =>$Row[1],
						// 						'mmGrasa'=>$Row[2],
						// 						'peso'=>$Row[3],
						// 						'sexo'=>$Row[4],
						// 						'clasificacion'=>$Row[5],
						// 						'aob'	=>$Row[6],
						// 						'fecha'	=>ControladorTrazabilidad::fechaExcel($Row[0]),
						// 						'refEco'=>$Row[7]);										
	
						// 					$rfidsTemp[] = $Row[1];
											
						// 				}
	
						// 				if ($rowNumber == 14){
	
						// 					if($Row[0] == 'Fecha'){
						// 						$rowValida = true;
						// 					} else {
	
						// 						ModeloTrazabilidad::mdlEliminarFaena($idFaena);
	
						// 						echo '<script>
	
						// 							swal({
						// 									type: "error",
						// 									title: "La planilla seleccionada no corresponde a una planilla de Toma de Decisión",
						// 									showConfirmButton: true,
						// 									confirmButtonText: "Cerrar"
						// 									}).then(function(result) {
						// 											if (result.value) {
	
						// 												window.location = "index.php?ruta=trazabilidad/index"
	
						// 											}
						// 										})
	
						// 							</script>';
						// 							die();
	
						// 					}
	
						// 				}
											
						// 				$rowNumber++;
				
						// 			}
										
						// 		}
	
						// 		$rfidsTemp = array();
											
						// 	} else {
	
						// 		ModeloTrazabilidad::mdlEliminarFaena($idFaena);
	
						// 		echo'<script>
	
						// 		swal({
						// 				type: "error",
						// 				title: "El formato de la planilla Toma de Decisión no es compatible con Excel",
						// 				showConfirmButton: true,
						// 				confirmButtonText: "Cerrar"
						// 				}).then(function(result) {
						// 						if (result.value) {
	
						// 							window.location = "index.php?ruta=trazabilidad/index"
	
						// 						}
						// 					})
	
						// 		</script>';
	
						// 		die();							
	
						// 	}

						// 	// CARGA DE EXCEL
						// 	$tabla = 'tdanimales';
							
						// 	$cargaTD = ControladorTrazabilidad::ctrCargarExcel($tabla,$idFaena,$dataTD);
						
						// 	if($cargaTD != 'ok'){

						// 		ModeloTrazabilidad::mdlEliminarFaena($idFaena);
								
						// 		echo'<script>

						// 				swal({
						// 						type: "error",
						// 						title: "Error al cargar Excel Toma de Decisión a la base de datos. Informar",
						// 						showConfirmButton: true,
						// 						confirmButtonText: "Cerrar"
						// 						}).then(function(result) {
						// 								if (result.value) {

						// 									window.location = "index.php?ruta=trazabilidad/index"

						// 								}
						// 							})

						// 		</script>';

						// 		die();	

						// 	}

						// }

						// TOMA DE DATOS CARGA EXCEL WINCAMPO
						if(in_array($_FILES["excelWC"]["type"],$allowedFileType)){
			
							$ruta = "carga/" . $_FILES['excelWC']['name'];
							
							move_uploaded_file($_FILES['excelWC']['tmp_name'], $ruta);
																		
							$rowNumber = 0;
							
							$rowValida = false;
								
							$Reader = new SpreadsheetReader($ruta);	
							
							$sheetCount = count($Reader->sheets());
															
							for ($i=0;$i<$sheetCount;$i++){
			
								$Reader->ChangeSheet($i);
			
								foreach ($Reader as $Row){

									if (empty(array_filter($Row, function($value) { return $value !== null && $value !== ''; }))) {
										$rowValida = false; // Si la fila está vacía, no la procesamos
									}

									if ($rowValida){			
										

										$ingreso = explode('-',$Row[30]);
										$ingreso = '20' . $ingreso[2] . '-' . $ingreso[0] . '-' . $ingreso[1];
										$salida = explode('-',$Row[31]);
										$salida = '20' . $salida[2] . '-' . $salida[0] . '-' . $salida[1];
										$dataWC[] = array('tropa' 		=> $Row[4],
															'rfid'		=> substr($Row[1], 9),
															'caravana'	=> $Row[59],
															'categoria'	=> $Row[2],
															'actividad'	=> $Row[7],
															'estado'		=> $Row[39],
															'consignatario'		=> $Row[22],
															'raza'		=> $Row[3],
															'ingreso' => $ingreso,
															'salida' => $salida,
															'kgIngreso'	=> $Row[9],
															'kgEgreso'	=> $Row[10],
															'kgProducido' => $Row[11],
															'dias'	    => $Row[12],
															'adpv'	    => $Row[13],
															'convTC'      => $Row[16],
															'convMS'      => $Row[17],
															'kilosTC'     => $Row[14],
															'kilosMS'     => $Row[15],
															'costo'       => $Row[18],
															'proveedor'   => $Row[23],
															'provincia'   => $Row[25],
															'localidad'   => $Row[24],
															'transaccionWC'=> $Row[36],
															'clienteDestinoVenta'=> $Row[6],
															'corral'=> $Row[58]
										);
										
										
									}
									
									
									if ($rowNumber == 0){

										if($Row[0] == 'Hotelero'){
											$rowValida = true;
										} else {

											echo'<script>

											swal({
													type: "error",
													title: "La planilla seleccionada no corresponde a una planilla de WinCampo",
													showConfirmButton: true,
													confirmButtonText: "Cerrar"
													}).then(function(result) {
															if (result.value) {

																window.location = "index.php?ruta=trazabilidad/index"

															}
														})

											</script>';
											die();
										}

									}
										
									$rowNumber++;
			
								}
									
							}
						} else {

							ModeloTrazabilidad::mdlEliminarFaena($idFaena);

							echo'<script>

							swal({
									type: "error",
									title: "El formato de la planilla WinCampo no es compatible con Excel",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result) {
											if (result.value) {

												window.location = "index.php?ruta=trazabilidad/index"

											}
										})

							</script>';
							die();	

						}

						// TOMA DE DATOS EXCEL TRAZABILIDAD

						if(in_array($_FILES["excelTrazabilidad"]["type"],$allowedFileType)){
			
							$ruta = "carga/" . $_FILES['excelTrazabilidad']['name'];
							
							move_uploaded_file($_FILES['excelTrazabilidad']['tmp_name'], $ruta);
																		
							$rowNumber = 0;
							
							$rowValida = false;
								
							$Reader = new SpreadsheetReader($ruta);	
							
							$sheetCount = count($Reader->sheets());
															
							for ($i=0;$i<$sheetCount;$i++){
			
								$Reader->ChangeSheet($i);
			
								 $rowIndex = 0;

								foreach ($Reader as $Row) {

									if ($rowIndex === 0) {
										// Salteamos la fila de cabecera
										if($Row[0] == 'Nº de Caravana'){
											$rowValida = true;
										} else {

											ModeloTrazabilidad::mdlEliminarFaena($idFaena);

											echo'<script>

											swal({
													type: "error",
													title: "La planilla seleccionada no corresponde a una planilla de Trazabilidad",
													showConfirmButton: true,
													confirmButtonText: "Cerrar"
													}).then(function(result) {
															if (result.value) {

																window.location = "index.php?ruta=trazabilidad/index"

															}
														})

											</script>';
											die();
										}

										$rowIndex++;
										continue;
									}

									// Eliminamos espacios y chequeamos si la celda 0 está vacía
									$cell0 = trim($Row[0] ?? '');

									if($cell0 != '') {
										
										// Si la longitud es menor a 6, agregamos ceros a la izquierda
										if (strlen($cell0) < 6) {
											$cell0 = str_pad($cell0, 6, '0', STR_PAD_LEFT);
										}

									}
								
									if (!empty($cell0)) {
										// Es una nueva carcasa
										$currentCarcasa = $cell0;
										$dataTrazabilidad[] = ['rfid' => $currentCarcasa,
													   'correlacion' => $Row[1],
													   'garron' => $Row[2],
													   'kilos' => $Row[3],
													   'denominacion' => $Row[4],
													   'tipificacion' => $Row[5],
													   'gordo' => $Row[6],
													   'den' => $Row[7]];
										
									} elseif ($currentCarcasa !== null) {
										// Es la segunda fila asociada a la carcasa actual
										$dataTrazabilidad[] = ['rfid' => $currentCarcasa,
													   'correlacion' => $Row[1],
													   'garron' => $Row[2],
													   'kilos' => $Row[3],
													   'denominacion' => $Row[4],
													   'tipificacion' => $Row[5],
													   'gordo' => $Row[6],
													   'den' => $Row[7]];
									}

									$rowIndex++;
								}
									
							}
						} else {

							ModeloTrazabilidad::mdlEliminarFaena($idFaena);

							echo'<script>

							swal({
									type: "error",
									title: "El formato de la planilla Trazabilidad no es compatible con Excel",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
									}).then(function(result) {
											if (result.value) {

												window.location = "index.php?ruta=trazabilidad/index"

											}
										})

							</script>';
							die();				
						}

						$tabla = 'wcanimales';
						$cargaWC = ControladorTrazabilidad::ctrCargarExcel($tabla,$idFaena,$dataWC);
						
						if($cargaWC != 'ok'){

							ModeloTrazabilidad::mdlEliminarFaena($idFaena);

							echo'<script>

									swal({
											type: "error",
											title: "Error al cargar Excel WinCampo a la base de datos. Informar",
											showConfirmButton: true,
											confirmButtonText: "Cerrar"
											}).then(function(result) {
													if (result.value) {

														window.location = "index.php?ruta=trazabilidad/index"

													}
												})

							</script>';

							die();	
						}
						
						$tabla = 'trazanimales';

						$cargaTrazabilidad = ControladorTrazabilidad::ctrCargarExcel($tabla,$idFaena,$dataTrazabilidad);
			
						
						if($cargaTrazabilidad != 'ok'){

							ModeloTrazabilidad::mdlEliminarFaena($idFaena);

							echo'<script>

								swal({
										type: "error",
										title: "Error al cargar Excel Trazabilidad a la base de datos. Informar",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
										}).then(function(result) {
												if (result.value) {

													window.location = "index.php?ruta=trazabilidad/index"

												}
											})

							</script>';						

						}


						echo'<script>

							swal({
								type: "success",
								title: "La carga se ha realizado correctamente",
								}).then(function(result) {
										window.location = "index.php?ruta=trazabilidad/index";
								})

						</script>';

						die;

					} else {

						ModeloTrazabilidad::mdlEliminarFaena($idFaena);

						echo'<script>

						swal({
								type: "error",
								title: "No se cargaron los tres archivos de Excel",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
								}).then(function(result) {
										if (result.value) {

											window.location = "index.php?ruta=trazabilidad/index"

										}
									})

						</script>';
						die();						

					}

				} else {

					echo'<script>

						swal({
								type: "error",
								title: "No se pudo crear la faena. Informar",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
								}).then(function(result) {
										if (result.value) {

											window.location = "index.php?ruta=trazabilidad/index"

										}
									})

						</script>';
						die();		
				}

			} else {

				echo'<script>

				swal({
						type: "error",
						title: "El nombre y/o Fecha no puede ir vacio",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result) {
								if (result.value) {

									window.location = "index.php?ruta=trazabilidad/index"

								}
							})

				</script>';
				die();	

			}
    
		} 

	}


	static public function ctrCargarExcel($tabla,$idFaena,$datos){


		$campos = implode(',', array_keys($datos[0]));

		$dataSql = array();

		foreach ($datos as $value) {

			$tmp = array();

			foreach ($value as $val) {
				$tmp[] = (is_numeric($val)) ? $val : "'" . $val . "'";
			}

			$dataSql[] = "(" . $idFaena . "," . implode(',',$tmp) . ")";
		}

		$dataSql = implode(',',$dataSql);

		return ModeloTrazabilidad::mdlCargarExcel($tabla,$campos,$dataSql);

	}

	static public function ctrEliminarFaena($idFaena){

		return ModeloTrazabilidad::mdlEliminarFaena($idFaena);
		
	}


	static public function ctrDataReporte1($idFaena){

		
		$tabla = 'faenas';
		$dataFaena = ModeloTrazabilidad::mdlDataReporte1($idFaena,$tabla);
		
		$tabla1 = 'tdanimales';
		$tabla2 = 'trazanimales';
		$tabla3 = 'wcanimales';
		$dataAnimales = ModeloTrazabilidad::mdlDataReporte1($idFaena,$tabla1,$tabla2,$tabla3);
		
		return array('faena'=>$dataFaena,'animales'=>$dataAnimales);

	}


	static public function ctrMostrarAnimalesFaenas($ids){

		$tabla = "wcanimales";

		$wincampo = ModeloTrazabilidad::mdlMostrarAnimalesFaenas($tabla, $ids);

		$tabla = "trazanimales";

		$frigorigico = ModeloTrazabilidad::mdlMostrarAnimalesFaenas($tabla, $ids);
	
		$respuesta = array();

		foreach ($wincampo as $key => $animal) {
			$respuesta[$animal['rfid']][] = $animal;
		}
		foreach ($frigorigico as $key => $animal) {
			$respuesta[$animal['rfid']][] = $animal;
		}

		
		return $respuesta;	
	}
}
	


