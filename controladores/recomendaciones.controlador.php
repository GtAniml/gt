<?php

class ControladorRecomendaciones{
	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	public function ctrNuevaRecomendacion(){
		if(isset($_POST["nuevotCuenta"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevotCuenta"])){

				$datos = array("tipo_cuenta"=> $_POST["nuevotCuenta"],
							   "recordatorio"=> $_POST["nuevoAnexo"],
							   "estado"=> 1);

				$tabla = "recomendaciones";
				$respuesta = ModeloRecomendaciones::mdlRegistroRecomendacion($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La recomendación ha sido registrado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "recomendaciones";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La recomendación no pudo ser registrado por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "recomendaciones";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La recomendación no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "recomendaciones";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR ANEXO
	=============================================*/
	static public function ctrMostrarRecomendacion($item, $valor){
		$tabla = "recomendaciones";
		$respuesta = ModeloRecomendaciones::mdlMostrarRecomendaciones($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR ANEXO
	=============================================*/
	public function ctrEditarRecomendacion(){
		if(isset($_POST["editartCuenta"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editartCuenta"])){

				$datos = array("tipo_cuenta"=> $_POST["editartCuenta"],
							   "id"=> $_POST["editarId"],
							   "recordatorio"=> $_POST["editarAnexo"]);

				$tabla = "recomendaciones";
				$respuesta = ModeloRecomendaciones::mdlEditarRecomendacion($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La recomendación ha sido editar correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "recomendaciones";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La recomendación no pudo ser editado por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "recomendaciones";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La recomendación no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "recomendaciones";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	BORRAR ANEXO
	=============================================*/
	static public function ctrBorrarRecomendacion(){
		if(isset($_GET["idRecomendacion"])){
			$tabla ="recomendaciones";
			$datos = $_GET["idRecomendacion"];

			$respuesta = ModeloRecomendaciones::mdlBorrarRecomendacion($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "La recomendación ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "recomendaciones";
								}
							})
				</script>';
			}
		}
	}
}