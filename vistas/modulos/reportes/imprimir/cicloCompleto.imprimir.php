<?php
 /// OBTENCION DE DATOS


  /*********
            POBLACION SEGUN SEXO
                                  ********/
  // MACHOS
  $item = 'categoria';

  $valor = 'NT';
  
  $totalMachosNT = ControladorDatos::ctrContarAnimales($item,$valor,true);

  $valor = 'TO';
  $totalMachosTO = ControladorDatos::ctrContarAnimales($item,$valor,true);

  $totalMachos = (int)$totalMachosNT[0] + (int)$totalMachosTO[0];

  // HEMBRAS
                                  
  $valor = 'VQ';

  $totalHembras = ControladorDatos::ctrContarAnimales($item,$valor,true);

  $totalAnimalesCC = ControladorDatos::ctrContarAnimales('','',true);


  /*********
                % POBLACION
                                  ********/


                                  
  /*********
                    ADPV
                                  ********/

  $item = NULL;
  $valor = NULL;
  $campo = 'adpvCC';
  $sumaADPV = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

  $totalAnimales = $totalAnimalesCC[0];
  $totalAdpvCC = $sumaADPV[0]; 

$promedioAdpvCC = number_format(($totalAdpvCC[0] / $totalAnimales[0]),2);


                                
  /*********
                    DIAS 
                                  ********/

  $campo = 'diasCC';
  $totalDias = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

  $totalDiasCC = $totalDias[0][0];

  $promedioDiasCC = round(($totalDiasCC / $totalAnimales[0]));
            
  /*********
                  KG INGRESO
                                  ********/

  $campo = 'kgIngresoCC';
  $kilosIng = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

  $kilosIngCC = $kilosIng[0][0];

  $promedioKgIngCC = round(($kilosIngCC / $totalAnimales[0]));

  /*********
                  KG SALIDA
                                  ********/

  $campo = 'kgSalidaCC';
  $kilosEgr = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

  $kilosEgrCC = $kilosEgr[0][0];

  $promedioKgEgrCC = round(($kilosEgrCC / $totalAnimales[0]));

                                  
  /*********
                KG PRODUCCION
                                  ********/


  $campo = 'kgProdCC';
  $kilosProd = ControladorDatos::ctrSumarCampo($item,$valor,$campo,true);

  $kilosProdCC = $kilosProd[0][0];

  $promedioKgProdCC = round(($kilosProdCC / $totalAnimales[0]));

?>

<h3>Ciclo Completo</h3>

<div class="row">

    <div class="col-md-4">
      <!-- BAR CHART -->
      <div class="box box-success">
          <div class="box-header with-border">
          <h3 class="box-title">ADPV</h3>
          </div>
          <div class="box-body">
          <div class="chart">
              <canvas id="barChart" style="height:230px"></canvas>
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
              <canvas id="barChart1" style="height:230px"></canvas>
          </div>
          </div>

      </div>
    
    </div>

    <div class="col-md-4">  
    
      <!-- DONUT CHART -->
      <div class="box box-danger">
      
          <div class="box-header with-border">
          
          <h3 class="box-title">Población según Sexo / Total: <?php echo $totalAnimales[0];?> Animales</h3>


          </div>
          
          <div class="box-body">
            
            <div class="chart">
            
              <canvas id="pieChart" style="height:250px"></canvas>
          
            </div>
     
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
              <canvas id="barChart2" style="height:230px"></canvas>
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
              <canvas id="barChart3" style="height:230px"></canvas>
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
              <canvas id="barChart4" style="height:230px"></canvas>
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

let data = [<?php echo $totalMachos.",".$totalHembras[0];?>];

let colors = [window.chartColors.red,window.chartColors.orange];

let labels = ['Macho','Hembra'];

let configPSS = configuracionPie(data,colors,labels,'Sexo');



var color = Chart.helpers.color;

data = [<?php echo $promedioAdpvCC;?>];

labels = ['Prom. Adpv'];

let configADPV = configuracionBar(labels,data,'Kg. Prom');

data = [<?php echo $promedioDiasCC;?>];

labels = ['Prom. Dias'];

let configDias = configuracionBar(labels,data,'Dias Prom.');

data = [<?php echo $promedioKgIngCC;?>];

labels = ['Kg Ing. Promedio'];

let configKgIng = configuracionBar(labels,data,'Kg Ing. Promedio');

data = [<?php echo $promedioKgEgrCC;?>];

labels = ['Kg Egr. Promedio'];

let configKgEgr = configuracionBar(labels,data,'Kg Egr. Promedio');

data = [<?php echo $promedioKgProdCC;?>];

labels = ['Kg Produc. Promedio'];

let configKgProd = configuracionBar(labels,data,'Kg Produc. Promedio');
    
</script>
