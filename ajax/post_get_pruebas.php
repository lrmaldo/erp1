<?php
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	//Variables por GET
	$data = $_GET["result"];
	$data = json_decode("$data", true);
	
	$return_arr = array();

	/* Connect To Database*/
	//require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	//require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	// escaping, additionally removing everything that could be (html/javascript-) code
	//$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
	//$sql="INSERT INTO post_data (id_posta_data,data1,data2) VALUES (default,'$data1','$data2')";
	//$query_update = mysqli_query($con,$sql);


	$list = array(
    "data1" => $data['id_cliente'],
    "data2" => $data['id_vendedor']
	);

	//array_push($return_arr,$list);
	//echo json_encode($return_arr,$list);

	echo json_encode($list,JSON_PRETTY_PRINT);
?>
