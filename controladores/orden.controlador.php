<?php

class ControladorOrden{ 
	/*=============================================
	REGISTRO DE STREAMING
	=============================================*/
	public function ctrRegistroCompra(){
		if(isset($_POST["nuevoNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])){

				$fecha = date('Y-m-d');
				$lafecha = "0000-00-00";

				$tabla1 = "notificaciones";
				$item1 = "id";
				$valor1 = 1;

				$respuesta1 = ControladorNotificacion::ctrMostrarNotificacion($tabla1, $item1, $valor1);

				$item2 = "nuevaOrdenCompra";
				$valor2 = $respuesta1["nuevaOrdenCompra"] + 1;

				$respuesta2 = ModeloNotificaciones::mdlActualizarNotificacion($tabla1, $item2, $valor2, $valor1);

				$datos = array("id_usuario"=> $_POST["nuevoId"],
							   "descripcion"=> $_POST["listaStreaming"],
							   "fecha_orden"=> $fecha,
							   "fecha_aprobacion"=> $lafecha,
							   "estado"=> 1);

				$tabla = "orden_compra";
				$respuesta = ModeloOrden::mdlRegistroOrden($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Orden de compra ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "orden-compra";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de compra no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "orden-compra";
							}
						});
					</script>';
				}

			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de compra no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "orden-compra";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR ORDEN PANTALLAS
	=============================================*/
	static public function ctrMostrarOrden($item, $valor){
		$tabla = "orden_compra";
		$respuesta = ModeloOrden::mdlMostrarOrden($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR DE STREAMING
	=============================================*/
	public function ctrEditarOrden(){
		if(isset($_POST["nuevoNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])){

				$fecha = date('Y-m-d');
				$lafecha = "0000-00-00";
				$estado = 1;

				/*=============================================
				FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
				=============================================*/
				$tabla = "orden_compra";

				$item = "id";
				$valor = $_POST["NuevoIdOrden"];

				$traerOrden = ModeloOrden::mdlMostrarOrden($tabla, $item, $valor);

				if($_POST["listaStreaming"] == ""){
					$listaStreaming = $traerOrden["descripcion"];
					$cambioProducto = false;
				}else{
					$listaStreaming = $_POST["listaStreaming"];
					$cambioProducto = true;
				}

				if($_SESSION["perfil"] == "Administrador"){
					$lafecha = $_POST["NuevoAprobado"];
					$estado = 2;
				}

				$tabla1 = "notificaciones";
				$item1 = "id";
				$valor1 = 1;

				$respuesta1 = ControladorNotificacion::ctrMostrarNotificacion($tabla1, $item1, $valor1);

				$item2 = "nuevaOrdenCompra";
				$valor2 = $respuesta1["nuevaOrdenCompra"] + 1;

				$respuesta2 = ModeloNotificaciones::mdlActualizarNotificacion($tabla1, $item2, $valor2, $valor1);

				$datos = array("id"=> $_POST["NuevoIdOrden"],
							   "id_usuario"=> $_POST["nuevoId"],
							   "descripcion"=> $listaStreaming,
							   "fecha_orden"=> $fecha,
							   "fecha_aprobacion"=> $lafecha,
							   "estado"=> $estado);

				$tabla = "orden_compra";
				$respuesta = ModeloOrden::mdlEditarOrden($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Orden de compra ha sido modificada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "orden-compra";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de compra no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "orden-compra";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de compra no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "orden-compra";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	ELIMINAR COMBO
	=============================================*/
	static public function ctrBorrarOrden(){
		if(isset($_GET["idOrden"])){

			$tabla = "orden_compra";

			$item = "id";
			$valor = $_GET["idOrden"];

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloOrden::mdlBorrarOrden($tabla, $_GET["idOrden"]);

			if($respuesta == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "La orde ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
									window.location = "orden-compra";
								}
							})
				</script>';

			}		
		}
	}
}