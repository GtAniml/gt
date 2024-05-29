<?php

class ControladorWhatsapp{
	/*=============================================
	REGISTRO DE WHATSAPP
	=============================================*/
	public function ctrNuevoWhatsapp(){
		if(isset($_POST["nuevoMensaje"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevaCuentaWhatsapp"])){

				$datos = array("cuenta"=> $_POST["nuevaCuentaWhatsapp"],
							   "mensaje"=> $_POST["nuevoMensaje"],
							   "estado" => 1);

				$tabla = "whatsapp";
				$respuesta = ModeloWhatsapp::mdlRegistroWhatsapp($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "El Mensaje ha sido registrado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "whatsapp";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El Mensaje no pudo ser registrado por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "whatsapp";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡El Mensaje no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "whatsapp";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR WHATSAPP
	=============================================*/
	static public function ctrMostrarWhatsapp($item, $valor){
		$tabla = "whatsapp";
		$respuesta = ModeloWhatsapp::mdlMostrarWhatsapp($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR MENSAJE DE WHATSAPP
	=============================================*/
	public function ctrEditarWhatsapp(){
		if(isset($_POST["editarMensaje"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarCuentaWhatsapp"])){

				$datos = array("id" => $_POST["editarId"],
							   "cuenta"=> $_POST["editarCuentaWhatsapp"],
							   "mensaje"=> $_POST["editarMensaje"]);

				$tabla = "whatsapp";
				$respuesta = ModeloWhatsapp::mdlEditarWhatsapp($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "El Mensaje ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "whatsapp";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El Mensaje no pudo ser editado por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "whatsapp";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡El Mensaje no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "whatsapp";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	BORRAR WHATSAPP
	=============================================*/
	static public function ctrBorrarWhatsapp(){
		if(isset($_GET["idWhatsapp"])){
			$tabla ="whatsapp";
			$datos = $_GET["idWhatsapp"];

			$respuesta = ModeloWhatsapp::mdlBorrarWhatsapp($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El mensaje ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "whatsapp";
								}
							})
				</script>';
			}
		}
	}
}