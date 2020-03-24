<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        }  else if ($_POST['mod_estatus']==""){
			$errors[] = "Selecciona el estatus del cliente";
		}  else if (
			!empty($_POST['mod_id']) && 
			!empty($_POST['mod_nombre']) && 
			$_POST['mod_estatus']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include('../funciones.php');
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefono"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["mod_email"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion"],ENT_QUOTES)));
		$estatus=intval($_POST['mod_estatus']);
		
		/* Nuevos campos */
		$ape_pat_clie=$_POST['mod_ape_pat_clie'];
		$ape_mat_clie=$_POST['mod_ape_mat_clie'];
		$col_clie=$_POST['mod_col_clie'];
		$cp_clie=$_POST['mod_cp_clie'];
		$ciudad_clie=$_POST['mod_ciudad_clie'];
		$estado_clie=$_POST['mod_estado_clie'];
		$pais_clie=$_POST['mod_pais_clie'];
		$tipo_clie=$_POST['mod_tipo_clie'];
		$rfc_clie=$_POST['mod_rfc_clie'];
		$tipo_prec_clie=intval( $_POST['mod_tipo_prec_clie'] );
		$lim_cred_clie=get_val_null( $_POST['mod_lim_cred_clie'] );
		$act_cred_clie=get_val_checkbox( $_POST['mod_act_cred_clie'] );
		//floatval
		
		$id_cliente=intval($_POST['mod_id']);
		//$sql="UPDATE clientes SET nombre_cliente='".$nombre."', telefono_cliente='".$telefono."', email_cliente='".$email."', direccion_cliente='".$direccion."', status_cliente='".$estatus."' WHERE id_cliente=".$id_cliente;
		
		$sql="UPDATE clientes SET nombre_cliente='".$nombre."', telefono_cliente='".$telefono."', email_cliente='".$email."', direccion_cliente='".$direccion."', status_cliente='".$estatus.
		"', ape_pat_cliente='".$ape_pat_clie."', ape_mat_cliente='".$ape_mat_clie."', col_cliente='".$col_clie.
		"', cp_cliente='".$cp_clie."', ciudad_cliente='".$ciudad_clie."', estado_cliente='".$estado_clie."', pais_cliente='".$pais_clie.
		"', tipo_cliente='".$tipo_clie."',rfc_cliente='".$rfc_clie."',tipo_prec_cliente='".$tipo_prec_clie.
		"', lim_cred_cliente='".$lim_cred_clie."', act_cred_cliente='".$act_cred_clie."' WHERE id_cliente='".$id_cliente."'";
		
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Cliente ha sido actualizado satisfactoriamente.";
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