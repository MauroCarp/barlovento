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

            <label for="selectEtapaProduccionCarga">Etapa</label>
            <input type="hidden" name="campania" id="inputCampaniaProduccion" value="">
            <select class="form-control" id="selectEtapaProduccionCarga" name="etapaProduccion">
              <option value="fina">Al 31 de Diciembre</option>
              <option value="gruesa">Al 31 de Mayo</option>
            </select>

          </div>

          <div class="box-body" id="formProduccion">

            <!-- Input para cargar múltiples archivos -->
            <div class="form-group">
              <label for="archivosProduccion">Cargar Archivos</label>
              <input type="file" class="form-control-file" id="archivosProduccion" name="archivosProduccion[]" multiple accept=".xlsx,.xls,.csv">
            </div>

            <!-- Vista previa de archivos seleccionados -->
            <div class="form-group" id="vistaArchivos" style="display:none;">
              <label>Archivos Seleccionados:</label>
              <div id="listaArchivos" class="list-group"></div>
            </div>

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

<script>
$(document).ready(function() {
    // Manejar selección de archivos múltiples
    $('#archivosProduccion').on('change', function() {
        const archivos = this.files;
        const listaArchivos = $('#listaArchivos');
        const vistaArchivos = $('#vistaArchivos');
        
        // Limpiar lista anterior
        listaArchivos.empty();
        
        if (archivos.length > 0) {
            let totalSize = 0;
            const maxSize = 50 * 1024 * 1024; // 50MB total
            
            $.each(archivos, function(index, archivo) {
                totalSize += archivo.size;
                
                // Crear elemento para mostrar archivo
                const archivoElement = $(`
                    <div class="list-group-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px;" data-index="${index}">
                        <div>
                            <i class="fa fa-file-excel-o text-success"></i>
                            <span class="nombre-archivo">${archivo.name}</span>
                            <small class="text-muted"> (${formatFileSize(archivo.size)})</small>
                        </div>
                        <button type="button" class="btn btn-xs btn-danger eliminar-archivo" data-index="${index}" style="margin-left: 10px;">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `);
                
                listaArchivos.append(archivoElement);
            });
            
            // Mostrar información total
            const infoTotal = $(`
                <div class="alert alert-info" style="margin-top: 10px; margin-bottom: 5px;">
                    <strong>${archivos.length}</strong> archivo(s) seleccionado(s) - 
                    Tamaño total: <strong>${formatFileSize(totalSize)}</strong>
                </div>
            `);
            listaArchivos.append(infoTotal);
            
            // Validar tamaño total
            if (totalSize > maxSize) {
                const alertError = $(`
                    <div class="alert alert-danger" style="margin-top: 5px;">
                        <i class="fa fa-warning"></i> El tamaño total de los archivos excede los 50MB permitidos.
                    </div>
                `);
                listaArchivos.append(alertError);
                $('#btnCargarProduccion').prop('disabled', true);
            } else {
                $('#btnCargarProduccion').prop('disabled', false);
            }
            
            vistaArchivos.show();
        } else {
            vistaArchivos.hide();
            $('#btnCargarProduccion').prop('disabled', false);
        }
    });
    
    // Función para formatear tamaño de archivo
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Eliminar archivo individual (funcionalidad visual)
    $(document).on('click', '.eliminar-archivo', function() {
        const index = $(this).data('index');
        $(this).closest('.list-group-item').remove();
        
        // Verificar si quedan archivos
        const archivosRestantes = $('#listaArchivos .list-group-item:not(.alert)').length;
        if (archivosRestantes === 0) {
            $('#vistaArchivos').hide();
            $('#archivosProduccion').val('');
        }
    });
    
    // Limpiar selección cuando se cierre el modal
    $('#modalCargarProduccion').on('hidden.bs.modal', function() {
        $('#archivosProduccion').val('');
        $('#listaArchivos').empty();
        $('#vistaArchivos').hide();
        $('#btnCargarProduccion').prop('disabled', false);
    });
    
    // Validación adicional al submit
    $('#formCarga').on('submit', function(e) {
        const archivos = $('#archivosProduccion')[0].files;
        
        if (archivos.length === 0) {
            e.preventDefault();
            alert('Por favor, selecciona al menos un archivo para cargar.');
            return false;
        }
        
        // Validar tipos de archivo
        const tiposPermitidos = ['.xlsx', '.xls', '.csv'];
        let archivosValidos = true;
        
        $.each(archivos, function(index, archivo) {
            const extension = '.' + archivo.name.split('.').pop().toLowerCase();
            if (!tiposPermitidos.includes(extension)) {
                archivosValidos = false;
                return false;
            }
        });
        
        if (!archivosValidos) {
            e.preventDefault();
            alert('Solo se permiten archivos Excel (.xlsx, .xls) y CSV (.csv).');
            return false;
        }
        
        return true;
    });
});
</script>

<?php

$nuevaCarga = new ControladorAgro();
$nuevaCarga->ctrCargarProduccion();


?>

