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
    
    $('#remanenteTotalModal').html();
    // Cargar detalle adicional del cultivo
    cargarDetalleCultivo(nombreCultivos[cultivo] || cultivo,totalCosechado);
    
    // Mostrar modal
    $('#modalDetalleCultivo').modal('show');
}

// Función para cargar detalle específico del cultivo
function cargarDetalleCultivo(cultivo,totalCosechado) {
    
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

    // Mostrar loader en contratos también
    $('#contratosModal').html(`
        <p class="text-center text-muted">
            <i class="fa fa-spinner fa-spin"></i> Cargando contratos...
        </p>
    `);
        
    // Cargar detalle del cultivo vía AJAX
    $.ajax({
        method: 'POST',
        url: 'ajax/agro.ajax.php',
        data: {
            accion: 'mostrarContratosCultivo',
            cultivo: cultivo,
            campania: campania
        },
        success: function(response) {
            
            try {
                let data = JSON.parse(response);
                
                if (data.success && data.detalle) {
                    
                    // Mostrar detalle de producción
                    mostrarDetalleProduccion(data.detalle);
                    
                } else {
                    $('#detalleProduccionModal').html(`
                        <p class="text-center text-muted">
                            No se encontraron detalles para este cultivo.
                        </p>
                    `);
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

    // Cargar contratos del cultivo
    cargarContratosCultivo(cultivoKey[0], campania, totalCosechado);
    
    // Cargar precio de pizarra desde Agrofy
    obtenerPrecioPizarra(cultivoKey[0]);
}

$('#btnGestionarCultivo').on('click', function() {

    $('#formCargaContrato').toggle(200);
})

// Función para cargar contratos del cultivo
function cargarContratosCultivo(cultivo, campania, totalCosechado) {
    
    $.ajax({
        method: 'POST',
        url: 'ajax/agro.ajax.php',
        data: {
            accion: 'mostrarContratosCultivo',
            cultivo: cultivo,
            campania: campania
        },
        success: function(response) {
            
            try {
                let data = JSON.parse(response);
                
                if (data.success && data.contratos && data.contratos.length > 0) {
                    mostrarTablaContratos(data.contratos, data.resumen, totalCosechado);
                } else {
                    mostrarSinContratos(totalCosechado);
                }
                
            } catch (error) {
                console.error('Error parsing contracts JSON:', error);
                $('#contratosModal').html(`
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> 
                        Error al cargar los contratos.
                    </div>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Contracts Error:', error);
            $('#contratosModal').html(`
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> 
                    Error de conexión al cargar contratos.
                </div>
            `);
        }
    });
}

// Función para mostrar tabla de contratos
function mostrarTablaContratos(contratos, resumen, totalCosechado) {
    
    // Calcular remanente
    let totalCosechadoNum = parseFloat(totalCosechado) || 0;
    let totalKilosContratos = parseFloat(resumen.total_kilos) || 0;
    let remanente = totalCosechadoNum - totalKilosContratos;
    
    // Actualizar remanente en el modal
    $('#remanenteTotalModal').html(remanente.toLocaleString('es-AR', {minimumFractionDigits: 0, maximumFractionDigits: 0}));
    
    let html = `
        <!-- Resumen de contratos -->
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-4">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Contratos</span>
                        <span class="info-box-number">${resumen.total_contratos}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-balance-scale"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Kilos</span>
                        <span class="info-box-number">${parseFloat(resumen.total_kilos).toLocaleString('es-AR')}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-dollar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Precio Promedio</span>
                        <span class="info-box-number">$${resumen.precio_promedio}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de contratos -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Precio ($/Tn)</th>
                        <th>Kilos</th>
                        <th>Corredor</th>
                        <th>Comprador</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    contratos.forEach(function(contrato) {
        html += `
            <tr>
                <td>${formatearFecha(contrato.fecha)}</td>
                <td>$${parseFloat(contrato.precio).toLocaleString('es-AR')}</td>
                <td>${parseFloat(contrato.kilos).toLocaleString('es-AR')} kg</td>
                <td>${contrato.corredor}</td>
                <td>${contrato.comprador}</td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
    `;
    
    $('#contratosModal').html(html);
}

// Función para mostrar mensaje cuando no hay contratos
function mostrarSinContratos(totalCosechado) {
    
    // Si no hay contratos, el remanente es igual al total cosechado
    let totalCosechadoNum = parseFloat(totalCosechado) || 0;
    $('#remanenteTotalModal').html(totalCosechadoNum.toLocaleString('es-AR', {minimumFractionDigits: 0, maximumFractionDigits: 0}));
    $('#contratosModal').html(`
        <div class="text-center" style="padding: 30px;">
            <i class="fa fa-file-o fa-3x" style="color: #ccc;"></i>
            <h4 style="color: #999; margin-top: 15px;">No hay contratos cargados</h4>
            <p style="color: #666;">
                No se encontraron contratos para este cultivo y campaña.
            </p>
        </div>
    `);
}

// Función auxiliar para formatear fecha
function formatearFecha(fechaString) {
    try {
        let fecha = new Date(fechaString);
        return fecha.toLocaleDateString('es-AR');
    } catch (error) {
        return fechaString;
    }
}

// Función para obtener precio de pizarra desde Agrofy
function obtenerPrecioPizarra(cultivo) {
    
    // Calcular fecha del día anterior en formato YYYYmmdd
    let fechaAyer = new Date();
    fechaAyer.setDate(fechaAyer.getDate() - 1);
    
    let year = fechaAyer.getFullYear();
    let month = String(fechaAyer.getMonth() + 1).padStart(2, '0');
    let day = String(fechaAyer.getDate()).padStart(2, '0');
    let dateString = `${year}/${month}/${day}`;
    
    // Mapeo de cultivos para Agrofy API
    let cultivosAgrofy = {
        'maiz': 'MZ',
        'maiz1': 'M9', 
        'maiz2': 'MZ',
        'soja': 'SO',
        'soja1': 'S9',
        'soja2': 'SO', 
        'girasol': 'GI',
        'trigo': 'TR',
        'avena': 'AV',
        'cebada': 'CB',
        'vicia': 'VI'
    };
    
    let cultivoAgrofy = cultivosAgrofy[cultivo.toLowerCase()] || cultivo.toLowerCase();
    
    // URL del API de Agrofy
    let apiUrl = `https://s1.dekagb.com/dkmserver.services/html/acabaseservice.aspx?mt=GetPizarras&appname=acabase&date=${dateString}&grano=${cultivoAgrofy}`;
    
    let api = 'https://s1.dekagb.com/dkmserver.services/html/acabaseservice.aspx?mt=GetPizarras&appname=acabase&date=2026/03/25&grano=GI'
    console.log(api,apiUrl)
    // Llamada AJAX al API de Agrofy
    $.ajax({
        method: 'GET',
        url: api,
        success: function(response) {
            console.log('hola')
            console.log(response)
            try {
                if (response && response.data && Array.isArray(response.data)) {
                console.log(response)
                return     
                    // Buscar el cultivo específico en la respuesta
                    let precioCultivo = response.data.find(item => 
                        item.commodity && 
                        item.commodity.toLowerCase().includes(cultivoAgrofy)
                    );
                    
                    if (precioCultivo && precioCultivo.price) {
                        // Actualizar precio remanente en el modal
                        $('#precioRemanenteModal').html(parseFloat(precioCultivo.price).toLocaleString('es-AR'));
                    } else {
                        // Si no se encuentra el cultivo específico, mostrar precio general
                        $('#precioRemanenteModal').html('No disponible');
                    }
                    
                } else {
                    $('#precioRemanenteModal').html('Sin datos');
                }
                
            } catch (error) {
                console.error('Error procesando respuesta de Agrofy:', error);
                $('#precioRemanenteModal').html('Error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error llamando API de Agrofy:', error);
            // En caso de error, mostrar mensaje informativo
            $('#precioRemanenteModal').html('No disponible');
        }
    });
}