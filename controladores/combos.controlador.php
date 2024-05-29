<?php

class ControladorCombos{
	/*=============================================
	MOSTRAR COMBOS
	=============================================*/
	static public function ctrMostrarCombos($item, $valor){
		$tabla = "combos";
		$respuesta = ModeloCombos::mdlMostrarCombos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	CREAR COMBO
	=============================================*/
	static public function ctrCrearCombo(){
		if(isset($_POST["nuevoCombo"])){

			$aleatorio = mt_rand(1000,99999);

			if($_POST["opc"] == 1){
				$cliente = $_POST["nuevoCliente"];
			}else if($_POST["opc"] == 0){
				$cliente = $_POST["nuevoClienteR"];
			}

			if($_POST["nuevaId"]){
					$nueva = $_POST["nuevaId"];
				}else{
					$nueva = 0;
				}

			/*=============================================
			ACTUALIZAR LAS CUENTAS  Y REDUCIR EL STOCK
			=============================================*/
			if($_POST["listaProductos"] == ""){
					echo'<script>

				swal({
					  type: "error",
					  title: "El combo no se registra si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
									window.location = "crear-cuenta-combo";
								}
							})
				</script>';
				return;
			}

			$listaProductos = json_decode($_POST["listaProductos"], true);
			
			$arrayId = array();
			$arrayCantidad = array();
			$sumaCantidad = array();
			$arrayIdC = array();

			foreach ($listaProductos as $key => $value) {

				$correo = $value["descripcion"];
				$id = $value["id"];

				#Introducir las id
				array_push($arrayId, $correo);

				#Capturamos las cantidades
				$arrayCantidad = array($correo => $value["cantidad"]);

				#Sumamos los pagos que ocurrieron el mismo mes
				foreach ($arrayCantidad as $key => $value1) {		
					$sumaCantidad[$key] += $value1;
				}

			    array_push($arrayIdC, $id);
			}

			$noRepetirFechas = array_unique($arrayId);
			$valor2 = array_unique($arrayIdC);
			

			if($noRepetirFechas != null){
				foreach(array_combine($noRepetirFechas, $valor2) as $key => $valor){
					$tablaProductos = "cuentas";

			    	$item = "id";
			    	$valor = $valor;

			    	$traerCuentas = ModeloCuentas::mdlMostrarCuentas($tablaProductos, $item, $valor);

					$item1b = "pantallas";
					$valor1b = $traerCuentas["pantallas"] - $sumaCantidad[$key];
					
					$nuevoStock = ModeloCuentas::mdlActualizarCuentaC($tablaProductos, $item1b, $valor1b, $valor);
				}				
			}		

			$fecha = date('Y-m-d');

			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/
			$tabla = "combos";

			$datos = array("nombre_combo"=>$_POST["nuevoCombo"],
						   "telefono"=>$_POST["nuevoTelefono"],
						   "cliente"=>$cliente,
						   "productos"=>$_POST["listaProductos"],
						   "precio"=>$_POST["totalVenta"],
						   "fecha_inicio"=>$_POST["nuevaFinicio"],
						   "fecha_final"=>$_POST["nuevaFtermino"],
						   "codigo"=>$aleatorio,
						   "ref_id"=> $nueva,
						   "fecha" => $fecha);

			$respuesta = ModeloCombos::mdlIngresarCombo($tabla, $datos);

			$tabla1 = "combos_copia";
			$respuesta = ModeloCombos::mdlIngresarComboC($tabla1, $datos);

			if($respuesta == "ok"){
	
				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El combo ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {
							window.location = "combos";
						}
					  })
				</script>';
			}
		}
	}

	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function ctrEditarCombo(){
		if(isset($_POST["idCombo"])){

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "combos";

			$item = "id";
			$valor = $_POST["idCombo"];

			$traerVenta = ModeloCombos::mdlMostrarCombos($tabla, $item, $valor);
			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
			if($_POST["listaProductos"] == ""){
				$listaProductos = $traerVenta["productos"];
				$cambioProducto = false;
			}else{
				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			if($cambioProducto){
				$productos =  json_decode($traerVenta["productos"], true);

				$arrayId = array();
				$arrayCantidad = array();
				$sumaCantidad = array();
				$arrayIdC = array();

				foreach ($productos as $key => $value) {
					$correo = $value["descripcion"];
                	$id = $value["id"];

                	#Introducir las id
                	array_push($arrayId, $correo);

                	#Capturamos las cantidades
                	$arrayCantidad = array($correo => $value["cantidad"]);

                	#Sumamos los pagos que ocurrieron el mismo mes
                	foreach ($arrayCantidad as $key => $value1) {   
                		$sumaCantidad[$key] += $value1;
                	}

                	array_push($arrayIdC, $id);
				}

				$noRepetirFechas = array_unique($arrayId);
				$valor2 = array_unique($arrayIdC);
			
				if($noRepetirFechas != null){
					foreach(array_combine($noRepetirFechas, $valor2) as $key => $valor){
						$tablaProductos = "cuentas";

						$item = "id";
						$valor = $valor;

						$traerProducto = ModeloCuentas::mdlMostrarCuentas($tablaProductos, $item, $valor);

						$item1b = "pantallas";
						$valor1b = $traerProducto["pantallas"] + $sumaCantidad[$key];

						$nuevoStock = ModeloCuentas::mdlActualizarCuentaC($tablaProductos, $item1b, $valor1b, $valor);
					}				
				}

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/
				$listaProductos_2 = json_decode($listaProductos, true);

				$arrayId1 = array();
				$arrayCantidad1 = array();
				$sumaCantidad1 = array();
				$arrayIdC1 = array();

				foreach ($listaProductos_2 as $key => $value) {
					$correo1 = $value["descripcion"];
                	$id1 = $value["id"];

                	#Introducir las id
                	array_push($arrayId1, $correo1);

                	#Capturamos las cantidades
                	$arrayCantidad1 = array($correo1 => $value["cantidad"]);

                	#Sumamos los pagos que ocurrieron el mismo mes
                	foreach ($arrayCantidad1 as $key => $value2) {   
                		$sumaCantidad1[$key] += $value2;
                	}

                	array_push($arrayIdC1, $id1);
				}

				$noRepetirFechas1 = array_unique($arrayId1);
				$valor21 = array_unique($arrayIdC1);
			
				if($noRepetirFechas1 != null){
					foreach(array_combine($noRepetirFechas1, $valor21) as $key => $valorN){
						$tablaProductos_2 = "cuentas";

						$item_2 = "id";
						$valor_2 = $valorN;
						$orden = "id";

						$traerProducto_2 = ModeloCuentas::mdlMostrarCuentas($tablaProductos_2, $item_2, $valor_2);

						$item1b_2 = "pantallas";
						$valor1b_2 =  $traerProducto_2["pantallas"] - $sumaCantidad1[$key];

						$nuevoStock_2 = ModeloCuentas::mdlActualizarCuentaC($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
						}				
				}
			}

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	
			$datos = array("id"=>$_POST["idCombo"],
						   "nombre_combo"=>$_POST["nuevoCombo"],
						   "telefono"=>$_POST["nuevoTelefono"],
						   "cliente"=>$_POST["nuevoCliente"],
						   "productos"=>$listaProductos,
						   "precio"=>$_POST["totalVenta"],
						   "fecha_inicio"=>$_POST["nuevaFinicio"],
						   "fecha_final"=>$_POST["nuevaFtermino"],
						   "codigo" => $_POST["nuevoCodigo"]);

			$respuesta = ModeloCombos::mdlEditarCombo($tabla, $datos);

			$tabla1 = "combos_copia";
			$respuesta = ModeloCombos::mdlEditarComboC($tabla1, $datos);

			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El combo ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {
									window.location = "combos";
								}
							})
				</script>';
			}
		}
	}

	/*=============================================
	RENOVAR COMBO
	=============================================*/
	static public function ctrRenovarCombo(){
		if(isset($_POST["idCombo"])){

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "combos";

			$item = "id";
			$valor = $_POST["idCombo"];

			$traerVenta = ModeloCombos::mdlMostrarCombos($tabla, $item, $valor);
			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
			if($_POST["listaProductos"] == ""){
				$listaProductos = $traerVenta["productos"];
				$cambioProducto = false;
			}else{
				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			if($cambioProducto){
				$productos =  json_decode($traerVenta["productos"], true);

				$arrayId = array();
				$arrayCantidad = array();
				$sumaCantidad = array();
				$arrayIdC = array();

				foreach ($productos as $key => $value) {
					$correo = $value["descripcion"];
                	$id = $value["id"];

                	#Introducir las id
                	array_push($arrayId, $correo);

                	#Capturamos las cantidades
                	$arrayCantidad = array($correo => $value["cantidad"]);

                	#Sumamos los pagos que ocurrieron el mismo mes
                	foreach ($arrayCantidad as $key => $value1) {   
                		$sumaCantidad[$key] += $value1;
                	}

                	array_push($arrayIdC, $id);
				}

				$noRepetirFechas = array_unique($arrayId);
				$valor2 = array_unique($arrayIdC);
			
				if($noRepetirFechas != null){
					foreach(array_combine($noRepetirFechas, $valor2) as $key => $valor){
						$tablaProductos = "cuentas";

						$item = "id";
						$valor = $valor;

						$traerProducto = ModeloCuentas::mdlMostrarCuentas($tablaProductos, $item, $valor);

						$item1b = "pantallas";
						$valor1b = $traerProducto["pantallas"] + $sumaCantidad[$key];

						$nuevoStock = ModeloCuentas::mdlActualizarCuentaC($tablaProductos, $item1b, $valor1b, $valor);
					}				
				}

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/
				$listaProductos_2 = json_decode($listaProductos, true);

				$arrayId1 = array();
				$arrayCantidad1 = array();
				$sumaCantidad1 = array();
				$arrayIdC1 = array();

				foreach ($listaProductos_2 as $key => $value) {
					$correo1 = $value["descripcion"];
                	$id1 = $value["id"];

                	#Introducir las id
                	array_push($arrayId1, $correo1);

                	#Capturamos las cantidades
                	$arrayCantidad1 = array($correo1 => $value["cantidad"]);

                	#Sumamos los pagos que ocurrieron el mismo mes
                	foreach ($arrayCantidad1 as $key => $value2) {   
                		$sumaCantidad1[$key] += $value2;
                	}

                	array_push($arrayIdC1, $id1);
				}

				$noRepetirFechas1 = array_unique($arrayId1);
				$valor21 = array_unique($arrayIdC1);
			
				if($noRepetirFechas1 != null){
					foreach(array_combine($noRepetirFechas1, $valor21) as $key => $valorN){
						$tablaProductos_2 = "cuentas";

						$item_2 = "id";
						$valor_2 = $valorN;
						$orden = "id";

						$traerProducto_2 = ModeloCuentas::mdlMostrarCuentas($tablaProductos_2, $item_2, $valor_2);

						$item1b_2 = "pantallas";
						$valor1b_2 =  $traerProducto_2["pantallas"] - $sumaCantidad1[$key];

						$nuevoStock_2 = ModeloCuentas::mdlActualizarCuentaC($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
						}				
				}
			}

			$fecha = date('Y-m-d');

			$aleatorio = mt_rand(1000,99999);

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	
			$datos = array("id"=>$_POST["idCombo"],
						   "nombre_combo"=>$_POST["nuevoCombo"],
						   "telefono"=>$_POST["nuevoTelefono"],
						   "cliente"=>$_POST["nuevoCliente"],
						   "productos"=>$listaProductos,
						   "precio"=>$_POST["totalVenta"],
						   "fecha_inicio"=>$_POST["nuevaFinicio"],
						   "fecha_final"=>$_POST["nuevaFtermino"],
						   "fecha" => $fecha,
						   "codigo" => $aleatorio);

			$respuesta = ModeloCombos::mdlRenovarCombo($tabla, $datos);

			$tabla1 = "combos_copia";
			$respuesta = ModeloCombos::mdlIngresarComboC($tabla1, $datos);

			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El combo ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {
									window.location = "combos";
								}
							})
				</script>';
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/
	static public function ctrRangoFechasCuentasCombos($fechaInicial, $fechaFinal){
		$tabla = "combos";
		$respuesta = ModeloCombos::mdlRangoFechasCuentasCombos($tabla, $fechaInicial, $fechaFinal);
		return $respuesta;		
	}

	/*=============================================
	ELIMINAR COMBO
	=============================================*/
	static public function ctrBorrarCombo(){
		if(isset($_GET["idCombo"])){

			$tabla = "combos";

			$item = "id";
			$valor = $_GET["idCombo"];

			$traerVenta = ModeloCombos::mdlMostrarCombos($tabla, $item, $valor);

			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$productos =  json_decode($traerVenta["productos"], true);
			
			$arrayId = array();
			$arrayCantidad = array();
			$sumaCantidad = array();
			$arrayIdC = array();

			foreach ($productos as $key => $value) {

				$correo = $value["descripcion"];
            	$id = $value["id"];

            	#Introducir las id
            	array_push($arrayId, $correo);

            	#Capturamos las cantidades
            	$arrayCantidad = array($correo => $value["cantidad"]);

            	#Sumamos los pagos que ocurrieron el mismo mes
            	foreach ($arrayCantidad as $key => $value1) {   
            		$sumaCantidad[$key] += $value1;
            	}

            	array_push($arrayIdC, $id);
			}

			$noRepetirFechas = array_unique($arrayId);
			$valor2 = array_unique($arrayIdC);
			
			if($noRepetirFechas != null){
				foreach(array_combine($noRepetirFechas, $valor2) as $key => $valor){
					$tablaProductos = "cuentas";

					$item = "id";
					$valor = $valor;

					$traerProducto = ModeloCuentas::mdlMostrarCuentas($tablaProductos, $item, $valor);

					$item1b = "pantallas";
					$valor1b = $traerProducto["pantallas"] + $sumaCantidad[$key];

					$nuevoStock = ModeloCuentas::mdlActualizarCuentaC($tablaProductos, $item1b, $valor1b, $valor);
				}				
			}

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloCombos::mdlBorrarCombo($tabla, $_GET["idCombo"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El combo ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
									window.location = "combos";
								}
							})
				</script>';

			}		
		}
	}

	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function ctrEditarComboReven(){
		if(isset($_POST["editarId"])){

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/
			$tabla = "combos";
			$datos = array("id"=>$_POST["editarId"],
						   "nombre_combo"=>$_POST["editarNombeC"],
						   "productos"=>$_POST["editarProductosC"],
						   "precio"=>$_POST["editarPrecioCombo"],
						   "fecha_final"=>$_POST["editarFcorte"],
						   "clienteRevendedor" => $_POST["editarClienteC"]);

			$respuesta = ModeloCombos::mdlEditarComboReven($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El combo ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {
									window.location = "inicio";
								}
							})
				</script>';
			}
		}
	}
}