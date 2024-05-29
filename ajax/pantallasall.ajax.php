<?php

require_once "../controladores/pantalla.controlador.php";
require_once "../modelos/pantalla.modelo.php";

class AjaxPantallasall{
  	/*=============================================
	MOSTRAR PANTALLAS
	=============================================*/	
	public $idPantalla;
	public function mostrarTablaPantalla(){
		$item = "fecha_termino";
		$valor = $this->idPantalla;

		$item1 = "renovo_regresa";
		$valor1 = 1;

		$respuesta = ControladorPantalla::ctrMostrarPantallasN($item, $valor, $item1, $valor1);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR PANTALLA
=============================================*/
if(isset($_POST["idPantalla"])){
	$editar = new AjaxPantallasall();
	$editar -> idPantalla = $_POST["idPantalla"];
	$editar -> mostrarTablaPantalla();
}