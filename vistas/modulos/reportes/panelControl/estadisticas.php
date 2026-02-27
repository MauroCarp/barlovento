<style>
    .estadisticas-wrapper {
        position: relative;
        overflow: hidden;
    }

    .estadisticas-track {
        display: flex;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.45s ease-in-out;
    }

    .estadisticas-pane {
        width: 50%;
        padding-right: 10px;
    }

    .estadisticas-pane.alt {
        padding-left: 10px;
        padding-right: 0;
    }

    .estadisticas-toggle {
        position: fixed;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1050;
        background: #00a65a;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.25s ease, box-shadow 0.25s ease;
    }

    .estadisticas-toggle:hover {
        background: #00994f;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 991px) {
        .estadisticas-pane {
            width: 100%;
        }

        .estadisticas-track {
            width: 200%;
        }
    }
</style>

<div class="estadisticas-wrapper">
    <div class="estadisticas-track" id="estadisticasTrack">
        <div class="estadisticas-pane">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tasa: costo $Kg MS/ $Precio de venta - Promedio Anual:&nbsp;&nbsp;<span id="tasaMSPrecioVentaAnual<?php echo $i + 1;?>" style="font-weight:bold"></span></h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="graficoTasaMsPrecioVenta<?php echo $i + 1;?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Conversi&oacute;n de MS - Promedio Anual:&nbsp;&nbsp;<span; id="conversionMSAnual<?php echo $i + 1;?>" style="font-weight:bold"></span></h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="graficoConversionMS<?php echo $i + 1;?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">A.D.P.V - Promedio Anual:&nbsp;&nbsp;<span; id="ADPVAnual<?php echo $i + 1;?>" style="font-weight:bold"></span></h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="graficoADPV<?php echo $i + 1;?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Poblaci&oacute;n Promedio - Promedio Anual:&nbsp;&nbsp;<span; id="poblacionPromAnual<?php echo $i + 1;?>" style="font-weight:bold"></span></h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="graficoPoblacionProm<?php echo $i + 1;?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Estadia Promedio - Promedio Anual:&nbsp;&nbsp;<span; id="estadiaPromAnual<?php echo $i + 1;?>" style="font-weight:bold"></span></h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="graficoEstadiaProm<?php echo $i + 1;?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Indice de Reposici&oacute;n - Promedio Anual:&nbsp;&nbsp;<span; id="indiceReposicionAnual<?php echo $i + 1;?>" style="font-weight:bold"></span></h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="graficoIR<?php echo $i + 1;?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="estadisticas-pane alt">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Kg producidos vendidos - Total:&nbsp;&nbsp;<span id="kgProdVendidoAnual<?php echo $i + 1;?>" style="font-weight:bold"></span></h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="graficoKgProdVendido<?php echo $i + 1;?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

<button class="estadisticas-toggle" id="estadisticasToggle" aria-label="Cambiar vista">
    <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
</button>

<script>
    (function () {
        var track = document.getElementById('estadisticasTrack');
        var toggle = document.getElementById('estadisticasToggle');
        if (!track || !toggle) {
            return;
        }

        var position = 0;

        toggle.addEventListener('click', function () {
            position = position === 0 ? 1 : 0;
            track.style.transform = position === 0 ? 'translateX(0)' : 'translateX(-50%)';
        });
    })();
</script>
