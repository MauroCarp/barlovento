<?php
/**
 * Script de consola para ejecutar ctrGenerarObjetoProduccion
 * 
 * Uso: php ejecutar_produccion_consola.php [campania]
 * Ejemplo: php ejecutar_produccion_consola.php "2026/2027"
 * 
 * Si no se proporciona campaña, usa "2026/2027" como valor por defecto
 */

// Verificar que se está ejecutando desde línea de comandos
if (php_sapi_name() !== 'cli') {
    die('Este script debe ejecutarse desde la línea de comandos (CLI)' . PHP_EOL);
}

// Configurar reporting de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener la campaña desde argumentos de línea de comandos
$campania = isset($argv[1]) ? $argv[1] : '2026/2027';

echo "=== Ejecutando Generación de Objeto Producción ===" . PHP_EOL;
echo "Campaña: " . $campania . PHP_EOL;
echo "Fecha: " . date('Y-m-d H:i:s') . PHP_EOL;
echo str_repeat('-', 50) . PHP_EOL;

try {
    // Incluir archivos necesarios
    require_once __DIR__ . '/modelos/conexion.php';
    require_once __DIR__ . '/modelos/agro.modelo.php';
    require_once __DIR__ . '/controladores/agro.controlador.php';
    
    echo "✓ Archivos cargados correctamente" . PHP_EOL;
    
    // Ejecutar la función
    echo "Ejecutando ctrGenerarObjetoProduccion..." . PHP_EOL;
    $resultado = ControladorAgro::ctrGenerarObjetoProduccion($campania);
    
    echo "✓ Función ejecutada correctamente" . PHP_EOL;
    echo str_repeat('-', 50) . PHP_EOL;
    
    // Mostrar resultado
    if (is_array($resultado)) {
        echo "Resultado obtenido:" . PHP_EOL;
        echo "Tipo: Array con " . count($resultado) . " elementos" . PHP_EOL;
        
        // Opción para mostrar resultado completo
        if (isset($argv[2]) && $argv[2] === '--mostrar-completo') {
            echo PHP_EOL . "RESULTADO COMPLETO:" . PHP_EOL;
            print_r($resultado);
        } else {
            echo PHP_EOL . "Para ver el resultado completo, ejecute:" . PHP_EOL;
            echo "php ejecutar_produccion_consola.php \"$campania\" --mostrar-completo" . PHP_EOL;
            
            // Mostrar preview de los primeros elementos
            if (count($resultado) > 0) {
                echo PHP_EOL . "Preview (primeros elementos):" . PHP_EOL;
                $count = 0;
                foreach ($resultado as $key => $value) {
                    if ($count >= 3) break; // Mostrar solo los primeros 3
                    if (is_array($value)) {
                        echo "  [$key] => Array con " . count($value) . " elementos" . PHP_EOL;
                    } else {
                        echo "  [$key] => " . (is_string($value) ? '"' . $value . '"' : $value) . PHP_EOL;
                    }
                    $count++;
                }
                if (count($resultado) > 3) {
                    echo "  ... y " . (count($resultado) - 3) . " elementos más" . PHP_EOL;
                }
            }
        }
    } else {
        echo "Resultado: " . var_export($resultado, true) . PHP_EOL;
    }
    
    echo str_repeat('-', 50) . PHP_EOL;
    echo "✓ Script completado exitosamente" . PHP_EOL;
    
} catch (Exception $e) {
    echo "❌ Error al ejecutar el script:" . PHP_EOL;
    echo "Mensaje: " . $e->getMessage() . PHP_EOL;
    echo "Archivo: " . $e->getFile() . PHP_EOL;
    echo "Línea: " . $e->getLine() . PHP_EOL;
    if ($e instanceof PDOException) {
        echo "Código SQL Error: " . $e->getCode() . PHP_EOL;
    }
    exit(1);
} catch (Error $e) {
    echo "❌ Error fatal:" . PHP_EOL;
    echo "Mensaje: " . $e->getMessage() . PHP_EOL;
    echo "Archivo: " . $e->getFile() . PHP_EOL;
    echo "Línea: " . $e->getLine() . PHP_EOL;
    exit(1);
}