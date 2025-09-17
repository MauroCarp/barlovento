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
        
        if (!empty($animales) && is_array($animales)) {
            foreach ($animales as $rfid => $registros) {
                if (sizeof($registros) === 3) {
                    // Primera fila: combinar datos de [0] y [1] si existen
                    $row0 = isset($registros[0]) ? $registros[0] : [];
                    $row1 = isset($registros[1]) ? $registros[1] : [];
                    $primeraFila = array_merge($row0, $row1);
                    
                    $processedData[] = array(
                        htmlspecialchars($rfid),
                        isset($primeraFila["correlacion"]) ? htmlspecialchars($primeraFila["correlacion"]) : '',
                        isset($primeraFila["garron"]) ? htmlspecialchars($primeraFila["garron"]) : '',
                        isset($primeraFila["diferencia"]) ? htmlspecialchars($primeraFila["diferencia"]) : '',
                        isset($primeraFila["kilos_teoricos"]) ? htmlspecialchars($primeraFila["kilos_teoricos"]) : '',
                        isset($primeraFila["kilos"]) ? htmlspecialchars($primeraFila["kilos"]) : '',
                        isset($primeraFila["gordo"]) ? htmlspecialchars($primeraFila["gordo"]) : '',
                        isset($primeraFila["denominacion"]) ? htmlspecialchars($primeraFila["denominacion"]) : '',
                        isset($primeraFila["caravana"]) ? htmlspecialchars($primeraFila["caravana"]) : '',
                        isset($primeraFila["categoria"]) ? htmlspecialchars($primeraFila["categoria"]) : '',
                        isset($primeraFila["raza"]) ? htmlspecialchars($primeraFila["raza"]) : '',
                        isset($primeraFila["tropa"]) ? htmlspecialchars($primeraFila["tropa"]) : '',
                        isset($primeraFila["clienteDestinoVenta"]) ? htmlspecialchars($primeraFila["clienteDestinoVenta"]) : '',
                        isset($primeraFila["actividad"]) ? htmlspecialchars($primeraFila["actividad"]) : '',
                        isset($primeraFila["kgIngreso"]) ? htmlspecialchars($primeraFila["kgIngreso"]) : '',
                        isset($primeraFila["kgEgreso"]) ? htmlspecialchars($primeraFila["kgEgreso"]) : '',
                        isset($primeraFila["kgProducido"]) ? htmlspecialchars($primeraFila["kgProducido"]) : '',
                        isset($primeraFila["dias"]) ? htmlspecialchars($primeraFila["dias"]) : '',
                        isset($primeraFila["adpv"]) ? htmlspecialchars($primeraFila["adpv"]) : '',
                        isset($primeraFila["kilosTC"]) ? htmlspecialchars($primeraFila["kilosTC"]) : '',
                        isset($primeraFila["kilosMS"]) ? htmlspecialchars($primeraFila["kilosMS"]) : '',
                        isset($primeraFila["convTC"]) ? htmlspecialchars($primeraFila["convTC"]) : '',
                        isset($primeraFila["convMS"]) ? htmlspecialchars($primeraFila["convMS"]) : '',
                        isset($primeraFila["costo"]) ? htmlspecialchars($primeraFila["costo"]) : '',
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
                            isset($row2["diferencia"]) ? htmlspecialchars($row2["diferencia"]) : '',
                            isset($row2["kilos_teoricos"]) ? htmlspecialchars($row2["kilos_teoricos"]) : '',
                            isset($row2["kilos"]) ? htmlspecialchars($row2["kilos"]) : '',
                            isset($row2["gordo"]) ? htmlspecialchars($row2["gordo"]) : '',
                            isset($row2["denominacion"]) ? htmlspecialchars($row2["denominacion"]) : '',
                            isset($row2["caravana"]) ? htmlspecialchars($row2["caravana"]) : '',
                            isset($row2["categoria"]) ? htmlspecialchars($row2["categoria"]) : '',
                            isset($row2["raza"]) ? htmlspecialchars($row2["raza"]) : '',
                            isset($row2["tropa"]) ? htmlspecialchars($row2["tropa"]) : '',
                            isset($row2["clienteDestinoVenta"]) ? htmlspecialchars($row2["clienteDestinoVenta"]) : '',
                            isset($row2["actividad"]) ? htmlspecialchars($row2["actividad"]) : '',
                            isset($row2["kgIngreso"]) ? htmlspecialchars($row2["kgIngreso"]) : '',
                            isset($row2["kgEgreso"]) ? htmlspecialchars($row2["kgEgreso"]) : '',
                            isset($row2["kgProducido"]) ? htmlspecialchars($row2["kgProducido"]) : '',
                            isset($row2["dias"]) ? htmlspecialchars($row2["dias"]) : '',
                            isset($row2["adpv"]) ? htmlspecialchars($row2["adpv"]) : '',
                            isset($row2["kilosTC"]) ? htmlspecialchars($row2["kilosTC"]) : '',
                            isset($row2["kilosMS"]) ? htmlspecialchars($row2["kilosMS"]) : '',
                            isset($row2["convTC"]) ? htmlspecialchars($row2["convTC"]) : '',
                            isset($row2["convMS"]) ? htmlspecialchars($row2["convMS"]) : '',
                            isset($row2["costo"]) ? htmlspecialchars($row2["costo"]) : '',
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
                                $rfid,
                                isset($rowX["correlacion"]) ? htmlspecialchars($rowX["correlacion"]) : '',
                                isset($rowX["garron"]) ? htmlspecialchars($rowX["garron"]) : '',
                                isset($rowX["diferencia"]) ? htmlspecialchars($rowX["diferencia"]) : '',
                                isset($rowX["kilos_teoricos"]) ? htmlspecialchars($rowX["kilos_teoricos"]) : '',
                                isset($rowX["kilos"]) ? htmlspecialchars($rowX["kilos"]) : '',
                                isset($rowX["gordo"]) ? htmlspecialchars($rowX["gordo"]) : '',
                                isset($rowX["denominacion"]) ? htmlspecialchars($rowX["denominacion"]) : '',
                                isset($rowX["caravana"]) ? htmlspecialchars($rowX["caravana"]) : '',
                                isset($rowX["categoria"]) ? htmlspecialchars($rowX["categoria"]) : '',
                                isset($rowX["raza"]) ? htmlspecialchars($rowX["raza"]) : '',
                                isset($rowX["tropa"]) ? htmlspecialchars($rowX["tropa"]) : '',
                                isset($rowX["clienteDestinoVenta"]) ? htmlspecialchars($rowX["clienteDestinoVenta"]) : '',
                                isset($rowX["actividad"]) ? htmlspecialchars($rowX["actividad"]) : '',
                                isset($rowX["kgIngreso"]) ? htmlspecialchars($rowX["kgIngreso"]) : '',
                                isset($rowX["kgEgreso"]) ? htmlspecialchars($rowX["kgEgreso"]) : '',
                                isset($rowX["kgProducido"]) ? htmlspecialchars($rowX["kgProducido"]) : '',
                                isset($rowX["dias"]) ? htmlspecialchars($rowX["dias"]) : '',
                                isset($rowX["adpv"]) ? htmlspecialchars($rowX["adpv"]) : '',
                                isset($rowX["kilosTC"]) ? htmlspecialchars($rowX["kilosTC"]) : '',
                                isset($rowX["kilosMS"]) ? htmlspecialchars($rowX["kilosMS"]) : '',
                                isset($rowX["convTC"]) ? htmlspecialchars($rowX["convTC"]) : '',
                                isset($rowX["convMS"]) ? htmlspecialchars($rowX["convMS"]) : '',
                                isset($rowX["costo"]) ? htmlspecialchars($rowX["costo"]) : '',
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
}

if (isset($_POST['action']) && $_POST['action'] == 'mostrarAnimalesPaginados') {
    $ajax = new AjaxTrazabilidadAnimals();
    $ajax->ajaxMostrarAnimalesPaginados();
}

?>