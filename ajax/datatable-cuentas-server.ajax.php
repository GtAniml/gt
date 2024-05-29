<?php

require_once "../controladores/cuentas.controlador.php";
require_once "../modelos/cuentas.modelo.php";

require_once "../controladores/asociar.controlador.php";
require_once "../modelos/asociar.modelo.php";

require_once "../controladores/revendedor.controlador.php";
require_once "../modelos/revendedor.modelo.php";

require_once "../controladores/streaming.controlador.php";
require_once "../modelos/streaming.modelo.php";

// almacenar petición ( es decir , obtener / post) array global a una variable
$requestData= $_REQUEST;

$columns = array( 
// índice de columna tabla de datos = > nombre de la columna de base de datos
    0 => 'id', 
    1 => 'nombre',
    2 => 'correo', 
    3 => 'pin',
    4 => 'valor_pin',
    5 => 'activacion',
    6 => 'facturacion', 
    7 => 'corte',
    8 => 'fecha-termino',
    9 => 'pantallas',
    10 => 'password',
    11 => 'dias-faltantes',
    12 => 'boton-estado',
    13 => 'editar',

);

$tabla ="cuentas";
$where = " ";
$orderBy =" ORDER BY Id ASC";

//Obtener el total de registros sin ninguna búsqueda
$respuesta = ControladorCuentas::allValoresControlador($tabla,$where,$orderBy);
$totalData = count($respuesta);

//Cuando no hay un parámetro de búsqueda el número total de 
//registros filtrados es igual al total de registros.
$totalFiltered = $totalData;

//$where = " WHERE 1=1 AND disponible = 'Si'";
$where = " WHERE 1=1";

//Si hay un parámetro de búsqueda , $RequestData [ 'search '] [ ' valor '] 
//contiene parámetros de búsqueda.
if( !empty($requestData['search']['value']) ) {  
    $where.=" AND ( id LIKE '%".$requestData['search']['value']."%' ";    
    $where.=" OR id_categoria LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR modo_cuenta LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR correo LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR password LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR pin LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR valor_pin LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR codigo LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR activacion LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR facturacion LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR corte LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR pantallas LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR ocupada LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR estado LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR desactivado LIKE '%".$requestData['search']['value']."%' ";
    $where.=" OR fecha LIKE '%".$requestData['search']['value']."%')";
}

//Obtener el total de registros con parámetros.
$respuesta = ControladorCuentas::allValoresControlador($tabla,$where,$orderBy);

//Cuando hay un parámetro de búsqueda, tenemos que
//modificar el total de filas filtradas.
$totalFiltered = count($respuesta);

$orderBy=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

//Obtener el total de registros con parámetros.
//con el orden y filtro especificados.
$respuesta = ControladorCuentas::allValoresControlador($tabla,$where,$orderBy);

$data = array();

if (count($respuesta) > 0){

	foreach ($respuesta as $row => $item){
		date_default_timezone_set("America/Bogota");
        $fecha = date("Y-m-d");
        /*=============================================
	 		FECHAS DÍAS RESTANTES
			=============================================*/
		$fecha1= new DateTime($fecha);
		$fecha2= new DateTime($item["corte"]);
		$diff = $fecha1->diff($fecha2);

		// El resultados sera 3 dias
		if ($item["corte"] < $fecha){
			$diasF = "0 dias";
		}else{
			$diasF = "".$diff->days." días";
		}

        /*=============================================
 		NOMBRE CLIENTE
		=============================================*/
		$item1 = "id";
    	$valor1 = $item["id_categoria"];

    	$streaming = ControladorStreaming::ctrMostrarStreaming($item1, $valor1);

		$nombre = $streaming["nombre"];  			

		/*=============================================
 		CUENTA COMPLETA O PANTALLA
		=============================================*/
		if($item["modo_cuenta"] == 1){
			$pantallas = "<button class='btn btn-info btn-sm'>Completa</button>";
		}else if($item["modo_cuenta"] == 0){
			$pantallas = "<button class='btn btn-warning btn-sm'>Pantallas</button>";
		}else{
			$pantallas = "<button class='btn btn-secondary btn-sm'>Re-vendedor</button>";
		}

		/*=============================================
	 		FECHAS DE CORTE
			=============================================*/
			if($item["modo_cuenta"] == 1){
				$item2 = "id_cuenta";
				$valor2 = $item["id"];

				$asociarfecha = ControladorAsociar::ctrMostrarAsociar($item2, $valor2);

				if($asociarfecha != ""){
					$fechaTC = $asociarfecha["fecha_termino"];
				}else{
					$fechaTC = "0000-00-00";
				}

				
			}else if($item["modo_cuenta"] == 0){
				$fechaTC = "0000-00-00";
			}else if($item["modo_cuenta"] == 2){  				
				$item2 = "id_cuenta";
				$valor2 = $item["id"];

				$revendedorfecha = ControladorRevendedor::ctrMostrarRevendedor($item2, $valor2);

				if($revendedorfecha != ""){
					$fechaTC = $revendedorfecha["fecha_termino"];
				}else{
					$fechaTC = "0000-00-00";
				}  				
			}

		/*=============================================
	 		ESTADO
			=============================================*/
			if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Administrador"){
			if($item["corte"] == "0000-00-00"){
				$buttonEstado = "<button class='btn btn-success btn-sm'>Activada</button>";
			}else if($item["corte"] > $fecha){
				$buttonEstado = "<button class='btn btn-success btn-sm'>Activada</button>";
			}else{
				$buttonEstado = "<button class='btn btn-danger btn-sm btnRenovarCuenta' data-toggle='modal' data-target='#modalRenovarCuenta' idCuenta='".$item["id"]."'>Renovar</button>";
			}
		}else{
			if($item["corte"] > $fecha){
				$buttonEstado = "<button class='btn btn-default btn-sm'>Activada</button>";
			}else{
				$buttonEstado = "<button class='btn btn-default btn-sm'>Desactivada</button>";
			}
		}

        if(isset($_GET["perfilOculto"]) || $_GET["perfilOculto"] == "Administrador" || $_GET["perfilOculto"] == "GAdministrador"){
			$editar = "<div class='btn-group'><button type='button' class='btn btn-success'>Acciones</button><button type='button' class='btn btn-success dropdown-toggle dropdown-icon' data-toggle='dropdown'><span class='sr-only'>Toggle Dropdown</span></button><div class='dropdown-menu' role='menu'><a class='dropdown-item btnEditarCuenta' idCuenta='".$item["id"]."' data-toggle='modal' data-target='#modalEditarCuenta' href=''>Editar Cuenta</a><a class='dropdown-item btnEliminarCuenta' estadoCuenta='1' idCuenta=".$item["id"]." href='#'>Eliminar Cuenta</a></div></div>";
		}else{				
			$editar = "<div class='btn-group pull-right'><button class='btn btn-default'><i class='fa fa-pen'></i> Editar</button></div>";

		}

        $nestedData=array();
    	if($item["desactivado"] != 1){  
	        $nestedData[] = $row+1;
	        $nestedData[] = $nombre; 
	        $nestedData[] = $item['correo'];
	        $nestedData[] = $item['pin']; 
	        $nestedData[] = number_format($item['valor_pin'],2);
	        $nestedData[] = $item['activacion']; 
	        $nestedData[] = $item['facturacion'];
	        $nestedData[] = $item['corte'];
	        $nestedData[] = $fechaTC;
	        $nestedData[] = $pantallas;
	        $nestedData[] = $item['password'];
	        $nestedData[] = $diasF;
	        $nestedData[] = $buttonEstado;
	        $nestedData[] = $editar;
	        $data[] = $nestedData;
	    }
    }
}

$json_data = array(
    "draw"            => intval( $requestData['draw'] ),   
    "recordsTotal"    => intval( $totalData ),  
    "recordsFiltered" => intval( $totalFiltered ),
    "data"            => $data   
    );

echo json_encode($json_data);