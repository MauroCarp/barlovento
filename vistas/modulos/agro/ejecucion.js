

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

const generarInputFile = (lotes) => {

  $('#inputCampaniaEjecucion').val(localStorage.getItem('campaniaAgro'))
  
  let pichiGruesa = []
  let pichiFina = []
  let betyGruesa = []
  let betyFina = []

  $('#formEjecucion').append($('<div class="bg-success" style="font-size:1.8em"><b>Pichi</b></div>'))
  
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

        betyGruesa.push(`<div class="form-group">

            <label for="${lotes[key]['lote'].split(' ').join('')}">${lotes[key]['lote']} - ${capitalizarPrimeraLetra(lotes[key]['cultivo'])}</label>

            <div class="input-group">

              <div class="custom-file"><input type="file" class="custom-file-input" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}">

                <input type="hidden" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}campo" value="${lotes[key]['campo']}"/>

              </div>
              
            </div>

          </div>`)

      }

      if(lotes[key]['etapa'] == 'fina'){

        betyFina.push(`<div class="form-group">

            <label for="${lotes[key]['lote'].split(' ').join('')}">${lotes[key]['lote']} - ${capitalizarPrimeraLetra(lotes[key]['cultivo'])}</label>

            <div class="input-group">

              <div class="custom-file"><input type="file" class="custom-file-input" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}">

                <input type="hidden" name="${lotes[key]['lote'].split(' ').join('')}_${lotes[key]['cultivo']}campo" value="${lotes[key]['campo']}"/>

              </div>
              
            </div>

          </div>`)

      }

    }

  }

  if(pichiGruesa != undefined){
    
    $('#formEjecucion').append($('<div id="inputPichiGruesa" style="display:none"></div>'))
    $('#inputPichiGruesa').append($('<div class="bg-info" style="font-size:1.5em"><b>Gruesa</b></div>'))  
    $('#inputPichiGruesa').append($(`${pichiGruesa.join('')}`))

  }

  if(pichiFina != undefined){

    $('#formEjecucion').append($('<div id="inputPichiFina"></div>'))
    $('#inputPichiFina').append($('<div class="bg-info" style="font-size:1.5em"><b>Fina</b></div>'))  
    $('#inputPichiFina').append($(`${pichiFina.join('')}`))

  }

  $('#formEjecucion').append($('<div class="bg-success" style="font-size:1.8em"><b>Bety</b></div>'))

  if(betyGruesa != undefined){

    $('#formEjecucion').append($('<div id="inputBetyGruesa" style="display:none"></div>'))
    $('#inputBetyGruesa').append($('<div class="bg-info" style="font-size:1.5em"><b>Gruesa</b></div>'))  
    $('#inputBetyGruesa').append($(`${betyGruesa.join('')}`))

  }

  if(betyFina != undefined){

    $('#formEjecucion').append($('<div id="inputBetyFina"></div>'))
    $('#inputBetyFina').append($('<div class="bg-info" style="font-size:1.5em"><b>Fina</b></div>'))  
    $('#inputBetyFina').append($(`${betyFina.join('')}`))

  }
/*
  if(lotes.pichi.gruesa != undefined){

    $('#formEjecucion').append($('<div id="inputPichiGruesa" style="display:none"></div>'))
    $('#inputPichiGruesa').append($('<div class="bg-info" style="font-size:1.5em"><b>Gruesa</b></div>'))
    
    lotes.pichi.gruesa.forEach(element => {

      $('#inputPichiGruesa').append($(`
    
      <div class="form-group">
    
        <label for="${element.lote.split(' ').join('')}">${element.lote} - ${element.cultivo}</label>
    
        <div class="input-group">
    
            <div class="custom-file">
    
                <input type="file" class="custom-file-input" name="${element.lote.split(' ').join('')}_${element.cultivo}">
                <input type="hidden" name="${element['lote'].split(' ').join('')}_${element['cultivo']}campo" value="pichi">

    
            </div>
    
        </div>
    
      </div>`))

    });

  } 
    if(lotes.bety.fina != undefined){

    $('#formEjecucion').append($('<div id="inputBetyFina"></div>'))
    $('#inputBetyFina').append($('<div class="bg-info" style="font-size:1.5em"><b>Fina</b></div>'))
    
    for (const key in lotes.bety.fina) {

      $('#inputBetyFina').append($(`
    
      <div class="form-group">
    
        <label for="${lotes.bety.fina[key]['lote'].split(' ').join('')}">${lotes.bety.fina[key]['lote']} - ${lotes.bety.fina[key]['cultivo']}</label>
    
        <div class="input-group">
    
            <div class="custom-file">
    
                <input type="file" class="custom-file-input" name="${lotes.bety.fina[key]['lote'].split(' ').join('')}_${lotes.bety.fina[key]['cultivo']}">
                <input type="hidden" name="${lotes.bety.fina[key]['lote'].split(' ').join('')}_${lotes.bety.fina[key]['cultivo']}campo" value="bety">

            </div>
    
        </div>
    
      </div>`))
    
    }

  }

  if(lotes.bety.gruesa != undefined){

    $('#formEjecucion').append($('<div id="inputBetyGruesa" style="display:none"></div>'))
    $('#inputBetyGruesa').append($('<div class="bg-info" style="font-size:1.5em"><b>Gruesa</b></div>'))
    
    for (const key in lotes.bety.gruesa) {

      $('#inputBetyGruesa').append($(`
    
      <div class="form-group">
    
        <label for="${lotes.bety.gruesa[key]['lote'].split(' ').join('')}">${lotes.bety.gruesa[key]['lote']} - ${lotes.bety.gruesa[key]['cultivo']}</label>
    
        <div class="input-group">
    
            <div class="custom-file">
    
                <input type="file" class="custom-file-input" name="${lotes.bety.gruesa[key]['lote'].split(' ').join('')}_${lotes.bety.gruesa[key]['cultivo']}">
                <input type="hidden" name="${lotes.bety.gruesa[key]['lote'].split(' ').join('')}_${lotes.bety.gruesa[key]['cultivo']}campo" value="bety">

    
            </div>
    
        </div>
    
      </div>`))
    
    }

  } */

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

  data.append('accion','mostrarDataEjecucion')
  data.append('campania',campania)
  data.append('etapa',etapa)

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
  
      document.getElementById(`hasTrigoEjecucionBety`).innerText = '-'
      document.getElementById(`hasTrigoEjecucionPichi`).innerText = '-'
  
      document.getElementById(`hasCoberturaEjecucionBety`).innerText = '-'
      document.getElementById(`hasCoberturaEjecucionPichi`).innerText = '-'
      
      document.getElementById(`hasCarinataEjecucionBety`).innerText = '-'
      document.getElementById(`hasCarinataEjecucionPichi`).innerText = '-'
  
      document.getElementById(`hasRestoEjecucionBety`).innerText = '-'
      document.getElementById(`hasRestoEjecucionPichi`).innerText = '-'

      document.getElementById(`totalCostoTrigoEjecucionBety`).innerText = '-'
      document.getElementById(`totalCostoTrigoEjecucionPichi`).innerText = '-'

      document.getElementById(`totalCostoCoberturaEjecucionBety`).innerText = '-'
      document.getElementById(`totalCostoCoberturaEjecucionPichi`).innerText = '-'
      
      document.getElementById(`totalCostoCarinataEjecucionBety`).innerText = '-'
      document.getElementById(`totalCostoCarinataEjecucionPichi`).innerText = '-'

      document.getElementById(`totalCostoRestoEjecucionBety`).innerText = '-'
      document.getElementById(`totalCostoRestoEjecucionPichi`).innerText = '-'
      
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

    respuesta.forEach(lote => {

      if(data[lote['campo']][lote['lote']] == undefined){

        labores[lote['campo']][lote['lote']] = {}

        labores[lote['campo']][lote['lote']][lote['labor']] = lote  

        data[lote['campo']][lote['lote']] = {}
        
        data[lote['campo']][lote['lote']].cultivo = lote['cultivo'] 

        data[lote['campo']][lote['lote']].costoLabor =  Number(lote['costoLabor'])

        data[lote['campo']][lote['lote']].costoInsumo = (lote['labor'] != 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoFertilizacion = (lote['labor'] == 'Fertilizacion') ? Number(lote['costoInsumo']) : 0
        
        if(lote.etapa == 'gruesa'){

          info[lote.campo].hasGruesa = Number(lote.has)
          info[lote.campo].costoGruesa += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

        } else {

          if(tipoCultivo(lote.cultivo) == 'Cobertura'){

            info[lote.campo].hasCobertura = Number(lote.has)
            info[lote.campo].costoCobertura += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          } else {

            info[lote.campo].hasFina = Number(lote.has)
            info[lote.campo].costoFina += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          }

        }

      } else {

        labores[lote['campo']][lote['lote']][lote['labor']] = lote  

        data[lote['campo']][lote['lote']].costoLabor += Number(lote['costoLabor'])

        data[lote['campo']][lote['lote']].costoInsumo += (lote['labor'] != 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoFertilizacion += (lote['labor'] == 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        if(lote.etapa == 'gruesa'){

          info[lote.campo].costoGruesa += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

        } else {

          if(tipoCultivo(lote.cultivo) == 'Cobertura'){

            info[lote.campo].costoCobertura += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          } else {

            info[lote.campo].costoFina += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          }

        }

      }
    
    });

    ['pichi','bety'].forEach(campo => {

      $(`#tablaEjecucion${capitalizarPrimeraLetra(campo)} tbody`).html('')
      
      for (const key in data[campo]) {
        
        let tooltip = ''
        
        for (const lote in labores[campo][key]) {

          tooltip += 
            `Labor: ${lote} | Costo Labor: $ ${labores[campo][key][lote]['costoLabor'].toLocaleString('de-DE')} | Costo Insumo: $ ${labores[campo][key][lote]['costoInsumo'].toLocaleString('de-DE')}
          `      
        }

        $(`#tablaEjecucion${capitalizarPrimeraLetra(campo)} tbody`).append($(`
  
          <tr>
  
            <td>
              <span data-toggle="tooltip" data-placement="top" 
              title="${tooltip}" 
              style="cursor:pointer">${key}</span>
              
            </td>
  
            <td>
              ${data[campo][key].cultivo}
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
              -
            </td>
  
            <td>
              %
            </td>
  
          <tr>
  
        `))
  
      }

    });


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
    
    document.getElementById(`costoGruesaEjecucionHasPichi`).innerText = (Number(info.pichi.hasGruesa) > 0) ? (Number(info.pichi.costoGruesa) / Number(info.pichi.hasGruesa)).toFixed(2).toLocaleString('de-DE') : 0
    document.getElementById(`costoGruesaEjecucionHasBety`).innerText = (Number(info.bety.hasGruesa) > 0) ? (Number(info.bety.costoGruesa) / Number(info.bety.hasGruesa)).toFixed(2).toLocaleString('de-DE') : 0

    document.getElementById(`totalCostoCoberturaEjecucionPichi`).innerText = info.pichi.costoCobertura.toLocaleString('de-DE')
    document.getElementById(`totalCostoCoberturaEjecucionBety`).innerText = info.bety.costoCobertura.toLocaleString('de-DE')
    
    document.getElementById(`costoCoberturaEjecucionHasPichi`).innerText = (Number(info.pichi.hasCobertura) > 0) ? (Number(info.pichi.costoCobertura) / Number(info.pichi.hasCobertura)).toFixed(2).toLocaleString('de-DE') : 0
    document.getElementById(`costoCoberturaEjecucionHasBety`).innerText = (Number(info.bety.hasCobertura) > 0) ? (Number(info.bety.costoCobertura) / Number(info.bety.hasCobertura)).toFixed(2).toLocaleString('de-DE') : 0

    document.getElementById(`totalCostoFinaEjecucionPichi`).innerText = info.pichi.costoFina.toLocaleString('de-DE')
    document.getElementById(`totalCostoFinaEjecucionBety`).innerText = info.bety.costoFina.toLocaleString('de-DE')
    
    document.getElementById(`costoFinaEjecucionHasPichi`).innerText = (Number(info.pichi.hasFina) > 0) ? (Number(info.pichi.costoFina) / Number(info.pichi.hasFina)).toLocaleString('de-DE') : 0
    document.getElementById(`costoFinaEjecucionHasBety`).innerText = (Number(info.bety.hasFina) > 0) ? (Number(info.bety.costoFina) / Number(info.bety.hasFina)).toLocaleString('de-DE') : 0


    
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

// const generarLoteActividad = (lote,actividades)=>{
//   let divRow = document.createElement('DIV')
//   let divCollapsedBox = divRow.cloneNode(true)
//   let divBoxHeader = divRow.cloneNode(true)
//   let divBoxTitle = document.createElement('H3')
//   let divBoxBody = divRow.cloneNode(true)
//   divRow.setAttribute('class','col-md-4')
//   divCollapsedBox.setAttribute('class','box box-default box-solid')
//   divBoxHeader.setAttribute('class','box-header with-border bg-aqua-active')
//   divBoxTitle.setAttribute('class','box-title')
//   divBoxTitle.innerText = lote
//   divBoxBody.setAttribute('class','box-body')

//   let actividadesHTML = []

//   for (let index = 0; index < actividades.length; index++) {
//     if(actividades[index][0] != '')
//       actividadesHTML.push(`<b>- ${capitalizarPrimeraLetra(actividades[index][0])} | ${actividades[index][1]} u$s/Has</b><br>`)
//   }

//   divBoxBody.innerHTML = actividadesHTML.join('')

//   divBoxHeader.append(divBoxTitle)

//   divCollapsedBox.append(divBoxHeader)
//   divCollapsedBox.append(divBoxBody)

//   divRow.append(divCollapsedBox)
//   return divRow
// }

$('#etapaEjecucion').on('change',()=>{

    $('#actividadLotesBety').html('')
    $('#actividadLotesPichi').html('')

    let campania =  $('#campania').html()

    cargarInfoEjecucion(campania)

})

