<?php

ini_set('display_errors', 0);

require_once 'Classes/PHPExcel.php';
require_once "../../controladores/trazabilidad.controlador.php";
require_once "../../modelos/trazabilidad.modelo.php";

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Barlovento SRL")
							 ->setTitle("Reporte Principal Trazabilidad");


$idFaena = $_GET['idFaena'];

$data = ControladorTrazabilidad::ctrDataReporte1($idFaena);

$nombre = $data['faena']['nombre'];

$fecha = date('d-m-Y',strtotime($data['faena']['fecha']));

$hoja = $objPHPExcel->setActiveSheetIndex(0);

$estiloTrazabilidad= array(
     'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
          'color' => array('rgb' => '94c5fd'), // Color de fondo en formato RGB
      )
 );
$estiloWC= array(
     'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
          'color' => array('rgb' => 'f7fd94'), // Color de fondo en formato RGB
      )
 );
$estiloTD= array(
     'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
          'color' => array('rgb' => 'd594fd'), // Color de fondo en formato RGB
      )
 );

 
$hoja->setCellValue('A1', 'Caravana')
     ->setCellValue('B1', 'Correl.')
     ->setCellValue('C1', 'Garrón')
     ->setCellValue('D1', 'Kilos')
     ->setCellValue('E1', 'Denominacion')
     ->setCellValue('F1', 'Tipif.')
     ->setCellValue('G1', 'Gord.')
     ->setCellValue('H1', 'Den')
     
     ->setCellValue('I1', 'Tropas')
     ->setCellValue('J1', 'RFID')
     ->setCellValue('K1', 'Caravana')
     ->setCellValue('L1', 'Categoria')
     ->setCellValue('M1', 'Raza')
     ->setCellValue('N1', 'Estado')
     ->setCellValue('O1', 'F.Ingreso')
     ->setCellValue('P1', 'F. Salida')
     ->setCellValue('Q1', 'kg Ingreso')
     ->setCellValue('R1', 'Kg Engreso')
     ->setCellValue('S1', 'Kg Producido')
     ->setCellValue('T1', 'Dias')
     ->setCellValue('U1', 'ADPV')
     ->setCellValue('V1', 'Conv TC')
     ->setCellValue('W1', 'Conv MS')
     ->setCellValue('X1', 'Kilos TC')
     ->setCellValue('Y1', 'Kilos MS')
     ->setCellValue('Z1', 'Costo')
     ->setCellValue('AA1', 'Proveedor')
     ->setCellValue('AB1', 'Provincias')
     ->setCellValue('AC1', 'Localidad')
     ->setCellValue('AD1', 'Transaccion WC')
     ->setCellValue('AE1', 'Cliente Destino Venta')
     ->setCellValue('AF1', 'Corral')
     
     ->setCellValue('AG1', 'Fecha')
     ->setCellValue('AH1', 'RFID')
     ->setCellValue('AI1', 'mm Grasa')
     ->setCellValue('AJ1', 'Peso')
     ->setCellValue('AK1', 'Sexo')
     ->setCellValue('AL1', 'Clasificacion')
     ->setCellValue('AM1', 'AOB')
     ->setCellValue('AN1', 'Ref. Eco');

$hoja->getStyle('A1:H1')->applyFromArray($estiloTrazabilidad);
$hoja->getStyle('I1:AF1')->applyFromArray($estiloWC);
$hoja->getStyle('AG1:AN1')->applyFromArray($estiloTD);


$index = 2;

foreach ($data['animales'] as $value) {
    
     if($temp != $value['rfidTrazabilidad']){

          $hoja->setCellValue('A' . $index, $value['rfidTrazabilidad']);

     }

     $hoja->setCellValue('B' . $index, $value['correlacion'])
         ->setCellValue('C' . $index, $value['garron'])
         ->setCellValue('D' . $index, $value['kilos'])
         ->setCellValue('E' . $index, $value['denominacion'])
         ->setCellValue('F' . $index, $value['tipificacion'])
         ->setCellValue('G' . $index, $value['gordo'])
         ->setCellValue('H' . $index, $value['den']);
     
     if($temp != $value['rfidTrazabilidad']){

          if(!is_null($value['fechaTD'])){

               $fechaTD = explode('-',$value['fechaTD']);
               $fechaTD = $fechaTD[2] . '/' . $fechaTD[1] . '/' . $fechaTD[0];

               $fechaIngreso = explode('-',$value['ingreso']);
               $fechaIngreso = $fechaIngreso[2] . '/' . $fechaIngreso[1] . '/' . $fechaIngreso[0];

               $fechaSalida = explode('-',$value['salida']);
               $fechaSalida = $fechaSalida[2] . '/' . $fechaSalida[1] . '/' . $fechaSalida[0];

          }else{

               $fechaTD = '-';
               $fechaIngreso = '-';
               $fechaSalida = '-';

          } 
          

          $hoja->setCellValue('I' . $index, $value['tropa'])
              ->setCellValue('J' . $index, $value['rfid'])
              ->setCellValue('K' . $index, $value['caravana'])
              ->setCellValue('L' . $index, $value['categoria'])
              ->setCellValue('M' . $index, $value['raza'])
              ->setCellValue('N' . $index, $value['estado'])
              ->setCellValue('O' . $index, $fechaIngreso)
              ->setCellValue('P' . $index, $fechaSalida)
              ->setCellValue('Q' . $index, $value['kgIngreso'])
              ->setCellValue('R' . $index, $value['kgEgreso'])
              ->setCellValue('S' . $index, $value['kgProducido'])
              ->setCellValue('T' . $index, $value['dias'])
              ->setCellValue('U' . $index, $value['adpv'])
              ->setCellValue('V' . $index, $value['convTC'])
              ->setCellValue('W' . $index, $value['convMS'])
              ->setCellValue('X' . $index, $value['kilosTC'])
              ->setCellValue('Y' . $index, $value['kilosMS'])
              ->setCellValue('Z' . $index, $value['costo'])
              ->setCellValue('AA' . $index, $value['proveedor'])
              ->setCellValue('AB' . $index, $value['provincia'])
              ->setCellValue('AC' . $index, $value['localidad'])
              ->setCellValue('AD' . $index, $value['transaccionWC'])
              ->setCellValue('AE' . $index, $value['clienteDestinoVenta'])
              ->setCellValue('AF' . $index, $value['corral'])
     
              ->setCellValue('AG'  . $index, $fechaTD)
              ->setCellValue('AH'  . $index, $value['rfidTD'])
              ->setCellValue('AI'  . $index, $value['mmGrasa'])
              ->setCellValue('AJ'  . $index, $value['peso'])
              ->setCellValue('AK'  . $index, $value['sexo'])
              ->setCellValue('AL'  . $index, $value['clasificacion'])
              ->setCellValue('AM'  . $index, $value['aob'])
              ->setCellValue('AN'  . $index, $value['refEco']);
     }

     $temp = $value['rfidTrazabilidad'];

     $index++;

}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte Secundario Trazabilidad.xlsx"');
header('Cache-Control: max-age=0');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
