<?php
require_once "conexion.php";

class ModeloCuentas{
	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	static public function mdlRegistroCuentas($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, modo_cuenta, correo, password, pin, valor_pin, codigo, activacion, facturacion, corte, pantallas, estado) VALUES (:id_categoria, :modo_cuenta, :correo, :password, :pin, :valor_pin, :codigo, :activacion, :facturacion, :corte, :pantallas, :estado)");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":modo_cuenta", $datos["modo_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":pin", $datos["pin"], PDO::PARAM_STR);
		$stmt->bindParam(":valor_pin", $datos["valor_pin"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":activacion", $datos["activacion"], PDO::PARAM_STR);
		$stmt->bindParam(":facturacion", $datos["facturacion"], PDO::PARAM_STR);
		$stmt->bindParam(":corte", $datos["corte"], PDO::PARAM_STR);
		$stmt->bindParam(":pantallas", $datos["pantallas"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	REGISTRO DE CUENTAS
	=============================================*/
	static public function mdlRegistroCuentasR($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, modo_cuenta, correo, password, pin, valor_pin, codigo, facturacion, pantallas) VALUES (:id_categoria, :modo_cuenta, :correo, :password, :pin, :valor_pin, :codigo, :facturacion, :pantallas)");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":modo_cuenta", $datos["modo_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":pin", $datos["pin"], PDO::PARAM_STR);
		$stmt->bindParam(":valor_pin", $datos["valor_pin"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":facturacion", $datos["facturacion"], PDO::PARAM_STR);
		$stmt->bindParam(":pantallas", $datos["pantallas"], PDO::PARAM_STR);


		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CUENTAS
	=============================================*/
	static public function mdlMostrarCuentas($tabla, $item, $valor){
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
	MOSTRAR CUENTAS
	=============================================*/
	static public function mdlMostrarCuentasFull($tabla, $item, $valor, $orden){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC LIMIT 0,1000");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}		
		$stmt-> close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CUENTAS RESPALDO
	=============================================*/
	static public function mdlMostrarCuentasR($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC LIMIT 0,1000");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}		
		$stmt-> close();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR CUENTA
	=============================================*/
	static public function mdlActualizarCuenta($tabla, $item1, $valor1, $item2, $valor2, $item3, $valor3){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1, $item3 = :$item3 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR CUENTAS
	=============================================*/
	static public function mdlEditarCuentas($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, modo_cuenta = :modo_cuenta, correo = :correo, password = :password, pin = :pin, valor_pin = :valor_pin, activacion = :activacion, facturacion = :facturacion, corte = :corte, pantallas = :pantallas, ocupada = :ocupada WHERE codigo = :codigo");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":modo_cuenta", $datos["modo_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":pin", $datos["pin"], PDO::PARAM_STR);
		$stmt->bindParam(":valor_pin", $datos["valor_pin"], PDO::PARAM_STR);
		$stmt->bindParam(":activacion", $datos["activacion"], PDO::PARAM_STR);
		$stmt->bindParam(":facturacion", $datos["facturacion"], PDO::PARAM_STR);
		$stmt->bindParam(":corte", $datos["corte"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":pantallas", $datos["pantallas"], PDO::PARAM_STR);
		$stmt->bindParam(":ocupada", $datos["ocupada"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";		
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	EDITAR CUENTAS
	=============================================*/
	static public function mdlEditarCuentasR($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, modo_cuenta = :modo_cuenta, correo = :correo, password = :password, pin = :pin, valor_pin = :valor_pin, activacion = :activacion, facturacion = :facturacion, corte = :corte, pantallas = :pantallas, estado = :estado WHERE codigo = :codigo");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":modo_cuenta", $datos["modo_cuenta"], PDO::PARAM_INT);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":pin", $datos["pin"], PDO::PARAM_STR);
		$stmt->bindParam(":valor_pin", $datos["valor_pin"], PDO::PARAM_STR);
		$stmt->bindParam(":activacion", $datos["activacion"], PDO::PARAM_STR);
		$stmt->bindParam(":facturacion", $datos["facturacion"], PDO::PARAM_STR);
		$stmt->bindParam(":corte", $datos["corte"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":pantallas", $datos["pantallas"], PDO::PARAM_STR);
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
	EDITAR CUENTA OCUPADA
	=============================================*/
	static public function mdlEditarOcupada($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ocupada = :ocupada WHERE id = :id");

		$stmt->bindParam(":ocupada", $datos["ocupada"], PDO::PARAM_STR);
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
	RESTAR PANTALLA A CUENTA
	=============================================*/
	static public function mdlEditarPantalla($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET pantallas = :pantallas WHERE id = :id");

		$stmt->bindParam(":pantallas", $datos["pantallas"], PDO::PARAM_STR);
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
	ACTUALIZAR CUENTA
	=============================================*/
	static public function mdlActualizarCuentaP($tabla, $item1, $valor1, $item2, $valor2){
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
	DESACTIVAR CUENTA 
	=============================================*/
	static public function mdlActualizarCuentaPC($tabla, $item1, $valor1, $item2, $valor2){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR PRODUCTO
	=============================================*/
	static public function mdlActualizarCuentaC($tabla, $item1, $valor1, $valor){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CUENTAS
	=============================================*/
	static public function mdlMostrarCuentasRegistro($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC LIMIT 0,1000");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}		
		$stmt-> close();
		$stmt = null;
	}

	/*=============================================
	RENOVAR CUENTA REVENDEDOR PONER OCUPADO
	=============================================*/
	static public function mdlRenovarOcupada($tabla1, $item1, $valor1, $item2, $valor2){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla1 SET $item1 = :$item1 WHERE $item2 = :$item2");
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
	DESACTIVAR CUENTA
	=============================================*/
	static public function mdlActualizarCuentaD($tabla, $item1, $valor1, $item2, $valor2){
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

	#LISTAR  LOS REGISTROS SOLICITADO POR EL CLIENTE.
	#-----------------------------------------------------------
	static public function allValoresModelo($tabla,$where,$orderBy){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla $where $orderBy");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
		$stmt = null;
	}
}