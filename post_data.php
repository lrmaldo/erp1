<?php
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	/*Inicia validacion del lado del servidor*/
		$data1=$_GET['data1'])
		$data2=$_GET['data2'])
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		
		// escaping, additionally removing everything that could be (html/javascript-) code
		//$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		
		$sql="INSERT INTO post_data (id_posta_data,data1,data2) VALUES (default,'$data1','$data2')";
		$query_update = mysqli_query($con,$sql);

		$myfile = fopen("uploads/newfile.txt", "w") or die("Unable to open file!");
		$txt = "John Doe\n";
		fwrite($myfile, $txt);
		$txt = "Jane Doe\n";
		fwrite($myfile, $txt);
		fclose($myfile);

?>
