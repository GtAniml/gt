<?php

require_once "../controladores/pantalla.controlador.php";
require_once "../modelos/pantalla.modelo.php";

class AjaxPantallas{
	/*=============================================
	ACTUALIZAR PANTALLAS
	=============================================*/	
	public $idCuentaR;
	public $cambiaruno;

	public function ajaxcambiarRenovar(){
		$tabla = "cuenta_pantalla";
		$item1 = "renovo_regresa";
		$valor1 = $this->cambiaruno;

		$item2 = "id";
		$valor2 = $this->idCuentaR;

		$respuesta = ModeloPantalla::mdlActualizarPantalla($tabla, $item1, $valor1, $item2, $valor2);
	}

	/*=============================================
	EDITAR PANTALLA
	=============================================*/	
	public $idPantalla;
	public function ajaxEditarpantalla(){
		$item = "id";
		$valor = $this->idPantalla;
		$respuesta = ControladorPantalla::ctrMostrarPantalla($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
ACTUALIZAR PANTALLAS 
=============================================*/	
if(isset($_POST["idCuentaR"])){
	$idCuentaR = new AjaxPantallas();
	$idCuentaR -> idCuentaR = $_POST["idCuentaR"];
	$idCuentaR -> cambiaruno = $_POST["cambiaruno"];
	$idCuentaR -> ajaxcambiarRenovar();
}

/*=============================================
EDITAR PANTALLA
=============================================*/
if(isset($_POST["idPantalla"])){
	$editar = new AjaxPantallas();
	$editar -> idPantalla = $_POST["idPantalla"];
	$editar -> ajaxEditarpantalla();
}