<?php

class Conexion{
	static public function conectar(){
		$link = new PDO("mysql:host=localhost;dbname=tt_adm",
			            "tt_adm",
			            "a*sx4IlC+;j{");
		$link->exec("set names utf8");
		return $link;
	}
}