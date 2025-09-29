

<?php if ($campoId == 'Anthony'){ ?>
    <!-- Acordeón para Anthony -->
    <div class="panel-group" id="accordionAnthony" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingAnthony">
                <h4 class="panel-title" style="font-size:1.5em;display:flex;justify-content:space-between;align-items:center;">
                    <a role="button" data-toggle="collapse" data-parent="#accordionAnthony" href="#collapseAnthony" aria-expanded="false" aria-controls="collapseAnthony">
                        <i class="fa fa-chevron-down"></i><b> <?php echo $campoId; ?></b>     
                    </a>
                    <form action="" method="post" id="formAnthony" style="display:flex;align-items:center;">
                        <input type="file" name="archivoAnthony" id="archivoAnthony">
                        <input type="button" class="btn btn-primary" id="btnCargarAnthony" value="Cargar">
                    </form>
                </h4>
            </div>
            <div id="collapseAnthony" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAnthony">
                <div class="panel-body">
<?php } ?>

<div class="row">
            
    <div class="col-lg-12">

        <div class="box box-widget widget-user">

            <div class="widget-user-header bg-aqua-active infoAgro">

                <h2 class="widget-user-username">
                    | <b> <?php echo $campo;?></b><br>
                    | Cultivos Invernales: <span id="hasInvPlanificacion<?php echo $campoId;?>"></span> Has.<br>
                    | Cultivos Cobertura: <span id="hasCobPlanificacion<?php echo $campoId;?>"></span>  Has.<br>
                    | Cultivos Estivales: <span id="hasEstPlanificacion<?php echo $campoId;?>"></span>  Has.<br>
                    | Ratio de Cultivo: <span id="ratioPlanificacion<?php echo $campoId;?>"></span>  %.
                </h2>
            
            </div>

            <div class="box-footer" style="padding-top:0px;padding-bottom:0px;">

                <div class="row"  style="font-size:1.5em;">

                    <div class="col-sm-4 border-right">

                        <div class="description-block btn" data-toggle="modal" data-target="#<?=strtolower($campoId)?>FinaDetalleModal">

                            <span class="description-text" style="font-size:1.5em">FINA</span>
                            <h4 class="description-text">
                                <span id="hasFinaPlanificacion<?php echo $campoId;?>"></span> Has. <br>
                                <span id="totalCostoFinaPlanificacion<?php echo $campoId;?>"></span> U$D <br>
                                <span id="costoFinaPlanificacionHas<?php echo $campoId;?>"></span> U$D/Has <br>
                            </h4>
                        </div>
                    </div>

                    <div class="col-sm-4 border-right">

                        <div class="description-block btn" data-toggle="modal" data-target="#<?=strtolower($campoId)?>CoberturaDetalleModal">
                            <span class="description-text" style="font-size:1.5em">COBERTURA</span>
                            <h4 class="description-text">
                                <span id="hasCoberturaPlanificacion<?php echo $campoId;?>"></span> Has. <br>
                                <span id="totalCostoCoberturaPlanificacion<?php echo $campoId;?>"></span> U$D <br>
                                <span id="costoCoberturaPlanificacionHas<?php echo $campoId;?>"></span> U$D/Has <br>
                            </h4>
                        </div>

                    </div>

                    <div class="col-sm-4">

                        <div class="description-block btn" data-toggle="modal" data-target="#<?=strtolower($campoId)?>GruesaDetalleModal">
                            <span class="description-text" style="font-size:1.5em">GRUESA</span>
                            <h4 class="description-text">
                                <span id="hasGruesaPlanificacion<?php echo $campoId;?>"></span> Has. <br>
                                <span id="totalCostoGruesaPlanificacion<?php echo $campoId;?>"></span> U$D <br>
                                <span id="costoGruesaPlanificacionHas<?php echo $campoId;?>"></span> U$D/Has <br>
                            </h4>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row">
    
    <div class="col-lg-6">
        
        <div class="info-box">

            <span class="info-box-icon bg-aqua"><i class="fa fa-map-o"></i></span>      

            <div class="info-box-content">

                <span class="info-box-text">Hectareas Totales</span>
                
                <span class="info-box-number"><span id="totalHasPlanificadas<?php echo $campoId;?>"></span> Has.</span>

            </div>

        </div>

    </div>

    <div class="col-lg-6">
        
        <div class="info-box">

            <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Inversion <br> Total Proyectada</span>
            <span class="info-box-number">U$D <span id="totalInversionPlanificada<?php echo $campoId;?>"></span></span>
            </div>

        </div>

    </div>

</div>

<?php if ($campoId == 'Anthony'){ ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
