<?php
require_once "conexion.php";

class ModeloOrdenPago{
	/*=============================================
	REGISTRO ORDEN DE PAGO
	=============================================*/
	static public function mdlRegistroPago($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_usuario, descripcion, valor, carpeta, foto, estado) VALUES (:id_usuario, :descripcion, :valor, :carpeta, :foto, :estado)");

		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt->bindParam(":carpeta", $datos["carpeta"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
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
	MOSTRAR ORDEN DE PAGO
	=============================================*/
	static public function mdlMostrarOrdenPago($tabla, $item, $valor){
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
	EDITAR ORDEN
	=============================================*/
	static public function mdlEditarPago($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_usuario = :id_usuario, descripcion = :descripcion, carpeta = :carpeta, valor = :valor, foto = :foto, estado = :estado WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":carpeta", $datos["carpeta"], PDO::PARAM_STR);
		$stmt->bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
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
	BORRAR ORDEN
	=============================================*/
	static public function mdlBorrarPago($tabla, $datos){
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