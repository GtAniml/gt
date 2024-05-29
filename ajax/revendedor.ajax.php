<?php

require_once "../controladores/revendedor.controlador.php";
require_once "../modelos/revendedor.modelo.php";

class AjaxRevendedor{
	/*=============================================
	EDITAR CUENTA REVENDEDOR
	=============================================*/	
	public $idRevendedor;
	public function ajaxEditarRevendedor(){
		$item = "id";
		$valor = $this->idRevendedor;
		$respuesta = ControladorRevendedor::ctrMostrarRevendedor($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR CUENTA REVENDEDOR
=============================================*/
if(isset($_POST["idRevendedor"])){
	$editar = new AjaxRevendedor();
	$editar -> idRevendedor = $_POST["idRevendedor"];
	$editar -> ajaxEditarRevendedor();
}