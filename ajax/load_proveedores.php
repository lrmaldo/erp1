<?PHP
	
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		
	$sql_prove=mysqli_query($con,"select id_prove,nombre_prove from proveedores");
	
	//$numero_filas = mysql_num_rows($sql_prove);

	$i=1;
	while ($rw=mysqli_fetch_array($sql_prove)){
		$output[] = array('id_prove' => $rw['id_prove'][$i], 'nombre_prove' => $rw['nombre_prove'][$i]);
		$i++;
	}
	
	//for($i=0;$i < $rw=mysqli_fetch_array($sql_prove);$i++) {
	//	$output[] = array('id_prove' => $rw['id_prove'][$i], 'nombre_prove' => $rw['nombre_prove'][$i]);
	//}

	echo json_encode($output);

?>