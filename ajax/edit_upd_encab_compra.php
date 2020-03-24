<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$id_factura= $_SESSION['id_factura'];
	/*Inicia validacion del lado del servidor*/

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");
		// escaping, additionally removing everything that could be (html/javascript-) code
		
		/*
		$cpr=0;
		foreach ($_POST as $param_name => $param_val) {
			echo "Param: $param_name; Value: $param_val<br />\n";
			$cpr++;
		}
		*/
		
			//Paso V Guardar encabezado insert compras
		$insert_compra = mysqli_query($con, "INSERT INTO compras VALUES 
		(default, '$id_prove', '$id_locat', '$num_fact', '$pedido', '$fecha_fact', '$plazo_pago_dias', 
		'$fecha_fact_venc', '$metodo_pago', '$forma_pago', '$cargo_envio_fact', '$cargo_externo_flete', 
		'$desc1', '$desc2', '$total_factura' )");
	
		if ($insert_compra) {
			//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
		} else {
			$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Insert compras ".mysqli_error($con);
		}

		
		
		$query_update = mysqli_query($con,$sql);
		if ($query_update){
			$messages[] = "Documento ha sido actualizado satisfactoriamente.";
		} else{
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
		if (isset($messages)){
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