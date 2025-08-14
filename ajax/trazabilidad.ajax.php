<?php

require_once "../controladores/trazabilidad.controlador.php";
require_once "../modelos/trazabilidad.modelo.php";

class AjaxTrazabilidad{

    public $idFaena;

	public function ajaxEliminarFaena(){
		
		$respuesta = ControladorTrazabilidad::ctrEliminarFaena($this->idFaena);
		
		echo json_encode($respuesta);

	}

}

if(isset($_POST["accion"])){

	$accion = $_POST['accion'];

	if($accion == 'eliminar'){

		$eliminarFaena = new AjaxTrazabilidad();
        $eliminarFaena -> idFaena= $_POST["idFaena"];
        $eliminarFaena -> ajaxEliminarFaena();

    }

}

