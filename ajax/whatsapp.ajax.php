<?php

require_once "../controladores/whatsapp.controlador.php";
require_once "../modelos/whatsapp.modelo.php";

class AjaxWhatsapp{
	/*=============================================
	ACTIVAR WHATSAPP
	=============================================*/	
	public $activarWhatsapp;
	public $activarId;

	public function ajaxactivarWhatsapp(){
		$tabla = "whatsapp";
		$item1 = "estado";
		$valor1 = $this->activarWhatsapp;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloWhatsapp::mdlActualizarWhatsapp($tabla, $item1, $valor1, $item2, $valor2);
	}

	/*=============================================
	EDITAR WHATSAPP
	=============================================*/	
	public $idWhatsapp;
	public function ajaxEditarWhatsapp(){
		$item = "id";
		$valor = $this->idWhatsapp;
		$respuesta = ControladorWhatsapp::ctrMostrarWhatsapp($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
ACTIVAR ANEXO
=============================================*/	
if(isset($_POST["activarWhatsapp"])){
	$activarWhatsapp = new AjaxWhatsapp();
	$activarWhatsapp -> activarWhatsapp = $_POST["activarWhatsapp"];
	$activarWhatsapp -> activarId = $_POST["activarId"];
	$activarWhatsapp -> ajaxactivarWhatsapp();
}

/*=============================================
EDITAR ANEXO
=============================================*/
if(isset($_POST["idWhatsapp"])){
	$editar = new AjaxWhatsapp();
	$editar -> idWhatsapp = $_POST["idWhatsapp"];
	$editar -> ajaxEditarWhatsapp();
}