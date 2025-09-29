<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-bar-chart"></i> Comparativo Planificación vs Ejecución
                </h3>
            </div>
            <div class="box-body">
                
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
                                                <th class="text-center">$<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">%<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">Dif Has</th>
                                                <th class="text-center">Dif $</th>
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
                                        <tfoot>
                                            <tr class="bg-gray">
                                                <td><strong>TOTAL</strong></td>
                                                <td class="text-right" id="hasTotalCombinado"><strong>-</strong></td>
                                                <td class="text-right" id="dolareTotalCombinado"><strong>-</strong></td>
                                                <td class="text-right" id="porcentajeTotalCombinado"><strong>-</strong></td>
                                                <td class="text-right" id="hasTotalDiferencia"><strong>-</strong></td>
                                                <td class="text-right" id="dolareTotalDiferencia"><strong>-</strong></td>
                                            </tr>
                                        </tfoot>
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
                                                <th class="text-center">$<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">%<br><small>(Plan | Ejec)</small></th>
                                                <th class="text-center">Dif Has</th>
                                                <th class="text-center">Dif $</th>
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

<!-- Resumen Visual -->
<div class="row">
    <div class="col-lg-6">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Eficiencia en Hectáreas</span>
                <span class="info-box-number" id="eficienciaHectareas">-</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Variación en Inversión</span>
                <span class="info-box-number" id="variacionInversion">-</span>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicializar cuando se haga clic en la pestaña de estadísticas
    $('#estadisticasTab').on('click', function() {
        cargarEstadisticas();
    });
    
    // Cargar datos simulados al inicio para mostrar la estructura
    setTimeout(function() {
        cargarEstadisticas();
    }, 1000);
    
    // Función para cargar estadísticas (simulada por ahora)
    function cargarEstadisticas() {
        // Datos simulados más completos y realistas
        const datosSimulados = {
            planificacion: {
                fina: { has: 285, dolares: 142500, porcentaje: 42 },
                gruesa: { has: 320, dolares: 256000, porcentaje: 47 },
                cobertura: { has: 75, dolares: 22500, porcentaje: 11 },
                invernales: { has: 180, dolares: 72000, porcentaje: 26 },
                estivales: { has: 500, dolares: 421000, porcentaje: 74 }
            },
            ejecucion: {
                fina: { has: 275, dolares: 137500, porcentaje: 40 },
                gruesa: { has: 340, dolares: 272000, porcentaje: 50 },
                cobertura: { has: 68, dolares: 20400, porcentaje: 10 },
                invernales: { has: 165, dolares: 66000, porcentaje: 24 },
                estivales: { has: 518, dolares: 443400, porcentaje: 76 }
            },
            cultivos: [
                { 
                    nombre: 'Trigo',
                    planificacion: { has: 120, dolares: 48000, porcentaje: 18 },
                    ejecucion: { has: 115, dolares: 46000, porcentaje: 17 }
                },
                {
                    nombre: 'Soja 1ra',
                    planificacion: { has: 180, dolares: 108000, porcentaje: 26 },
                    ejecucion: { has: 190, dolares: 114000, porcentaje: 28 }
                },
                {
                    nombre: 'Soja 2da',
                    planificacion: { has: 105, dolares: 34500, porcentaje: 15 },
                    ejecucion: { has: 85, dolares: 23500, porcentaje: 12 }
                },
                {
                    nombre: 'Maíz',
                    planificacion: { has: 215, dolares: 172000, porcentaje: 32 },
                    ejecucion: { has: 243, dolares: 194400, porcentaje: 35 }
                },
                {
                    nombre: 'Carinata',
                    planificacion: { has: 60, dolares: 24000, porcentaje: 9 },
                    ejecucion: { has: 60, dolares: 24000, porcentaje: 9 }
                },
                {
                    nombre: 'Vicia',
                    planificacion: { has: 45, dolares: 13500, porcentaje: 7 },
                    ejecucion: { has: 40, dolares: 12000, porcentaje: 6 }
                },
                {
                    nombre: 'Avena Cobertura',
                    planificacion: { has: 30, dolares: 9000, porcentaje: 4 },
                    ejecucion: { has: 28, dolares: 8400, porcentaje: 4 }
                },
                {
                    nombre: 'Triticale',
                    planificacion: { has: 25, dolares: 7500, porcentaje: 4 },
                    ejecucion: { has: 25, dolares: 7500, porcentaje: 4 }
                },
                {
                    nombre: 'Cebada',
                    planificacion: { has: 20, dolares: 8000, porcentaje: 3 },
                    ejecucion: { has: 15, dolares: 6000, porcentaje: 2 }
                }
            ]
        };
        
        // Llenar tabla por tipo
        llenarTablaPorTipo(datosSimulados);
        
        // Llenar tabla por cultivo
        llenarTablaPorCultivo(datosSimulados.cultivos);
        
        // Calcular resúmenes
        calcularResumenes(datosSimulados);
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
            const dolaresCombinado = `<span class="text-primary">$${plan.dolares.toLocaleString()}</span> | <span class="text-info">$${ejec.dolares.toLocaleString()}</span>`;
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
            $(`#dolare${capitalizarPrimeraLetra(tipo)}Diferencia`).html(`<span class="${colorDolares}">$${diffDolares > 0 ? '+' : ''}${diffDolares.toLocaleString()}</span>`);
            $(`#porcentaje${capitalizarPrimeraLetra(tipo)}Diferencia`).html(`<span class="${colorPorcentaje}">${diffPorcentaje > 0 ? '+' : ''}${diffPorcentaje}%</span>`);
        });
        
        // Totales
        const totalHasPlan = Object.values(datos.planificacion).reduce((sum, item) => sum + item.has, 0);
        const totalHasEjec = Object.values(datos.ejecucion).reduce((sum, item) => sum + item.has, 0);
        const totalDolaresPlan = Object.values(datos.planificacion).reduce((sum, item) => sum + item.dolares, 0);
        const totalDolaresEjec = Object.values(datos.ejecucion).reduce((sum, item) => sum + item.dolares, 0);
        
        // Totales combinados
        const hasTotalCombinado = `<span class="text-primary"><strong>${totalHasPlan.toLocaleString()}</strong></span> | <span class="text-info"><strong>${totalHasEjec.toLocaleString()}</strong></span>`;
        const dolaresTotalCombinado = `<span class="text-primary"><strong>$${totalDolaresPlan.toLocaleString()}</strong></span> | <span class="text-info"><strong>$${totalDolaresEjec.toLocaleString()}</strong></span>`;
        const porcentajeTotalCombinado = `<span class="text-primary"><strong>100%</strong></span> | <span class="text-info"><strong>100%</strong></span>`;
        
        $('#hasTotalCombinado').html(hasTotalCombinado);
        $('#dolareTotalCombinado').html(dolaresTotalCombinado);
        $('#porcentajeTotalCombinado').html(porcentajeTotalCombinado);
        
        const diffTotalHas = totalHasEjec - totalHasPlan;
        const diffTotalDolares = totalDolaresEjec - totalDolaresPlan;
        const diffTotalPorcentaje = ((totalDolaresEjec - totalDolaresPlan) / totalDolaresPlan * 100).toFixed(1);
        
        const colorTotalHas = diffTotalHas >= 0 ? 'text-green' : 'text-red';
        const colorTotalDolares = diffTotalDolares >= 0 ? 'text-green' : 'text-red';
        
        $('#hasTotalDiferencia').html(`<span class="${colorTotalHas}"><strong>${diffTotalHas > 0 ? '+' : ''}${diffTotalHas}</strong></span>`);
        $('#dolareTotalDiferencia').html(`<span class="${colorTotalDolares}"><strong>$${diffTotalDolares > 0 ? '+' : ''}${diffTotalDolares.toLocaleString()}</strong></span>`);
        $('#porcentajeTotalDiferencia').html(`<span class="${colorTotalDolares}"><strong>${diffTotalPorcentaje > 0 ? '+' : ''}${diffTotalPorcentaje}%</strong></span>`);
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
                    <td class="text-right"><span class="text-primary">$${cultivo.planificacion.dolares.toLocaleString()}</span> | <span class="text-info">$${cultivo.ejecucion.dolares.toLocaleString()}</span></td>
                    <td class="text-right"><span class="text-primary">${cultivo.planificacion.porcentaje}%</span> | <span class="text-info">${cultivo.ejecucion.porcentaje}%</span></td>
                    <td class="text-right"><span class="${colorHas}">${diffHas > 0 ? '+' : ''}${diffHas}</span></td>
                    <td class="text-right"><span class="${colorDolares}">$${diffDolares > 0 ? '+' : ''}${diffDolares.toLocaleString()}</span></td>
                </tr>
            `;
        });
        
        $('#tablaEstadisticasCultivoBody').html(tbody);
    }
    
    function calcularResumenes(datos) {
        const totalHasPlan = Object.values(datos.planificacion).reduce((sum, item) => sum + item.has, 0);
        const totalHasEjec = Object.values(datos.ejecucion).reduce((sum, item) => sum + item.has, 0);
        const totalDolaresPlan = Object.values(datos.planificacion).reduce((sum, item) => sum + item.dolares, 0);
        const totalDolaresEjec = Object.values(datos.ejecucion).reduce((sum, item) => sum + item.dolares, 0);
        
        const eficienciaHas = ((totalHasEjec / totalHasPlan) * 100).toFixed(1);
        const variacionInversion = (((totalDolaresEjec - totalDolaresPlan) / totalDolaresPlan) * 100).toFixed(1);
        
        $('#eficienciaHectareas').text(eficienciaHas + '%');
        $('#variacionInversion').text(variacionInversion + '%');
        
        // Cambiar color según el resultado
        if (eficienciaHas >= 95) {
            $('#eficienciaHectareas').parent().parent().find('.info-box-icon').removeClass('bg-green bg-yellow bg-red').addClass('bg-green');
        } else if (eficienciaHas >= 80) {
            $('#eficienciaHectareas').parent().parent().find('.info-box-icon').removeClass('bg-green bg-yellow bg-red').addClass('bg-yellow');
        } else {
            $('#eficienciaHectareas').parent().parent().find('.info-box-icon').removeClass('bg-green bg-yellow bg-red').addClass('bg-red');
        }
        
        if (Math.abs(variacionInversion) <= 5) {
            $('#variacionInversion').parent().parent().find('.info-box-icon').removeClass('bg-green bg-yellow bg-red').addClass('bg-green');
        } else if (Math.abs(variacionInversion) <= 15) {
            $('#variacionInversion').parent().parent().find('.info-box-icon').removeClass('bg-green bg-yellow bg-red').addClass('bg-yellow');
        } else {
            $('#variacionInversion').parent().parent().find('.info-box-icon').removeClass('bg-green bg-yellow bg-red').addClass('bg-red');
        }
    }
    
    function capitalizarPrimeraLetra(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
</script>
