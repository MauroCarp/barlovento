<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary" style="box-shadow:none;">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-bar-chart"></i> Comparativo Planificación vs Ejecución
                </h3>
            </div>
            <div class="box-body">
                <!-- Resumen Visual -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Hectáreas Totales</span>
                                <span class="info-box-number" id="eficienciaHectareas">-</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Inversion Total</span>
                                <span class="info-box-number" id="variacionInversion">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dos tablas lado a lado -->
                <div class="row">
                    
                    <!-- Tabla Por Tipo de Cultivo -->
                    <div class="col-lg-6">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="fa fa-pie-chart"></i> Por Tipo de Cultivo
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="tablaEstadisticasTipo">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center">Tipo</th>
                                                <th class="text-center">Has<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">U$S<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">%<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">Dif Has</th>
                                                <th class="text-center">Dif U$S</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Fina</strong></td>
                                                <td class="text-right" id="hasFinaCombinado">-</td>
                                                <td class="text-right" id="dolareFinaCombinado">-</td>
                                                <td class="text-right" id="porcentajeFinaCombinado">-</td>
                                                <td class="text-right" id="hasFinaDiferencia">-</td>
                                                <td class="text-right" id="dolareFinaDiferencia">-</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Gruesa</strong></td>
                                                <td class="text-right" id="hasGruesaCombinado">-</td>
                                                <td class="text-right" id="dolareGruesaCombinado">-</td>
                                                <td class="text-right" id="porcentajeGruesaCombinado">-</td>
                                                <td class="text-right" id="hasGruesaDiferencia">-</td>
                                                <td class="text-right" id="dolareGruesaDiferencia">-</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Cobertura</strong></td>
                                                <td class="text-right" id="hasCoberturaCombinado">-</td>
                                                <td class="text-right" id="dolareCoberturaCombinado">-</td>
                                                <td class="text-right" id="porcentajeCoberturaCombinado">-</td>
                                                <td class="text-right" id="hasCoberturaDiferencia">-</td>
                                                <td class="text-right" id="dolareCoberturaDiferencia">-</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Invernales</strong></td>
                                                <td class="text-right" id="hasInvernalesCombinado">-</td>
                                                <td class="text-right" id="dolareInvernalesCombinado">-</td>
                                                <td class="text-right" id="porcentajeInvernalesCombinado">-</td>
                                                <td class="text-right" id="hasInvernalesDiferencia">-</td>
                                                <td class="text-right" id="dolareInvernalesDiferencia">-</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Estivales</strong></td>
                                                <td class="text-right" id="hasEstivalesCombinado">-</td>
                                                <td class="text-right" id="dolareEstivalesCombinado">-</td>
                                                <td class="text-right" id="porcentajeEstivalesCombinado">-</td>
                                                <td class="text-right" id="hasEstivalesDiferencia">-</td>
                                                <td class="text-right" id="dolareEstivalesDiferencia">-</td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabla Por Cultivo Específico -->
                    <div class="col-lg-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="fa fa-leaf"></i> Por Cultivo Específico
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="tablaEstadisticasCultivo">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center">Cultivo</th>
                                                <th class="text-center">Has<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">U$S<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">%<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">Dif Has</th>
                                                <th class="text-center">Dif U$S</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaEstadisticasCultivoBody">
                                            <!-- Se carga dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicializar cuando se haga clic en la pestaña de estadísticas
    $('#btnEstadistica').on('click', function() {
        cargarEstadisticas();
    });

    // Carga inmediata al abrir (si tab ya activo)
    cargarEstadisticas();

    // Función para cargar estadísticas reales desde backend
    function cargarEstadisticas() {
        const campania = $('#campania').text() || localStorage.getItem('campaniaAgro') || '';
        if(!campania) return;

        const url = 'ajax/agro.ajax.php';
        $.ajax({
            method: 'POST',
            url,
            data: { accion: 'estadisticas', campania },
            success: function(resp) {
                try {
                    const datos = JSON.parse(resp);
                    if(!datos || !datos.planificacion || !datos.ejecucion) return;
                    // Llenar tabla por tipo
                    llenarTablaPorTipo(datos);
                    // Llenar tabla por cultivo
                    llenarTablaPorCultivo(datos.cultivos || []);
                    // Calcular resúmenes
                    calcularResumenes(datos);
                } catch(e) {
                    console.error('Error parseando estadísticas', e);
                }
            }
        });
    }
    
    function llenarTablaPorTipo(datos) {
        const tipos = ['fina', 'gruesa', 'cobertura', 'invernales', 'estivales'];
        
        tipos.forEach(tipo => {
            const plan = datos.planificacion[tipo];
            const ejec = datos.ejecucion[tipo];
            
            // Diferencias
            const diffHas = ejec.has - plan.has;
            const diffDolares = ejec.dolares - plan.dolares;
            const diffPorcentaje = ejec.porcentaje - plan.porcentaje;
            
            // Datos combinados con colores
            const hasCombinado = `<span class="text-primary">${plan.has.toLocaleString()}</span> | <span class="text-info">${ejec.has.toLocaleString()}</span>`;
            const dolaresCombinado = `<span class="text-primary">U$S ${plan.dolares.toLocaleString()}</span> | <span class="text-info">U$S ${ejec.dolares.toLocaleString()}</span>`;
            const porcentajeCombinado = `<span class="text-primary">${plan.porcentaje}%</span> | <span class="text-info">${ejec.porcentaje}%</span>`;
            
            // Llenar datos combinados
            $(`#has${capitalizarPrimeraLetra(tipo)}Combinado`).html(hasCombinado);
            $(`#dolare${capitalizarPrimeraLetra(tipo)}Combinado`).html(dolaresCombinado);
            $(`#porcentaje${capitalizarPrimeraLetra(tipo)}Combinado`).html(porcentajeCombinado);
            
            // Llenar diferencias con colores
            const colorHas = diffHas >= 0 ? 'text-green' : 'text-red';
            const colorDolares = diffDolares >= 0 ? 'text-green' : 'text-red';
            const colorPorcentaje = diffPorcentaje >= 0 ? 'text-green' : 'text-red';
            
            $(`#has${capitalizarPrimeraLetra(tipo)}Diferencia`).html(`<span class="${colorHas}">${diffHas > 0 ? '+' : ''}${diffHas}</span>`);
            $(`#dolare${capitalizarPrimeraLetra(tipo)}Diferencia`).html(`<span class="${colorDolares}">U$S ${diffDolares.toLocaleString()}</span>`);
            $(`#porcentaje${capitalizarPrimeraLetra(tipo)}Diferencia`).html(`<span class="${colorPorcentaje}">${diffPorcentaje > 0 ? '+' : ''}${diffPorcentaje}%</span>`);
        });

    }
    
    function llenarTablaPorCultivo(cultivos) {
        let tbody = '';
        
        cultivos.forEach(cultivo => {
            const diffHas = cultivo.ejecucion.has - cultivo.planificacion.has;
            const diffDolares = cultivo.ejecucion.dolares - cultivo.planificacion.dolares;
            const diffPorcentaje = cultivo.ejecucion.porcentaje - cultivo.planificacion.porcentaje;
            
            const colorHas = diffHas >= 0 ? 'text-green' : 'text-red';
            const colorDolares = diffDolares >= 0 ? 'text-green' : 'text-red';
            const colorPorcentaje = diffPorcentaje >= 0 ? 'text-green' : 'text-red';
            
            tbody += `
                <tr>
                    <td><strong>${cultivo.nombre}</strong></td>
                    <td class="text-right"><span class="text-primary">${cultivo.planificacion.has.toLocaleString()}</span> | <span class="text-info">${cultivo.ejecucion.has.toLocaleString()}</span></td>
                    <td class="text-right"><span class="text-primary">U$S ${cultivo.planificacion.dolares.toLocaleString()}</span> | <span class="text-info">U$S ${cultivo.ejecucion.dolares.toLocaleString()}</span></td>
                    <td class="text-right"><span class="text-primary">${cultivo.planificacion.porcentaje}%</span> | <span class="text-info">${cultivo.ejecucion.porcentaje}%</span></td>
                    <td class="text-right"><span class="${colorHas}">${diffHas > 0 ? '+' : ''}${diffHas}</span></td>
                    <td class="text-right"><span class="${colorDolares}">U$S ${diffDolares.toLocaleString()}</span></td>
                </tr>
            `;
        });
        
        $('#tablaEstadisticasCultivoBody').html(tbody);
    }
    
    function calcularResumenes(datos) {
        const totalHasPlan = Object.values(datos.planificacion).reduce((sum, item) => sum + (item.has||0), 0);
        const totalHasEjec = Object.values(datos.ejecucion).reduce((sum, item) => sum + (item.has||0), 0);
        const totalDolaresPlan = Object.values(datos.planificacion).reduce((sum, item) => sum + (item.dolares||0), 0);
        const totalDolaresEjec = Object.values(datos.ejecucion).reduce((sum, item) => sum + (item.dolares||0), 0);

        const eficienciaHas = `${totalHasPlan.toLocaleString()} | ${totalHasEjec.toLocaleString()}`;
        const variacionInversion = 'U$S ' + totalDolaresPlan.toLocaleString('DE-de') + '  |  U$S ' + totalDolaresEjec.toLocaleString('DE-de');

        $('#eficienciaHectareas').text(eficienciaHas);
        $('#variacionInversion').text(variacionInversion);
    }
    
    function capitalizarPrimeraLetra(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
</script>
