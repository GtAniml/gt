<?php

require_once "../controladores/cuentas.controlador.php";
require_once "../modelos/cuentas.modelo.php";

require_once "../controladores/asociar.controlador.php";
require_once "../modelos/asociar.modelo.php";

require_once "../controladores/revendedor.controlador.php";
require_once "../modelos/revendedor.modelo.php";

require_once "../controladores/streaming.controlador.php";
require_once "../modelos/streaming.modelo.php";

require_once "../controladores/proveedor.controlador.php";
require_once "../modelos/proveedor.modelo.php";

class TablaCuentas{
	public function mostrarTablaCuentas(){
		$item = null;
        $valor = null;

        $respuesta = ControladorCuentas::ctrMostrarCuentas($item, $valor);       

        if(count($respuesta) == 0){
  			echo '{"data": []}';
		  	return;
  		}

  		$datosJson = '{
		  "data": [';
		  for($i = 0; $i < count($respuesta); $i++){

		  	date_default_timezone_set("America/Bogota");
            $fecha = date("Y-m-d");
            /*=============================================
 	 		FECHAS DÍAS RESTANTES
  			=============================================*/
			$fecha1= new DateTime($fecha);
			$fecha2= new DateTime($respuesta[$i]["corte"]);
			$diff = $fecha1->diff($fecha2);

			// El resultados sera 3 dias
			if ($respuesta[$i]["corte"] < $fecha){
				$diasF = "0 dias";
			}else{
				$diasF = "".$diff->days." días";
			}

            /*=============================================
 	 		NOMBRE CLIENTE
  			=============================================*/
  			$item1 = "id";
        	$valor1 = $respuesta[$i]["id_categoria"];

        	$streaming = ControladorStreaming::ctrMostrarStreaming($item1, $valor1);

  			$nombre = $streaming["nombre"];

  			/*=============================================
 	 		PIN PROVEEDOR
  			=============================================*/
  			$item2 = "id";
        	$valor2 = $respuesta[$i]["pin"];

        	$proveedor = ControladorProveedores::ctrMostrarProveedor($item2, $valor2);

        	if($proveedor){
        		$nombrePin = $proveedor["nombre"];
        	}else{
        		$nombrePin = $respuesta[$i]["pin"];
        	}  			   			

  			/*=============================================
 	 		CUENTA COMPLETA O PANTALLA
  			=============================================*/
			if($respuesta[$i]["modo_cuenta"] == 1){
				$pantallas = "<button class='btn btn-info btn-sm'>Completa</button>";
			}else if($respuesta[$i]["modo_cuenta"] == 0){
				$pantallas = "<button class='btn btn-warning btn-sm'>Pantallas</button>";
			}else{
				$pantallas = "<button class='btn btn-secondary btn-sm'>Re-vendedor</button>";
			}

			/*=============================================
 	 		FECHAS DE CORTE
  			=============================================*/
  			if($respuesta[$i]["modo_cuenta"] == 1){
  				$item2 = "id_cuenta";
  				$valor2 = $respuesta[$i]["id"];

  				$asociarfecha = ControladorAsociar::ctrMostrarAsociar($item2, $valor2);

  				if($asociarfecha != ""){
  					$fechaTC = $asociarfecha["fecha_termino"];
  				}else{
  					$fechaTC = "0000-00-00";
  				}

  				
  			}else if($respuesta[$i]["modo_cuenta"] == 0){
  				$fechaTC = "0000-00-00";
  			}else if($respuesta[$i]["modo_cuenta"] == 2){  				
  				$item2 = "id_cuenta";
  				$valor2 = $respuesta[$i]["id"];

  				$revendedorfecha = ControladorRevendedor::ctrMostrarRevendedor($item2, $valor2);

  				if($revendedorfecha != ""){
  					$fechaTC = $revendedorfecha["fecha_termino"];
  				}else{
  					$fechaTC = "0000-00-00";
  				}  				
  			}

			/*=============================================
 	 		ESTADO
  			=============================================*/
  			if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador"){
				if($respuesta[$i]["corte"] == "0000-00-00"){
					$buttonEstado = "<button class='btn btn-success btn-sm'>Activada</button>";
				}else if($respuesta[$i]["corte"] > $fecha){
					$buttonEstado = "<button class='btn btn-success btn-sm'>Activada</button>";
				}else{
					$buttonEstado = "<button class='btn btn-danger btn-sm btnRenovarCuenta' data-toggle='modal' data-target='#modalRenovarCuenta' idCuenta='".$respuesta[$i]["id"]."'>Renovar</button>";
				}
			}else{
				if($respuesta[$i]["corte"] > $fecha){
					$buttonEstado = "<button class='btn btn-default btn-sm'>Activada</button>";
				}else{
					$buttonEstado = "<button class='btn btn-default btn-sm'>Desactivada</button>";
				}
			}

            if(isset($_GET["perfilOculto"]) || $_GET["perfilOculto"] == "Administrador" || $_GET["perfilOculto"] == "GAdministrador"){
				$editar = "<div class='btn-group'><button type='button' class='btn btn-success'>Acciones</button><button type='button' class='btn btn-success dropdown-toggle dropdown-icon' data-toggle='dropdown'><span class='sr-only'>Toggle Dropdown</span></button><div class='dropdown-menu' role='menu'><a class='dropdown-item btnEditarCuenta' idCuenta='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalEditarCuenta' href=''>Editar Cuenta</a><a class='dropdown-item btnEliminarCuenta' estadoCuenta='1' idCuenta=".$respuesta[$i]["id"]." href='#'>Eliminar Cuenta</a></div></div>";
			}else{				
				$editar = "<div class='btn-group pull-right'><button class='btn btn-default'><i class='fa fa-pen'></i> Editar</button></div>";

			}

			if($respuesta[$i]["desactivado"] != 1){
				$datosJson .='[
			      "'.($i+1).'",
			      "'.$nombre.'",
			      "'.$respuesta[$i]["correo"].'",
			      "'.$respuesta[$i]["password"].'",
			      "'.$nombrePin.'",
			      "'.number_format($respuesta[$i]["valor_pin"],2).'",
			      "'.$respuesta[$i]["activacion"].'",
			      "'.$respuesta[$i]["facturacion"].'",
			      "'.$respuesta[$i]["corte"].'",
			      "'.$fechaTC.'",
			      "'.$pantallas.'",
			      "'.$diasF.'",
			      "'.$buttonEstado.'",
			      "'.$editar.'"
			    ],';
			}		  	
		  }
			$datosJson = substr($datosJson, 0, -1);
			$datosJson .=   ']

		}';
		
		echo $datosJson;
	}
}

/*=============================================
ACTIVAR TABLA DE MEMBRESIAS
=============================================*/ 
$activarMembresias = new TablaCuentas();
$activarMembresias -> mostrarTablaCuentas();