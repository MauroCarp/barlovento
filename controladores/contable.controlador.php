<?php

// require('../modelos/log.modelo.php');

use function Ramsey\Uuid\v1;

class ControladorContable{

	/*=============================================
	CARGAR ARCHIVO
	=============================================*/
	static public function ctrCargarArchivo(){

        function formatearNumero($number){

            return str_replace('*','.',
                                        str_replace(',','',
                                                    str_replace('.','*',
                                                                str_replace('?','',$number))));

        }

        function numberPaihuen($number){
            return str_replace('(','',str_replace(')','',str_replace('*','-',str_replace(',','.',str_replace('?','',$number)))));
        }

        // VALIDAR INGRESOS REPETIDOS⁄
        
        if(isset($_POST['btnCargar'])){
            
            require_once('extensiones/excel/php-excel-reader/excel_reader2.php');
            require_once('extensiones/excel/SpreadsheetReader.php');

            $tabla = 'contable';

            $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            $respuesta = null;

            if (isset($_FILES['nuevosDatosBarlovento'])){
    
                if(in_array($_FILES["nuevosDatosBarlovento"]["type"],$allowedFileType)){
    
                    $ruta = "carga/" . $_FILES['nuevosDatosBarlovento']['name'];
                    
                    move_uploaded_file($_FILES['nuevosDatosBarlovento']['tmp_name'], $ruta);

                    $nombreArchivo = $_FILES['nuevosDatosBarlovento']['name'];

                    $respuesta = ControladorContable::ctrProcesoExcel($ruta,$nombreArchivo,$tabla,'principal');

                }

            }
    
            if (isset($_FILES['nuevosDatosBarloventoConsolidado'])){
        
                if(in_array($_FILES["nuevosDatosBarloventoConsolidado"]["type"],$allowedFileType)){
    
                    $ruta = "carga/" . $_FILES['nuevosDatosBarloventoConsolidado']['name'];
                    
                    move_uploaded_file($_FILES['nuevosDatosBarloventoConsolidado']['tmp_name'], $ruta);
                        
                    $nombreArchivo = $_FILES['nuevosDatosBarloventoConsolidado']['name'];

                    $respuesta = ControladorContable::ctrProcesoExcel($ruta,$nombreArchivo,$tabla,'consolidado');
                    
                }
    
            }

            if (isset($_FILES['nuevosDatosPaihuen'])){
                if(in_array($_FILES["nuevosDatosPaihuen"]["type"],$allowedFileType)){
                    
                    $ruta = "carga/" . $_FILES['nuevosDatosPaihuen']['name'];
                    
                    move_uploaded_file($_FILES['nuevosDatosPaihuen']['tmp_name'], $ruta);
                    
                    $nombreArchivo = $_FILES['nuevosDatosPaihuen']['name'];
                    
                    $respuesta = ControladorContable::ctrProcesoExcel($ruta,$nombreArchivo,$tabla,'paihuen');

                }
    
            }
            

            if ($respuesta == 'error'){
    
                echo'<script>

                swal({
                        type: "error",
                        title: `¡No se pudo cargar la planilla!';

                        if($_SESSION['usuario'] == 'tecnicoContable'){
                            echo json_encode($respuesta);
                        }

                        echo '`,
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result) {
                        if (result.value) {
                            
                            

                        }
                    })

                </script>';

            } else {

                echo'<script>

                swal({
                        type: "success",
                        title: "La planilla ha sido cargada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result) {
                                if (result.value) {


                                }
                            })

                </script>';

            }
        }
            
        
	}

    /*=============================================
	PROCESO EXCEL DATOS
	=============================================*/
    static public function ctrProcesoExcel($ruta,$nombreArchivo,$tabla,$libro){

        $mapping = [
            '1.00.00.00.000' => 'activos',
            '1.01.00.00.000' => 'activoCorriente',
            '1.01.01.00.000' => 'activoDisponibilidades',
            '1.01.01.01.000' => 'cajaBancos',
            '1.01.02.00.000' => 'activoInversiones',
            '1.01.02.03.000' => 'activoMonedaExtranjera',
            '1.01.03.00.000' => 'activoCreditos',
            '1.01.03.03.006' => 'saldoTecnico',
            '1.01.03.03.008' => 'sld',
            '1.01.04.00.000' => 'bienesDeCambio',
            '1.01.04.01.000' => 'activosBiologicosGan',
            '1.01.04.03.000' => 'productosAgropecuarios',
            '1.01.04.05.000' => 'bienesUPP',
            '1.02.00.00.000' => 'activoNoCorriente',
            '1.02.01.00.000' => 'activoNCBienesDeUso',
            '1.02.01.01.000' => 'buEstructura',
            '1.02.01.02.000' => 'buMoviles',
            '1.02.01.03.000' => 'buDiversos',
            '1.02.01.04.000' => 'buReproductores',
            '1.02.02.00.000' => 'activoNCOtrosCreditos',
            '2.00.00.00.000' => 'pasivoTotal',
            '2.01.00.00.000' => 'pasivoCorriente',
            '2.01.01.00.000' => 'deudaTotal',
            '2.01.01.01.000' => 'proveedores',
            '2.01.01.02.000' => 'deudaBancaria',
            '2.01.01.02.010' => 'prestamos',
            '2.01.01.02.011' => 'prestamos',
            '2.01.01.02.012' => 'tarjetas',
            '2.01.01.02.013' => 'tarjetas',
            '2.01.01.02.014' => 'tarjetas',
            '2.01.01.02.015' => 'prestamos',
            '2.01.01.02.016' => 'prestamos',
            '2.01.01.07.000' => 'mutuales',
            '2.01.01.08.000' => 'prestamos',
            '2.01.01.09.000' => 'sgr',
            '3.00.00.00.000' => 'patrimonioNeto',
            '3.01.01.01.000' => 'patrimonioNetoCapital',
            '3.01.01.02.000' => 'patrimonioNetoReservas',
            '3.01.01.03.000' => 'patrimonioNetoResultadosAcumulados',
            '3.01.01.03.001' => 'patrimonioNetoResultadosAcumulados2',
            '3.01.01.03.002' => 'patrimonioNetoResultadoEjercicio',
            '4.00.00.00.000' => 'ganancias',
            '4.01.00.00.000' => 'directas',
            '4.01.01.00.000' => 'agricultura',
            '4.01.02.01.002' => 'vaquillonasNovillos',
            '4.01.02.01.005' => 'vaquillonasNovillos',
            '4.01.02.01.010' => 'carneSubproductos',
            '4.01.02.01.011' => 'carneSubproductos',
            '4.01.02.01.012' => 'produccionHacienda',
            '4.01.04.01.000' => 'exportacion',
            '4.02.00.00.000' => 'gananciasFinancieras',
            '5.00.00.00.000' => 'perdidas',
            '5.01.00.00.000' => 'perdidasDirectas',
            '5.01.01.14.004' => 'seguros',
            '5.01.01.14.005' => 'seguros',
            '5.01.01.14.006' => 'seguros',
            '5.02.00.00.000' => 'perdidasIndirectas',
            '5.02.01.01.001' => 'ingresoBrutoMensual',
            '5.02.01.02.000' => 'buGastosEstructura',
            '5.02.01.02.017' => 'seguros',
            '5.02.01.05.001' => 'sueldos',
            '5.02.01.05.002' => 'cargasSocialesReales',
            '5.02.01.05.003' => 'seguros',
            '5.02.01.06.005' => 'inmobiliario',
            '5.02.01.06.006' => 'honorarios',
            '5.02.01.06.007' => 'honorarios',
            '5.02.01.06.008' => 'honorarios',
            '5.02.01.06.009' => 'honorarios',
            '5.02.01.06.011' => 'seguros',
            '5.03.00.00.000' => 'perdidasFinancieras',
            '5.03.01.01.004' => 'interesesPagados',
            '5.04.00.00.000' => 'perdidasImpuestos',
        ];

        if($libro != 'paihuen'){

            $mapping['4.01.02.01.003'] = 'vaquillonasNovillos';
            $mapping['2.01.01.06.002'] = 'cerealPL';
            $mapping['4.01.02.01.000'] = 'ganaderia';

        }

        $rowNumber = 0;

        $Reader = new SpreadsheetReader($ruta);	
                    
        $sheetCount = count($Reader->sheets());
        
        $data = array('archivo'=>$nombreArchivo,
                      'libro'=>ucfirst($libro),
                      'prestamos' => array(),
                      'tarjetas' => array(),
                      'activos'=>0,
                      'activoCorriente'=>0,
                      'deudaTotal'=>0,
                      'mutuales'=>0,
                      'proveedores'=>0,
                      'cerealPL'=>0,
                      'seguros'=>array(),
                      'sgr'=>0,
                      'ganancias'=>0,
                      'gananciasFinancieras'=>0,
                      'perdidas'=>0,
                      'perdidasDirectas'=>0,
                      'perdidasIndirectas'=>0,
                      'perdidasImpuestos'=>0,
                      'perdidasFinancieras'=>0,
                      'deudaBancaria'=>0,
                      'saldoTecnico'=>0,
                      'sld'=>0,
                      'bienesDeCambio'=>0,
                      'cajaBancos'=>0,
                      'pasivoCorriente'=>0,
                      'pasivoTotal'=>0,
                      'patrimonioNeto'=>0,
                      'directas'=>0,
                      'agricultura'=>0,
                      'ganaderia'=>0,
                      'resto'=>0,
                      'ingresoBrutoMensual'=>0,
                      'inmobiliario'=>0,
                      'cargasSocialesReales'=>0,
                      'sueldos'=>0,
                      'honorarios'=>array(),
                      'interesesPagados'=>0,
                      'vaquillonasNovillos'=>array(),
                      'carneSubproductos'=>array(),
                      'exportacion'=>0,
                      'produccionHacienda'=>0,
                      'activosBiologicosGan'=>0,
                      'productosAgropecuarios'=>0,
                      'bienesUPP'=>0,
                      'buEstructura'=>0,
                      'buMoviles'=>0,
                      'buDiversos'=>0,
                      'buReproductores'=>0,
                      'buGastosEstructura'=>0,
                      'activoDisponibilidades'=>0,
                      'activoInversiones'=>0,
                      'activoMonedaExtranjera'=>0,
                      'activoCreditos'=>0,
                      'activoNoCorriente'=>0,
                      'activoNCBienesDeUso'=>0,
                      'activoNCOtrosCreditos'=>0,
                      'patrimonioNetoCapital'=>0,
                      'patrimonioNetoReservas'=>0,
                      'patrimonioNetoResultadosAcumulados'=>0,
                      'patrimonioNetoResultadosAcumulados2'=>0,
                      'patrimonioNetoResultadoEjercicio'=>0,
        );

        $periodo = '';

        for($i=0;$i<$sheetCount;$i++){

            $Reader->ChangeSheet($i);

            foreach ($Reader as $Row){

                if($rowNumber == 4){


                    $año = substr(substr($Row[4],-7),3);

                    $mes = substr(substr($Row[4],-7),0,2);

                    $date = "$año-$mes-01";

                    $data['periodo'] = $date;

                    $item = 'libro';
                    
                    $valor = $libro;

                    $item2 = 'periodo';

                    $valor2 = $data['periodo'];

                    $periodo = $valor2;

                    $cargaValida = ControladorContable::ctrMostrarDatos($item,$valor,$item2,$valor2);

                    if($cargaValida){
                        
                        echo '<script>

                            swal({
                                    type: "error",
                                    title: "Ya hay una planilla ' . ucfirst($libro) . ' en este periodo!",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                    }).then(function(result) {
                                    if (result.value) {
                                        
                                        window.location = "index.php?ruta=contable/contable"
        
                                    }
                                })
        
                            </script>';

                            die();
                    }
                    
                    
                }
                
                if($rowNumber >= 6){

                    if (isset($mapping[$Row[1]])) {

                        $key = $mapping[$Row[1]];
                        
                        if (!isset($data[$key])) {

                            $data[$key] = [];

                        }

                        if(is_array($data[$key])){

                            $data[$key][] = $Row[5];

                        } else {

                            $data[$key] = $Row[5];

                        }

                    }

                }
                    
                $rowNumber++;

            }
                
        }
                    
        $data['sgr'] = ($data['sgr'] != null) ? $data['sgr'] : 0; 
        $data['cerealPL'] = ($data['cerealPL'] != null) ? $data['cerealPL'] : 0; 
        $data['inmobiliario'] = ($data['inmobiliario'] != null) ? $data['inmobiliario'] : 0; 
        $data['resto'] = 0;
        $data['prestamos'] = array_sum($data['prestamos']);
        $data['tarjetas'] = array_sum($data['tarjetas']);
        $data['seguros'] = array_sum($data['seguros']);
        $data['honorarios'] = array_sum($data['honorarios']);
        $data['ganaderia'] = $data['ganaderia'];
        $data['vaquillonasNovillos'] = array_sum($data['vaquillonasNovillos']);
        $data['carneSubproductos'] = array_sum($data['carneSubproductos']);
        
        $precioDolar = 0;

        if($libro == 'consolidado'){

            $precioDolar = ControladorContable::ctrCalcularDolar($periodo);

        }
  
        $data['precioDolar'] = $precioDolar;

        $response = ModeloContable::mdlCargarArchivo($tabla,$data);

        return $response;

    }

    /*=============================================
	MOSTRAR DATOS
	=============================================*/
    static public function ctrMostrarDatos($item,$valor,$item2,$valor2){
        
        $tabla = 'contable';
        
        return ModeloContable::mdlMostrarDatos($tabla,$item,$valor,$item2,$valor2);
        
    }
    
    
    /*=============================================
    ULTIMO PERIODO
    =============================================*/
    
    static public function ctrUltimoPeriodo(){
        
        $principal = ModeloContable::mdlUltimoPeriodo('Principal','contable');        
        $consolidado = ModeloContable::mdlUltimoPeriodo('Consolidado','contable');
        $paihuen = ModeloContable::mdlUltimoPeriodo('Paihuen','contable');

        $periodos = array($principal[0],$consolidado[0],$paihuen[0]);

        if(count(array_unique($periodos)) == 1){

            return $principal[0];

        }else{

            return array('error'=>true,'principal'=>$principal[0],'consolidado'=>$consolidado[0],'paihuen'=>$paihuen[0]);

        }
        
    }
    
    /*============================================
    CALCULAR DATA
    =============================================*/
    
    static public function ctrCalcularData($periodo){
       
        function calcularData($consolidado,$principal,$ultimoMes){

            $labelMeses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
            $anio = explode('-',$consolidado['periodo']);
            $anio = $anio[0];

            // CAJAS
                /* ECONOMICO */

                    // AGRICULTURA
                        $agricultura1 = $principal['agricultura'];
                        $agricultura2 = $consolidado['agricultura'] - $agricultura1;
                    
                    // GANADERIAS  Y RESTOS
                    // var_dump($principal['ganaderiaExportacion']);
                    // die;

                        $ganaderiaResto1 = ($principal['ganaderia'] + $principal['ganaderiaExportacion']) - $principal['produccionHacienda'];
                        // var_dump($principal['ganaderia']);
                        // var_dump($principal['ganaderiaExportacion']);
                        // var_dump($principal['produccionHacienda']);
                        // var_dump($ganaderiaResto1);
                        
                        $ganaderiaResto2 = (($consolidado['ganaderia'] + $consolidado['ganaderiaExportacion']) - $consolidado['produccionHacienda']) - $ganaderiaResto1;

                    // VENTAS TOTALES
                        $ventasTotales = $agricultura1 + $agricultura2 + $ganaderiaResto1 + $ganaderiaResto2; 
                        $ventasTotales2 = $agricultura1 + $agricultura2;
                        $denominadorVentas = floatVal($consolidado['directas']) - floatVal($consolidado['produccionHacienda']);

                    // UTILIDADADES
                        $utilidadBruta = floatVal($consolidado['directas']) - floatVal($consolidado['perdidasDirectas']);
                        // var_dump(floatVal($consolidado['directas']));
                        // var_dump($consolidado['directas']);
                        // var_dump($consolidado['perdidasDirectas']);
                        // var_dump(floatVal($consolidado['perdidasDirectas']));
                        $utilidadNeta = floatVal($consolidado['ganancias']) - floatVal($consolidado['perdidas']);
                        $utilidadOperativa = floatVal($consolidado['directas']) - floatVal($consolidado['perdidas']);

                    // GASTOS OPERATIVOS
                        $gastosOperativos = floatVal($consolidado['perdidasDirectas']);

                    // INGRESOS TOTALES
                        $ingresosTotales = floatVal($consolidado['ganancias']);

                    // MARGEN DE UTILIDAD BRUTA
                    // var_dump($utilidadBruta);
                    // var_dump($ingresosTotales);
                        $margenUtilidadBruta = ($utilidadBruta / $ingresosTotales) * 100;
                        // var_dump($margenUtilidadBruta);
                        // die;
                        // print_r($utilidadBruta);
                        // echo "<script>console.log('".$utilidadBruta."')</script>";
                        // print_r($ingresosTotales);
                        // print_r($margenUtilidadBruta);

                    // MARGEN DE UTILIDAD NETA
                        $margenUtilidadNeta = ($utilidadNeta / $ingresosTotales) * 100;

                    // MARGEN DE UTILIDAD OPERATIVA
                        $margenUtilidadOperativa = ($utilidadOperativa / $ingresosTotales) * 100;

                    // RATIO DE GASTOS OPERATIVOS
                        $ratioGastosOperativos = ($gastosOperativos / $ingresosTotales) * 100;

                    // RESULTADO OPERATIVO / VENTAS
                        $resultadoOperativo = (floatVal($consolidado['directas']) - floatVal($consolidado['perdidas']));

                /* FINANCIERO */

                    // DEUDA TOTAL
                        $deudaTotal = floatVal($consolidado['deudaTotal']);

                    // PASIVO TOTAL
                        $pasivoTotal = floatVal($consolidado['pasivoTotal']);

                    // ACTIVO CIRCULANTE

                        $cajaBancos = floatVal($consolidado['cajaBancos']); 
                
                        $activoCirculante = $cajaBancos;
                    
                    // PATRIMONIO NETO
                        $patrimonioNeto = floatVal($consolidado['patrimonioNeto']) + (floatVal($consolidado['ganancias']) - floatVal($consolidado['perdidas']));

                    // DEUDA BANCARIA
                        $deudaBancaria = floatVal($consolidado['deudaBancaria']);

                    // BIENES DE CAMBIO
                        $bienesDeCambio = floatVal($consolidado['bienesDeCambio']);
                    
                    // PASIVO TOTAL
                        $pasivoTotal = floatVal($consolidado['pasivoTotal']);

                /* IMPOSITIVO */

                    // INGRESO BRUTO
                        $ingresosBrutos = floatVal($consolidado['ingresoBrutoMensual']);
                                        
                    // CARGAS SOCIALES REALES
                        $cargasSociales = floatVal($consolidado['cargasSocialesReales']);
                    
                    // SUELDOS 
                        $sueldos = floatVal($consolidado['sueldos']);
                        $sueldos12 = floatVal($consolidado['sueldos']);
                        $sueldos12Honorarios = floatVal($consolidado['sueldos'] + $consolidado['honorarios'] );
                    

            // GRAFICOS
                /* ECONOMICO */

                    // MARGEN SOBRE VENTAS

                        $resultadoExplotacion = (floatVal($consolidado['ganancias']) - floatVal($consolidado['perdidas']));
                        $resultadoExplotacion2 = (floatVal($consolidado['ganancias']) - floatVal($consolidado['perdidasDirectas']));
            
                        $ingresosExplotacion = $consolidado['ganancias'];
            
                        $margenSobreVentas = ($ingresosExplotacion != 0) ? ($resultadoExplotacion2 / $ingresosExplotacion) * 100 : 0;

                    // RENTABILIDAD ECONOMICA

                        $rentabilidadEconomica = ($consolidado['activos'] != 0) ? ($resultadoExplotacion / ($consolidado['activos'])) * 100 : 0;

                /* FINANCIERO */

                    // PRESTAMOS
                        $prestamos = $consolidado['prestamos'];
                        $tarjetas = $consolidado['tarjetas'];
                        $mutuales = $consolidado['mutuales'];
                        $sgr = $consolidado['sgr'];
                        $proveedores = $consolidado['proveedores'];
                        $cerealPL = $consolidado['cerealPL'];

                    // ENDEUDAMIENTO    
    
                        $endeudamiento = array('prestamos'=>$prestamos,'tarjetas'=>$tarjetas,'mutuales'=>$mutuales,'sgr'=>$sgr,'proveedores'=>$proveedores,'cerealPL'=>$cerealPL,'total'=>($prestamos + $tarjetas + $mutuales + $sgr + $proveedores + $cerealPL));

                    // DEUDA BANCARIA 

                        $deudaBancaria = $consolidado['deudaBancaria'];

                /* IMPOSITIVO */

                    // SALDOS
                        $saldos = array('sld'=>$consolidado['sld'],'saldoTecnico'=>$consolidado['saldoTecnico']);
                        
                    // SUELDOS HONORARIOS
                
                        $sueldosHonorarios = ($consolidado['sueldos'] + $consolidado['honorarios']);

                    // SUELDOS HONORARIOS / VENTAS
                
                        $sueldos12Ventas = $sueldos12 / $ventasTotales;
                      
                        $sueldos12HonorariosVentas = $sueldos12Honorarios / $ventasTotales;           
                        
            return array(
                'periodo'=>$labelMeses[$ultimoMes - 1],
                'dolar'=>$consolidado['precioDolar'],
                'periodoVisible'=> $labelMeses[$ultimoMes - 1] . ' ' . $anio,
                'resultados'=>array(
                    'resultadoNeto'=>$utilidadNeta,
                    'resultadoBruto'=>$utilidadBruta,
                    'resultadoOperativo'=>$utilidadOperativa,
                ),
                'tabla' => array('produccionGanancias'=>$consolidado['ganancias'],
                    'produccionGananciasDirectas'=>$consolidado['directas'],
                    'produccionGananciasFinancieras'=>$consolidado['gananciasFinancieras'],
                    'produccionPerdidas'=>$consolidado['perdidas'],
                    'produccionPerdidasDirectas'=>$consolidado['perdidasDirectas'],
                    'produccionPerdidasIndirectas'=>$consolidado['perdidasIndirectas'],
                    'produccionPerdidasFinancieras'=>$consolidado['perdidasFinancieras'],
                    'produccionPerdidasImpuestos'=>$consolidado['perdidasImpuestos'],
                    'patrimonioActivo'=>$consolidado['activos'],
                    'patrimonioActivoCorriente'=>$consolidado['activoCorriente'],
                    'patrimonioActivoBienesDeCambio'=>$consolidado['bienesDeCambio'],
                    'patrimonioActivoDisponibilidades'=>$consolidado['activoDisponibilidades'],
                    'patrimonioActivoInversiones'=>$consolidado['activoInversiones'],
                    'patrimonioActivoMonedaExtranjera'=>$consolidado['activoMonedaExtranjera'],
                    'patrimonioActivoCreditos'=>$consolidado['activoCreditos'],
                    'patrimonioActivoNoCorriente'=>$consolidado['activoNoCorriente'],
                    'patrimonioActivoNCBienesDeUso'=>$consolidado['activoNCBienesDeUso'],
                    'patrimonioActivoNCOtrosCreditos'=>$consolidado['activoNCOtrosCreditos'],
                    'patrimonioPasivo'=>$consolidado['pasivoTotal'],
                    'patrimonioPasivoCorriente'=>$consolidado['pasivoCorriente'],
                    'patrimonioPasivoDeudas'=>$consolidado['deudaTotal'],
                    'patrimonioNetoCapital'=>$consolidado['patrimonioNetoCapital'],
                    'patrimonioNetoReservas'=>$consolidado['patrimonioNetoReservas'],
                    'patrimonioNetoResultadosAcumulados'=>$consolidado['patrimonioNetoResultadosAcumulados'],
                    'patrimonioNetoResultadosAcumulados2'=>$consolidado['patrimonioNetoResultadosAcumulados2'],
                    'patrimonioNetoResultadoEjercicio'=>$consolidado['patrimonioNetoResultadoEjercicio'],
                    'patrimonioNeto'=>$consolidado['patrimonioNeto']

                ),
                'cajas'=>array('agricultura1'=>floatVal($agricultura1),
                               'agricultura2'=>floatVal($agricultura2),
                               'ganaderiaResto1'=>floatVal($ganaderiaResto1),
                               'ganaderiaResto2'=>floatVal($ganaderiaResto2),
                               'deudaTotal'=>($mutuales + $sgr + $deudaBancaria),
                               'deudaBancaria'=>$deudaBancaria,
                               'margenUtilidadBruta'=>$margenUtilidadBruta,
                               'margenUtilidadNeta'=>$margenUtilidadNeta,
                               'margenUtilidadOperativa'=>$margenUtilidadOperativa,
                               'ratioGastosOperativos'=>$ratioGastosOperativos,
                               'resultadoOperativo'=>$resultadoOperativo,
                               'patrimonioNeto'=>floatVal($patrimonioNeto),
                               'activos'=>$consolidado['activos'],
                               'activoCirculante'=>$activoCirculante,
                               'activoCorriente'=>$consolidado['activoCorriente'],
                               'pasivoTotal'=>$pasivoTotal,
                               'pasivoCorriente' => $consolidado['pasivoCorriente'],
                               'bienesDeCambio'=>$bienesDeCambio,
                               'ingresosBrutos'=>$ingresosBrutos,
                               'inmobiliario'=>0,
                               'cargasSociales'=>$cargasSociales,
                               'sueldos12'=>$sueldos12,
                               'sueldos12Honorarios'=>$sueldos12Honorarios,
                               'sueldos'=>$sueldos,
                               'ventasSG'=>$ventasTotales2,
                               'ventasTotales'=>$ventasTotales),     
                'graficos'=>array('ventasTotales'=>$ventasTotales,
                                  'activos'=>$consolidado['activos'],
                                  'denominadorVentas'=>($denominadorVentas),
                                  'gananciasDirectas'=>($consolidado['directas']),
                                  'perdidas'=>($consolidado['perdidas']),
                                  'agricultura1'=>(floatVal($agricultura1)),
                                  'ganaderiaResto1'=>floatVal($ganaderiaResto1),  
                                  'agricultura2'=>(floatVal($agricultura2)),
                                  'ganaderiaResto2'=>floatVal($ganaderiaResto2),
                                  'vaquillonasNovillos'=>floatVal($consolidado['vaquillonasNovillos']),
                                  'carneSubproductos'=>floatVal($consolidado['carneSubproductos']),
                                  'exportacion'=>floatVal($consolidado['ganaderiaExportacion']),
                                  'produccionHacienda'=>floatVal($consolidado['produccionHacienda']),
                                  'directas' => floatVal($consolidado['directas']),
                                  'margenSobreVentas'=>$margenSobreVentas,
                                  'resultadoExplotacion'=>$resultadoExplotacion,
                                  'resultadoExplotacion2'=>$resultadoExplotacion2,
                                  'rentabilidadEconomica'=>$rentabilidadEconomica,
                                  'cargasSociales'=>$cargasSociales,
                                  'endeudamiento' => $endeudamiento,
                                  'deudaBancaria' => $deudaBancaria,
                                  'interesesPagados' => $consolidado['interesesPagados'],
                                  'saldos'=>$saldos,
                                  'sueldos12' => $sueldos12,
                                  'sueldos12Honorarios' => $sueldos12Honorarios,
                                  'sueldos12Ventas' => $sueldos12Ventas,
                                  'sueldos12HonorariosVentas' => $sueldos12HonorariosVentas,
                                  'patrimonioNeto'=>floatVal($patrimonioNeto),
                                  'resultadoNeto'=>$utilidadNeta,
                                  'resultadoBruto'=>$utilidadBruta,
                                  'resultadoOperativo'=>$utilidadOperativa,
                                  'bienesDeCambio'=>array('activosBiologicosGan'=>$consolidado['activosBiologicosGan'],'productosAgropecuarios'=>$consolidado['productosAgropecuarios'],'bienesUPP'=>$consolidado['bienesUPP']),
                                  'bienesDeUso'=>array('buEstructura'=>$consolidado['buEstructura'],'buMoviles'=>$consolidado['buMoviles'],'buReproductores'=>$consolidado['buReproductores'],'buDiversos'=>$consolidado['buDiversos'],'buGastosEstructura'=>$consolidado['buGastosEstructura']))
            );

        }
        
        function calcularDataPaihuen($paihuen,$ultimoMes){
            $labelMeses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
            
            $anio = explode('-',$paihuen['periodo']);
            $anio = $anio[0];
            // CAJAS
                /* ECONOMICO */

                    // AGRICULTURA
                        $agricultura = $paihuen['agricultura'];
                    
                    // GANADERIAS  Y RESTOS
                        $ganaderiaResto = $paihuen['ganaderia'];

                    // VENTAS TOTALES
                        $ventasTotales = $agricultura + $ganaderiaResto; 
                /* FINANCIERO */

                    // DEUDA TOTAL
                        $deudaTotal = floatVal($paihuen['deudaTotal']);

                    // PASIVO TOTAL
                        $pasivoTotal = floatVal($paihuen['pasivoTotal']);

                    // ACTIVO CIRCULANTE

                        $cajaBancos = floatVal($paihuen['cajaBancos']); 
                
                        $activoCirculante = $cajaBancos;
                    
                    // PATRIMONIO NETO
                        $patrimonioNeto = floatVal($paihuen['patrimonioNeto']) + (floatVal($paihuen['ganancias']) - floatVal($paihuen['perdidas']));

                    // DEUDA BANCARIA
                        $deudaBancaria = floatVal($paihuen['deudaBancaria']);

                    // BIENES DE CAMBIO
                        $bienesDeCambio = floatVal($paihuen['bienesDeCambio']);
                    
                    // PASIVO TOTAL
                        $pasivoTotal = floatVal($paihuen['pasivoTotal']);

                /* IMPOSITIVO */

                    // INGRESO BRUTO
                        $ingresosBrutos = floatVal($paihuen['ingresoBrutoMensual']);
                    
                    // INMOBILIARIO / COMUNA
                        $inmobiliario = floatVal($paihuen['inmobiliario']);

                    // CARGAS SOCIALES REALES
                        $cargasSociales = floatVal($paihuen['cargasSocialesReales']);
                    
                    // SUELDOS 
                        $sueldos = floatVal($paihuen['sueldos']);
                        $sueldos12 = floatVal($paihuen['sueldos']);
                        $sueldos12Honorarios = floatVal($paihuen['sueldos'] + $paihuen['honorarios'] );
                    

            // GRAFICOS
                /* ECONOMICO */

                    // MARGEN SOBRE VENTAS

                        $resultadoExplotacion = (floatVal($paihuen['ganancias']) - floatVal($paihuen['perdidas']));
            
                        $ingresosExplotacion = $paihuen['ganancias'];
            
                        $margenSobreVentas = ($ingresosExplotacion != 0) ? ($resultadoExplotacion / $ingresosExplotacion) * 100 : 0;

                    // RENTABILIDAD ECONOMICA

                        $rentabilidadEconomica = ($paihuen['activos'] != 0) ? ($resultadoExplotacion / ($paihuen['activos'])) * 100 : 0;

                /* FINANCIERO */

                    // PRESTAMOS
                        $prestamos = $paihuen['prestamos'];
                        $tarjetas = $paihuen['tarjetas'];
                        $mutuales = $paihuen['mutuales'];
                        $sgr = $paihuen['sgr'];
                        $proveedores = $paihuen['proveedores'];
                        $cerealPL = $paihuen['cerealPL'];

                    // ENDEUDAMIENTO    
    
                        $endeudamiento = array('prestamos'=>$prestamos,'tarjetas'=>$tarjetas,'mutuales'=>$mutuales,'sgr'=>$sgr,'proveedores'=>$proveedores,'cerealPL'=>$cerealPL,'total'=>($prestamos + $tarjetas + $mutuales + $sgr + $proveedores + $cerealPL));

                    // DEUDA BANCARIA 

                        $deudaBancaria = $paihuen['deudaBancaria'];

                /* IMPOSITIVO */

                    // SALDOS
                        $saldos = array('sld'=>$paihuen['sld'],'saldoTecnico'=>$paihuen['saldoTecnico']);
                        
                    // SUELDOS HONORARIOS
                
                        $sueldosHonorarios = ($paihuen['sueldos'] + $paihuen['honorarios']);

                    // SUELDOS HONORARIOS / VENTAS
                
                        $sueldos12Ventas = ($ventasTotales > 0) ?  $sueldos12 / $ventasTotales : 0;
                        $sueldos12HonorariosVentas = ($ventasTotales > 0) ?  $sueldos12Honorarios / $ventasTotales : 0;           
            return array(
                'periodo'=>$labelMeses[$ultimoMes - 1],
                'dolar'=>0,
                'periodoVisible'=> $labelMeses[$ultimoMes - 1] . ' ' . $anio,
                'resultados'=>array(
                    'resultadoNeto'=>$utilidadNeta,
                    'resultadoBruto'=>$utilidadBruta,
                    'resultadoOperativo'=>$utilidadOperativa,
                ),
                'cajas'=>array('agricultura'=>floatVal($agricultura),
                               'ganaderiaResto'=>floatVal($ganaderiaResto),
                               'deudaTotal'=>($mutuales + $sgr + $deudaBancaria),
                               'deudaBancaria'=>$deudaBancaria,
                               'patrimonioNeto'=>floatVal($patrimonioNeto),
                               'activos'=>$paihuen['activos'],
                               'activoCirculante'=>$activoCirculante,
                               'activoCorriente'=>$paihuen['activoCorriente'],
                               'pasivoTotal'=>$pasivoTotal,
                               'pasivoCorriente' => $paihuen['pasivoCorriente'],
                               'bienesDeCambio'=>$bienesDeCambio,
                               'ingresosBrutos'=>$ingresosBrutos,
                               'inmobiliario'=>$inmobiliario,
                               'cargasSociales'=>$cargasSociales,
                               'sueldos12'=>$sueldos12,
                               'sueldos12Honorarios'=>$sueldos12Honorarios,
                               'sueldos'=>$sueldos),     
                'graficos'=>array('ventasTotales'=>$ventasTotales,
                                  'agricultura'=>(floatVal($agricultura)),
                                  'ganaderiaResto'=>floatVal($ganaderiaResto),  
                                //   'agricultura2'=>(floatVal($agricultura2)),
                                //   'ganaderiaResto2'=>floatVal($ganaderiaResto2),
                                  'vaquillonasNovillos'=>floatVal($paihuen['vaquillonasNovillos']),
                                  'carneSubproductos'=>floatVal($paihuen['carneSubproductos']),
                                  'exportacion'=>floatVal($paihuen['ganaderiaExportacion']),
                                  'produccionHacienda'=>floatVal($paihuen['produccionHacienda']),
                                  'margenSobreVentas'=>$margenSobreVentas,
                                  'resultadoExplotacion'=>$resultadoExplotacion,
                                //   'resultadoExplotacion2'=>$resultadoExplotacion2,
                                  'rentabilidadEconomica'=>$rentabilidadEconomica,
                                  'endeudamiento' => $endeudamiento,
                                  'deudaBancaria' => $deudaBancaria,
                                  'interesesPagados' => $paihuen['interesesPagados'],
                                  'saldos'=>$saldos,
                                  'sueldos12' => $sueldos12,
                                  'sueldos12Honorarios' => $sueldos12Honorarios,
                                  'sueldos12Ventas' => $sueldos12Ventas,
                                  'resultadoNeto'=>$utilidadNeta,
                                  'resultadoBruto'=>$utilidadBruta,
                                  'resultadoOperativo'=>$utilidadOperativa,
                                  'sueldos12HonorariosVentas' => $sueldos12HonorariosVentas)
            );

        }

        // ULTIMO MES⁄
        $item = 'libro';

        $valor = 'Principal';

        $item2 = 'periodo';

        $principal = ControladorContable::ctrMostrarDatos($item,$valor,$item2,$periodo);        

        if(!$principal)
            return false;
            
         
            // print_r($principal);
            // die;
        $valor = 'Consolidado';
        $consolidado = ControladorContable::ctrMostrarDatos($item,$valor,$item2,$periodo);

        $item = 'libro';
        
        $valor = 'Paihuen';
        
        $paihuen = ControladorContable::ctrMostrarDatos($item,$valor,$item2,$periodo);
        // MESES ANTERIORES
        
        $dateExplode = explode('-',$periodo);
        
        $ultimoMes = intval($dateExplode[1]);
        $ultimoAnio = intval($dateExplode[0]);

        $data = array('barlovento'=>array(calcularData($consolidado,$principal,$ultimoMes)));
        // 'paihuen'=>array(calcularDataPaihuen($paihuen,$ultimoMes)));

        for ($i=0; $i < 12; $i++) { 
            
            
            if($ultimoMes == 1){
    
                $ultimoMes = 12;
                $ultimoAnio = $ultimoAnio - 1;
    
            }else{
    
                $ultimoMes--;
    
            }

            $item = 'libro';

            $valor = 'Principal';
    
            $item2 = 'periodo';

            $valor2 = array($ultimoMes,$ultimoAnio);

            $principal = ControladorContable::ctrMostrarDatos($item,$valor,$item2,$valor2);        

            if(!$principal){
                
                return $data;
            }
            
            $valor = 'Consolidado';
            
            $consolidado = ControladorContable::ctrMostrarDatos($item,$valor,$item2,$valor2);
            
            $item = 'libro';
    
            $valor = 'Paihuen';
    
            $paihuen = ControladorContable::ctrMostrarDatos($item,$valor,$item2,$valor2);

            $data['barlovento'][] = calcularData($consolidado,$principal,$ultimoMes);
            // $data['paihuen'][] = calcularDataPaihuen($paihuen,$ultimoMes);
            

        }


        return $data;
    }

    
    static public function ctrSetearDolar($periodo,$promedioDolar){

        $tabla = 'contable';

        $libro = 'consolidado';

        return ModeloContable::mdlSetearDolar($tabla,$libro,$periodo,$promedioDolar);

    }

    static public function setearDolar(){
                
        if(isset($_POST['btnDolar'])){

            $meses = array('01','02','03','04','05','06','07','08','09','10','11','12');

            foreach ($meses as $key => $value) {
                $desde = "2022-$value-01";
                $date = new DateTime($desde);
                
                // Modificar la fecha al último día del mes
                $date->modify('last day of this month');
                
                // Formatear la fecha para obtener solo el día
                $hasta = $date->format('Y-m-d');
                
                // PRECIO DOLAR
         
                $url = "https://mercados.ambito.com//dolarrava/cl/historico-general/$desde/$hasta";
        
                // Inicializar cURL
                $ch = curl_init();
        
                // Configurar opciones de cURL
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
                // Ejecutar la solicitud
                $response = curl_exec($ch);
           
                // Verificar si hubo errores
                if ($response === false) {
                    $error = curl_error($ch);
                    echo "Error en la solicitud cURL: $error";
                } else {
                    // Decodificar la respuesta JSON
                    $data = json_decode($response, true);
                    $total = 0;
                    $count = 0;
                    // Recorrer el array de resultados y sumar los valores
                    foreach ($data as $key => $result) {
                        
                        if($key != 0){
                            $total += floatval(str_replace(',', '.', $result[1]));
                  
                            $count++;

                        }
                    }
        
                    // Calcular el promedio
                    $dolarPromedio = $total / $count;
                  
                    $respuesta = ControladorContable::ctrSetearDolar($desde,$dolarPromedio);

                }
        
                // Cerrar cURL
                curl_close($ch); 
            }

        }
            
    }

       
    static public function ctrCalcularDolar($periodo){
                
                $date = new DateTime($periodo);
                
                // Modificar la fecha al último día del mes
                $date->modify('last day of this month');
                
                // Formatear la fecha para obtener solo el día
                $hasta = $date->format('Y-m-d');
                
                // PRECIO DOLAR
         
                $url = "https://mercados.ambito.com//dolarrava/cl/historico-general/$periodo/$hasta";
        
                // Inicializar cURL
                $ch = curl_init();
        
                // Configurar opciones de cURL
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
                // Ejecutar la solicitud
                $response = curl_exec($ch);
           
                // Verificar si hubo errores
                if ($response === false) {
                    $error = curl_error($ch);
                    echo "Error en la solicitud cURL: $error";
                } else {
                    // Decodificar la respuesta JSON
                    $data = json_decode($response, true);
                    $total = 0;
                    $count = 0;
                    // Recorrer el array de resultados y sumar los valores
                    foreach ($data as $key => $result) {
                        
                        if($key != 0){
                            $total += floatval(str_replace(',', '.', $result[1]));
                  
                            $count++;

                        }
                    }
        
                    // Calcular el promedio
                    $dolarPromedio = $total / $count;
                  
                }
        
                // Cerrar cURL
                curl_close($ch); 

                return $dolarPromedio;

    }

    
}

    