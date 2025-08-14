<?php

require_once "../controladores/contable.controlador.php";
require_once "../modelos/contable.modelo.php";

class AjaxContable{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	
    public $periodo;

	public function ajaxMostrarData(){
        
        $periodo = $this->periodo;

        if($periodo == 'last'){
            
            $periodo = ControladorContable::ctrUltimoPeriodo();
        
        }

        if(isset($periodo['error'])){

            echo json_encode($periodo);

            die();

        }
        

		$respuesta = ControladorContable::ctrCalcularData($periodo);

        echo json_encode($respuesta);

	}


}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["accion"])){
	
	$accion = $_POST['accion'];

	if($accion == 'mostrarData'){

		$mostrarData = new AjaxContable();
        $mostrarData -> periodo = $_POST["periodo"];
        $mostrarData -> ajaxMostrarData();

    }

}

