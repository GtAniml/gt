<?php

class ControladorLicencia{
	/*=============================================
	MOSTRAR LICENCIA
	=============================================*/
	static public function ctrMostrarLicencia($item, $valor){
		$tabla = "licencia";
		$respuesta = ModeloLicencia::mdlMostrarLicencia($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR ASOCIAR CUENTA
	=============================================*/
	public function ctrEditarLicencia(){
		if(isset($_POST["editarId"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarId"])){

				$datos = array("id"=> $_POST["editarId"],
							   "fecha"=> $_POST["editarFcorte"],
							   "ilimitado"=> $_POST["editarIlimitado"]);

				$tabla = "licencia";
				$respuesta = ModeloLicencia::mdlEditarLicencia($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Licencia ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "inicio";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Licencia no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "inicio";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La fecha no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "inicio";
							}
						});
					</script>';
			}
		}
	}
}