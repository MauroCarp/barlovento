

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
  'soja': 'Soja',
  'soja1': 'Soja 1°',
  'soja2': 'Soja 2°',
  'maiz': 'Maíz 1°',
  'maiz1': 'Maíz 1°',
  'maiz2': 'Maíz 2°',
  'trigo': 'Trigo',
  'girasol': 'Girasol',
  'camelina': 'Camelina',
  'carinata': 'Carinata',
  'vicia': 'Vicia',
  'triticale': 'Triticale',
  'vicia-triticale': 'Vicia-Triticale',
  'vicia+triticale': 'Vicia-Triticale',
  'triticale-vicia': 'Triticale-Vicia',
  'pasturaconsociada': 'Pastura Consociada',
  'avena': 'Avena',
  'avena cobertura': 'Avena Cobertura',
  'cebada': 'Cebada',
  'cebadilla': 'Cebadilla',
  'triticale espinillo': 'Triticale Espinillo',
  'carinata': 'Carinata',
}

const esMaizTardio = (cultivo) => {
  let c = (cultivo || '').toLowerCase().trim()
  return c === 'maiz2' || c === 'maiz2da'
}

const htmlInputLote = (lote) => {
  let loteId = lote['lote'].split(' ').join('')
  return `<div class="form-group">
            <label for="${loteId}">${lote['lote']} - ${capitalizarPrimeraLetra(lote['cultivo'])}</label>
            <div class="input-group">
              <div class="custom-file"><input type="file" class="custom-file-input" name="${loteId}_${lote['cultivo']}">
                <input type="hidden" name="${loteId}_${lote['cultivo']}campo" value="${lote['campo']}"/>
              </div>
            </div>
          </div>`
}

const setText = (id, value) => {
  const el = document.getElementById(id)
  if (el) el.innerText = value
}

const mostrarGruposCargaEtapa = (etapa) => {
  $('#inputPichiGruesa, #inputBetyGruesa, #inputAntonyGruesa').hide(250)
  $('#inputPichiFina, #inputBetyFina, #inputAntonyFina').hide(250)
  $('#inputPichiTardio, #inputBetyTardio, #inputAntonyTardio').hide(250)

  if (etapa == 'gruesa') {
    $('#inputPichiGruesa, #inputBetyGruesa, #inputAntonyGruesa').show(250)
  } else if (etapa == 'tardio') {
    $('#inputPichiTardio, #inputBetyTardio, #inputAntonyTardio').show(250)
  } else {
    $('#inputPichiFina, #inputBetyFina, #inputAntonyFina').show(250)
  }
}

const generarInputFile = (lotes) => {

  $('#inputCampaniaEjecucion').val(localStorage.getItem('campaniaAgro'))
  
  let grupos = {
    pichi: { gruesa: [], fina: [], tardio: [] },
    bety: { gruesa: [], fina: [], tardio: [] },
    antony: { gruesa: [], fina: [], tardio: [] }
  }

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

                              <div class="box box-success">
      
                                  <div class="box-header with-border">
                              
                                  <h3 class="box-title">Antony</h3>
                              
                                  </div>
                            
                                  <div class="box-body" id="inputAntony">
                            
                                  </div>

                              </div>
  `))
  for (const key in lotes) {

    let campo = lotes[key]['campo']
    if (!grupos[campo]) continue

    if (esMaizTardio(lotes[key]['cultivo'])) {
      grupos[campo].tardio.push(htmlInputLote(lotes[key]))
    } else if (lotes[key]['etapa'] == 'gruesa') {
      grupos[campo].gruesa.push(htmlInputLote(lotes[key]))
    } else if (lotes[key]['etapa'] == 'fina') {
      grupos[campo].fina.push(htmlInputLote(lotes[key]))
    }

  }

  const titulos = { gruesa: 'Gruesa', fina: 'Fina', tardio: 'Maíz Tardío' }
  const displayInicial = { gruesa: 'none', fina: '', tardio: 'none' }

  ;['pichi','bety','antony'].forEach(campo => {
    ;['gruesa','fina','tardio'].forEach(tipo => {
      let id = `input${capitalizarPrimeraLetra(campo)}${capitalizarPrimeraLetra(tipo)}`
      $(`#input${capitalizarPrimeraLetra(campo)}`).append($(`<div id="${id}" style="display:${displayInicial[tipo]}"></div>`))
      $(`#${id}`).append($(`<div class="bg-info" style="font-size:1.5em"><b>${titulos[tipo]}</b></div>`))
      $(`#${id}`).append($(`${grupos[campo][tipo].join('')}`))
    })
  })

}

$('#selectEtapa').on('change',function(){
  mostrarGruposCargaEtapa($(this).val())
})


const tipoCultivo = (cultivo)=>{

  switch (cultivo) {
      // case 'carinata':
      // case 'vicia':
      // case 'triticale':
      // case 'vicia+triticale':
      // case 'vicia-triticale':
      // case 'triticale-vicia':
      // case 'avena':
      case 'vicia-triticale':
      case 'vicia+triticale':
      case 'triticale-vicia':
      case 'Vicia-Triticale':
      case 'trigo':
          tipo = 'Invernal';
          break;
      case 'carinata':
      case 'vicia':
      case 'triticale':
      // // case 'vicia-triticale':
      // // case 'vicia+triticale':
      // // case 'triticale-vicia':
      // case 'Vicia-Triticale':
      case 'avena':
      case 'avena cobertura':
      case 'cebada':
      case 'cebadilla':
      case 'triticale espinillo':
      case 'camelina':
          tipo = 'Cobertura';
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
          tipo = 'Estival';
          break;
  }

  return tipo;

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
    console.log(respuesta)
    // setTimeout(() => {
    //   $('#idEjecucionRindes').val(respuesta['data'][0].idEjecucion);
    // }, 600);

    $('#hasTotalEjecutado').text(respuesta['totales'][0]['totalHas'])
    $('#costoTotalEjecutado').text(Number(respuesta['totales'][0]['totalCosto']).toLocaleString('de-DE'))

    if(respuesta['data'].length == 0){

      setText('totalHasEjecutadas', 0)
      setText('totalInversionEjecutada', 0)
      setText('hasInvEjecucionBety', '-')
      setText('hasInvEjecucionPichi', '-')
      setText('hasInvEjecucionAntony', '-')
      setText('hasCobEjecucionBety', '-')
      setText('hasCobEjecucionPichi', '-')
      setText('hasCobEjecucionAntony', '-')
      setText('hasEstEjecucionBety', '-')
      setText('hasEstEjecucionPichi', '-')
      setText('hasEstEjecucionAntony', '-')
      setText('hasCoberturaEjecucionBety', '-')
      setText('hasCoberturaEjecucionPichi', '-')
      setText('hasCoberturaEjecucionAntony', '-')
      setText('totalCostoCoberturaEjecucionBety', '-')
      setText('totalCostoCoberturaEjecucionPichi', '-')
      setText('totalCostoCoberturaEjecucionAntony', '-')
      setText('totalHasEjecucionBety', '-')
      setText('totalHasEjecucionPichi', '-')
      setText('totalHasEjecucionAntony', '-')
      setText('totalInversionEjecucionBety', '-')
      setText('totalInversionEjecucionPichi', '-')
      setText('totalInversionEjecucionAntony', '-')
      setText('ratioEjecucionBety', '-')
      setText('ratioEjecucionPichi', '-')
      setText('ratioEjecucionAntony', '-')
      setText('hasTardioEjecucionBety', '-')
      setText('hasTardioEjecucionPichi', '-')
      setText('hasTardioEjecucionAntony', '-')
      setText('totalCostoTardioEjecucionBety', '-')
      setText('totalCostoTardioEjecucionPichi', '-')
      setText('totalCostoTardioEjecucionAntony', '-')

      return
    }
    
    let data = {'pichi':{},'bety':{},'antony':{}}
    let labores = {'pichi':{},'bety':{},'antony':{}}
    let info = {
      'bety':{
        'hasFina':0,
        'hasCobertura':0,
        'hasGruesa':0,
        'hasTardio':0,
        'costoFina':0,
        'costoGruesa':0,
        'costoCobertura':0,
        'costoTardio':0
      },
      'pichi':{
        'hasFina':0,
        'hasCobertura':0,
        'hasGruesa':0,
        'hasTardio':0,
        'costoFina':0,
        'costoGruesa':0,
        'costoCobertura':0,
        'costoTardio':0
      },
      'antony':{
        'hasFina':0,
        'hasCobertura':0,
        'hasGruesa':0,
        'hasTardio':0,
        'costoFina':0,
        'costoGruesa':0,
        'costoCobertura':0,
        'costoTardio':0
      }
    }
   
    respuesta['data'].forEach(lote => {

      if(!data[lote['campo']] || !info[lote['campo']]) return;

      if(data[lote['campo']][lote['lote']] == undefined){

        labores[lote['campo']][lote['lote']] = {}

        labores[lote['campo']][lote['lote']][lote['labor']] = lote  

        data[lote['campo']][lote['lote']] = {}
        
        data[lote['campo']][lote['lote']].cultivo = lote['cultivo'] 

        data[lote['campo']][lote['lote']].costoLabor =  (lote['labor'] != 'Cosecha') ? Number(lote['costoLabor']) : 0

        data[lote['campo']][lote['lote']].costoInsumo = (lote['labor'] != 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoFertilizacion = (lote['labor'] == 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoCosecha = (lote['labor'] == 'Cosecha') ? Number(lote['costoLabor']) : 0
        
        data[lote['campo']][lote['lote']].costoPlanificacion = lote['costoPlanificacion']

        data[lote['campo']][lote['lote']].has = lote['has']

        data[lote['campo']][lote['lote']].idEjecucion = lote['idEjecucion']

        data[lote['campo']][lote['lote']].etapa = lote['etapa']
        
        if(esMaizTardio(lote.cultivo) || lote.etapa == 'tardio'){

          info[lote['campo']]['hasTardio'] += Number(lote.has)
          info[lote['campo']]['costoTardio'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

        } else if(lote.etapa == 'gruesa'){

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

        data[lote['campo']][lote['lote']].costoLabor += (lote['labor'] != 'Cosecha') ? Number(lote['costoLabor']) : 0

        data[lote['campo']][lote['lote']].costoInsumo += (lote['labor'] != 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoFertilizacion += (lote['labor'] == 'Fertilizacion') ? Number(lote['costoInsumo']) : 0

        data[lote['campo']][lote['lote']].costoCosecha += (lote['labor'] == 'Cosecha') ? Number(lote['costoLabor']) : 0

        if(esMaizTardio(lote.cultivo) || lote.etapa == 'tardio'){

          info[lote['campo']]['costoTardio'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

        } else if(lote.etapa == 'gruesa'){

          info[lote['campo']]['costoGruesa'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

        } else {

          if(tipoCultivo(lote.cultivo) == 'Cobertura'){

            info[lote['campo']]['costoCobertura'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          } else {

            info[lote['campo']]['costoFina'] += (Number(lote['costoLabor']) + Number(lote['costoInsumo']))

          }

        }

      }
    
    });

    ['pichi','bety','antony'].forEach(campo => {

      if (!document.getElementById(`tablaEjecucion${capitalizarPrimeraLetra(campo)}`)) return

      $(`#tablaEjecucion${capitalizarPrimeraLetra(campo)} tbody`).html('')

      for (const key in data[campo]) {
        
        let tooltip = ''
        
        for (const lote in labores[campo][key]) {

          if(tooltip.length > 0 )
            tooltip += '\n';

          if(labores[campo][key][lote]['labor'] != 'Cosecha'){

            tooltip += 
              `Labor: ${lote} \n Costo Labor: $ ${labores[campo][key][lote]['costoLabor'].toLocaleString('de-DE')} \n Costo Insumo: $ ${labores[campo][key][lote]['costoInsumo'].toLocaleString('de-DE')} \n -------------------
            `;

          }

        }

        let totalEjecucion = (Number(data[campo][key].costoInsumo) + Number(data[campo][key].costoLabor) + Number(data[campo][key].costoFertilizacion))
        console.log(totalEjecucion,data[campo][key].has)
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
              ${data[campo][key].has}
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
               ${(totalEjecucion / Number(data[campo][key].has)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
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
            
            <td>
              ${(Number(totalEjecucion) - Number(data[campo][key].costoPlanificacion)).toLocaleString('de-DE')}
            </td>

            <td>
              <button class="btn btn-danger btn-xs btn-eliminar-ejecucion-lote"
                data-lote="${key}"
                data-campo="${campo}"
                data-etapa="${data[campo][key].etapa || etapa}"
                data-idejecucion="${data[campo][key].idEjecucion}">
                <i class="fa fa-trash"></i>
              </button>
            </td>
        `))
  
      }

    });


    // HAS INFO
    //varia segun etapa
    let totalHasEjecutadas
    if (etapa == 'fina') {
      totalHasEjecutadas = Number(info.bety.hasFina) + Number(info.bety.hasCobertura) + Number(info.pichi.hasFina) + Number(info.pichi.hasCobertura) + Number(info.antony.hasFina) + Number(info.antony.hasCobertura)
    } else if (etapa == 'tardio') {
      totalHasEjecutadas = Number(info.bety.hasTardio) + Number(info.pichi.hasTardio) + Number(info.antony.hasTardio)
    } else {
      totalHasEjecutadas = Number(info.bety.hasGruesa) + Number(info.pichi.hasGruesa) + Number(info.antony.hasGruesa)
    }
    
    setText('totalHasEjecutadas', totalHasEjecutadas)
    
    let totalInversion = Number(info.bety.costoFina) + Number(info.bety.costoGruesa) + Number(info.bety.costoCobertura) + Number(info.bety.costoTardio) + Number(info.pichi.costoFina) + Number(info.pichi.costoGruesa) + Number(info.pichi.costoCobertura) + Number(info.pichi.costoTardio) + Number(info.antony.costoFina) + Number(info.antony.costoGruesa) + Number(info.antony.costoCobertura) + Number(info.antony.costoTardio)

    setText('totalInversionEjecutada', totalInversion.toLocaleString('de-DE'))

    setText('hasInvEjecucionBety', info.bety.hasFina)
    setText('hasInvEjecucionPichi', info.pichi.hasFina)
    setText('hasInvEjecucionAntony', info.antony.hasFina)
    setText('hasCobEjecucionBety', info.bety.hasCobertura)
    setText('hasCobEjecucionPichi', info.pichi.hasCobertura)
    setText('hasEstEjecucionBety', info.bety.hasGruesa)
    setText('hasEstEjecucionPichi', info.pichi.hasGruesa)

    setText('totalCostoGruesaEjecucionPichi', info.pichi.costoGruesa.toLocaleString('de-DE'))
    setText('totalCostoGruesaEjecucionBety', info.bety.costoGruesa.toLocaleString('de-DE'))
    setText('totalCostoGruesaEjecucionAntony', info.antony.costoGruesa.toLocaleString('de-DE'))
    setText('costoGruesaEjecucionHasAntony', (Number(info.antony.hasGruesa) > 0) ? (Number(info.antony.costoGruesa) / Number(info.antony.hasGruesa)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)
    setText('costoGruesaEjecucionHasPichi', (Number(info.pichi.hasGruesa) > 0) ? (Number(info.pichi.costoGruesa) / Number(info.pichi.hasGruesa)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)
    setText('costoGruesaEjecucionHasBety', (Number(info.bety.hasGruesa) > 0) ? (Number(info.bety.costoGruesa) / Number(info.bety.hasGruesa)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)

    setText('totalCostoCoberturaEjecucionPichi', info.pichi.costoCobertura.toLocaleString('de-DE'))
    setText('totalCostoCoberturaEjecucionBety', info.bety.costoCobertura.toLocaleString('de-DE'))
    setText('totalCostoCoberturaEjecucionAntony', info.antony.costoCobertura.toLocaleString('de-DE'))
    setText('costoCoberturaEjecucionHasAntony', (Number(info.antony.hasCobertura) > 0) ? (Number(info.antony.costoCobertura) / Number(info.antony.hasCobertura)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)
    setText('costoCoberturaEjecucionHasPichi', (Number(info.pichi.hasCobertura) > 0) ? (Number(info.pichi.costoCobertura) / Number(info.pichi.hasCobertura)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)
    setText('costoCoberturaEjecucionHasBety', (Number(info.bety.hasCobertura) > 0) ? (Number(info.bety.costoCobertura) / Number(info.bety.hasCobertura)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)

    setText('totalCostoFinaEjecucionPichi', info.pichi.costoFina.toLocaleString('de-DE'))
    setText('totalCostoFinaEjecucionBety', info.bety.costoFina.toLocaleString('de-DE'))
    setText('totalCostoFinaEjecucionAntony', info.antony.costoFina.toLocaleString('de-DE'))
    setText('costoFinaEjecucionHasAntony', (Number(info.antony.hasFina) > 0) ? (Number(info.antony.costoFina) / Number(info.antony.hasFina)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)
    setText('costoFinaEjecucionHasPichi', (Number(info.pichi.hasFina) > 0) ? (Number(info.pichi.costoFina) / Number(info.pichi.hasFina)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)
    setText('costoFinaEjecucionHasBety', (Number(info.bety.hasFina) > 0) ? (Number(info.bety.costoFina) / Number(info.bety.hasFina)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 0)

    // CAJAS HAS
    setText('hasCoberturaEjecucionBety', info.bety.hasCobertura)
    setText('hasCoberturaEjecucionPichi', info.pichi.hasCobertura)
    setText('hasCoberturaEjecucionAntony', info.antony.hasCobertura)
    setText('hasFinaEjecucionBety', info.bety.hasFina)
    setText('hasFinaEjecucionPichi', info.pichi.hasFina)
    setText('hasFinaEjecucionAntony', info.antony.hasFina)
    setText('hasGruesaEjecucionBety', info.bety.hasGruesa)
    setText('hasGruesaEjecucionPichi', info.pichi.hasGruesa)
    setText('hasGruesaEjecucionAntony', info.antony.hasGruesa)

    ;['Bety','Pichi','Antony'].forEach(campoId => {
      let campo = campoId.toLowerCase()
      setText(`hasTardioEjecucion${campoId}`, info[campo].hasTardio)
      setText(`totalCostoTardioEjecucion${campoId}`, info[campo].costoTardio.toLocaleString('de-DE'))
      setText(`costoTardioEjecucionHas${campoId}`, (Number(info[campo].hasTardio) > 0)
        ? (Number(info[campo].costoTardio) / Number(info[campo].hasTardio)).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        : 0)
    })

    // TOTALES
    setText('totalHasEjecucionBety', (Number(info.bety.hasFina) + Number(info.bety.hasCobertura) + Number(info.bety.hasGruesa) + Number(info.bety.hasTardio)))
    setText('totalHasEjecucionPichi', (Number(info.pichi.hasFina) + Number(info.pichi.hasCobertura) + Number(info.pichi.hasGruesa) + Number(info.pichi.hasTardio)))
    setText('totalHasEjecucionAntony', (Number(info.antony.hasFina) + Number(info.antony.hasCobertura) + Number(info.antony.hasGruesa) + Number(info.antony.hasTardio)))
    setText('totalInversionEjecucionBety', (info.bety.costoCobertura + info.bety.costoFina + info.bety.costoGruesa + info.bety.costoTardio).toLocaleString('de-DE'))
    setText('totalInversionEjecucionPichi', (info.pichi.costoCobertura + info.pichi.costoFina + info.pichi.costoGruesa + info.pichi.costoTardio).toLocaleString('de-DE'))
    setText('totalInversionEjecucionAntony', (Number(info.antony.costoCobertura) + Number(info.antony.costoFina) + Number(info.antony.costoGruesa) + Number(info.antony.costoTardio)).toLocaleString('de-DE'))

    let ratioBety = (info.bety.hasGruesa > 0) ? ((Number(info.bety.hasFina) + Number(info.bety.hasCobertura)) / Number(info.bety.hasGruesa)).toFixed(2) : ''
    let ratioPichi = (info.pichi.hasGruesa > 0) ? ((Number(info.pichi.hasFina) + Number(info.pichi.hasCobertura)) / Number(info.pichi.hasGruesa)).toFixed(2) : ''
    let ratioAntony = (Number(info.antony.hasGruesa) > 0) ? ((Number(info.antony.hasFina) + Number(info.antony.hasCobertura)) / Number(info.antony.hasGruesa)).toFixed(2) : ''

    setText('ratioEjecucionBety', ratioBety)
    setText('ratioEjecucionPichi', ratioPichi)
    setText('ratioEjecucionAntony', ratioAntony)
    
 
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
      $('.info-tardio').hide(250)
    } else if(etapa == 'tardio') {
      $('.info-tardio').removeClass('hide')
      $('.info-gruesa').hide(250)
      $('.info-fina').hide(250)
      $('.info-cobertura').hide(250)
      $('.info-tardio').show(250)
    } else {

      $('.info-fina').removeClass('hide')
      $('.info-cobertura').removeClass('hide')

      $('.info-gruesa').hide(250)
      $('.info-tardio').hide(250)
      $('.info-fina').show(250)
      $('.info-cobertura').show(250)
    }

    let campania =  $('#campania').html()

    cargarInfoEjecucion(campania)

})

$('#btnCargaLotes').on('click',function(){

  let etapa = $('#etapaEjecucion').val()

  $('#selectEtapa').val(etapa)

  mostrarGruposCargaEtapa(etapa)

})

$(document).on('click', '.btn-eliminar-ejecucion-lote', function(){

  let lote        = $(this).data('lote')
  let campo       = $(this).data('campo')
  let etapa       = $(this).data('etapa')
  let idEjecucion = $(this).data('idejecucion')

  swal({
    title: '¿Eliminar registro?',
    text: `¿Desea eliminar el lote "${lote}" del campo "${campo}"? Esta acción no se puede deshacer.`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {

    if (result.value) {

      $.ajax({
        method: 'POST',
        url: 'ajax/agro.ajax.php',
        data: {
          accion: 'eliminarEjecucionLote',
          lote,
          campo,
          etapa,
          idEjecucion
        },
        success: function(respuesta) {
          console.log('se ejecuto la eliminacion')
          console.log(respuesta == '\"ok\"')
          console.log(respuesta)
          if (respuesta == '\"ok\"') {
            console.log('correctamente')
            swal({ type: 'success', title: 'Eliminado correctamente', showConfirmButton: false, timer: 1500 })
            let campania = $('#campania').html()
            cargarInfoEjecucion(campania)
          } else {
            console.log('hubo un error')
            swal({ type: 'error', title: 'Error al eliminar', text: 'Informar al administrador.', showConfirmButton: true })
          }
        }
      })
    }

  })

})