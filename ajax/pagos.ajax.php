<?php

require_once "../controladores/pago.controlador.php";
require_once "../modelos/pago.modelo.php";

class AjaxPagos{
	/*=============================================
	EDITAR PAGOS
	=============================================*/	
	public $idOrden;
	public function ajaxEditarPago(){
		$item = "id";
		$valor = $this->idOrden;
		$respuesta = ControladorOrdenPago::ctrMostrarPago($item, $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
EDITAR PAGOS
=============================================*/
if(isset($_POST["idOrden"])){
	$editar = new AjaxPagos();
	$editar -> idOrden = $_POST["idOrden"];
	$editar -> ajaxEditarPago();
}