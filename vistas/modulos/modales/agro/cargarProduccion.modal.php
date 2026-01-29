<div id="modalCargarProduccion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" id="formCarga">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Carga de Producci&oacute;n por Lotes</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
            
          
          <div class="form-group">

            <label for="selectEtapaProduccion">Etapa</label>
            <input type="hidden" name="campania" id="inputCampaniaProduccion" value="">
            <input type="hidden" name="idPlanificacion" id="idPlanificacion" value="">
            <select class="form-control" id="selectEtapaProduccion" name="etapaProduccion">
              <option value="fina">Al 31 de Diciembre</option>
              <option value="gruesa">Al 31 de Mayo</option>
            </select>

          </div>

          <div class="box-body" id="formProduccion">
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary" id="btnCargarProduccion" name="btnCargarProduccion" data-carga="">Cargar Producci&oacute;n de lotes</button>

        </div>

      </form>

    </div>

  </div>

</div>

<?php

$nuevaCarga = new ControladorAgro();
$nuevaCarga->ctrCargarProduccion();


?>

