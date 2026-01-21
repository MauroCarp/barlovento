<?php
// Vista: Panel Gordos con 2 solapas ("A definir" y "Resumen")
?>
<div class="content-wrapper">
  <section class="content-header">
    <div style="display:flex; align-items:left;">

        <h1>Panel Gordos <small><span id="fechaActualizacion"></span></small></h1>
        <button type="button" class="btn btn-primary" style="height:50%;margin:auto 0;margin-left:10px" data-toggle="modal" data-target="#modalActualizar">
            <i class="fa fa-upload"></i> Actualizar
        </button>

    </div>

    <div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-labelledby="modalActualizarLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="modalActualizarLabel">Actualizar archivo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="archivoActualizar">Seleccionar archivo</label>
                            <input type="file" class="form-control" id="archivoActualizar" name="archivo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="cargarGordos"><i class="fa fa-upload"></i> Subir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Panel Gordos</li>
    </ol>
  </section>

  <section class="content">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab"><b>Principal</b></a></li>
        <li><a href="#tab_2" data-toggle="tab"><b>Resumen</b></a></li>
      </ul>

      <div class="tab-content" style="padding-bottom:0;">
        <div class="tab-pane active" id="tab_1">
          <?php
            include __DIR__ . '/gordosPrincipal.php';
          ?>
        </div>

        <div class="tab-pane" id="tab_2">
          <?php
            include "resumen.php";
          ?>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
(function(){
  // Actualiza la fecha del encabezado con la del endpoint si está disponible
  function setFecha(fechaISO){
    try{
      if(!fechaISO) return;
      var p = fechaISO.split('-');
      if(p.length===3){
        document.getElementById('fechaActualizacion').textContent = [p[2], p[1], p[0]].join('/');
      }
    }catch(e){}
  }
  fetch('ajax/gordosPrincipal.ajax.php?accion=data')
    .then(r=>r.ok?r.json():null)
    .then(d=>{ if(d && d.fecha){ setFecha(d.fecha); }})
    .catch(()=>{});
})();
</script>

<?php

    $cargarGordos = new ControladorGordos();
    $cargarGordos->ctrCargarExcel();
?>