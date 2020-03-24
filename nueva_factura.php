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
	
	
	
	
	
	
	span.multiselect-native-select {
	position: relative
}
span.multiselect-native-select select {
	border: 0!important;
	clip: rect(0 0 0 0)!important;
	height: 1px!important;
	margin: -1px -1px -1px -3px!important;
	overflow: hidden!important;
	padding: 0!important;
	position: absolute!important;
	width: 1px!important;
	left: 50%;
	top: 30px;
	font-family: cursive;
}
.multiselect-container {
	position: absolute;
	list-style-type: none;
	margin: 0;
	padding: 0
}
.multiselect-container .input-group {
	margin: 5px
}
.multiselect-container>li {
	padding: 0
}
.multiselect-container>li>a.multiselect-all label {
	font-weight: 700
}
.multiselect-container>li.multiselect-group label {
	margin: 0;
	padding: 3px 20px 3px 20px;
	height: 82%;
	font-weight: 700
}
.multiselect-container>li.multiselect-group-clickable label {
	cursor: pointer
}
.multiselect-container>li>a {
	padding: 0
}
.multiselect-container>li>a>label {
	margin: 0;
	height: 100%;
	cursor: pointer;
	font-weight: 400;
	padding: 3px 0 3px 30px
}
.multiselect-container>li>a>label.radio, .multiselect-container>li>a>label.checkbox {
	margin: 0
}
.multiselect-container>li>a>label>input[type=checkbox] {
	margin-bottom: 5px
}
.btn-group>.btn-group:nth-child(2)>.multiselect.btn {
	border-top-left-radius: 4px;
	border-bottom-left-radius: 4px
}
.form-inline .multiselect-container label.checkbox, .form-inline .multiselect-container label.radio {
	padding: 3px 20px 3px 40px
}
.form-inline .multiselect-container li a label.checkbox input[type=checkbox], .form-inline .multiselect-container li a label.radio input[type=radio] {
	margin-left: -20px;
	margin-right: 0
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
	$active_facturas="active";
	$active_compras="";
	$active_clientes="";
	$active_usuarios="";
	$title="Nuevo Documento | Maxim Inventory";

	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); // Proxies.
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	//Al crear nuevo documento se limpia antes la tabla tmp por session
	$session_id= session_id();
	$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
	
	//if(is_callable('curl_init')){
  	//	echo "Si";
	//}

	/*
	$api="http://bitapeso.com/json/"; 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$api);
	$result=curl_exec($ch);
	curl_close($ch);
	$get = json_decode($result, true);

	echo "Un dolar = $".round($get['dolar'],2)." MXN";
	
	*/

	//echo "1 Bitcoin = $".$get['mxn']." MXN";
	//echo "1 Bitcoin = $".$get['usd']." dolares";

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
			<button type="button" class="btn btn-success pull-right" id="return_doc" onclick="freturn_doc();">
				  <span class="glyphicon glyphicon-list-alt"></span> Regresar a lista de documentos
			</button>
			<h4><i class='glyphicon glyphicon-edit'></i> Nuevo Documento</h4>
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
						<select class='form-control input-sm' id="tipo_doc" onchange="change_tipo_doc();">
							<option value="1">VENTA</option>
							<option value="2" selected>COTIZACION</option>
					</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="nombrecliente" class="col-md-1 control-label">Cliente:</label>
					<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" Title="Selecciona un cliente del catálogo tecleando a partir de 3 caracteres, para un cliente foraneo teclea sus datos completos" maxlength="100" required >
					  <input id="id_cliente" type='hidden'>
					  <input id="tipo_prec_cliente" type='hidden'>	
					</div>

					<label for="tel1" class="col-md-1 control-label">Teléfono:</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" maxlength="30">
					</div>

					<label for="mail" class="col-md-1 control-label">Email:</label>
					 <div class="col-md-3">
						 <input type="email" multiple="multiple" class="form-control" id="mail" Title="Para agregar un correo electrónico más tecleé el símbolo: ," placeholder="ingrese correctamente el correo electrónico" maxlength="255" >
					 </div>
				 </div>
				 <div class="form-group row">
					 <div class="col-md-5">
						 <input type="text" class="form-control" id="direcc" Title="Ingrese correctamente la direccion sólo si el cliente es foraneo" placeholder="Ingrese dirección si el cliente es foraneo" maxlength="255" >
					 </div>
					 <div class="col-md-3">
						<input type="text" class="form-control input-sm" id="colonia" Title="Ingrese correctamente la colonia sólo si el cliente es foraneo" placeholder="Ingrese colonia si el cliente es foraneo" maxlength="100">
					 </div>
					 <div class="col-md-2">
						<input type="text" class="form-control input-sm" id="ciudad" Title="Ingrese correctamente la ciudad sólo si el cliente es foraneo" placeholder="Ingrese ciudad si el cliente es foraneo" maxlength="50">
					 </div>
					 <div class="col-md-2">
						<input type="text" class="form-control input-sm" id="rfc" Title="Ingrese correctamente el RFC sólo si el cliente es foraneo" placeholder="Ingrese RFC si el cliente es foraneo" maxlength="13">
					 </div>
				 </div>
				
						<div class="form-group row">
							<label for="vendedor" class="col-md-1 control-label">Vendedor:</label>
							<div class="col-md-3">
								<select class="form-control input-sm" id="id_vendedor">
									<?php
										$sql_vendedor=mysqli_query($con,"select * from users order by lastname");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$_SESSION['user_id']) {
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
							<label for="lblfecha" class="col-md-1 control-label">Fecha:</label>
							<div class="col-md-2">
								<input type="date" class="form-control input-sm" id="fecha_doc" value="<?php echo date("Y-m-d");?>" >
							</div>
							
							<label for="tipopago" class="col-md-1 control-label">Pago:</label>
							<div class="col-md-3">
								<select class='form-control input-sm' id="condiciones" disabled>
									<option value="1">Efectivo</option>
									<option value="2">Cheque</option>
									<option value="3">Transferencia bancaria</option>
									<option value="4">Crédito</option>
								</select>
							</div>
						
						</div>
				
				<div class="form-group row">
					<label for="lblmembresias" class="col-md-1 control-label">Membresias:</label>
					<div class="col-md-4">
						<select class="form-control input-sm" id="opt_membre" multiple="multiple">
							<?php
								$sql_prods=mysqli_query($con, "select * from products where ( nombre_producto like '%MEMBRESIA%' or nombre_producto like '%INTERNET DEDICADO%' or nombre_producto like '%INTERNET AVANZADO%' ) ");
								while ($rw=mysqli_fetch_array($sql_prods)){
									$id_producto=$rw["id_producto"];
									$nombre_producto=$rw["nombre_producto"];
							?>
									<option value="<?php echo $id_producto?>" <?php echo $selected;?>><?php echo $nombre_producto?></option>
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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="load(1);" >
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-primary">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
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
	<script type="text/javascript" src="js/nueva_factura.js"></script>
	<link rel="stylesheet" href="js/jquery-ui.css">
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootbox.js"></script>
	<script type="text/javascript" src="js/cssrefresh.js"></script>
	<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
		
	<script type="text/javascript">
		
		$('#opt_membre').multiselect({
			enableFiltering: true,
			includeSelectAllOption: true,
			numberDisplayed: 0,
			maxHeight: 160
		});
		
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
					//Necesitado para obtener el precio en los productos
					$('#tipo_prec_cliente').val(ui.item.tipo_prec_cliente);
					
					$('#tel1').attr('disabled', true);
					$('#mail').attr('disabled', true);
					
					//News add 13Oct2017
					$('#direcc').val(ui.item.direccion_cliente);
					$('#colonia').val(ui.item.col_cliente);
					$('#ciudad').val(ui.item.ciudad_cliente);
					$('#rfc').val(ui.item.rfc_cliente);
					$('#direcc').attr('disabled', true);
					$('#colonia').attr('disabled', true);
					$('#ciudad').attr('disabled', true);
					$('#rfc').attr('disabled', true);
				}
			});
		});
					
		$("#nombre_cliente" ).on( "keydown", function( event ) {
			//if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE ) {
			if (event.keyCode== event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE ) {
				$("#id_cliente" ).val("");
				$("#tel1" ).val("");
				$("#mail" ).val("");
				$('#tipo_prec_cliente').val("");
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
			if (event.keyCode==$.ui.keyCode.DELETE) {
				$("#nombre_cliente" ).val("");
				$("#id_cliente" ).val("");
				$("#tel1" ).val("");
				$("#mail" ).val("");
				$('#tipo_prec_cliente').val("");
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
		
	function fcheck_id_cliente() {
		var id_cliente = $("#id_cliente" ).val();
		var name_cliente = $("#nombre_cliente" ).val();
		
		if (id_cliente=="" )  {
			  if (name_cliente !== null ) {
					bootbox.alert('Cliente no seleccionado del catálogo, se tomará como cliente foraneo ?');
			  }
		}
	}
	
	function change_tipo_doc() {
		var tipo_doc = $('#tipo_doc').val();
		$('#condiciones').attr('disabled', tipo_doc == 1 ? false : true);
	}
		
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
	
	
	//Se guarda el documento a la tabla facturas y se pasa a la generación del pdf______________________________________
	$("#datos_factura").submit(function(event) {
		
		  event.preventDefault();
		
		  var tipo_doc = $("#tipo_doc").val();
		  var name_doc;
		  
		  if (tipo_doc==1) {
			  name_doc="Venta";
		  } else {
			  name_doc="Cotización";
		  }
		  
		  var id_cliente = $("#id_cliente").val();
		  var name_cliente = $("#nombre_cliente").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var condiciones = $("#condiciones").val();
		  var fecha_doc = $("#fecha_doc").val();
		  
		  var datoc1; var datoc2; var datoc3; var datoc4; var datoc5; var datoc6; var datoc7;
		  
		  if (id_cliente=="" )  {
			  if (name_cliente !== null ) {
					//bootbox.alert("Cliente no seleccionado del catálogo, se tomará como cliente foraneo");
					//bootstrap_alert.warning('Cliente no seleccionado del catálogo, se tomará como cliente foraneo');
					id_cliente=0;
					datoc1=$("#nombre_cliente").val();
					datoc2=$("#tel1").val();
					datoc3=$("#mail").val();
				    //News add 13Oct2017
					datoc4=$('#direcc').val();
					datoc5=$('#colonia').val();
					datoc6=$('#ciudad').val();
					datoc7=$('#rfc').val();
			  } else {
					alert("Se debe seleccionar un cliente");
					$("#nombre_cliente").focus();
					return false;
			  }
			} else {
				datoc1="";
				datoc2="";
				datoc3="";
				datoc4="";
				datoc5="";
				datoc6="";
				datoc7="";
			}
			
			var ner = 0;
			$.ajax({
					type: "POST",
					async: false,
					cache: false,
					url: "ajax/before_save_doc.php",
					beforeSend: function(objeto) {
						//$("#resultados").html("Guardando documento...");
					},
					success: function(msg) {
						if(msg=='error') {
							//$("#resultados").html("");
							ner=1;
							bootbox.alert('No hay productos agregados al documento');
							return false;
						} else {
							ner=2;
						}
					}
			});
		
		if (ner==2) {
			/*
			if (confirm("Guardar el documento ?") == true) {
				VentanaCentrada('./pdf/documentos/documento_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor +'&condiciones='+condiciones+'&tipo_doc='+tipo_doc+'&datoc1='+datoc1+'&datoc2='+datoc2+'&datoc3='+datoc3,name_doc, '', '1024', '768', 'true');
				//Reset del form de la nueva factura despues de la impresion
				$('#datos_factura').get(0).reset();
				$("#return_doc").click();
			}
			*/
			
			var ndoc=0;
			//var aparam = [id_cliente, id_vendedor, condiciones, tipo_doc, datoc1, datoc2, datoc3, datoc4]
			
			datoc4=datoc4.trim();
			
			//Get selection membresias
			var selected = $("#opt_membre option:selected");
        	var datoc8 = "";
			selected.each(function () {
				datoc8 += $(this).val() + ",";
			});
			
			//var aparam={'id_cliente':id_cliente,'id_vendedor':id_vendedor,'condiciones':condiciones,'tipo_doc':tipo_doc,'datoc1':datoc1,'datoc2':datoc2,'datoc3':datoc3,'datoc4':datoc4};
			var aparam={'id_cliente':id_cliente,'id_vendedor':id_vendedor,'fecha_doc':fecha_doc,'condiciones':condiciones,'tipo_doc':tipo_doc,'datoc1':datoc1,'datoc2':datoc2,'datoc3':datoc3,'datoc4':datoc4,'datoc5':datoc5,'datoc6':datoc6,'datoc7':datoc7,'datoc8':datoc8};
			var jsonString = JSON.stringify(aparam);
			
			//url:'./pdf/documentos/documento_pdf.php',
			//url: "ajax/pruebasajax.php",
			
			bootbox.confirm("Seguro de guardar el documento ?.", function (confirmed) {
				if (confirmed) {
				//* Se elimina la generacion del pfd,solo se procesa
					//VentanaCentrada('./pdf/documentos/documento_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor +'&condiciones='+condiciones+'&tipo_doc='+tipo_doc+'&datoc1='+datoc1+'&datoc2='+datoc2+'&datoc3='+datoc3,name_doc, '', '1024', '768', 'true');
					$.ajax({
						type: "POST",
						url:'pdf/documentos/documento_pdf.php',
						data: {'data' : jsonString},
						async: true,
						cache: false,
						dataType: "JSON",
						beforeSend: function(objeto) {
				  	},
						success:function(data) {
							//alert("success: "+data);
							data = data.trim();
							ndoc = data;	//Solo guarda el valor
						},
						error: function(jqXHR, textStatus, errorThrown) {
							//alert("jqXHR: "+jqXHR+", textStatus:"+textStatus+", errorThrown:"+errorThrown);
						}
					})
					
					//Reset del form de la nueva factura despues de la impresion
					$('#datos_factura').get(0).reset();
					$("#return_doc").click();
			}
		});
		
		}
		
	});
		
	function freturn_doc() {
		location.href = 'facturas.php';
	}
	
	$( function() {
		$( document ).tooltip({
		  position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
			  $( this ).css( position );
			  $( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			}
		  }
		});
  	});
		
	</script>

  </body>
</html>