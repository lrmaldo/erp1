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
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$active_proveedores="active";
	$title="Proveedores | Maxim Ventas";
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
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoProveedor"><span class="glyphicon glyphicon-plus" ></span> Nuevo Proveedor</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Proveedores</h4>
		</div>
		<div class="panel-body">
			
			<?php
				include("modal/registro_proveedores.php");
				include("modal/editar_proveedores.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Proveedor</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre del proveedor" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/proveedores.js"></script>
  </body>
</html>

<script>
$( "#guardar_proveedor" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var param = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_proveedor.php",
			data: param,
			beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			},
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_proveedor" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var param = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_proveedor.php",
			data: param,
			beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			},
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var nombre_cliente = $("#nombre_cliente"+id).val();
			var telefono_cliente = $("#telefono_cliente"+id).val();
			var email_cliente = $("#email_cliente"+id).val();
			var direccion_cliente = $("#direccion_cliente"+id).val();
			var status_cliente = $("#status_cliente"+id).val();
			
			$("#mod_nombre").val(nombre_cliente);
			$("#mod_telefono").val(telefono_cliente);
			$("#mod_email").val(email_cliente);
			$("#mod_direccion").val(direccion_cliente);
			$("#mod_estatus").val(status_cliente);
			//$('#mod_act_cred_clie').attr('checked', act_cred_cliente == 1 ? true : false);
			$("#mod_id").val(id);
		
		}

$('#nuevoProveedor').on('hidden.bs.modal', function () {
	$('#alert1').hide();
	$('#alert2').hide();
	$('#nuevoProveedor').find('form').trigger('reset');
})


$('#myModal2').on('hidden.bs.modal', function () {
	$('#alert1').hide();
	$('#alert2').hide();
	$('#editar_proveedor').find('form').trigger('reset');
})

</script>

