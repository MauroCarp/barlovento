<div class="row">

    <div class='col-md-12'>

        <div class='nav-tabs-custom'>

            <ul class='nav nav-tabs' id='tabsProduccion' style='font-size:1.2em;'>
                <li class='tabs active' id='betyTabProduccion'><a href='#tab_1Produccion' data-toggle='tab' id="btnBetyProduccion"><b>La Bety</b></a></li>
                <li class='tabs' id='pichiTabProduccion'><a href='#tab_2Produccion' data-toggle='tab' id="btnPichiProduccion"><b>El Pichi</b></a></li>
                <li class='tabs' id='antonyTabProduccion'><a href='#tab_3Produccion' data-toggle='tab' id="btnAntonyProduccion"><b>Antony</b></a></li>
            </ul>

            <div class='tab-content'>

                <div class='tab-pane active' id='tab_1Produccion'>
                    <?php
                        $idTablaProduccion = 'tablaProduccionBety';
                        include 'tablas/produccion.php';
                        // Gráfico debajo de la tabla (La Bety)
                        $idGraficoProduccion = 'graficoProduccionBety';
                        include 'graficos/produccion.php';
                    ?>
                </div>

                <div class='tab-pane' id='tab_2Produccion'>
                    <?php
                        $idTablaProduccion = 'tablaProduccionPichi';
                        include 'tablas/produccion.php';
                        // Gráfico debajo de la tabla (El Pichi)
                        $idGraficoProduccion = 'graficoProduccionPichi';
                        include 'graficos/produccion.php';
                    ?>
                </div>

                <div class='tab-pane' id='tab_3Produccion'>
                    <?php
                        $idTablaProduccion = 'tablaProduccionAntony';
                        include 'tablas/produccion.php';
                        // Gráfico debajo de la tabla (Antony)
                        $idGraficoProduccion = 'graficoProduccionAntony';
                        include 'graficos/produccion.php';
                    ?>
                </div>

            </div>

        </div>

    </div>

</div>
