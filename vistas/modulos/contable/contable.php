

<div class="content-wrapper">
  
    <div class="box">
      
      <section class="content" style="padding-top:5px;">
        <div class="row">
          <div class="col-lg-1">
            <button class="btn btn-primary btn-block" id="btnFiltrarContable" style="margin-bottom:10px;" data-toggle="modal" data-target="#ventanaModalMensual"><b>Filtrar</b></button>

            <?php if($_SESSION['usuario'] == 'tecnicoContable'){ ?>

              <!-- <form action="" method="POST">

                <button class="btn btn-primary btn-block" type="submit" id="btnDolar" name="btnDolar" style="margin-bottom:10px;"><b>Dolarizar</b></button>
              </form> -->

            <?php } ?>

          </div>
          <div class="col-lg-2">
            <b style="font-size:1.8em;">Periodo: <span id="periodoVisible"></span></b>
          </div>

          <div class="col-lg-9" style="text-align:right">
            <small><b>*Los valores se representan en US$ CCL <span id="precioDolarCCL" style="color:blue"><span></b></small>
          </div>

        </div>

        <div class="row">
          
          <div class="col-lg-12">

            <ul class="nav nav-tabs" id="tabsCampos" style="font-size:1.5em;">
                    
                    <li class='tabs active' id='barloventoTab'><a href='#tab_barlovento' data-toggle='tab' id="btnBarlovento"><b>Barlovento</b></a></li>
                    <li class='tabs' id='paihuenTab'><a href='#tab_paihuen' data-toggle='tab' id="btnPihuen"><b>Paihuen</b></a></li>
    
            </ul>

            <div class="tab-content">
    
              <div class='tab-pane active' id='tab_barlovento'>
    
                <?php 
                
                  $campo = 'Barlovento';
    
                  include 'dataContable.php';
    
                ?>
    
              </div>
    
              <div class='tab-pane' id='tab_paihuen'>
    
                <?php
    
                  $campo = 'Paihuen';
    
                  include 'dataContable.php';
    
                ?>
    
              </div>
    
            </div>

          </div>
        </div>

      </section>

    </div>

</div>


<!-- MODAL FILTRO -->
<div id="ventanaModalMensual" class="modal fade" role="dialog">
 
  <div class="modal-dialog">

    <div class="modal-content" style="width:300px">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Contabilidad Mensual</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class='modal-body' style='padding-top:0px;margin-top:0px;'>

            <div class='box-body' style='padding-top:0px;margin-top:0px;'>
            
                <div class='box-header'>
                                    
                    <div class="row">
                        
                        <div class="col-md-8">
                        
                            <label><h4><b>Periodo</b></h4></label>
                            
                        </div>
                    
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                        
                           <input class="form-control periodoContable" type="month" name="periodoContable" id="periodoContable" value="">

                        </div>

                    </div>

                    <br>

                </div>

            </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary" id="generarReporteContabilidad">Generar Reporte</button>

        </div>

    </div>
 
  </div>

</div>

<?php 
$dolarizar = new ControladorContable();
$dolarizar-> setearDolar();