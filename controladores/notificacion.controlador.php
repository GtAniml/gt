<?php

class ControladorNotificacion{
	/*=============================================
	MOSTRAR NOTIFICACIONES
	=============================================*/
	static public function ctrMostrarNotificacion(){
		$tabla = "notificaciones";
		$respuesta = ModeloNotificaciones::mdlMostrarNotificacion($tabla);
		return $respuesta;
	}
}