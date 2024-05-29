<?php

class ControladorUsuarios{
	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/
	public function ctrRegistroUsuario(){
		if(isset($_POST["nuevoNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){

			   	/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$ruta = "";
				if($_FILES["nuevaFoto"]["tmp_name"] == ""){

				}else{
					if(isset($_FILES["nuevaFoto"]["tmp_name"])){
						
						list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

						$nuevoAncho = 500;
						$nuevoAlto = 500;

						/*=============================================
						CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
						=============================================*/
						$directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];
						mkdir($directorio, 0755);

						/*=============================================
						DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
						=============================================*/
						if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){
							/*=============================================
							GUARDAMOS LA IMAGEN EN EL DIRECTORIO
							=============================================*/
							$aleatorio = mt_rand(100,999);
							$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";
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
							$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";
							$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
							$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
							imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
							imagepng($destino, $ruta);
						}
					}
				}

				if($_POST["refId"] != 0){
					$venta = $_POST["refId"];
				}else{
					$venta = 0;
				}

			   	$encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
			   	$carpeta = $_POST["nuevoUsuario"];

				$datos = array("nombre"=> $_POST["nuevoNombre"],
							   "usuario"=> $_POST["nuevoUsuario"],
							   "carpeta"=> $carpeta,
							   "password"=> $encriptar,	
							   "email"=> $_POST["nuevoEmail"],						   
							   "perfil"=> $_POST["nuevoPerfil"],
							   "telefono"=> $_POST["nuevoTelefono"],
							   "ref_id"=> $venta,
							   "foto"=> $ruta,
							   "estado"=> 1);

				$tabla = "usuarios";
				$respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "El usuario ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "usuarios";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "usuarios";
							}
						});
				</script>';
				}
			}
		}
	}

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/
	static public function ctrMostrarUsuario($item, $valor){
		$tabla = "usuarios";
		$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/
	public function ctrIngresoUsuario(){
		if(isset($_POST["ingUsuario"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

				date_default_timezone_set('America/Bogota');
			   	$fecha = date('Y-m-d');

				$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "usuarios";
				$item = "usuario";
				$valor = $_POST["ingUsuario"];

				$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

				$tabla1 = "licencia";
				$item1 = "id";
				$valor1 = 1;

				$Licencia = ModeloLicencia::mdlMostrarLicencia($tabla1, $item1, $valor1);

				if($fecha <= $Licencia["fecha"] or $Licencia["ilimitado"] == 1){
					if($respuesta["usuario"] == $_POST["ingUsuario"] && $respuesta["password"] == $encriptar){

						if($respuesta["estado"] != 0){
							$_SESSION["iniciarSesion"] = "ok";
							$_SESSION["id"] = $respuesta["id"];
							$_SESSION["nombre"] = $respuesta["nombre"];
							$_SESSION["usuario"] = $respuesta["usuario"];
							$_SESSION["perfil"] = $respuesta["perfil"];
							$_SESSION["telefono"] = $respuesta["telefono"];
							$_SESSION["foto"] = $respuesta["foto"];
							$_SESSION["refId"] = $respuesta["ref_id"];
							$_SESSION["estado"] = $respuesta["estado"];

							echo '<script>							
								window.location = "inicio"
							</script>';

						}else{
								echo'<script>
								swal({
									  title: "¡SU CUENTA NO HA SIDO ACTIVADA!",
									  text: "¡Por favor comuniquese con un administrador para dar solución a su problema.!",
									  type: "error",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
								},

								function(isConfirm){
										 if (isConfirm) {	   
										    history.back();
										  } 
								});
								</script>';
						}
					}else{
						echo'<script>
								swal({
									  title: "¡ERROR AL INGRESAR!",
									  text: "¡Por favor revise que el usuario exista o la contraseña coincida con la registrada!",
									  type: "error",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
								},
								function(isConfirm){
										 if (isConfirm) {	   
										    window.location = login;
										  } 
								});
								</script>';

					}
				}else{
					echo '<script> 
							swal({
								type: "error",
								title: "¡Su licencia a terminado contactate con el administrador!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then(function(result){
								if(result.value){							
									window.location = "login";
								}
							});
						</script>';					
				}	
			}else{
				echo '<script> 
						swal({
							  title: "¡ERROR!",
							  text: "¡Error al ingresar al sistema, no se permiten caracteres especiales!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},
							function(isConfirm){
								if(isConfirm){
									history.back();
								}
						});
				</script>';
			}
		}
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/
	static public function ctrEditarUsuario(){
		if(isset($_POST["editarUsuario"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$carpeta = $_POST["editarCarpeta"];
				$ruta = $_POST["fotoActual"];
				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					if($_POST["editarCarpeta"] == ""){
						$carpeta = mt_rand(100,9999);
						$directorio = "vistas/img/usuarios/".$carpeta;
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
						$aleatorio = mt_rand(100,999);
						if($_POST["editarCarpeta"] != ""){
							$ruta = "vistas/img/usuarios/".$_POST["editarCarpeta"]."/".$aleatorio.".jpg";
							$carpeta = $_POST["editarCarpeta"];
						}else{
							$ruta = "vistas/img/usuarios/".$carpeta."/".$aleatorio.".jpg";							
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
							$ruta = "vistas/img/usuarios/".$_POST["editarCarpeta"]."/".$aleatorio.".png";
							$carpeta = $_POST["editarCarpeta"];
						}else{
							$ruta = "vistas/img/usuarios/".$carpeta."/".$aleatorio.".png";
						}
						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}

				$tabla = "usuarios";

				if($_POST["editarPassword"] != ""){
					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){
						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					}else{
						echo'<script>
								swal({
								  type: "error",
								  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result) {
									if (result.value) {

									window.location = "usuarios";

									}
								})
						  	</script>';

						  	return;
					}
				}else{
					$encriptar = $_POST["passwordActual"];
				}

				$datos = array("id" => $_POST["editarId"],
							   "nombre" => $_POST["editarNombre"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encriptar,
							   "email" => $_POST["editarEmail"],
							   "telefono" => $_POST["editarTelefono"],
							   "perfil" => $_POST["editarPerfil"],
							   "foto" => $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
								if (result.value) {
									window.location = "usuarios";
								}
							})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {
								window.location = "usuarios";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/
	static public function ctrBorrarUsuario(){
		if(isset($_GET["idUsuario"])){
			$tabla ="usuarios";
			$datos = $_GET["idUsuario"];

			if($_GET["fotoUsuario"] != ""){
				unlink($_GET["fotoUsuario"]);
				rmdir('vistas/img/usuarios/'.$_GET["usuario"]);
			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "usuarios";
								}
							})
				</script>';
			}
		}
	}
}