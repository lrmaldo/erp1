<?php
/*-------------------------
Autor: Elio Mojica
Web: maximcode.com
Mail: admin@maximcode.com
---------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();

if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_compra'])){$precio_compra=$_POST['precio_compra'];}
if (isset($_POST['dato_adicional'])){$dato_adicional=$_POST['dato_adicional'];}

/*
$cpr=0;
foreach ($_POST as $param_name => $param_val) {
	echo "Param: $param_name; Value: $param_val<br />\n";
	$cpr++;
}
*/


/* Connect To Database*/
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include("../funciones.php");

if (!empty($id) and !empty($cantidad) and !empty($precio_compra)) {
	//$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	
	$insert_tmp=mysqli_query($con, "INSERT HIGH_PRIORITY INTO tmp_deta_compras ( id_producto_tmp, cantidad_tmp, precio_tmp, 
	session_id_tmp, obser_partida_tmp ) VALUES ('$id','$cantidad','$precio_compra','$session_id','$dato_adicional' )");
	
	//if ($insert_tmp) {
}

if (isset($_GET['modo'])){
	$modo=$_GET['modo'];
} else {
	$modo=0;
}

//codigo elimina un elemento del array
if ( isset($_GET['id']) && $modo==0 ) {
	$id_tmp=intval($_GET['id']);	
	$delete=mysqli_query($con, "DELETE FROM tmp_deta_compras WHERE id_tmp='".$id_tmp."'");
}

//update elemento detalle documento del array
if (isset($_GET['id']) && $modo==1 ) {
	$id_tmp=intval($_GET['id']);
	$d_a=$_GET['d_a'];
	$n_c=$_GET['n_c'];
	$n_p=$_GET['n_p'];
	$update=mysqli_query($con, "update tmp_deta_compras set obser_partida_tmp = '$d_a', cantidad_tmp = '$n_c', precio_tmp = '$n_p' WHERE id_tmp='".$id_tmp."'");
}

$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
<div class="table-responsive">
<table class="table table-bordered table-hover scroll input-sm">
<tr class="info">
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>UND</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th>OBSERVACION POR PARTIDA</th>
	<th class='text-right'>PREC.UNITARIO</th>
	<th class='text-right'>I M P O R T E</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	//$sql=mysqli_query($con, "select * from products, tmp_deta_compras, unidades where products.id_producto=tmp_deta_compras.id_producto_tmp and session_id_tmp='".$session_id."'");
	$csql="select * from products inner join unidades on unidades.id_unidad=products.id_unidad inner join tmp_deta_compras on tmp_deta_compras.id_producto_tmp=products.id_producto where session_id_tmp='".$session_id."'";
	
	$sql=mysqli_query($con, $csql);
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['nombre_producto'];
	$dato_adicional=$row['obser_partida_tmp'];
	$precio_venta=$row['precio_tmp'];
	$nombre_und=$row['nombre_unidad'];
		
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
	?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $nombre_und;?></td>
			
			<td class='col-xs-1'>
				<div class="pull-right">
				<input type="text" class="form-control numbers input-sm" style="text-align:right" id="cantidad_tmp_<?php echo $id_tmp; ?>" value="<?php echo $cantidad;?>"  pattern="\d{1,4}" required >
			</div></td>
			
			<td><?php echo $nombre_producto;?></td>
			<td class='col-xs-3' ><div class="pull-left">
				<textarea class="form-control input-sm" id="dato_adicional_<?php echo $id_tmp; ?>" cols="60" rows="1"  ><?php echo $dato_adicional;?></textarea>
			</div></td>
			
			<td class='col-xs-1'>
				<div class="pull-right">
				<input type="text" class="form-control numbers input-sm" style="text-align:right" id="precio_tmp_<?php echo $id_tmp; ?>" value="<?php echo $precio_venta_f;?>" required pattern="^[0-9]+(\.[0-9]{1,2})?$" >
			</div></td>
			
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
			<td class='text-right'><a href="#" onclick="update_detalle_tmp('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-tag"></i></a></td>
		</tr>		
		<?php
	}
	
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	
	$desc=0;
	$cargos_extra=0;
	
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_compra=$subtotal+$total_iva;

?>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>SUBTOTAL <?php echo $simbolo_moneda;?> </td>
	<td class='text-right' ><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>DESCUENTO (<?php echo $simbolo_moneda;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right' ><?php echo number_format($desc,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>CARGOS EXTRA (<?php echo $simbolo_moneda;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right' ><?php echo number_format($cargos_extra,2);?></td>
	<td></td>
</tr>


<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right' ><?php echo number_format($total_iva,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>TOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right' ><?php echo number_format($total_compra,2);?></td>
	<td></td>
</tr>

</table>
</div>

<script>
	
	$(document).ready(function() {
		$("input.numbers").keypress(function(event) {
			if (String.fromCharCode(event.keyCode).match(/^[0-9.,]+$/)) {
				return true;
			} else {
				return false;
			}
		});
		
	});
	
</script>
