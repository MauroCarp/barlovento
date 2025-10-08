<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Test del endpoint AJAX de compras</h1>";
echo "<p>Este archivo es para probar directamente el endpoint AJAX.</p>";

// Limpiar el log anterior
if (file_exists('ajax/compras_debug.log')) {
    unlink('ajax/compras_debug.log');
}

echo "<h2>Verificando archivos necesarios:</h2>";
echo "<ul>";

$files_to_check = [
    'controladores/compras.controlador.php',
    'modelos/compras.modelo.php',
    'controladores/datos.controlador.php',
    'modelos/datos.modelo.php',
    'ajax/datatable-compras.ajax.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "<li style='color: green;'>✓ $file - EXISTE</li>";
    } else {
        echo "<li style='color: red;'>✗ $file - NO EXISTE</li>";
    }
}
echo "</ul>";

echo "<h2>Resultado del endpoint:</h2>";
echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9;'>";

try {
    echo "<p><strong>Iniciando captura de salida...</strong></p>";
    
    // Capturar la salida del archivo AJAX
    ob_start();
    
    // Intentar incluir el archivo AJAX sin echo adicional
    $result = include 'ajax/datatable-compras.ajax.php';
    
    $output = ob_get_contents();
    ob_end_clean();
    
    echo "<pre style='background: #e8f5e8; padding: 10px;'>";
    echo "SALIDA CAPTURADA (longitud: " . strlen($output) . " caracteres):\n";
    echo "=== INICIO DE SALIDA ===\n";
    echo htmlspecialchars($output);
    echo "\n=== FIN DE SALIDA ===\n";
    echo "</pre>";
    
    // Verificar si es JSON válido
    echo "<h3>Análisis de JSON:</h3>";
    $json_decode = json_decode($output);
    $json_error = json_last_error();
    
    if ($json_error === JSON_ERROR_NONE) {
        echo "<p style='color: green;'>✓ El JSON es válido</p>";
        echo "<pre style='background: #e8f5e8; padding: 10px;'>";
        echo "JSON decodificado:\n";
        print_r($json_decode);
        echo "</pre>";
    } else {
        echo "<p style='color: red;'>✗ El JSON NO es válido</p>";
        echo "<p>Error JSON: " . json_last_error_msg() . " (Código: $json_error)</p>";
        
        // Mostrar caracteres no imprimibles o problemáticos
        echo "<h4>Análisis detallado de la salida:</h4>";
        echo "<pre style='background: #ffe8e8; padding: 10px; font-size: 12px;'>";
        for ($i = 0; $i < strlen($output); $i++) {
            $char = $output[$i];
            $ord = ord($char);
            if ($ord < 32 || $ord > 126) {
                echo "Pos $i: [ASCII $ord] ";
                if ($ord == 10) echo "[\\n]";
                elseif ($ord == 13) echo "[\\r]";
                elseif ($ord == 9) echo "[\\t]";
                else echo "[CTRL]";
                echo "\n";
            }
        }
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<pre style='background: #ffe8e8; padding: 10px;'>";
    echo "ERROR DE EXCEPCIÓN:\n";
    echo "Mensaje: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString();
    echo "</pre>";
} catch (Error $e) {
    echo "<pre style='background: #ffe8e8; padding: 10px;'>";
    echo "ERROR FATAL:\n";
    echo "Mensaje: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString();
    echo "</pre>";
}

echo "</div>";

echo "<h2>Log de debugging:</h2>";
if (file_exists('ajax/compras_debug.log')) {
    echo "<pre style='background: #f0f8ff; padding: 10px; max-height: 400px; overflow-y: scroll;'>";
    echo htmlspecialchars(file_get_contents('ajax/compras_debug.log'));
    echo "</pre>";
} else {
    echo "<p style='color: orange;'>No se encontró el archivo de log ajax/compras_debug.log</p>";
}

echo "<h2>Errores de PHP:</h2>";
$php_errors = error_get_last();
if ($php_errors) {
    echo "<pre style='background: #ffe8e8; padding: 10px;'>";
    print_r($php_errors);
    echo "</pre>";
} else {
    echo "<p style='color: green;'>No se detectaron errores de PHP</p>";
}
?>