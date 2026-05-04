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
                <span class="info-box-text">$ Remanente </span>
                  <small>Seg&uacute;n pizarra del dia anterior.<span id="precioPizarra"></span></small>
                <span class="info-box-number">$ <span id="precioRemanenteModal">0</span></span>
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
                  <label for="archivoContrato">Seleccionar archivos</label>
                  <input type="file" id="archivoContrato" name="archivoContrato[]" class="form-control" required multiple>
                </div>
                <!-- Vista previa de archivos seleccionados -->
                <div class="form-group" id="vistaArchivosContrato" style="display:none;">
                  <label>Archivos Seleccionados:</label>
                  <div id="listaArchivosContrato" class="list-group"></div>
                </div>
                <button type="submit" class="btn btn-success" id="btnCargarContrato" name="btnCargarContrato">
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

<script>
$(document).ready(function() {

    function formatFileSizeContrato(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    $('#archivoContrato').on('change', function() {
        const archivos = this.files;
        const listaArchivos = $('#listaArchivosContrato');
        const vistaArchivos = $('#vistaArchivosContrato');

        listaArchivos.empty();

        if (archivos.length > 0) {
            let totalSize = 0;
            const maxSize = 50 * 1024 * 1024; // 50MB

            $.each(archivos, function(index, archivo) {
                totalSize += archivo.size;
                const item = $(`
                    <div class="list-group-item" style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px;" data-index="${index}">
                        <div>
                            <i class="fa fa-file-o text-primary"></i>
                            <span>${archivo.name}</span>
                            <small class="text-muted"> (${formatFileSizeContrato(archivo.size)})</small>
                        </div>
                        <button type="button" class="btn btn-xs btn-danger eliminar-archivo-contrato" data-index="${index}" style="margin-left:10px;">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `);
                listaArchivos.append(item);
            });

            const infoTotal = $(`
                <div class="alert alert-info" style="margin-top:10px; margin-bottom:5px;">
                    <strong>${archivos.length}</strong> archivo(s) seleccionado(s) &mdash;
                    Tama&ntilde;o total: <strong>${formatFileSizeContrato(totalSize)}</strong>
                </div>
            `);
            listaArchivos.append(infoTotal);

            if (totalSize > maxSize) {
                listaArchivos.append(`
                    <div class="alert alert-danger" style="margin-top:5px;">
                        <i class="fa fa-warning"></i> El tama&ntilde;o total supera los 50MB permitidos.
                    </div>
                `);
                $('#btnCargarContrato').prop('disabled', true);
            } else {
                $('#btnCargarContrato').prop('disabled', false);
            }

            vistaArchivos.show();
        } else {
            vistaArchivos.hide();
            $('#btnCargarContrato').prop('disabled', false);
        }
    });

    $(document).on('click', '.eliminar-archivo-contrato', function() {
        $(this).closest('.list-group-item').remove();
        const restantes = $('#listaArchivosContrato .list-group-item:not(.alert)').length;
        if (restantes === 0) {
            $('#vistaArchivosContrato').hide();
            $('#archivoContrato').val('');
        }
    });

    $('#modalDetalleCultivo').on('hidden.bs.modal', function() {
        $('#archivoContrato').val('');
        $('#listaArchivosContrato').empty();
        $('#vistaArchivosContrato').hide();
        $('#btnCargarContrato').prop('disabled', false);
    });

});
</script>

<?php
$nuevoContrato = ControladorAgro::ctrNuevoContrato();
