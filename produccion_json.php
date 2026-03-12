<?php
/**
 * Script simple para obtener el resultado en formato JSON
 * 
 * Uso: php produccion_json.php [campania]
 * Salida: JSON del resultado
 */

if (php_sapi_name() !== 'cli') {
    header('Content-Type: application/json');
}

error_reporting(E_ERROR);

$campania = isset($argv[1]) ? $argv[1] : '2026/2027';

try {
    require_once __DIR__ . '/modelos/conexion.php';
    require_once __DIR__ . '/modelos/agro.modelo.php';
    require_once __DIR__ . '/controladores/agro.controlador.php';
    
    $resultado = ControladorAgro::ctrGenerarObjetoProduccion($campania);
    
    echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    $error = [
        'error' => true,
        'mensaje' => $e->getMessage(),
        'codigo' => $e->getCode(),
        'campania' => $campania
    ];
    echo json_encode($error, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit(1);
}