	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Proveedor</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_proveedor" name="guardar_proveedor">
			<div id="resultados_ajax"></div>
				
				<div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Nombre:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100">
					</div>
				</div>
				
				<div class="form-group">
					<label for="rfc_prove" class="col-sm-3 control-label">RFC:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="rfc_prove" name="rfc_prove" required maxlength="15">
					</div>
				</div>
				
				<div class="form-group">
					<label for="direccion" class="col-sm-3 control-label">Dirección:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="direccion" name="direccion" required maxlength="100">
					</div>
				</div>
				
				<div class="form-group">
					<label for="colprove" class="col-sm-3 control-label">Colonia:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="col_prove" name="col_prove" maxlength="100">
					</div>
				</div>
				
				<div class="form-group">
					<label for="cpprove" class="col-sm-3 control-label">Código Postal:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="cp_prove" name="cp_prove" maxlength="10">
					</div>
				</div>
				
				<div class="form-group">
					<label for="ciudadprove" class="col-sm-3 control-label">Ciudad:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="ciudad_prove" name="ciudad_prove" maxlength="50">
					</div>
				</div>
				
				<div class="form-group">
					<label for="estprove" class="col-sm-3 control-label">Estado:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="estado_prove" name="estado_prove" maxlength="20">
					</div>
				</div>
				
				<div class="form-group">
					<label for="telef1prove" class="col-sm-3 control-label">Teléfono 1:</label>
					<div class="col-sm-8">
						  <input type="text" class="form-control" id="tele1_prove" name="tele1_prove" maxlength="20">
					</div>
				</div>
				
				<div class="form-group">
					<label for="telef2prove" class="col-sm-3 control-label">Teléfono 2:</label>
					<div class="col-sm-8">
						  <input type="text" class="form-control" id="tele2_prove" name="tele2_prove" maxlength="20">
					</div>
				</div>
			  
			  	<div class="form-group">
					<label for="emailprove" class="col-sm-3 control-label">Email:</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" id="email_prove" name="email_prove" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" maxlength="50" >
					</div>
				</div>
				
				<div class="form-group">
					<label for="rlprove" class="col-sm-3 control-label">Representante Legal:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="rl_prove" name="rl_prove" maxlength="50">
					</div>
				</div>
				
				<div class="panel panel-info">
				  <div class="panel-heading">ESTATUS DEL PROVEEDOR</div>
					<div class="form-group panel-body">
						<label for="saldoprove" class="col-sm-3 control-label">Saldo:</label>
						<div class="col-sm-8" >
						  <input type="text" class="form-control" id="saldo_prove" name="saldo_prove" pattern="\d+(\.\d{2})?" title="Ingresa sólo números">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 form-check-label">Días de credito:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="dias_cred_prove" name="dias_cred_prove" pattern="\d{1,3}" title="Ingresa sólo números">
						</div>
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
	
	<script>
	</script>

	<?php
		}
	?>