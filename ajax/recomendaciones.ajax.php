<?php

require_once "../controladores/recomendaciones.controlador.php";
require_once "../modelos/recomendaciones.modelo.php";

class AjaxRecomendacion{
	/*=============================================
	ACTIVAR ANEXO
	=============================================*/	
	public $activarRecomendacion;
	public $activarId;

	public function ajaxactivarRecomendacion(){
		$tabla = "recomendaciones";
		$item1 = "estado";
		$valor1 = $this->activarRecomendacion;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloRecomendaciones::mdlActualizarRecomendacion($tabla, $item1, $valor1, $item2, $valor2);
	}

	/*=============================================
	EDITAR ANEXO
	=============================================*/	
	public $idRecomendacion;
	public function ajaxEditarRecomendacion(){
		$item = "id";
		$valor = $this->idRecomendacion;
		$respuesta = ControladorRecomendaciones::ctrMostrarRecomendacion($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
ACTIVAR ANEXO
=============================================*/	
if(isset($_POST["activarRecomendacion"])){
	$activarRecomendacion = new AjaxRecomendacion();
	$activarRecomendacion -> activarRecomendacion = $_POST["activarRecomendacion"];
	$activarRecomendacion -> activarId = $_POST["activarId"];
	$activarRecomendacion -> ajaxactivarRecomendacion();
}

/*=============================================
EDITAR ANEXO
=============================================*/
if(isset($_POST["idRecomendacion"])){
	$editar = new AjaxRecomendacion();
	$editar -> idRecomendacion = $_POST["idRecomendacion"];
	$editar -> ajaxEditarRecomendacion();
}