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

          <div class="col-lg-4">

            <div class="box box-info">

              <div class="box-header with-border">

                <h3 class="box-title">Nueva Faena</h3>

              </div>

              <div class="box-body">

                <form method="post" enctype="multipart/form-data">

                  <div class="row" id="faenaPaso1">

                    <div class="col-lg-8">

                      <div class="form-group">
      
                        <label for="nombreFaena">Nombre</label>
                        <input type="text" class="form-control" name="nombreFaena" id="nombreFaena">
      
                      </div>
      
                      <div class="form-group">
      
                        <label>Fecha:</label>
      
                        <div class="input-group date">
      
                          <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                          </div>
      
                          <input type="date" class="form-control pull-right" id="fechaFaena" name="fechaFaena">
                        </div>
      
                      </div>
       
                      <div class="form-group">
      
                        <label>Frigorifico:</label>
      
                        <div class="input-group date">
      
                          <div class="input-group-addon">
                          <i class="fa fa-building "></i>
                          </div>
      
                          <select name="frigorificoFaena" class="form-control pull-right" id="frigorificoFaena">
                            <option value="pellegrinense">La Pellegrinense</option>
                            <option value="bustosBeltran">Bustos y Beltran</option>
                          </select>

                        </div>
      
                      </div>

                    </div>

                    <div class="col-lg-4" align="center">

                      <button type="button" style="border-radius:5px;padding:5px 20px;background-color:transparent;font-family:calibri;color:rgb(200,200,200);font-size:2em;" id="btnPaso1">
                        <i class="fa fa-arrow-right" style="font-size:5em;"></i><br>
                        <b>Continuar</b>
                      </button>

                    </div>

                  </div>

                  <div class="row" style="display:none" id="faenaPaso2">

                    <div class="col-lg-8">

                      <div class="form-group">

                        <label for="excelTrazabilidad">Excel Trazabilidad del Frigorifico</label>
                        <input type="file" name="excelTrazabilidad" id="excelTrazabilidad" required>

                      </div>

                      <div class="form-group">

                        <label for="excelWC">Excel Wincampo</label>
                        <input type="file" name="excelWC" id="excelWC" required>

                      </div>

   

                      <div class="form-group">

                        <label for="excelTD">Excel Toma Decisión (Opcional)</label>
                        <input type="file" name="excelTD" id="excelTD" disabled>

                      </div>

                    </div>

                    <div class="col-lg-4" align="center">

                      <button type="button" style="border-radius:5px;padding:5px 20px;background-color:transparent;font-size:2em;font-family:calibri;color:rgb(200,200,200);margin-bottom:5px" id="btnVolver">
                        <i class="fa fa-arrow-left"></i>
                        <b>Volver</b>
                      </button>

                      <button type="submit" style="border-radius:5px;padding:5px 20px;background-color:transparent;font-family:calibri;color:rgb(200,200,200);font-size:2em;" name="btnCargarFaena" id="btnCargarFaena">
                        <i class="fa fa-upload" style="font-size:5em;"></i><br>
                        <b>Cargar</b>
                      </button>

                    </div>

                  </div>
                  
                </form>
                
              </div>

            </div>

          </div>

          <div class="col-lg-8">

            <div class="box box-info">

              <div class="box-header with-border">

                <h3 class="box-title">Registro de faenas</h3>

              </div>

              <div class="box-body">

                <table class="table table-bordered table-striped dt-responsive tablas tablaFaenas">
                  
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Frigorifico</th>
                      <th>Faena</th>
                      <th>Fecha</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $faenas = ControladorTrazabilidad::ctrMostrarFaenas();

                    foreach ($faenas as $key => $value) {

                      $fecha = date('d-m-Y',strtotime($value['fecha']));
                      $frigorifico = ($value["frigorifico"] == 'pellegrinense') ? 'La Pellegrinense' : (($value['frigorifico'] != '') ? 'Bustos y Beltran' : 'No especificado');
                      echo '<tr>

                              <td>' . $value["id"] .'</td>
                              <td>' . $frigorifico.'</td>
                              <td>'.$value["nombre"].'</td>
                              <td>'.$fecha.'</td>
                              <td>
                                  <button class="btn btn-danger btnEliminarFaena" idFaena="'.$value["id"].'"><i class="fa fa-trash"></i></button>
                              </td>
                            </tr>';
                    }
                    ?>
                  </tbody>
                  <script>
                    $(document).ready(function() {

                        var table = $('.tablaFaenas').DataTable({
                        responsive: true,
                        ordering: false,
                        columnDefs: [
                          {
                          targets: 0, // Oculta la primera columna (#)
                          visible: false,
                          searchable: false
                          }
                        ],
                        language: {
                          search: "Buscar:",
                          lengthMenu: "Mostrar _MENU_ registros",
                          info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                          infoEmpty: "Mostrando 0 a 0 de 0 registros",
                          infoFiltered: "(filtrado de _MAX_ registros totales)",
                          zeroRecords: "No se encontraron registros",
                          paginate: {
                          first: "Primero",
                          last: "Último",
                          next: "Siguiente",
                          previous: "Anterior"
                          }
                        },
                      });

                      // Agrega inputs de filtro de rango de fechas para Fecha Ingreso y Fecha Salida
                      $('.tablaFaenas').before(`
                        <div class="row" style="margin-bottom:10px;">
                          <div class="col-md-4">
                            <input type="text" id="rangoFecha" class="form-control" autocomplete="off" placeholder="Seleccione rango de Ingreso/Egreso">
                          </div>
                          <div class="col-md-4">
                            <button id="btnFiltrarRango" class="btn btn-primary" disabled>
                              Ver animales filtrados
                            </button>
                        </div>
                      `);

                      // Incluye daterangepicker
                      $('head').append('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">');
                      $.getScript('https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js', function() {
                        $.getScript('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', function() {
                          // Espera a que el plugin esté disponible antes de inicializar
                          setTimeout(function() {
                            $('#rangoFecha').daterangepicker({
                              autoUpdateInput: false,
                              locale: {
                                cancelLabel: 'Limpiar',
                                format: 'DD-MM-YYYY',
                                applyLabel: 'Aplicar',
                                fromLabel: 'Desde',
                                toLabel: 'Hasta',
                                customRangeLabel: 'Personalizado',
                                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                firstDay: 1
                              }
                            });

                            $('#rangoFecha').on('apply.daterangepicker', function(ev, picker) {
                              $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                              table.draw();
                            });

                            $('#rangoFecha').on('cancel.daterangepicker', function(ev, picker) {
                              $(this).val('');
                              table.draw();
                            });
                          }, 0);
                        });
                      });

                      // Filtro personalizado para rango de fechas
                      $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                          // Fecha Ingreso
                          var rango = $('#rangoFecha').val();
                          var fecha = data[3] || "";
                          var mostrarFecha = true;
                          // Convertir fecha de DD-MM-YYYY a YYYY-MM-DD
                          if (fecha.match(/^(\d{2})-(\d{2})-(\d{4})$/)) {
                            var partesFecha = fecha.split('-');
                            fecha = partesFecha[2] + '-' + partesFecha[1] + '-' + partesFecha[0];
                          }
                          if (rango) {
                            var partes = rango.split(' - ');
                            var desde = partes[0];
                            var hasta = partes[1];
                            if (fecha < desde || fecha > hasta) {
                              mostrarFecha = false;
                            }
                          }

                          return mostrarFecha;
                        }
                      );

                      // Evento para actualizar el filtro
                      $('#rangoFecha').on('change', function() {
                        table.draw();
                      });

                      function actualizarBotonFiltrar() {

                        if ($('#rangoFecha').val()) {
                          console.log('Habilitando botón');
                          $('#btnFiltrarRango').prop('disabled', false);
                        } else {
                          console.log('Deshabilitando botón');
                          $('#btnFiltrarRango').prop('disabled', true);
                        }
                      }

                      $('#rangoFecha').on('apply.daterangepicker cancel.daterangepicker change', function() {
                        setTimeout(() => {
                          actualizarBotonFiltrar();
                        }, 200);
                      });

                      $('#btnFiltrarRango').on('click', function() {

                        var ids = [];
                        table.rows({ search: 'applied' }).every(function() {
                          var data = this.data();
                          ids.push(data[0]);
                        });

                        if (ids.length != 0) {
                          ids.join(',')
                            var url = 'index.php?ruta=trazabilidad/tablaAnimales&ids=' + ids;
                          window.location.href = url;
                        }
                      });
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

  </section>
 
</div>

<?php 

$nuevaFaena = new ControladorTrazabilidad;

$nuevaFaena->ctrNuevaFaena();

?>