<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
	$id_factura= $_SESSION['id_factura'];
	//numero_docum=intval($_POST['numero_docum']);
	$numero_docum=$_POST['numero_docum'];
		
	/* Connect To Database */
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$sql_seek_and_lock=mysqli_query( $con, "select * from facturas where id_factura = '$id_factura' LOCK IN SHARE MODE" );
	$sql="UPDATE facturas SET tipo_doc=1, cerrada=1 WHERE id_factura='".$id_factura."'";
	$query_update = mysqli_query($con, $sql);
	
	if ($query_update){
		$messages[] = "Documento ha sido actualizado satisfactoriamente de Cotización a Venta.";
	} else{
		$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: UPDATE facturas - Cotización a Venta".mysqli_error($con);
	}
	
	$sql=mysqli_query($con, "select * from products, facturas, detalle_factura where 
	facturas.numero_factura=detalle_factura.numero_factura and  facturas.id_factura='$id_factura' and 
	products.id_producto=detalle_factura.id_producto");
	
	//$sql=mysqli_query( $con, "select * from facturas, detalle_factura where 
	//facturas.numero_factura=detalle_factura.numero_factura and facturas.id_factura='$id_factura' " );
	
	//$sql=mysqli_query( $con, "select * from detalle_factura where numero_factura='$numero_docum' " );
	
	$user_id = intval( $_SESSION['user_id'] );
	$date_added = date("Y-m-d H:i:s");
	
	while ($row=mysqli_fetch_array($sql)) {
		$numero_factura=$row["numero_factura"];
		$id_producto=$row["id_producto"];
		$cantidad=$row["cantidad"];
		$prod_invent=$row["prod_invent"];
		
		//print "numero docume: " . $numero_factura . " ";
		//print "datos: " . $id_producto . " ";
		//print "cantidad: " . $cantidad . " ";
		//print "prod_invent: " . $prod_invent . " ";
		
		// Registro al inventario de la cantida inicial al registro del nuevo producto
		if ($prod_invent==1) {
			$vtaaut = "Conversion cotizacion a venta documento." . $numero_factura;
			$cantformat = "-" . $cantidad;
		} else {
			$vtaaut = "Conversion cotizacion a venta(servicio) documento." . $numero_factura;
			$cantformat = 0;
		}
		
		$qry1 = "INSERT INTO inventory (id_product, id_user, date_added, comment, id_location, cant_inventory ) 
		VALUES ('$id_producto', '$user_id', '$date_added', '$vtaaut', 1, '$cantformat' )";
		$qry_insert_inventory=mysqli_multi_query($con, $qry1);
		if ($qry_insert_inventory) {
				//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: INSERT INTO inventory - Cotización a Venta".mysqli_error($con);
			}
		
		//Paso 1 proceso afectar la existencia real actual del producto
		$sql_seek_product = mysqli_query( $con, "select * from cant_products where id_product = '$id_producto' LOCK IN SHARE MODE" );
		$rw_seek_product = mysqli_fetch_array($sql_seek_product);
		$cant_actual = $rw_seek_product['cantidad'];
		$nuevo_total = ($cant_actual - $cantidad);
		
		if ($prod_invent==1) {
			$qry2 = "UPDATE cant_products set cantidad = '$nuevo_total' where id_product = '$id_producto' ";
		} else {
			$qry2 = "UPDATE cant_products set cantidad = 0 where id_product = '$id_producto' ";
		}
		$qry_update_exist=mysqli_multi_query($con, $qry2);
		if ($qry_update_exist) {
				//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: UPDATE cant_products - Cotización a Venta ".mysqli_error($con);
			}
		
	}


		
	if (isset($errors)){
			
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