<div id="modalCarga" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" id="formCarga">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title" id="tituloCarga"></h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group hidden" id="inputPeriodoContable">
              
              <div class="panel">Periodo</div>

              <input type="month" id="periodoContable" name="periodoContable">

            </div>

            <div class="form-group hidden" id="inputCampania">
              
              <div>Campa&ntilde;a</div>

              <div class="row">

                <div class="col-lg-4">

                  <select class="form-control" id="campania1" name="campania1">

                    <?php
                      $year = date('Y');
                      
                      for ($i=0; $i < 5; $i++) { ?>
                        
                        <option value="<?=$year+$i?>"><?=$year+$i?></option>

                    <?php
                      }
                    ?>

                  </select>

                </div>

                <div class="col-lg-1">
                    <span style="font-size:1.5em">/</span>
                </div>

                <div class="col-lg-4">

                  <input type="number" class="form-control" id="campania2" name="campania2" readOnly>

                </div>

              </div>

            </div>

             <div class="form-group">
              
              <div class="panel">Seleccionar Archivo</div>

              <input type="file" id="nuevosDatosCarga" name="">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary" id="btnCargar" name="btnCargar" data-carga=""></button>

        </div>

      </form>

    </div>

  </div>

</div>

<?php

if($_SESSION['perfil'] == 'Agro' OR $_SESSION['perfil'] == 'Administrador Agro')
  $cargarArchivo = new ControladorAgro();

if($_SESSION['perfil'] == 'Contable' OR $_SESSION['perfil'] == 'Administrador Contable')
  $cargarArchivo = new ControladorContable();

if($_SESSION['perfil'] == 'Pastoreo' OR $_SESSION['perfil'] == 'Administrador Pastoreo')
  $cargarArchivo = new ControladorPastoreo();


$cargarArchivo->ctrCargarArchivo();


?>

