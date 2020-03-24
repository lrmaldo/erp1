<style>
	.ui-tooltip, .arrow:after {
		background: black;
		border: 2px solid white;
		}
	.ui-tooltip {
		padding: 10px 20px;
		color: white;
		border-radius: 20px;
		font: 10px "Helvetica Neue", Sans-Serif;
		box-shadow: 0 0 3px black;
		}
	.arrow {
		width: 70px;
		height: 16px;
		overflow: hidden;
		position: absolute;
		left: 50%;
		margin-left: -35px;
		bottom: -16px;
		}
	.arrow.top {
		top: -16px;
		bottom: auto;
		}
	.arrow.left {
		left: 20%;
		}
	.arrow:after {
		content: "";
		position: absolute;
		left: 20px;
		top: -20px;
		width: 25px;
		height: 25px;
		box-shadow: 6px 5px 9px -9px black;
		-webkit-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		transform: rotate(45deg);
		}
	.arrow.top:after {
		bottom: -20px;
		top: auto;
		}
	.ui-autocomplete.ui-widget {
	  font-family: Verdana,Arial,sans-serif;
	  font-size: 10px;
	  width: 500px;
	  z-index:100;
		}
</style>
<?php
	/*-------------------------
	Autor: Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_facturas="";
	$active_compras="active";
	$active_clientes="";
	$active_usuarios="";
	$title="Editar Compra | Maxim Inventory";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	include("funciones.php");

	if (isset($_GET['id_compra'])) {
		$id_compra=intval($_GET['id_compra']);
		
		/*
		"proveedores"
		id_prove, nombre_prove, rfc_prove, tel1_prove, tel2_prove, direccion_prove, colonia_prove, cp_prove, ciudad_prove
  		estado_prove, email_prove, represe_legal_prove, saldo_prove, dias_cred_prove 	
		
		"compras"
		id_compra, id_prove, id_almacen, numero_factura, pedido, fecha_fact, plazo_pago_dias, fecha_fact_venc, metodo_pago
		forma_pago, cargo_envio_fact, cargo_externo_flete, desc1, desc2, total_factura
		*/
		
		$campos="proveedores.id_prove, proveedores.nombre_prove, 
		numero_factura, pedido, fecha_fact, plazo_pago_dias, 
		fecha_fact_venc, metodo_pago, forma_pago, cargo_envio_fact, cargo_externo_flete, desc1, desc2, total_factura";
		
		$sql_compra=mysqli_query($con,"select $campos from compras, proveedores where 
		compras.id_prove=proveedores.id_prove and id_compra='".$id_compra."'" );
		$count=mysqli_num_rows($sql_compra);
		if ($count==1) {
				$rw_factura=mysqli_fetch_array($sql_compra);
				$id_prove=$rw_factura['id_prove'];
				$nombre_prove=$rw_factura['nombre_prove'];
				$numero_factura=$rw_factura['numero_factura'];
				$pedido=$rw_factura['pedido'];
				
				$year = date('Y', strtotime($rw_factura['fecha_fact']));
				$fecha_fact = ($year == "1969") ? NULL : date("m/d/Y", strtotime($rw_factura['fecha_fact']));
				
				$plazo_pago_dias=$rw_factura['plazo_pago_dias'];
				
				$year = date('Y', strtotime($rw_factura['fecha_fact_venc']));
				$fecha_fact_venc = ($year == "1969") ? NULL : date("m/d/Y", strtotime($rw_factura['fecha_fact_venc']));
			
				$metodo_pago=$rw_factura['metodo_pago'];
				$forma_pago=$rw_factura['forma_pago'];
				$cargo_envio_fact=$rw_factura['cargo_envio_fact'];
				$cargo_externo_flete=$rw_factura['cargo_externo_flete'];
				$desc1=$rw_factura['desc1'];
				$desc2=$rw_factura['desc2'];
				$total_factura=$rw_factura['total_factura'];
			
				//$_SESSION['id_compra']=$id_compra;
				//$_SESSION['numero_factura']=$numero_factura;
		
		}	
		else
		{
			header("location: compras.php");
			exit;	
		}
	} 
	else 
	{
		header("location: compras.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<button type="button" class="btn btn-success pull-right" id="cancel_compra" onclick="cancel_compra('<?php echo $id_compra;?>');">
			  <span class="glyphicon glyphicon-refresh"></span> Cancelar compra
			</button>
			<h4 id="titHead" ><i classfecha_fact_venc='glyphicon glyphicon-edit' ></i> Editar Compra Nº <?php echo $numero_factura;?> </h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_compra">
					
					<div class="form-group row">
					  	<div class="col-xs-12">
							<label for="idprove" class="control-label">Proveedor:</label>
							<input type="text" class="form-control input-sm" id="nombre_prove" name="nombre_prove" value="<?php echo $nombre_prove;?>" placeholder="Selecciona un proveedor del catálogo tecleando a partir de 3 caracteres" required>
							<input type='hidden' id="id_prove" name="id_prove" >
						</div>

					</div>

					<div class="form-group row">
						
						<label for="numfact" class="col-md-1 control-label">Factura:</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="num_fact" name="num_fact" value="<?php echo $numero_factura;?>" required maxlength="20" >
						</div>
						
						<label for="numpedido" class="col-md-1 control-label">Pedido:</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="num_pedido" name="num_pedido" value="<?php echo $pedido;?>" maxlength="20">
						</div>
						
						<label for="fechafact" class="col-md-1 control-label">Fecha:</label>
						<div class="col-md-2">
							<input type="date" class="form-control input-sm" id="fecha_fact" required>
						</div>
						
						<label for="condpago" class="col-md-2 control-label">Cond. Plazo días:</label>
						<div class="col-md-1">
							<input type="number" class="form-control input-sm" id="cond_pago" name="cond_pago" value="<?php echo $plazo_pago_dias;?>" min="0" step="1" >
						</div>
						
						<!--
						<label for="desc2" class="col-md-1 control-label">Desc%2:</label>
						<div class="col-md-1">
							<input type="number" class="form-control" id="desc_2" name="desc_2" min="0" step="1" value="0" >
						</div>
						-->

					</div>

					<div class="form-group row">
						
						<label for="fechafactven" class="col-md-2 control-label">Fecha vencimiento:</label>
						<div class="col-md-2">
							<input type="date" class="form-control input-sm" id="fecha_fact_venc" name="fecha_fact_venc" >
						</div>
						
						<label for="metpago" class="col-md-2 control-label">Método pago:</label>
						<div class="col-md-2">
							<select class='form-control input-sm' id="metodo_pago" name="metodo_pago" >
								<option value="1">Efectivo(1)</option>
								<option value="2">Cheque nominativo(2)</option>
								<option value="3">Transferencia electrónica de fondos(3)</option>
								<option value="4">Tarjeta de crédito(4)</option>
								<option value="5">Monedero electrónico(5)</option>
								<option value="6">Dinero electrónico(6)</option>
								<option value="7">Tarjetas digitales(7)</option>
								<option value="8">Vales de despensa(8)</option>
								<option value="9">Bienes(9)</option>
								<option value="10">Servicio(10)</option>
								<option value="11">Por cuenta de tercero(11)</option>
								<option value="12">Dación en pago(12)</option>
								<option value="13">Pago por subrogación(13)</option>
								<option value="14">Pago por consignación(14)</option>
								<option value="15">Condonación(15)</option>
								<option value="16">Cancelación(16)</option>
								<option value="17">Compensación(17)</option>
								<option value="98">N/A(98)</option>
								<option value="99">Otros(99)</option>
							</select>
						</div>
						
						<label for="formapago" class="col-md-2 control-label">Forma pago:</label>
						<div class="col-md-2">
							<select class='form-control input-sm' id="forma_pago" name="forma_pago">
								<option value="1">Una sola exhibición</option>
								<option value="2">Pago inicial y parcialidades</option>
								<option value="3">Pago en parcialidades o diferido</option>
							</select>
						</div>

					</div>

					<div class="form-group row">
						
						<label for="carenvcompra" class="col-md-2 control-label">Cargo envio $ :</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm 2numbers" id="cargo_envio_fact" name="cargo_envio_fact" value="<?php echo $email_cliente;?>" >
						</div>

						<label for="carextflete" class="col-md-2 control-label">Cargo externo flete $ :</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm 2numbers" id="cargo_ext_flete" name="cargo_ext_flete" value="<?php echo $email_cliente;?>" >
						</div>
						
						<label for="desc1" class="col-md-1 control-label">Desc%:</label>
						<div class="col-md-1">
							<input type="number" class="form-control" id="desc1" name="desc1" value="<?php echo $email_cliente;?>" min="0" step="1" value="0" >
						</div>
					
				 </div>
				
				<div class="form-group row">
					<label for="locat" class="col-md-2 control-label">Almacen aplicar la entrada de productos:</label>
					<div class="col-md-2">
							<select class="form-control input-sm" name="id_locat" id="id_locat" >
								<?php
									$sql_locat=mysqli_query($con,"select id,name from stock_locations");
									while ($rw=mysqli_fetch_array($sql_locat)){
										$id_locat=$rw["id"];
										$name_locat=$rw["name"];
								?>
								<option value="<?php echo $id_locat?>" <?php echo $selected;?>><?php echo $name_locat?></option>
								<?php
								}
								?>
							</select>
				</div>
				</div>
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-primary" onclick="upd_encab('<?php echo $id_compra;?>');" >
						 	<span class="glyphicon glyphicon-save"></span> Actualizar encabezado
						</button>
					</div>	
				</div>
			</form>	
			
			<div class="clearfix"></div>
				<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_compra.js"></script>
  	<link rel="stylesheet" href="js/jquery-ui.css">
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootbox.js"></script>
	<script type="text/javascript" src="js/cssrefresh.js"></script>
	
	<script>
		
		$(document).ready(function() {
			//var tipo_doc=<?php echo $tipo_doc;?>;
			//var i;
			/*
			$('#nombre_cliente').attr('disabled', tipo_doc == 1 ? true : false);
			for(i=2; i<=5; i++) {
				$('#button'+i).attr('disabled', tipo_doc == 1 ? true : false);
			}
			//$( "#resultados" ).load( "ajax/editar_facturacion.php" );
			*/
			
			$('#nombre_prove').attr('disabled', true);
			$('#num_fact').attr('disabled', true);
			$('#num_pedido').attr('disabled', true);
			$('#fecha_fact').attr('disabled', true);
			$('#cond_pago').attr('disabled', true);
			$('#fecha_fact_venc').attr('disabled', true);
			$('#metodo_pago').attr('disabled', true);
			$('#forma_pago').attr('disabled', true);
			
			
			var date1string = "<?php echo $fecha_fact;?>";
			var date1obj = new Date(date1string);
			document.getElementById('fecha_fact').valueAsDate = date1obj;
			
			var date2string = "<?php echo $fecha_fact_venc;?>";
			var date2obj = new Date(date2string);
			document.getElementById('fecha_fact_venc').valueAsDate = date2obj;
			
			$('#metodo_pago').val(<?php echo $metodo_pago;?>);
			$('#forma_pago').val(<?php echo $forma_pago;?>);
			
			//Enlace llamada a las partidas de la compra
			var id_compra = "<?php echo $id_compra;?>";
			var nf = "<?php echo $numero_factura;?>";
			$( "#resultados" ).load( "ajax/editar_detalle_compra.php?id_compra="+id_compra+'&nf='+nf);
		
		});
		
		//---------------------------------------------------------------------------------------------------- Busqueda por proveedor
		$(function() {
			$("#nombre_prove").autocomplete({
				source: "./ajax/autocomplete/prove.php",
				minLength: 3,
				select: function(event, ui) {
				event.preventDefault();
				$('#id_prove').val(ui.item.id_prove);
				$('#nombre_prove').val(ui.item.nombre_prove);
				}
			});
		});
					
		$("#nombre_prove" ).on( "keydown", function( event ) {
				if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE ) {
					$("#id_prove" ).val("");
				}
				if (event.keyCode==$.ui.keyCode.DELETE){
					$("#nombre_prove" ).val("");
					$("#id_prove" ).val("");
				}
		});

		//--------------------------------------------------------------------------------------------------------- agregar productos
		function p_agregar_prod() {
				var page=1;
				var q= $("#q").val();
				var tipoprecclie = $('#tipo_prec_cliente').val();
				$("#loader").fadeIn('slow');
				$.ajax({
					url:'ajax/productos_factura.php?action=ajax&page='+page+'&q='+q+'&tipoprecclie='+tipoprecclie,
					 beforeSend: function(objeto){
					 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
				},
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					}
				})
		}
		
		function upd_encab(id) {
			bootbox.alert("upd_encabezado"+id);
		}
		
		function cancel_compra(id) {
			bootbox.alert("Cancelar compra"+id);
		}
		
	</script>

  </body>
</html>