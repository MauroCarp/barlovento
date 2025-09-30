

<?php if ($campoId == 'Anthony'){ ?>
    <!-- Acordeón para Anthony -->
    <div class="panel-group" id="accordionAnthonyEjecucion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingAnthonyEjecucion" style="display:flex;justify-content:space-between;align-items:center;">
                <h4 class="panel-title" style="font-size:1.5em;">
                    <a role="button" data-toggle="collapse" data-parent="#accordionAnthonyEjecucion" href="#collapseAnthonyEjecucion" aria-expanded="false" aria-controls="collapseAnthonyEjecucion">
                        <i class="fa fa-chevron-down"></i><b> <?php echo $campoId; ?></b>     
                    </a>
                </h4>
                    <form action="" method="post" id="formAnthonyEjecucion" style="display:flex;align-items:center;">
                        <input type="file" name="archivoAnthonyEjecucion" id="archivoAnthonyEjecucion">
                        <input type="button" class="btn btn-primary" id="btnCargarAnthonyEjecucion" value="Cargar">
                    </form>
            </div>
            <div id="collapseAnthonyEjecucion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAnthonyEjecucion">
                <div class="panel-body">
<?php } ?>

        
        
        <div class="row">
            
            <div class="col-lg-12">

                <div class="box box-widget widget-user">
    
                    <div class="widget-user-header bg-aqua-active infoAgro">

                        <h2 class="widget-user-username">
                            | <b> <?php echo $campo;?></b><br>
                            <span class="info-fina hide">| Cultivos Invernales: <span id="hasInvEjecucion<?php echo $campoId;?>"></span> Has.<br>
                            | Cultivos Cobertura: <span id="hasCobEjecucion<?php echo $campoId;?>"></span>  Has.<br></span>
                            <span class="info-gruesa">| Cultivos Estivales: <span id="hasEstEjecucion<?php echo $campoId;?>"></span>  Has.<br></span>
                            | Ratio de Cultivo: <span id="ratioEjecucion<?php echo $campoId;?>"></span>  %.
                        </h2>
                    
                    </div>
        
                    <div class="box-footer" style="padding-top:0px;padding-bottom:0px;">
        
                        <div class="row"  style="font-size:1.5em;">
        
                            <div class="col-sm-4 border-right info-fina hide">
        
                                <div class="description-block">

                                    <span class="description-text">FINA</span>

                                    <h4 class="description-text">
                                        <span id="hasFinaEjecucion<?php echo $campoId;?>"></span> Has. <br>
                                        <span id="totalCostoFinaEjecucion<?php echo $campoId;?>"></span> U$D <br>
                                        <span id="costoFinaEjecucionHas<?php echo $campoId;?>"></span> U$D/Has <br>
                                    </h4>

                                </div>
        
                            </div>
        
                            <div class="col-sm-4 border-right info-cobertura hide">
        
                                <div class="description-block">

                                    <span class="description-text">COBERTURA</span>

                                    <h4 class="description-text">
                                        <span id="hasCoberturaEjecucion<?php echo $campoId;?>"></span> Has. <br>
                                        <span id="totalCostoCoberturaEjecucion<?php echo $campoId;?>"></span> U$D <br>
                                        <span id="costoCoberturaEjecucionHas<?php echo $campoId;?>"></span> U$D/Has <br>
                                    </h4>

                                </div>
        
                            </div>
        
                            <div class="col-sm-4 border-right info-gruesa">
        
                                <div class="description-block">

                                    <span class="description-text">GRUESA</span>

                                    <h4 class="description-text">
                                        <span id="hasGruesaEjecucion<?php echo $campoId;?>"></span> Has. <br>
                                        <span id="totalCostoGruesaEjecucion<?php echo $campoId;?>"></span> U$D <br>
                                        <span id="costoGruesaEjecucionHas<?php echo $campoId;?>"></span> U$D/Has <br>
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
                        
                        <span class="info-box-number"><span id="totalHasEjecucion<?php echo $campoId;?>"></span> Has.</span>

                    </div>
        
                </div>

            </div>
     
            <div class="col-lg-6">
                
                <div class="info-box">

                    <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Inversion <br> Total Ejecutada</span>
                    <span class="info-box-number">U$D <span id="totalInversionEjecucion<?php echo $campoId;?>"></span></span>
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