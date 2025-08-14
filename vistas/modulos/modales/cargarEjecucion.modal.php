<div id="modalCargarEjecucion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" id="formCarga">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Carga de Ejecuci&oacute;n por Lotes</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
            
          
          <div class="form-group">

            <label for="selectEtapa">Etapa</label>
            <input type="hidden" name="campania" id="inputCampaniaEjecucion" value="">
            <select class="form-control" id="selectEtapa" name="etapaEjecucion">
              <option value="fina">Al 31 de Diciembre</option>
              <option value="gruesa">Al 31 de Mayo</option>
            </select>

          </div>

          <div class="box-body" id="formEjecucion">
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary" id="btnCargarEjecucion" name="btnCargarEjecucion" data-carga="">Cargar Ejecuci&oacute;n de lotes</button>

        </div>

      </form>

    </div>

  </div>

</div>

<?php

$nuevaCarga = new ControladorAgro();
$nuevaCarga->ctrCargarEjecucion();


?>

