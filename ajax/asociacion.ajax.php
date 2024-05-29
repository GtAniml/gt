<?php

require_once "../controladores/asociar.controlador.php";
require_once "../modelos/asociar.modelo.php";

class AjaxAsociacion{
	/*=============================================
	EDITAR CUENTA
	=============================================*/	
	public $idAsociacion;
	public function ajaxEditarAsociar(){
		$item = "id";
		$valor = $this->idAsociacion;
		$respuesta = ControladorAsociar::ctrMostrarAsociar($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR CUENTA
=============================================*/
if(isset($_POST["idAsociacion"])){
	$editar = new AjaxAsociacion();
	$editar -> idAsociacion = $_POST["idAsociacion"];
	$editar -> ajaxEditarAsociar();
}