<div class="row">

        <div class="col-md-12">

            <div class="nav-tabs-custom">

                <ul class="nav nav-tabs" id="tabsCiclos" style="font-size:1.5em;">
            
                    <li class='tabs active' id='economicoTab<?=$campo?>'><a href='#tab_1<?=$campo?>' data-toggle='tab' id="btnEconomico<?=$campo?>"><b>Economico</b></a></li>
                    <li class='tabs' id='financieroTab<?=$campo?>'><a href='#tab_2<?=$campo?>' data-toggle='tab' id="btnFinanciero<?=$campo?>"><b>Financiero</b></a></li>
                    <li class='tabs' id='impositivoTab<?=$campo?>'><a href='#tab_3<?=$campo?>' data-toggle='tab' id="btnImpositivo<?=$campo?>"><b>Impositivo</b></a></li>

                </ul>

                <div class="tab-content">


                    <div class='tab-pane active' id='tab_1<?=$campo?>'>

                    <?php
                        
                        include 'economico.php';
                    ?>
                    
                    </div>

                    <div class='tab-pane' id='tab_2<?=$campo?>'>

                    <?php
                        
                        include 'financiero.php';
                    ?>

                    </div>

                    <div class='tab-pane' id='tab_3<?=$campo?>'>
                    
                    <?php
                        
                        include 'impositivo.php';
                    ?>
                    
                    </div>
                    
                </div>

            </div>

        </div>

</div>