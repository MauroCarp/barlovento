
<div id="modalHistoricoParcela" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content" style="width:350px;margin:0 auto">


        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

            <div class="box-body">

                <div class="box box-widget widget-user-2">
              
                    <div class="widget-user-header bg-primary" id="cabezeraModalPastoreo">

                        <h3>Historico</h3>
                            
                    </div>
                    
                    <div style="max-width:100%;overflow-x:scroll">

                        <table class="table table-bordered table-striped dt-responsive tablasModal" id="miTabla">

                            <thead>

                                <tr>

                                    <th colspan="2" style="color:#757575;background-color:#eaeaea;text-align:center;">Potrero</th>
                                    <th colspan="3" style="color:#757575;background-color:#cfeeb9;text-align:center;">Planificado</th>
                                    <th colspan="3" style="color:#757575;background-color:#fff1c8;text-align:center;">Real</th>
                                    <th rowspan="2" style="color:#757575;background-color:#fff1c8;text-align:center;vertical-align:middle;">Tiempo de Recuperaci&oacute;n</th>

                                </tr>

                                <tr>

                                    <th>Lote</th>
                                    <th>Parcela</th>
                                    <th>D&iacute;a Entrada</th>
                                    <th>D&iacute;a Salida</th>
                                    <th>D&iacute;a de Pastoreo</th>
                                    <th>D&iacute;a Entrada</th>
                                    <th>D&iacute;a Salida</th>
                                    <th>D&iacute;a de Pastoreo</th>

                                </tr>
                                
                            </thead>

                            <tbody id="tbodyHistoricoParcela">
                            </tbody>

                        </table>

                    </div>

                    <hr>
                    
                    <button class="btn btn-default" type="button" id="btnVolverDetalleParcela">Volver</button>

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

<!-- <table class="table table-bordered table-striped dt-responsive tablasModal">

<thead>
<tr>
<td colspan="2" style="text-align:center;font-weight:bolder;color:grey">Potrero</td>
<td colspan="3" style="text-align:center;font-weight:bolder;color:green">Planificado</td>
<td colspan="3" style="text-align:center;font-weight:bolder;color:yellow">Real</td>
<td rowspan="2" style="text-align:center;font-weight:bolder;vertical-align:middle">Tiempo de Recuperaci&oacute;n</td>
</tr>
<tr>
<th>Lote</th>
<th>Parcela</th>
<th>D&iacute;a Entrada</th>
<th>D&iacute;a Salida</th>
<th>D&iacute;a de Pastoreo</th>
<th>D&iacute;a Entrada</th>
<th>D&iacute;a Salida</th>
<th>D&iacute;a de Pastoreo</th>
<th></th>
</tr>
</thead>
<tbody>
<tr>
<td>a</td>
<td>s</td>
<td>a</td>
<td>a</td>
<td>a</td>
<td>a</td>
<td>a</td>
<td>a</td>
<td>a</td>
</tr>
</tbody>
</table> -->