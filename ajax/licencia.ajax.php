<?php

require_once "../controladores/licencia.controlador.php";
require_once "../modelos/licencia.modelo.php";

class AjaxLicencia{
	/*=============================================
	EDITAR LICENCIA
	=============================================*/	
	public $idLicencia;
	public function ajaxEditarLicencia(){
		$item = "id";
		$valor = $this->idLicencia;
		$respuesta = ControladorLicencia::ctrMostrarLicencia($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR LICENCIA
=============================================*/
if(isset($_POST["idLicencia"])){
	$editar = new AjaxLicencia();
	$editar -> idLicencia = $_POST["idLicencia"];
	$editar -> ajaxEditarLicencia();
}