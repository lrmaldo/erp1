<?php
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	/*Inicia validacion del lado del servidor*/
	$data = $_REQUEST["data"];
	$data = json_decode($data, true);

	$data=$data['tipo_doc'] . "|" . intval($data['id_cliente']) . "|" . intval($data['id_vendedor']) . "|" . $data['datoc1'] . "|" . $data['datoc2'] . "|" . $data['datoc3'] . "|" . $data['datoc4'];
	$myfile = fopen("/var/www/sattlink.mx/public_html/descargas/playa-vicente/prueba.txt", "a") or die("Unable to open file!");
	$txt = $data  . "\r\n";
	fwrite($myfile, $txt . PHP_EOL);
	fclose($myfile);

	$list = array(
    "title" => "well",
    "author" => "Ing.Elio Mojica",
    "edition" => 1
	);

	echo json_encode($list,JSON_PRETTY_PRINT);
?>
