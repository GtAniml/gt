<?php
require_once "conexion.php";

class ModeloLicencia{
	/*=============================================
	MOSTRAR LICENCIA
	=============================================*/
	static public function mdlMostrarLicencia($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
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
	EDITAR LICENCIA
	=============================================*/
	static public function mdlEditarLicencia($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha = :fecha, ilimitado = :ilimitado WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":ilimitado", $datos["ilimitado"], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}
}