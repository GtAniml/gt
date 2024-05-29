<?php

class ControladorOrdenPago{
	/*=============================================
	REGISTRO DE ORDEN DE PAGO
	=============================================*/
	public function ctrRegistroPago(){
		if(isset($_POST["nuevoNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$ruta = "";
				if($_FILES["nuevaFoto"]["tmp_name"] == ""){

				}else{
					if(isset($_FILES["nuevaFoto"]["tmp_name"])){
						
						list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

						$nuevoAncho = 400;
						$nuevoAlto = 673;

						/*=============================================
						CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
						=============================================*/
						$aleatorio = mt_rand(100,9999);
						$directorio = "vistas/img/pagos/".$_POST["nuevoId"];
						mkdir($directorio, 0755);

						/*=============================================
						DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
						=============================================*/
						if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){
							/*=============================================
							GUARDAMOS LA IMAGEN EN EL DIRECTORIO
							=============================================*/
							$aleatorio = mt_rand(100,9999);
							$ruta = "vistas/img/pagos/".$_POST["nuevoId"]."/".$aleatorio.".jpg";
							$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagejpeg($destino, $ruta);
						}

						if($_FILES["nuevaFoto"]["type"] == "image/png"){
							/*=============================================
							GUARDAMOS LA IMAGEN EN EL DIRECTORIO
							=============================================*/
							$aleatorio = mt_rand(100,999);
							$ruta = "vistas/img/pagos/".$_POST["nuevoId"]."/".$aleatorio.".png";
							$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagepng($destino, $ruta);
						}
					}
				}

				$tabla1 = "notificaciones";
				$item1 = "id";
				$valor1 = 1;

				$respuesta1 = ControladorNotificacion::ctrMostrarNotificacion($tabla1, $item1, $valor1);

				$item2 = "nuevoReportePago";
				$valor2 = $respuesta1["nuevoReportePago"] + 1;

				$respuesta2 = ModeloNotificaciones::mdlActualizarNotificacion($tabla1, $item2, $valor2, $valor1);

				$datos = array("id_usuario"=> $_POST["nuevoId"],
							   "descripcion"=> $_POST["nuevaDescripcion"],
							   "valor"=> $_POST["nuevoPrecio"],
							   "carpeta" => $_POST["nuevoId"],
							   "foto"=> $ruta,
							   "estado"=> 1);

				$tabla = "reporte_pago";
				$respuesta = ModeloOrdenPago::mdlRegistroPago($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Orden de pago ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "reporte-pago";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de pago no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "reporte-pago";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de pago no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "reporte-pago";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR ORDEN PAGO
	=============================================*/
	static public function ctrMostrarPago ($item, $valor){
		$tabla = "reporte_pago";
		$respuesta = ModeloOrdenPago::mdlMostrarOrdenPago($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	REGISTRO DE ORDEN DE PAGO
	=============================================*/
	public function ctrEditarPago(){
		if(isset($_POST["editarNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				$estado = 1;
				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$carpeta = $_POST["editarCarpeta"];
				$ruta = $_POST["fotoActual"];
				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
					$nuevoAncho = 400;
					$nuevoAlto = 673;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					if($_POST["editarCarpeta"] == ""){
						$carpeta = $_POST["editarIdUsuario"];
						$directorio = "vistas/img/pagos/".$carpeta;
					}

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/
					if(!empty($_POST["fotoActual"])){
						unlink($_POST["fotoActual"]);
					}else{
						mkdir($directorio, 0755);
					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,9999);
						if($_POST["editarCarpeta"] != ""){
							$ruta = "vistas/img/pagos/".$_POST["editarCarpeta"]."/".$aleatorio.".jpg";
							$carpeta = $_POST["editarCarpeta"];
						}else{
							$ruta = "vistas/img/pagos/".$carpeta."/".$aleatorio.".jpg";							
						}
						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,9999);
						if($_POST["editarCarpeta"] != ""){
							$ruta = "vistas/img/pagos/".$_POST["editarCarpeta"]."/".$aleatorio.".png";
							$carpeta = $_POST["editarCarpeta"];
						}else{
							$ruta = "vistas/img/pagos/".$carpeta."/".$aleatorio.".png";
						}
						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}

				if($_SESSION["perfil"] == "Administrador"){
					$estado = 2;
				}

				$datos = array("id"=> $_POST["editarId"],
							   "id_usuario"=> $_POST["editarIdUsuario"],
							   "descripcion"=> $_POST["editarDescripcion"],
							   "valor"=> $_POST["editarPrecio"],
							   "carpeta" => $_POST["editarIdUsuario"],
							   "foto"=> $ruta,
							   "estado"=> $estado);

				$tabla = "reporte_pago";
				$respuesta = ModeloOrdenPago::mdlEditarPago($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Orden de pago ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "reporte-pago";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de pago no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "reporte-pago";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Orden de pago no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "reporte-pago";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	ELIMINAR PAGO
	=============================================*/
	static public function ctrBorrarPago(){
		if(isset($_GET["idOrden"])){

			$tabla = "reporte_pago";

			$item = "id";
			$valor = $_GET["idOrden"];

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloOrdenPago::mdlBorrarPago($tabla, $_GET["idOrden"]);

			if($respuesta == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "La orde ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
									window.location = "reporte-pago";
								}
							})
				</script>';

			}		
		}
	}
}