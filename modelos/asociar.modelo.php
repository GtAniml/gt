<?php
require_once "conexion.php";

class ModeloAsociar{
	/*=============================================
	REGISTRO DE ASOCIACIÓN
	=============================================*/
	static public function mdlRegistroAsociacion($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cuenta, fecha_corte, fecha_termino, precio, nombre_cliente, telefono, codigo, iptv, ref_id, fecha) VALUES (:id_cuenta, :fecha_corte, :fecha_termino, :precio, :nombre_cliente, :telefono, :codigo, :iptv, :ref_id, :fecha)");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":iptv", $datos["iptv"], PDO::PARAM_STR);
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
	REGISTRO DE ASOCIACIÓN COPIA
	=============================================*/
	static public function mdlRegistroAsociacionC($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cuenta, fecha_corte, fecha_termino, precio, nombre_cliente, telefono, codigo, fecha) VALUES (:id_cuenta, :fecha_corte, :fecha_termino, :precio, :nombre_cliente, :telefono, :codigo, :fecha)");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
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
	MOSTRAR CUENTAS ASOCIADAS
	=============================================*/
	static public function mdlMostrarAsociar($tabla, $item, $valor){
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
	EDITAR ASOCIAR CUENTAS
	=============================================*/
	static public function mdlEditarAsociacion($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_cliente = :nombre_cliente, telefono = :telefono WHERE id = :id");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
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
	EDITAR ASOCIAR CUENTAS COPIA
	=============================================*/
	static public function mdlEditarAsociacionC($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_cliente = :nombre_cliente, telefono = :telefono WHERE codigo = :codigo");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
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
	RENOVAR ASOCIAR CUENTAS
	=============================================*/
	static public function mdlRenovarAsociacion($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_cliente = :nombre_cliente, telefono = :telefono, codigo = :codigo WHERE id = :id");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
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
	RANGO FECHAS COPIAS
	=============================================*/	
	static public function mdlRangoFechasCuentasCompletas($tabla, $fechaInicial, $fechaFinal){
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
	MOSTRAR CUENTAS ASOCIADAS PARA INICIO
	=============================================*/
	static public function mdlMostrarAsociarCuentaCompleta($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC LIMIT 0,20");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC LIMIT 0,20");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}		
		$stmt-> close();
		$stmt = null;
	}

	/*=============================================
	BORRAR ASOCIACION
	=============================================*/
	static public function mdlBorrarAsociacion($tabla, $datos){
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
	EDITAR ASOCIAR CUENTAS IPTV
	=============================================*/
	static public function mdlEditarAsociacionIptv($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_cliente = :nombre_cliente, telefono = :telefono, iptv = :iptv WHERE id = :id");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":iptv", $datos["iptv"], PDO::PARAM_STR);
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
	RENOVAR ASOCIAR CUENTAS
	=============================================*/
	static public function mdlRenovarAsociacionIptv($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cuenta = :id_cuenta, fecha_termino = :fecha_termino, precio = :precio, nombre_cliente = :nombre_cliente, telefono = :telefono, codigo = :codigo, iptv = :iptv WHERE id = :id");

		$stmt->bindParam(":id_cuenta", $datos["id_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_termino", $datos["fecha_termino"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_cliente", $datos["nombre_cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":iptv", $datos["iptv"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}
}