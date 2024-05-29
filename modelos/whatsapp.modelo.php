<?php
require_once "conexion.php";

class ModeloWhatsapp{
	/*=============================================
	REGISTRO DE WHATSAPP
	=============================================*/
	static public function mdlRegistroWhatsapp($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(cuenta, mensaje, estado) VALUES (:cuenta, :mensaje, :estado)");

		$stmt->bindParam(":cuenta", $datos["cuenta"], PDO::PARAM_STR);
		$stmt->bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	MOSTRAR WHATSAPP
	=============================================*/
	static public function mdlMostrarWhatsapp($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}		
		$stmt-> close();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR WHATSAPP
	=============================================*/
	static public function mdlActualizarWhatsapp($tabla, $item1, $valor1, $item2, $valor2){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR WHATSAPP
	=============================================*/
	static public function mdlEditarWhatsapp($tabla, $datos){	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cuenta = :cuenta, mensaje = :mensaje WHERE id = :id");

		$stmt -> bindParam(":cuenta", $datos["cuenta"], PDO::PARAM_STR);
		$stmt -> bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	BORRAR WHATSAPP
	=============================================*/
	static public function mdlBorrarWhatsapp($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}
}