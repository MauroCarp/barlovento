<?php
 /// OBTENCION DE DATOS


    /*********
             POBLACION SEGUN SEXO
                                    ********/
    // MACHOS
    $item = 'adpvT';

    $valor = '';

    $item2 = 'categoria';

    $valor2 = 'NT';

    $operador = '!=';

    $totalMachosNT = ControladorDatos::ctrContarDatos($item,$valor,$item2,$valor2,$operador,true);

    $valor2 = 'TO';

    $totalMachosTO = ControladorDatos::ctrContarDatos($item,$valor,$item2,$valor2,$operador,true);

    $totalMachos = (int)$totalMachosNT[0] + (int)$totalMachosTO[0];

    // HEMBRAS
                                    
    $valor2 = 'VQ';

    $totalHembras = ControladorDatos::ctrContarDatos($item,$valor,$item2,$valor2,$operador,true);

    /*********
                 % POBLACION
                                    ********/
    // $totalAnimalesT = $totalMachos[0] + $totalHembras[0];

    $totalAnimalesT = ControladorDatos::ctrContarDatos($item,$valor,null,$valor2,$operador,true);

    $restoAnimales = $totalAnimales[0] - $totalAnimalesT[0];
                  
    /*********
                     ADPV
                                    ********/

    $item = NULL;
    $valor = NULL;
    $campo = 'adpvT';
    $sumaADPV = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

    $totalAdpvT = $sumaADPV[0][0];
    $promedioAdpvT = number_format(($totalAdpvT / $totalAnimalesT[0]),2);

                                
    /*********
                     DIAS 
                                    ********/
    
    $campo = 'diasT';
    $totalDias = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

    $totalDiasT = $totalDias[0][0];

    $promedioDiasT = round(($totalDiasT / $totalAnimalesT[0]));
            
    /*********
                    KG INGRESO
    //                                 ********/
    
    // $campo = 'kgIngresoT';
    // $kilosIng = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

    // $kilosIngRR = $kilosIng[0][0];

    // $promedioKgIngT = number_format(($kilosIngRR / $totalAnimalesT[0]),2);

    // /*********
    //                 KG SALIDA
    //                                 ********/
    
    // $campo = 'kgSalidaT';
    // $kilosEgrPR = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

    // $kilosEgrPR = $kilosEgrPR[0][0];

    // $promedioKgEgrT = number_format(($kilosEgrPR / $totalAnimalesT[0]),2);

                                    
    /*********
                 KG PRODUCCION
                                    ********/

    
    $campo = 'kgProdT';
    $kilosProd = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

    $kilosProdT = $kilosProd[0][0];

    $promedioKgProdT = number_format(($kilosProdT / $totalAnimalesT[0]),2);

?>
<br>


<div class="row">

    <div class="col-md-4">
      <!-- BAR CHART -->
      <div class="box box-success">
          <div class="box-header with-border">
          <h3 class="box-title">ADPV</h3>
          </div>
          <div class="box-body">
          <div class="chart">
              <canvas id="barChartT" style="height:230px"></canvas>
          </div>
          </div>

      </div>
    
    </div>

    <div class="col-md-4">
      <!-- BAR CHART -->
      <div class="box box-success">
          <div class="box-header with-border">
          <h3 class="box-title">Días</h3>
          </div>
          <div class="box-body">
          <div class="chart">
              <canvas id="barChart1T" style="height:230px"></canvas>
          </div>
          </div>

      </div>
    
    </div>

    <div class="col-md-4">  
        
        <!-- DONUT CHART -->
        <div class="box box-danger">
        
            <div class="box-header with-border">
            
            <h3 class="box-title">% Participaci&oacute;n  / Total: <?php echo $totalAnimalesT[0];?> Animales</h3>

            </div>
            
            <div class="box-body">

                <canvas id="pieChart1T" style="height:150px"></canvas>

            </div>
        
        </div>

    </div>

</div>

<div class="row">

      <div class="col-md-4">
        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Kg Ingreso</h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="barChart2T" style="height:230px"></canvas>
            </div>
          </div>

        </div>
        

      </div>

      <div class="col-md-4">
        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Kg Salida</h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <!-- <canvas id="barChart3T" style="height:230px"></canvas> -->
            </div>
          </div>

        </div>
        

      </div>

      <div class="col-md-4">
        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Kg Produc.</h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="barChart4T" style="height:230px"></canvas>
            </div>
          </div>

        </div>
        

      </div>

</div>


<script>
// POBLACION

data = [<?php echo $totalMachos.",".$totalHembras[0].",";?>];

label = ['Macho','Hembra'];
        
let configPSST = configuracionPie(data,label);

// PARTICIPACION

data = [<?php echo $totalAnimalesT[0] . "," . $restoAnimales.",";?>];

label = ['Población T','Resto Población'];

let configPPT = configuracionPie(data,label);

// ADPV

var color = Chart.helpers.color;

data = [ <?php echo $promedioAdpvT;?> ];

label = ['Prom. Adpv'];

label2 = 'Kg. Prom';

let configADPVT = configuracionBar(label,data,label2);

// DIAS

label = ['Prom. Dias'];

label2 = 'Dias';

data = [<?php echo $promedioDiasT;?>];

let configDiasT = configuracionBar(label,data,label2);

// KG PROD

label = ['Prom. Kg Produc.'];

data = [<?php echo $promedioKgProdT;?>];

let configKgProdT = configuracionBar(label,data,label2);




</script>
