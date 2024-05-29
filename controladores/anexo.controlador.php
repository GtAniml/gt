<?php

class ControladorAnexos{
	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	public function ctrNuevoAnexo(){
		if(isset($_POST["nuevotCuenta"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevotCuenta"])){

				$datos = array("tipo_cuenta"=> $_POST["nuevotCuenta"],
							   "recordatorio"=> $_POST["nuevoAnexo"],
							   "estado"=> 1);

				$tabla = "anexo";
				$respuesta = ModeloAnexos::mdlRegistroAnexo($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "El Anexo ha sido registrado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "anexos";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El anexo no pudo ser registrado por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "anexos";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡El anexo no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "anexos";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR ANEXO
	=============================================*/
	static public function ctrMostrarAnexo($item, $valor){
		$tabla = "anexo";
		$respuesta = ModeloAnexos::mdlMostrarAnexos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR ANEXO
	=============================================*/
	public function ctrEditarAnexo(){
		if(isset($_POST["editartCuenta"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editartCuenta"])){

				$datos = array("tipo_cuenta"=> $_POST["editartCuenta"],
							   "id"=> $_POST["editarId"],
							   "recordatorio"=> $_POST["editarAnexo"]);

				$tabla = "anexo";
				$respuesta = ModeloAnexos::mdlEditarAnexo($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "El Anexo ha sido editar correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "anexos";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El anexo no pudo ser editado por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "anexos";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡El anexo no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "anexos";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	BORRAR ANEXO
	=============================================*/
	static public function ctrBorrarAnexo(){
		if(isset($_GET["idAnexo"])){
			$tabla ="anexo";
			$datos = $_GET["idAnexo"];

			$respuesta = ModeloAnexos::mdlBorrarAnexo($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El anexo ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "anexos";
								}
							})
				</script>';
			}
		}
	}
}