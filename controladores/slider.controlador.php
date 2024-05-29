<?php

class ControladorSlider{
	/*=============================================
	REGISTRO DE SLIDER
	=============================================*/
	public function ctrRegistroSlider(){
		if(isset($_POST["nuevoNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$ruta = "";
				$aleatorio = mt_rand(100,999);
				if($_FILES["nuevaFoto"]["tmp_name"] == ""){

				}else{
					if(isset($_FILES["nuevaFoto"]["tmp_name"])){
						
						list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

						$nuevoAncho = 1600;
						$nuevoAlto = 600;

						/*=============================================
						CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
						=============================================*/
						$aleatorio1 = mt_rand(100,999);
						$directorio = "vistas/img/slider/".$aleatorio;
						mkdir($directorio, 0755);

						/*=============================================
						DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
						=============================================*/
						if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){
							/*=============================================
							GUARDAMOS LA IMAGEN EN EL DIRECTORIO
							=============================================*/
							$ruta = "vistas/img/slider/".$aleatorio."/".$aleatorio1.".jpg";
							$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagejpeg($destino, $ruta);
						}

						if($_FILES["nuevaFoto"]["type"] == "image/png"){
							/*=============================================
							GUARDAMOS LA IMAGEN EN EL DIRECTORIO
							=============================================*/
							$ruta = "vistas/img/slider/".$aleatorio."/".$aleatorio1.".png";
							$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagepng($destino, $ruta);
						}
					}
				}

				$datos = array("nombre"=> $_POST["nuevoNombre"],
							   "foto"=> $ruta,
							   "carpeta"=> $aleatorio,
							   "estado"=> 1);

				$tabla = "slider";
				$respuesta = ModeloSlider::mdlRegistroSlider($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "El Slider ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "banner";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El Slider no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "banner";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡El Slider no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "banner";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR SLIDER
	=============================================*/
	static public function ctrMostrarSlider($item, $valor){
		$tabla = "slider";
		$respuesta = ModeloSlider::mdlMostrarSlider($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR SLIDER
	=============================================*/
	public function ctrModificarSlider(){
		if(isset($_POST["editarNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$carpeta = $_POST["editarCarpeta"];
				$ruta = $_POST["fotoActual"];
				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
					$nuevoAncho = 1600;
					$nuevoAlto = 600;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					if($_POST["editarCarpeta"] == ""){
						$carpeta = mt_rand(100,9999);
						$directorio = "vistas/img/slider/".$carpeta;
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
							$ruta = "vistas/img/slider/".$_POST["editarCarpeta"]."/".$aleatorio.".jpg";
							$carpeta = $_POST["editarCarpeta"];
						}else{
							$ruta = "vistas/img/slider/".$carpeta."/".$aleatorio.".jpg";							
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
							$ruta = "vistas/img/slider/".$_POST["editarCarpeta"]."/".$aleatorio.".png";
							$carpeta = $_POST["editarCarpeta"];
						}else{
							$ruta = "vistas/img/slider/".$carpeta."/".$aleatorio.".png";
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
							   "nombre"=> $_POST["editarNombre"],
							   "foto" => $ruta,
							   "carpeta" => $_POST["editarCarpeta"]);

				$tabla = "slider";
				$respuesta = ModeloSlider::mdlEditarSlider($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "El slider ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "banner";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El slider de pago no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "banner";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡El slider no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "banner";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	BORRAR SLIDER
	=============================================*/
	static public function ctrBorrarSlider(){
		if(isset($_GET["idSlider"])){
			$tabla ="slider";
			$datos = $_GET["idSlider"];

			if($_GET["fotoSlider"] != ""){
				unlink($_GET["fotoSlider"]);
				rmdir('vistas/img/slider/'.$_GET["carpeta"]);
			}

			$respuesta = ModeloSlider::mdlBorrarSlider($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El slider ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "banner";
								}
							})
				</script>';
			}
		}
	}
}