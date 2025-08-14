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

$hoja->mergeCells('A1:F1');
$hoja->mergeCells('G1:H1');
$hoja->mergeCells('A2:C2');
$hoja->setCellValue('A1', 'Reporte Principal Trazabilidad')
     ->setCellValue('G1', )
     ->setCellValue('A2', $nombre . ' | ' . $fecha)
     ->setCellValue('A3', 'Caravana')
     ->setCellValue('B3', 'Garrón')
     ->setCellValue('C3', 'Peso Vivo')
     ->setCellValue('D3', 'Ecografía')
     ->setCellValue('E3', 'Peso Media')
     ->mergeCells('F3:G3')
     ->setCellValue('F3', 'Tipificación')
     ->setCellValue('H3', 'Conversión')
     ->setCellValue('I3', 'Proveedor');

     $hoja->setCellValue('A1', 'Texto en negrita');

$estiloTitulo = array(
    'font' => array(
        'bold' => true,   // Negrita
        'size' => 16,     // Tamaño de fuente
        'name' => 'Calibri' // Nombre de la fuente
    )
);

$estiloThead= array(
    'font' => array(
        'bold' => true,   // Negrita
        'size' => 12,     // Tamaño de fuente
        'name' => 'Calibri' // Nombre de la fuente
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Alineación horizontal al centro
    )
);

// Aplicar el estilo de fuente a la celda A1
$hoja->getStyle('A1')->applyFromArray($estiloTitulo);
$hoja->getStyle('A2')->applyFromArray($estiloTitulo);
$hoja->getStyle('A3')->applyFromArray($estiloThead); 
$hoja->getStyle('B3')->applyFromArray($estiloThead); 
$hoja->getStyle('C3')->applyFromArray($estiloThead); 
$hoja->getStyle('D3')->applyFromArray($estiloThead); 
$hoja->getStyle('E3')->applyFromArray($estiloThead); 
$hoja->getStyle('F3')->applyFromArray($estiloThead); 
$hoja->getStyle('H3')->applyFromArray($estiloThead); 
$hoja->getStyle('I3')->applyFromArray($estiloThead); 

$index = 4;

foreach ($data['animales'] as $value) {
    
    $hoja->setCellValue('A' . $index, $value['rfidTD'])
         ->setCellValue('B' . $index, $value['garron'])
         ->setCellValue('C' . $index, $value['kgEgreso'])
         ->setCellValue('D' . $index, $value['clasificacion'])
         ->setCellValue('E' . $index, $value['kilos'])
         ->setCellValue('F' . $index, $value['tipificacion'])
         ->setCellValue('G' . $index, $value['gordo'])
         ->setCellValue('H' . $index, $value['convMS'])
         ->setCellValue('I' . $index, $value['proveedor']);

    $index++;
}

$hoja->calculateColumnWidths();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte Principal Trazabilidad.xlsx"');
header('Cache-Control: max-age=0');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
