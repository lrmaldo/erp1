<style>
	.back-to-top {
		position: fixed;
		bottom: 4em;
		right: 0px;
		text-decoration: none;
		color: #000000;
		background-color: rgba(210, 30, 44, 0.9);
		font-size: 12px;
		padding: 1em;
		display: none;
		}
	.back-to-top:hover {    
		background-color: rgba(9, 216, 60, 0.8);
		}
	.ui-autocomplete.ui-widget {
		  font-family: Verdana,Arial,sans-serif;
		  font-size: 10px;
		  width: 500px;
		  z-index:100;

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
	$title="Nueva compra | Maxim Inventory";

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); // Proxies.

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	//date_default_timezone_set('America/Mexico_city');
	//echo date_default_timezone_get();

	$qry_utili=mysqli_query( $con, "select * from utilidades where id=1" );
	if ($qry_utili) {
		$rw=mysqli_fetch_array($qry_utili);
		$utilidad_1=$rw['utilidad_1'];
		$utilidad_2=$rw['utilidad_2'];
		$utilidad_3=$rw['utilidad_3'];
		$utilidad_4=$rw['utilidad_4'];
	} else {
		$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Nuevo documento nuevo productos ".mysqli_error($con);
	}

	//Al crear nuevo documento se limpia antes la tabla tmp por session
	$session_id= session_id();
	$delete=mysqli_query($con,"DELETE FROM tmp_deta_compras WHERE session_id_tmp='".$session_id."'");

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
	<div class="panel panel-primary">
		<a href="#" class="back-to-top">Volver arriba</a>
		<div class="panel-heading">
			<button type="button" class="btn btn-success pull-right" id="return_doc" onclick="freturn_doc();">
				  <span class="glyphicon glyphicon-list-alt"></span> Regresar a lista de compras
			</button>
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Compra</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_proveedores.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_compra">
					
					<div class="form-group row">
					  	<div class="col-xs-12">
							<label for="idprove" class="control-label">Proveedor:</label>
							<input type="text" class="form-control input-sm" id="nombre_prove" name="nombre_prove" placeholder="Selecciona un proveedor del catálogo tecleando a partir de 3 caracteres" required>
							<input type='hidden' id="id_prove" name="id_prove" >
						</div>
					</div>

					<div class="form-group row">
						
						<label for="numfact" class="col-md-1 control-label">Factura:</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="num_fact" name="num_fact" required maxlength="20" >
						</div>
						
						<label for="numpedido" class="col-md-1 control-label">Pedido:</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm" id="num_pedido" name="num_pedido" maxlength="20">
						</div>
						
						<label for="fechafact" class="col-md-1 control-label">Fecha:</label>
						<div class="col-md-2">
							<input type="date" class="form-control input-sm" id="fecha_fact" name="fecha_fact" required>
						</div>
						
						<label for="condpago" class="col-md-2 control-label">Cond. Plazo días:</label>
						<div class="col-md-1">
							<input type="number" class="form-control input-sm" id="cond_pago" name="cond_pago" min="0" step="1" value="0" >
						</div>
						
						<!--
						<label for="desc2" class="col-md-1 control-label">Desc%2:</label>
						<div class="col-md-1">
							<input type="number" class="form-control" id="desc_2" name="desc_2" min="0" step="1" value="0" >
						</div>
						-->

					</div>

					<div class="form-group row">
						
						<label for="fechafactven" class="col-md-2 control-label">Fecha vencimiento.:</label>
						<div class="col-md-2">
							<input type="date" class="form-control input-sm" id="fecha_fact_venc" name="fecha_fact_venc" >
						</div>
						
						<label for="metpago" class="col-md-2 control-label">Método pago:</label>
						<div class="col-md-2">
							<select class='form-control input-sm' id="metodo_pago" name="metodo_pago">
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
							<input type="text" class="form-control input-sm 2numbers" id="cargo_envio_fact" name="cargo_envio_fact" >
						</div>

						<label for="carextflete" class="col-md-2 control-label">Cargo externo flete $ :</label>
						<div class="col-md-2">
							<input type="text" class="form-control input-sm 2numbers" id="cargo_ext_flete" name="cargo_ext_flete" >
						</div>
						
						<label for="desc1" class="col-md-1 control-label">Desc%:</label>
						<div class="col-md-1">
							<input type="number" class="form-control" id="desc1" name="desc1" min="0" step="1" value="0" >
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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoProveedor">
						 <span class="glyphicon glyphicon-user"></span> Nuevo proveedor
						</button>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="load(1);" >
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-primary">
						  <span class="glyphicon glyphicon-save"></span> Guardar compra
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
		</div>
		
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			</div>	
		 </div>
	</div>
	<hr>
	<?php
		include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/nueva_compra.js"></script>
	<link rel="stylesheet" href="js/jquery-ui.css">
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/cssrefresh.js"></script>
	<script src="js/bootbox.js"></script>
	
	<script>
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
		function _p_agregar_prod() {
			var page=1;
			var q= $("#q").val();
			//var xxxx = $('#').val();
			
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'ajax/productos_compra.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			},
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$('#loader').html('');
				}
			})
		}
		
		//Se guarda el documento compra//////////////////////////////////////////////////////////////////////////////////////////////////
		$("#datos_compra").submit(function( event ) {
			 var id_prove = $("#id_prove").val();
			 var name_prove = $("#nombre_prove").val();
			
			if (id_prove=="" ) {
				bootbox.alert("Se debe seleccionar un proveedor del catálogo de la lista");
				$("#nombre_prove").focus();
				return false;
				/*
				var d = bootbox.alert({ 
				  message: "Se debe seleccionar un proveedor del catálogo de la lista", 
				  callback: function() {
					  //$("#nombre_prove").focus();
				  }
				})
				return false;
				*/
			}
			
			$(":input,:hidden").serialize();
			var param = $(this).serialize();
			
			bootbox.confirm("Seguro de guardar la compra ?.", function (confirmed) {
				if (confirmed) {
					$.ajax({
							type: "POST",
							url: "ajax/save_compra.php",
							data: param,
							beforeSend: function(objeto) {
								$("#resultados").html("Guardando compra...");
							},
							success: function(msg) {
								if(msg=='error') {
									$("#resultados").html("");
									bootbox.alert('No hay productos agregados al documento compra');
								} else {
									$("#resultados").html(msg);
									$('#datos_compra').get(0).reset();
									$('#nombre_prove').focus();
									$("#return_doc").click();
								}
							},
						error: function(error) {
							  bootbox.alert("Error: " + msg);
							}
						});
				}
			});
			
			event.preventDefault();

		});
	
		//------------------------------------------------------------------------------ Abrir la ventana modal para nuevos productos
		$('#nuevoProducto').on('shown.bs.modal', function () {
			$("#utili1").val(<?php echo $utilidad_1;?>);
			$("#utili2").val(<?php echo $utilidad_2;?>);
			$("#utili3").val(<?php echo $utilidad_3;?>);
			$("#utili4").val(<?php echo $utilidad_4;?>);		
			$('#prod_invent').attr('checked', true );
			$('#codigo').focus();
		}) 
		//------------------------------------------------------------------------------ Despues de cerrar la ventana de productos
		$('#nuevoProducto').on('hidden.bs.modal', function () {
			$('#alert1').hide();
			$('#alert2').hide();
			$('#nuevoProducto').find('form').trigger('reset');
		})

		//------------------------------------------------------------------------------ Despues de cerrar la ventana de nuevo provee
		$('#nuevoProveedor').on('hidden.bs.modal', function () {
			$('#alert1').hide();
			$('#alert2').hide();
			$('#nuevoProveedor').find('form').trigger('reset');
		})
		
		$(".bootbox").on('hidden.bs.modal', function () {
			$("#nombre_prove").focus();
		})
		
		function freturn_doc() {
			location.href = 'compras.php';
		}

		
	</script>

  </body>
</html>
