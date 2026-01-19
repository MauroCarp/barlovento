

        
        
        <div class="row">
            
            <div class="col-lg-12">

                <div class="box box-widget widget-user">
    
                    <div class="widget-user-header bg-aqua-active infoAgro">

                        <h2 class="widget-user-username">
                            | <b> <?php echo $campo;?></b><br>
                            <span class="info-fina hide">| Cosecha Fina: <span id="cosechaFinaProduccion<?php echo $campoId;?>"></span><br>
                            | Rinde Fina: <span id="rindeFinaProduccion<?php echo $campoId;?>"></span><br>
                            | Flete Fina: <span id="fleteFinaProduccion<?php echo $campoId;?>"></span><br></span>
                            <span class="info-gruesa">| Cosecha Gruesa: <span id="cosechaGruesaProduccion<?php echo $campoId;?>"></span><br>
                            | Rinde Gruesa: <span id="rindeGruesaProduccion<?php echo $campoId;?>"></span><br>
                            | Flete Gruesa: <span id="fleteGruesaProduccion<?php echo $campoId;?>"></span><br></span>
                        </h2>
                    
                    </div>
        
                    <div class="box-footer" style="padding-top:0px;padding-bottom:0px;">
        
                        <div class="row"  style="font-size:1.5em;">
        
                            <div class="col-sm-4 border-right info-fina hide">
        
                                <div class="description-block">

                                    <span class="description-text">FINA</span>

                                    <h4 class="description-text">
                                        <span id="cosechaFinaProduccionDetalle<?php echo $campoId;?>"></span> Has<br>
                                        <span id="rindeFinaProduccionDetalle<?php echo $campoId;?>"></span> U$S/Has<br>
                                        <span id="fleteFinaProduccionDetalle<?php echo $campoId;?>"></span> U$S<br>
                                    </h4>

                                </div>
        
                            </div>
        
                            <div class="col-sm-4 border-right info-cobertura hide">
        
                                <div class="description-block">

                                    <span class="description-text">COBERTURA</span>

                                    <h4 class="description-text">
                                        <span id="cosechaCoberturaProduccion<?php echo $campoId;?>"></span> Has<br>
                                        <span id="rindeCoberturaProduccion<?php echo $campoId;?>"></span> U$S/Has<br>
                                        <span id="fleteCoberturaProduccion<?php echo $campoId;?>"></span> U$S<br>
                                    </h4>

                                </div>
        
                            </div>
        
                            <div class="col-sm-4 border-right info-gruesa">
        
                                <div class="description-block">

                                    <span class="description-text">GRUESA</span>

                                    <h4 class="description-text">
                                        <span id="cosechaGruesaProduccionDetalle<?php echo $campoId;?>"></span> Has<br>
                                        <span id="rindeGruesaProduccionDetalle<?php echo $campoId;?>"></span> U$S/Has<br>
                                        <span id="fleteGruesaProduccionDetalle<?php echo $campoId;?>"></span> U$S<br>
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

                    <span class="info-box-icon bg-aqua"><i class="fa fa-industry"></i></span>      

                    <div class="info-box-content">

                        <span class="info-box-text">Cosecha Total</span>
                        
                        <span class="info-box-number"><span id="totalCosechaProduccion<?php echo $campoId;?>"></span></span>

                    </div>
        
                </div>

            </div>
     
            <div class="col-lg-6">
                
                <div class="info-box">

                    <span class="info-box-icon bg-aqua"><i class="fa fa-truck"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text">Costo Flete Total</span>
                    <span class="info-box-number">U$D <span id="totalFleteProduccion<?php echo $campoId;?>"></span></span>
                    </div>
        
                </div>

            </div>
        
        </div>
