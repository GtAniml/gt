<?php

require_once "../controladores/cuentas.controlador.php";
require_once "../modelos/cuentas.modelo.php";

class AjaxCuentasall{
	public function mostrarTablaCuentas(){
		$item = null;
    	$valor = null;

  		$respuesta = ControladorCuentas::ctrMostrarCuentas($item, $valor);
  		echo json_encode($respuesta);
  	}
}

/*=============================================
ACTIVAR TABLA DE MEMBRESIAS
=============================================*/ 
$activarMembresias = new AjaxCuentasall();
$activarMembresias -> mostrarTablaCuentas();