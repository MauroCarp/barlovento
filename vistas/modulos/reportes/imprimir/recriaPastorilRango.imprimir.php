<?php
 /// OBTENCION DE DATOS


    /*********
             POBLACION SEGUN SEXO
                                    ********/
    // MACHOS
    $item = 'adpvRP';

    $valor = '';

    $item2 = 'categoria';

    $valor2 = 'NT';

    $operador = '!=';

    $item3 = 'fechaSalida';

    $fecha1 = $fechaInicial;

    $fecha2 = $fechaFinal;

    $totalMachosNT = ControladorDatos::ctrContarDatosRango($item, $valor,$item2, $valor2, $operador,$item3,$fecha1,$fecha2);
    
    $valor2 = 'TO';
    
    $totalMachosTO = ControladorDatos::ctrContarDatosRango($item, $valor,$item2, $valor2, $operador,$item3,$fecha1,$fecha2);

    $totalMachosRP = ( (int)$totalMachosNT[0] + (int)$totalMachosTO[0]); 

    // HEMBRAS
                                    
    $valor2 = 'VQ';

    $totalHembras = ControladorDatos::ctrContarDatosRango($item, $valor,$item2, $valor2, $operador,$item3,$fecha1,$fecha2);

    /*********
                 % POBLACION
                                    ********/
    $totalAnimalesRP = $totalMachosRP + $totalHembras[0];

    $restoAnimales = $totalAnimalesCC - $totalAnimalesRP;

    /*********
                     ADPV
                                    ********/

    $item = NULL;

    $valor = NULL;

    $item2 = 'fechaSalida';

    $campo = 'adpvRP';

    $sumaADPV = ControladorDatos::ctrSumarCampoRango($item, $valor,$campo,$item2,$fecha1,$fecha2);

    $totalAdpvRP = $sumaADPV[0][0];
    $promedioAdpvRP = number_format(($totalAdpvRP / $totalAnimalesRP),2);

                                
    /*********
                     DIAS 
                                    ********/
    
    $campo = 'diasRP';
    $totalDias = ControladorDatos::ctrSumarCampoRango($item, $valor,$campo,$item2,$fecha1,$fecha2);

    $totalDiasRP = $totalDias[0][0];

    $promedioDiasRP = round(($totalDiasRP / $totalAnimalesRP));
            
                                    
    /*********
                 KG PRODUCCION
                                    ********/

    
    $campo = 'kgProdRP';
    $kilosProd = ControladorDatos::ctrSumarCampoRango($item, $valor,$campo,$item2,$fecha1,$fecha2);

    $kilosProdRP = $kilosProd[0][0];

    $promedioKgProdRP = number_format(($kilosProdRP / $totalAnimalesRP),2);

?>

<h2>Recr&iacute;a Pastoril</h2>

<div class="row">

    <div class="col-md-4">
      <!-- BAR CHART -->
      <div class="box box-success">
          <div class="box-header with-border">
          <h3 class="box-title">ADPV</h3>
          </div>
          <div class="box-body">
          <div class="chart">
              <canvas id="barChartRP" style="height:200px"></canvas>
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
                <canvas id="barChart1RP" style="height:230px"></canvas>
            </div>
          </div>

      </div>


    </div>
   
    <div class="col-md-4">  
        
        <!-- DONUT CHART -->
        <div class="box box-danger">
        
            <div class="box-header with-border">
            
            <h3 class="box-title">% Participaci&oacute;n  / Total: <?php echo $totalAnimalesRP;?> Animales</h3>

            </div>
            
            <div class="box-body">

                <canvas id="pieChart1RP" style="height:100px"></canvas>

            </div>
        
        </div>

    </div>  

</div>
<div class="saltopagina"></div>
<div class="row">

      <div class="col-md-4">
        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Kg Ingreso</h3>
          </div>
          <div class="box-body">
            <div class="chart">
              <!-- <canvas id="barChart2RP" style="height:230px"></canvas> -->
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
              <!-- <canvas id="barChart3RP" style="height:230px"></canvas> -->
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
              <canvas id="barChart4RP" style="height:230px"></canvas>
            </div>
          </div>

        </div>
        

      </div>

</div>

<script>

function configuracionPie(data,color,label,label2){
          
  let configuracion = {
    type: 'pie',
    data: {
      datasets: [{
        data: data,
        backgroundColor:

          color
        ,
        label: label2
      }],
      labels: label
    },
    options: {
        responsive: true,
        title: {
          display: false,
        },
        plugins:{
          labels:{
            render: 'value'
          }
        },
        legend: {
          labels: {
              boxWidth: 5
          }
        }
      }
  };
    
  return configuracion;

}
        
        
function configuracionBar(labels,data,labels2){

  let configuracion = {
    labels: labels,
    datasets: [{
      label: labels2,
      backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
      borderColor: window.chartColors.red,
      borderWidth: 1, 

      data: data
    }]

  }

  return configuracion;

}

let data = [<?php $totalMachos.",".$totalHembras[0].",";?>];

let colors = [window.chartColors.red,window.chartColors.orange];

let labels = ['Macho','Hembra'];

let configPSSRP = configuracionPie(data,colors,labels,'Sexo');


data = [<?php echo $totalAnimalesRP.",".$restoAnimales.",";?>];

labels = ['Población RP','Resto Población'];

let configPPRP = configuracionPie(data,colors,labels,'value');

var color = Chart.helpers.color;

data = [<?php echo $promedioAdpvRP;?>];

labels = ['Prom. Adpv'];

let configADPVRP = configuracionBar(labels,data,'Kg. Prom');

data = [<?php echo $promedioDiasRP;?>];

labels = ['Prom. Dias'];

let configDiasRP = configuracionBar(labels,data,'Dias Prom.');

data = [<?php echo $promedioKgProdRP;?>];

labels = ['Kg Produc. Promedio'];

let configKgProdRP = configuracionBar(labels,data,'Kg Produc. Promedio');




</script>
