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
	
	$active_productos="active";
	$title="Productos | Maxim Ventas";
	
	if (isset($con)) {
		$qry_utili=mysqli_query( $con, "select * from utilidades where id=1" );
		if ($qry_utili) {
			$rw=mysqli_fetch_array($qry_utili);
			$utilidad_1=$rw['utilidad_1'];
			$utilidad_2=$rw['utilidad_2'];
			$utilidad_3=$rw['utilidad_3'];
			$utilidad_4=$rw['utilidad_4'];
		} else {
			$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Productos ".mysqli_error($con);
		}
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
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</button>
				<a href="reportes/rpt_products01.php" class='btn btn-info' ><i class="glyphicon glyphicon-export"></i> Exportar a Excel</a>
			</div>
			
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Productos</h4>
		</div>
		<div class="panel-body">
			
			<?php
			include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			?>
			<form class="form-horizontal" role="form" id="datos_productos">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Código o nombre</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Código o nombre del producto" onkeyup='load(1,8);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1,8);'>
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
	<script type="text/javascript" src="js/productos.js"></script>
	<script src="js/bootbox.js"></script>
  </body>
</html>


<script>
	
	
$( "#guardar_producto" ).submit(function( event ) {
  //$('#guardar_datos').attr("disabled", true);
  
  //var parametros = $(this).serialize();
 	var formData = new FormData(this);
 
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_producto.php",
			data: formData,
		 	mimeType:"multipart/form-data",
		 	contentType: false,
			cache: false,
			processData: false,
			beforeSend: function(objeto){
				$("#resultados_ajax_productos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_productos").html(datos);
			$('#guardar_datos').attr("disabled", true);
			load(1,8);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
  //$('#actualizar_datos').attr("disabled", true);
  
	//var parametros = $(this).serialize();
 	var formData = new FormData(this);
	
	 $.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
		    data: formData,
		 	mimeType:"multipart/form-data",
		 	contentType: false,
			cache: false,
			processData: false,
			beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", true);
			load(1,8);
		  }
	});
  
  event.preventDefault();
  
})

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
	$('#guardar_datos').attr("disabled", false);
})

$('#myModal2').on('hidden.bs.modal', function () {
	$('#alert1').hide();
	$('#alert2').hide();
	//$("#myModal2").get(0).reset();
	//$('#myModal2').data('formValidation').resetForm(true);
	$('#myModal2').find('form').trigger('reset');
	$('#actualizar_datos').attr("disabled", false);
})

function obtener_datos(id) {
	var codigo_producto = $("#codigo_producto"+id).val();
	var nombre_producto = $("#nombre_producto"+id).val();
	var nombre_productol = $("#nombre_productol"+id).val();
	var id_provee = $("#id_provee"+id).val();
	var id_unidad = $("#id_unidad"+id).val();
	var id_linea = $("#id_linea"+id).val();
	var id_marca = $("#id_marca"+id).val();
	var estado = $("#estado"+id).val();
	var precio_cost = $("#precio_cost"+id).val();
	var precio_show1 = $("#precio_show1"+id).val();
	var precio_show2 = $("#precio_show2"+id).val();
	var precio_show3 = $("#precio_show3"+id).val();
	var precio_show4 = $("#precio_show4"+id).val();

	var utili1 = $("#utili1"+id).val();
	var utili2 = $("#utili2"+id).val();
	var utili3 = $("#utili3"+id).val();
	var utili4 = $("#utili4"+id).val();
	/*
	var precio_producto = $("#precio_producto"+id).val();
	var precio2 = $("#precio2"+id).val();
	var precio3 = $("#precio3"+id).val();
	var precio4 = $("#precio4"+id).val();
	*/
	
	//alert(typeof precio_producto);
	//precio_producto=parseFloat(precio_producto);
	
	var prod_iva = $("#prod_iva"+id).val();
	var prod_invent = $("#prod_invent"+id).val();
	var stock_min = $("#stock_min"+id).val();
	var invent_ini = $("#invent_ini"+id).val();
	var product_img = $("#product_img"+id).val();
	
	$("#mod_id").val(id);
	$("#mod_codigo").val(codigo_producto);
	$("#mod_nombre").val(nombre_producto);
	$("#mod_nombrel").val(nombre_productol);
	$("#mod_id_provee").val(id_provee);
	$("#mod_id_unidad").val(id_unidad);
	$("#mod_id_linea").val(id_linea);
	$("#mod_id_marca").val(id_marca);
	$("#mod_estado").val(estado);
	$("#mod_precio_cost").val(precio_cost);
	$("#mod_utili1").val(utili1);
	$("#mod_utili2").val(utili2);
	$("#mod_utili3").val(utili3);
	$("#mod_utili4").val(utili4);
	$("#mod_precio1").val(precio_show1);
	$("#mod_precio2").val(precio_show2);
	$("#mod_precio3").val(precio_show3);
	$("#mod_precio4").val(precio_show4);
	$('#mod_prod_iva').attr('checked', prod_iva == 1 ? true : false);
	$('#mod_prod_invent').attr('checked', prod_invent == 1 ? true : false);
	$("#mod_stock_min").val(stock_min);
	$("#mod_invent_ini").val(invent_ini);
	$('#myImg').attr('src', "./uploads/" + product_img);
	
}
</script>