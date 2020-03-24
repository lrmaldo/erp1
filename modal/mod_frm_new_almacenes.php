	<?php
		if (isset($con))
		{
	?>

	<!-- Modal -->
	<div class="modal fade" id="nuevoAlmacen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Almacen</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_almacen" name="guardar_almacen">
				<div id="resultados_ajax_almacenes"></div>

				  <div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Nombre:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del almacen" pattern="(?=.*[A-Z]).{3,30}" title="Sólo mayusculas,3 caracteres mínimo 50 máximo" required >
					</div>
				  </div>

				<div class="form-check">
					<label class="col-sm-3 form-check-label"> Activado:</label>
					<div class="col-sm-8">
						<input type="checkbox" class="form-check-input" name="activate" id="activate" >
					</div>
				</div>
				
			  </div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
			  </div>
		  
			</form>
		
		</div>
	  </div>
	</div>
	<?php
		}
	?>