$('#produccionTab').on('click', function(){
  const url = 'ajax/agro.ajax.php'
  const campania = $('#campania').html()
  if(!campania) return
  // Ajusta visibilidad según etapa seleccionada (por defecto GRUESA)
  actualizarVistaEtapaProduccion()
  $.post(url,{accion:'produccion',campania}, function(resp){
    if(resp == 0){
      $('#modalCargarProduccion').modal('show')
      prepararInputsProduccion(campania)
    }else{
      cargarInfoProduccion(campania)
    }
  })
})

function prepararInputsProduccion(campania){
  const url = 'ajax/agro.ajax.php'
  $.ajax({
    method:'POST',
    url,
    data:{accion:'getLotes',campania},
    dataType:'json',
    success:function(lotes){
      if(!Array.isArray(lotes) || lotes.length === 0){
        $('#formProduccion').html('')
        return
      }
      $('#inputCampaniaProduccion').val(localStorage.getItem('campaniaAgro'))
      const grupos = {}
      lotes.forEach(l => {
        const campo = l.campo
        const etapa = l.etapa
        if(!grupos[campo]) grupos[campo] = {fina:[],gruesa:[]}
        if(grupos[campo][etapa]) grupos[campo][etapa].push(l)
      })
      const cont = $('#formProduccion')
      cont.html('')
      Object.keys(grupos).forEach(campo => {
        cont.append($(`<div class="bg-success" style="font-size:1.8em"><b>${capitalizarPrimeraLetra(campo)}</b></div>`))
        ;['gruesa','fina'].forEach(etapa => {
          const items = grupos[campo][etapa]
          if(items && items.length){
            const idDiv = `input${capitalizarPrimeraLetra(campo)}${capitalizarPrimeraLetra(etapa)}`
            const div = $(`<div id="${idDiv}" ${etapa==='gruesa'?'style="display:none"':''}></div>`)
            div.append($(`<div class="bg-info" style="font-size:1.5em"><b>${capitalizarPrimeraLetra(etapa)}</b></div>`))
            items.forEach(l => {
              div.append($(`<div class="form-group">
                <label for="${l.lote.split(' ').join('')}">${l.lote} - ${capitalizarPrimeraLetra(l.cultivo)}</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="${l.lote.split(' ').join('')}_${l.cultivo}">
                    <input type="hidden" name="${l.lote.split(' ').join('')}_${l.cultivo}campo" value="${l.campo}"/>
                  </div>
                </div>
              </div>`))
            })
            cont.append(div)
          }
        })
      })
    },
    error:function(){ $('#formProduccion').html('') }
  })
}

$('#selectEtapaProduccion, #etapaProduccion').on('change', function(){
  const campania = $('#campania').html()
  actualizarVistaEtapaProduccion()
  cargarInfoProduccion(campania)
})

function cargarInfoProduccion(campania){
  const etapa = $('#etapaProduccion').val() || 'gruesa'
  // Demo/harcodeo de datos para validar UI
  const demo = {
    bety: {
      fina: { cosecha: 320, rinde: 29.4, flete: 4100 },
      cobertura: { cosecha: 60, rinde: 0, flete: 300 },
      gruesa: { cosecha: 520, rinde: 36.2, flete: 7100 },
      lotesGruesa: [
        { lote:'L1', cultivo:'soja1', cosecha:180, rinde: 36.8, flete: 2500 },
        { lote:'L2', cultivo:'maiz1', cosecha:220, rinde: 35.9, flete: 3000 },
        { lote:'L3', cultivo:'soja2', cosecha:120, rinde: 36.0, flete: 1600 }
      ],
      lotesFina: [
        { lote:'L7', cultivo:'trigo', cosecha:200, rinde: 30.0, flete: 2600 },
        { lote:'L8', cultivo:'vicia-triticale', cosecha:60, rinde: 0, flete: 300 },
        { lote:'L9', cultivo:'triticale', cosecha:120, rinde: 28.2, flete: 1200 }
      ]
    },
    pichi: {
      fina: { cosecha: 280, rinde: 27.9, flete: 3800 },
      cobertura: { cosecha: 70, rinde: 0, flete: 350 },
      gruesa: { cosecha: 460, rinde: 35.2, flete: 6600 },
      lotesGruesa: [
        { lote:'P1', cultivo:'maiz1', cosecha:190, rinde: 34.7, flete: 2700 },
        { lote:'P2', cultivo:'soja1', cosecha:170, rinde: 35.6, flete: 2400 },
        { lote:'P3', cultivo:'soja2', cosecha:100, rinde: 35.4, flete: 1500 }
      ],
      lotesFina: [
        { lote:'P7', cultivo:'trigo', cosecha:180, rinde: 28.4, flete: 2200 },
        { lote:'P8', cultivo:'avena', cosecha:70, rinde: 0, flete: 350 },
        { lote:'P9', cultivo:'triticale', cosecha:100, rinde: 27.0, flete: 1250 }
      ]
    },
    antony: {
      fina: { cosecha: 150, rinde: 26.5, flete: 2100 },
      cobertura: { cosecha: 40, rinde: 0, flete: 220 },
      gruesa: { cosecha: 260, rinde: 34.1, flete: 4300 },
      lotesGruesa: [
        { lote:'A1', cultivo:'soja1', cosecha:140, rinde: 34.0, flete: 2100 },
        { lote:'A2', cultivo:'maiz2', cosecha:120, rinde: 34.2, flete: 2200 }
      ],
      lotesFina: [
        { lote:'A7', cultivo:'trigo', cosecha:110, rinde: 27.0, flete: 1600 },
        { lote:'A9', cultivo:'vicia', cosecha:40, rinde: 0, flete: 220 }
      ]
    }
  }

  const campos = ['bety','pichi','antony']
  const C = (s)=>capitalizarPrimeraLetra(s)

  // Totales top y por campo según etapa
  let totalCosecha = 0
  let totalFlete = 0
  let rindeAcum = 0
  let rindeCount = 0

  campos.forEach(c=>{
    const d = demo[c]
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

    // Tablas
    const tbody = $(`#tablaProduccion${C(c)} tbody`)
    tbody.html('')
    const rows = (etapa==='gruesa') ? d.lotesGruesa : d.lotesFina
    rows.forEach(item=>{
      tbody.append($(`
        <tr>
          <td>${item.lote}</td>
          <td>${item.cultivo}</td>
          <td>${Number(item.cosecha).toLocaleString('de-DE')}</td>
          <td>${Number(item.rinde).toLocaleString('de-DE')}</td>
          <td>${Number(item.flete).toLocaleString('de-DE')}</td>
        </tr>
      `))
    })
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

