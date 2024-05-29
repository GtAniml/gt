<?php

require_once "conexion.php";

class ModeloCombos{
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function mdlMostrarCombos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC LIMIT 0,1000");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	REGISTRO DE COMBO
	=============================================*/
	static public function mdlIngresarCombo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre_combo, telefono, cliente, productos, precio, fecha_inicio, fecha_final, codigo, ref_id, fecha) VALUES (:nombre_combo, :telefono, :cliente, :productos, :precio, :fecha_inicio, :fecha_final, :codigo, :ref_id  :fecha)");

		$stmt->bindParam(":nombre_combo", $datos["nombre_combo"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
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
	REGISTRO DE COMBO COPIA
	=============================================*/
	static public function mdlIngresarComboC($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre_combo, telefono, cliente, productos, precio, fecha_inicio, fecha_final, codigo, fecha) VALUES (:nombre_combo, :telefono, :cliente, :productos, :precio, :fecha_inicio, :fecha_final, :codigo, :fecha)");

		$stmt->bindParam(":nombre_combo", $datos["nombre_combo"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
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
	EDITAR VENTA
	=============================================*/
	static public function mdlEditarCombo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  nombre_combo = :nombre_combo, telefono = :telefono, cliente = :cliente, productos = :productos, precio = :precio, fecha_inicio = :fecha_inicio, fecha_final= :fecha_final WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_combo", $datos["nombre_combo"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR VENTA COPIA
	=============================================*/
	static public function mdlEditarComboC($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  nombre_combo = :nombre_combo, telefono = :telefono, cliente = :cliente, productos = :productos, precio = :precio, fecha_inicio = :fecha_inicio, fecha_final= :fecha_final WHERE codigo = :codigo");

		$stmt->bindParam(":nombre_combo", $datos["nombre_combo"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	RENOVAR COMBO
	=============================================*/
	static public function mdlRenovarCombo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  nombre_combo = :nombre_combo, telefono = :telefono, cliente = :cliente, productos = :productos, precio = :precio, fecha_inicio = :fecha_inicio, fecha_final= :fecha_final, codigo= :codigo WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_combo", $datos["nombre_combo"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);

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
	static public function mdlRangoFechasCuentasCombos($tabla, $fechaInicial, $fechaFinal){
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
	BORRAR COMBO
	=============================================*/
	static public function mdlBorrarCombo($tabla, $datos){
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

	/*=============================================
	EDITAR VENTA REVENDEDOR
	=============================================*/
	static public function mdlEditarComboReven($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  nombre_combo = :nombre_combo, productos = :productos, precio = :precio, fecha_final= :fecha_final, clienteRevendedor= :clienteRevendedor WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_combo", $datos["nombre_combo"], PDO::PARAM_STR);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_final", $datos["fecha_final"], PDO::PARAM_STR);
		$stmt->bindParam(":clienteRevendedor", $datos["clienteRevendedor"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}

		$stmt->close();
		$stmt = null;
	}
}