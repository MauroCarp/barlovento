<?php

include 'cajasImpositivo.php';

?>

<div class="row">
            
    <div class="col-lg-4">
                
        <div class="box box-success">

            <div class="box-header with-border">
                
                <h3 class="box-title">Sueldos 1 + 2 / Ventas</h3>

                <div class="box-tools pull-right" bis_skin_checked="1">

                    <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoSueldos12<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                    </button>

                </div>
                
            </div>
            
            <div class="box-body">
                
                <div class="chart">

                    <canvas id="sueldos12Ventas<?=$campo?>" style="height:100px"></canvas>
                
                </div>

            </div>

        </div>

    </div>
            
    <div class="col-lg-4">
                
        <div class="box box-success">

            <div class="box-header with-border">
                
                <h3 class="box-title">Sueldos 1 + 2 + Honorarios / Ventas</h3>

                <div class="box-tools pull-right" bis_skin_checked="1">

                    <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoSueldos12Honorarios<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                    </button>

                </div>
                
            </div>
            
            <div class="box-body">
                
                <div class="chart">

                    <canvas id="sueldos12HonorariosVentas<?=$campo?>" style="height:100px"></canvas>
                
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row">
    
    <div class="col-lg-4">
                
        <div class="box box-success">

            <div class="box-header with-border">

                <h3 class="box-title">Saldo Iva</h3>

                <div class="box-tools pull-right" bis_skin_checked="1">

                    <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoSaldoIva<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                    </button>

                </div>


            </div>


            <div class="box-body">

                <div class="chart">

                    <canvas id="saldoIva<?=$campo?>"></canvas>

                </div>

            </div>

        </div>
        
    </div>

    <div class="col-lg-4">
                    
        <div class="box box-success">

            <div class="box-header with-border">

                <h3 class="box-title">Cargas Sociales</h3>

                <div class="box-tools pull-right" bis_skin_checked="1">

                    <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoCargasSociales<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                    </button>

                </div>


            </div>


            <div class="box-body">

                <div class="chart">

                    <canvas id="cargasSocialesGrafico<?=$campo?>"></canvas>

                </div>

            </div>

        </div>
        
    </div>

</div>

<?php
include 'cajasImpositivoFooter.php';

$tituloGrafico = 'Saldo IVA';
$idGraficoModal = 'graficoSaldoIvaModal' . $campo;
$idGrafico = 'idGraficoSaldoIva' . $campo;

include 'graficoContable.modal.php';

$tituloGrafico = 'Sueldos 1 + 2 / Ventas';
$idGraficoModal = 'graficoSueldo12Modal' . $campo;
$idGrafico = 'idGraficoSueldo12' . $campo;

include 'graficoContable.modal.php';

$tituloGrafico = 'Sueldos 1 + 2 + Horarios / Ventas';
$idGraficoModal = 'graficoSueldo12HonorarioModal' . $campo;
$idGrafico = 'idGraficoSueldo12Honorario' . $campo;

include 'graficoContable.modal.php';

$tituloGrafico = 'Cargas Sociales';
$idGraficoModal = 'graficoCargasSocialesModal' . $campo;
$idGrafico = 'idGraficoCargasSociales' . $campo;

include 'graficoContable.modal.php';
