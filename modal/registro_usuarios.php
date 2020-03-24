	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo usuario</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Nombre:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombres" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="lastname" class="col-sm-3 control-label">Apellidos:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellidos" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="user_name" class="col-sm-3 control-label">Usuario:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Nombre de usuario para acceder al sistema" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="user_email" class="col-sm-3 control-label">Correo primario:</label>
				<div class="col-sm-8">
				  <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo primario" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="pasw_mail" class="col-sm-3 control-label">Contraseña correo primario:</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="paswr_email2" name="paswr_email2" placeholder="Contraseña del correo primario" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mailalterno" class="col-sm-3 control-label">Correo alterno:</label>
				<div class="col-sm-8">
				  <input type="email" class="form-control" id="mail_alterno" name="mail_alterno" placeholder="Correo alterno">
				</div>
			  </div>
				
			 <div class="form-group">
				<label for="typeuser" class="col-sm-3 control-label">Tipo de usuario:</label>
				<div class="col-sm-8">
				<select class="form-control" id="type_user" name="type_user" title="Usuario: Admin-Tiene todos los privilegios y normal No" required>
					<option value="0" selected>Normal</option>
					<option value="1">Admin</option>
				  </select>
				</div>
			  </div>
				
			  <div class="form-group">
				<label for="user_password_new" class="col-sm-3 control-label">Contraseña:</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="user_password_new" name="user_password_new" placeholder="Contraseña para el acceso al sistema" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="user_password_repeat" class="col-sm-3 control-label">Repite contraseña:</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Repite contraseña para el acceso al sistema" pattern=".{6,}" required>
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