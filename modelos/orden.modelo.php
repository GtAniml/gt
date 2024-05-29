<?php
require_once "conexion.php";

class ModeloOrden{
	/*=============================================
	REGISTRO ORDEN DE COMPRA
	=============================================*/
	static public function mdlRegistroOrden($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_usuario, descripcion, fecha_orden, fecha_aprobacion, estado) VALUES (:id_usuario, :descripcion, :fecha_orden, :fecha_aprobacion, :estado)");

		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_orden", $datos["fecha_orden"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_aprobacion", $datos["fecha_aprobacion"], PDO::PARAM_STR);
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
	MOSTRAR ORDEN COMPRA
	=============================================*/
	static public function mdlMostrarOrden($tabla, $item, $valor){
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
	static public function mdlEditarOrden($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_usuario = :id_usuario, descripcion = :descripcion, fecha_orden = :fecha_orden, fecha_aprobacion = :fecha_aprobacion, estado = :estado WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_orden", $datos["fecha_orden"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_aprobacion", $datos["fecha_aprobacion"], PDO::PARAM_STR);
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
	static public function mdlBorrarOrden($tabla, $datos){
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