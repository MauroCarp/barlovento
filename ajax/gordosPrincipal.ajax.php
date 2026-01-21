<?php
header('Content-Type: application/json; charset=utf-8');

// En esta primera versión devolvemos datos estáticos para prueba.
// Luego se puede reemplazar por consultas a modelos/controladores.

$accion = $_GET['accion'] ?? $_POST['accion'] ?? 'data';

if ($accion === 'data') {
  $response = [
    'fecha' => '2026-01-15',
    'meses' => ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP'],
    'externo' => [
      'demanda' => [190,330,330,330,330,330,330,330,330],
      'oferta'  => [189,669,497,540,342,115,0,0,0],
    ],
    'interno' => [
      'demanda' => [200,420,420,420,420,420,420,420,420],
      'oferta'  => [337,406,469,119,18,9,0,0,0],
    ],
  ];

  echo json_encode($response);
  exit;
}

http_response_code(400);
echo json_encode(['error' => 'Acción no soportada']);
exit;
