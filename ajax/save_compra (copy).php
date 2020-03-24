<?php
	/*-------------------------
	Autor: Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado	/* Connect To Database*/
	
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include('../funciones.php');
	$session_id=session_id();

	$sql_count=mysqli_query($con,"select * from tmp_deta_compras where session_id_tmp='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	$count=intval($count);

	if ($count==0) 	{
		echo 'error';
		exit;
	}

	//foreach ($_POST as $param_name => $param_val) {
	//	echo "Param: $param_name; Value: $param_val<br />\n";
	//}

	//Variables por POST
	$id_prove=intval($_POST['id_prove']);
	$id_locat=intval($_POST['id_locat']);
	$num_fact=$_POST['num_fact'];
	$pedido=$_POST['num_pedido'];
	$fecha_fact=date('Y-m-d',strtotime($_POST['fecha_fact']));
	$plazo_pago_dias=intval($_POST['cond_pago']);
	
	$fecha_fact_venc=date('Y-m-d',strtotime($_POST['fecha_fact_venc']));
	
	$metodo_pago=$_POST['metodo_pago'];
	$forma_pago=$_POST['forma_pago'];
	
	if (isset($_POST['cargo_envio_fact'])){$cargo_envio_fact=intval($_POST['cargo_envio_fact']);}{$cargo_envio_fact=0;}
	if (isset($_POST['cargo_ext_flete'])){$cargo_externo_flete=intval($_POST['cargo_ext_flete']);}{$cargo_externo_flete=0;}

	$desc1=intval($_POST['desc1']);
	$desc2=0;

	//Fin de variables por GET

	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	
	$sql_deta=mysqli_query($con, "select * from products, tmp_deta_compras where products.id_producto=tmp_deta_compras.id_producto_tmp and 
	tmp_deta_compras.session_id_tmp='".$session_id."'");

	$total_factura=0;

	//Datos para Inventory
	$user_id = intval( $_SESSION['user_id'] );
	$date_added = date("Y-m-d H:i:s");
	$leycompra = "Entrada automatica compra No." . $num_fact;

	while ($row=mysqli_fetch_array($sql_deta)) 	{
		
		$id_tmp=$row["id_tmp"];
		$id_producto_tmp=$row["id_producto_tmp"];
		$cantidad_tmp=$row['cantidad_tmp'];
		$precio_tmp=$row['precio_tmp'];
		$obser_partida_tmp=$row['obser_partida_tmp'];
		
		$importe=$precio_tmp*$cantidad_tmp;
		$importe_total=number_format($importe,2);//Precio total formateado
		$importe_total=str_replace(",","",$importe_total);//Reemplazo las comas
		
		$total_iva=($importe_total * $impuesto )/100;
		$total_iva=number_format($total_iva,2,'.','');
		
		$total_factura+=$importe_total+$total_iva;

		//Paso I insert en la tabla deta_compras
		$insert_detail = mysqli_query($con, "INSERT INTO deta_compras (numero_factura, id_producto, cantidad, precio_costo,
		obser_partida, importe, iva ) VALUES ('$num_fact', '$id_producto_tmp', '$cantidad_tmp', '$precio_tmp', '$obser_partida_tmp', 
		'$importe_total', '$total_iva' )");
		
		if ($insert_detail) {
			//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
		} else {
			$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Compras, insert deta_compras ".mysqli_error($con);
		}
		
		//Paso II registro al inventario de la cantida inicial al registro del nuevo producto
		$cantformat = $cantidad_tmp;
		$qry1 = "INSERT INTO inventory (id_product, id_user, date_added, comment, id_location, cant_inventory ) 
		VALUES ('$id_producto_tmp', '$user_id', '$date_added', '$leycompra', '$id_locat', '$cantformat' )";
		$qry_insert_inventory=mysqli_multi_query($con, $qry1);
		if ($qry_insert_inventory) {
				//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Compras, insert inventory ".mysqli_error($con);
		}

		//Paso III proceso afectar la existencia real actual del producto
		$sql_seek_cant_products = mysqli_query( $con, "select * from cant_products where id_product = '$id_producto_tmp' LOCK IN SHARE MODE" );
		$rw_seek_cant_products = mysqli_fetch_array($sql_seek_cant_products);
		$cant_actual = $rw_seek_cant_products['cantidad'];
		$nuevo_total = ($cant_actual + $cantidad_tmp);

		$qry2 = "UPDATE cant_products set cantidad = '$nuevo_total' where id_product = '$id_producto_tmp' ";
		$qry_update_cant_exist=mysqli_multi_query($con, $qry2);
		if ($qry_update_cant_exist) {
				//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Compras, cant_products ".mysqli_error($con);
		}
		
		//Paso IV Afectar el precio costo del catalogo de products con el nuevo pero almacenar el costo anterior,
		//es necesario tambien actualizar los precios de lista de acuerdo a su % de venta de cada uno
		$sql_seek_product = mysqli_query( $con, "select * from products where id_producto = '$id_producto_tmp' LOCK IN SHARE MODE" );
		$rw_seek_product = mysqli_fetch_array($sql_seek_product);
		$precio_cost_actual = $rw_seek_product['precio_cost'];
		$precio_cost_new = $precio_tmp;
		
		$utili1 = $rw_seek_product['utili'];
		$utili2 = $rw_seek_product['utili2'];
		$utili3 = $rw_seek_product['utili3'];
		$utili4 = $rw_seek_product['utili4'];
		
		$tmp=($precio_cost_new * $utili1) /100;
		$precio_new1=$precio_cost_new + $tmp;
		
		$tmp=($precio_cost_new * $utili2) /100;
		$precio_new2=$precio_cost_new + $tmp;
		
		$tmp=($precio_cost_new * $utili3) /100;
		$precio_new3=$precio_cost_new + $tmp;
		
		$tmp=($precio_cost_new * $utili4) /100;
		$precio_new4=$precio_cost_new + $tmp;

		$qry3 = "UPDATE products set precio_producto = '$precio_new1', precio2='$precio_new2', precio3='$precio_new3', precio4='$precio_new4', precio_cost='$precio_cost_new' where id_producto = '$id_producto_tmp' ";
		$qry_update_exist=mysqli_multi_query($con, $qry3);
		if ($qry_update_exist) {
				//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
		} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Compras, update products ".mysqli_error($con);
		}
		

	}	//End while

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
	
	//==========================================================================================================================Final

	$delete=mysqli_query($con,"DELETE FROM tmp_deta_compras WHERE session_id_tmp='".$session_id."'");

	$messages[] = "La compra ha sido agregada satisfactoriamente.";

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
