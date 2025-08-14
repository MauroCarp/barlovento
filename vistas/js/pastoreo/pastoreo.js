$('.tabsPastoreo').each(function(){

    $(this).on('click',function(){

        $('#mapaLotes').hide()

    })

})

$('.tablaCelula').on('click','.btnEditarParcela',function(){

    let id = $(this).attr('idParcela')

    let url = 'ajax/pastoreo.ajax.php'

    let cellColor = 'yellow'

    if($(this).attr('cell') == 'naranja'){
        cellColor = 'orange'
    }else if($(this).attr('cell') == 'roja'){
        cellColor = 'red'
    }

    let celula = $(this).attr('cell')

    $.ajax({

        method:'POST',
        url,
        data:{
            id,
            accion:'mostrarData'
        }

    }).done(function(resp){

        let respuesta = JSON.parse(resp)

        $('#modalHistoricoParcela').modal('hide')
        $('#modalParcela').modal('show')

        $('#cabezeraModalPastoreo').removeClass()
        $('#cabezeraModalPastoreo').addClass(`bg-${cellColor}`)
        $('#cabezeraModalPastoreo').addClass(`widget-user-header`)
        $('#detalleCelula').html(capitalizarPrimeraLetra(celula))
        $('#detalleLote').html(respuesta[0].lote)
        $('#detalleParcela').html(respuesta[0].parcela)
        
        if(respuesta.length > 0){
            // MUESTRO DATOS DETALLE
            $('#datosParcela').removeClass('hidden')
            $('#noData').addClass('hidden')

            $('#entradaPlanificado').val(respuesta[0].ingresoPlanificado)
            $('#salidaPlanificado').val(respuesta[0].salidaPlanificado)

            $('#idRegistro').val(respuesta[0].id)

            let diferenciaDiasPlanificado = ''
            let diferenciaDiasReal = ''
            let recuperacion = 0

            if(respuesta[0].ingresoReal != null){

                $('#entradaReal').val(respuesta[0].ingresoReal)

                if(respuesta[0].salidaReal == '0000-00-00' || respuesta[0].salidaReal == null){
                    setTimeout(() => {
                        $('#salidaReal').removeAttr('readOnly')
                    }, 500);

                }
                

            } else {

                $('#entradaReal').removeAttr('readOnly')

            }

            if(respuesta[0].salidaReal != null){

                $('#salidaReal').val(respuesta[0].salidaReal)
                setTimeout(() => {
                    $('#salidaReal').attr('readOnly','readOnly')
                }, 300);

                let fecha1 = moment(respuesta[0].ingresoReal);
                let fecha2 = moment(respuesta[0].salidaReal);
                diferenciaDiasReal = fecha2.diff(fecha1, 'days');
                $('#diasPastoreoReal').val(diferenciaDiasReal)


                let today = moment()
                recuperacion = today.diff(fecha2,'days')
                
            }

            let fecha1 = moment(respuesta[0].ingresoPlanificado);
            let fecha2 = moment(respuesta[0].salidaPlanificado);
            diferenciaDiasPlanificado = fecha2.diff(fecha1, 'days');
            $('#diasPlanificado').val(diferenciaDiasPlanificado)                   


            $('#recuperacion').val(recuperacion)

            // CARGO DATOS A TABLA
            respuesta.forEach(pastoreo => {
                
                let row = $(`<tr>
                                <td>${pastoreo.lote}</td>
                                <td>${pastoreo.parcela}</td>
                                <td>${moment(pastoreo.ingresoPlanificado).format('DD-MM-YYYY')}</td>
                                <td>${moment(pastoreo.salidaPlanificado).format('DD-MM-YYYY')}</td>
                                <td>${diferenciaDiasPlanificado}</td>
                                <td>${(pastoreo.ingresoReal != null) ? moment(pastoreo.ingresoReal).format('DD-MM-YYYY') : ''}</td>
                                <td>${(pastoreo.salidaReal != null) ? moment(pastoreo.salidaReal).format('DD-MM-YYYY') : ''}</td>
                                <td>${diferenciaDiasReal}</td>
                                <td>${recuperacion}</td>
                            </tr>`)

                $('#tbodyHistoricoParcela').html('')        
                $('#tbodyHistoricoParcela').html(row)        

            });

        }else{

            $('#datosParcela').addClass('hidden')
            $('#noData').removeClass('hidden')

        }

    })

})

$('.tablaCelula').on('click','.btnEliminarPlanificacion',function(){

    let el = $(this)

    swal({
        title: '¿Está seguro de borrar el registro?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, borrar!'
    }).then(function(result){

        if(result.value){

            let id = el.attr('idPlanificacion')

            let url = 'ajax/pastoreo.ajax.php'

            $.ajax({

                method:'POST',
                url,
                data:{
                    id:id,
                    accion:'eliminarPlanificacion'
                }

            }).done(function(resp){
                let respuesta = JSON.parse(resp)

                if(respuesta == 'ok'){

                    swal({
                        type: "success",
                        title: "El registro ha sido eliminado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {

                        window.location = "index.php?ruta=pastoreo/index";

                    })

                }

            })

        }

    })

    
})

$('#mostrarRegistroParsela').on('click',function(){


        // if (!/Mobi|Android/i.test(navigator.userAgent)) {
        //     $('.modal-content').css('width','800px')
        // }

        $('#modalEditarParcela').modal('hide')
        $('#modalHistoricoParcela').modal('show')

        // let divToDelete = $('#DataTables_Table_0_paginate').parent().prev();

        // $('#DataTables_Table_0_paginate').parent().removeClass('col-sm-7')
        // $('#DataTables_Table_0_paginate').parent().addClass('col-sm-12')

        // if (divToDelete.length > 0) divToDelete.remove()

})

$('#btnVolverDetalleParcela').on('click',function(){
    $('#modalHistoricoParcela').modal('hide')
    $('#modalParcela').modal('show')
})


$('.tablasModal').DataTable({
    "dom": 'lrtip',
    "responsive": true,
    "ordering": false,
    "lengthChange": false,
    "searching":false,
    "info":false,
    "language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "",
		"sInfoEmpty":      "",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		}

	}

});

$(".tablaCelula").DataTable({   
	"ordering": false,
	"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		}

	},
	'responsive': true

});


$(document).ready(function () {
    // Muestra u oculta el botón Back to Top según el desplazamiento de la página
    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
        $('#back-to-top-btn').fadeIn();
      } else {
        $('#back-to-top-btn').fadeOut();
      }
    });
  
    // Desplazamiento suave al principio de la página cuando se hace clic en el botón
    $('#back-to-top-btn').click(function () {
      $('body,html').animate({
        scrollTop: 0
      }, 800);
      return false;
    });
});

