<?php

class ControladorPantalla{
	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	public function ctrAsociarPantalla(){
		if(isset($_POST["nuevaAsocion"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevaAsocion"])){

				$fecha = date('Y-m-d');

				if($_POST["opc"] == 1){
					$cliente = $_POST["nuevaCliente"];
				}else if($_POST["opc"] == 0){
					$cliente = $_POST["nuevaClienteR"];
				}else if($_POST["opc"] == 2){
					$cliente = $_POST["nuevaClienteM"];
				}

				$aleatorio = mt_rand(1000,99999);

				if($_POST["nuevaId"]){
					$nueva = $_POST["nuevaId"];
				}else{
					$nueva = 0;
				}

				$datos = array("id_cuenta"=> $_POST["nuevaAsocion"],
							   "cliente"=> $cliente,
							   "pantalla"=> $_POST["nuevaNombrePantalla"],
							   "pass"=> $_POST["nuevoPasswordP"],
							   "fecha_corte"=> $_POST["nuevaFcorte"],
							   "fecha_termino"=> $_POST["nuevaFtermino"],
							   "telefono"=> $_POST["nuevoNumero"],
							   "costo"=> $_POST["nuevoPrecioC"],
							   "renovo_cuenta"=> $aleatorio,
							   "mac"=> $_POST["nuevaMac"],
							   "llave"=> $_POST["nuevaKey"],
							   "reproductor"=> $_POST["nuevaReproductor"],
							   "estado"=> 1,
							   "renovo_regresa"=> 1,
							   "ref_id"=> $nueva,
							   "fecha" => $fecha);	   

				$tabla = "cuenta_pantalla";
				$respuesta = ModeloPantalla::mdlRegistroPantalla($tabla, $datos);

				$tabla1 = "cuentas";
				$datos1 = array("id"=> $_POST["nuevaAsocion"],
							    "pantallas"=> $_POST["nuevaPantallas"]);

				$respuesta = ModeloCuentas::mdlEditarPantalla($tabla1, $datos1);

				$tabla2 = "cuenta_pantalla_replica";
				$respuesta = ModeloPantalla::mdlRegistroPantallaC($tabla2, $datos);
				

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La asociación ha sido registrada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-pantalla";
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
								window.location = "cuenta-pantalla";
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
								window.location = "cuenta-pantalla";
							}
						});
					</script>';
			}
		}
	}
	/*=============================================
	MOSTRAR CUENTAS PANTALLAS
	=============================================*/
	static public function ctrMostrarPantalla($item, $valor){
		$tabla = "cuenta_pantalla";
		$respuesta = ModeloPantalla::mdlMostrarPantalla($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR CUENTAS PANTALLAS
	=============================================*/
	static public function ctrMostrarPantallasN($item, $valor, $item1, $valor1){
		$tabla = "cuenta_pantalla";
		$respuesta = ModeloPantalla::mdlMostrarPantallasN($tabla, $item, $valor, $item1, $valor1);
		return $respuesta;
	}

	/*=============================================
	EDITAR ASOCIAR CUENTA
	=============================================*/
	public function ctrEditarPantalla(){
		if(isset($_POST["editarCliente"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarAsociacion"])){

				if(isset($_POST["editarClienteReven"])){
					$dato = $_POST["editarClienteReven"];
				}else{
					$dato = $_POST["editarClienteReven"];
				}

				if($_POST["editarMac"] != ""){
					$mac = $_POST["editarMac"];
				}else{
					$mac = 0;
				}

				if($_POST["editarKey"] != ""){
					$llave = $_POST["editarKey"];
				}else{
					$llave = 0;
				}

				if($_POST["editarReproductor"] != ""){
					$reproductor = $_POST["editarReproductor"];
				}else{
					$reproductor = 0;
				}

				$datos = array("renovo_cuenta"=> $_POST["editarCodigoSecret"],
							   "id_cuenta"=> $_POST["editarAsociacion"],
							   "fecha_corte"=> $_POST["editarFcorte"],
							   "fecha_termino"=> $_POST["editarFtermino"],
							   "costo"=> $_POST["editarPrecioC"],
							   "cliente"=> $_POST["editarCliente"],
							   "pantalla"=> $_POST["editarNombrePantalla"],
							   "pass"=> $_POST["editarPasswordP"],
							   "clienteRevendedor"=> $dato,
							   "mac"=> $mac,
							   "llave"=> $llave,
							   "reproductor"=> $reproductor,
							   "telefono"=> $_POST["editarNumero"]);

				if($_POST["editarComparar"] == $_POST["editarAsociacion"]){
					$tabla = "cuenta_pantalla";
					$respuesta = ModeloPantalla::mdlEditarPantalla($tabla, $datos);

					$tabla1 = "cuenta_pantalla_replica";
					$respuesta = ModeloPantalla::mdlEditarPantalla($tabla1, $datos);
				}else{
					$tabla = "cuenta_pantalla";
					$respuesta = ModeloPantalla::mdlEditarPantalla($tabla, $datos);

					$tabla1 = "cuenta_pantalla_replica";
					$respuesta = ModeloPantalla::mdlEditarPantalla($tabla1, $datos);

					$tabla2 = "cuentas";

					$item2 = "id";
					$valor2 = $_POST["editarComparar"];

					$traerCuentas = ModeloCuentas::mdlMostrarCuentas($tabla2, $item2, $valor2);

					$item5 = "id";
					$valor5 = $_POST["editarAsociacion"];

					$traerCuentas1 = ModeloCuentas::mdlMostrarCuentas($tabla2, $item5, $valor5);

					$item3 = "pantallas";
					$valor3 = $traerCuentas["pantallas"] + 1;

					$editarCuenta = ModeloCuentas::mdlActualizarCuentaC($tabla2, $item3, $valor3, $valor2);

					$valor4 = $traerCuentas1["pantallas"] - 1;

					$editarCuenta = ModeloCuentas::mdlActualizarCuentaC($tabla2, $item3, $valor4, $valor5);
				}
				
				if($respuesta == "ok"){
					if($_SESSION["perfil"] == "Administrador"){
						echo '<script> 
							swal({
							  type: "success",
							  title: "La Pantalla ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-pantalla";
								}
							})
						</script>';
					}else{
						echo '<script> 
							swal({
							  type: "success",
							  title: "La Pantalla ha sido editada correctamente",
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
							title: "¡La Pantalla no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-pantalla";
							}
						});
					</script>';
				}
				
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Pantalla no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-pantalla";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	EDITAR ASOCIAR CUENTA
	=============================================*/
	public function ctrRenovarPantalla(){
		if(isset($_POST["editarClienteR"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarAsociacionR"])){

				if($_POST["editarMacR"] != ""){
					$mac = $_POST["editarMacR"];
				}else{
					$mac = 0;
				}

				if($_POST["editarKeyR"] != ""){
					$llave = $_POST["editarKeyR"];
				}else{
					$llave = 0;
				}

				if($_POST["editarReproductorR"] != ""){
					$reproductor = $_POST["editarReproductorR"];
				}else{
					$reproductor = 0;
				}

				$fecha = date('Y-m-d');

				$aleatorio = mt_rand(1000,99999);

				$datos = array("id"=> $_POST["renovarId"],
							   "id_cuenta"=> $_POST["editarAsociacionR"],
							   "fecha_corte"=> $_POST["editarFcorteR"],
							   "fecha_termino"=> $_POST["editarFterminoR"],
							   "costo"=> $_POST["editarPrecioCR"],
							   "cliente"=> $_POST["editarClienteR"],
							   "pantalla"=> $_POST["editarNombrePantallaR"],
							   "pass"=> $_POST["editarPasswordPR"],
							   "telefono"=> $_POST["editarNumeroR"],
							   "renovo_cuenta"=> $aleatorio,
							   "estado"=> 1,
							   "renovo_regresa"=> 1,
							   "mac"=> $mac,
							   "llave"=> $llave,
							   "reproductor"=> $reproductor,
							   "fecha" => $fecha);

				$tabla = "cuenta_pantalla_replica";
				$respuesta = ModeloPantalla::mdlRegistroPantallaC($tabla, $datos);

				$tabla1 = "cuenta_pantalla";
				$respuesta = ModeloPantalla::mdlRenovarPantalla($tabla1, $datos);

				//$tabla2 = "cuentas";
				//$datos2 = array("id"=> $_POST["editarAsociacionR"],
							    //"pantallas"=> $_POST["nuevaPantallasR"]);

				//$respuesta = ModeloCuentas::mdlEditarPantalla($tabla2, $datos2);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Pantalla ha sido Renovada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-pantalla";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Pantalla no pudo ser Renovada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-pantalla";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Pantalla no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-pantalla";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/
	static public function ctrRangoFechasCuentasPantallas($fechaInicial, $fechaFinal){
		$tabla = "cuenta_pantalla_replica";
		$respuesta = ModeloPantalla::mdlRangoFechasCuentasPantallas($tabla, $fechaInicial, $fechaFinal);
		return $respuesta;		
	}

	/*=============================================
	BORRAR PANTALLA
	=============================================*/
	static public function ctrBorrarPantalla(){
		if(isset($_GET["idPantalla"])){
			$tabla = "cuentas";

			$item = "id";
			$valor = $_GET["idCuenta"];

			$traerCuentas = ModeloCuentas::mdlMostrarCuentas($tabla, $item, $valor);

			$item1 = "pantallas";
			$valor1 = $traerCuentas["pantallas"] + 1;

			$editarCuenta = ModeloCuentas::mdlActualizarCuentaC($tabla, $item1, $valor1, $valor);

			$tabla1 ="cuenta_pantalla";
			$datos = $_GET["idPantalla"];

			$respuesta = ModeloPantalla::mdlBorrarPantalla($tabla1, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "La pantalla ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "cuenta-pantalla";
								}
							})
				</script>';
			}
		}
	}
}