<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        } else if (!empty($_POST['nombre'])){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include('../funciones.php');
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$estatus=intval($_POST['estatus']);
		$date_added=date("Y-m-d H:i:s");
		
		/* Nuevos campos */
		$ape_mat=$_POST['ape_mat'];
		$ape_pat=$_POST['ape_pat'];
		$col_clie=$_POST['col_clie'];
		$cp_clie=$_POST['cp_clie'];
		$ciudad_clie=$_POST['ciudad_clie'];
		$estado_clie=$_POST['estado_clie'];
		$pais_clie=$_POST['pais_clie'];
		$tipo_clie=$_POST['tipo_clie'];
		$rfc_clie=$_POST['rfc_clie'];
		$tipo_prec_clie=$_POST['tipo_prec_clie'];
		$lim_cred_clie=get_val_null( $_POST['lim_cred_clie'] );
		$act_cred_clie=get_val_checkbox( $_POST['act_cred_clie'] );
		
		$sql="INSERT INTO clientes (nombre_cliente, telefono_cliente, email_cliente, direccion_cliente, status_cliente,
		date_added, ape_pat_cliente, ape_mat_cliente, col_cliente, cp_cliente, ciudad_cliente, estado_cliente, pais_cliente,
		tipo_cliente, rfc_cliente, tipo_prec_cliente, lim_cred_cliente, act_cred_cliente ) 
		VALUES ('$nombre','$telefono','$email','$direccion','$estatus','$date_added','$ape_pat','$ape_mat','$col_clie','$cp_clie',
		'$ciudad_clie','$estado_clie','$pais_clie','$tipo_clie','$rfc_clie','$tipo_prec_clie','$lim_cred_clie','$act_cred_clie' )";
		
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Cliente ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div style="position: fixed; bottom: 30px;" class="alert alert-danger" id="alert1" role="alert">
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
				<div style="position: fixed; bottom: 30px;" class="alert alert-success" id="alert2" role="alert">
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