<?php

require_once "../controladores/cuentas.controlador.php";
require_once "../modelos/cuentas.modelo.php";

require_once "../controladores/streaming.controlador.php";
require_once "../modelos/streaming.modelo.php";

class TablaProductosReporteInventario{

	/*=============================================
 	 MOSTRAR LA TABLA DE INVENTARIO
  	=============================================*/ 
	public function mostrarTablaReporteInventario(){
		$item = null;
    	$valor = null;

    	$reporte = ControladorCuentas::ctrMostrarCuentas($item, $valor);

    	date_default_timezone_set("America/Bogota");
        $fecha = date("Y-m-d");

    	if(count($reporte) == 0){
  			echo '{"data": []}';
		  	return;
	  	}

  		$datosJson = '{
  			"data": [';
  				for($i = 0; $i < count($reporte); $i++){
  					
  					/*=============================================
		 	 		STREAMING
		  			=============================================*/
		  			$item = "id";
			    	$valor = $reporte[$i]["id_categoria"];

			    	$streaming = ControladorStreaming::ctrMostrarStreaming($item, $valor);

				  	/*=============================================
		 	 		STOCK
		  			=============================================*/
		  			if($reporte[$i]["pantallas"] <= 1){
		  				$cantidad = "<button class='btn btn-danger'>".$reporte[$i]["pantallas"]."</button>";
		  			}else if($reporte[$i]["pantallas"] > 1 && $reporte[$i]["pantallas"] <= 2){
		  				$cantidad = "<button class='btn btn-warning'>".$reporte[$i]["pantallas"]."</button>";
		  			}else{
		  				$cantidad = "<button class='btn btn-success'>".$reporte[$i]["pantallas"]."</button>";
		  			}

		  			/*=============================================
			 		TRAEMOS LAS ACCIONES
					=============================================*/ 
				  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$reporte[$i]["id"]."'>Agregar</button></div>"; 

				  	if($reporte[$i]["pantallas"] == 0 || $reporte[$i]["ocupada"] == 1 || $reporte[$i]["modo_cuenta"] == 2 || $reporte[$i]["desactivado"] == 1 ){
				  		
				  	}else{
				  		$datosJson .='[
					      "'.$reporte[$i]["correo"].' - '.$streaming["nombre"].'",
					      "'.$cantidad.'",
					      "'.$botones.'",
					      "'.$reporte[$i]["corte"].'"
					    ],';
				  	}
				  	
  				}

  				$datosJson = substr($datosJson, 0, -1);
		 		$datosJson .= 
  			']
  		}';
  		
  		echo $datosJson;
	}
}

/*=============================================
ACTIVAR TABLA DE INVENTARIO
=============================================*/ 
$activarProductosVentas = new TablaProductosReporteInventario();
$activarProductosVentas -> mostrarTablaReporteInventario();