<?php

class ControladorRevendedor{
	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	public function ctrCuentaRevendedor(){
		if(isset($_POST["nuevoRevendedor"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevaAsocion"])){

				$fecha = date('Y-m-d');

				$aleatorio = mt_rand(1000,99999);

				$datos = array("id_cuenta"=> $_POST["nuevaAsocion"],
							   "fecha_corte"=> $_POST["nuevaFcorte"],
							   "fecha_termino"=> $_POST["nuevaFtermino"],
							   "precio"=> $_POST["nuevoPrecioC"],
							   "nombre_revendedor"=> $_POST["nuevoRevendedor"],
							   "codigo"=> $aleatorio,
							   "fecha"=>$fecha);

				$tabla = "revendedores";
				$respuesta = ModeloRevendedor::mdlRegistroRevendedor($tabla, $datos);

				$datos1 = array("id"=> $_POST["nuevaAsocion"],
							    "ocupada"=> 1);

				$tabla1 = "cuentas";
				$respuesta = ModeloCuentas::mdlEditarOcupada($tabla1, $datos1);

				$tabla2 = "revendedores_copia";
				$respuesta = ModeloRevendedor::mdlRegistroRevendedorC($tabla2, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La cuenta revendedor ha sido registrada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-revendedores";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La asociación no pudo ser registrada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-revendedores";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La asociación no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-revendedores";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CUENTAS DE REVENDEDOR
	=============================================*/
	static public function ctrMostrarRevendedor($item, $valor){
		$tabla = "revendedores";
		$respuesta = ModeloRevendedor::mdlMostrarRevendedor($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR CUENTAS DE REVENDEDOR COPIA
	=============================================*/
	static public function ctrMostrarRevendedorC($item, $valor){
		$tabla = "revendedores_copia";
		$respuesta = ModeloRevendedor::mdlMostrarRevendedor($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR ASOCIAR CUENTA
	=============================================*/
	public function ctrEditarRevendedor(){
		if(isset($_POST["editarRevendedor"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarAsociacion"])){

				if(isset($_POST["editarCliente"])){
					$dato = $_POST["editarCliente"];
				}else{
					$dato = $_POST["editarCliente"];
				}

				$datos = array("codigo"=> $_POST["editarCodigo"],
							   "id_cuenta"=> $_POST["editarAsociacion"],
							   "fecha_termino"=> $_POST["editarFtermino"],
							   "precio"=> $_POST["editarPrecioC"],
							   "nombre_revendedor"=> $_POST["editarRevendedor"],
							   "cliente"=> $dato);

				$tabla = "revendedores";
				$respuesta = ModeloRevendedor::mdlEditarRevendedor($tabla, $datos);

				$tabla = "revendedores_copia";
				$respuesta = ModeloRevendedor::mdlEditarRevendedorC($tabla, $datos);

				if($respuesta == "ok"){
					if($_SESSION["perfil"] == "Administrador"){
						echo '<script> 
							swal({
							  type: "success",
							  title: "La cuenta de Revendedor ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-revendedores";
								}
							})
						</script>';
					}else{
						echo '<script> 
							swal({
							  type: "success",
							  title: "La cuenta de Revendedor ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "inicio";
								}
							})
						</script>';
					}
					
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta de Revendedor no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-revendedores";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta de Revendedor no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-revendedores";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/
	static public function ctrRangoFechasCuentasRevendedor($fechaInicial, $fechaFinal){
		$tabla = "revendedores_copia";
		$respuesta = ModeloRevendedor::mdlRangoFechasCuentasRevendedor($tabla, $fechaInicial, $fechaFinal);
		return $respuesta;		
	}

	/*=============================================
	RENOVAR ASOCIAR CUENTA
	=============================================*/
	public function ctrRenovarRevendedor(){
		if(isset($_POST["renovarRevendedor"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["renovarAsociacion"])){

				$fecha = date('Y-m-d');

				$aleatorio = mt_rand(1000,99999);

				$datos = array("id"=> $_POST["renovarId"],
							   "id_cuenta"=> $_POST["renovarAsociacion"],
							   "fecha_corte"=> $_POST["renovarFcorte"],
							   "fecha_termino"=> $_POST["renovarFtermino"],
							   "precio"=> $_POST["renovarPrecioC"],
							   "codigo"=> $aleatorio,
							   "fecha"=>$fecha,
							   "nombre_revendedor"=> $_POST["renovarRevendedor"]);

				$tabla = "revendedores";
				$respuesta = ModeloRevendedor::mdlRenovarRevendedor($tabla, $datos);

				$tabla2 = "revendedores_copia";
				$respuesta = ModeloRevendedor::mdlRegistroRevendedorC($tabla2, $datos);

				$tabla1 = "cuentas";

				$item1 = "ocupada";
				$valor1 = 1;
				
				$item2 = "id";
				$valor2 = $_POST["renovarAsociacion"];

				$respuesta = ModeloCuentas::mdlRenovarOcupada($tabla1, $item1, $valor1, $item2, $valor2);

				$item2 = "password";
				$valor2 = $_POST["renovarContrasena"];
				
				$item3 = "id";
				$valor3 = $_POST["renovarAsociacion"];

				$respuesta = ModeloCuentas::mdlRenovarOcupada($tabla1, $item2, $valor2, $item3, $valor3);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La cuenta de Revendedor ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-revendedores";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta de Revendedor no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-revendedores";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta de Revendedor no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-revendedores";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	BORRAR CUENTA DE REVENDEDOR
	=============================================*/
	static public function ctrBorrarRevendedor(){
		if(isset($_GET["idRenovar"])){

			$tabla = "cuentas";
			$valor = $_GET["idCuenta"];

			$traerCuentas = ModeloCuentas::mdlMostrarCuentas($tabla, $item, $valor);

			$item1 = "ocupada";
			$valor1 = 0;

			$editarCuenta = ModeloCuentas::mdlActualizarCuentaC($tabla, $item1, $valor1, $valor);

			$tabla1 ="revendedores";
			$datos = $_GET["idRenovar"];

			$respuesta = ModeloRevendedor::mdlBorrarRevendedor($tabla1, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "La cuenta ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "cuenta-revendedores";
								}
							})
				</script>';
			}
		}
	}
}