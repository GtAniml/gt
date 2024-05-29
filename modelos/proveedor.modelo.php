<?php
require_once "conexion.php";

class ModeloProveedor{
	/*=============================================
	REGISTRO DE PROVEEDOR
	=============================================*/
	static public function mdlRegistroProveedor($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, email, streaming, telefono, estado) VALUES (:nombre, :email, :streaming, :telefono, :estado)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":streaming", $datos["streaming"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
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
	MOSTRAR PROVEEDOR
	=============================================*/
	static public function mdlMostrarProveedor($tabla, $item, $valor){
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
	EDITAR USUARIO
	=============================================*/
	static public function mdlEditarProveedor($tabla, $datos){	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, streaming = :streaming, telefono = :telefono WHERE id = :id");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":streaming", $datos["streaming"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
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
	ACTUALIZAR USUARIO
	=============================================*/
	static public function mdlActualizarProveedor($tabla, $item1, $valor1, $item2, $valor2){
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
	BORRAR PROVEEDOR
	=============================================*/
	static public function mdlBorrarProveedor($tabla, $datos){
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