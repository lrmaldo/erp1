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
	Autor: Lic.Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$title="Editar Factura | Simple Invoice";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	include("funciones.php");
	
	if (isset($_GET['id_factura'])) {
		$id_factura=intval($_GET['id_factura']);
		$campos="clientes.id_cliente, tipo_cliente, clientes.nombre_cliente, ape_pat_cliente, ape_mat_cliente,clientes.telefono_cliente,
		clientes.email_cliente, clientes.direccion_cliente, clientes.col_cliente, clientes.ciudad_cliente, clientes.rfc_cliente,
		facturas.id_vendedor, facturas.fecha_factura, facturas.condiciones, facturas.estado_factura, facturas.numero_factura, 
		tipo_doc, tipo_prec_cliente, cliente_foraneo, tel_cliente_foraneo, email_cliente_foraneo, direccion_cliente_foraneo, 
		col_cliente_foraneo, ciudad_cliente_foraneo, rfc_cliente_foraneo, membresias_selections";
		$sql_factura=mysqli_query($con,"select $campos from facturas, clientes where facturas.id_cliente=clientes.id_cliente and id_factura='".$id_factura."'");
		$count=mysqli_num_rows($sql_factura);
		if ($count==1)
		{
				$rw_factura=mysqli_fetch_array($sql_factura);
				$id_cliente=$rw_factura['id_cliente'];
				$tipo_doc=$rw_factura['tipo_doc'];
				
				$id_cli_foraneo=get_row('perfil','numeracion_cliente_foraneo', 'id_perfil', 1);
				if ($id_cli_foraneo <> $id_cliente) {
					$tipo_cliente=$rw_factura['tipo_cliente'];
				    $nombre_gral=$rw_factura['nombre_cliente'];
				    if($tipo_cliente==1) {
						$nombre_gral=$nombre_gral.' '.$rw_factura['ape_pat_cliente'].' '.$rw_factura['ape_mat_cliente'];
					}
					
					$cliente_registrado=1;
					$nombre_cliente=$nombre_gral;
					$telefono_cliente=$rw_factura['telefono_cliente'];
					$email_cliente=$rw_factura['email_cliente'];
					//New
					$direccion_cliente=$rw_factura['direccion_cliente'];
					$col_cliente=$rw_factura['col_cliente'];
					$ciudad_cliente=$rw_factura['ciudad_cliente'];
					$rfc_cliente=$rw_factura['rfc_cliente'];
				} else {
					$cliente_registrado=0;
					$nombre_cliente=$rw_factura['cliente_foraneo'];
					$telefono_cliente=$rw_factura['tel_cliente_foraneo'];
					$email_cliente=$rw_factura['email_cliente_foraneo'];
					//New data customer foraneo
					$direccion_cliente=$rw_factura['direccion_cliente_foraneo'];
					$col_cliente=$rw_factura['col_cliente_foraneo'];
					$ciudad_cliente=$rw_factura['ciudad_cliente_foraneo'];
					$rfc_cliente=$rw_factura['rfc_cliente_foraneo'];
				}
			
				//New for membresias
					$membresias_selections=$rw_factura['membresias_selections'];
					$string_array = explode(",",$membresias_selections);
					//if (!empty($membresias_selections)) {
					//	for($i = 0; $i < sizeof($string_array); $i++) {
					//		echo $string_array[$i];
					//	}
				//}
			
				$id_vendedor_db=$rw_factura['id_vendedor'];
				
				//$fecha_factura=date("d/m/Y", strtotime($rw_factura['fecha_factura']));
				$year = date('Y', strtotime($rw_factura['fecha_factura']));
				$fecha_factura = ($year == "1969") ? NULL : date("Y-m-d", strtotime($rw_factura['fecha_factura']));
				
				$condiciones=$rw_factura['condiciones'];
				$estado_factura=$rw_factura['estado_factura'];
				$numero_factura=$rw_factura['numero_factura'];
				$tipo_prec_cliente=$rw_factura['tipo_prec_cliente'];
				$_SESSION['id_factura']=$id_factura;
				$_SESSION['numero_factura']=$numero_factura;
			
				if($tipo_doc==1) {
					$Titulo_doc = "VENTA Nº " . $numero_factura;
				} else if($tipo_doc==2) {
					$Titulo_doc = "COTIZACION Nº " . $numero_factura;
				}
		}	
		else
		{
			header("location: facturas.php");
			exit;	
		}
		
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

		
	} 
	else 
	{
		header("location: facturas.php");
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
				<?php
					if($tipo_doc==2) { ?>
						<button type="button" class="btn btn-success pull-right" id="cotiz_venta" onclick="change_cotiz_venta('<?php echo $numero_factura;?>');">
							  <span class="glyphicon glyphicon-refresh"></span> Convertir a Venta
						</button>
					<?php }
				?>
			<button type="button" class="btn btn-success pull-right" id="return_doc" onclick="freturn_doc();">
				  <span class="glyphicon glyphicon-list-alt"></span> Regresar a lista de documentos
			</button>

			<h4 id="titHead" ><i class='glyphicon glyphicon-edit' ></i> Editar Documento <?php echo $Titulo_doc;?> </h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura">
				
				<div class="form-group row">
				<label for="tipodoc" class="col-md-1 control-label">TIPO:</label>
					<div class="col-md-3">
						<select class='form-control input-sm' id="tipo_doc" disabled >
							<option value="1" <?php if ($tipo_doc==1){echo "selected";}?>>VENTA</option>
							<option value="2" <?php if ($tipo_doc==2){echo "selected";}?>>COTIZACION</option>
					</select>
					</div>
				</div>
				
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente:</label>
				  <div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" name="nombre_cliente" placeholder="Selecciona un cliente" value="<?php echo $nombre_cliente;?>" required disabled>
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">	
					  <input id="tipo_prec_cliente" type='hidden' value="<?php echo $tipo_prec_cliente;?>">
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono:</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" name="tel1" placeholder="Teléfono" value="<?php echo $telefono_cliente;?>" >
							</div>
					<label for="mail" class="col-md-1 control-label">Email:</label>
							<div class="col-md-3">
								<input type="email" multiple="multiple" class="form-control input-sm" id="mail" name="mail" Title="Para agregar un correo electrónico más tecleé el símbolo: ," placeholder="Teclear sólo si es cliente foraneo" value="<?php echo $email_cliente;?>" >
							</div>
				 </div>
				
				 <div class="form-group row">
					 <div class="col-md-5">
						 <input type="text" class="form-control" id="direcc" name="direcc" Title="Ingrese correctamente la direccion sólo si el cliente es foraneo" placeholder="Ingrese dirección si el cliente es foraneo" value="<?php echo $direccion_cliente;?>" maxlength="255" >
					 </div>
					 <div class="col-md-3">
						<input type="text" class="form-control input-sm" id="colonia" name="colonia" Title="Ingrese correctamente la colonia sólo si el cliente es foraneo" placeholder="Ingrese colonia si el cliente es foraneo" value="<?php echo $col_cliente;?>" maxlength="100">
					 </div>
					 <div class="col-md-2">
						<input type="text" class="form-control input-sm" id="ciudad" name="ciudad" Title="Ingrese correctamente la ciudad sólo si el cliente es foraneo" placeholder="Ingrese ciudad si el cliente es foraneo" value="<?php echo $ciudad_cliente;?>" maxlength="50">
					 </div>
					 <div class="col-md-2">
						<input type="text" class="form-control input-sm" id="rfc" name="rfc" Title="Ingrese correctamente el RFC sólo si el cliente es foraneo" placeholder="Ingrese RFC si el cliente es foraneo" value="<?php echo $rfc_cliente;?>" maxlength="13">
					 </div>
				 </div>
				
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Vendedor:</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="id_vendedor" name="id_vendedor" required>
									<?php
										$sql_vendedor=mysqli_query($con,"select * from users order by lastname");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$id_vendedor_db){
												$selected="selected";
											} else {
												$selected="";
											}
											?>
											<option value="<?php echo $id_vendedor?>" <?php echo $selected;?>><?php echo $nombre_vendedor?></option>
											<?php
										}
									?>
								</select>
							</div>
							<label for="tel2" class="col-md-1 control-label">Fecha:</label>
							<div class="col-md-2">
								<input type="date" class="form-control input-sm" id="fecha_doc" name="fecha_doc" value="<?php echo $fecha_factura;?>" required>
							</div>
							<label for="email" class="col-md-1 control-label">Pago:</label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="condiciones" name="condiciones" required >
									<option value="1" <?php if ($condiciones==1){echo "selected";}?>>Efectivo</option>
									<option value="2" <?php if ($condiciones==2){echo "selected";}?>>Cheque</option>
									<option value="3" <?php if ($condiciones==3){echo "selected";}?>>Transferencia bancaria</option>
									<option value="4" <?php if ($condiciones==4){echo "selected";}?>>Crédito</option>
								</select>
							</div>
							<div class="col-md-2">
								<select class='form-control input-sm ' id="estado_factura" name="estado_factura" required>
									<option value="1" <?php if ($estado_factura==1){echo "selected";}?>>Pagado</option>
									<option value="2" <?php if ($estado_factura==2){echo "selected";}?>>Pendiente</option>
								</select>
							</div>
						</div>
				
						<div class="form-group row">
						<label for="lblmembresias" class="col-md-1 control-label">Membresias:</label>
						<div class="col-md-4">
							<select class="form-control input-sm" id="opt_membre" name="opt_membre[]" multiple="multiple" >
								<?php
									$sql_chg_prods=mysqli_query($con,"select * from products where ( nombre_producto like '%MEMBRESIA%' or nombre_producto like '%INTERNET DEDICADO%' or nombre_producto like '%INTERNET AVANZADO%' )");
									while ($chg_rw=mysqli_fetch_array($sql_chg_prods)){
										$id_producto=$chg_rw["id_producto"];
										$nombre_producto=$chg_rw["nombre_producto"];
										
										if ($tipo_doc==1) {
								?>
								        <option value="<?php echo $id_producto?>" <?php if (in_array($id_producto, $string_array)) {echo "selected";}?> disabled > <?php echo $nombre_producto?></option>
								<?php
										} else {
								?>
										<option value="<?php echo $id_producto?>" <?php if (in_array($id_producto, $string_array)) {echo "selected";}?> > <?php echo $nombre_producto?></option>
								<?php
										}
									}
								?>
							</select>
							</div>
						</div>
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="submit" class="btn btn-primary" id="button1" title="Actualizar los datos del encabezado del documento" >
						  <span class="glyphicon glyphicon-save"></span> Actualizar datos
						</button>
						<button type="button" class="btn btn-primary" id="button2" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-primary" id="button3" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-primary" id="button4" data-toggle="modal" data-target="#myModal" onclick="load(1);">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="button" class="btn btn-primary" id="button5" onclick="imprimir_factura('<?php echo $id_factura;?>')">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
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
	<script type="text/javascript" src="js/editar_factura.js"></script>
	<link rel="stylesheet" href="js/jquery-ui.css">
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootbox.js"></script>
	<script type="text/javascript" src="js/cssrefresh.js"></script>
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
	
	<script type="text/javascript">
		
		function Ini_load() {
			var tipo_doc=<?php echo $tipo_doc;?>;
			var cliente_registrado=<?php echo $cliente_registrado;?>;
			var i;
			
			$('#opt_membre').multiselect({
				enableFiltering: true,
				includeSelectAllOption: true,
				numberDisplayed: 0,
				maxHeight: 160
			});	

			$('#nombre_cliente').attr('disabled', tipo_doc == 1 ? true : false);
			
			//tipo_doc=1 Venta, =2 Cotiza
			if (tipo_doc==1) {
				if (cliente_registrado==1) {
					$('#tel1').attr('disabled', true);
					$('#mail').attr('disabled', true);
					// New for customer foraneo
					$('#direcc').attr('disabled', true);
					$('#colonia').attr('disabled', true);
					$('#ciudad').attr('disabled', true);
					$('#rfc').attr('disabled', true);
				}
			} else if (tipo_doc==2) {
				if (cliente_registrado==1) {
					$('#tel1').attr('disabled', true);
					$('#mail').attr('disabled', true);
					// New for customer foraneo
					$('#direcc').attr('disabled', true);
					$('#colonia').attr('disabled', true);
					$('#ciudad').attr('disabled', true);
					$('#rfc').attr('disabled', true);
				}
			}
			
			//Disabled fields if tipo_doc=1
			$('#id_vendedor').attr('disabled', tipo_doc == 1 ? true : false);
			$('#fecha_doc').attr('disabled', tipo_doc == 1 ? true : false);
			
			$('#fecha').attr('disabled', tipo_doc == 1 ? true : false);
			$('#condiciones').attr('disabled', tipo_doc == 1 ? true : false);
			//$('#opt_membre').attr('disabled', tipo_doc == 1 ? true : false);
			
			for(i=2; i<=5; i++) {
				$('#button'+i).attr('disabled', tipo_doc == 1 ? true : false);
			}
			$( "#resultados" ).load( "ajax/editar_facturacion.php" );
		}
		
		$(function() {
					$("#nombre_cliente").autocomplete({
						source: "./ajax/autocomplete/clientes.php",
						minLength: 3,
						select: function(event, ui) {
							event.preventDefault();
							$('#id_cliente').val(ui.item.id_cliente);
							$('#nombre_cliente').val(ui.item.value);
							$('#tel1').val(ui.item.telefono_cliente);
							$('#mail').val(ui.item.email_cliente);
							$('#tel1').attr('disabled', true);
							$('#mail').attr('disabled', true);
							//News add 13Oct2017
							$('#direcc').attr('disabled', true);
							$('#colonia').attr('disabled', true);
							$('#ciudad').attr('disabled', true);
							$('#rfc').attr('disabled', true);
						 }
					});
		});

		$("#nombre_cliente" ).on( "keydown", function( event ) {
					if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE ) {
						$("#id_cliente" ).val("");
						$("#tel1" ).val("");
						$("#mail" ).val("");
						$('#tel1').attr('disabled', false);
						$('#mail').attr('disabled', false);
						//News add 13Oct2017
						$('#direcc').val("");
						$('#colonia').val("");
						$('#ciudad').val("");
						$('#rfc').val("");
						$('#direcc').attr('disabled', false);
						$('#colonia').attr('disabled', false);
						$('#ciudad').attr('disabled', false);
						$('#rfc').attr('disabled', false);
					}
					if (event.keyCode==$.ui.keyCode.DELETE){
						$("#nombre_cliente" ).val("");
						$("#id_cliente" ).val("");
						$("#tel1" ).val("");
						$("#mail" ).val("");
						$('#tel1').attr('disabled', false);
						$('#mail').attr('disabled', false);
						//News add 13Oct2017
						$('#direcc').val("");
						$('#colonia').val("");
						$('#ciudad').val("");
						$('#rfc').val("");
						$('#direcc').attr('disabled', false);
						$('#colonia').attr('disabled', false);
						$('#ciudad').attr('disabled', false);
						$('#rfc').attr('disabled', false);
					}
		});

		// Abrir la ventana modal para nuevos productos
		$('#nuevoProducto').on('shown.bs.modal', function () {
			$("#utili1").val(<?php echo $utilidad_1;?>);
			$("#utili2").val(<?php echo $utilidad_2;?>);
			$("#utili3").val(<?php echo $utilidad_3;?>);
			$("#utili4").val(<?php echo $utilidad_4;?>);		

			$('#prod_invent').attr('checked', true );
			$('#prod_iva').attr('checked', true );
			$('#codigo').focus();
		}) 
		$('#nuevoProducto').on('hidden.bs.modal', function () {
			$('#alert1').hide();
			$('#alert2').hide();
			$('#nuevoProducto').find('form').trigger('reset');
		})

		$('#nuevoCliente').on('hidden.bs.modal', function () {
			$('#alert1').hide();
			$('#alert2').hide();
			$('#nuevoCliente').find('form').trigger('reset');
		})

		// Convertir cotizacion a venta para afectar los productos
		function change_cotiz_venta( _nf ) {

				id_cliente=$("#id_cliente").val();
			
				if (id_cliente=="") {
					  bootbox.alert("Debes seleccionar un cliente !");
					  $("#nombre_cliente").focus();
					  return false;
				  }

				var numero_docum = _nf;

				 $.ajax({
						type: "POST",
						url: 'ajax/cotiza-venta.php',
						data: "numero_docum="+numero_docum,
						beforeSend: function(objeto){
							$(".editar_factura").html("Mensaje: Cargando...");
					  },
					success: function(datos) {
						$(".editar_factura").html(datos);
						
						var newtit_doc = "VENTA Nº " + <?php echo $numero_factura;?>;
						
						//titHead.innerText = "public offers";
						//$("#titHead h4").text("New header");
						$("#titHead").text(newtit_doc);
						
						$("#nombre_cliente").prop("disabled", true);
						$("#id_vendedor").prop("disabled", true);
						
						//Refrescar detalles
						$( "#resultados" ).load( "ajax/editar_facturacion.php" );
						
						//Deshabilitar botones, el de actualizar encabezado no se deshabilita
						$("#cotiz_venta").prop("disabled", true);
						var i;
						for(i=1; i<=5; i++) {
							$('#button'+i).attr('disabled', true);
						}
						
					}
				});
		}
		
		function freturn_doc() {
			location.href = 'facturas.php';
		}
		
		
	</script>

  </body>
</html>