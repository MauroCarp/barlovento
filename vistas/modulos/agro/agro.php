<?php         

if(isset($_GET['accion']) && $_GET['accion'] == 'costosCultivos'){

  $idPlanificacion = $_GET['idPlanificacion'];

  $cultivos = ControladorAgro::ctrCultivosUnicosPorPlanificacion($idPlanificacion);

  $html = '<div class="row">';

  asort($cultivos);

  foreach ($cultivos as $key => $cultivo) {

    $cultivoRaw = $cultivo;
    $ultimoCaracter = substr($cultivo, -1);
    $len = strlen($cultivo) - 1;
    $cultivo = (is_numeric($ultimoCaracter)) ? substr(ucfirst($cultivo),0,$len) . ' ' . $ultimoCaracter . '°' : ucfirst($cultivo); 

    $html .= '<div class="col-lg-5" style="font-size:1.2em;line-height:3.5em;text-align:right">
                ' . $cultivo . ':
              </div>
              <div class="col-lg-4">
                <input type="number" name="' . $cultivoRaw . '" class="swal2-input cultivos" value="0">
              </div>';
  }
    
  $html .= '</div>';

?>

  <script>
    swal({
      title: 'Costo de Cultivos',
      html:`<?=$html?>`,
      showCancelButton: false, // Oculta el botón "Cancelar"
      showCloseButton: false, // Oculta el botón para cerrar
      allowOutsideClick: false, // Impide cerrar haciendo clic fuera del SweetAlert
      allowEscapeKey: false,
      confirmButtonText: 'Cargar',
    }).then((result) => {

      if (result) {
        let data = {
          'idPlanificacion': <?=$idPlanificacion?>,
          'accion':'cargarCostos'
        }

        let costosCultivos = {}

        $('.cultivos').each(function(){

          let cultivo = $(this).attr('name')
          costosCultivos[cultivo] = $(this).val()

        })

        data.cultivos = costosCultivos;

        let url = 'ajax/agro.ajax.php'
        $.ajax({
          method:'post',
          url,
          data:`accion=cargarCostos&data=${JSON.stringify(data)}`,
          success:function(response){

            if(response == 'ok'){
              swal({
                type: "success",
                title: "La carga ha sido correcta.",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
                }).then(function(result) {

                  if (result.value) {

                  window.location = "index.php?ruta=agro/agro";

                  }

                })
            }
            
          }
        })
        
      }

    })
  </script>

<?php
  die;
}
?>

<div class="content-wrapper">
  
    <div class="box">
    
        <section class="content" style="padding-top:5px;">

          <div class="widget-user-header bg-aqua-active">

              <button class="btn btn-info" style="padding:10px;margin:5px;font-size:1.3em;" data-toggle="modal" data-target="#modalSelectCampania"><b>Campa&ntilde;a: <span id="campania"></span></b></button>

          </div>

          <div class="row">

                  <div class="col-md-12">

                      <div class="nav-tabs-custom">

                          <ul class="nav nav-tabs" id="tabsCiclos" style="font-size:1.5em;">
                    
                              <li class='tabs active' id='planificacionTab'><a href='#tab_1' data-toggle='tab' id="btnPlanificacion"><b>Planificaci&oacute;n</b></a></li>
                              <li class='tabs' id='ejecucionTab'><a href='#tab_2' data-toggle='tab' id="btnEjecucion"><b>Ejecuci&oacute;n</b></a></li>
                              <?php if(in_array('Produccion',$_SESSION['perfilAgro'])){ ?>
                                <li class='tabs' id='produccionTab'><a href='#tab_3' data-toggle='tab' id="btnProduccion"><b>Producci&oacute;n</b></a></li>
                              <?php } ?>

                          </ul>

                          <div class="tab-content">


                            <div class='tab-pane active' id='tab_1'>

                              <?php include 'planificacion.php';?>
                           
                            </div>

                            <div class='tab-pane' id='tab_2'>
                              <?php include 'ejecucion.php';?>
                            </div>

                            <?php if(in_array('Produccion',$_SESSION['perfilAgro'])){ ?>

                            <div class='tab-pane' id='tab_3'>
                              
                              <h1>PRODUCCION</h1>
                              <?php //include 'produccion.php';?>
                            </div>

                            <?php } ?>

                      </div>

                  </div>

          </div>

        </section>

    </div>

</div>

<?php

include 'vistas/modulos/modales/agro/selectCampania.modal.php';

include 'vistas/modulos/modales/agro/costosPlanificacion.modal.php';

include 'vistas/modulos/modales/agro/cargarEjecucion.modal.php';

$eliminarArchivo = new ControladorAgro;

$eliminarArchivo -> ctrEliminarArchivo();

$campaniaAgro = isset($_COOKIE['campaniaAgro']) ? true : false;

?>
