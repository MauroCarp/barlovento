<?php

require_once "../controladores/pastoreo.controlador.php";
require_once "../modelos/pastoreo.modelo.php";

class AjaxPastoreo{

	/*=============================================
	CARGAR DATA REGISTRO
	=============================================*/	

    public $id;

	public function ajaxMostrarData(){

        $id = $this->id;
		$item = 'id';
		$respuesta = ControladorPastoreo::ctrMostrarRegistros($item,$id);
        
        echo json_encode($respuesta);

	}

	public function ajaxEliminarPlanificacion(){

        $id = $this->id;
		$item = 'id';
		$respuesta = ControladorPastoreo::ctrEliminarRegistro($item,$id);
        
        echo json_encode($respuesta);

	}

}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["accion"])){

	$accion = $_POST['accion'];

    if($accion == 'mostrarData'){
		$mostrarData = new AjaxPastoreo();
        $mostrarData -> id = $_POST["id"];
        $mostrarData -> ajaxMostrarData();
    }

	if($accion == 'eliminarPlanificacion'){
		$mostrarData = new AjaxPastoreo();
        $mostrarData -> id = $_POST["id"];
        $mostrarData -> ajaxEliminarPlanificacion();
    }

}

