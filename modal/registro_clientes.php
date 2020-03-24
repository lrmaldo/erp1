	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo Cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>
				
				<div class="form-group">
				<label for="tipocliente" class="col-sm-3 control-label">Tipo Cliente:</label>
				<div class="col-sm-8">
				 <select class="form-control" id="tipo_clie" name="tipo_clie" onchange="fchktiporfc();" required>
					<option value="">-- Tipo Cliente --</option>
					<option value="1" selected>Persona Física</option>
					<option value="2">Persona Moral</option>
				  </select>
				</div>
			  	</div>
				
				<div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Nombre:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100" >
					</div>
				</div>
				
				<div class="form-group">
					<label for="rfc" class="col-sm-3 control-label">RFC:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="rfc_clie" name="rfc_clie" maxlength="13">
					</div>
				</div>
				
				<div class="form-group">
					<label for="apepat" class="col-sm-3 control-label">Apellido Paterno:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="ape_pat" name="ape_pat" required maxlength="50">
					</div>
				</div>
				
				<div class="form-group">
					<label for="apemat" class="col-sm-3 control-label">Apellido Materno:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="ape_mat" name="ape_mat" required maxlength="50">
					</div>
				</div>
				
				<div class="form-group">
					<label for="direccion" class="col-sm-3 control-label">Dirección:</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="direccion" name="direccion" required maxlength="255" ></textarea>

					</div>
				</div>
				
				<div class="form-group">
					<label for="colclie" class="col-sm-3 control-label">Colonia:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="col_clie" name="col_clie" maxlength="100">
					</div>
				</div>
				
				<div class="form-group">
					<label for="cpclie" class="col-sm-3 control-label">Código Postal:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="cp_clie" name="cp_clie" maxlength="08">
					</div>
				</div>
				
				<div class="form-group">
					<label for="ciudadclie" class="col-sm-3 control-label">Ciudad:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="ciudad_clie" name="ciudad_clie" maxlength="50">
					</div>
				</div>
				
				<div class="form-group">
					<label for="colclie" class="col-sm-3 control-label">Estado:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="estado_clie" name="estado_clie" maxlength="20">
					</div>
				</div>
				
				<div class="form-group">
					<label for="paisclie" class="col-sm-3 control-label">Pais:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="pais_clie" name="pais_clie" value="MEXICO" maxlength="20">
					</div>
				</div>
				
				<div class="form-group">
					<label for="telefono" class="col-sm-3 control-label">Teléfono:</label>
					<div class="col-sm-8">
						  <input type="text" class="form-control" id="telefono" name="telefono" maxlength="30">
					</div>
				</div>
			  
			  	<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email:</label>
					<div class="col-sm-8">
						<input type="email" multiple="multiple" class="form-control" id="email" name="email" Title="Para agregar un correo electrónico más tecleé el símbolo: ," placeholder="ingrese correctamente el correo electrónico" >
					</div>
				</div>
				
				<div class="form-group">
					<label for="asignprecio" class="col-sm-3 control-label">Tipo de precio:</label>
					<div class="col-sm-8">
					<select class="form-control" id="tipo_prec_clie" name="tipo_prec_clie" required>
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
						  <input type="text" class="form-control" id="lim_cred_clie" name="lim_cred_clie" pattern="\d+(\.\d{2})?" title="Ingresa sólo números">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 form-check-label">Activar credito:</label>
						<div class="col-sm-8">
							<input type="checkbox" class="form-check-input" name="act_cred_clie" id="act_cred_clie" >
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="estatus" class="col-sm-3 control-label">Estatus:</label>
					<div class="col-sm-8">
					 <select class="form-control" id="estatus" name="estatus" required>
						<option value="">-- Selecciona Estatus--</option>
						<option value="1" selected>Activo</option>
						<option value="0">Inactivo</option>
					  </select>
					</div>
				</div>
		  		</div>
		  
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="guardar_datos" >Guardar datos</button>
			 </div>
		  </form>
		
		  </div>
	  </div>
	</div>
	
	<script>
		
		function fchktiporfc() {
			var selecvalue = $('#tipo_clie').val();
			$("#ape_mat").prop("required", selecvalue == 1 ? true : false);
			$("#ape_mat").prop("disabled", selecvalue == 1 ? false : true);
			$("#ape_mat").val("");
			$("#ape_pat").prop("required", selecvalue == 1 ? true : false);
			$("#ape_pat").prop("disabled", selecvalue == 1 ? false : true);
			$("#ape_pat").val("");
		}
		
		function fchkmails() {
			/*
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
			if(inputText.value.match(mailformat))  {  
				document.form1.text1.focus();  
				return true;  
			}  else  {  
				alert("You have entered an invalid email address!");  
				document.form1.text1.focus();  
				return false;  
			}
			*/
			
			var dmail = $("#email").val();
			// NOTA: Falta terminar la verificacion del mail
			
		}
			
		
	</script>

	<?php
		}
	?>