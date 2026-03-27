$(document).ready(function() {
    
    // Cargar datos iniciales de comercialización
    cargarCultivosComercializacion();
    
});

// Función para cargar cultivos de comercialización
function cargarCultivosComercializacion() {
    
    // Obtener campaña seleccionada
    let campania = $('#campania').html().trim();
    
    if (!campania || campania === '') {
        mostrarError('No hay campaña seleccionada');
        return;
    }
    
    // Mostrar loader
    $('#containerCultivosComercializacion').html(`
        <div class="col-lg-12 text-center">
            <p style="margin: 50px 0;">
                <i class="fa fa-spinner fa-spin fa-2x"></i><br>
                <span style="font-size: 16px; color: #666;">Cargando cultivos...</span>
            </p>
        </div>
    `);
    
    // Llamada AJAX
    $.ajax({
        method: 'POST',
        url: 'ajax/agro.ajax.php',
        data: {
            accion: 'mostrarCultivosComercializacion',
            campania: campania
        },
        success: function(response) {
            
            try {
                let data = JSON.parse(response);
                
                if (data.success && data.cultivos && data.cultivos.length > 0) {
                    mostrarCardsCultivos(data.cultivos);
                } else {
                    mostrarSinDatos();
                }
                
            } catch (error) {
                console.error('Error parsing JSON:', error);
                console.log('Response received:', response);
                mostrarError('Error al procesar los datos recibidos');
            }
            
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            mostrarError('Error al cargar los datos de comercialización');
        }
    });
}

// Función para mostrar cards de cultivos
function mostrarCardsCultivos(cultivos) {
    
    let html = '';
    console.log(cultivos)
    cultivos.forEach(function(cultivo, index) {
        
        // Formatear el total cosechado
        let totalCosechado = parseFloat(cultivo.total_cosechado) || 0;
        let totalFormateado = totalCosechado.toLocaleString('es-AR',{minimumFractionDigits: 0, maximumFractionDigits: 0});
        
        html += `
            <div class="col-lg-4 col-md-4 col-sm-12" style="margin-bottom: 15px;">
                <div class="cultivoCard" data-cultivo="${cultivo.cultivo}" 
                     data-total-cosechado="${totalCosechado}"
                     style="cursor: pointer; transition: all 0.3s; padding: 15px; background: #fff; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); position: relative;">
                    
                    <h4 style="margin: 0 0 5px 0; color: #333; font-weight: bold;">
                        <i class="fa fa-leaf" style="color: #4CAF50; margin-right: 8px;"></i>
                        ${nombreCultivos[cultivo.cultivo]}
                    </h4>
                    <small style="color: #666; font-size: 13px;">
                        ${totalFormateado} Kg
                    </small>
                    
                    <!-- Icono para indicar que es clickeable -->
                    <div style="position: absolute; top: 10px; right: 10px; color: #999;">
                        <i class="fa fa-expand"></i>
                    </div>
                    
                </div>
            </div>
        `;
    });
    
    $('#containerCultivosComercializacion').html(html);
    
    // Agregar eventos click a los cards
    $('.cultivoCard').on('click', function() {
        
        let cultivo = $(this).data('cultivo');
        let totalCosechado = $(this).data('total-cosechado');
        
        abrirModalDetalleCultivo(cultivo, totalCosechado);
        
    });
    
    // Efecto hover para los cards
    $('.cultivoCard').hover(
        function() {
            $(this).css({
                'transform': 'scale(1.02)',
                'box-shadow': '0 4px 8px rgba(0,0,0,0.2)'
            });
        },
        function() {
            $(this).css({
                'transform': 'scale(1)',
                'box-shadow': 'none'
            });
        }
    );
}

// Función para mostrar mensaje cuando no hay datos
function mostrarSinDatos() {
    $('#containerCultivosComercializacion').html(`
        <div class="col-lg-12 text-center">
            <div style="margin: 50px 0;">
                <i class="fa fa-exclamation-triangle fa-3x" style="color: #f39c12;"></i>
                <h4 style="color: #666; margin-top: 20px;">No hay cultivos planificados</h4>
                <p style="color: #999;">
                    No se encontraron cultivos para la campaña seleccionada.<br>
                    Verifique que haya datos cargados en la planificación.
                </p>
            </div>
        </div>
    `);
    
    // Limpiar resumen
    $('#totalCultivosComercializacion').html('0');
    $('#totalProducidoComercializacion').html('0');
}

// Función para mostrar errores
function mostrarError(mensaje) {
    $('#containerCultivosComercializacion').html(`
        <div class="col-lg-12 text-center">
            <div class="alert alert-danger" style="margin: 30px 0;">
                <h4><i class="fa fa-exclamation-circle"></i> Error</h4>
                <p>${mensaje}</p>
                <button type="button" class="btn btn-primary" onclick="cargarCultivosComercializacion()">
                    <i class="fa fa-refresh"></i> Reintentar
                </button>
            </div>
        </div>
    `);
}

// Función para abrir modal con detalle de cultivo
function abrirModalDetalleCultivo(cultivo, totalCosechado) {
    
    // Actualizar título del modal
    $('#nombreCultivoModal').html(nombreCultivos[cultivo] || cultivo);
    
    // Actualizar datos básicos
    $('#totalCosechadoModal').html(parseFloat(totalCosechado).toLocaleString('es-AR',{minimumFractionDigits: 0, maximumFractionDigits: 0}));
    
    // Cargar detalle adicional del cultivo
    cargarDetalleCultivo(nombreCultivos[cultivo] || cultivo);
    
    // Mostrar modal
    $('#modalDetalleCultivo').modal('show');
}

// Función para cargar detalle específico del cultivo
function cargarDetalleCultivo(cultivo) {
    
    let campania = $('#campania').html().trim();
    
    $('#campaniaContrato').val(campania);
    let cultivoKey = Object.entries(nombreCultivos).find(([key, value]) => value === cultivo);
    $('#cultivoContrato').val(cultivoKey[0])
    // Mostrar loader en el modal
    $('#detalleProduccionModal').html(`
        <p class="text-center text-muted">
            <i class="fa fa-spinner fa-spin"></i> Cargando detalles...
        </p>
    `);
        
    // Cargar detalle vía AJAX
    $.ajax({
        method: 'POST',
        url: 'ajax/agro.ajax.php',
        data: {
            accion: 'mostrarDetalleCultivoComercializacion',
            cultivo: cultivo,
            campania: campania
        },
        success: function(response) {
            
            try {
                let data = JSON.parse(response);
                
                if (data.success && data.detalle) {
                    
                    // Actualizar precio pizarra
                    $('#precioPizarraModal').html(data.detalle.precioPizarra || '0');
                    
                    // Mostrar detalle de producción
                    mostrarDetalleProduccion(data.detalle);
                    
                } else {
                    $('#detalleProduccionModal').html(`
                        <p class="text-center text-muted">
                            No se encontraron detalles para este cultivo.
                        </p>
                    `);
                    $('#hectareasModal').html('0');
                }
                
            } catch (error) {
                console.error('Error parsing detail JSON:', error);
                $('#detalleProduccionModal').html(`
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> 
                        Error al cargar los detalles del cultivo.
                    </div>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Detail Error:', error);
            $('#detalleProduccionModal').html(`
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> 
                    Error de conexión al cargar detalles.
                </div>
            `);
        }
    });
}

// Función para mostrar detalle de producción en el modal
function mostrarDetalleProduccion(detalle) {
    
    let html = `
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
    `;

    
    $('#detalleProduccionModal').html(html);
}

$('#btnGestionarCultivo').on('click', function() {

    $('#formCargaContrato').toggle(200);
})