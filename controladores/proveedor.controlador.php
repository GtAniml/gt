<?php

class ControladorProveedores{
	/*=============================================
	REGISTRO DE PROVEEDOR
	=============================================*/
	public function ctrRegistroProveedor(){
		if(isset($_POST["nuevoNombre"])){

			$datos = array("nombre"=> $_POST["nuevoNombre"],
						   "email"=> $_POST["nuevoEmail"],
						   "streaming"=> $_POST["nuevoStreaming"],
						   "telefono"=> $_POST["nuevoTelefono"],
						   "estado"=> 1);

			echo '<pre>'; print_r($datos); echo '</pre>';

			$tabla = "proveedores";
			$respuesta = ModeloProveedor::mdlRegistroProveedor($tabla, $datos);

			if($respuesta == "ok"){
				echo '<script> 
						swal({
						  type: "success",
						  title: "El proveedor ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "proveedor";
							}
						})
					</script>';
			}else{
				echo '<script> 
					swal({
						type: "error",
						title: "¡El proveedor no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){							
							window.location = "proveedor";
						}
					});
			</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR PROVEEDOR
	=============================================*/
	static public function ctrMostrarProveedor($item, $valor){
		$tabla = "proveedores";
		$respuesta = ModeloProveedor::mdlMostrarProveedor($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/
	static public function ctrEditarProveedor(){
		if(isset($_POST["editarNombre"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				$tabla = "proveedores";
				$datos = array("id" => $_POST["editarId"],
							   "nombre" => $_POST["editarNombre"],
							   "email" => $_POST["editarEmail"],
							   "streaming" => $_POST["editarStreaming"],
							   "telefono" => $_POST["editarTelefono"]);

				$respuesta = ModeloProveedor::mdlEditarProveedor($tabla, $datos);

				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El proveedor ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
								if (result.value) {
									window.location = "proveedor";
								}
							})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El proveedor no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {
								window.location = "proveedor";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR PROVEEDOR
	=============================================*/
	static public function ctrBorrarProveedor(){
		if(isset($_GET["idProveedor"])){
			$tabla ="proveedores";
			$datos = $_GET["idProveedor"];

			$respuesta = ModeloProveedor::mdlBorrarProveedor($tabla, $datos);

			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El proveedor ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "proveedor";
								}
							})
				</script>';
			}
		}
	}
}