<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaUsuarios{
	public function mostrarTablaUsuarios(){
				$item = null;
        $valor = null;

        $respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

        if(count($respuesta) == 0){
  			echo '{"data": []}';
		  	return;
  		}

  		$datosJson = '{
		  "data": [';
		  for($i = 0; $i < count($respuesta); $i++){
            /*=============================================
			 	 		FOTOS
			  		=============================================*/
						if($respuesta[$i]["foto"] != ""){
              $foto = "<td><img src='".$respuesta[$i]["foto"]."' class='img-thumbnail' width='40px'></td>";
            }else{
              $foto = "<td><img src='vistas/img/usuarios/default/anonymous.png' class='img-thumbnail' width='40px'></td>";
            }

						if($respuesta[$i]["estado"] != 0){
                $Estado = "<td><button class='btn btn-success btn-xs btnActivar' idUsuario='".$respuesta[$i]["id"]."' estadoUsuario='0'>Activado</button></td>";
            }else{
                $Estado = "<td><button class='btn btn-danger btn-xs btnActivar' idUsuario='".$respuesta[$i]["id"]."' estadoUsuario='1'>Bloqueado</button></td>";    
            }

            if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador"){
	            if($respuesta[$i]["perfil"] == "Revendedor"){
	              $botones = "<td><div class='btn-group'><button class='btn btn-warning btnEditarUsuarioR' idUsuario='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUsuarioR'><i class='nav-icon fas fa-edit'></i> Editar</button><button class='btn btn-danger btnEliminarUsuario' idUsuario='".$respuesta[$i]["id"]."' fotoUsuario='".$respuesta[$i]["foto"]."' usuario='".$respuesta[$i]["carpeta"]."'><i class='fa fa-times'></i> Eliminar</button></div></td>";
	            }else if($respuesta[$i]["perfil"] == "Cliente"){
	              $botones = "<td><div class='btn-group'><button class='btn btn-warning btnEditarUsuario' idUsuario='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUsuario'><i class='nav-icon fas fa-edit'></i> Editar</button><button class='btn btn-danger btnEliminarUsuario' idUsuario='".$respuesta[$i]["id"]."' fotoUsuario='".$respuesta[$i]["foto"]."' usuario='".$respuesta[$i]["carpeta"]."'><i class='fa fa-times'></i> Eliminar</button></div></td>";     
	            }else{
	            	$botones = "<td><div class='btn-group'><button class='btn btn-warning btnEditarUsuario' idUsuario='".$respuesta[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUsuario'><i class='nav-icon fas fa-edit'></i> Editar</button><button class='btn btn-danger btnEliminarUsuario' idUsuario='".$respuesta[$i]["id"]."' fotoUsuario='".$respuesta[$i]["foto"]."' usuario='".$respuesta[$i]["carpeta"]."'><i class='fa fa-times'></i> Eliminar</button></div></td>";
	            }

	            if($respuesta[$i]["perfil"] == "Administrador"){
	            	if($respuesta[$i]["activo_mensaje"] == 0){
	            		$botonWhat = "<td><div class='btn-group'><button class='btn btn-danger btnActivarMensaje' idUsuario='".$respuesta[$i]["id"]."' estadoMensajeU='0'><i class='fab fa-whatsapp'></i> Desactivar Mensaje</button></div></td>";
	            	}else{
	            		$botonWhat = "<td><div class='btn-group'><button class='btn btn-success btnActivarMensaje' idUsuario='".$respuesta[$i]["id"]."' estadoMensajeU='1'><i class='fab fa-whatsapp'></i> Activar Mensaje</button></div></td>";
	            	}
	            }
        		}

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$respuesta[$i]["nombre"].'",
			      "'.$respuesta[$i]["usuario"].'",
			      "'.$respuesta[$i]["telefono"].'",
			      "'.$foto.'",
			      "'.$respuesta[$i]["perfil"].'",
			      "'.$Estado.'",
			      "'.$botones.''.$botonWhat.'"
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
$activarAsociacion = new TablaUsuarios();
$activarAsociacion -> mostrarTablaUsuarios();