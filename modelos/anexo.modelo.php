<?php
require_once "conexion.php";

class ModeloAnexos{
	/*=============================================
	REGISTRO DE ANEXOS
	=============================================*/
	static public function mdlRegistroAnexo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(tipo_cuenta, recordatorio, estado) VALUES (:tipo_cuenta, :recordatorio, :estado)");

		$stmt->bindParam(":tipo_cuenta", $datos["tipo_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":recordatorio", $datos["recordatorio"], PDO::PARAM_STR);
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
	MOSTRAR ANEXOS
	=============================================*/
	static public function mdlMostrarAnexos($tabla, $item, $valor){
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
	ACTUALIZAR ANEXOS
	=============================================*/
	static public function mdlActualizarAnexo($tabla, $item1, $valor1, $item2, $valor2){
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
	EDITAR ANEXO
	=============================================*/
	static public function mdlEditarAnexo($tabla, $datos){	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET tipo_cuenta = :tipo_cuenta, recordatorio = :recordatorio WHERE id = :id");

		$stmt -> bindParam(":tipo_cuenta", $datos["tipo_cuenta"], PDO::PARAM_INT);
		$stmt -> bindParam(":recordatorio", $datos["recordatorio"], PDO::PARAM_STR);
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
	BORRAR ANEXO
	=============================================*/
	static public function mdlBorrarAnexo($tabla, $datos){
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