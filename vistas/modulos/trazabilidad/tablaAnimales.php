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
                        <th>Kilos</th>
                        <th>Clasificacion</th>
                        <th>Denominacion</th>
                        <th>Tipif.</th>
                        <th>Gord.</th>
                        <th>Dent.</th>
                        <th>% Diferencia T vs R</th>
                        <th>Kilos teoricos</th>
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
                                text: 'Exportar a Excel (Todos los datos)',
                                className: 'btn btn-success btn-exportar-todos',
                                action: function (e, dt, button, config) {
                                  // Encontrar el botón y cambiar su estado
                                  const $btn = $('.btn-exportar-todos');
                                  const originalText = $btn.text();
                                  $btn.text('Exportando...').prop('disabled', true);
                                  
                                  // Obtener todos los datos del servidor
                                  $.ajax({
                                    url: 'ajax/trazabilidad-animals.ajax.php',
                                    type: 'POST',
                                    data: {
                                      action: 'exportarTodos',
                                      ids: ids
                                    },
                                    success: function(response) {
                                      try {
                                        const data = JSON.parse(response);
                                        
                                        // Crear workbook de Excel
                                        const wb = XLSX.utils.book_new();
                                        
                                        // Crear headers para Excel (solo columnas visibles, excluyendo la columna de estilo)
                                        const headers = [];
                                        table.columns(':visible').every(function(index) {
                                          if (index !== 32) { // Excluir la columna del marcador de estilo
                                            const header = $(this.header()).text();
                                            if (header.trim() !== '') {
                                              headers.push(header);
                                            }
                                          }
                                        });
                                        
                                        // Preparar datos para Excel (filtrar solo columnas visibles)
                                        const excelData = [headers];
                                        
                                        data.forEach(function(row) {
                                          const filteredRow = [];
                                          let visibleColumnIndex = 0;
                                          
                                          table.columns(':visible').every(function(index) {
                                            if (index !== 32 && row[index] !== undefined) { // Excluir columna de estilo
                                              let cellValue = row[index];
                                              
                                              // Identificar columnas que pueden tener números largos (RFID, Correlación, Garrón, etc.)
                                              const columnHeader = $(this.header()).text().toLowerCase();
                                              const isNumericColumn = columnHeader.includes('rfid') || 
                                                                    visibleColumnIndex === 0; // Primera columna visible (RFID)
                                              
                                              // Convertir números largos a texto para evitar notación científica
                                              if (isNumericColumn && cellValue != '') {
                                                cellValue = "'" + cellValue + "'";
                                              }
                                              
                                              filteredRow.push(cellValue);
                                              visibleColumnIndex++;
                                            }
                                          });
                                          excelData.push(filteredRow);
                                        });
                                        // Array de índices de columnas numéricas (ajusta según tus columnas)
                                        const columnasNumericas = [3,9,10, 17, 18, 19, 21, 22, 23, 24,25,26];

                                        // Aplicar formato numérico a las celdas correspondientes
                                        const ws = XLSX.utils.aoa_to_sheet(excelData);

                                        // Recorrer las filas y columnas para aplicar formato numérico
                                        for (let r = 1; r < excelData.length; r++) { // Empieza en 1 para saltar el header
                                          let visibleColumnIndex = 0;
                                          table.columns(':visible').every(function(index) {
                                          if (index !== 32 && excelData[r][visibleColumnIndex] !== undefined) {
                                            if (columnasNumericas.includes(index)) {
                                            const cellAddress = XLSX.utils.encode_cell({c: visibleColumnIndex, r: r});
                                            const cell = ws[cellAddress];
                                            if (cell) {
                                              let valorOriginal = cell.v;
                                              
                                              // Si es string, limpia y convierte
                                              if (typeof valorOriginal === 'string') {
                                                // Elimina comillas y espacios
                                                valorOriginal = valorOriginal.replace(/['"'\s]/g, '');
                                                
                                                // Detectar si usa coma como separador decimal (formato europeo)
                                                // Si tiene punto Y coma, el punto es separador de miles
                                                // Si solo tiene coma, es separador decimal
                                                if (valorOriginal.includes(',')) {
                                                  if (valorOriginal.includes('.')) {
                                                    // Tiene ambos: punto es miles, coma es decimal (ej: 1.234,56)
                                                    valorOriginal = valorOriginal.replace(/\./g, '').replace(',', '.');
                                                  } else {
                                                    // Solo tiene coma: es decimal (ej: 1,03)
                                                    valorOriginal = valorOriginal.replace(',', '.');
                                                  }
                                                } else if (valorOriginal.includes('.')) {
                                                  // Solo tiene punto: podría ser decimal o miles
                                                  // Si tiene más de un punto, son separadores de miles (ej: 1.234.567)
                                                  const puntos = (valorOriginal.match(/\./g) || []).length;
                                                  if (puntos > 1) {
                                                    valorOriginal = valorOriginal.replace(/\./g, '');
                                                  }
                                                  // Si tiene un solo punto, se asume decimal (ej: 1.03)
                                                }
                                              }
                                              
                                              // Convierte a número
                                              const valorNumerico = Number(valorOriginal);
                                              
                                              // Si la conversión es exitosa, actualiza la celda
                                              if (!isNaN(valorNumerico) && valorOriginal !== '') {
                                                cell.v = valorNumerico;
                                                cell.t = 'n';
                                                // Opcional: agregar formato de número con 2 decimales
                                                cell.z = '0.00';
                                              }
                                            }
                                            }
                                            visibleColumnIndex++;
                                          }
                                          });
                                        }
                                        // Crear worksheet
                                        // const ws = XLSX.utils.aoa_to_sheet(excelData);
                                        
                                        // Agregar worksheet al workbook
                                        XLSX.utils.book_append_sheet(wb, ws, 'Animales');
                                        
                                        // Generar archivo y descargarlo
                                        const fileName = 'animales_trazabilidad_' + new Date().toISOString().slice(0,10) + '.xlsx';
                                        XLSX.writeFile(wb, fileName);
                                        
                                      } catch (error) {
                                        console.error('Error al procesar datos para Excel:', error);
                                        alert('Error al generar el archivo Excel');
                                      } finally {
                                        // Restaurar texto original del botón
                                        $btn.text(originalText).prop('disabled', false);
                                      }
                                    },
                                    error: function(xhr, status, error) {
                                      console.error('Error en la petición AJAX:', error);
                                      alert('Error al obtener los datos del servidor');
                                      // Restaurar texto original del botón
                                      $btn.text(originalText).prop('disabled', false);
                                    }
                                  });
                                }
                              },
                            ],
                            responsive: true,
                            columnDefs: [
                              { targets: [9,10,12,13,16,17,18,19,20,21,22,23,24,25,26,27,30], visible: false }
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
                              const tipoRegistro = data[35]; // Índice del marcador de estilo
                              console.log(tipoRegistro)
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
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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