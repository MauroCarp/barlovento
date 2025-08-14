
<div id="modalEditarParcela" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content" style="width:350px;margin:0 auto">


        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

            <div class="box-body">

                <div class="box box-widget widget-user-2">
              
                    <div class="widget-user-header" id="cabezeraModalPastoreo">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h3>Detalle celula <span id="detalleCelula"></span> | Lote <span id="detalleLote"></span> Parcela <span id="detalleParcela"></span></h3>

                    </div>
                    <br>
                    <div class="box-footer no-padding" id="datosParcela">

                        <ul class="nav nav-stacked">

                            <li>
                                <div class="form-group">
                                    <label for="entradaPlanificado">Fecha Entrada Planificado:</label>
                                    <input type="date" class="form-control" id="entradaPlanificado" readOnly>
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <label for="salidaPlanificado">Fecha Salida Planificado:</label>
                                    <input type="date" class="form-control" id="salidaPlanificado" readOnly>
                                </div>
                            </li>
                            
                            <li>
                                <div class="form-group">
                                    <label for="diasPlanificado">Dias Pastoreo Planificado:</label>
                                    <input type="number" class="form-control" id="diasPlanificado" readOnly>
                                </div>
                            </li>

                            <form method="post" id="formPastoreo">
                                <input type="hidden" name="idRegistro" id="idRegistro">
                                <li>
                                    <div class="form-group">
                                        <label for="entradaReal">Fecha Entrada Real:</label>
                                        <input type="date" class="form-control" id="entradaReal" name="entradaReal" readOnly>
                                    </div>
                                </li>

                                <li>
                                    <div class="form-group">
                                        <label for="salidaReal">Fecha Salida Real:</label>
                                        <input type="date" class="form-control" id="salidaReal" name="salidaReal" readOnly>
                                    </div>
                                </li>
                                
                            </form>

                            <li>
                                <div class="form-group">
                                    <label for="diasPastoreoReal">Dias Pastoreo Real:</label>
                                    <input type="number" class="form-control" id="diasPastoreoReal" readOnly>
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <label for="recuperacion">Tiempo de Recuperaci&oacute;n:</label>
                                    <input type="number" class="form-control" id="recuperacion" readOnly>
                                </div>
                            </li>

                        </ul>

                        <button class="btn btn-default" id="mostrarRegistroParsela" type="button">Mostrar Historico</button>

                        <button class="btn btn-primary" name="cargarPastoreo" type="submit" form="formPastoreo" style="float:right">Actualizar Registro</button>
                        <br>
                        <br>
                    </div>

                    <div class="box-footer no-padding hidden" id="noData" >
                        <h1>No hay datos para esta Parcela</h1>
                        <button class="btn btn-default btn-block mostrarRegistroParsela" type="button">Mostrar Historico</button>
                        <br><br>
                    </div>


                </div>

            </div>

        </div>

    </div>

  </div>

</div>

<?php
$actualizarRegistro = new ControladorPastoreo();
$actualizarRegistro->ctrCargarRegistro();
?>