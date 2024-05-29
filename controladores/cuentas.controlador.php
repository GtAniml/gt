<?php

class ControladorCuentas{
	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	public function ctrRegistroCuenta(){
		if(isset($_POST["nuevoCostoPin"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoTipoCuentaP"])){

				$fecha = date('Y-m-d');

				$aleatorio = mt_rand(1000,99999);

				if ($_POST["nuevaFcorte"] != "") {
					$lafecha = $_POST["nuevaFcorte"];
				}else{
					$lafecha = "0000-00-00";
				}

				if ($_POST["editarIptv"] == "0") {
					$pin = $_POST["nuevoPinEs"];
				}else{
					$pin = $_POST["nuevoPinSe"];
				}


				$datos = array("id_categoria"=> $_POST["nuevoTipoCuenta"],
							   "modo_cuenta"=> $_POST["nuevoTipoCuentaP"],
							   "correo"=> trim($_POST["nuevoEmail"]),
							   "password"=> trim($_POST["nuevoPassword"]),
							   "pin"=> trim($pin),
							   "valor_pin"=> trim($_POST["nuevoCostoPin"]),
							   "codigo"=> $aleatorio,
							   "activacion"=> $_POST["nuevaFactivacion"],
							   "facturacion"=> $_POST["nuevaFacturacion"],
							   "corte"=> $lafecha,
							   "pantallas"=> $_POST["nuevaPantallas"],
							   "estado"=> 1,
							   "fecha_creado"=> $fecha);

				$tabla = "cuentas";
				$respuesta = ModeloCuentas::mdlRegistroCuentas($tabla, $datos);

				$tabla1 = "cuentas_registro";
				$respuesta = ModeloCuentas::mdlRegistroCuentasR($tabla1, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La cuenta ha sido registrada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuentas";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta no pudo ser registrada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuentas";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuentas";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CUENTAS
	=============================================*/
	static public function ctrMostrarCuentas($item, $valor){
		$tabla = "cuentas";
		$respuesta = ModeloCuentas::mdlMostrarCuentas($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR CUENTAS
	=============================================*/
	static public function ctrMostrarCuentasFull($item, $valor, $orden){
		$tabla = "cuentas";
		$respuesta = ModeloCuentas::mdlMostrarCuentasFull($tabla, $item, $valor, $orden);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR CUENTAS R
	=============================================*/
	static public function ctrMostrarCuentasR($item, $valor){
		$tabla = "cuentas_registro";
		$respuesta = ModeloCuentas::mdlMostrarCuentasR($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	public function ctrEditarCuenta(){
		if(isset($_POST["editarCostoPin"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarTipoCuentaP"])){

				if($_POST["editarPassword"] != ""){
					$contrasena = $_POST["editarPassword"];
				}else{
					$contrasena = $_POST["passwordActual"];
				}

				if ($_POST["editarIptv"] == "0") {
					$pin = $_POST["editarPinEs"];
				}else{
					$pin = $_POST["editarPinSe"];
				}

				$datos = array("id_categoria"=> $_POST["editarTipoCuenta"],
							   "modo_cuenta"=> $_POST["editarTipoCuentaP"],
							   "correo"=> trim($_POST["editarEmail"]),
							   "password"=> trim($contrasena),
							   "pin"=> trim($pin),
							   "valor_pin"=> trim($_POST["editarCostoPin"]),
							   "codigo"=> $_POST["editarCodigo"],
							   "activacion"=> $_POST["editarFactivacion"],
							   "facturacion"=> $_POST["editarFacturacion"],
							   "corte"=> $_POST["editarFcorte"],
							   "ocupada"=> $_POST["editarEstadoCuentaP"],
							   "pantallas"=> $_POST["editarPantallas"]);

				$tabla = "cuentas";
				$respuesta = ModeloCuentas::mdlEditarCuentas($tabla, $datos);

				//$tabla1 = "cuentas_respaldo";
				//$respuesta = ModeloCuentas::mdlEditarCuentas($tabla1, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La cuenta ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuentas";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuentas";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuentas";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	RENOVAR CUENTAS
	=============================================*/
	public function ctrRenovarCuenta(){
		if(isset($_POST["renovarCostoPin"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["renovarTipoCuenta"])){

				$aleatorio = mt_rand(1000,99999);

				if($_POST["renovarPassword"] != ""){
					$contrasena = $_POST["renovarPassword"];
				}else{
					$contrasena = $_POST["passwordActualR"];
				}

				if ($_POST["renovarIptv"] == "0") {
					$pin = $_POST["renovarPinEs"];
				}else{
					$pin = $_POST["renovarPinSe"];
				}

				$datos = array("id_categoria"=> $_POST["renovarTipoCuenta"],
							   "modo_cuenta"=> $_POST["renovarTipoCuentaP"],
							   "correo"=> $_POST["renovarEmail"],
							   "password"=> $contrasena,
							   "pin"=> trim($pin),
							   "valor_pin"=> $_POST["renovarCostoPin"],
							   "codigo"=> $_POST["renovarCodigo"],
							   "codigo1"=> $aleatorio,
							   "activacion"=> $_POST["renovarFactivacion"],
							   "facturacion"=> $_POST["renovarFacturacion"],
							   "corte"=> $_POST["renovarFcorte"],
							   "pantallas"=> $_POST["renovarPantallas"],
							   "estado" => 1);

				$tabla = "cuentas";
				$respuesta = ModeloCuentas::mdlEditarCuentasR($tabla, $datos);

				$tabla1 = "cuentas_registro";
				$respuesta = ModeloCuentas::mdlRegistroCuentasR($tabla1, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La cuenta ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuentas";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuentas";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La cuenta no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuentas";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CUENTAS RESPALDO
	=============================================*/
	static public function ctrMostrarCuentasRegistro($item, $valor){
		$tabla = "cuentas_registro";
		$respuesta = ModeloCuentas::mdlMostrarCuentasRegistro($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	BORRAR CUENTA
	=============================================*/
	static public function ctrBorrarCuenta(){
		if(isset($_GET["idCuenta"])){
			$tabla ="cuentas";

			$item2 = "id";
			$valor2 = $_GET["idCuenta"];

			$item1 = "desactivado";
			$valor1 = $_GET["estadoCuenta"];

			$respuesta = ModeloCuentas::mdlActualizarCuentaPC($tabla, $item1, $valor1, $item2, $valor2);

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
								window.location = "cuentas";
								}
							})
				</script>';
			}
		}
	}

	#LISTAR TODOS LOS REGISTROS SOLICITADOS POR EL CLIENTE.
	#-----------------------------------------------------------
	static public function allValoresControlador($tabla,$where,$orderBy){
		$respuesta = ModeloCuentas::allValoresModelo($tabla,$where,$orderBy);
		return $respuesta;
	}
}