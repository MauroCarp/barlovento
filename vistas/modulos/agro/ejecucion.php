<div class="row">

    <div class="col-lg-2">
        
        <div class="input-group" bis_skin_checked="1">
            <span class="input-group-addon"><b>ETAPA</B></span>
            <select class="form-control" id="etapaEjecucion">
                <option value="gruesa">Al 31 de Mayo</option>
                <option value="fina">Al 31 de Diciembre</option>
            </select>
        </div>

    </div>

    <div class="col-lg-3">
        <button type="button" id="btnCargaLotes" class="btn btn-secondary" data-toggle="modal" data-target="#modalCargarEjecucion"><i class="fa fa-file" style="color:#3c8dbc;font-size:1.2em;"></i><b>&nbsp;&nbsp;Carga de Lotes</b></button>
    </div>

</div>

<br>

<div class="row">

    <div class="col-lg-4">
            
        <div class="row">
                
            <div class="col-lg-6">
                
                <div class="info-box">

                    <span class="info-box-icon bg-green"><i class="fa fa-map-o"></i></span>      

                    <div class="info-box-content">

                        <span class="info-box-text">Hectareas Totales</span>
                        
                        <span class="info-box-number"><span id="totalHasEjecutadas"></span> Has.</span>

                    </div>

                </div>

            </div>

            <div class="col-lg-6">
                
                <div class="info-box">

                    <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Inversion Total</span>
                    <span class="info-box-number">U$D <span id="totalInversionEjecutada"></span></span>
                    </div>

                </div>

            </div>

        </div>

        <?php

        $campo = 'La Bety';

        $campoId = 'Bety';

        include 'infoEjecucion.php';

        $campo = 'El Pichi';

        $campoId = 'Pichi';

        include 'infoEjecucion.php';

        $campo = 'Antony';

        $campoId = 'Antony';

        include 'infoEjecucion.php';

        ?>
    
    </div>

    <div class="col-lg-8">

        <?php include "tablasEjecucion.php"; ?>

    </div>

</div>