<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../controladores/gordos.controlador.php';

$accion = $_GET['accion'] ?? $_POST['accion'] ?? 'data';

if ($accion === 'data') {
  $response = ControladorGordos::ctrObtenerPrincipal();
  echo json_encode($response);
  exit;
}

http_response_code(400);
echo json_encode(['error' => 'Acción no soportada']);
exit;
