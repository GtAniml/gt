<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{
	/*=============================================
	EDITAR USUARIO
	=============================================*/	
	public $idUsuario;
	public function ajaxEditarUsuario(){
		$item = "id";
		$valor = $this->idUsuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/
	public $validarUsuario;
	public function ajaxValidarUsuario(){
		$item = "usuario";
		$valor = $this->validarUsuario;
		
		$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	
	public $activarUsuario;
	public $activarId;

	public function ajaxActivarUsuario(){
		$tabla = "usuarios";
		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
	}

	/*=============================================
	LLENAR NUMERO CUENTA
	=============================================*/
	public $validarNombre;
	public function ajaxllamarCuenta(){
		$item = "nombre";
		$valor = $this->validarNombre;

		$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	ACTIVAR MENSAJES WHATSAPP
	=============================================*/	
	public $estadoMensajeU;
	public $activarIdM;

	public function ajaxactivarWhatsapp(){
		$tabla = "usuarios";
		$item1 = "activo_mensaje";
		$valor1 = $this->estadoMensajeU;

		$item2 = "id";
		$valor2 = $this->activarIdM;

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
	}
}
/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["idUsuario"])){
	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST["idUsuario"];
	$editar -> ajaxEditarUsuario();
}

/*=============================================
ACTIVAR USUARIO
=============================================*/	
if(isset($_POST["activarUsuario"])){
	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();
}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/
if(isset( $_POST["validarUsuario"])){
	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();
}

/*=============================================
LLAMAR EL NUMERO DE LA CUENTA
=============================================*/
if(isset($_POST["nuevaCuenta"])){
	$llamar = new AjaxUsuarios();
	$llamar -> validarNombre = $_POST["nuevaCuenta"];
	$llamar -> ajaxllamarCuenta();
}

/*=============================================
MENSAJES WHATSAPP
=============================================*/	
if(isset($_POST["estadoMensajeU"])){
	$estadoMensajeU = new AjaxUsuarios();
	$estadoMensajeU -> estadoMensajeU = $_POST["estadoMensajeU"];
	$estadoMensajeU -> activarIdM = $_POST["activarIdM"];
	$estadoMensajeU -> ajaxactivarWhatsapp();
}