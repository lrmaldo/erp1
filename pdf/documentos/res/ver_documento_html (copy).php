<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.color-leyenda{
	background:orange;
	padding: 4px 4px 4px;
	color:black;
	font-weight:bold;
	font-size:12px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}

.myTableLeye { 
  width: 100%;
  text-align: left;
  background-color: lemonchiffon;
  border-collapse: collapse; 
  font-size:12px;
	
  border-radius: 5px;
  margin: auto;
  float: none;
  }
.myTableLeye th { 
  text-align: center;
  background-color: goldenrod;
  color: white; 
  }
.myTableLeye td,
.myTableLeye th { 
  padding: 3px;
  border: 1px solid goldenrod; 
 }

-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    <?php echo get_row('perfil','email', 'id_perfil', 1); ?>
                </td>
            </tr>
        </table>
    </page_footer>
	<?php include("encabezado_factura.php");?>
    <br>
    
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'> <?php echo $leyenda_doc; ?> </td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
			   
			   $id_cli_foraneo=get_row('perfil','numeracion_cliente_foraneo', 'id_perfil', 1);
			   $vendedor=get_two_row('users', 'firstname', 'lastname', 'user_id', $id_vendedor);
			   	
			   if ($id_cli_foraneo <> $id_cliente) {
					$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
					$rw_cliente=mysqli_fetch_array($sql_cliente);
				   
				    $tipo_cliente=$rw_cliente['tipo_cliente'];
				    $nombre_gral=$rw_cliente['nombre_cliente'];
				   
				    if($tipo_cliente==1) {
						$nombre_gral=$nombre_gral.' '.$rw_cliente['ape_pat_cliente'].' '.$rw_cliente['ape_mat_cliente'];
					}
				   
				    echo $nombre_gral;
					echo "<br>";
					echo $rw_cliente['direccion_cliente'];
					echo "<br> Teléfono: ";
					echo $rw_cliente['telefono_cliente'];
					echo "<br> Email: ";
					echo $rw_cliente['email_cliente'];
				   	$mail_customer=$rw_cliente['email_cliente'];
				    //New adress for registered customer, col, city and rfc
				   
				} else {
				   	echo $datoc1;
					echo "<br> Teléfono: ";
					echo $datoc2;
					echo "<br> Email:";
					echo $datoc3;
				   	$mail_customer=$datoc3;
				    echo "<br>";
				    //New address for foraneo customer, col, city and rfc
				   	echo $datoc4;	//Address
				    //echo $datoc5;	//Colony
				    //echo $datoc6;	//City
				    //echo $datoc7;	//Rfc
				}
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='midnight-blue'>ATENDIO</td>
		  <td style="width:25%;" class='midnight-blue'>FECHA</td>
		   <td style="width:40%;" class='midnight-blue'>FORMA DE PAGO</td>
        </tr>
		<tr>
           <td style="width:35%;">
			<?php 
				$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['firstname']." ".$rw_user['lastname'];
			?>
		   </td>
		  <td style="width:25%;"><?php echo date("d/m/Y", strtotime($fecha_factura));?></td>
		   <td style="width:40%;" >
				<?php 
				if($tipo_doc==1) {
						if ($condiciones==1){echo "Efectivo";}
						elseif ($condiciones==2){echo "Cheque";}
						elseif ($condiciones==3){echo "Transferencia bancaria";}
						elseif ($condiciones==4){echo "Crédito";}
					} else if($tipo_doc==2) {
						echo "Sin aplicar";
					}
				?>
		   </td>
        </tr>
		
        
   
    </table>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;table-layout:fixed">
        <tr>
            <th style="width: 08%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>IMPORTE</th>
            
        </tr>

<?php
$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from products, detalle_factura, facturas where products.id_producto=detalle_factura.id_producto and detalle_factura.numero_factura=facturas.numero_factura and facturas.id_factura='".$id_factura."'");

while ($row=mysqli_fetch_array($sql))
	{
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['nombre_producto'];
	
	$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	
	$textoLargo = $row['dato_adicional'];
	$largoMax = 58; // numero maximo de caracteres antes de hacer un salto de linea
	$rompeLineas = '<br />';
	$romper_palabras_largas = true; // rompe la cadena
	
	$varblack=0;
	$dect_word=substr($textoLargo, 0,1);
	
	if ($dect_word=='*') {	//Si se detecta * se activa bold en la impresion
		$varblack=1;
		$textoLargo = substr($textoLargo, 1, -1);	//Una vez detectado * se elimina de la impresion
	}
	
	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 08%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_venta_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_total_f;?></td>
        </tr>
		<tr>
			<td class='<?php echo $clase;?>' style="width: 08%; text-align: left"></td>
			<?php
				if ($varblack==1) {
					?>
            			<td colspan="3" style="width: 58%;text-align: left;font-weight: bold;"> <?php echo wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);?> </td>
				<?php	
					} else {
				?>
						<td colspan="3" style="width: 58%;text-align: left;"> <?php echo wordwrap($textoLargo,$largoMax,$rompeLineas,$romper_palabras_largas);?> </td>						
				<?php
				}
			?>
        </tr>

	<?php 

	
	$nums++;
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
?>
	  
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
        </tr>
		<tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">IVA (<?php echo $impuesto;?>)% <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva,2);?></td>
        </tr><tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_factura,2);?></td>
        </tr>
    </table>
	
	
	
	<br>
	<div style="font-size:11pt;text-align:center;font-weight:bold">*Precios sujetos a cambio sin previo aviso.<br>
	Entrega del sistema funcionando: 10 días hábiles a partir de recibir el depósito.
	<br>
	Beneficiario: SARAHI YULIANA GARCIA USCANGA
	</div>
	<br>
	<table class="myTableLeye">
        <tr>
          	<th>BANCO</th>
		  	<th>CUENTA</th>
		  	<th>CLABE</th>
        </tr>
		<tr>
			<td>HSBC</td>
			<td>6326875823</td>
			<td>021628063268758233</td>
        </tr>
			<tr>
          	<td>BBVA BANCOMER</td>
		  	<td>0191359606</td>
		  	<td>012628001913596067</td>
        </tr>
    </table>
	  

</page>

