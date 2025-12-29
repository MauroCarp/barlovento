<?php

require_once "../controladores/trazabilidad.controlador.php";
require_once "../modelos/trazabilidad.modelo.php";

class AjaxTrazabilidadAnimals {

    public function ajaxMostrarAnimalesPaginados() {
        
        $ids = $_POST['ids'];
        $draw = intval($_POST['draw']);
        $start = intval($_POST['start']);
        $length = intval($_POST['length']);
        
        // Obtener TODOS los datos procesados (necesario para la lógica de agrupación)
        $animales = ControladorTrazabilidad::ctrMostrarAnimalesFaenas($ids);
       
        // Procesar todos los datos y convertir a array plano para paginación
        $allProcessedData = $this->processAnimalsData($animales);
        
        // Aplicar paginación al resultado procesado
        $totalRecords = count($allProcessedData);
        $pagedData = array_slice($allProcessedData, $start, $length);
        
        $result = array(
            'data' => $pagedData,
            'total' => $totalRecords
        );
        
        
        $data = array();
        
        // Los datos ya vienen como array plano desde processAnimalsData
        foreach ($pagedData as $row) {
            $data[] = $row;
        }
        
        $response = array(
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        );
        
        echo json_encode($response);
    }

    private function processAnimalsData($animales) {
        $processedData = array();
        
        $rfidOriginal = '';
        if (!empty($animales) && is_array($animales)) {
            foreach ($animales as $rfid => $registros) {
                if (sizeof($registros) === 3) {
                    // Primera fila: combinar datos de [0] y [1] si existen
                    $row0 = isset($registros[0]) ? $registros[0] : [];
                    $row1 = isset($registros[1]) ? $registros[1] : [];
                    $primeraFila = array_merge($row0, $row1);
                    $rfidOriginal = ($primeraFila["rfidOriginal"] != '') ? $primeraFila["rfidOriginal"] : $rfid;

                    $processedData[] = array(
                        htmlspecialchars($rfidOriginal),
                        isset($primeraFila["correlacion"]) ? htmlspecialchars($primeraFila["correlacion"]) : '',
                        isset($primeraFila["garron"]) ? htmlspecialchars($primeraFila["garron"]) : '',
                        isset($primeraFila["kilos"]) ? htmlspecialchars($primeraFila["kilos"]) : '',
                        isset($primeraFila["clasificacionTraza"]) ? htmlspecialchars($primeraFila["clasificacionTraza"]) : '',
                        isset($primeraFila["denominacion"]) ? htmlspecialchars($primeraFila["denominacion"]) : '',
                        isset($primeraFila["tipificacion"]) ? htmlspecialchars($primeraFila["tipificacion"]) : '',
                        isset($primeraFila["gordo"]) ? htmlspecialchars($primeraFila["gordo"]) : '',
                        isset($primeraFila["den"]) ? htmlspecialchars($primeraFila["den"]) : '',
                        isset($primeraFila["mmGrasa"]) ? htmlspecialchars($primeraFila["mmGrasa"]) : '',
                        isset($primeraFila["clasificacion"]) ? htmlspecialchars($primeraFila["clasificacion"]) : '',
                        isset($primeraFila["aob"]) ? htmlspecialchars($primeraFila["aob"]) : '',
                        isset($primeraFila["diferencia"]) ? htmlspecialchars($primeraFila["diferencia"]) : '',
                        isset($primeraFila["kilos_teoricos"]) ? htmlspecialchars($primeraFila["kilos_teoricos"]) : '',
                        isset($primeraFila["caravana"]) ? htmlspecialchars($primeraFila["caravana"]) : '',
                        isset($primeraFila["categoria"]) ? htmlspecialchars($primeraFila["categoria"]) : '',
                        isset($primeraFila["raza"]) ? htmlspecialchars($primeraFila["raza"]) : '',
                        isset($primeraFila["tropa"]) ? htmlspecialchars($primeraFila["tropa"]) : '',
                        isset($primeraFila["clienteDestinoVenta"]) ? htmlspecialchars($primeraFila["clienteDestinoVenta"]) : '',
                        isset($primeraFila["actividad"]) ? htmlspecialchars($primeraFila["actividad"]) : '',
                        isset($primeraFila["kgIngreso"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["kgIngreso"])) : '',
                        isset($primeraFila["kgEgreso"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["kgEgreso"])) : '',
                        isset($primeraFila["kgProducido"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["kgProducido"])) : '',
                        isset($primeraFila["dias"]) ? htmlspecialchars($primeraFila["dias"]) : '',
                        isset($primeraFila["adpv"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["adpv"])) : '',
                        isset($primeraFila["kilosTC"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["kilosTC"])) : '',
                        isset($primeraFila["kilosMS"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["kilosMS"])) : '',
                        isset($primeraFila["convTC"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["convTC"])) : '',
                        isset($primeraFila["convMS"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["convMS"])) : '',
                        isset($primeraFila["costo"]) ? htmlspecialchars(str_replace('.', ',', $primeraFila["costo"])) : '',
                        isset($primeraFila["consignatario"]) ? htmlspecialchars($primeraFila["consignatario"]) : '',
                        isset($primeraFila["proveedor"]) ? htmlspecialchars($primeraFila["proveedor"]) : '',
                        isset($primeraFila["localidad"]) ? htmlspecialchars($primeraFila["localidad"]) : '',
                        isset($primeraFila["provincia"]) ? htmlspecialchars($primeraFila["provincia"]) : '',
                        isset($primeraFila["ingreso"]) ? htmlspecialchars(date('d-m-Y', strtotime($primeraFila["ingreso"]))) : '',
                        isset($primeraFila["salida"]) ? htmlspecialchars(date('d-m-Y', strtotime($primeraFila["salida"]))) : '',
                        isset($primeraFila['transaccionWC']) ? htmlspecialchars($primeraFila['transaccionWC']) : '',
                        isset($primeraFila['corral']) ? htmlspecialchars($primeraFila['corral']) : '',
                        'primera' // Marcador para el estilo
                    );
                    
                    // Segunda fila si existe
                    if (isset($registros[2]) && is_array($registros[2])) {
                        $row2 = $registros[2];
                        $processedData[] = array(
                            '', // RFID vacío para la segunda fila
                            isset($row2["correlacion"]) ? htmlspecialchars($row2["correlacion"]) : '',
                            isset($row2["garron"]) ? htmlspecialchars($row2["garron"]) : '',
                            isset($row2["kilos"]) ? htmlspecialchars($row2["kilos"]) : '',
                            isset($row2["clasificacionTraza"]) ? htmlspecialchars($row2["clasificacionTraza"]) : '',
                            isset($row2["denominacion"]) ? htmlspecialchars($row2["denominacion"]) : '',
                            isset($row2["tipificacion"]) ? htmlspecialchars($row2["tipificacion"]) : '',
                            isset($row2["gordo"]) ? htmlspecialchars($row2["gordo"]) : '',
                            isset($row2["den"]) ? htmlspecialchars($row2["den"]) : '',
                            isset($row2["mmGrasa"]) ? htmlspecialchars($row2["mmGrasa"]) : '',
                            isset($row2["clasificacion"]) ? htmlspecialchars($row2["clasificacion"]) : '',
                            isset($row2["aob"]) ? htmlspecialchars($row2["aob"]) : '',
                            isset($row2["diferencia"]) ? htmlspecialchars($row2["diferencia"]) : '',
                            isset($row2["kilos_teoricos"]) ? htmlspecialchars($row2["kilos_teoricos"]) : '',
                            isset($row2["caravana"]) ? htmlspecialchars($row2["caravana"]) : '',
                            isset($row2["categoria"]) ? htmlspecialchars($row2["categoria"]) : '',
                            isset($row2["raza"]) ? htmlspecialchars($row2["raza"]) : '',
                            isset($row2["tropa"]) ? htmlspecialchars($row2["tropa"]) : '',
                            isset($row2["clienteDestinoVenta"]) ? htmlspecialchars($row2["clienteDestinoVenta"]) : '',
                            isset($row2["actividad"]) ? htmlspecialchars($row2["actividad"]) : '',
                            isset($row2["kgIngreso"]) ? htmlspecialchars(str_replace('.', ',', $row2["kgIngreso"])) : '',
                            isset($row2["kgEgreso"]) ? htmlspecialchars(str_replace('.', ',', $row2["kgEgreso"])) : '',
                            isset($row2["kgProducido"]) ? htmlspecialchars(str_replace('.', ',', $row2["kgProducido"])) : '',
                            isset($row2["dias"]) ? htmlspecialchars($row2["dias"]) : '',
                            isset($row2["adpv"]) ? htmlspecialchars(str_replace('.', ',', $row2["adpv"])) : '',
                            isset($row2["kilosTC"]) ? htmlspecialchars(str_replace('.', ',', $row2["kilosTC"])) : '',
                            isset($row2["kilosMS"]) ? htmlspecialchars(str_replace('.', ',', $row2["kilosMS"])) : '',
                            isset($row2["convTC"]) ? htmlspecialchars(str_replace('.', ',', $row2["convTC"])) : '',
                            isset($row2["convMS"]) ? htmlspecialchars(str_replace('.', ',', $row2["convMS"])) : '',
                            isset($row2["costo"]) ? htmlspecialchars(str_replace('.', ',', $row2["costo"])) : '',
                            isset($row2["consignatario"]) ? htmlspecialchars($row2["consignatario"]) : '',
                            isset($row2["proveedor"]) ? htmlspecialchars($row2["proveedor"]) : '',
                            isset($row2["localidad"]) ? htmlspecialchars($row2["localidad"]) : '',
                            isset($row2["provincia"]) ? htmlspecialchars($row2["provincia"]) : '',
                            isset($row2["ingreso"]) ? htmlspecialchars(date('d-m-Y', strtotime($row2["ingreso"]))) : '',
                            isset($row2["salida"]) ? htmlspecialchars(date('d-m-Y', strtotime($row2["salida"]))) : '',
                            isset($row2['transaccionWC']) ? htmlspecialchars($row2['transaccionWC']) : '',
                            isset($row2['corral']) ? htmlspecialchars($row2['corral']) : '',
                            'segunda' // Marcador para el estilo
                        );
                    }
                } else {
                    // Manejo de otros casos
                    for ($i = 0; $i < count($registros); $i++) {
                        $rowX = $registros[$i];
                        if (is_array($rowX)) {
                            $processedData[] = array(
                                $rfidOriginal,
                                isset($rowX["correlacion"]) ? htmlspecialchars($rowX["correlacion"]) : '',
                                isset($rowX["garron"]) ? htmlspecialchars($rowX["garron"]) : '',
                                isset($rowX["kilos"]) ? htmlspecialchars($rowX["kilos"]) : '',
                                isset($rowX["clasificacionTraza"]) ? htmlspecialchars($rowX["clasificacionTraza"]) : '',
                                isset($rowX["denominacion"]) ? htmlspecialchars($rowX["denominacion"]) : '',
                                isset($rowX["tipificacion"]) ? htmlspecialchars($rowX["tipificacion"]) : '',
                                isset($rowX["gordo"]) ? htmlspecialchars($rowX["gordo"]) : '',
                                isset($rowX["den"]) ? htmlspecialchars($rowX["den"]) : '',
                                isset($rowX["mmGrasa"]) ? htmlspecialchars($rowX["mmGrasa"]) : '',
                                isset($rowX["clasificacion"]) ? htmlspecialchars($rowX["clasificacion"]) : '',
                                isset($rowX["aob"]) ? htmlspecialchars($rowX["aob"]) : '',
                                isset($rowX["diferencia"]) ? htmlspecialchars($rowX["diferencia"]) : '',
                                isset($rowX["kilos_teoricos"]) ? htmlspecialchars($rowX["kilos_teoricos"]) : '',
                                isset($rowX["caravana"]) ? htmlspecialchars($rowX["caravana"]) : '',
                                isset($rowX["categoria"]) ? htmlspecialchars($rowX["categoria"]) : '',
                                isset($rowX["raza"]) ? htmlspecialchars($rowX["raza"]) : '',
                                isset($rowX["tropa"]) ? htmlspecialchars($rowX["tropa"]) : '',
                                isset($rowX["clienteDestinoVenta"]) ? htmlspecialchars($rowX["clienteDestinoVenta"]) : '',
                                isset($rowX["actividad"]) ? htmlspecialchars($rowX["actividad"]) : '',
                                isset($rowX["kgIngreso"]) ? htmlspecialchars(str_replace('.', ',', $rowX["kgIngreso"])) : '',
                                isset($rowX["kgEgreso"]) ? htmlspecialchars(str_replace('.', ',', $rowX["kgEgreso"])) : '',
                                isset($rowX["kgProducido"]) ? htmlspecialchars(str_replace('.', ',', $rowX["kgProducido"])) : '',
                                isset($rowX["dias"]) ? htmlspecialchars($rowX["dias"]) : '',
                                isset($rowX["adpv"]) ? htmlspecialchars(str_replace('.', ',', $rowX["adpv"])) : '',
                                isset($rowX["kilosTC"]) ? htmlspecialchars(str_replace('.', ',', $rowX["kilosTC"])) : '',
                                isset($rowX["kilosMS"]) ? htmlspecialchars(str_replace('.', ',', $rowX["kilosMS"])) : '',
                                isset($rowX["convTC"]) ? htmlspecialchars(str_replace('.', ',', $rowX["convTC"])) : '',
                                isset($rowX["convMS"]) ? htmlspecialchars(str_replace('.', ',', $rowX["convMS"])) : '',
                                isset($rowX["costo"]) ? htmlspecialchars(str_replace('.', ',', $rowX["costo"])) : '',
                                isset($rowX["consignatario"]) ? htmlspecialchars($rowX["consignatario"]) : '',
                                isset($rowX["proveedor"]) ? htmlspecialchars($rowX["proveedor"]) : '',
                                isset($rowX["localidad"]) ? htmlspecialchars($rowX["localidad"]) : '',
                                isset($rowX["provincia"]) ? htmlspecialchars($rowX["provincia"]) : '',
                                isset($rowX["ingreso"]) ? htmlspecialchars(date('d-m-Y', strtotime($rowX["ingreso"]))) : '',
                                isset($rowX["salida"]) ? htmlspecialchars(date('d-m-Y', strtotime($rowX["salida"]))) : '',
                                isset($rowX['transaccionWC']) ? htmlspecialchars($rowX['transaccionWC']) : '',
                                isset($rowX['corral']) ? htmlspecialchars($rowX['corral']) : '',
                                'otros' // Marcador para el estilo
                            );
                        }
                    }
                }
            }
        }
        return $processedData;
    }

    public function ajaxExportarTodos() {
        $ids = $_POST['ids'];
        
        // Obtener TODOS los datos sin paginación
        $animales = ControladorTrazabilidad::ctrMostrarAnimalesFaenas($ids);
        
        // Procesar todos los datos
        $allProcessedData = $this->processAnimalsData($animales);
        
        echo json_encode($allProcessedData);
    }
}

if (isset($_POST['action'])) {
    $ajax = new AjaxTrazabilidadAnimals();
    
    if ($_POST['action'] == 'mostrarAnimalesPaginados') {
        $ajax->ajaxMostrarAnimalesPaginados();
    } elseif ($_POST['action'] == 'exportarTodos') {
        $ajax->ajaxExportarTodos();
    }
}

?>