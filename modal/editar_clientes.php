	<?php
		if (isset($con))
		{
	?>

	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar cliente</h4>
		  </div>
		  <div class="modal-body">
			
			<form class="form-horizontal" method="post" id="editar_cliente" name="editar_cliente">
			<div id="resultados_ajax2"></div>
				
				<div class="form-group">
				<label for="tipocliente" class="col-sm-3 control-label">Tipo Cliente:</label>
				<div class="col-sm-8">
					<input type="hidden" name="mod_id" id="mod_id">
				 <select class="form-control" id="mod_tipo_clie" name="mod_tipo_clie" onchange="fmodchktiporfc();" required>
					<option value="">-- Tipo Cliente --</option>
					<option value="1" selected>Persona Física</option>
					<option value="2">Persona Moral</option>
				  </select>
				</div>
			  	</div>
				
				<div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Nombre:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" required maxlength="100">
					</div>
				</div>
				
				<div class="form-group">
					<label for="apepat" class="col-sm-3 control-label">Apellido Paterno:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_ape_pat_clie" name="mod_ape_pat_clie" required maxlength="50">
					</div>
				</div>
				
				<div class="form-group">
					<label for="apemat" class="col-sm-3 control-label">Apellido Materno:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_ape_mat_clie" name="mod_ape_mat_clie" required maxlength="50">
					</div>
				</div>
				
				<div class="form-group">
					<label for="rfc" class="col-sm-3 control-label">RFC:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_rfc_clie" name="mod_rfc_clie" required maxlength="13">
					</div>
				</div>
				
				<div class="form-group">
					<label for="direccion" class="col-sm-3 control-label">Dirección:</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="mod_direccion" name="mod_direccion" required maxlength="255" ></textarea>

					</div>
				</div>
				
				<div class="form-group">
					<label for="colclie" class="col-sm-3 control-label">Colonia:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_col_clie" name="mod_col_clie" required maxlength="100">
					</div>
				</div>
				
				<div class="form-group">
					<label for="cpclie" class="col-sm-3 control-label">Código Postal:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_cp_clie" name="mod_cp_clie" required maxlength="08">
					</div>
				</div>
				
				<div class="form-group">
					<label for="ciudadclie" class="col-sm-3 control-label">Ciudad:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_ciudad_clie" name="mod_ciudad_clie" required maxlength="50">
					</div>
				</div>
				
				<div class="form-group">
					<label for="colclie" class="col-sm-3 control-label">Estado:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_estado_clie" name="mod_estado_clie" required maxlength="20">
					</div>
				</div>
				
				<div class="form-group">
					<label for="paisclie" class="col-sm-3 control-label">Pais:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_pais_clie" name="mod_pais_clie" required maxlength="20">
					</div>
				</div>
				
				<div class="form-group">
					<label for="telefono" class="col-sm-3 control-label">Teléfono:</label>
					<div class="col-sm-8">
						  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono" maxlength="30">
					</div>
				</div>
			  
			  	<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email:</label>
					<div class="col-sm-8">
						<input type="email" multiple="multiple" class="form-control" id="mod_email" name="mod_email" Title="Para agregar un correo electrónico más tecleé el símbolo: ," placeholder="ingrese correctamente el correo electrónico" >
					</div>
				</div>
				
				<div class="form-group">
				<label for="asignprecio" class="col-sm-3 control-label">Tipo de precio:</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_tipo_prec_clie" name="mod_tipo_prec_clie" required>
					<option value="">-- Seleccionar precio --</option>
					<option value="1" selected>Precio 1</option>
					<option value="2">Precio 2</option>
					<option value="3">Precio 3</option>
					<option value="4">Precio 4</option>
				  </select>
				</div>
			  	</div>
				
				<div class="panel panel-info">
				  <div class="panel-heading">CREDITO DE CLIENTE</div>
					<div class="form-group panel-body">
						<label for="limcred" class="col-sm-3 control-label">Límite de crédito:</label>
						<div class="col-sm-8" >
						  <input type="text" class="form-control" id="mod_lim_cred_clie" name="mod_lim_cred_clie" pattern="\d+(\.\d{2})?" title="Ingresa sólo números">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 form-check-label">Activar credito:</label>
						<div class="col-sm-8">
							<input type="checkbox" class="form-check-input" name="mod_act_cred_clie" id="mod_act_cred_clie" >
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="estatus" class="col-sm-3 control-label">Estatus:</label>
					<div class="col-sm-8">
					 <select class="form-control" id="mod_estatus" name="mod_estatus" required>
						<option value="">-- Selecciona Estatus--</option>
						<option value="1" selected>Activo</option>
						<option value="0">Inactivo</option>
					  </select>
					</div>
				</div>
		  	</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
			</div>
				
		  </form>
			
		</div>
	  </div>
	</div>
	
	<script>
		
		function fmodchktiporfc(){
			var selecvalue = $('#mod_tipo_clie').val();
			$("#mod_ape_pat_clie").prop("required", selecvalue == 1 ? true : false);
			$("#mod_ape_pat_clie").prop("disabled", selecvalue == 1 ? false : true);
			//$("#mod_ape_pat_clie").val("");
			$("#mod_ape_mat_clie").prop("required", selecvalue == 1 ? true : false);
			$("#mod_ape_mat_clie").prop("disabled", selecvalue == 1 ? false : true);
			//$("#mod_ape_mat_clie").val("");
		}
		
	</script>

	<?php
		}
	?>