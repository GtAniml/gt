<?php

class ControladorStreaming{
	/*=============================================
	REGISTRO DE STREAMING
	=============================================*/
	public function ctrRegistroStreaming(){
		if(isset($_POST["nuevoNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])){

				$datos = array("nombre"=> $_POST["nuevoNombre"],
							   "pantallas"=> $_POST["nuevaCantidad"],
							   "iptv"=> $_POST["nuevoIptv"],
							   "estado"=> 1);

				$tabla = "categorias";
				$respuesta = ModeloStreaming::mdlRegistroStreaming($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La categoria ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "categorias";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La categoria no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "categorias";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La categoria no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "categorias";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR STREAMING
	=============================================*/
	static public function ctrMostrarStreaming($item, $valor){
		$tabla = "categorias";
		$respuesta = ModeloStreaming::mdlMostrarStreaming($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR STREAMING
	=============================================*/
	static public function ctrEditarStreaming(){
		if(isset($_POST["editarNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				$tabla = "categorias";
				$datos = array("id" => $_POST["editarId"],
							   "nombre" => $_POST["editarNombre"],
							   "pantallas" => $_POST["editarCantidad"],
							   "iptv"=> $_POST["editarIptv"]);

				$respuesta = ModeloStreaming::mdlEditarStreaming($tabla, $datos);

				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Streaming ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
								if (result.value) {
									window.location = "categorias";
								}
							})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El Streaming no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {
								window.location = "categorias";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR STREAMING
	=============================================*/
	static public function ctrBorrarStreaming(){
		if(isset($_GET["idCategoria"])){
			$tabla ="categorias";
			$datos = $_GET["idCategoria"];

			$respuesta = ModeloStreaming::mdlBorrarStreaming($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El streaming ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "categorias";
								}
							})
				</script>';
			}
		}
	}
}