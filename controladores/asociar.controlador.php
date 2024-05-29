<?php

class ControladorAsociar{ 
	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	public function ctrAsociarCuenta(){
		if(isset($_POST["nuevaCliente"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevaAsocion"])){

				if($_POST["opc"] == 1){
					$cliente = $_POST["nuevaCliente"];
				}else if($_POST["opc"] == 0){
					$cliente = $_POST["nuevaClienteR"];
				}				
				
				$fecha = date('Y-m-d');

				$aleatorio = mt_rand(1000,99999);

				if($_POST["nuevaId"]){
					$nueva = $_POST["nuevaId"];
				}else{
					$nueva = 0;
				}

				$datos = array("id_cuenta"=> $_POST["nuevaAsocion"],
							   "fecha_corte"=> $_POST["nuevaFcorte"],
							   "fecha_termino"=> $_POST["nuevaFtermino"],
							   "precio"=> $_POST["nuevoPrecioC"],
							   "nombre_cliente"=> $cliente,
							   "telefono"=> $_POST["nuevoNumero"],
							   "codigo"=> $aleatorio,
							   "iptv"=> $_POST["listaIptv"],
							   "ref_id"=> $nueva,
							   "fecha"=> $fecha);

				$tabla = "cuenta_completa";
				$respuesta = ModeloAsociar::mdlRegistroAsociacion($tabla, $datos);

				$tabla2 = "cuenta_completa_copia";
				$respuesta = ModeloAsociar::mdlRegistroAsociacionC($tabla2, $datos);

				$datos1 = array("id"=> $_POST["nuevaAsocion"],
							    "ocupada"=> 1);

				$tabla1 = "cuentas";
				$respuesta = ModeloCuentas::mdlEditarOcupada($tabla1, $datos1);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La asociación ha sido registrada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-completa";
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
								window.location = "cuenta-completa";
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
								window.location = "cuenta-completa";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR CUENTAS ASOCIADAS
	=============================================*/
	static public function ctrMostrarAsociar($item, $valor){
		$tabla = "cuenta_completa";
		$respuesta = ModeloAsociar::mdlMostrarAsociar($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR CUENTAS ASOCIADAS PARA INICIO
	=============================================*/
	static public function ctrMostrarAsociarInicio($item, $valor){
		$tabla = "cuenta_completa";
		$respuesta = ModeloAsociar::mdlMostrarAsociarCuentaCompleta($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR ASOCIAR CUENTA
	=============================================*/
	public function ctrEditarAsociar(){
		if(isset($_POST["editarCliente"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarId"])){

				$datos = array("id"=> $_POST["editarId"],
							   "id_cuenta"=> $_POST["editarAsociacion"],
							   "fecha_termino"=> $_POST["editarFtermino"],
							   "precio"=> $_POST["editarPrecioC"],
							   "nombre_cliente"=> $_POST["editarCliente"],
							   "codigo"=> $_POST["editarCodigo"],
							   "telefono"=> $_POST["editarNumero"]);

				$tabla = "cuenta_completa";
				$respuesta = ModeloAsociar::mdlEditarAsociacion($tabla, $datos);

				$tabla1 = "cuenta_completa_copia";
				$respuesta1 = ModeloAsociar::mdlEditarAsociacionC($tabla1, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Asociación ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-completa";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/
	static public function ctrRangoFechasCuentasCompletas($fechaInicial, $fechaFinal){
		$tabla = "cuenta_completa_copia";
		$respuesta = ModeloAsociar::mdlRangoFechasCuentasCompletas($tabla, $fechaInicial, $fechaFinal);
		return $respuesta;		
	}

	/*=============================================
	RENOVAR ASOCIAR CUENTA
	=============================================*/
	public function ctrRenovarAsociar(){
		if(isset($_POST["renovarCliente"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["renovarAsociacion"])){

				$fecha = date('Y-m-d');

				$aleatorio = mt_rand(1000,99999);

				$datos = array("id"=> $_POST["renovarId"],
							   "id_cuenta"=> $_POST["renovarAsociacion"],
							   "fecha_corte"=> $_POST["renovarFcorte"],
							   "fecha_termino"=> $_POST["renovarFtermino"],
							   "precio"=> $_POST["renovarPrecioC"],
							   "nombre_cliente"=> $_POST["renovarCliente"],
							   "codigo"=> $aleatorio,
							   "fecha"=>$fecha,
							   "telefono"=> $_POST["renovarNumero"]);

				$tabla = "cuenta_completa";
				$respuesta = ModeloAsociar::mdlRenovarAsociacion($tabla, $datos);

				$tabla2 = "cuenta_completa_copia";
				$respuesta = ModeloAsociar::mdlRegistroAsociacionC($tabla2, $datos);

				$tabla1 = "cuentas";

				$item1 = "ocupada";
				$valor1 = 1;
				
				$item2 = "id";
				$valor2 = $_POST["renovarAsociacion"];

				$respuesta = ModeloCuentas::mdlRenovarOcupada($tabla1, $item1, $valor1, $item2, $valor2);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Asociación ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-completa";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	BORRAR CUENTA COMPLETA
	=============================================*/
	static public function ctrBorrarAsociacion(){
		if(isset($_GET["idAsociacion"])){
			$tabla = "cuentas";

			$item = "id";
			$valor = $_GET["idCuenta"];

			$traerVenta = ModeloCuentas::mdlMostrarCuentas($tabla, $item, $valor);

			$tablaCuentas = "cuentas";

			$item1 = "ocupada";
			$valor1 = $_GET["estadoCuenta"];

			$editarCuenta = ModeloCuentas::mdlActualizarCuentaC($tablaCuentas, $item1, $valor1, $valor);

			$tabla1 ="cuenta_completa";
			$datos = $_GET["idAsociacion"];

			$respuesta = ModeloAsociar::mdlBorrarAsociacion($tabla1, $datos);

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
								window.location = "cuenta-completa";
								}
							})
				</script>';
			}
		}
	}

	/*=============================================
	EDITAR ASOCIAR CUENTA
	=============================================*/
	public function ctrEditarAsociarIptv(){
		if(isset($_POST["editarCliente"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarId"])){

				/*=============================================
				FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
				=============================================*/
				$tabla = "cuenta_completa";

				$item = "id";
				$valor = $_POST["editarId"];

				$traerCuenta = ModeloCuentas::mdlMostrarCuentas($tabla, $item, $valor);

				/*=============================================
				REVISAR SI VIENE PRODUCTOS EDITADOS
				=============================================*/
				if($_POST["listaIptv"] == ""){
					$listaIptv = $traerCuenta["iptv"];
					$cambioProducto = false;
				}else{
					$listaIptv = $_POST["listaIptv"];
					$cambioProducto = true;
				}

				$datos = array("id"=> $_POST["editarId"],
							   "id_cuenta"=> $_POST["editarAsociacion"],
							   "fecha_termino"=> $_POST["editarFtermino"],
							   "precio"=> $_POST["editarPrecioC"],
							   "nombre_cliente"=> $_POST["editarCliente"],
							   "codigo"=> $_POST["editarCodigo"],
							   "iptv"=> $listaIptv,
							   "telefono"=> $_POST["editarNumero"]);							   

				$tabla = "cuenta_completa";
				$respuesta = ModeloAsociar::mdlRenovarAsociacionIptv($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Asociación ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-completa";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no pudo ser editada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
			}
		}
	}

	/*=============================================
	EDITAR ASOCIAR CUENTA
	=============================================*/
	public function ctrRenovarAsociarIptv(){
		if(isset($_POST["renovarCliente"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["renovarId"])){

				/*=============================================
				FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
				=============================================*/
				$tabla = "cuenta_completa";

				$item = "id";
				$valor = $_POST["renovarId"];

				$traerCuenta = ModeloCuentas::mdlMostrarCuentas($tabla, $item, $valor);

				/*=============================================
				REVISAR SI VIENE PRODUCTOS EDITADOS
				=============================================*/
				if($_POST["listaIptv"] == ""){
					$listaIptv = $traerCuenta["iptv"];
					$cambioProducto = false;
				}else{
					$listaIptv = $_POST["listaIptv"];
					$cambioProducto = true;
				}

				$fecha = date('Y-m-d');

				$aleatorio = mt_rand(1000,99999);

				$datos = array("id"=> $_POST["renovarId"],
							   "id_cuenta"=> $_POST["renovarAsociacion"],
							   "fecha_corte"=> $_POST["renovarFcorte"],
							   "fecha_termino"=> $_POST["renovarFtermino"],
							   "precio"=> $_POST["renovarPrecioC"],
							   "nombre_cliente"=> $_POST["renovarCliente"],
							   "codigo"=> $aleatorio,
							   "fecha"=>$fecha,
							   "iptv"=> $listaIptv,
							   "telefono"=> $_POST["renovarNumero"]);

				$tabla = "cuenta_completa";
				$respuesta = ModeloAsociar::mdlRenovarAsociacionIptv($tabla, $datos);

				$tabla2 = "cuenta_completa_copia";
				$respuesta = ModeloAsociar::mdlRegistroAsociacionC($tabla2, $datos);

				$tabla1 = "cuentas";

				$item1 = "ocupada";
				$valor1 = 1;
				
				$item2 = "id";
				$valor2 = $_POST["renovarAsociacion"];

				$respuesta = ModeloCuentas::mdlRenovarOcupada($tabla1, $item1, $valor1, $item2, $valor2);

				if($respuesta == "ok"){
					echo '<script> 
							swal({
							  type: "success",
							  title: "La Asociación ha sido renovada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "cuenta-completa";
								}
							})
						</script>';
				}else{
					echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no pudo ser renovada por algun fallo!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
				}
			}else{
				echo '<script> 
						swal({
							type: "error",
							title: "¡La Asociación no puede ir vacía o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){							
								window.location = "cuenta-completa";
							}
						});
					</script>';
			}
		}
	}
}