<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])){
			$errors[] = "Nombre de la unidad vacía";
		} else if (
			!empty($_POST['nombre'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		//include("..modal/editar_unidades.php");
		
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		
		$sql="INSERT INTO unidades (id_unidad,nombre_unidad) VALUES (default,'$nombre')";
		$query_update = mysqli_query($con,$sql);
		
		$myfile = fopen("../uploads/newfile.txt", "w") or die("Unable to open file!");
		$txt = "John Doe\n";
		fwrite($myfile, $txt);
		$txt = "Jane Doe\n";
		fwrite($myfile, $txt);
		fclose($myfile);
		
		
			if ($query_update){
				$messages[] = "Unidad ha sido agregada satisfactoriamente.";
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
