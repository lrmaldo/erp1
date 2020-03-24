<style type="text/css">
<!--

.only-line {
	background:#FF4000;
	color:white;
}
	
-->
</style>
<?php
/*-------------------------
Autor: Elio Mojica
Web: maximcode.com
Mail: admin@maximcode.com
---------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();

/*
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
if (isset($_POST['dato_adicional'])){$dato_adicional=$_POST['dato_adicional'];}
*/

/* Connect To Database*/
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include("../funciones.php");

//print "Result: " . $_POST[info][0] . ", " . $_POST[info][1] . ", " . $_POST[info][2] . ", " . $_POST[info][3];

if (isset($_POST[info][0])){$id=$_POST[info][0];}
if (isset($_POST[info][1])){$cantidad=$_POST[info][1];}
if (isset($_POST[info][2])){$precio_venta=$_POST[info][2];}
if (isset($_POST[info][3])){$dato_adicional=$_POST[info][3];}
if (isset($_POST[info][4])) {$prod_iva=$_POST[info][4];}

if (!empty($id) and !empty($cantidad) and !empty($precio_venta)) {
	$date_added=date("Y-m-d H:i:s");
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$insert_tmp=mysqli_query($con, "INSERT HIGH_PRIORITY INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,dato_adicional,tax_tmp,date_added,tax_iva ) VALUES ('$id','$cantidad','$precio_venta','$session_id','$dato_adicional','$impuesto','$date_added','$prod_iva' )");
	//if ($insert_tmp) {
}

/*
if (isset($_GET['modo'])){
	$modo=$_GET['modo'];
} else {
	$modo=0;
}
*/
if (isset($_GET[info_udp][1])){
	$modo=$_GET[info_udp][1];
} else {
	$modo=0;
}


if (isset($_POST['add_del_tax'])){
	$add_del_tax=$_POST['add_del_tax'];
} else {
	$add_del_tax=0;
}

//codigo elimina un elemento del array
if ( isset($_GET[info_udp][0]) && $modo==0 ) {
	$id_tmp=intval($_GET[info_udp][0]);
	$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}

//update elemento detalle documento del array
if (isset($_GET[info_udp][0]) && $modo==1 ) {
	$id_tmp=intval($_GET[info_udp][0]);
	$d_a=$_GET[info_udp][2];
	$n_c=$_GET[info_udp][3];
	$n_p=$_GET[info_udp][4];
	$tax_ova=$_GET[info_udp][5];
	$update=mysqli_query($con, "update tmp set dato_adicional = '$d_a', cantidad_tmp = '$n_c', precio_tmp = '$n_p', tax_iva = '$tax_ova' WHERE id_tmp='".$id_tmp."'");
}

//print "1 paso: " . $add_del_tax;
//actualiza la tabla tmp con el tax
if($add_del_tax==1) {
	//print "2 paso: ";
	//print "id_tmp: " . $id_tmp;
	//$new_tax=0;
	//$sql=mysqli_query($con, "update tmp set tax_tmp = '$new_tax' where session_id='".$session_id."' and id_tmp='".$id_tmp."'");
}

$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);

?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-striped scroll input-sm">
<tr class="warning">
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th>DATO ADICIONAL</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-left'>IVA</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from products, tmp where products.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['nombre_producto'];
	$dato_adicional=$row['dato_adicional'];
	$precio_venta=$row['precio_tmp'];
	$integra_iva=$row['tax_iva'];
		
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	
	$sum_part=$precio_total_r;//Sumador por partida
		
	$subtotal+=number_format($sum_part,2,'.','');
	
	if ($integra_iva==1) {
		$total_iva=($sum_part * $impuesto )/100;
		$total_iva=number_format($total_iva,2,'.','');
		$idclass="only-line text-center";
	} else {
	  $total_iva=0;
	  $idclass="text-center";
	}
	
	$acum_iva+=$total_iva;
	
	?>
		<tr>
			
			<td class='<?php echo $idclass;?>'> <?php echo $codigo_producto;?> </td>
			
			<!-- <td class='text-center'><?php echo $cantidad;?></td> -->
			<td class='col-xs-1'>
				<div class="pull-right">
				<input type="number" class="form-control input-sm numbers" style="text-align:right" id="cantidad_tmp_<?php echo $id_tmp; ?>" value="<?php echo $cantidad;?>"  pattern="\d{1,4}" min="1" step="1" required >
			</div></td>
			
			<td><?php echo $nombre_producto;?></td>
			<td class='col-xs-3' ><div class="pull-left">
				<textarea class="form-control input-sm" id="dato_adicional_<?php echo $id_tmp; ?>" cols="60" rows="2"  ><?php echo $dato_adicional;?></textarea>
			</div></td>
			
			<!-- <td class='text-right'><?php echo $precio_venta_f;?></td> -->
			<td class='col-xs-2'>
				<div class="pull-right">
				<input type="text" class="form-control input-sm numbers" style="text-align:right" id="precio_tmp_<?php echo $id_tmp; ?>" value="<?php echo $precio_venta_f;?>" required pattern="^[0-9]+(\.[0-9]{1,2})?$" >
			</div></td>
			
			<td class='col-xs-0'>
				<div class="pull-left">
					<input type="checkbox" class="form-check-input input-sm" id="prod_iva_tmp_<?php echo $id_tmp; ?>" <?php if($integra_iva==1){?> checked <?php } ;?>  >
			</div></td>
			
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
			<!-- <td class='text-center'><a href="#" id="tax" onclick="add_del_tax('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-tag"></i></a></td>  -->
			<td class='text-right'><a href="#" onclick="update_detalle_tmp('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-tag"></i></a></td>
		</tr>		
		<?php
	}
	
		$total_factura=$subtotal+$acum_iva;

?>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>SUBTOTAL<?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' style='font-weight:bold' colspan=4>IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($acum_iva,2);?></td>
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
