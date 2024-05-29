<?php

require_once "../controladores/slider.controlador.php";
require_once "../modelos/slider.modelo.php";

class AjaxSlider{
	/*=============================================
	EDITAR SLIDER
	=============================================*/	
	public $idSlider;
	public function ajaxEditarSlider(){
		$item = "id";
		$valor = $this->idSlider;
		$respuesta = ControladorSlider::ctrMostrarSlider($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	ACTIVAR SLIDER
	=============================================*/	
	public $activarSlider;
	public $activarId;

	public function ajaxactivarSlider(){
		$tabla = "slider";
		$item1 = "estado";
		$valor1 = $this->activarSlider;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloSlider::mdlActualizarSlider($tabla, $item1, $valor1, $item2, $valor2);
	}
}

/*=============================================
EDITAR SLIDER
=============================================*/
if(isset($_POST["idSlider"])){
	$editar = new AjaxSlider();
	$editar -> idSlider = $_POST["idSlider"];
	$editar -> ajaxEditarSlider();
}

/*=============================================
ACTIVAR USUARIO
=============================================*/	
if(isset($_POST["activarSlider"])){
	$activarSlider = new AjaxSlider();
	$activarSlider -> activarSlider = $_POST["activarSlider"];
	$activarSlider -> activarId = $_POST["activarId"];
	$activarSlider -> ajaxactivarSlider();
}