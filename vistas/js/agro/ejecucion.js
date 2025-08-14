
$('#ejecucionTab').on('click',function(){
  
  let url = 'ajax/agro.ajax.php'

  let campania =  $('#campania').html()

  if(campania != ''){

    $.ajax({
      method:'POST',
      url,
      data:{
        accion:'ejecucion',
        campania
      },
      success:function(resp){

        if(resp == 0){
  
          $('#modalCargarEjecucion').modal('show')
  
        }else{
          
          cargarInfoEjecucion(campania)
  
        }
  
      }
  
    }) 

  }
  
})

const nombreCultivos = {
  'soja1': 'Soja 1°',
  'soja2': 'Soja 2°',
  'maiz1': 'Maíz 1°',
  'maiz2': 'Maíz 2°',
  'trigo': 'Trigo',
  'camelina': 'Camelina',
  'carinata': 'Carinata',
  'vicia': 'Vicia',
  'triticale': 'Triticale',
  'vicia-triticale': 'Vicia-Triticale',
  'triticale-vicia': 'Triticale-Vicia',
  'avena': 'Avena',
  'avena cobertura': 'Avena Cobertura',
  'cebada': 'Cebada',
  'cebadilla': 'Cebadilla',
  'triticale espinillo': 'Triticale Espinillo',
  'carinata': 'Carinata',
}
const generarInputFile = (lotes) => {

  $('#inputCampaniaEjecucion').val(localStorage.getItem('campaniaAgro'))
  
  let pichiGruesa = []
  let pichiFina = []
  let betyGruesa = []
  let betyFina = []

  $('#formEjecucion').append($(`
                              <div class="box box-success">
      
                                  <div class="box-header with-border">
                              
                                  <h3 class="box-title">Pichi</h3>
                              
                                  </div>
                            
                                  <div class="box-body" id="inputPichi">
                            
                                  </div>

                              </div>
                              <div class="box box-success">
      
                                  <div class="box-header with-border">
                              
                                  <h3 class="box-title">Bety</h3>
                              
                                  </div>
                            
                                  <div class="box-body" id="inputBety">
                            
                                  </div>

                              </div>
  `))
  
  for (const key in lotes) {

    if(lotes[key]['campo'] == 'pichi'){

      if(lotes[key]['etapa'] == 'gruesa'){

        pichiGruesa.push(`<div class="form-group">

            <label for="${lotes[key]['lote'].split(' ').join('')}">${lotes[key]['lote']} - ${capitalizarPrimeraLetra(lotes[key]['cultivo'])}</label>

            <div class="input-group">

              <div class="custom-file"><input type="file" class="custom-file-input" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}">

                <input type="hidden" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}campo" value="${lotes[key]['campo']}"/>

              </div>
              
            </div>

          </div>`)

      }

      if(lotes[key]['etapa'] == 'fina'){

        pichiFina.push(`<div class="form-group">

            <label for="${lotes[key]['lote'].split(' ').join('')}">${lotes[key]['lote']} - ${capitalizarPrimeraLetra(lotes[key]['cultivo'])}</label>

            <div class="input-group">

              <div class="custom-file"><input type="file" class="custom-file-input" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}">

                <input type="hidden" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}campo" value="${lotes[key]['campo']}"/>

              </div>
              
            </div>

          </div>`)

      }

    }
   
    if(lotes[key]['campo'] == 'bety'){

      if(lotes[key]['etapa'] == 'gruesa'){
        
        let campo = lotes[key]['campo']

        betyGruesa.push(`<div class="form-group">

            <label for="${lotes[key]['lote'].split(' ').join('')}">${lotes[key]['lote']} - ${capitalizarPrimeraLetra(lotes[key]['cultivo'])}</label>

            <div class="input-group">

              <div class="custom-file"><input type="file" class="custom-file-input" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}">

                <input type="hidden" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}campo" value="${campo}"/>

              </div>
              
            </div>

          </div>`)

      }

      if(lotes[key]['etapa'] == 'fina'){

        let campo = lotes[key]['campo']

        betyFina.push(`<div class="form-group">

            <label for="${lotes[key]['lote'].split(' ').join('')}">${lotes[key]['lote']} - ${capitalizarPrimeraLetra(lotes[key]['cultivo'])}</label>

            <div class="input-group">

              <div class="custom-file"><input type="file" class="custom-file-input" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}">

                <input type="hidden" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}campo" value="${campo}"/>

              </div>
              
            </div>

          </div>`)

      }

    }

  }

  if(pichiGruesa != undefined){
    
    $('#inputPichi').append($('<div id="inputPichiGruesa" style="display:none"></div>'))
    $('#inputPichiGruesa').append($('<div class="bg-info" style="font-size:1.5em"><b>Gruesa</b></div>'))  
    $('#inputPichiGruesa').append($(`${pichiGruesa.join('')}`))

  }

  if(pichiFina != undefined){

    $('#inputPichi').append($('<div id="inputPichiFina"></div>'))
    $('#inputPichiFina').append($('<div class="bg-info" style="font-size:1.5em"><b>Fina</b></div>'))  
    $('#inputPichiFina').append($(`${pichiFina.join('')}`))

  }

  if(betyGruesa != undefined){

    $('#inputBety').append($('<div id="inputBetyGruesa" style="display:none"></div>'))
    $('#inputBetyGruesa').append($('<div class="bg-info" style="font-size:1.5em"><b>Gruesa</b></div>'))  
    $('#inputBetyGruesa').append($(`${betyGruesa.join('')}`))

  }

  if(betyFina != undefined){

    $('#inputBety').append($('<div id="inputBetyFina"></div>'))
    $('#inputBetyFina').append($('<div class="bg-info" style="font-size:1.5em"><b>Fina</b></div>'))  
    $('#inputBetyFina').append($(`${betyFina.join('')}`))

  }

}


$('#selectEtapa').on('change',function(){
  
  let value = $(this).val()

  if(value == 'gruesa'){
    $('#inputPichiGruesa').show(250)
    $('#inputBetyGruesa').show(250)
    $('#inputPichiFina').hide(250)
    $('#inputBetyFina').hide(250)
  } else {
    $('#inputPichiGruesa').hide(250)
    $('#inputBetyGruesa').hide(250)
    $('#inputPichiFina').show(250)
    $('#inputBetyFina').show(250)

  }

})


const tipoCultivo = (cultivo)=>{

  switch (cultivo) {
      case 'carinata':
      case 'vicia':
      case 'triticale':
      case 'vicia-triticale':
      case 'triticale-vicia':
      case 'avena':
      case 'trigo':
          $tipo = 'Invernal';
          break;
      case 'carinata':
      case 'vicia':
      case 'triticale':
      case 'vicia-triticale':
      case 'triticale-vicia':
      case 'avena':
      case 'avena cobertura':
      case 'cebada':
      case 'cebadilla':
      case 'triticale espinillo':
      case 'camelina':
          $tipo = 'Cobertura';
          break;

      case 'maiz':
      case 'soja':
      case 'soja1ra':
      case 'soja1era':
      case 'soja1':
      case 'soja2da':
      case 'soja2':
      case 'maiz1ra':
      case 'maiz1':
      case 'maiz1era':
      case 'maiz2da':
          $tipo = 'Estival';
          break;
  }

  return $tipo;

}

const cargarInfoEjecucion = (campania)=>{
  // Obtener DATA
  let url = 'ajax/agro.ajax.php'

  let etapa = $('#etapaEjecucion').val()

  let data = new FormData()

  let idPlanificacion = $('#idPlanificacion').val()

  data.append('accion','mostrarDataEjecucion')
  data.append('campania',campania)
  data.append('etapa',etapa)
  data.append('idPlanificacion',Number(idPlanificacion))


  fetch(url,{
      method:'post',
      body:data
  }).then(resp=>resp.json())
  .then(respuesta=>{

    if(respuesta.length == 0){
      document.getElementById(`hasInvEjecucionBety`).innerText = '-'
      document.getElementById(`hasInvEjecucionPichi`).innerText = '-'
      
      document.getElementById(`hasCobEjecucionBety`).innerText = '-'
      document.getElementById(`hasCobEjecucionPichi`).innerText = '-'
      
      document.getElementById(`hasEstEjecucionBety`).innerText = '-'
      document.getElementById(`hasEstEjecucionPichi`).innerText = '-'
  
      // document.getElementById(`hasTrigoEjecucionBety`).innerText = '-'
      // document.getElementById(`hasTrigoEjecucionPichi`).innerText = '-'
  
      document.getElementById(`hasCoberturaEjecucionBety`).innerText = '-'
      document.getElementById(`hasCoberturaEjecucionPichi`).innerText = '-'
      
      // document.getElementById(`hasCarinataEjecucionBety`).innerText = '-'
      // document.getElementById(`hasCarinataEjecucionPichi`).innerText = '-'
  
      // document.getElementById(`hasRestoEjecucionBety`).innerText = '-'
      // document.getElementById(`hasRestoEjecucionPichi`).innerText = '-'

      // document.getElementById(`totalCostoTrigoEjecucionBety`).innerText = '-'
      // document.getElementById(`totalCostoTrigoEjecucionPichi`).innerText = '-'

      document.getElementById(`totalCostoCoberturaEjecucionBety`).innerText = '-'
      document.getElementById(`totalCostoCoberturaEjecucionPichi`).innerText = '-'
      
      // document.getElementById(`totalCostoCarinataEjecucionBety`).innerText = '-'
      // document.getElementById(`totalCostoCarinataEjecucionPichi`).innerText = '-'

      // document.getElementById(`totalCostoRestoEjecucionBety`).innerText = '-'
      // document.getElementById(`totalCostoRestoEjecucionPichi`).innerText = '-'
      
      document.getElementById(`totalHasEjecucionBety`).innerText = '-'
      document.getElementById(`totalHasEjecucionPichi`).innerText = '-'

      document.getElementById(`totalInversionEjecucionBety`).innerText = '-'
      document.getElementById(`totalInversionEjecucionPichi`).innerText = '-'

      document.getElementById(`ratioEjecucionBety`).innerText = '-'
      document.getElementById(`ratioEjecucionPichi`).innerText = '-'

      return
    }
    
    let data = {'pichi':{},'bety':{}}
    let labores = {'pichi':{},'bety':{}}
    let info = {
      'bety':{
        'hasFina':0,
        'hasCobertura':0,
        'hasGruesa':0,
        'costoFina':0,
        'costoGruesa':0,
        'costoCobertura':0
      },
      'pichi':{
        'hasFina':0,
        'hasCobertura':0,
        'hasGruesa':0,
        'costoFina':0,
        'costoGruesa':0,
        'costoCobertura':0
      }
    }
    
    // console.log(respuesta)

    respuesta.forEach(lote => {

      if(data[lote['campo']][lote['lote']] == undefined){

        labores[lote['campo']][lote['lote']] = {}

        labores[lote['campo']][lote['lote']][lote['labor']] = lote  

        data[lote['campo']][lote['lote']] = {}
        
        data[lote['campo']][lote['lote']].cultivo = lote['cultivo'] 

        data[lote['campo']][lote['lote']].costoLabor =  Number(lote['costoLabor'])

        data[lote['campo']][lote['lote']].costoInsumo = (lote['labor'] != 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoFertilizacion = (lote['labor'] == 'Fertilizacion') ? Number(lote['costoInsumo']) : 0
        
        data[lote['campo']][lote['lote']].costoPlanificacion = lote['costoPlanificacion']
        
        console.log(lote.cultivo)
        console.log(tipoCultivo(lote.cultivo))
        if(lote.etapa == 'gruesa'){

          info[lote['campo']]['hasGruesa'] += Number(lote.has)
          info[lote['campo']]['costoGruesa'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

        } else {

          if(tipoCultivo(lote.cultivo) == 'Cobertura'){
            info[lote['campo']]['hasCobertura'] += Number(lote.has)
            info[lote['campo']]['costoCobertura'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          } else {

            info[lote['campo']]['hasFina'] += Number(lote.has)
            info[lote['campo']]['costoFina'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          }

        }

      } else {

        labores[lote['campo']][lote['lote']][lote['labor']] = lote  

        data[lote['campo']][lote['lote']].costoLabor += Number(lote['costoLabor'])

        data[lote['campo']][lote['lote']].costoInsumo += (lote['labor'] != 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoFertilizacion += (lote['labor'] == 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        if(lote.etapa == 'gruesa'){

          info[lote['campo']]['costoGruesa'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

        } else {

          if(tipoCultivo(lote.cultivo) == 'Cobertura'){

            info[lote['campo']]['costoCobertura'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          } else {

            info[lote['campo']]['costoFina'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          }

        }

      }
      // console.log(info[lote['campo']]['hasFina'])
    });


    ['pichi','bety'].forEach(campo => {

      $(`#tablaEjecucion${capitalizarPrimeraLetra(campo)} tbody`).html('')

      for (const key in data[campo]) {
        
        let tooltip = ''
        
        for (const lote in labores[campo][key]) {

          if(tooltip.length > 0 )
            tooltip += '\n';

          tooltip += 
            `Labor: ${lote} \n Costo Labor: $ ${labores[campo][key][lote]['costoLabor'].toLocaleString('de-DE')} \n Costo Insumo: $ ${labores[campo][key][lote]['costoInsumo'].toLocaleString('de-DE')} \n -------------------
          `;
        }

        let totalEjecucion = (Number(data[campo][key].costoInsumo) + Number(data[campo][key].costoLabor) + Number(data[campo][key].costoFertilizacion))

        let diferencia = ((totalEjecucion - data[campo][key].costoPlanificacion) * 100) / data[campo][key].costoPlanificacion

        $(`#tablaEjecucion${capitalizarPrimeraLetra(campo)} tbody`).append($(`
  
          <tr>
  
            <td>
              <span data-toggle="tooltip" data-placement="top" 
              title="${tooltip}" 
              style="cursor:pointer">${key}</span>
              
            </td>
  
            <td>
              ${nombreCultivos[data[campo][key].cultivo]}
            </td>
  
            <td>
              ${data[campo][key].costoInsumo.toLocaleString('de-DE')}
            </td>
  
            <td>
              ${data[campo][key].costoLabor.toLocaleString('de-DE')}
            </td>
  
            <td>
              ${data[campo][key].costoFertilizacion.toLocaleString('de-DE')}
            </td>
  
            <td>
              ${totalEjecucion.toLocaleString('de-DE')}
            </td>
            
            <td>
              ${data[campo][key].costoPlanificacion.toLocaleString('de-DE')}
            </td>

            <td>
              ${diferencia.toFixed(2)} %
            </td>
  
          <tr>
  
        `))
  
      }

    });

    console.log(info)
    // HAS INFO
    document.getElementById(`totalHasEjecutadas`).innerText = Number(info.bety.hasFina) + Number(info.bety.hasGruesa) + Number(info.bety.hasCobertura) + Number(info.pichi.hasFina) + Number(info.pichi.hasGruesa) + Number(info.pichi.hasCobertura) 
    
    let totalInversion = Number(info.bety.costoFina) + Number(info.bety.costoGruesa) + Number(info.bety.costoCobertura) + Number(info.pichi.costoFina) + Number(info.pichi.costoGruesa) + Number(info.pichi.costoCobertura)

    document.getElementById(`totalInversionEjecutada`).innerText = totalInversion.toLocaleString('de-DE')

    document.getElementById(`hasInvEjecucionBety`).innerText = info.bety.hasFina
    document.getElementById(`hasInvEjecucionPichi`).innerText = info.pichi.hasFina
    
    document.getElementById(`hasCobEjecucionBety`).innerText = info.bety.hasCobertura
    document.getElementById(`hasCobEjecucionPichi`).innerText = info.pichi.hasCobertura
    
    document.getElementById(`hasEstEjecucionBety`).innerText = info.bety.hasGruesa
    document.getElementById(`hasEstEjecucionPichi`).innerText = info.pichi.hasGruesa


    document.getElementById(`totalCostoGruesaEjecucionPichi`).innerText = info.pichi.costoGruesa.toLocaleString('de-DE')
    document.getElementById(`totalCostoGruesaEjecucionBety`).innerText = info.bety.costoGruesa.toLocaleString('de-DE')
    
    document.getElementById(`costoGruesaEjecucionHasPichi`).innerText = (Number(info.pichi.hasGruesa) > 0) ? (Number(info.pichi.costoGruesa) / Number(info.pichi.hasGruesa)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0
    document.getElementById(`costoGruesaEjecucionHasBety`).innerText = (Number(info.bety.hasGruesa) > 0) ? (Number(info.bety.costoGruesa) / Number(info.bety.hasGruesa)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0

    document.getElementById(`totalCostoCoberturaEjecucionPichi`).innerText = info.pichi.costoCobertura.toLocaleString('de-DE')
    document.getElementById(`totalCostoCoberturaEjecucionBety`).innerText = info.bety.costoCobertura.toLocaleString('de-DE')
    
    document.getElementById(`costoCoberturaEjecucionHasPichi`).innerText = (Number(info.pichi.hasCobertura) > 0) ? (Number(info.pichi.costoCobertura) / Number(info.pichi.hasCobertura)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0
    document.getElementById(`costoCoberturaEjecucionHasBety`).innerText = (Number(info.bety.hasCobertura) > 0) ? (Number(info.bety.costoCobertura) / Number(info.bety.hasCobertura)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0

    document.getElementById(`totalCostoFinaEjecucionPichi`).innerText = info.pichi.costoFina.toLocaleString('de-DE')
    document.getElementById(`totalCostoFinaEjecucionBety`).innerText = info.bety.costoFina.toLocaleString('de-DE')
    
    console.log((Number(info.bety.costoFina) / Number(info.bety.hasFina)));
    console.log((Number(info.bety.costoFina) / Number(info.bety.hasFina)).toLocaleString('de-DE'))
    
    document.getElementById(`costoFinaEjecucionHasPichi`).innerText = (Number(info.pichi.hasFina) > 0) ? (Number(info.pichi.costoFina) / Number(info.pichi.hasFina)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0
    document.getElementById(`costoFinaEjecucionHasBety`).innerText = (Number(info.bety.hasFina) > 0) ? (Number(info.bety.costoFina) / Number(info.bety.hasFina)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0


    
    // CAJAS HAS

    document.getElementById(`hasCoberturaEjecucionBety`).innerText = info.bety.hasCobertura
    document.getElementById(`hasCoberturaEjecucionPichi`).innerText = info.pichi.hasCobertura

    document.getElementById(`hasFinaEjecucionBety`).innerText = info.bety.hasFina
    document.getElementById(`hasFinaEjecucionPichi`).innerText = info.pichi.hasFina

    document.getElementById(`hasGruesaEjecucionBety`).innerText = info.bety.hasGruesa
    document.getElementById(`hasGruesaEjecucionPichi`).innerText = info.pichi.hasGruesa



    // TOTALES

    document.getElementById(`totalHasEjecucionBety`).innerText = (Number(info.bety.hasFina) + Number(info.bety.hasCobertura) + Number(info.bety.hasGruesa))
    document.getElementById(`totalHasEjecucionPichi`).innerText = (Number(info.pichi.hasFina) + Number(info.pichi.hasCobertura) + Number(info.pichi.hasGruesa))
    
    document.getElementById(`totalInversionEjecucionBety`).innerText = (info.bety.costoCobertura + info.bety.costoFina + info.bety.costoGruesa).toLocaleString('de-DE') 
    document.getElementById(`totalInversionEjecucionPichi`).innerText = (info.pichi.costoCobertura + info.pichi.costoFina + info.pichi.costoGruesa).toLocaleString('de-DE') 

    let ratioBety = (info.bety.hasGruesa > 0) ? ((Number(info.bety.hasFina) + Number(info.bety.hasCobertura)) / Number(info.bety.hasGruesa)).toFixed(2) : ''
    let ratioPichi = (info.pichi.hasGruesa > 0) ? ((Number(info.bety.hasFina) + Number(info.bety.hasCobertura)) / Number(info.bety.hasGruesa)).toFixed(2) : ''

    document.getElementById(`ratioEjecucionBety`).innerText = ratioBety
    document.getElementById(`ratioEjecucionPichi`).innerText = ratioPichi
    
 
    // LOTES ACTIVIDAD
    // for (const key in dataCampos['LA BETY'].actividad) {
    //   $('#actividadLotesBety').append(generarLoteActividad(key,dataCampos['LA BETY'].actividad[key]))
    // }
    
    // for (const key in dataCampos['EL PICHI'].actividad) {
    //   $('#actividadLotesPichi').append(generarLoteActividad(key,dataCampos['EL PICHI'].actividad[key]))
    // }
      
  })

}

$('#etapaEjecucion').on('change',()=>{

    $('#actividadLotesBety').html('')
    $('#actividadLotesPichi').html('')

    let etapa = $('#etapaEjecucion').val()
    if(etapa == 'gruesa'){  
      $('.info-gruesa').show(250)
      $('.info-fina').hide(250)
      $('.info-cobertura').hide(250)
    } else {

      $('.info-fina').removeClass('hide')
      $('.info-cobertura').removeClass('hide')

      $('.info-gruesa').hide(250)
      $('.info-fina').show(250)
      $('.info-cobertura').show(250)
    }

    let campania =  $('#campania').html()

    cargarInfoEjecucion(campania)

})

$('#btnCargaLotes').on('click',function(){

  let etapa = $('#etapaEjecucion').val()

  $('#selectEtapa').val(etapa)

  if(etapa == 'gruesa'){
    $('#inputPichiGruesa').show(250)
    $('#inputBetyGruesa').show(250)
    $('#inputPichiFina').hide(250)
    $('#inputBetyFina').hide(250)
  } else {
    $('#inputPichiGruesa').hide(250)
    $('#inputBetyGruesa').hide(250)
    $('#inputPichiFina').show(250)
    $('#inputBetyFina').show(250)

  }

})