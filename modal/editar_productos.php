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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar producto </h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" enctype="multipart/form-data" method="post" id="editar_producto" name="editar_producto" >
			<div id="resultados_ajax2"></div>
			  
				<div class="form-group">
					<label for="codigo" class="col-sm-3 control-label">Código:</label>
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-barcode"></span></span>
							<input type="text" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" required maxlength="20" >
							<input type="hidden" name="mod_id" id="mod_id">
						</div>
					</div>
				</div>
			  
			  	<div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Nombre Producto:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required maxlength="50">
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="nombrel" class="col-sm-3 control-label">Descripcion larga:</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="mod_nombrel" name="mod_nombrel" placeholder="Descripción larga del producto" maxlength="255" ></textarea>
					</div>
			  	</div>
			  
				<div class="form-group">
					<label for="provee" class="col-sm-3 control-label">Proveedor:</label>
					<div class="col-sm-8">
					 <select class="form-control" id="mod_id_provee" name="mod_id_provee" >
						<option value="">-- Selecciona proveedor --</option>
						<?php
							$sql_linea=mysqli_query($con,"select id_prove,nombre_prove from proveedores");
							while ($rw=mysqli_fetch_array($sql_linea)){
								$id_provee_field=$rw["id_prove"];
								$nombre_provee=$rw["nombre_prove"];
						?>
						<option value="<?php echo $id_provee_field?>" <?php echo $selected;?>><?php echo $nombre_provee?></option>
						<?php
						}
						?>
					  </select>
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="unidad" class="col-sm-3 control-label">Unidad:</label>
					<div class="col-sm-8">
					<select class='form-control input-sm' id="mod_id_unidad" name="mod_id_unidad" required >
						<option value="">-- Selecciona Unidad --</option>
						<?php
							$sql_unidad=mysqli_query($con,"select id_unidad,nombre_unidad from unidades");
							while ($rw=mysqli_fetch_array($sql_unidad)){
								$id_unidad_field=$rw["id_unidad"];
								$nombre_unidad=$rw["nombre_unidad"];
						?>
						<option value="<?php echo $id_unidad_field?>" <?php echo $selected;?>><?php echo $nombre_unidad?></option>
						<?php
						}
						?>
					</select>
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="linea" class="col-sm-3 control-label">Linea:</label>
					<div class="col-sm-8">
					<select class='form-control input-sm' id="mod_id_linea" name="mod_id_linea" required >
						<option value="">-- Selecciona Linea --</option>
						<?php
							$sql_linea=mysqli_query($con,"select id_linea,nombre_linea from lineas");
							while ($rw=mysqli_fetch_array($sql_linea)){
								$id_linea_field=$rw["id_linea"];
								$nombre_linea=$rw["nombre_linea"];
						?>
						<option value="<?php echo $id_linea_field?>" <?php echo $selected;?>><?php echo $nombre_linea?></option>
						<?php
						}
						?>
					</select>
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="marca" class="col-sm-3 control-label">Marca:</label>
					<div class="col-sm-8">
					<select class='form-control input-sm' id="mod_id_marca" name="mod_id_marca" >
					<option value="">-- Selecciona Marca --</option>
					<?php
						$sql_marca=mysqli_query($con,"select id_marca,nombre_marca from marcas");
						while ($rw=mysqli_fetch_array($sql_marca)){
							$id_marca=$rw["id_marca"];
							$nombre_marca=$rw["nombre_marca"];
					?>
					<option value="<?php echo $id_marca?>" <?php echo $selected;?>><?php echo $nombre_marca?></option>
					<?php
					}
					?>
					</select>
					</div>
			  	</div>	
				
				<div class="form-group">
					<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-8">
					 <select class="form-control" id="mod_estado" name="mod_estado" required>
						<option value="">-- Selecciona estado --</option>
						<option value="1" selected>Activo</option>
						<option value="0">Inactivo</option>
					  </select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="precio_cost" class="col-sm-3 control-label">Precio costo:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_precio_cost" name="mod_precio_cost" placeholder="Precio de compra del producto" pattern="\d+(\.\d{2})?" onkeyup="fmod_precio_cost();" title="Ingresa sólo números" >
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="utili" class="col-sm-3 control-label">% Utilidades:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_utili1" name="mod_utili1" placeholder="% de utilidad de ganancia precio 1"  pattern="\d{1,4}" maxlength="4" onkeyup="fmod_utili(1);" title="Ingresa sólo números" >
					  <input type="text" class="form-control" id="mod_utili2" name="mod_utili2" placeholder="% de utilidad de ganancia precio 2" pattern="\d{1,4}" maxlength="4" onkeyup="fmod_utili(2);" title="Ingresa sólo números" >
					  <input type="text" class="form-control" id="mod_utili3" name="mod_utili3" placeholder="% de utilidad de ganancia precio 3" pattern="\d{1,4}" maxlength="4" onkeyup="fmod_utili(3);" title="Ingresa sólo números" >
					  <input type="text" class="form-control" id="mod_utili4" name="mod_utili4" placeholder="% de utilidad de ganancia precio 4" pattern="\d{1,4}" maxlength="4" onkeyup="fmod_utili(4);" title="Ingresa sólo números" >
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="precio1" class="col-sm-3 control-label">Precio 1:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_precio1" name="mod_precio1" placeholder="Precio 1 de venta del producto" required pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="precio2" class="col-sm-3 control-label">Precio 2:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_precio2" name="mod_precio2" placeholder="Precio 2 de venta del producto" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
					</div>
				</div>
				
			  	<div class="form-group">
					<label for="precio3" class="col-sm-3 control-label">Precio 3:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_precio3" name="mod_precio3" placeholder="Precio 3 de venta del producto" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="precio4" class="col-sm-3 control-label">Precio 4:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_precio4" name="mod_precio4" placeholder="Precio 4 de venta del producto" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
					</div>
			  	</div>
				
				<div class="form-group">
					<label class="col-sm-3 form-check-label">Utiliza IVA:</label>
					<div class="col-sm-8">
						<input type="checkbox" class="form-check-input" name="mod_prod_iva" id="mod_prod_iva" >
					</div>
			    </div>
				
				<div class="form-group">
					<label class="col-sm-3 form-check-label">Producto inventariable:</label>
					<div class="col-sm-8">
						<input type="checkbox" class="form-check-input" name="mod_prod_invent" id="mod_prod_invent" >
					</div>
				</div>
				
				<div class="form-group">
					<label for="stock_min" class="col-sm-3 control-label">Stock minimo:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_stock_min" name="mod_stock_min" placeholder="Cantidad minima requerida en inventario" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
					</div>
			  	</div>
				
			  	<div class="form-group">
					<label for="invent_ini" class="col-sm-3 control-label">Inventario inicial:</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="mod_invent_ini" name="mod_invent_ini" placeholder="Cantidad del producto contado al registro" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" disabled>
					</div>
			  	</div>
				
			  	<div class="form-group">
					<label for="imagen" class="col-sm-3 control-label">Imagen:</label>
					<div class="col-sm-8">
					  <input type="file" name="product_img" class="form-control" id="product_img" >
						<img id="myImg" src="#" height="200" class="img-responsive">
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
	
		function fmod_precio_cost(){
		
		var precio_cost = $("#mod_precio_cost").val();
		var metod=0;
		var utili1 = $("#mod_utili1").val();
		var utili2 = $("#mod_utili2").val();
		var utili3 = $("#mod_utili3").val();
		var utili4 = $("#mod_utili4").val();
		
		var param = {"utili1":utili1,"utili2":utili2,"utili3":utili3,"utili4":utili4,"precio_cost":precio_cost,"metod":metod};
		$.ajax({
				dataType: "json",
				type:"POST",
				url:'./ajax/preciosventa.php',
				data: param,
				 success:function(data){
				 $.each(data, function(index, element) {
					var precio1= element.precio1;
					var precio2= element.precio2;
					var precio3= element.precio3;
					var precio4= element.precio4;
					$("#mod_precio1").val(precio1);
					$("#mod_precio2").val(precio2);
					$("#mod_precio3").val(precio3);
					$("#mod_precio4").val(precio4);
					 
                });
				}
			})
		
	}
		
	function fmod_utili(_n){
		
		var precio_cost = $("#mod_precio_cost").val();
		var metod=1;
		var utili1 = $("#mod_utili"+_n).val();
		
		var param = {"utili1":utili1,"precio_cost":precio_cost,"metod":metod};
		$.ajax({
				dataType: "json",
				type:"POST",
				url:'./ajax/preciosventa.php',
				data: param,
				 success:function(data){
				 $.each(data, function(index, element) {
					var precio= element.precio;
					$("#mod_precio"+_n).val(precio);
                });
				}
			})
		
	}
		
	</script>
	
	<?php
		}
	?>