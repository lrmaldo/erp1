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

	$active_lineas="active";
	$title="Lineas | Maxim Ventas";
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
	
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoLinea"><span class="glyphicon glyphicon-plus" ></span> Nueva Linea</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Lineas</h4>
		</div>
		<div class="panel-body">
			
			<?php
			
			include("modal/mod_frm_new_lineas.php");	//Here change by another
			include("modal/mod_frm_edit_lineas.php");	//Here change by another
			
			?>
			<form class="form-horizontal" role="form" id="datos_lineas">
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Código o nombre</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Código o nombre de la lineas" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/lineas.js"></script>
  </body>
</html>


<script>
$( "#guardar_linea" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
		
		var parametros = $(this).serialize();

		 $.ajax({
				type: "POST",
				url: "ajax/new_linea.php",
				data: parametros,
				beforeSend: function(objeto){
					$("#resultados_ajax_lineas").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$("#resultados_ajax_lineas").html(datos);
				$('#guardar_datos').attr("disabled", false);
				load(1);
			  }
		});
	
	event.preventDefault();

})

$( "#editar_linea" ).submit(function( event ) {
  
  $('#actualizar_datos').attr("disabled", true);
  
	var parametros = $(this).serialize();
	
	 $.ajax({
			type: "POST",
			url: "ajax/save_linea.php",
		    data: parametros,
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

	
$('#nuevoLinea').on('hidden.bs.modal', function () {
	$('#alert1').hide();
	$('#alert2').hide();
	$('#nuevoLinea').find('form').trigger('reset');
})


$('#myModal2').on('hidden.bs.modal', function () {
	$('#alert1').hide();
	$('#alert2').hide();
	$('#editar_linea').find('form').trigger('reset');
})

function obtener_datos(id){
	var nombre_linea = $("#nombre_linea"+id).val();
	$("#mod_id").val(id);
	$("#mod_nombre").val(nombre_linea);
	}
</script>