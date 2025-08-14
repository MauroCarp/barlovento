<?php
$ids = isset($_GET['ids']) ? $_GET['ids'] : '';

?>  

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Trazabilidad
      
      <small>Panel de Control</small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Trazabilidad</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-body">
          
        <div class="row">

          <div class="col-lg-12">

            <div class="box box-info">

              <div class="box-header with-border">

                <h3 class="box-title">Registro de Animales - </h3>

              </div>

              <div class="box-body">
                <div style="overflow-x:auto;">
                  
                  <table class="table table-bordered table-striped dt-responsive tablas tablaFaenas">
                    <thead>
                      <tr>
                        <th>RFID</th>
                        <th>Correl</th>
                        <th>Garron</th>
                        <th>% Diferencia T vs R</th>
                        <th>Kilos teoricos</th>
                        <th>Kilos</th>
                        <th>Clasif.</th>
                        <th>Denominacion</th>
                        <th>Caravana Visual</th>
                        <th>Categoria</th>
                        <th>Raza</th>
                        <th>Tropa</th>
                        <th>Destino Venta</th>
                        <th>Actividad</th>
                        <th>Kilos Ingresados</th>
                        <th>Kilos Salidos</th>
                        <th>Kilos Producidos</th>
                        <th>Dias</th>
                        <th>ADPV</th>
                        <th>Total Kg TC</th>
                        <th>Total Kg MS</th>
                        <th>Conversion TC</th>
                        <th>Conversion MS</th>
                        <th>Costo Producir 1 KG</th>
                        <th>Consignatario</th>
                        <th>Proveedor</th>
                        <th>Localidad</th>
                        <th>Provincia</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Salida</th>
                        <th>Transaccion</th>
                        <th>Corral</th>
                      </tr>
                    </thead>
                    <tbody id="tablaAnimalesBody">
                      <?php
                      $animales = ControladorTrazabilidad::ctrMostrarAnimalesFaenas($ids);
                    
                      if (!empty($animales) && is_array($animales)) {

                        $registrosAgrupados = '';
                        $sinRegistros = '';

                        foreach ($animales as $rfid => $registros) {
                         
                          if(sizeof($registros) === 3) {
                            
                            // Primera fila: combinar datos de [0] y [1] si existen
                            $row0 = isset($registros[0]) ? $registros[0] : [];
                            $row1 = isset($registros[1]) ? $registros[1] : [];

                            // Mezclar datos de [0] y [1] (row1 sobrescribe row0 en caso de conflicto)
                            $primeraFila = array_merge($row0, $row1);
                            $registrosAgrupados .= '<tr style="background-color:rgba(255, 246, 121, 0.38);">
                                                      <td>' . htmlspecialchars($rfid) . '</td>
                                                      <td>' . (isset($primeraFila["correlacion"]) ? htmlspecialchars($primeraFila["correlacion"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["garron"]) ? htmlspecialchars($primeraFila["garron"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["diferencia"]) ? htmlspecialchars($primeraFila["diferencia"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["kilos_teoricos"]) ? htmlspecialchars($primeraFila["kilos_teoricos"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["kilos"]) ? htmlspecialchars($primeraFila["kilos"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["gordo"]) ? htmlspecialchars($primeraFila["gordo"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["denominacion"]) ? htmlspecialchars($primeraFila["denominacion"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["caravana"]) ? htmlspecialchars($primeraFila["caravana"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["categoria"]) ? htmlspecialchars($primeraFila["categoria"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["raza"]) ? htmlspecialchars($primeraFila["raza"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["tropa"]) ? htmlspecialchars($primeraFila["tropa"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["clienteDestinoVenta"]) ? htmlspecialchars($primeraFila["clienteDestinoVenta"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["actividad"]) ? htmlspecialchars($primeraFila["actividad"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["kgIngreso"]) ? htmlspecialchars($primeraFila["kgIngreso"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["kgEgreso"]) ? htmlspecialchars($primeraFila["kgEgreso"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["kgProducido"]) ? htmlspecialchars($primeraFila["kgProducido"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["dias"]) ? htmlspecialchars($primeraFila["dias"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["adpv"]) ? htmlspecialchars($primeraFila["adpv"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["kilosTC"]) ? htmlspecialchars($primeraFila["kilosTC"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["kilosMS"]) ? htmlspecialchars($primeraFila["kilosMS"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["convTC"]) ? htmlspecialchars($primeraFila["convTC"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["convMS"]) ? htmlspecialchars($primeraFila["convMS"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["costo"]) ? htmlspecialchars($primeraFila["costo"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["consignatario"]) ? htmlspecialchars($primeraFila["consignatario"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["proveedor"]) ? htmlspecialchars($primeraFila["proveedor"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["localidad"]) ? htmlspecialchars($primeraFila["localidad"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["provincia"]) ? htmlspecialchars($primeraFila["provincia"]) : '') . '</td>
                                                      <td>' . (isset($primeraFila["ingreso"]) ? htmlspecialchars(date('d-m-Y', strtotime($primeraFila["ingreso"]))) : '') . '</td>
                                                      <td>' . (isset($primeraFila["salida"]) ? htmlspecialchars(date('d-m-Y', strtotime($primeraFila["salida"]))) : '') . '</td>
                                                      <td>' . (isset($primeraFila['transaccionWC']) ? htmlspecialchars($primeraFila['transaccionWC']) : '') . '</td>
                                                      <td>' . (isset($primeraFila['corral']) ? htmlspecialchars($primeraFila['corral']) : '') . '</td>
                                                    </tr>';

                            // Segunda fila: si existe el índice 2, mostrar sólo los campos que correspondan
                            if (isset($registros[2]) && is_array($registros[2])) {
                              $row2 = $registros[2];

                              $registrosAgrupados .= 
                              '<tr style="background-color:rgba(44, 187, 212, 0.38);">
                                <td></td>
                                <td>' . (isset($row2["correlacion"]) ? htmlspecialchars($row2["correlacion"]) : '') . '</td>
                                <td>' . (isset($row2["garron"]) ? htmlspecialchars($row2["garron"]) : '') . '</td>
                                <td>' . (isset($row2["diferencia"]) ? htmlspecialchars($row2["diferencia"]) : '') . '</td>
                                <td>' . (isset($row2["kilos_teoricos"]) ? htmlspecialchars($row2["kilos_teoricos"]) : '') . '</td>
                                <td>' . (isset($row2["kilos"]) ? htmlspecialchars($row2["kilos"]) : '') . '</td>
                                <td>' . (isset($row2["gordo"]) ? htmlspecialchars($row2["gordo"]) : '') . '</td>
                                <td>' . (isset($row2["denominacion"]) ? htmlspecialchars($row2["denominacion"]) : '') . '</td>
                                <td>' . (isset($row2["caravana"]) ? htmlspecialchars($row2["caravana"]) : '') . '</td>
                                <td>' . (isset($row2["categoria"]) ? htmlspecialchars($row2["categoria"]) : '') . '</td>
                                <td>' . (isset($row2["raza"]) ? htmlspecialchars($row2["raza"]) : '') . '</td>
                                <td>' . (isset($row2["tropa"]) ? htmlspecialchars($row2["tropa"]) : '') . '</td>
                                <td>' . (isset($row2["clienteDestinoVenta"]) ? htmlspecialchars($row2["clienteDestinoVenta"]) : '') . '</td>
                                <td>' . (isset($row2["actividad"]) ? htmlspecialchars($row2["actividad"]) : '') . '</td>
                                <td>' . (isset($row2["kgIngreso"]) ? htmlspecialchars($row2["kgIngreso"]) : '') . '</td>
                                <td>' . (isset($row2["kgEgreso"]) ? htmlspecialchars($row2["kgEgreso"]) : '') . '</td>
                                <td>' . (isset($row2["kgProducido"]) ? htmlspecialchars($row2["kgProducido"]) : '') . '</td>
                                <td>' . (isset($row2["dias"]) ? htmlspecialchars($row2["dias"]) : '') . '</td>
                                <td>' . (isset($row2["adpv"]) ? htmlspecialchars($row2["adpv"]) : '') . '</td>
                                <td>' . (isset($row2["kilosTC"]) ? htmlspecialchars($row2["kilosTC"]) : '') . '</td>
                                <td>' . (isset($row2["kilosMS"]) ? htmlspecialchars($row2["kilosMS"]) : '') . '</td>
                                <td>' . (isset($row2["convTC"]) ? htmlspecialchars($row2["convTC"]) : '') . '</td>
                                <td>' . (isset($row2["convMS"]) ? htmlspecialchars($row2["convMS"]) : '') . '</td>
                                <td>' . (isset($row2["costo"]) ? htmlspecialchars($row2["costo"]) : '') . '</td>
                                <td>' . (isset($row2["consignatario"]) ? htmlspecialchars($row2["consignatario"]) : '') . '</td>
                                <td>' . (isset($row2["proveedor"]) ? htmlspecialchars($row2["proveedor"]) : '') . '</td>
                                <td>' . (isset($row2["localidad"]) ? htmlspecialchars($row2["localidad"]) : '') . '</td>
                                <td>' . (isset($row2["provincia"]) ? htmlspecialchars($row2["provincia"]) : '') . '</td>
                                <td>' . (isset($row2["ingreso"]) ? htmlspecialchars(date('d-m-Y', strtotime($row2["ingreso"]))) : '') . '</td>
                                <td>' . (isset($row2["salida"]) ? htmlspecialchars(date('d-m-Y', strtotime($row2["salida"]))) : '') . '</td>
                                <td>' . (isset($row2['transaccionWC']) ? htmlspecialchars($row2['transaccionWC']) : '') . '</td>
                                <td>' . (isset($row2['corral']) ? htmlspecialchars($row2['corral']) : '') . '</td>
                              </tr>';
                            }
                          } else {

                            // Si hay más de 3 arrays internos, puedes agregar lógica similar para los índices 3, 4, etc.
                              for ($i = 3; $i < count($registros); $i++) {
                                $rowX = $registros[$i];
                                if (is_array($rowX)) {
                                  $sinRegistros .= '<tr style="background-color:rgba(116, 25, 25, 0.38);"> 
                                                    <td> Sin registro </td>
                                                    <td>' . (isset($rowX["correlacion"]) ? htmlspecialchars($rowX["correlacion"]) : '') . '</td>
                                                    <td>' . (isset($rowX["garron"]) ? htmlspecialchars($rowX["garron"]) : '') . '</td>
                                                    <td>' . (isset($rowX["diferencia"]) ? htmlspecialchars($rowX["diferencia"]) : '') . '</td>
                                                    <td>' . (isset($rowX["kilos_teoricos"]) ? htmlspecialchars($rowX["kilos_teoricos"]) : '') . '</td>
                                                    <td>' . (isset($rowX["kilos"]) ? htmlspecialchars($rowX["kilos"]) : '') . '</td>
                                                    <td>' . (isset($rowX["gordo"]) ? htmlspecialchars($rowX["gordo"]) : '') . '</td>
                                                    <td>' . (isset($rowX["denominacion"]) ? htmlspecialchars($rowX["denominacion"]) : '') . '</td>
                                                    <td>' . (isset($rowX["caravana"]) ? htmlspecialchars($rowX["caravana"]) : '') . '</td>
                                                    <td>' . (isset($rowX["categoria"]) ? htmlspecialchars($rowX["categoria"]) : '') . '</td>
                                                    <td>' . (isset($rowX["raza"]) ? htmlspecialchars($rowX["raza"]) : '') . '</td>
                                                    <td>' . (isset($rowX["tropa"]) ? htmlspecialchars($rowX["tropa"]) : '') . '</td>
                                                    <td>' . (isset($rowX["clienteDestinoVenta"]) ? htmlspecialchars($rowX["clienteDestinoVenta"]) : '') . '</td>
                                                    <td>' . (isset($rowX["actividad"]) ? htmlspecialchars($rowX["actividad"]) : '') . '</td>
                                                    <td>' . (isset($rowX["kgIngreso"]) ? htmlspecialchars($rowX["kgIngreso"]) : '') . '</td>
                                                    <td>' . (isset($rowX["kgEgreso"]) ? htmlspecialchars($rowX["kgEgreso"]) : '') . '</td>
                                                    <td>' . (isset($rowX["kgProducido"]) ? htmlspecialchars($rowX["kgProducido"]) : '') . '</td>
                                                    <td>' . (isset($rowX["dias"]) ? htmlspecialchars($rowX["dias"]) : '') . '</td>
                                                    <td>' . (isset($rowX["adpv"]) ? htmlspecialchars($rowX["adpv"]) : '') . '</td>
                                                    <td>' . (isset($rowX["kilosTC"]) ? htmlspecialchars($rowX["kilosTC"]) : '') . '</td>
                                                    <td>' . (isset($rowX["kilosMS"]) ? htmlspecialchars($rowX["kilosMS"]) : '') . '</td>
                                                    <td>' . (isset($rowX["convTC"]) ? htmlspecialchars($rowX["convTC"]) : '') . '</td>
                                                    <td>' . (isset($rowX["convMS"]) ? htmlspecialchars($rowX["convMS"]) : '') . '</td>
                                                    <td>' . (isset($rowX["costo"]) ? htmlspecialchars($rowX["costo"]) : '') . '</td>
                                                    <td>' . (isset($rowX["consignatario"]) ? htmlspecialchars($rowX["consignatario"]) : '') . '</td>
                                                    <td>' . (isset($rowX["proveedor"]) ? htmlspecialchars($rowX["proveedor"]) : '') . '</td>
                                                    <td>' . (isset($rowX["localidad"]) ? htmlspecialchars($rowX["localidad"]) : '') . '</td>
                                                    <td>' . (isset($rowX["provincia"]) ? htmlspecialchars($rowX["provincia"]) : '') . '</td>
                                                    <td>' . (isset($rowX["ingreso"]) ? htmlspecialchars(date('d-m-Y', strtotime($rowX["ingreso"]))) : '') . '</td>
                                                    <td>' . (isset($rowX["salida"]) ? htmlspecialchars(date('d-m-Y', strtotime($rowX["salida"]))) : '') . '</td>
                                                    <td>' . (isset($rowX['transaccionWC']) ? htmlspecialchars($rowX['transaccionWC']) : '') . '</td>
                                                    <td>' . (isset($rowX['corral']) ? htmlspecialchars($rowX['corral']) : '') . '</td>
                                                  </tr>';
                                }
                              
                            }

                          }
                 
                        }
                         
                        if (!empty($registrosAgrupados)) {
                          echo $registrosAgrupados;
                          echo $sinRegistros;
                        } else {
                          echo '<tr><td colspan="32" class="text-center">No se encontraron registros.</td></tr>';
                        }
                      }
                      ?>
                    </tbody>
                    <script>
                      $(document).ready(function() {

                        // Inicializa DataTable sin ordenamiento
                            var table = $('.tablaFaenas').DataTable({
                            ordering: false,
                            dom: 'Bfrtip',
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                            pageLength: 25,
                            buttons: [
                            {
                                extend: 'colvis',
                                text: 'Mostrar/Ocultar columnas',
                                className: 'btn btn-info',
                                columnText: function ( dt, idx, title ) {
                                  return title;
                                }
                              },
                              {
                                extend: 'excelHtml5',
                                text: 'Exportar a Excel',
                                className: 'btn btn-success',
                                exportOptions: {
                                  columns: ':visible'
                                }
                              },
                            ],
                            responsive: true,
                            columnDefs: [
                              { targets: [3,4,12,13,16,17,18,19,20,21,22,23,24,25,26,27,30], visible: false }
                            ],
                            language: {
                              buttons: {
                                colvis: 'Mostrar/Ocultar columnas',
                                excel: 'Exportar a Excel',
                                pdf: 'Exportar a PDF'
                              }
                            },
                            // scrollX: true // Habilita scroll horizontal en DataTables
                          });

                          // if (typeof sinRegistros !== 'undefined' && Array.isArray(sinRegistros)) {
                          //   sinRegistros.forEach(function(trHtml) {
                          //     $('#tablaAnimalesBody').append(trHtml);
                          //   });
                          //   table.rows.add($('#tablaAnimalesBody tr')).draw();
                          // }
                          // Personaliza el menú desplegable de ColVis con CSS
                          $('<style>')
                            .prop('type', 'text/css')
                            .html(`
                              .buttons-columnVisibility{
                                margin:0;
                              }
                              .dt-button-collection {
                                background-color: #f4f4f4 !important;
                                border-radius: 8px !important;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
                                min-width: 150px;
                              }
                              .dt-button-collection .dt-button {
                                color: #333 !important;
                                font-family: Calibri, Arial, sans-serif;
                                padding: 1px 10px !important;
                                border-radius: 4px;
                              }
                              .dt-button-collection .dt-button.active {
                                background-color:rgb(0, 0, 0) !important;
                                color: rgba(0,0,0) !important;
                              }
                            `)
                            .appendTo('head');
                        

                      });
                    </script>
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
                    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"/>
                    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
                  </table>

                </div>

              </div>

          </div>

        </div>

      </div>

      </div>

  </section>
 
</div>

<?php 

$nuevaFaena = new ControladorTrazabilidad;

$nuevaFaena->ctrNuevaFaena();

?>