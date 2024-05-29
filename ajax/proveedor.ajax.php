<?php

require_once "../controladores/proveedor.controlador.php";
require_once "../modelos/proveedor.modelo.php";

class AjaxProveedor{
	/*=============================================
	EDITAR PROVEEDOR
	=============================================*/	
	public $idProveedor;
	public function ajaxEditarProveedor(){
		$item = "id";
		$valor = $this->idProveedor;
		$respuesta = ControladorProveedores::ctrMostrarProveedor($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	ACTIVAR PROVEEDOR
	=============================================*/	
	public $activarProveedor;
	public $activarId;

	public function ajaxActivarProveedor(){
		$tabla = "proveedores";
		$item1 = "estado";
		$valor1 = $this->activarProveedor;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloProveedor::mdlActualizarProveedor($tabla, $item1, $valor1, $item2, $valor2);
	}
}

/*=============================================
EDITAR PROVEEDOR
=============================================*/
if(isset($_POST["idProveedor"])){
	$editar = new AjaxProveedor();
	$editar -> idProveedor = $_POST["idProveedor"];
	$editar -> ajaxEditarProveedor();
}

/*=============================================
ACTIVAR PROVEEDOR
=============================================*/	
if(isset($_POST["activarProveedor"])){
	$activarProveedor = new AjaxProveedor();
	$activarProveedor -> activarProveedor = $_POST["activarProveedor"];
	$activarProveedor -> activarId = $_POST["activarId"];
	$activarProveedor -> ajaxActivarProveedor();
}