// $.ajax({

// 	url: "ajax/datatable-compras.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// });


console.log("Iniciando configuración del DataTable de compras");

$('.tablaCompras').DataTable( {
    "ajax": {
        "url": "ajax/datatable-compras.ajax.php",
        "error": function (xhr, error, code) {
            console.error("Error AJAX en DataTable:", {
                "xhr": xhr,
                "error": error,
                "code": code,
                "status": xhr.status,
                "statusText": xhr.statusText,
                "responseText": xhr.responseText
            });
            
            // Mostrar alerta al usuario
            if (typeof swal !== 'undefined') {
                swal({
                    type: "error",
                    title: "Error al cargar los datos",
                    text: "Error: " + error + " (Código: " + xhr.status + ")\nRevisa el archivo compras_debug.log para más detalles.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });
            } else {
                alert("Error al cargar los datos. Revisa la consola del navegador y el archivo compras_debug.log para más detalles.");
            }
        },
        "success": function(data) {
            console.log("Datos recibidos exitosamente:", data);
        }
    },
    "deferRender": true,
	"retrieve": true,
	"processing": true,
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
	"initComplete": function(settings, json) {
        console.log("DataTable inicializado correctamente:", json);
    },
    "drawCallback": function(settings) {
        console.log("Tabla redibujada, registros mostrados:", settings.fnRecordsDisplay());
    }

} );


$('#compararValidoFechaCompras').change(function(){
	
	let compararValido = $(this).is(':checked');
	
	console.log(compararValido);

	if(compararValido){
  
	  $('#modalFechaComprasComparar').show(1000);
  
	  $('#modalFechaCompra').css('left','-250px');
	  
	  $('#modalFechaCompra').css('transition','left 1s');
	  
	  
	}else{
	  
	  $('#modalFechaComprasComparar').hide(800);
  
	  $('#modalFechaCompra').css('left','0');
	  
	  $('#modalFechaCompra').css('transition','left 1s');
  
	}
  
  
  });

  $('#daterange-btnCompras').daterangepicker(
	{
	  ranges   : {
  
	  },
	  startDate: moment(),
	  endDate  : moment()
	},
	function (start, end) {
	  $('#daterange-btnCompras span').html(start.format('d/m/Y') + ' - ' + end.format('DD/MM/YYYY'));
  
	  var fechaInicial = start.format('YYYY-MM-d');
  
	  var fechaFinal = end.format('YYYY-MM-d');
  
	  localStorage.setItem('rangoCompras', fechaInicial + '/' + fechaFinal);
  
	  var capturarRango = $("#daterange-btnCompras span").html();
  
	  cargarSelectSegunFecha('1',capturarRango,'compras','consignatario','fecha');
	  
	  cargarSelectSegunFecha('1',capturarRango,'compras','proveedor','fecha');
	  
	  cargarSelectSegunFecha('1',capturarRango,'compras','tropa','fecha');
	}
  
  );

  $('#daterange-btnComprasComp').daterangepicker(
	{
	  ranges   : {
  
	  },
	  startDate: moment(),
	  endDate  : moment()
	},
	function (start, end) {
	  $('#daterange-btnComprasComp span').html(start.format('d/m/Y') + ' - ' + end.format('DD/MM/YYYY'));
  
	  var fechaInicial = start.format('YYYY-MM-d');
  
	  var fechaFinal = end.format('YYYY-MM-d');
  
	  localStorage.setItem('rangoComprasComp', fechaInicial + '/' + fechaFinal);
  
	  var capturarRango = $("#daterange-btnComprasComp span").html();
  
	  cargarSelectSegunFecha('1',capturarRango,'compras','consignatario','fecha');
	  
	  cargarSelectSegunFecha('1',capturarRango,'compras','proveedor','fecha');
	  
	  cargarSelectSegunFecha('1',capturarRango,'compras','tropa','fecha');
	}
  
  );
  