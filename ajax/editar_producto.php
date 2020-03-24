<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_codigo'])) {
           $errors[] = "Código vacío";
        } else if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre del producto vacío";
		} else if ($_POST['mod_estado']==""){
			$errors[] = "Selecciona el estado del producto";
		} else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_codigo']) &&
			!empty($_POST['mod_nombre']) &&
			$_POST['mod_estado']!=""
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("..modal/editar_productos.php");
		include_once ("../classes/class.upload.php");
		include ("../classes/options.php");
		include('../funciones.php');
		// escaping, additionally removing everything that could be (html/javascript-) code
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$estado=intval($_POST['mod_estado']);
		
		$id_producto=$_POST['mod_id'];
		
		// Resto de informacion nueva
		$nombrel=$_POST['mod_nombrel'];
		$precio_cost=floatval($_POST['mod_precio_cost']);
		
		//$id_provee=$_POST['mod_id_provee'];
		$id_provee=get_val_null($_POST['mod_id_provee']);
		
		$id_unidad=$_POST['mod_id_unidad'];
		$id_linea=$_POST['mod_id_linea'];
		$id_marca=get_val_null($_POST['mod_id_marca']);
		
		$utili=get_val_null($_POST['mod_utili1']);
		$utili2=get_val_null($_POST['mod_utili2']);
		$utili3=get_val_null($_POST['mod_utili3']);
		$utili4=get_val_null($_POST['mod_utili4']);
		$precio_venta=floatval($_POST['mod_precio1']);
		$precio2=floatval($_POST['mod_precio2']);
		$precio3=floatval($_POST['mod_precio3']);
		$precio4=floatval($_POST['mod_precio4']);
		
		$prod_iva=get_val_checkbox( $_POST['mod_prod_iva'] );
		$prod_invent=get_val_checkbox( $_POST['mod_prod_invent'] );
		
		$stock_min=get_val_null($_POST['mod_stock_min']);
		$invent_ini=get_val_null($_POST['mod_invent_ini']);
		$product_img=$_POST['product_img'];
		
		$img_stat=0;
		
		if(isset($_FILES['product_img']) && !empty( $_FILES["product_img"]["name"] )) {
			$img_stat=1;
			$handle = new Upload($_FILES["product_img"]);
			if($handle->uploaded) {
				  $handle->Process("../uploads/");
				  if($handle->processed){
					  //print "Image well process: ";
					  $product_img = $handle->file_dst_name;
				  }
				} else {
					//print "Image not upload: " . $handle->error;
					$errors[] = "Aviso imagen del producto: " . $handle->error;
				}
				$handle->clean();
		}
		
		//print "img_stat(1) : " . $img_stat;
		if ($img_stat==1) {
			//$sql="UPDATE products SET codigo_producto='".$codigo."', nombre_producto='".$nombre."', status_producto='".$estado."', precio_producto='".$precio_venta."',product_img='".$product_img."' WHERE id_producto='".$id_producto."'";
			$sql="UPDATE products SET codigo_producto='".$codigo."', nombre_producto='".$nombre."', status_producto='".$estado.
				"', precio_producto='".$precio_venta."',product_img='".$product_img."',nombre_producto_l='".$nombrel.
				"',id_provee='".$id_provee."',id_unidad='".$id_unidad."',id_linea='".$id_linea."',id_marca='".$id_marca.
				"',utili='".$utili."',utili2='".$utili2."',utili3='".$utili3."',utili4='".$utili4."',precio2='".$precio2.
				"',precio3='".$precio3."',precio4='".$precio4."',prod_invent='".$prod_invent."',precio_cost='".$precio_cost.
				"',stock_min='".$stock_min."',invent_ini='".$invent_ini."',iva='".$prod_iva."' WHERE id_producto='".$id_producto."'";
			//$answwer="S";
		} else {
			//$sql="UPDATE products SET codigo_producto='".$codigo."', nombre_producto='".$nombre."', status_producto='".$estado."', precio_producto='".$precio_venta."' WHERE id_producto='".$id_producto."'";
			$sql="UPDATE products SET codigo_producto='".$codigo."', nombre_producto='".$nombre.
			"', status_producto='".$estado."', precio_producto='".$precio_venta."',nombre_producto_l='".
			$nombrel."',id_provee='".$id_provee."',id_unidad='".$id_unidad."',id_linea='".$id_linea."',id_marca='"
			.$id_marca."',utili='".$utili."',utili2='".$utili2."',utili3='".$utili3."',utili4='".$utili4.
			"',precio2='".$precio2."',precio3='".$precio3."',precio4='".$precio4."',prod_invent='".$prod_invent.
			"',precio_cost='".$precio_cost."',stock_min='".$stock_min."',invent_ini='".$invent_ini."',iva='".$prod_iva."' WHERE id_producto='".$id_producto."'";
			//$answwer="N";
		}
		
		//print "img_stat(2) : " . $answwer;
		
		$query_update = mysqli_query($con,$sql);
		
		if ($query_update){
				$messages[] = "Producto ha sido actualizado satisfactoriamente.";
				if ($img_stat==1) {
					echo "<script language='javascript'> $('#myImg').attr('src', './uploads/$product_img'); </script>";
				}
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

