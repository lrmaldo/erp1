<?php
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	/*Inicia validacion del lado del servidor*/
	$data1=$_POST['data1']; //email
	$data2=$_POST['data2'];	//tel
	$data3=$_POST['data3'];	//nombre y apell
	$data4=$_POST['data4'];	//fecha cumpleaños
	$data5=$_POST['data5'];	//genero
	$data6 = date("Y-m-d H:i:s"); //fecha actual automatico
	$data7=$_POST['data7'];	//Localidad

	$return_arr = array();
	//$list = array();

	/* Connect To Database*/
	//require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	//require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		
	// escaping, additionally removing everything that could be (html/javascript-) code
	//$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		
	//$sql="INSERT INTO post_data (id_posta_data,data1,data2) VALUES (default,'$data1','$data2')";
	//$query_update = mysqli_query($con,$sql);

	//$myfile = fopen("../uploads/mikrotik.txt", "w") or die("Unable to open file!");
	if ($data7=="pv") {
		$myfile = fopen("/var/www/sattlink.mx/public_html/descargas/playa-vicente/mikrotik.txt", "a") or die("Unable to open file!");
	} elseif ($data7=="jd")  {
		$myfile = fopen("/var/www/sattlink.mx/public_html/descargas/jalapa-diaz/mikrotik.txt", "a") or die("Unable to open file!");
	} elseif ($data7=="sl")  {
		$myfile = fopen("/var/www/sattlink.mx/public_html/descargas/sattlink/mikrotik.txt", "a") or die("Unable to open file!");
	}
	
	$txt = $data1 . "|" . $data2 . "|" . $data3 . "|" . $data4 . "|" . $data5 . "|" . $data6 . "\r\n";
	fwrite($myfile, $txt . PHP_EOL);
	fclose($myfile);

	$list = array(
    "title" => "well",
    "author" => "Ing.Elio Mojica",
    "edition" => 1
	);

	//array_push($return_arr,$list);
	//echo json_encode($return_arr,$list);

	echo json_encode($list,JSON_PRETTY_PRINT);
?>
