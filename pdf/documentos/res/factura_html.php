<?php 
	//include("encabezado_factura.php");
?>

<?php

$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from products, tmp where products.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
	
	$prod_invent=$row['prod_invent'];
		
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['nombre_producto'];
	$dato_adicional=$row['dato_adicional'];
	$tax_iva=$row['tax_iva'];
	
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	//$sumador_total+=$precio_total_r;//Sumador
		
	$sum_part=$precio_total_r;//Sumador por partida
	$subtotal+=number_format($sum_part,2,'.','');
	if ($tax_iva==1) {
		$total_iva=($sum_part * $impuesto )/100;
		$total_iva=number_format($total_iva,2,'.','');
	} else {
	  $total_iva=0;
	}
	$acum_iva+=$total_iva;	
		
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	
	/*
	$textoLargo = $dato_adicional;
	$largoMax = 58; // numero maximo de caracteres antes de hacer un salto de linea
	$rompeLineas = '<br />';
	$romper_palabras_largas = true; // rompe una palabra 
	*/
	
	?>

	<?php 
	//Insert en la tabla detalle_cotizacion
	$insert_detail = mysqli_query($con, "INSERT INTO detalle_factura VALUES (default,'$numero_factura','$id_producto','$cantidad','$precio_venta_r','$dato_adicional','$tax_iva' )");
	if ($insert_detail) {
		//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
	} else {
		$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: detalle_factura ".mysqli_error($con);
	}
	
	//Proceso guardar el documento y registrar en la bitacora del inventario cuando sea nota de venta y el producto sea inventariable
	if ( $tipo_doc==1 && $prod_invent==1 ) {
		//Registro al inventario de la cantida inicial al registro del nuevo producto
		$user_id = intval( $_SESSION['user_id'] );
		
		//$date_added = date("Y-m-d H:i:s");
		
		$vtaaut = "Venta automatica No." . $numero_factura;
		$cantformat = "-" . $cantidad;
		$qry1 = "INSERT INTO inventory (id_product, id_user, date_added, comment, id_location, cant_inventory ) 
		VALUES ('$id_producto', '$user_id', '$date_added', '$vtaaut', 1, '$cantformat' )";
		$qry_insert_inventory=mysqli_multi_query($con, $qry1);
		if ($qry_insert_inventory) {
				//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Venta inventory ".mysqli_error($con);
			}
	
		//Proceso afectar la existencia real actual del producto
		$sql_seek_product = mysqli_query( $con, "select * from cant_products where id_product = '$id_producto' LOCK IN SHARE MODE" );
		$rw_seek_product = mysqli_fetch_array($sql_seek_product);
		$cant_actual = $rw_seek_product['cantidad'];
		$nuevo_total = ($cant_actual - $cantidad);
		
		//$qry2 = "UPDATE cant_products (id_product, id_location, cantidad ) 
		$qry2 = "UPDATE cant_products set cantidad = '$nuevo_total' where id_product = '$id_producto' ";
		$qry_update_exist=mysqli_multi_query($con, $qry2);
		if ($qry_update_exist) {
				//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Venta cant_products ".mysqli_error($con);
			}
	}
	
	$nums++;
	
	}	//End while

	
	/*
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
	*/

	$total_factura=$subtotal+$acum_iva;

?>
	  

<?php
	
	//$date=date("Y-m-d H:i:s");

	if ($id_cliente==0) {
		$id_cliente=get_row('perfil','numeracion_cliente_foraneo', 'id_perfil', 1);
	}
	$insert_factura = mysqli_query($con,"INSERT INTO facturas VALUES (default, '$numero_factura', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '1', '$tipo_doc', '$cerrada', '$datoc1', '$datoc2', '$datoc3', '$datoc4', '$datoc5', '$datoc6', '$datoc7', '$datoc8' )");
	if ($insert_factura) {
			//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
		} else {
			$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: factura ".mysqli_error($con);
		}
	
	if (isset($errors)){
		foreach ($errors as $error) {
			print "Error: " . $error;
		}
	}

	$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");

?>