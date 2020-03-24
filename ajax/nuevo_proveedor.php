<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        } else if (!empty($_POST['nombre'])) {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include('../funciones.php');
		
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$rfc_prove=$_POST['rfc_prove'];
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$col_prove=$_POST['col_prove'];
		$cp_prove=$_POST['cp_prove'];
		$ciudad_prove=$_POST['ciudad_prove'];
		$estado_prove=$_POST['estado_prove'];
		$tele1_prove=mysqli_real_escape_string($con,(strip_tags($_POST["tele1_prove"],ENT_QUOTES)));
		$tele2_prove=mysqli_real_escape_string($con,(strip_tags($_POST["tele2_prove"],ENT_QUOTES)));
		$email_prove=mysqli_real_escape_string($con,(strip_tags($_POST["email_prove"],ENT_QUOTES)));
		$rl_prove=mysqli_real_escape_string($con,(strip_tags($_POST["rl_prove"],ENT_QUOTES)));
		$saldo_prove=get_val_null( $_POST['saldo_prove'] );
		$dias_cred_prove=get_val_null( $_POST['dias_cred_prove'] );
		//$date_added=date("Y-m-d H:i:s");
		
		/*
		foreach ($_POST as $param_name => $param_val) {
			echo "Param: $param_name; Value: $param_val<br />\n";
		}
		*/
		
		$sql="INSERT INTO proveedores (nombre_prove, rfc_prove, tel1_prove, tel2_prove, direccion_prove, colonia_prove, cp_prove, ciudad_prove, estado_prove, email_prove, represe_legal_prove, saldo_prove, dias_cred_prove) 
		VALUES ('$nombre','$rfc_prove','$tele1_prove','$tele2_prove','$direccion','$col_prove','$cp_prove','$ciudad_prove','$estado_prove','$email_prove','$rl_prove','$saldo_prove','$dias_cred_prove')";
		
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Proveedor ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" id="alert1" role="alert">
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
				<div class="alert alert-success" id="alert2" role="alert">
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