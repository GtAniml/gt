<?php

require_once "../controladores/cuentas.controlador.php";
require_once "../modelos/cuentas.modelo.php";

class AjaxCuentas{
	/*=============================================
	VALIDAR NO REPETIR EMAIL
	=============================================*/
	public $validarEmail;
	public function ajaxValidarEmail(){
		$item = "correo";
		$valor = $this->validarEmail;

		$respuesta = ControladorCuentas::ctrMostrarCuentas($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	ACTIVAR CUENTA
	=============================================*/	
	public $activarCuenta;
	public $activarId;

	public function ajaxActivarCuenta(){
		$tabla = "cuentas";
		$item1 = "modo_cuenta";
		$valor1 = $this->activarCuenta;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloCuentas::mdlActualizarCuentaP($tabla, $item1, $valor1, $item2, $valor2);
	}

	/*=============================================
	ACTUALIZAR CUENTA ESTADO AUTOMATICO
	=============================================*/	
	public $cambiarCuenta;
	public $cambiarOcupado;
	public $cambiarId;

	public function ajaxcambiarCuenta(){
		$tabla = "cuentas";
		$item1 = "estado";
		$item3 = "ocupada";
		$valor1 = $this->cambiarCuenta;
		$valor3 = $this->cambiarOcupado;

		$item2 = "id";
		$valor2 = $this->cambiarId;

		$respuesta = ModeloCuentas::mdlActualizarCuenta($tabla, $item1, $valor1, $item2, $valor2, $item3, $valor3);
	}

	/*=============================================
	EDITAR CUENTA
	=============================================*/	
	public $idCuenta;
	public $traerProductos;
	public $nombreProducto;

	public function ajaxEditarCuenta(){
  		if($this->traerProductos == "ok"){
			$item = null;
			$valor = null;
			$orden = "id";

			$respuesta = ControladorCuentas::ctrMostrarCuentasFull($item, $valor,
			$orden);
			echo json_encode($respuesta);

  		}else if($this->nombreProducto != ""){

	      $item = "correo";
	      $valor = $this->nombreProducto;
	      $orden = "id";

	      $respuesta = ControladorCuentas::ctrMostrarCuentasFull($item, $valor,
	        $orden);
	      echo json_encode($respuesta);

	    }else{
	    	$item = "id";
			$valor = $this->idCuenta;
			$orden = "id";

			$respuesta = ControladorCuentas::ctrMostrarCuentasFull($item, $valor, $orden);
			echo json_encode($respuesta);
	    }
	}

	/*=============================================
	DESACTIVAR CUENTA
	=============================================*/	
	public $desactivarCuenta;
	public $activarCuentaD;

	public function ajaxDesactivarCuenta(){
		$tabla = "cuentas";
		$item1 = "desactivado";
		$valor1 = $this->desactivarCuenta;

		$item2 = "id";
		$valor2 = $this->activarCuentaD;

		$respuesta = ModeloCuentas::mdlActualizarCuentaD($tabla, $item1, $valor1, $item2, $valor2);
	}
		
	/*=============================================
	ACTUALIZAR PANTALLAS
	=============================================*/	
	public $idCuentam;
	public $sumaUno;

	public function ajaxcambiarCuentaM(){
		$tabla = "cuentas";
		$item1 = "pantallas";
		$valor1 = $this->sumaUno;

		$item2 = "id";
		$valor2 = $this->idCuentam;

		$respuesta = ModeloCuentas::mdlActualizarCuentaP($tabla, $item1, $valor1, $item2, $valor2);
	}
}

/*=============================================
VALIDAR NO REPETIR EMAIL
=============================================*/
if(isset( $_POST["validarEmail"])){

	$valEmail = new AjaxCuentas();
	$valEmail -> validarEmail = $_POST["validarEmail"];
	$valEmail -> ajaxValidarEmail();
}

/*=============================================
ACTIVAR CUENTA
=============================================*/	
if(isset($_POST["activarCuenta"])){
	$activarCuenta = new AjaxCuentas();
	$activarCuenta -> activarCuenta = $_POST["activarCuenta"];
	$activarCuenta -> activarId = $_POST["activarId"];
	$activarCuenta -> ajaxActivarCuenta();
}

/*=============================================
ACTUALIZAR CUENTA ESTADO AUTOMATICO
=============================================*/	
if(isset($_POST["cambiarCuenta"])){
	$cambiarCuenta = new AjaxCuentas();
	$cambiarCuenta -> cambiarCuenta = $_POST["cambiarCuenta"];
	$cambiarCuenta -> cambiarOcupado = $_POST["cambiarOcupado"];
	$cambiarCuenta -> cambiarId = $_POST["cambiarId"];
	$cambiarCuenta -> ajaxcambiarCuenta();
}

/*=============================================
EDITAR CUENTA
=============================================*/
if(isset($_POST["idCuenta"])){
	$editar = new AjaxCuentas();
	$editar -> idCuenta = $_POST["idCuenta"];
	$editar -> ajaxEditarCuenta();
}

/*=============================================
TRAER PRODUCTO
=============================================*/
if(isset($_POST["traerProductos"])){

  $traerProductos = new AjaxCuentas();
  $traerProductos -> traerProductos = $_POST["traerProductos"];
  $traerProductos -> ajaxEditarCuenta();
}

/*=============================================
TRAER PRODUCTO
=============================================*/ 
if(isset($_POST["nombreProducto"])){

  $nombreProducto = new AjaxCuentas();
  $nombreProducto -> nombreProducto = $_POST["nombreProducto"];
  $nombreProducto -> ajaxEditarCuenta();
}

/*=============================================
ACTUALIZAR PANTALLAS 
=============================================*/	
if(isset($_POST["idCuentam"])){
	$idCuentam = new AjaxCuentas();
	$idCuentam -> idCuentam = $_POST["idCuentam"];
	$idCuentam -> sumaUno = $_POST["sumaUno"];
	$idCuentam -> ajaxcambiarCuentaM();
}

/*=============================================
DESACTIVAR CUENTA
=============================================*/	
if(isset($_POST["desactivarCuenta"])){
	$desactivarCuenta = new AjaxCuentas();
	$desactivarCuenta -> desactivarCuenta = $_POST["desactivarCuenta"];
	$desactivarCuenta -> activarCuentaD = $_POST["activarCuentaD"];
	$desactivarCuenta -> ajaxDesactivarCuenta();
}