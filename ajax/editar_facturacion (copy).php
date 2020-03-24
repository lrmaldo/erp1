<?php
	/*-------------------------
	Autor: Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_factura= $_SESSION['id_factura'];
$numero_factura= $_SESSION['numero_factura'];
if (isset($_POST['id'])){$id=intval($_POST['id']);}
if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}
if (isset($_POST['dato_adicional'])){$dato_adicional=$_POST['dato_adicional'];}

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");

if (isset($_GET['modo'])){
	$modo=$_GET['modo'];
} else {
	$modo=0;
}

if (!empty($id) and !empty($cantidad) and !empty($precio_venta)) {
	$insert_tmp=mysqli_query($con, "INSERT INTO detalle_factura (id_detalle, numero_factura, id_producto,cantidad,precio_venta,dato_adicional) VALUES 
	(default, '$numero_factura', '$id', '$cantidad', '$precio_venta','$dato_adicional' )");
}

//codigo elimina un elemento del array
if (isset($_GET['id']) && $modo==0 ) {
	$id_detalle=intval($_GET['id']);	
	$delete=mysqli_query($con, "DELETE FROM detalle_factura WHERE id_detalle='".$id_detalle."'");
}

//update elemento detalle documento del array
if (isset($_GET['id']) && $modo==1 ) {
	$id_detalle=intval($_GET['id']);
	$d_a=$_GET['d_a'];
	$n_c=$_GET['n_c'];
	$n_p=$_GET['n_p'];
	$update=mysqli_query($con, "update detalle_factura set dato_adicional='$d_a', cantidad='$n_c', precio_venta='$n_p' WHERE id_detalle='".$id_detalle."'");
}

$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
<div class="table-responsive">
<table class="table table-bordered table-hover scroll input-sm">
<tr class="danger">
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th>DATO ADICIONAL</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from products, facturas, detalle_factura where facturas.numero_factura=detalle_factura.numero_factura and  facturas.id_factura='$id_factura' and products.id_producto=detalle_factura.id_producto");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_detalle=$row["id_detalle"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['nombre_producto'];
	$dato_adicional=$row['dato_adicional'];
	$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas

	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	$cerrada=$row['cerrada'];
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			
			<td class='col-xs-1'>
				<div class="pull-right">
				<input type="number" class="form-control input-sm numbers" style="text-align:right" id="cantidad_update_<?php echo $id_detalle; ?>" min="1" step="1" value="<?php echo $cantidad;?>" required pattern="\d{1,4}"
					<?php if ($cerrada==1){echo "disabled";}?> >
				</div></td>
			
			<td><?php echo $nombre_producto;?></td>
			
			<td class='col-xs-3' ><div class="pull-left">
				<textarea <?php if ($cerrada==1){echo "disabled";}?> class="form-control" id="dato_adic_update_<?php echo $id_detalle; ?>" cols="60" rows="2"  ><?php echo $dato_adicional;?>
				</textarea>
			</div></td>
			
			<td class='col-xs-2'>
				<div class="pull-right">
				<input type="text" class="form-control input-sm numbers" style="text-align:right" id="precio_update_<?php echo $id_detalle; ?>" value="<?php echo $precio_venta_f;?>" required pattern="^[0-9]+(\.[0-9]{1,2})?$" 
					<?php if ($cerrada==1){echo "disabled";}?> required >
			</div></td>
			
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle; ?>', '<?php echo $cerrada; ?>' )" ><i class="glyphicon glyphicon-trash" ></i></a></td>
			<td class='text-right'><a href="#" onclick="update_detalle_doc('<?php echo $id_detalle ?>', '<?php echo $cerrada; ?>')"><i class="glyphicon glyphicon-edit"></i></a></td>
		</tr>		
		<?php
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
	$update=mysqli_query($con,"update facturas set total_venta='$total_factura' where id_factura='$id_factura'");
	
?>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>SUBTOTAL<?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>TOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<td></td>
</tr>

</table>
</div>

<script>
	
	$(document).ready(function(){
		$("input.numbers").keypress(function(event) {
			if (String.fromCharCode(event.keyCode).match(/^[0-9.,]+$/)) {
				return true;
			} else {
				return false;
			}
		});
		
	});
	
</script>
