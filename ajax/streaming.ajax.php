<?php

require_once "../controladores/streaming.controlador.php";
require_once "../modelos/streaming.modelo.php";

class AjaxStreaming{ 
	/*=============================================
	EDITAR STREAMING
	=============================================*/	
	public $idCategoria;
	public function ajaxEditarStreaming(){
		$item = "id";
		$valor = $this->idCategoria;
		$respuesta = ControladorStreaming::ctrMostrarStreaming($item, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	ACTIVAR STREAMING
	=============================================*/	
	public $activarCategoria;
	public $activarId;

	public function ajaxactivarCategoria(){
		$tabla = "categorias";
		$item1 = "estado";
		$valor1 = $this->activarCategoria;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloStreaming::mdlActualizarStreaming($tabla, $item1, $valor1, $item2, $valor2);
	}
	/*=============================================
	EDITAR STREAMING
	=============================================*/	
	public $nombreProducto;
	public function ajaxBuscarStreaming(){
		$item = "nombre";
		$valor = $this->nombreProducto;
		$respuesta = ControladorStreaming::ctrMostrarStreaming($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR STREAMING
=============================================*/
if(isset($_POST["idCategoria"])){
	$editar = new AjaxStreaming();
	$editar -> idCategoria = $_POST["idCategoria"];
	$editar -> ajaxEditarStreaming();
}

/*=============================================
ACTIVAR STREAMING
=============================================*/	
if(isset($_POST["activarCategoria"])){
	$activarCategoria = new AjaxStreaming();
	$activarCategoria -> activarCategoria = $_POST["activarCategoria"];
	$activarCategoria -> activarId = $_POST["activarId"];
	$activarCategoria -> ajaxactivarCategoria();
}

/*=============================================
BUSCAR STREAMING
=============================================*/
if(isset($_POST["nombreProducto"])){
	$buscar = new AjaxStreaming();
	$buscar -> nombreProducto = $_POST["nombreProducto"];
	$buscar -> ajaxBuscarStreaming();
}