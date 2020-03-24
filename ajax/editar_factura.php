<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$id_factura= $_SESSION['id_factura'];
	/*Inicia validacion del lado del servidor*/

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");
		// escaping, additionally removing everything that could be (html/javascript-) code
		
		$cpr=0;
		foreach ($_POST as $param_name => $param_val) {
			//echo "Param: $param_name; Value: $param_val<br />\n";
			$cpr++;
		}

		$id_cliente=intval($_POST['id_cliente']);
		$nombre_cliente=$_POST['nombre_cliente'];
		$tel1=$_POST['tel1'];
		$mail=$_POST['mail'];
		$id_vendedor=intval($_POST['id_vendedor']);
		$fecha_doc=$_POST['fecha_doc'];
		$condiciones=intval($_POST['condiciones']);
		$estado_factura=intval($_POST['estado_factura']);
		
		//New Membresia
		$opt_membre=$_POST['opt_membre'];
		for($i = 0; $i < sizeof($opt_membre); $i++) {
			$item_membre .=  $opt_membre[$i] . ',';
		}

		//New customer foraneo
		$dire_clie_fora=$_POST['direcc'];
		$col_clie_fora=$_POST['colonia'];
		$ciu_clie_fora=$_POST['ciudad'];
		$rfc_clie_fora=$_POST['rfc'];
		//End customer foraneo

		$id_foraneo_cliente=get_row('perfil','numeracion_cliente_foraneo', 'id_perfil', 1);

		if($id_cliente==0) {
			$id_cliente=$id_foraneo_cliente;
		} else if($id_cliente<>$id_foraneo_cliente) {
			$nombre_cliente="";
			$tel1="";
			$mail="";
			//New customer foraneo
			$dire_clie_fora="";
			$col_clie_fora="";
			$ciu_clie_fora="";
			$rfc_clie_fora="";
		}

		if($cpr > 9) {
			$sql="UPDATE facturas SET id_cliente='".$id_cliente."', id_vendedor='".$id_vendedor."', 
			fecha_factura='".$fecha_doc."',
			condiciones='".$condiciones."', estado_factura='".$estado_factura."',cliente_foraneo='".$nombre_cliente.
			"',tel_cliente_foraneo='".$tel1."', email_cliente_foraneo='".$mail."', direccion_cliente_foraneo='".$dire_clie_fora.
			"', col_cliente_foraneo='".$col_clie_fora."', ciudad_cliente_foraneo='".$ciu_clie_fora."', rfc_cliente_foraneo='".$rfc_clie_fora.
			"', membresias_selections='" . $item_membre . "' WHERE id_factura='".$id_factura."'";
			$flag="> 9";
		} else if($cpr==2) {
			$sql="UPDATE facturas SET estado_factura='".$estado_factura."' WHERE id_factura='".$id_factura."'";
			$flag="2";
		} else if($cpr==8 or $cpr==9 ) {
			$sql="UPDATE facturas SET estado_factura='".$estado_factura."',tel_cliente_foraneo='".$tel1.
				"', email_cliente_foraneo='".$mail."', direccion_cliente_foraneo='".$dire_clie_fora.
				"', col_cliente_foraneo='".$col_clie_fora."', ciudad_cliente_foraneo='".$ciu_clie_fora.
				"', rfc_cliente_foraneo='".$rfc_clie_fora."', membresias_selections='".$item_membre.
				"' WHERE id_factura='".$id_factura."'";
			$flag="8,9";
		} else if($cpr==5 or $cpr==6 ) {	// Clientes registrados
			$sql="UPDATE facturas SET id_cliente='".$id_cliente."', id_vendedor='".$id_vendedor."', 
			condiciones='".$condiciones."', estado_factura='".$estado_factura."', membresias_selections='" . $item_membre . "' WHERE id_factura='".$id_factura."'";
			$flag="5,6";
		} else if($cpr==3 or $cpr==4 ) {	// Clientes foraneos
			$sql="UPDATE facturas SET estado_factura='".$estado_factura."', membresias_selections='" . $item_membre . "' WHERE id_factura='".$id_factura."'";
			$flag="3,4";
		}

		//echo "Flag: ". $flag;
		
		$query_update = mysqli_query($con, $sql);

		if ($query_update) {
			$messages[] = "Documento ha sido actualizado satisfactoriamente.";
		} else {
			$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
		}
		
		if (isset($errors)) {
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
							echo $error;
						}
						?>
			</div>
			<?php
		}
		if (isset($messages)) {
			?>
			<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Bien hecho!</strong>
					<?php
						foreach ($messages as $message) {
							echo $message;
						}
					?>
				</div>
			<?php
			}

?>