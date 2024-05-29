<?php

require_once "../controladores/cuentas.controlador.php";
require_once "../modelos/cuentas.modelo.php";

require_once "../controladores/asociar.controlador.php";
require_once "../modelos/asociar.modelo.php";

require_once "../controladores/streaming.controlador.php";
require_once "../modelos/streaming.modelo.php";

require_once "../controladores/pantalla.controlador.php";
require_once "../modelos/pantalla.modelo.php";

require_once "../controladores/anexo.controlador.php";
require_once "../modelos/anexo.modelo.php";

require_once "../controladores/recomendaciones.controlador.php";
require_once "../modelos/recomendaciones.modelo.php";

class TablaPantallas{
	public function mostrarTablaPantalla(){
		$item = null;
        $valor = null;

        $respuesta = ControladorPantalla::ctrMostrarPantalla($item, $valor);

        if(count($respuesta) == 0){
  			echo '{"data": []}';
		  	return;
  		}

  		$datosJson = '{
		  "data": [';
		  for($i = 0; $i < count($respuesta); $i++){
            /*=============================================
 	 		CUENTA CORREO
  			=============================================*/
  			$item1 = "id";
        	$valor1 = $respuesta[$i]["id_cuenta"];

        	$cuenta = ControladorCuentas::ctrMostrarCuentas($item1, $valor1);

        	$valor2 = $cuenta["id_categoria"];    	

        	$streaming = ControladorStreaming::ctrMostrarStreaming($item1, $valor2);

  			$correo = $cuenta["correo"];

  			$passPan = $cuenta["password"];

  			$item2 = "tipo_cuenta";
			$valor3 = "2";

			$anexos = ControladorAnexos::ctrMostrarAnexo($item2, $valor3);

			if($anexos["estado"]=="1"){
				$completa = $anexos["recordatorio"];
			}else{
				$completa="";
			}

			$item3 = "tipo_cuenta";
			$valor4 = "2";

			$recomendacion = ControladorRecomendaciones::ctrMostrarRecomendacion($item3, $valor4);

			if($recomendacion["estado"]=="1"){
				$completaR = $recomendacion["recordatorio"];
			}else{
				$completaR ="";
			}

  			date_default_timezone_set("America/Bogota");
            $fecha = date("Y-m-d");
            /*=============================================
 	 		FECHAS DÍAS RESTANTES
  			=============================================*/
			$fecha1= new DateTime($fecha);
			$fecha2= new DateTime($respuesta[$i]["fecha_termino"]);
			$diff = $fecha1->diff($fecha2);

			// El resultados sera 3 dias
			if ($respuesta[$i]["fecha_termino"] < $fecha){
				$diasF = "0 dias";
			}else{
				$diasF = "".$diff->days." días";
			}

			/*=============================================
 	 		ESTADO
  			=============================================*/
  			if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador"){
				if($fecha == $respuesta[$i]["fecha_termino"]){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$respuesta[$i]["telefono"]."&text=Buen%20d%C3%ADa%20¿c%C3%B3mo%20vas?...%20Ya%20hoy%20a%20las%206:00%20p.m.%20es%20tu%20corte%20del%20servicio%20".urlencode($respuesta[$i]["pantalla"])."-".$streaming["nombre"]."...%20Quer%C3%ADa%20confirmar%20si%20desea%20renovarla...%20Cualquier%20cosa%20qued%C3%B3%20atento...%F0%9F%93%9D%0A%0A".$completa."' target='_blank'><button class='btn btn-warning btn-sm'>Aviso Corte HOY</button></a>";
				}else if($fecha > $respuesta[$i]["fecha_termino"]){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$respuesta[$i]["telefono"]."&text=Buen%20d%C3%ADa%20¿c%C3%B3mo%20vas?...%20Queremos%20informarte%20que%20tu%20cuenta%20ha%20sido%20desactivada...%20Quer%C3%ADamos%20confirmar%20si%20desea%20renovarla...%20Cualquier%20cosa%20qued%C3%B3%20atento...%F0%9F%93%9D' target='_blank'><button class='btn btn-danger btn-sm'>Cuenta Desactivada</button></a>";
				}else if($diff->days <= "3" and $diff->days >= "2"){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$respuesta[$i]["telefono"]."&text=Buen%20día%20¿Cómo%20vas?...%0A%0AServicio:%20".urlencode($respuesta[$i]["pantalla"])."-".$streaming["nombre"]."%0ACorte:%20".$respuesta[$i]["fecha_termino"]."%0A%0AQuería%20confirmar%20renovación...%20Cualquier%20cosa%20quedó%20atento...%20📝%20Gracias%20😁%0A%0A".$completa."' target='_blank'><button class='btn btn-warning btn-sm'>Aviso Corte</button></a>";
				}else if($diff->days == "1"){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$respuesta[$i]["telefono"]."&text=Buen%20día%20¿Cómo%20vas?...%0A%0AServicio:%20".urlencode($respuesta[$i]["pantalla"])."-".$streaming["nombre"]."%0ACorte:%20".$respuesta[$i]["fecha_termino"]."%0A%0AQuería%20confirmar%20renovación...%20Cualquier%20cosa%20quedó%20atento...%20📝%20Gracias%20😁%0A%0A".$completa."' target='_blank'><button class='btn btn-warning btn-sm'>Aviso Corte</button></a>";
				}else if($diff->days > "3"){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$respuesta[$i]["telefono"]."&text=DATOS%20ACCESO%20".$streaming["nombre"]."%0A%0ACorreo:%20".urlencode($correo)."%0AContrase%C3%B1a:%20".urlencode($cuenta["password"])."%0APantalla:%20".$respuesta[$i]["pantalla"]."%0APIN:%20".$respuesta[$i]["pass"]."%0AServicio%20hasta:%20".$respuesta[$i]["fecha_termino"]."%0A%0AMuchas%20gracias%20por%20su%20compra.%20😊😉%0A%0A".urlencode($completaR)."' target='_blank'><button class='btn btn-success btn-sm'>pantalla Activa</button></a>";
				}
			}else{
				if($fecha < $respuesta[$i]["fecha_termino"]){
					$buttonEstado = "<button class='btn btn-success btn-sm'>Cuenta Activa</button>";
				}else if($fecha == $respuesta[$i]["fecha_termino"]){
					$buttonEstado = "<button class='btn btn-warning btn-sm'>Aviso Corte</button>";
				}else{
					$buttonEstado = "<button class='btn btn-danger btn-sm'>Renovar Cuenta</button>";
				}
			}

            if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador" && $fecha < $respuesta[$i]["fecha_termino"]){
				$editar = "<div class='btn-group pull-right'><button class='btn btn-warning btnEditarPantalla' idPantalla='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalEditarPantalla'><i class='fa fa-pen'></i> Editar</button></div>";
			}else{	
				$editar = "<div class='btn-group'><button type='button' class='btn btn-success'>Acciones</button><button type='button' class='btn btn-success dropdown-toggle dropdown-icon' data-toggle='dropdown'><span class='sr-only'>Toggle Dropdown</span></button><div class='dropdown-menu' role='menu'><a class='dropdown-item btnRenovarPantalla' idPantalla='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalRenovarPantalla' href=''>Renovar Pantalla</a><a class='dropdown-item btnEliminarPantalla' idPantalla=".$respuesta[$i]["id"]." idCuenta=".$respuesta[$i]["id_cuenta"]." href='#'>Eliminar Pantalla</a></div></div>";		
			}

		 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$correo.' - '.$streaming["nombre"].'",
			      "'.$passPan.'",
			      "'.$respuesta[$i]["pantalla"].'",
			      "'.$respuesta[$i]["pass"].'",
			      "'.$cuenta["corte"].'",
			      "'.$respuesta[$i]["cliente"].'",
			      "'.$respuesta[$i]["telefono"].'",
			      "'.$respuesta[$i]["fecha_termino"].'",
			      "'.$diasF.'",
			      "'.$buttonEstado.'",
			      "'.$editar.'"
			    ],';
		  }
			$datosJson = substr($datosJson, 0, -1);
			$datosJson .=   '] 

		}';		
		echo $datosJson;
	}
}

/*=============================================
ACTIVAR TABLA DE PANTALLA
=============================================*/ 
$activarAsociacion = new TablaPantallas();
$activarAsociacion -> mostrarTablaPantalla();