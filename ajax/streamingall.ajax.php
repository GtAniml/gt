<?php

require_once "../controladores/streaming.controlador.php";
require_once "../modelos/streaming.modelo.php";

class AjaxStreamingAll{ 
	/*=============================================
	BUSCAR STREAMING
	=============================================*/
	public function mostrarTablaStreaming(){
		$item = null;
    	$valor = null;

  		$respuesta = ControladorStreaming::ctrMostrarStreaming($item, $valor);
  		echo json_encode($respuesta);
  	}
}

/*=============================================
ACTIVAR TABLA DE STREAMING
=============================================*/ 
$activarMembresias = new AjaxStreamingAll();
$activarMembresias -> mostrarTablaStreaming();