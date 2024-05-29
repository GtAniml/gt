<?php

require_once "../controladores/anexo.controlador.php";
require_once "../modelos/anexo.modelo.php";

class AjaxAnexo{
	/*=============================================
	ACTIVAR ANEXO
	=============================================*/	
	public $activarAnexo;
	public $activarId;

	public function ajaxactivarAnexo(){
		$tabla = "anexo";
		$item1 = "estado";
		$valor1 = $this->activarAnexo;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloAnexos::mdlActualizarAnexo($tabla, $item1, $valor1, $item2, $valor2);
	}

	/*=============================================
	EDITAR ANEXO
	=============================================*/	
	public $idAnexo;
	public function ajaxEditarAnexo(){
		$item = "id";
		$valor = $this->idAnexo;
		$respuesta = ControladorAnexos::ctrMostrarAnexo($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
ACTIVAR ANEXO
=============================================*/	
if(isset($_POST["activarAnexo"])){
	$activarAnexo = new AjaxAnexo();
	$activarAnexo -> activarAnexo = $_POST["activarAnexo"];
	$activarAnexo -> activarId = $_POST["activarId"];
	$activarAnexo -> ajaxactivarAnexo();
}

/*=============================================
EDITAR ANEXO
=============================================*/
if(isset($_POST["idAnexo"])){
	$editar = new AjaxAnexo();
	$editar -> idAnexo = $_POST["idAnexo"];
	$editar -> ajaxEditarAnexo();
}