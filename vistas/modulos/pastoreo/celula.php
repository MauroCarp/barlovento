<div class="box <?=($celula == 'amarilla') ? '" ' . $color : 'box-' . $color?>">

    <div class="box-header with-border">

        <h3 class="box-title"><?=ucfirst($celula)?></h3>

    </div>

    <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablaCelula" width="100%">
    
                <thead>
                
                <tr>
                
                <th>Lote</th>
                <th>Parcela</th>
                <th>Entrada Planificada</th>
                <th>Salida Planificada</th>
                <th>Dias de Pastoreo</th>
                <th>Entrada Real</th>
                <th>Salida Real</th>
                <th>Dias de Pastoreo Real</th>
                <th>Tiempo de Recuperaci&oacute;n</th>
                <th></th>
                
                </tr> 
                
                </thead>
                
                <tbody>
                
                <?php
                    
                    $item = 'celula';
                    
                    $pastoreos = ControladorPastoreo::ctrMostrarRegistros($item, $celula);
                    
                    foreach ($pastoreos as $key => $value){
                    
                    $planificada1 = new DateTime($value["ingresoPlanificado"]);
                    $planificada2 = new DateTime($value["salidaPlanificado"]);
                    
                    $diffPlanificado = $planificada1->diff($planificada2);
                    
                    $diasPlanificado = $diffPlanificado->days;
                    
                    
                    $diasReal = 0;
                    $diasRecuperacion = 0;
                    
                    if($value["salidaReal"] != null && $value["salidaReal"] != '0000-00-00'){
                        
                        $real1 = new DateTime($value["ingresoReal"]);
                        $real2 = new DateTime($value["salidaReal"]);
                    
                        $diffReal = $real1->diff($real2);
                    
                        $diasReal = $diffReal->days;
                    
                        $today = new DateTime();
                        $recuperacion =  $real2->diff($today);
                        $diasRecuperacion = $recuperacion->days;
                    
                    }

                    $ingresoReal = "";
                    
                    if($value["ingresoReal"] != '' && $value["ingresoReal"] != null && $value["ingresoReal"] != '0000-00-00'){
                        $ingresoReal = date('d-m-Y',strtotime($value["ingresoReal"]));
                    }
                    
                    $salidaReal = "";

                    if($value["salidaReal"] != '' && $value["salidaReal"] != null && $value["salidaReal"] != '0000-00-00'){
                        $salidaReal = date('d-m-Y',strtotime($value["salidaReal"]));
                    }

                    echo '
                    <tr>
                        <td>'. $value["lote"] .'</td>
                        <td>'. $value["parcela"] .'</td>
                        <td>'. date('d-m-Y',strtotime($value["ingresoPlanificado"])) .'</td>
                        <td>'. date('d-m-Y',strtotime($value["salidaPlanificado"])) .'</td>
                        <td>'. $diasPlanificado .'</td>
                        <td>'. $ingresoReal . '</td>
                        <td>'. $salidaReal . '</td>
                        <td>'. $diasReal .'</td>
                        <td>'. $diasRecuperacion .'</td>
                        <td>
                    
                            <div class="btn-group">
                                
                            <button class="btn btn-warning btnEditarParcela" cell="'. $celula .'" idParcela="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarParcela"><i class="fa fa-pencil"></i></button>
                    
                            <button class="btn btn-danger btnEliminarPlanificacion" idPlanificacion="'.$value["id"].'"><i class="fa fa-times"></i></button>
                    
                            </div>  
                    
                        </td>
                    
                    </tr>';
                    }
                    
                
                ?> 
                
                </tbody>
                
            </table>

    </div>
                        
</div>
        
       


