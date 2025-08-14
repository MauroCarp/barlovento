

<style>

    .v-tabs {
        display: -ms-flexbox !important;
        display: flex !important;
        .nav-tabs > li {
            display: block;
            float: none;
            &,
            &.active {
                > a {
                    &,
                    &:hover,
                    &:focus {
                        border-radius: 0;
                    }
                }
            }
            &.active > a,
            & > a:focus,
            & > a:hover {
                z-index: 1;
                position: relative;
            }
        }
        .tab-content {
            flex: 1;
        }
    }

    .vertical-text {
        writing-mode: vertical-rl; /* Establece el modo de escritura vertical */
        text-orientation: upright; /* Asegura que el texto se visualice verticalmente */
        white-space: nowrap; /* Evita que el texto se divida en varias líneas */
        background-color:white;
    }

</style>

<div class="tabCollapse v-tabs">

    <ul class="nav nav-tabs" role="tablist" style="position:fixed;z-index:2;top:40%;margin-left:-25px">
        <li role="presentation" class="active"><a href="#home" class="nav-link vertical-text"  style="border:solid 1px rgb(220,220,220);border-top-right-radius:5px;line-height:1.5em;padding:5px;" aria-controls="home" role="tab" data-toggle="tab"><b>RESULTADO</b></a></li>
        <li role="presentation"><a href="#profile" class="nav-link vertical-text" style="border:solid 1px rgb(220,220,220);border-bottom-right-radius:5px;line-height:1.5em;padding:5px;" aria-controls="profile" role="tab" data-toggle="tab"><b>PATRIMONIO</b></a></li>
    </ul>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="home">

            <?php

                include 'economicoProduccion.php';

            ?>

        </div>

        <div role="tabpanel" class="tab-pane" id="profile">
                        
            <?php

                include 'economicoPatrimonio.php';

            ?>

        </div>

    </div>

</div>

<?php

$tituloGrafico = 'Ventas Agricultura';
$idGraficoModal = 'graficoVentaModal' . $campo;
$idGrafico = 'idGraficoVentas'  . $campo;
include 'graficoContable.modal.php';

$tituloGrafico = 'Ventas Ganaderia';
$idGraficoModal = 'graficoVenta2Modal' . $campo;
$idGrafico = 'idGraficoVentas2'  . $campo;
include 'graficoContable.modal.php';

$tituloGrafico = 'Ventas Ganaderia por Lineas de Producto';
$idGraficoModal = 'graficoGanaderiaModal'  . $campo;
$idGrafico = 'idGraficoGanaderia2'  . $campo;
include 'graficoContable.modal.php';

$tituloGrafico = 'Bienes de Cambio';
$idGraficoModal = 'graficoBienesDeCambioModal'  . $campo;
$idGrafico = 'idGraficoBienesDeCambio'  . $campo;
include 'graficoContable.modal.php';

$tituloGrafico = 'Bienes de Uso';
$idGraficoModal = 'graficoBienesDeUsoModal'  . $campo;
$idGrafico = 'idGraficoBienesDeUso'  . $campo;
include 'graficoContable.modal.php';

$tituloGrafico = 'BAAI';
$idGraficoModal = 'graficoMargenVentaModal' . $campo;
$idGrafico = 'idGraficoMargenVentas' . $campo;
include 'graficoContable.modal.php';

?>


