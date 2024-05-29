<?php
require_once "conexion.php";

class ModeloRevendedor{
	/*=============================================
	REGISTRO DE REVENDEDOR
	=============================================*/
	static public function mdlRegistroRevendedor($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cuenta, fecha_corte, fecha_termino, precio, nombre_revendedor, codigo, fecha) VALUES (:id_cuenta, :fecha_corte, :fecha_termino, :precio, :nombre_revendedor, :codigo, :fecha)");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_revendedor", $datos["nombre_revendedor"], PDO::PARAM_STR);
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
	REGISTRO DE REVENDEDOR COPIA
	=============================================*/
	static public function mdlRegistroRevendedorC($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cuenta, fecha_corte, fecha_termino, precio, nombre_revendedor, codigo) VALUES (:id_cuenta, :fecha_corte, :fecha_termino, :precio, :nombre_revendedor, :codigo)");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_revendedor", $datos["nombre_revendedor"], PDO::PARAM_STR);
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
	MOSTRAR CUENTAS REVENDEDOR
	=============================================*/
	static public function mdlMostrarRevendedor($tabla, $item, $valor){
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
	EDITAR REVENDEDOR DE CUENTAS
	=============================================*/
	static public function mdlEditarRevendedor($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_revendedor = :nombre_revendedor,  cliente = :cliente WHERE codigo = :codigo");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_revendedor", $datos["nombre_revendedor"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	EDITAR REVENDEDOR DE CUENTAS COPIA
	=============================================*/
	static public function mdlEditarRevendedorC($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_revendedor = :nombre_revendedor WHERE codigo = :codigo");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_revendedor", $datos["nombre_revendedor"], PDO::PARAM_STR);
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
	static public function mdlRangoFechasCuentasRevendedor($tabla, $fechaInicial, $fechaFinal){
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
	RENOVAR REVENDEDOR DE CUENTAS
	=============================================*/
	static public function mdlRenovarRevendedor($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_revendedor = :nombre_revendedor, codigo = :codigo WHERE id = :id");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_revendedor", $datos["nombre_revendedor"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	BORRAR REVENDEDOR
	=============================================*/
	static public function mdlBorrarRevendedor($tabla, $datos){
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