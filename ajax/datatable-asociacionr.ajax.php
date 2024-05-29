<?php

require_once "../controladores/cuentas.controlador.php";
require_once "../modelos/cuentas.modelo.php";

require_once "../controladores/revendedor.controlador.php";
require_once "../modelos/revendedor.modelo.php";

require_once "../controladores/streaming.controlador.php";
require_once "../modelos/streaming.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class tablaAsociacionR{
	public function mostrarTablaAsociacionR(){
		$item = null;
        $valor = null;

        $respuesta = ControladorRevendedor::ctrMostrarRevendedor($item, $valor);        

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
        	
        	$item3 = "nombre";
        	$valor3 = $respuesta[$i]["nombre_revendedor"];

        	$usuario = ControladorUsuarios::ctrMostrarUsuario($item3, $valor3);
        	
        	$miusuario = $usuario["telefono"];

        	$valor2 = $cuenta["id_categoria"];

        	$streaming = ControladorStreaming::ctrMostrarStreaming($item1, $valor2);

  			$correo = $cuenta["correo"];

  			$passPan = $cuenta["password"];


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
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$miusuario."&text=Buen%20d%C3%ADa%20¿c%C3%B3mo%20vas?...%20Ya%20hoy%20a%20las%206:00%20p.m.%20es%20tu%20corte%20del%20servicio%20".urlencode($correo)."-".$streaming["nombre"]."...%20Quer%C3%ADa%20confirmar%20si%20desea%20renovarla...%20Cualquier%20cosa%20qued%C3%B3%20atento...%F0%9F%93%9D' target='_blank'><button class='btn btn-warning btn-sm'>Aviso Corte HOY</button></a>";
				}else if($fecha > $respuesta[$i]["fecha_termino"]){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$miusuario."&text=Buen%20d%C3%ADa%20¿c%C3%B3mo%20vas?...%20Queremos%20informarte%20que%20tu%20cuenta%20ha%20sido%20desactivada...%20Quer%C3%ADamos%20confirmar%20si%20desea%20renovarla...%20Cualquier%20cosa%20qued%C3%B3%20atento...%F0%9F%93%9D' target='_blank'><button class='btn btn-danger btn-sm'>Cuenta Desactivada</button></a>";
				}else if($diff->days <= "3" and $diff->days >= "2"){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$miusuario."&text=Buen%20día%20¿Cómo%20vas?...%0A%0AServicio:%20".urlencode($correo)."-".$streaming["nombre"]."%0ACorte:%20".$respuesta[$i]["fecha_termino"]."%0A%0AQuería%20confirmar%20renovación...%20Cualquier%20cosa%20quedó%20atento...%20📝%20Gracias%20😁' target='_blank'><button class='btn btn-warning btn-sm'>Aviso Corte</button></a>";
				}else if($diff->days == "1"){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$miusuario."&text=Buen%20día%20¿Cómo%20vas?...%0A%0AServicio:%20".urlencode($correo)."-".$streaming["nombre"]."%0ACorte:%20".$respuesta[$i]["fecha_termino"]."%0A%0AQuería%20confirmar%20renovación...%20Cualquier%20cosa%20quedó%20atento...%20📝%20Gracias%20😁' target='_blank'><button class='btn btn-warning btn-sm'>Aviso Corte</button></a>";
				}else if($diff->days > "3"){
					$buttonEstado = "<a href='https://api.whatsapp.com/send?phone=".$miusuario."&text=DATOS%20ACCESO%20".$streaming["nombre"]."%0A%0ACorreo:%20".urlencode($correo)."%0AContrase%C3%B1a:%20".urlencode($cuenta["password"])."%0AServicio%20hasta:%20".$respuesta[$i]["fecha_termino"]."%0A%0AMuchas%20gracias%20por%20su%20compra.%20😊😉' target='_blank'><button class='btn btn-success btn-sm'>Cuenta Activa</button></a>";
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

            if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador"){
            	if($fecha < $respuesta[$i]["fecha_termino"]){
            		$editar = "<div class='btn-group pull-right'><button class='btn btn-warning btnEditarRevendedor' idRevendedor='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalEditarRevendedor'><i class='fa fa-pen'></i> Editar</button></div>";
            	}else{
            		$editar = "<div class='btn-group'><button type='button' class='btn btn-success'>Acciones</button><button type='button' class='btn btn-success dropdown-toggle dropdown-icon' data-toggle='dropdown'><span class='sr-only'>Toggle Dropdown</span></button><div class='dropdown-menu' role='menu'><a class='dropdown-item btnRenovarRevendedor' idRevendedor='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalRenovarRevendedor' href=''>Renovar Cuenta</a><a class='dropdown-item btnEliminarRenovar' idRenovar=".$respuesta[$i]["id"]." idCuenta=".$respuesta[$i]["id_cuenta"]." href='#'>Eliminar Cuenta</a></div></div>";
            	}
				
			}else{				
				$editar = "<div class='btn-group pull-right'><button class='btn btn-default'><i class='fa fa-pen'></i> Editar</button></div>";		
			}

		 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$correo.' - '.$streaming["nombre"].'",
			      "'.$passPan.'",
			      "'.$cuenta["corte"].'",
			      "'.$respuesta[$i]["nombre_revendedor"].'",
			      "'.$miusuario.'",
			      "'.$respuesta[$i]["fecha_termino"].'",
			      "'.number_format($respuesta[$i]["precio"],2).'",
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
ACTIVAR TABLA DE ASOCIACION
=============================================*/ 
$activarAsociacionR = new tablaAsociacionR();
$activarAsociacionR -> mostrarTablaAsociacionR();