$('#produccionTab').on('click', function(){
  const url = 'ajax/agro.ajax.php'
  const campania = $('#campania').html()
  if(!campania) return
  console.log(campania)
  $('#inputCampaniaProduccion').val(campania)
  // Ajusta visibilidad según etapa seleccionada (por defecto GRUESA)
  actualizarVistaEtapaProduccion()
  $.post(url,{accion:'produccion',campania}, function(resp){
    if(resp == 0){
      $('#modalCargarProduccion').modal('show')
      // prepararInputsProduccion(campania)
    }else{
      cargarInfoProduccion(campania)
    }
  })
})

// function prepararInputsProduccion(campania){
//   const url = 'ajax/agro.ajax.php'
//   $.ajax({
//     method:'POST',
//     url,
//     data:{accion:'getLotes',campania},
//     dataType:'json',
//     success:function(lotes){
//       if(!Array.isArray(lotes) || lotes.length === 0){
//         $('#formProduccion').html('')
//         return
//       }
//       $('#inputCampaniaProduccion').val(localStorage.getItem('campaniaAgro'))
//       const grupos = {}
//       lotes.forEach(l => {
//         const campo = l.campo
//         const etapa = l.etapa
//         if(!grupos[campo]) grupos[campo] = {fina:[],gruesa:[]}
//         if(grupos[campo][etapa]) grupos[campo][etapa].push(l)
//       })
//       const cont = $('#formProduccion')
//       cont.html('')
//       Object.keys(grupos).forEach(campo => {
//         cont.append($(`<div class="bg-success" style="font-size:1.8em"><b>${capitalizarPrimeraLetra(campo)}</b></div>`))
//         ;['gruesa','fina'].forEach(etapa => {
//           const items = grupos[campo][etapa]
//           if(items && items.length){
//             const idDiv = `input${capitalizarPrimeraLetra(campo)}${capitalizarPrimeraLetra(etapa)}`
//             const div = $(`<div id="${idDiv}" ${etapa==='gruesa'?'style="display:none"':''}></div>`)
//             div.append($(`<div class="bg-info" style="font-size:1.5em"><b>${capitalizarPrimeraLetra(etapa)}</b></div>`))
//             items.forEach(l => {
//               div.append($(`<div class="form-group">
//                 <label for="${l.lote.split(' ').join('')}">${l.lote} - ${capitalizarPrimeraLetra(l.cultivo)}</label>
//                 <div class="input-group">
//                   <div class="custom-file">
//                     <input type="file" class="custom-file-input" name="${l.lote.split(' ').join('')}_${l.cultivo}">
//                     <input type="hidden" name="${l.lote.split(' ').join('')}_${l.cultivo}campo" value="${l.campo}"/>
//                   </div>
//                 </div>
//               </div>`))
//             })
//             cont.append(div)
//           }
//         })
//       })
//     },
//     error:function(){ $('#formProduccion').html('') }
//   })
// }

$('#selectEtapaProduccion, #etapaProduccion').on('change', function(){
  const campania = $('#campania').html()
  actualizarVistaEtapaProduccion()
  cargarInfoProduccion(campania)
})

function cargarInfoProduccion(campania){
  const url = 'ajax/agro.ajax.php'
  $.ajax({
    method:'POST',
    url,
    data:{accion:'objetoProduccion',campania},
    dataType:'json',
    success:function(resp){
      console.log(resp)
      renderInfoProduccion(resp)
    }
  })
}

function renderInfoProduccion(){

  const etapa = $('#etapaProduccion').val() || 'gruesa'
  const calcularSuggestedMax = (datos,tipo)=>{
    if(!Array.isArray(datos) || datos.length === 0) return 0
    const max = Math.max(...datos)
    const min = Math.min(...datos)
    const margen = (max * 0.05)
    if(tipo === 'min') return min - margen
    return max + margen
  }

  const campos = ['bety','pichi','antony']
  const C = (s)=>capitalizarPrimeraLetra(s)

  // Totales top y por campo según etapa
  let totalCosecha = 0
  let totalFlete = 0
  let rindeAcum = 0
  let rindeCount = 0

  campos.forEach(c=>{
    const d = base[c] || obtenerObjetoBaseProduccion()[c]
    const finaCob = d.fina.cosecha + d.cobertura.cosecha
    const fleteFinaCob = d.fina.flete + d.cobertura.flete
    const rindeFina = d.fina.rinde
    const rindeGruesa = d.gruesa.rinde
    const cosecha = (etapa==='gruesa') ? d.gruesa.cosecha : finaCob
    const flete = (etapa==='gruesa') ? d.gruesa.flete : fleteFinaCob
    const rinde = (etapa==='gruesa') ? rindeGruesa : rindeFina // simplificado promedio

    totalCosecha += cosecha
    totalFlete += flete
    if(rinde>0){ rindeAcum += rinde; rindeCount++ }

    $(`#totalCosechaProduccion${C(c)}`).html(Number(cosecha).toLocaleString('de-DE'))
    $(`#totalFleteProduccion${C(c)}`).html(Number(flete).toLocaleString('de-DE'))

    // Header valores por tipo
    $(`#cosechaGruesaProduccion${C(c)}`).html(Number(d.gruesa.cosecha).toLocaleString('de-DE'))
    $(`#rindeGruesaProduccion${C(c)}`).html(Number(d.gruesa.rinde).toLocaleString('de-DE'))
    $(`#fleteGruesaProduccion${C(c)}`).html(Number(d.gruesa.flete).toLocaleString('de-DE'))

    $(`#cosechaFinaProduccion${C(c)}`).html(Number(d.fina.cosecha).toLocaleString('de-DE'))
    $(`#rindeFinaProduccion${C(c)}`).html(Number(d.fina.rinde).toLocaleString('de-DE'))
    $(`#fleteFinaProduccion${C(c)}`).html(Number(d.fina.flete).toLocaleString('de-DE'))

    $(`#cosechaCoberturaProduccion${C(c)}`).html(Number(d.cobertura.cosecha).toLocaleString('de-DE'))
    $(`#rindeCoberturaProduccion${C(c)}`).html(Number(d.cobertura.rinde).toLocaleString('de-DE'))
    $(`#fleteCoberturaProduccion${C(c)}`).html(Number(d.cobertura.flete).toLocaleString('de-DE'))

    // Detalles de cajas
    $(`#cosechaGruesaProduccionDetalle${C(c)}`).html(Number(d.gruesa.cosecha).toLocaleString('de-DE'))
    $(`#rindeGruesaProduccionDetalle${C(c)}`).html(Number(d.gruesa.rinde).toLocaleString('de-DE'))
    $(`#fleteGruesaProduccionDetalle${C(c)}`).html(Number(d.gruesa.flete).toLocaleString('de-DE'))

    $(`#cosechaFinaProduccionDetalle${C(c)}`).html(Number(d.fina.cosecha).toLocaleString('de-DE'))
    $(`#rindeFinaProduccionDetalle${C(c)}`).html(Number(d.fina.rinde).toLocaleString('de-DE'))
    $(`#fleteFinaProduccionDetalle${C(c)}`).html(Number(d.fina.flete).toLocaleString('de-DE'))

    $(`#cosechaCoberturaProduccion${C(c)}`).html(Number(d.cobertura.cosecha).toLocaleString('de-DE'))
    $(`#rindeCoberturaProduccion${C(c)}`).html(Number(d.cobertura.rinde).toLocaleString('de-DE'))
    $(`#fleteCoberturaProduccion${C(c)}`).html(Number(d.cobertura.flete).toLocaleString('de-DE'))

    return
    // Tablas
    const tbody = $(`#tablaProduccion${C(c)} tbody`)
    tbody.html('')
    const rowsBase = (etapa==='gruesa') ? d.lotesGruesa : d.lotesFina
    // Normalizar filas: asegurar propiedades costo, kg, kgtotal siempre presentes
    const rows = rowsBase.map(r => Object.assign({ costo: 0, kg: 0, kgtotal: 0 }, r))
    rows.forEach(item=>{
      tbody.append($(`
        <tr>
          <td>${item.lote}</td>
          <td>${item.cultivo}</td>
          <td>${Number(item.cosecha).toLocaleString('de-DE')}</td>
          <td>${Number(item.costo).toLocaleString('de-DE')}</td>
          <td>${Number(item.kg).toLocaleString('de-DE')}</td>
          <td>${Number(item.kgtotal).toLocaleString('de-DE')}</td>
          <td>${Number(item.rinde).toLocaleString('de-DE')}</td>
          <td>${Number(item.flete).toLocaleString('de-DE')}</td>
        </tr>
      `))
    })

    // Gráfico: Has (barras) y Rinde (línea) por Lote/Cultivo
    const labels = rows.map(r => `${r.cultivo} / ${r.lote}`)
    const datosHas = rows.map(r => Number(r.cosecha))
    const datosRinde = rows.map(r => Number(r.rinde))

    const config = {
      type: 'bar',
      data: {
        labels,
        datasets: [
          {
            type: 'line',
            label: 'Rinde',
            borderColor: window.chartColors.red,
            backgroundColor: window.chartColors.red,
            fill: false,
            yAxisID: 'A',
            data: datosRinde
          },
          {
            label: 'Has',
            type: 'bar',
            backgroundColor: window.chartColors.green,
            borderColor: 'white',
            borderWidth: 2,
            yAxisID: 'B',
            data: datosHas
          }
        ]
      },
      options: {
        scales: {
          xAxes: [{
            display: true,
            ticks: { autoSkip: false }
          }],
          yAxes: [
            {
              id: 'A', type: 'linear', position: 'left',
              ticks: {
                beginAtZero: true,
                suggestedMax: calcularSuggestedMax(datosRinde,'max')
              }
            },
            { id: 'B', type: 'linear', position: 'right', ticks: { beginAtZero: true } }
          ]
        },
        plugins: { labels: { render: function(reg){ return Number(reg.value).toLocaleString('de-DE') } } },
        legend: { labels: { boxWidth: 5 } }
      }
    }

    const canvasId = `graficoProduccion${C(c)}`
    if(document.getElementById(canvasId)){
      if(window[canvasId]){ try { window[canvasId].destroy() } catch(e){} }
      generarGraficoBar(canvasId, config, 'noOption')
    }
  })

  const rindeProm = (rindeCount>0) ? (rindeAcum/rindeCount).toFixed(2) : 0
  $('#totalCosechaProduccion').html(Number(totalCosecha).toLocaleString('de-DE'))
  $('#totalFleteProduccion').html(Number(totalFlete).toLocaleString('de-DE'))
  $('#rindePromedioProduccion').html(rindeProm)

}

function actualizarVistaEtapaProduccion(){
  const etapa = $('#etapaProduccion').val() || 'gruesa'
  if(etapa === 'gruesa'){
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
  // Modal inputs (si está abierto): alterna grupos de archivos por etapa
  const etapaModal = $('#selectEtapaProduccion').val() || etapa
  if(etapaModal === 'gruesa'){
    $("div[id$='Gruesa']").show(250)
    $("div[id$='Fina']").hide(250)
  } else {
    $("div[id$='Gruesa']").hide(250)
    $("div[id$='Fina']").show(250)
  }
}

