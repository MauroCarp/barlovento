<div class="content-wrapper">
  
    <div class="box">
      
      <section class="content" style="padding-top:5px;">

        <div class="row">

          <div class="col-lg-12">
            
            <ul class="nav nav-tabs" id="tabsCampos" style="font-size:1.5em;">      
              
              <li class='tabs tabsPastoreo' id='celulaAmarilla'><a href='#tab_amarilla'><b>Amarilla</b></a></li>
              <li class='tabs tabsPastoreo' id='celulaNaranja'><a href='#tab_naranja'><b>Naranja</b></a></li>
              <li class='tabs tabsPastoreo' id='celulaRoja'><a href='#tab_roja'><b>Roja</b></a></li>
              
            </ul>
    
            <div id='tab_amarilla'>

              <?php
              
                $celula = 'amarilla';
                $color = 'style="border-top:3px solid #ffe300"';

                include 'celula.php';

              ?>
              
            </div>

            <div id='tab_naranja'> 

              <?php
                
                $celula = 'naranja';
                $color = 'warning';

                include 'celula.php';

              ?>

            </div>

            <div id='tab_roja'>

              <?php
                
                $celula = 'roja';
                $color = 'danger';

                include 'celula.php';

              ?>

            </div>

          </div>

        </div>

        <!-- <div class="row" id="mapaLotes">

          <div class="col-lg-5 col-sm-12" style="background-image:url(vistas/img/pastoreo/lotes.png);background-repeat:no-repeat;padding-left:0;">

            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 708" width="500" height="708">
                    
                <a href='#tab_naranja' data-toggle='tab'>
                  <path id="Naranja" class="mapaLote" d="m211.7 103.3l86.3 45.7 1.3 239h-87.3z"/>
                </a>

                <a href='#tab_roja' data-toggle='tab'>
                  <path id="Roja" class="mapaLote" d="m261 388h121l3 258.6-107 1.4-0.7-154.7-15.6 1z"/>
                </a>

                <a href='#tab_amarilla' data-toggle='tab'>
                  <path id="Amarilla" class="mapaLote" d="m127 64.6l84 38 1 289.4 45.3 0.3 0.7 104.3 17.3 0.7 3.7 150.3-110-0.3-21-131.  3-19-111-45-260z"/>
                </a>


            </svg>

          </div>
        </div> -->

      </section>

    </div>

    <button id="back-to-top-btn" class="btn btn-success">Volver arriba</button>

</div>

<style>

  .lotesPath, .mapaLote{
    fill:transparent;
    cursor:pointer;
  }

  .lotesPath:hover, .mapaLote:hover{
      stroke: #3c8dbc;
      stroke-width: 2; /* ancho del borde */
      stroke-opacity: 1; /* aumenta la opacidad al pasar el ratón sobre el rectángulo */
      transition: stroke-opacity 1s ease; /* transición suave de opacidad */

    }

    #back-to-top-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      display: none;
    }

</style>

<?php
  include 'vistas/modulos/modales/pastoreo/detalleParcela.modal.php';
  include 'vistas/modulos/modales/pastoreo/historicoParcela.modal.php';

?>