const cobertura = ['vicia','triticale','avena','avena cobertura','cebada','vicia-triticale','cebadilla','triticale espinillo','camelina']

function calcularSuggestedMax(datos,tipo) {

  let max = Math.max(...datos)
  let min = Math.min(...datos)
  let margen = (max * 0.05)
  if(tipo == 'min')
    return min - margen;
  
  return max + margen;
}

const cargarInfoPlanificacion = (campania,carga)=>{
  
  // Obtener DATA
  
  let data = new FormData()
  data.append('accion','mostrarDataPlanificacion')
  data.append('carga',carga)
  data.append('campania',campania)

  let url = 'ajax/agro.ajax.php'
  let graficos = []

  fetch(url,{
      method:'post',
      body:data
  }).then(resp=>resp.json())
  .then(respuesta=>{
      let data = {
        'pichi':{
          'fina':{
            'hasTotal':0,
            'costo':0,
          },
          'gruesa':{
            'hasTotal':0,
            'costo':0,
          },
          'cobertura':{
            'hasTotal':0,
            'costo':0,
          },
          'estival':{
            'hasTotal':0,
          },
          'invernal':{
            'hasTotal':0,
          },
          'grafico':{
            'labels': [],
            'has': [],
            'costoHas':[]
          },
          'hasTotal':0,
          'costoTotal':0,
        },
        'bety':{
          'fina':{
            'hasTotal':0,
            'costo':0,
          },
          'gruesa':{
            'hasTotal':0,
            'costo':0,
          },
          'cobertura':{
            'hasTotal':0,
            'costo':0,
          },
          'estival':{
            'hasTotal':0,
          },
          'invernal':{
            'hasTotal':0,
          },
          'grafico':{
            'labels': [],
            'has': [],
            'costoHas':[]
          },
          'hasTotal':0,
          'costoTotal':0,
        }

      }

      respuesta['cultivos'].forEach(cultivo => {

        let costo = (parseInt(cultivo.has) * parseInt(respuesta['costos'][cultivo.cultivo]))
        let has = parseInt(cultivo.has)
        data[cultivo.campo].hasTotal += has

        if (cultivo.tipoEstInv === 'estival') {
          data[cultivo.campo].estival.hasTotal += has;
        }

        if (cultivo.tipoEstInv === 'invernal') {
          data[cultivo.campo].invernal.hasTotal += has;
        }

        if (cultivo.tipo === 'fina') {
          data[cultivo.campo].fina.hasTotal += has

          data[cultivo.campo].fina.cultivos = data[cultivo.campo].fina.cultivos || {}
          data[cultivo.campo].fina.cultivos[cultivo.cultivo] = data[cultivo.campo].fina.cultivos[cultivo.cultivo] || {}
          data[cultivo.campo].fina.cultivos[cultivo.cultivo].has = (data[cultivo.campo].fina.cultivos[cultivo.cultivo].has || 0) + has
          data[cultivo.campo].fina.cultivos[cultivo.cultivo].costo = (data[cultivo.campo].fina.cultivos[cultivo.cultivo].costo || 0) + costo
          data[cultivo.campo].fina.costo += costo

        }

        if (cultivo.tipo === 'cobertura') {
          data[cultivo.campo].cobertura.hasTotal += has

          data[cultivo.campo].cobertura.cultivos = data[cultivo.campo].cobertura.cultivos || {}
          data[cultivo.campo].cobertura.cultivos[cultivo.cultivo] = data[cultivo.campo].cobertura.cultivos[cultivo.cultivo] || {}
          data[cultivo.campo].cobertura.cultivos[cultivo.cultivo].has = (data[cultivo.campo].cobertura.cultivos[cultivo.cultivo].has || 0) + has
          data[cultivo.campo].cobertura.cultivos[cultivo.cultivo].costo = (data[cultivo.campo].cobertura.cultivos[cultivo.cultivo].costo || 0) + costo
          data[cultivo.campo].cobertura.costo += costo

        }
        
        if (cultivo.tipo === 'gruesa') {

          data[cultivo.campo].gruesa.hasTotal += has;

          data[cultivo.campo].gruesa.cultivos = data[cultivo.campo].gruesa.cultivos || {}
          data[cultivo.campo].gruesa.cultivos[cultivo.cultivo] = data[cultivo.campo].gruesa.cultivos[cultivo.cultivo] || {}
          data[cultivo.campo].gruesa.cultivos[cultivo.cultivo].has = (data[cultivo.campo].gruesa.cultivos[cultivo.cultivo].has || 0) + has
          data[cultivo.campo].gruesa.cultivos[cultivo.cultivo].costo = (data[cultivo.campo].gruesa.cultivos[cultivo.cultivo].costo || 0) + costo
          data[cultivo.campo].gruesa.costo += costo


        }          
        
        data[cultivo.campo].grafico.labels.push(`${cultivo.cultivo} / ${cultivo.lote}`)
        data[cultivo.campo].grafico.has.push(has)
        // data[cultivo.campo].grafico.costoHas.push(costo)
        data[cultivo.campo].grafico.costoHas.push(respuesta['costos'][cultivo.cultivo])

      });

      console.log(data.pichi.grafico.labels)

      data.pichi.costoTotal = data.pichi.fina.costo + data.pichi.cobertura.costo + data.pichi.gruesa.costo
      data.bety.costoTotal = data.bety.fina.costo + data.bety.cobertura.costo + data.bety.gruesa.costo              

      // PINTAR DATOS
      $('#totalHasPlanificadas').text(data.bety.hasTotal + data.pichi.hasTotal)
      $('#totalInversionPlanificada').text((data.bety.costoTotal + data.pichi.costoTotal).toLocaleString('de-DE'))

      let arr = ['bety','pichi']
      
      arr.forEach(campo => {      

        $(`#hasInvPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].invernal.hasTotal)
        $(`#hasCobPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].cobertura.hasTotal)
        $(`#hasEstPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].estival.hasTotal)
        let ratio = (data[campo].invernal.hasTotal + data[campo].cobertura.hasTotal) / data[campo].estival.hasTotal 
        $(`#ratioPlanificacion${capitalizarPrimeraLetra(campo)}`).text(ratio.toFixed(2))
  
        $(`#hasFinaPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].fina.hasTotal)
        $(`#totalCostoFinaPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].fina.costo.toLocaleString('de-DE'))
        $(`#costoFinaPlanificacionHas${capitalizarPrimeraLetra(campo)}`).text((data[campo].fina.costo / data[campo].fina.hasTotal || 0).toFixed(2).toLocaleString('de-DE'))
  
        $(`#hasCoberturaPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].cobertura.hasTotal)
        $(`#totalCostoCoberturaPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].cobertura.costo.toLocaleString('de-DE'))
        $(`#costoCoberturaPlanificacionHas${capitalizarPrimeraLetra(campo)}`).text((data[campo].cobertura.costo / data[campo].cobertura.hasTotal || 0).toFixed(2))
  
        $(`#hasGruesaPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].gruesa.hasTotal)
        $(`#totalCostoGruesaPlanificacion${capitalizarPrimeraLetra(campo)}`).text(data[campo].gruesa.costo.toLocaleString('de-DE'))
        $(`#costoGruesaPlanificacionHas${capitalizarPrimeraLetra(campo)}`).text((data[campo].gruesa.costo / data[campo].gruesa.hasTotal || 0).toFixed(2))
  
        $(`#totalHasPlanificadas${capitalizarPrimeraLetra(campo)}`).text(data[campo].hasTotal)
        $(`#totalInversionPlanificada${capitalizarPrimeraLetra(campo)}`).text(data[campo].costoTotal.toLocaleString('de-DE'))
        
        cargarDetallesCulltivos(data[campo].fina.cultivos,`${campo}Fina`)
        cargarDetallesCulltivos(data[campo].cobertura.cultivos,`${campo}Cobertura`)
        cargarDetallesCulltivos(data[campo].gruesa.cultivos,`${campo}Gruesa`)

        // PINTAR GRAFICO
        let configPlanificacion = {
          type: 'bar',
          data: {
            labels: data[campo].grafico.labels,
            datasets: [
              {
                type: 'line',
                label: 'Inversión USD/Has',
                borderColor: window.chartColors.red,
                fill:false,
                yAxisID: 'A',
                data: data[campo].grafico.costoHas
              }
              ,
              {
                label: 'Has.',
                type: 'bar',
                backgroundColor: window.chartColors.green,
                yAxisID: 'B',
                data: data[campo].grafico.has,
                borderColor: 'white',
                borderWidth: 2
              }
            ]
          },
          options: {
            scaleShowValues: true,
            scales: {
              xAxes: [{
                display:true,
                ticks: {
                  autoSkip: false
                }
              }],
              yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
                ticks: {
                  suggestedMin: calcularSuggestedMax(data[campo].grafico.costoHas,'min'),
                  suggestedMax: calcularSuggestedMax(data[campo].grafico.costoHas,'max')
                },
              
              }, {
                id: 'B',
                type: 'linear',
                position: 'right',

              }]
            },
            plugins:{
              labels:{                  
                  render:function(reg){
                      return reg.value.toLocaleString('de-DE')
                  },
              }
            },
            legend:{
              labels: {
                    boxWidth: 5
              }
            }
          }
        }
            
        generarGraficoBar(`graficoPlanificacion${capitalizarPrimeraLetra(campo)}`,configPlanificacion,'noOption')

      });

  })
  .catch( err=>console.log(err))

  return graficos

}

const eliminarArchivoCampo = (campo,seccion,campania1,campania2)=>{

  swal({
    title: `¿Está seguro de borrar los datos del campo ${campo} de la seccion ${seccion}?`,
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar datos!'
  }).then(respuesta=>{

    if(respuesta.value){

        window.location = `index.php?ruta=agro/agro&campo=${campo}&tabla=${seccion}&campania1=${campania1}&campania2=${campania2}`;

    }

})
  
}

const cargarDetallesCulltivos = (cultivos,idDetalle)=>{

  let table = document.createElement('TABLE')                
  table.setAttribute('class','table table-striped')
  
  let thead = document.createElement('THEAD')
  let thCultivo = document.createElement('TH')
  let thHas = thCultivo.cloneNode(true)
  let thCostoHas = thCultivo.cloneNode(true)

  thCultivo.innerText = 'Cultivo'
  thHas.innerText = 'Has'
  thCostoHas.innerText = 'u$s/Has'

  thead.append(thCultivo)
  thead.append(thHas)
  thead.append(thCostoHas)

  table.append(thead)

  let tbody = document.createElement('TBODY')

  let content = document.createDocumentFragment()

  for (const key in cultivos) {

    let tr = document.createElement('TR')
    let tdCultivo = document.createElement('TD')
    let tdHas = tdCultivo.cloneNode(true)
    let tdCostoHas = tdCultivo.cloneNode(true)

    let ultimoCaracter = key.slice(-1);
    
    if(!isNaN(ultimoCaracter)){

      let index = key.search(/\d/); 

      if (index !== -1) {

        let parteAntesDelNumero = key.slice(0, index);

        let numero = key.slice(index);

        tdCultivo.innerText = capitalizarPrimeraLetra(`${parteAntesDelNumero} ${numero}°`);
        
      }

    } else { 
      tdCultivo.innerText = capitalizarPrimeraLetra(key)
    }

    tdCostoHas.innerText = `u$s ${cultivos[key]['costo'].toLocaleString('de-DE')}`
    tdHas.innerText = cultivos[key]['has']

    tr.append(tdCultivo)
    tr.append(tdHas)
    tr.append(tdCostoHas)

    content.append(tr)

  }
  
  tbody.append(content)
  table.append(tbody)

  document.getElementById(idDetalle).innerHTML = '' 

  document.getElementById(idDetalle).append(table)
  
}
const btnMostrarCampania = document.getElementById('btnMostrarCampania')

btnMostrarCampania.addEventListener('click',(e)=>{
  e.preventDefault()
  let campaniaAgro = document.getElementById('campaniaAgro').value
  localStorage.setItem('campaniaAgro',campaniaAgro)
  window.location = `index.php?ruta=agro/agro&campania=${campaniaAgro}`

})

let campaniaValida = getQueryVariable('campania')

if(campania && campaniaValida){

  $('#campania').text(campania)

  let cargaPlanificacion = $('select[name="cargaPlanificacion"]').val()

  cargarInfoPlanificacion(campania,cargaPlanificacion)

}

const btnCostosPlanificacion = document.getElementById('btnCostosPlanificacion')

if(btnCostosPlanificacion != null){
    
    let campania = localStorage.getItem('campaniaAgro')

    let cargaCampania = $('select[name="cargaPlanificacion"]').val()

    let url = 'ajax/agro.ajax.php'
  
    let data = new FormData()
    data.append('accion','mostrarCostos')
    data.append('campania',campania)
    data.append('cargaCampania',cargaCampania)
  
    fetch(url,{
      method:'post',
      body:data
    }).then(resp => resp.json())
    .then(respuesta=>{

      let row = document.createElement('DIV')
      row.setAttribute('class','box-body no-padding')
      
      let table = document.createElement('TABLE')                
      table.setAttribute('class','table table-striped')
      
      let thead = document.createElement('THEAD')
      let thCultivo = document.createElement('TH')
      let thCosto = thCultivo.cloneNode(true)
      thCultivo.innerHTML = 'Cultivo'
      thCosto.innerHTML = 'U$D/Has'

      thead.append(thCultivo)
      thead.append(thCosto)
      table.append(thead)
      
      let tbody = document.createElement('TBODY')

      let content = document.createDocumentFragment()

      respuesta.map(reg=>{

        let tr = document.createElement('TR')
        let tdCultivo = document.createElement('TD')
        let tdCosto = tdCultivo.cloneNode(true)

        let ultimoCaracter = reg.cultivo.slice(-1);
        
        if(!isNaN(ultimoCaracter)){

          let index = reg.cultivo.search(/\d/); 

          if (index !== -1) {

            let parteAntesDelNumero = reg.cultivo.slice(0, index);

            let numero = reg.cultivo.slice(index);

            tdCultivo.innerText = capitalizarPrimeraLetra(`${parteAntesDelNumero} ${numero}°`);
            
          }

        } else { 
          tdCultivo.innerText = capitalizarPrimeraLetra(reg.cultivo)
        }

        tdCosto.innerText = `u$d ${reg.costo}`

        tr.append(tdCultivo)
        tr.append(tdCosto)

        content.append(tr)

      })
      
      tbody.append(content)
      table.append(tbody)
      row.append(table)

      document.getElementById('costoInversionCultivos').appendChild(row)
      
    })
    .catch(er=>console.log(er))
  
}

$('select[name="cargaPlanificacion"]').on('change',function(){

  let cargaPlanificacion = $(this).val()

  window.graficoPlanificacionBety.destroy()
  window.graficoPlanificacionPichi.destroy()

  cargarInfoPlanificacion(campania,cargaPlanificacion)

})



