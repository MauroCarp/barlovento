<style>
.month-slider-container {
    position: relative;
    padding: 0 40px;
}
.month-slider-track {
    display: flex;
    overflow: hidden;
    scroll-behavior: smooth;
    gap: 10px;
    padding: 10px 0;
}
.month-col {
    flex: 0 0 220px;
    min-width: 220px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}
.month-col .month-title {
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #555;
    border-bottom: 2px solid #3c8dbc;
    padding-bottom: 6px;
    margin-bottom: 10px;
}
.month-slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #3c8dbc;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    font-size: 16px;
    line-height: 32px;
    text-align: center;
    cursor: pointer;
    z-index: 10;
    padding: 0;
    transition: background 0.2s;
}
.month-slider-arrow:hover { background: #367fa9; }
.month-slider-arrow.arrow-left  { left: 0; }
.month-slider-arrow.arrow-right { right: 0; }

/* Tablero Sanitario: columnas más anchas */
#track-sanitario .month-col {
    flex: 0 0 260px;
    min-width: 260px;
}
.san-field {
    margin-bottom: 10px;
}
.san-field .san-label {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    color: #888;
    letter-spacing: 0.4px;
    margin-bottom: 3px;
}
.san-field .san-value {
    font-size: 15px;
    font-weight: 700;
    color: #333;
}
.san-cumplimiento-si  { color: #00a65a; }
.san-cumplimiento-no  { color: #dd4b39; }
.san-chart-wrap {
    position: relative;
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#ps-inventario" data-toggle="tab">Gestión de Inventario</a></li>
        <li><a href="#ps-engorde" data-toggle="tab">Dinámica de Engorde</a></li>
        <li><a href="#ps-eficiencia" data-toggle="tab">Eficiencia Física</a></li>
        <li><a href="#ps-sanitario" data-toggle="tab">Tablero Sanitario</a></li>
    </ul>
    <div class="tab-content">

        <!-- Gestión de Inventario -->
        <div class="tab-pane active" id="ps-inventario">
            <div class="month-slider-container">
                <button class="month-slider-arrow arrow-left"  data-target="track-inventario"><i class="fa fa-chevron-left"></i></button>
                <div class="month-slider-track" id="track-inventario">
                    <?php foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $mes): ?>
                    <div class="month-col">
                        <div class="month-title"><?= $mes ?></div>
                        <p class="text-muted text-center" style="font-size:12px;">Sin datos</p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="month-slider-arrow arrow-right" data-target="track-inventario"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Dinámica de Engorde -->
        <div class="tab-pane" id="ps-engorde">
            <div class="month-slider-container">
                <button class="month-slider-arrow arrow-left"  data-target="track-engorde"><i class="fa fa-chevron-left"></i></button>
                <div class="month-slider-track" id="track-engorde">
                    <?php foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $mes): ?>
                    <div class="month-col">
                        <div class="month-title"><?= $mes ?></div>
                        <p class="text-muted text-center" style="font-size:12px;">Sin datos</p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="month-slider-arrow arrow-right" data-target="track-engorde"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Eficiencia Física -->
        <div class="tab-pane" id="ps-eficiencia">
            <div class="month-slider-container">
                <button class="month-slider-arrow arrow-left"  data-target="track-eficiencia"><i class="fa fa-chevron-left"></i></button>
                <div class="month-slider-track" id="track-eficiencia">
                    <?php foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $mes): ?>
                    <div class="month-col">
                        <div class="month-title"><?= $mes ?></div>
                        <p class="text-muted text-center" style="font-size:12px;">Sin datos</p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="month-slider-arrow arrow-right" data-target="track-eficiencia"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Tablero Sanitario -->
        <div class="tab-pane" id="ps-sanitario">
            <div class="month-slider-container">
                <button class="month-slider-arrow arrow-left"  data-target="track-sanitario"><i class="fa fa-chevron-left"></i></button>
                <div class="month-slider-track" id="track-sanitario">
                    <?php
                    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                    foreach($meses as $idx => $mes):
                    ?>
                    <div class="month-col">
                        <div class="month-title"><?= $mes ?></div>

                        <!-- Cumplimiento de plan sanitario -->
                        <div class="san-field">
                            <div class="san-label">Cumplimiento de plan sanitario</div>
                            <div class="san-value san-cumplimiento-si">—</div>
                        </div>

                        <!-- Índice de mortandad -->
                        <div class="san-field">
                            <div class="san-label">Índice de mortandad %</div>
                            <div class="san-value">—</div>
                        </div>

                        <!-- Causas de mortandad (gráfico de torta) -->
                        <div class="san-field">
                            <div class="san-label">Causas de mortandad *</div>
                            <div class="san-chart-wrap">
                                <canvas id="chart-sanitario-<?= $idx ?>" width="120" height="120"></canvas>
                            </div>
                        </div>

                        <!-- Análisis de costos -->
                        <div class="san-field">
                            <div class="san-label">Análisis de costos ($/cab)</div>
                            <div class="san-value">—</div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="month-slider-arrow arrow-right" data-target="track-sanitario"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

    </div>
</div>

<script>
(function () {
    var scrollAmount = 240; // px por clic (ancho de columna + gap)

    $(document).on('click', '.month-slider-arrow', function () {
        var trackId = $(this).data('target');
        var track   = document.getElementById(trackId);
        if (!track) return;
        if ($(this).hasClass('arrow-left')) {
            track.scrollLeft -= scrollAmount;
        } else {
            track.scrollLeft += scrollAmount;
        }
    });

    /* ---- Gráficos de torta: Causas de mortandad ---- */
    /* Se inicializan cuando la pestaña sanitario es visible por primera vez */
    var sanitarioChartsInit = false;

    function initSanitarioCharts() {
        if (sanitarioChartsInit) return;
        sanitarioChartsInit = true;

        // Datos de ejemplo — reemplazar con datos reales
        var causasEjemplo = [
            { label: 'Respiratoria', color: '#3c8dbc' },
            { label: 'Digestiva',    color: '#f39c12' },
            { label: 'Traumática',   color: '#00a65a' },
            { label: 'Otras',        color: '#dd4b39' }
        ];
        var valoresEjemplo = [40, 30, 20, 10];

        for (var i = 0; i < 12; i++) {
            var canvas = document.getElementById('chart-sanitario-' + i);
            if (!canvas) continue;
            new Chart(canvas, {
                type: 'pie',
                data: {
                    labels: causasEjemplo.map(function(c){ return c.label; }),
                    datasets: [{
                        data: valoresEjemplo,
                        backgroundColor: causasEjemplo.map(function(c){ return c.color; }),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    tooltips: {
                        callbacks: {
                            label: function(item, data) {
                                return data.labels[item.index] + ': ' + data.datasets[0].data[item.index] + '%';
                            }
                        }
                    }
                }
            });
        }
    }

    /* Inicializar al hacer clic en la pestaña sanitario */
    $(document).on('shown.bs.tab', 'a[href="#ps-sanitario"]', function () {
        initSanitarioCharts();
    });

    /* Si la pestaña sanitario es la activa al cargar */
    if ($('#ps-sanitario').hasClass('active')) {
        $(function(){ initSanitarioCharts(); });
    }
})();
</script>
