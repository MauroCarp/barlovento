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
                      <!-- Los datos se cargarán vía AJAX -->
                    </tbody>
                    <script>
                      $(document).ready(function() {
                        const inicio = performance.now();
                        console.log("Inicio de procesamiento: " + inicio + " ms");
                        
                        // Obtener los IDs de la URL
                        const urlParams = new URLSearchParams(window.location.search);
                        const ids = urlParams.get('ids') || '<?php echo $ids; ?>';
                        
                        // Inicializa DataTable con procesamiento del lado del servidor
                        var table = $('.tablaFaenas').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: 'ajax/trazabilidad-animals.ajax.php',
                                type: 'POST',
                                data: function(d) {
                                    d.action = 'mostrarAnimalesPaginados';
                                    d.ids = ids;
                                }
                            },
                            ordering: false,
                            dom: 'Bfrtip',
                            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                            pageLength: 26,
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
                              },
                              processing: "Procesando...",
                              lengthMenu: "Mostrar _MENU_ registros",
                              zeroRecords: "No se encontraron resultados",
                              emptyTable: "Ningún dato disponible en esta tabla",
                              info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                              infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                              infoFiltered: "(filtrado de un total de _MAX_ registros)",
                              search: "Buscar:",
                              paginate: {
                                first: "Primero",
                                last: "Último",
                                next: "Siguiente",
                                previous: "Anterior"
                              }
                            },
                            rowCallback: function(row, data, index) {
                              // Aplicar estilos según el tipo de registro
                              const tipoRegistro = data[32]; // Índice del marcador de estilo
                              if (tipoRegistro === 'segunda') {
                                // Segunda fila (RFID vacío)
                                $(row).css('background-color', 'rgba(44, 187, 212, 0.38)');
                              } else if (tipoRegistro === 'primera') {
                                // Primera fila
                                $(row).css('background-color', 'rgba(255, 246, 121, 0.38)');
                              } else if (tipoRegistro === 'otros') {
                                // Registros sin agrupación completa
                                $(row).css('background-color', 'rgba(116, 25, 25, 0.38)');
                              }
                            }
                          });
                          
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
                        
                            const fin = performance.now();
                            console.log("Fin de procesamiento: " + fin + " ms");
                            console.log("Tiempo total de procesamiento: " + (fin - inicio) + " ms");

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