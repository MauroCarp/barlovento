<div id="modalSelectCampania" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content" style="width:300px">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Seleccionar Campa&ntilde;a</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body" >

            <div class="form-group">

              <label for="campaniaAgro">Campa&ntilde;a</label>

              <select name="campaniaAgro" class="form-control" id="campaniaAgro">
                <?php
                $tabla = 'planificaciones';
  
                $campanias = ControladorAgro::ctrMostrarCampanias(null,'DISTINCT(campania)');
  
                foreach ($campanias as $key => $value) {
                    echo "<option value='" . $value['campania'] . "'>" . $value['campania'] . "</option>";
                }
                ?>
              </select>

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary" id="btnMostrarCampania" name="btnMostrarCampania">Mostrar Campa&ntilde;a</button>

        </div>

      </form>

    </div>

  </div>

</div>

<?php



?>