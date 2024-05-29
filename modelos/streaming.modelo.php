<?php
require_once "conexion.php";

class ModeloStreaming{
	/*=============================================
	REGISTRO DE STREAMING
	=============================================*/
	static public function mdlRegistroStreaming($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, pantallas, iptv, estado) VALUES (:nombre, :pantallas, :iptv, :estado)");
		
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":pantallas", $datos["pantallas"], PDO::PARAM_STR);
		$stmt->bindParam(":iptv", $datos["iptv"], PDO::PARAM_INT);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	MOSTRAR STREAMING
	=============================================*/
	static public function mdlMostrarStreaming($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}		
		$stmt-> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR STREAMING
	=============================================*/
	static public function mdlEditarStreaming($tabla, $datos){	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, pantallas = :pantallas, iptv = :iptv WHERE id = :id");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":pantallas", $datos["pantallas"], PDO::PARAM_STR);
		$stmt -> bindParam(":iptv", $datos["iptv"], PDO::PARAM_INT);
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
	ACTUALIZAR STREAMING
	=============================================*/
	static public function mdlActualizarStreaming($tabla, $item1, $valor1, $item2, $valor2){
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
	BORRAR STREAMING
	=============================================*/
	static public function mdlBorrarStreaming($tabla, $datos){
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