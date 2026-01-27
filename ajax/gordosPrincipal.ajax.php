<?php

require_once "../controladores/gordos.controlador.php";

class AjaxGordos{

	/*=============================================
	CARGAR DATA REGISTRO
	=============================================*/	

	public function ajaxMostrarData(){

		$respuesta = ControladorGordos::ctrMostrarData();
        
    echo json_encode($respuesta);

	}
  

  public function ajaxObtenerResumen(){
    $respuesta = ControladorGordos::ctrResumenData();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respuesta);
  }

}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["accion"])){

	$accion = $_POST['accion'];

    if($accion == 'data'){
      
		  $mostrarData = new AjaxGordos();
      $mostrarData -> ajaxMostrarData();

    }

    if($accion === 'dataResumen'){
      $inst = new AjaxGordos();
      $inst->ajaxObtenerResumen();
    }

}
