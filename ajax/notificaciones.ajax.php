<?php 

require_once "../modelos/notificacion.modelo.php";

Class AjaxNotificaciones{

	public $item;

	public function ajaxActualizarNotificaciones(){
		
		$item = $this -> item;
		$valor = 0;

		$respuesta = ModeloNotificaciones::mdlActualizarNotificaciones("notificaciones", $item, $valor);

		echo $respuesta;
	}
}

if(isset($_POST["item"])){
	$actualizarNotificaciones = new AjaxNotificaciones();
	$actualizarNotificaciones -> item = $_POST['item'];
	$actualizarNotificaciones -> ajaxActualizarNotificaciones();
}