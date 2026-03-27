<!-- MODAL PARA DETALLE DE CULTIVO -->
<div id="modalDetalleCultivo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <!-- ENCABEZADO -->
      <div class="modal-header" style="background:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <i class="fa fa-leaf"></i> 
          Detalle de Cultivo: <span id="nombreCultivoModal"></span>
        </h4>
      </div>

      <!-- CUERPO -->
      <div class="modal-body">
        
        <!-- Información general del cultivo -->
        <div class="row">
          <div class="col-lg-4">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-envira"></i></span>      
              <div class="info-box-content">
                <span class="info-box-text">Total Cosechado</span>
                <span class="info-box-number"><span id="totalCosechadoModal">0</span> Kg</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-envira"></i></span>      
              <div class="info-box-content">
                <span class="info-box-text">Remanente</span>
                <span class="info-box-number"><span id="remanenteTotalModal">0</span> Kg</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="info-box">
              <span class="info-box-icon bg-blue"><i class="fa fa-dollar"></i></span>      
              <div class="info-box-content">
                <span class="info-box-text">$ Remantente </span>
                  <small>Seg&uacute;n pizarra del dia anterior.</small>
                <span class="info-box-number">$ <span id="precioPizarraModal">0</span></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Aquí se agregará más contenido del modal en siguientes iteraciones -->
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Contratos</h3>
              </div>
              <div class="box-body" id="contratosModal">
                <p class="text-center text-muted">
                  <i class="fa fa-spinner fa-spin"></i> Cargando detalles...
                </p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- PIE -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGestionarCultivo">
          <i class="fa fa-file-text"></i> Cargar Contrato
        </button>
      </div>

      <div class="row" style="display:none;" id="formCargaContrato">
        <div class="col-lg-12" style="padding: 15px;">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Cargar Archivo</h3>
            </div>
            <div class="box-body">
              <form id="formCargaArchivo" method='POST' enctype="multipart/form-data">
                <input type="hidden" name="campaniaContrato" id="campaniaContrato">
                <input type="hidden" name="cultivoContrato" id="cultivoContrato">
                <div class="form-group">
                  <label for="archivoContrato">Seleccionar archivo</label>
                  <input type="file" id="archivoContrato" name="archivoContrato" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success" name="btnCargarContrato">
                  <i class="fa fa-upload"></i> Cargar
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$nuevoContrato = ControladorAgro::ctrNuevoContrato();
