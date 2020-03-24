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
	$title="Documentos | Maxim Ventas";

	if (isset($_SESSION['num_doc'])) {
		$num_doc=$_SESSION['num_doc'];
		unset($_SESSION['num_doc']);
		//print "Num_doc: " . $num_doc;
	} else {
	   	$num_doc=0;
		//print "Num_doc: " . $num_doc;
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
				<a  href="nueva_factura.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Documento</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Documentos</h4>
		</div>
			<div class="panel-body">
				
				<?php
					//include("modal/mod_frm_send_mail.php");
				?>
				
				<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Cliente o # de Documento</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre del cliente o # de documento" onkeyup='load(1);'>
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
	  
	  
	  		<!-- Modal -->
			<div class="modal fade" id="mailsend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Envio de correo</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal" method="post" id="id_mailsend" name="id_mailsend">
					<div id="resultados_ajax_mailsend"></div>

					  <div class="form-group">
						  <label for="nombre" class="col-sm-3 control-label">Documento No. </label>
						  <div class="col-sm-3">
							<label id="LblName" for="nombre" class="col-sm-3 control-label" ></label>
						</div>
					  </div>
					  <div class="form-group">
						  <label for="nombre" class="col-sm-3 control-label">Nombre</label>
						  <div class="col-sm-8">
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la marca" required >
						</div>
					  </div>

				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" id="send_mail" onclick="fsend_mail()">Enviar correo</button>
				  </div>
				  </form>
				</div>
			  </div>
			</div>	
	  
	  
	  
	  
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/facturas.js"></script>
	<script src="js/bootbox.js"></script>
	<script type="text/javascript" src="js/cssrefresh.js"></script>
  </body>
</html>

<script>
	
	//* Crear pdf ultimo documento generado automaticamente
	var num_doc=<?php echo $num_doc;?>;
	if (num_doc>0) {
		imprimir_factura(num_doc, 0);
	}
	
	function obtener_datos(id) {
		//var nombre_marca = $("#nombre"+id).val();
		//document.getElementById('LblName').innerHTML = "Documento No. " + id;
		document.getElementById('LblName').innerHTML = id;
		$("#nombre").val(id);
	}
	
	function fsend_mail() {
		$('#mailsend').modal('toggle');
		var id_doc = $("#nombre").val();
		imprimir_factura(id_doc,1);
	}
	
	
	$('#mailsend').on('hidden.bs.modal', function () {
		//$('#alert1').hide();
		//$('#editar_marca').find('form').trigger('reset');
	})

</script>