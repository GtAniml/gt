<?php

require_once "../controladores/combos.controlador.php";
require_once "../modelos/combos.modelo.php";

class AjaxCombos{
	/*=============================================
	EDITAR COMBO
	=============================================*/	
	public $idCombo;
	public function ajaxEditarcombo(){
		$item = "id";
		$valor = $this->idCombo;
		$respuesta = ControladorCombos::ctrMostrarCombos($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR COMBO
=============================================*/
if(isset($_POST["idCombo"])){
	$editar = new AjaxCombos();
	$editar -> idCombo = $_POST["idCombo"];
	$editar -> ajaxEditarcombo();
}