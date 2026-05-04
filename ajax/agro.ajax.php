<?php

require_once "../controladores/agro.controlador.php";
require_once "../modelos/agro.modelo.php";

class AjaxAgro{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	public $campania;
	
	public $idPlanificacion;
	
	public $idProduccion;

	public $carga;

    public $campo;

    public $etapa;

    public $seccion;

	public $data;

	public $cultivo;

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

		$totales = ControladorAgro::ctrMostrarDataEjecucion($tabla,'campania',$campania,'etapa',false);

		echo json_encode(array('data' => $data,'totales'=>$totales));

	}

	public function ajaxMostrarDataProduccion(){
		$tabla = 'produccion';
		$campania = $this->campania;
		$etapa = $this->etapa;

		$data = ControladorAgro::ctrMostrarDataProduccion($tabla,'campania',$campania,'etapa',$etapa);

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

	public function ajaxProduccionValido(){
		$campania = $this->campania;
		$valido = ControladorAgro::ctrMostrarProduccion($campania);
		$valido = ($valido == 0) ? false : true;
		echo $valido;
	}

	public function ajaxGetLotes(){
		$campania = $this->campania;
		$lotes = ControladorAgro::ctrGetLotes($campania);
		echo json_encode($lotes);
	}

	public function ajaxObtenerEstadisticas(){
		$campania = $this->campania;
		$carga = $this->carga; // opcional
		$data = ControladorAgro::ctrObtenerEstadisticas($campania, $carga);
		echo json_encode($data);
	}

	public function ajaxObtenerObjetoProduccion(){
		$campania = $this->campania;
		$data = ControladorAgro::ctrGenerarObjetoProduccion($campania);
		echo json_encode($data);
	}

	public function ajaxEliminarProduccion(){
		$id = $this->idProduccion;

		$respuesta = ControladorAgro::ctrEliminarProduccion($id);
		echo json_encode($respuesta);
	}

	/*=============================================
	COMERCIALIZACIÓN - MOSTRAR CULTIVOS
	=============================================*/
	public function ajaxMostrarCultivosComercializacion(){
		$campania = $this->campania;

		$data = ControladorAgro::ctrMostrarCultivosComercializacion($campania);
		echo json_encode($data);
	}
	/*=============================================
	COMERCIALIZACIÓN - MOSTRAR CONTRATOS POR CULTIVO
	=============================================*/
	public function ajaxMostrarContratosCultivo(){
		$campania = $this->campania;
		$cultivo = $this->cultivo;

		$data = ControladorAgro::ctrMostrarContratosCultivo($campania, $cultivo);
		echo json_encode($data);
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

	if($accion == 'mostrarDataProduccion'){
		$mostrarData = new AjaxAgro();
		$mostrarData -> campania = $_POST["campania"];
		$mostrarData -> etapa = $_POST["etapa"];
		$mostrarData -> ajaxMostrarDataProduccion();

	}

	if($accion == 'ejecucion'){
		$ejecucionValido = new AjaxAgro;
		$ejecucionValido->campania = $_POST['campania'];
		$ejecucionValido-> ajaxEjecucionValido();
	}

	if($accion == 'produccion'){
		$produccionValido = new AjaxAgro;
		$produccionValido->campania = $_POST['campania'];
		$produccionValido-> ajaxProduccionValido();
	}

	if($accion == 'getLotes'){
		$getLotes = new AjaxAgro;
		$getLotes->campania = $_POST['campania'];
		$getLotes-> ajaxGetLotes();
	}

	if($accion == 'estadisticas'){
		$estadisticas = new AjaxAgro();
		$estadisticas->campania = $_POST['campania'];
		if(isset($_POST['carga'])) $estadisticas->carga = $_POST['carga'];
		$estadisticas->ajaxObtenerEstadisticas();
	}

	if($accion == 'objetoProduccion'){
		$objetoProduccion = new AjaxAgro();
		$objetoProduccion->campania = $_POST['campania'];
		$objetoProduccion->ajaxObtenerObjetoProduccion();
	}

	if($accion == 'eliminarProduccion'){
		$eliminarProduccion = new AjaxAgro();
		$eliminarProduccion->idProduccion = $_POST['id'];
		$eliminarProduccion->ajaxEliminarProduccion();
	}

	if($accion == 'mostrarCultivosComercializacion'){
		$mostrarCultivos = new AjaxAgro();
		$mostrarCultivos->campania = $_POST['campania'];
		$mostrarCultivos->ajaxMostrarCultivosComercializacion();
	}

	if($accion == 'mostrarContratosCultivo'){
		$mostrarDetalle = new AjaxAgro();
		$mostrarDetalle->campania = $_POST['campania'];
		$mostrarDetalle->cultivo = $_POST['cultivo'];
		$mostrarDetalle->ajaxMostrarContratosCultivo();
	}

	if($accion == 'eliminarContrato'){
		$id = intval($_POST['id']);
		$resultado = ControladorAgro::ctrEliminarContrato($id);
		if($resultado === 'ok'){
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'error' => $resultado]);
		}
	}

}

