<?php

require_once "../controladores/agro.controlador.php";
require_once "../modelos/agro.modelo.php";

class AjaxAgro{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	public $campania;
	
	public $idPlanificacion;

	public $carga;

    public $campo;

    public $etapa;

    public $seccion;

	public $data;

	public function ajaxMostrarDataPlanificacion(){
		
		$cargaPlanificacion = $this->carga;
		$campania = $this->campania;

		$idPlanificacion = ControladorAgro::ctrGetCampaignId($campania,$cargaPlanificacion);
		
		$cultivos = ControladorAgro::ctrMostrarDataCultivosPlanificacion($idPlanificacion);

		$dataCostos = ControladorAgro::ctrMostrarCostos('planificaciones',$campania,$idPlanificacion);

		$lotes = ControladorAgro::ctrGetLotes($campania);

		$data = array('idPlanificacion'=>$idPlanificacion,'cultivos'=>$cultivos,'costos'=>$dataCostos,'lotes'=>$lotes);

		echo json_encode($data);


	}

	public function ajaxMostrarDataEjecucion(){
		
		$tabla = 'ejecucion';
		$campania = $this->campania;
		$etapa = $this->etapa;

		$data = ControladorAgro::ctrMostrarDataEjecucion($tabla,'campania',$campania,'etapa',$etapa);

		$idPlanificacion = $this->idPlanificacion;
		
		$costos = ControladorAgro::ctrMostrarCostos('planificaciones',$campania,$idPlanificacion);

		foreach ($data as $key => $value) {

			$data[$key]['costoPlanificacion'] = $costos[$value['cultivo']] * $value['has'];

		}

		echo json_encode($data);

	}

	public function ajaxMostrarCostos(){

		$tabla = 'planificaciones';

		$idCampania = ControladorAgro::ctrGetCampaignId($this->campania,$this->carga);
		// echo json_encode($idCampania);
		$respuesta = ControladorAgro::ctrMostrarCostos($tabla,$this->campania,$idCampania);

		echo json_encode($respuesta);

	}

	public function ajaxCargarCostos(){

		$tabla = 'costocultivos';

		$data = (array)$this->data;
		
		$cultivos = (array)$data['cultivos'];

		$cultivosSql = array();
		
		foreach ($cultivos as $cultivo => $costo) {

			$cultivosSql[] = '(' . $data['idPlanificacion'] . ',"' . $cultivo . '",' . $costo . ')';
			
		}


		echo ControladorAgro::ctrCargarCostos($tabla,implode(',',$cultivosSql));
		
	}

	public function ajaxEjecucionValido(){

		$campania = $this->campania;
		
		$ejecucionValido = ControladorAgro::ctrMostrarEjecucion($campania);

		$ejecucionValido = ($ejecucionValido == 0) ? false : true;
		
		echo $ejecucionValido;
	
	}

}


/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["accion"])){

	$accion = $_POST['accion'];
	
	if($accion == 'mostrarDataPlanificacion'){
		$mostrarData = new AjaxAgro();
        $mostrarData -> carga = $_POST["carga"];
        $mostrarData -> campania = $_POST["campania"];
        $mostrarData -> ajaxMostrarDataPlanificacion();

    }

	if($accion == 'mostrarDataEjecucion'){
		$mostrarData = new AjaxAgro();
        $mostrarData -> campania = $_POST["campania"];
        $mostrarData -> etapa = $_POST["etapa"];
        $mostrarData -> idPlanificacion = $_POST["idPlanificacion"];
        $mostrarData -> ajaxMostrarDataEjecucion();

    }

	if($accion == 'mostrarCostos'){

		$mostrarData = new AjaxAgro();
        $mostrarData -> campania = $_POST["campania"];
        $mostrarData -> carga = $_POST["cargaCampania"];
        $mostrarData -> ajaxMostrarCostos();

    }

	if($accion == 'cargarCostos'){
		$data = json_decode($_POST['data']);
		$cargarCostos = new AjaxAgro;
		$cargarCostos->data = $data;
		$cargarCostos-> ajaxCargarCostos();
	}

	if($accion == 'ejecucion'){
		$ejecucionValido = new AjaxAgro;
		$ejecucionValido->campania = $_POST['campania'];
		$ejecucionValido-> ajaxEjecucionValido();
	}

}

