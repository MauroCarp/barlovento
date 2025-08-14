                
    <?php

        include 'cajasEconomicoPatrimonio.php';

    ?>
<div class="row">

    <div class="col-lg-4">
        
        <div class="box box-success">

            <div class="box-header with-border">

                <h3 class="box-title">ESTADO DE SITUACION PATRIMONIAL AL <span id="periodoPatrimonioAl<?=$campo?>"></span></h3>
            </div>

            <div class="box-body" style="padding:0;padding-left:5px">

                <div class="chart">
                    
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr style="background-color:rgba(0,0,255,.2);font-weight:bolder;">
                                <td  style="line-height:0.7em;">Activo</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioActivo<?=$campo?>"></td>
                            </tr>
                            <tr style="background-color:rgba(51,255,255,.2)">
                                <td  style="line-height:0.7em;">Activo Corriente</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioActivoCorriente<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Disponibilidades</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioDisponibilidad<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Inversiones</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioInversiones<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Moneda Extranjera</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioMonedaExtranjera<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Creditos</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioCreditos<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Bienes de Cambio</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioBienesDeCambio<?=$campo?>"></td>
                            </tr>
                            <tr style="background-color:rgba(51,255,255,.2)">
                                <td  style="line-height:0.7em;">Activo No Corriente</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioActivoNoCorriente<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Bienes de Uso</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioBienesDeUso<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">OTROS CREDITOS</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioOtrosCreditos<?=$campo?>"></td>
                            </tr>
                            <tr style="background-color:rgba(0,0,255,.2);font-weight:bolder;">
                                <td  style="line-height:0.7em;">Pasivo</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioPasivo<?=$campo?>"></td>
                            </tr>
                            <tr style="background-color:rgba(51,255,255,.2)">
                                <td  style="line-height:0.7em;">Pasivo Corriente</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioPasivoCorriente<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Deudas</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioDeudas<?=$campo?>"></td>
                            </tr>
                            <tr style="background-color:rgba(0,0,255,.2);font-weight:bolder;">
                                <td  style="line-height:0.7em;">Patromonio Neto</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioPatrimonioNeto<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Capital</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioCapital<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Reservas</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioReservas<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Resultados Acumulados</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioResultadoAcumulado<?=$campo?>"></td>
                            </tr>
                            <tr>
                                <td  style="line-height:0.7em;">Resultado del Ejercicio</td>
                                <td  style="line-height:0.7em;text-align:right" id="patrimonioResultadoEjercicio<?=$campo?>"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">
        
        <div class="row">

            <div class="col-lg-12">
                
                <div class="box box-success">

                    <div class="box-header with-border">

                        <h3 class="box-title">Bienes de Cambio</h3>

                        <div class="box-tools pull-right" bis_skin_checked="1">

                            <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoBienesDeCambio<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                            </button>

                        </div>
                    </div>


                    <div class="box-body">

                        <div class="chart">

                            <canvas id="bienesDeCambioChart<?=$campo?>"></canvas>

                        </div>

                    </div>
                
                </div>

            </div>

        </div>     

    </div>

    <div class="col-lg-4">

        <div class="row">

            <div class="col-lg-12">
                
                <div class="box box-success">

                    <div class="box-header with-border">

                        <h3 class="box-title">Bienes de Uso</h3>

                        <div class="box-tools pull-right" bis_skin_checked="1">

                            <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoBienesDeUso<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                            </button>

                        </div>
                    </div>


                    <div class="box-body">

                        <div class="chart">

                            <canvas id="bienesDeUsoChart<?=$campo?>"></canvas>

                        </div>

                    </div>
                
                </div>

            </div>

        </div>

    </div>

</div>
    <?php

        include 'cajasEconomicoPatrimonioFooter.php';

    ?>