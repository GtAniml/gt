<?php
require_once "conexion.php";

class ModeloPantalla{
	/*=============================================
	REGISTRO DE ASOCIACIÓN PANTALLA
	=============================================*/
	static public function mdlRegistroPantalla($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cuenta, cliente, pantalla, pass, fecha_corte, fecha_termino, telefono, costo, renovo_cuenta, mac, llave, reproductor, estado, renovo_regresa, ref_id, fecha) VALUES (:id_cuenta, :cliente, :pantalla, :pass, :fecha_corte, :fecha_termino, :telefono, :costo, :renovo_cuenta, :mac, :llave, :reproductor, :estado, :renovo_regresa, :ref_id, :fecha)");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":pantalla", $datos["pantalla"], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt->bindParam(":renovo_cuenta", $datos["renovo_cuenta"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":llave", $datos["llave"], PDO::PARAM_STR);
		$stmt->bindParam(":reproductor", $datos["reproductor"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		$stmt->bindParam(":renovo_regresa", $datos["renovo_regresa"], PDO::PARAM_INT);
		$stmt->bindParam(":ref_id", $datos["ref_id"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	REGISTRO DE ASOCIACIÓN PANTALLA
	=============================================*/
	static public function mdlRegistroPantallaC($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cuenta, cliente, pantalla, pass, fecha_corte, fecha_termino, telefono, costo, renovo_cuenta, mac, llave, reproductor, estado, renovo_regresa, fecha) VALUES (:id_cuenta, :cliente, :pantalla, :pass, :fecha_corte, :fecha_termino, :telefono, :costo, :renovo_cuenta, :mac, :llave, :reproductor, :estado, :renovo_regresa, :fecha)");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":pantalla", $datos["pantalla"], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt->bindParam(":renovo_cuenta", $datos["renovo_cuenta"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":llave", $datos["llave"], PDO::PARAM_STR);
		$stmt->bindParam(":reproductor", $datos["reproductor"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		$stmt->bindParam(":renovo_regresa", $datos["renovo_regresa"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CUENTAS PANTALLAS
	=============================================*/
	static public function mdlMostrarPantalla($tabla, $item, $valor){
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
	MOSTRAR CUENTAS PANTALLAS
	=============================================*/
	static public function mdlMostrarPantallasN($tabla, $item, $valor, $item1, $valor1){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item <= :$item AND $item1 = :$item1");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();	
		$stmt-> close();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR PANTALLA
	=============================================*/
	static public function mdlActualizarPantalla($tabla, $item1, $valor1, $item2, $valor2){
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
	EDITAR PLAN CUENTAS
	=============================================*/
	static public function mdlEditarPantalla($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, fecha_corte = :fecha_corte, costo = :costo, cliente = :cliente, telefono = :telefono, pantalla = :pantalla, pass = :pass, clienteRevendedor = :clienteRevendedor, mac = :mac, llave = :llave, reproductor = :reproductor WHERE renovo_cuenta = :renovo_cuenta");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":pantalla", $datos["pantalla"], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt->bindParam(":clienteRevendedor", $datos["clienteRevendedor"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":llave", $datos["llave"], PDO::PARAM_STR);
		$stmt->bindParam(":reproductor", $datos["reproductor"], PDO::PARAM_STR);
		$stmt->bindParam(":renovo_cuenta", $datos["renovo_cuenta"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	RENOVAR PLAN CUENTAS
	=============================================*/
	static public function mdlRenovarPantalla($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, fecha_corte = :fecha_corte, costo = :costo, cliente = :cliente, telefono = :telefono, pantalla = :pantalla, pass = :pass, renovo_cuenta = :renovo_cuenta, renovo_regresa = :renovo_regresa, mac = :mac, llave = :llave, reproductor = :reproductor WHERE id = :id");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":pantalla", $datos["pantalla"], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":renovo_cuenta", $datos["renovo_cuenta"], PDO::PARAM_STR);
		$stmt->bindParam(":mac", $datos["mac"], PDO::PARAM_STR);
		$stmt->bindParam(":llave", $datos["llave"], PDO::PARAM_STR);
		$stmt->bindParam(":reproductor", $datos["reproductor"], PDO::PARAM_STR);
		$stmt->bindParam(":renovo_regresa", $datos["renovo_regresa"], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	RANGO FECHAS COPIAS
	=============================================*/	
	static public function mdlRangoFechasCuentasPantallas($tabla, $fechaInicial, $fechaFinal){
		if($fechaInicial == null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC LIMIT 0,1000");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}else if($fechaInicial == $fechaFinal){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
			}
		
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}

	/*=============================================
	BORRAR PANTALLA
	=============================================*/
	static public function mdlBorrarPantalla($tabla, $datos){
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