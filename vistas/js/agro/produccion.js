$('#produccionTab').on('click', function(){
  const url = 'ajax/agro.ajax.php'
  const campania = $('#campania').html()
  if(!campania) return
  $('#inputCampaniaProduccion').val(campania)
  // Ajusta visibilidad según etapa seleccionada (por defecto GRUESA)
  actualizarVistaEtapaProduccion()

  cargarInfoProduccion(campania)
})

$('#selectEtapaProduccion, #etapaProduccion').on('change', function(){
  const campania = $('#campania').html()
  actualizarVistaEtapaProduccion()
  cargarInfoProduccion(campania)
})

function cargarInfoProduccion(campania){
  console.log('cargarInfoProduccion')
  const url = 'ajax/agro.ajax.php'
  $.ajax({
    method:'POST',
    url,
    data:{accion:'objetoProduccion',campania},
    success:function(resp){
      let respuesta = JSON.parse(resp)
      console.log(respuesta)
      renderInfoProduccion(respuesta)
    }
  })
}

function renderInfoProduccion(resp){
  console.log(resp)
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

  // Totales top y por campo según etapa
  let totalCosecha = 0
  let totalFlete = 0
  let rindeAcum = 0
  let rindeCount = 0
  campos.forEach(campo=>{
    const infoCampo = resp[campo] 

    const finaCob = infoCampo.fina.cosecha + infoCampo.cobertura.cosecha
    const fleteFinaCob = infoCampo.fina.flete + infoCampo.cobertura.flete
    const rindeFina = infoCampo.fina.rinde
    const rindeGruesa = infoCampo.gruesa.rinde
    const cosecha = (etapa==='gruesa') ? infoCampo.gruesa.cosecha : finaCob
    const flete = (etapa==='gruesa') ? infoCampo.gruesa.flete : fleteFinaCob
    const rinde = (etapa==='gruesa') ? rindeGruesa : rindeFina // simplificado promedio

    totalCosecha += cosecha
    totalFlete += flete
    if(rinde>0){ rindeAcum += rinde; rindeCount++ }

    $(`#totalCosechaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(cosecha).toLocaleString('de-DE'))
    $(`#totalFleteProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(flete).toLocaleString('de-DE'))

    // Header valores por tipo
    $(`#cosechaGruesaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.gruesa.cosecha).toLocaleString('de-DE'))
    $(`#rindeGruesaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.gruesa.rinde).toLocaleString('de-DE'))
    $(`#fleteGruesaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.gruesa.flete).toLocaleString('de-DE'))

    $(`#cosechaFinaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.fina.cosecha).toLocaleString('de-DE'))
    $(`#rindeFinaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.fina.rinde).toLocaleString('de-DE'))
    $(`#fleteFinaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.fina.flete).toLocaleString('de-DE'))

    $(`#cosechaCoberturaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.cobertura.cosecha).toLocaleString('de-DE'))
    $(`#rindeCoberturaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.cobertura.rinde).toLocaleString('de-DE'))
    $(`#fleteCoberturaProduccion${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.cobertura.flete).toLocaleString('de-DE'))

    // Detalles de cajas
    $(`#cosechaGruesaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.gruesa.cosecha).toLocaleString('de-DE'))
    $(`#rindeGruesaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.gruesa.rinde).toLocaleString('de-DE'))
    $(`#fleteGruesaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.gruesa.flete).toLocaleString('de-DE'))

    $(`#cosechaFinaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.fina.cosecha).toLocaleString('de-DE'))
    $(`#rindeFinaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.fina.rinde).toLocaleString('de-DE'))
    $(`#fleteFinaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.fina.flete).toLocaleString('de-DE'))

    $(`#cosechaCoberturaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.cobertura.cosecha).toLocaleString('de-DE'))
    $(`#rindeCoberturaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.cobertura.rinde).toLocaleString('de-DE'))
    $(`#fleteCoberturaProduccionDetalle${capitalizarPrimeraLetra(campo)}`).html(Number(infoCampo.cobertura.flete).toLocaleString('de-DE'))

    // Tablas
    const tbody = $(`#tablaProduccion${capitalizarPrimeraLetra(campo)} tbody`)
    tbody.html('')
    const rowsBase = (etapa==='gruesa') ? infoCampo.lotesGruesa : infoCampo.lotesFina
    // Normalizar filas: asegurar propiedades costo, kg, kgtotal siempre presentes
    const rows = rowsBase.map(r => Object.assign({ costo: 0, kg: 0, kgtotal: 0 }, r))
    rows.forEach(item=>{
      let kgHas = (Number(item.rinde) * 100)
      let kgTotal = (kgHas * Number(item.cosecha)) 
      tbody.append($(`
        <tr>
          <td>${item.lote}</td>
          <td>${nombreCultivos[item.cultivo]}</td>
          <td>${Number(item.cosecha).toLocaleString('de-DE')}</td>
          <td>${Number(item.costo).toLocaleString('de-DE')}</td>
          <td>${Number(kgHas).toLocaleString('de-DE')}</td>
          <td>${Number(kgTotal).toLocaleString('de-DE')}</td>
          <td>${Number(item.rinde).toLocaleString('de-DE')}</td>
          <td>${Number(item.flete).toLocaleString('de-DE')}</td>
          <td>
            <button class="btn btn-danger btn-sm btnEliminarProduccion" 
                    data-id="${item.id}" 
                    data-lote="${item.lote}" 
                    data-cultivo="${item.cultivo}" 
                    data-campo="${capitalizarPrimeraLetra(campo)}" 
                    title="Eliminar registro">
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>
      `))
    })

    // Gráfico: Has (barras) y Rinde (línea) por Lote/Cultivo
    const labels = rows.map(r => `${nombreCultivos[r.cultivo]} / ${r.lote}`)
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

    const canvasId = `graficoProduccion${capitalizarPrimeraLetra(campo)}`
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

// Event listener para botones de eliminar producción
$(document).on('click', '.btnEliminarProduccion', function(){
  const id = $(this).data('id')
  const lote = $(this).data('lote')
  const cultivo = $(this).data('cultivo')
  const campo = $(this).data('campo')
  
  eliminarRegistroProduccion(id, lote, cultivo, campo)
})

function eliminarRegistroProduccion(id, lote, cultivo, campo){
  
  // Confirmación con SweetAlert
  swal({
    title: '¿Está seguro?',
    text: `Se eliminará el registro del "${lote}" - cultivo "${nombreCultivos[cultivo]}" del campo "${campo}"`,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then(function(result) {
    if (result.value) {
      
      // Mostrar loading
      swal({
        title: 'Eliminando...',
        text: 'Por favor espere',
        type: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        onOpen: function() {
          swal.showLoading()
        }
      })
      
      // Realizar petición AJAX
      $.ajax({
        method: 'POST',
        url: 'ajax/agro.ajax.php',
        data: {
          accion: 'eliminarProduccion',
          id: id
        },
        success: function(response) {
          try {
            const resp = JSON.parse(response)
            
            if (resp === 'ok' || (resp && resp.success)) {
              swal({
                title: '¡Eliminado!',
                text: 'El registro ha sido eliminado correctamente.',
                type: 'success',
                timer: 2000,
                showConfirmButton: false
              })
              
              // Recargar la información de producción
              cargarInfoProduccion(campania)
              
            } else {
              swal({
                title: 'Error',
                text: resp.message || 'No se pudo eliminar el registro',
                type: 'error'
              })
            }
          } catch (e) {
            if (response === 'ok') {
              swal({
                title: '¡Eliminado!',
                text: 'El registro ha sido eliminado correctamente.',
                type: 'success',
                timer: 2000,
                showConfirmButton: false
              })
              
              // Recargar la información de producción
              cargarInfoProduccion(campania)
            } else {
              swal({
                title: 'Error',
                text: 'Respuesta inesperada del servidor',
                type: 'error'
              })
            }
          }
        },
        error: function(xhr, status, error) {
          swal({
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor. Inténtelo nuevamente.',
            type: 'error'
          })
        }
      })
    }
  })
}

