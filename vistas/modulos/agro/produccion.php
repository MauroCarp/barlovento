<br>

<div class="row">

    <div class="col-lg-4">
            
        <div class="row">
                
            <div class="col-lg-4">
                
                <div class="info-box">

                    <span class="info-box-icon bg-green"><i class="fa fa-map-o"></i></span>      

                    <div class="info-box-content">

                        <span class="info-box-text">Cosecha Total</span>
                        
                        <span class="info-box-number"><span id="totalCosechaProduccion"></span> Has</span>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">
        
                <div class="info-box">

                    <span class="info-box-icon bg-green"><i class="fa fa-line-chart"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Rinde Promedio</span>
                    <span class="info-box-number"><span id="rindePromedioProduccion"></span></span>
                    </div>

                </div>

            </div>

            <div class="col-lg-4">
                
                <div class="info-box">

                    <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Costo Flete Total</span>
                    <span class="info-box-number">U$D <span id="totalFleteProduccion"></span></span>
                    </div>

                </div>

            </div>

        </div>

        <div class="row">
    
            <div class="col-lg-6">
                
                <div class="input-group" bis_skin_checked="1">
                    <span class="input-group-addon"><b>ETAPA</B></span>
                    <select class="form-control" id="etapaProduccion">
                        <option value="gruesa">Al 31 de Mayo</option>
                        <option value="fina">Al 31 de Diciembre</option>
                    </select>
                </div>

            </div>

            <div class="col-lg-6">
                <button type="button" id="btnCargaLotesProduccion" class="btn btn-secondary" data-toggle="modal" data-target="#modalCargarProduccion"><i class="fa fa-file" style="color:#3c8dbc;font-size:1.2em;"></i><b>&nbsp;&nbsp;Carga de Lotes</b></button>
            </div>

        </div>

        <br>


        <?php

        $campo = 'La Bety';

        $campoId = 'Bety';

        include 'infoProduccion.php';

        $campo = 'El Pichi';

        $campoId = 'Pichi';

        include 'infoProduccion.php';

        $campo = 'Antony';

        $campoId = 'Antony';

        include 'infoProduccion.php';

        ?>
    
    </div>

    <div class="col-lg-8">

        <?php include "tablasProduccion.php"; ?>

    </div>

</div>