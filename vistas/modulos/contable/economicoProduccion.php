            <?php

                include 'cajasEconomico.php';

            ?>

            <div class="row">

                <div class="col-lg-4"> 
                        
                    <div class="row">

                        <div class="col-lg-12">
                            
                            <div class="box box-success">

                                <div class="box-header with-border">

                                    <h3 class="box-title">Resultado al <span id="periodoResultadoAl<?=$campo?>"></span></h3>
                                    <span class="pull-right" id="resultadoAl<?=$campo?>"></span>
                                </div>

                                <div class="box-body" style="padding:0;padding-left:5px">

                                    <div class="chart">
                                        
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                                <tr style="background-color:rgba(0,0,255,.2);font-weight:bolder;">
                                                    <td  style="line-height:0.7em;">Ganancias</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionGanancias<?=$campo?>"></td>
                                                </tr>
                                                <tr>
                                                    <td  style="line-height:0.7em;">Directas</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionGananciasDirectas<?=$campo?>"></td>
                                                </tr>
                                                <tr>
                                                    <td  style="line-height:0.7em;">Financieras</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionGananciasFinancieras<?=$campo?>"></td>
                                                </tr>
                                                <tr style="background-color:rgba(0,0,255,.2);font-weight:bolder;">
                                                    <td  style="line-height:0.7em;">Perdidas</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionPerdidas<?=$campo?>"></td>
                                                </tr>
                                                <tr>
                                                    <td  style="line-height:0.7em;">Directas</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionPerdidasDirectas<?=$campo?>"></td>
                                                </tr>
                                                <tr>
                                                    <td  style="line-height:0.7em;">Indirectas</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionPerdidasIndirectas<?=$campo?>"></td>
                                                </tr>
                                                <tr>
                                                    <td  style="line-height:0.7em;">Financieras</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionPerdidasFinancieras<?=$campo?>"></td>
                                                </tr>
                                                <tr>
                                                    <td  style="line-height:0.7em;">Impuestos</td>
                                                    <td  style="line-height:0.7em;text-align:right" id="produccionImpuestos<?=$campo?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- <canvas id="ventasChart<?//=$campo?>"></canvas> -->

                                    </div>

                                </div>
                            
                            </div>

                        </div>

                    </div>

                </div>

                <!-- VENTAS GANADERIA -->
                <div class="col-lg-4">
                    
                    <div class="row">

                        <div class="col-lg-12">
                            
                            <div class="box box-success">

                                <div class="box-header with-border">

                                    <h3 class="box-title">Ventas Ganaderia</h3>

                                    <div class="box-tools pull-right" bis_skin_checked="1">

                                        <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoVentas2<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                                        </button>

                                    </div>
                                </div>


                                <div class="box-body">

                                    <div class="chart">

                                        <canvas id="ventasChart2<?=$campo?>"></canvas>

                                    </div>

                                </div>
                            
                            </div>

                        </div>

                    </div>

                </div>

                <!-- VENTAS POR PORUDCTO -->
                <div class="col-lg-4">
                    
                    <div class="row">

                        <div class="col-lg-12">
                            
                            <div class="box box-success">

                                <div class="box-header with-border">

                                    <h3 class="box-title">Ventas Ganader&iacute;a por L&iacute;neas de Producto</h3>

                                    <div class="box-tools pull-right" bis_skin_checked="1">

                                        <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoGanaderia<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                                        </button>

                                    </div>
                                </div>


                                <div class="box-body">

                                    <div class="chart">

                                        <canvas id="ventasGanaderiaChart<?=$campo?>"></canvas>

                                    </div>

                                </div>
                            
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row">

                <!-- M/V  -->
                <div class="col-lg-4">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="box box-success">

                                <div class="box-header with-border">

                                    <h3 class="box-title">Rdo. Bruto/Ventas - Rdo. Operativo/Ventas - Rdo. Neto/Ventas</h3>

                                </div>


                                <div class="box-body">

                                    <div class="chart">
                                    
                                        <canvas id="margenRtdoOpereativoVentasChart<?=$campo?>"></canvas>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- UTILIDAD NETA -->
                <div class="col-lg-4">
                
                    <div class="row">

                        <div class="col-lg-12">
                        
                            <div class="box box-success">

                                <div class="box-header with-border">

                                    <h3 class="box-title">Rdo. Neto - Rdo. Neto Acum. </h3>

                                    <div class="box-tools pull-right" bis_skin_checked="1">

                                        <button type="button" class="btn btn-box-tool zoomGraficos" data-modal="zGraficoMargenVentas<?=$campo?>" data-widget="zoom"><i class="fa fa-search-plus"></i>
                                        </button>

                                    </div>

                                </div>


                                <div class="box-body">

                                    <div class="chart">

                                        <canvas id="margenVentasChart<?=$campo?>"></canvas>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RENTA ACTIVO -->
                <div class="col-lg-4">
                
                    <div class="row">

                        <div class="col-lg-12">
                        
                            <div class="box box-success">

                                <div class="box-header with-border">

                                    <h3 class="box-title">Rdo. Neto/Activo - Rdo. Neto/Patrimonio Neto</h3>

                                </div>


                                <div class="box-body">

                                    <div class="chart">
                                    
                                        <canvas id="rentabilidadEconomicaChart<?=$campo?>"></canvas>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <?php

            include 'cajasEconomicoFooter.php';

            ?>