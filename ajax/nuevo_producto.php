<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['codigo'])) {
           $errors[] = "Código vacío";
        } else if (empty($_POST['nombre'])){
			$errors[] = "Nombre del producto vacío";
		} else if ($_POST['estado']==""){
			$errors[] = "Selecciona el estado del producto";
		} else if (
			!empty($_POST['codigo']) &&
			!empty($_POST['nombre']) &&
			$_POST['estado']!=""
		) {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include_once ("../classes/class.upload.php");
		include ("../classes/options.php");
		include('../funciones.php');
		// escaping, additionally removing everything that could be (html/javascript-) code
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$estado=intval($_POST['estado']);
		
		// Resto de informacion nueva
		$nombrel=$_POST['nombrel'];
		$precio_cost=floatval($_POST['precio_cost']);
		$id_provee=get_val_null($_POST['id_provee']);
		$id_unidad=$_POST['id_unidad'];
		$id_linea=$_POST['id_linea'];
		$id_marca=get_val_null($_POST['id_marca']);
		$utili=get_val_null($_POST['utili1']);
		$utili2=get_val_null($_POST['utili2']);
		$utili3=get_val_null($_POST['utili3']);
		$utili4=get_val_null($_POST['utili4']);
		$precio_venta=floatval($_POST['precio1']);
		$precio2=$_POST['precio2'];
		$precio3=$_POST['precio3'];
		$precio4=$_POST['precio4'];
		
		//Checkboxs
		$prod_invent=get_val_checkbox( $_POST['prod_invent'] );
		$stock_min=get_val_null($_POST['stock_min']);
		$prod_iva=get_val_checkbox( $_POST['prod_iva'] );
		
		$invent_ini=get_val_null($_POST['invent_ini']);
		//if (isset($_POST['stock_min'])){$stock_min=$_POST['stock_min'];}{$stock_min=0;}
		//if (isset($_POST['invent_ini'])){$invent_ini=$_POST['invent_ini'];}{$invent_ini=0;}
		$date_added=date("Y-m-d H:i:s");
		$product_img=$_POST['product_img'];
		
		$img_stat=0;
		if(isset($_FILES['product_img']) && !empty( $_FILES["product_img"]["name"] )) {
			$img_stat=1;
			$handle = new Upload($_FILES["product_img"]);
			if($handle->uploaded) {
				  $handle->Process("../uploads/");
				  if($handle->processed){
					  $product_img = $handle->file_dst_name;
				  }
				} else {
					//print "Image not upload: " . $handle->error;
					$errors[] = "Aviso imagen del producto: " . $handle->error;
				}
				$handle->clean();
		}
		
		if ($img_stat==1) {
			$query1 = "INSERT INTO products (codigo_producto, nombre_producto, status_producto, date_added, precio_producto, 
			product_img, nombre_producto_l, id_provee, id_unidad, id_linea, id_marca, utili, utili2, utili3, utili4,
			prod_invent, precio_cost, precio2, precio3, precio4, stock_min, invent_ini, iva) VALUES ('$codigo','$nombre',
			'$estado','$date_added','$precio_venta','$product_img','$nombrel','$id_provee','$id_unidad','$id_linea',
			'$id_marca','$utili','$utili2','$utili3','$utili4','$prod_invent','$precio_cost','$precio2','$precio3',
			'$precio4','$stock_min','$invent_ini','$prod_iva' )";
		} else {
			$query1 = "INSERT INTO products (codigo_producto, nombre_producto, status_producto, date_added, 
			precio_producto, nombre_producto_l, id_provee, id_unidad, id_linea, id_marca, utili, utili2, utili3,
			utili4, prod_invent, precio_cost, precio2, precio3, precio4, stock_min, invent_ini, iva) VALUES 
			('$codigo','$nombre','$estado','$date_added','$precio_venta','$nombrel','$id_provee','$id_unidad',
			'$id_linea','$id_marca','$utili','$utili2','$utili3','$utili4','$prod_invent','$precio_cost','$precio2',
			'$precio3','$precio4','$stock_min','$invent_ini','$prod_iva' )";
		}
		
		$qry_insert=mysqli_multi_query($con, $query1);
		if ($qry_insert) {
				$messages[] = "Producto ha sido ingresado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Productos ".mysqli_error($con);
				//header("location: /modal/registro_productos");
				
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
				exit;
			}
		
		
		//Se recupera el numero de factura insertado
		$query2=mysqli_query($con, "select LAST_INSERT_ID(id_producto) as last from products order by id_producto desc limit 0,1 ");
		$rw=mysqli_fetch_array($query2);
		$id_producto=$rw['last'];
	
		if ($prod_invent==1) {	// Importante solo si el product es inventariable se realizan los procesos
		
			// Registro al inventario de la cantida inicial al registro del nuevo producto
			$user_id = intval( $_SESSION['user_id'] );
			$query3 = "INSERT INTO inventory (id_product, id_user, date_added, comment, id_location, cant_inventory ) 
			VALUES ('$id_producto', '$user_id', '$date_added', 'Edicion Manual de Cantidad', 1, '$invent_ini' )";

			$qry_insert=mysqli_multi_query($con, $query3);
			if ($qry_insert) {
					//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
				} else {
					$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Inventario ".mysqli_error($con);
				}
		
		
			// Registro a la bitacora de cantidades
			$query4 = "INSERT INTO cant_products (id_product, id_location, cantidad ) VALUES ('$id_producto', 1, '$invent_ini' )";
			$qry_insert=mysqli_multi_query($con, $query4);
			if ($qry_insert) {
					//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
				} else {
					$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: cant_products ".mysqli_error($con);
				}
			}
	
	
		} else {
			$errors []= "Error desconocido.";
		}

		
		// Revision de los errores encontrados

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