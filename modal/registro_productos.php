	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto </h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" enctype="multipart/form-data" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>
				
				<div class="form-group">
					<label for="codigo" class="col-sm-3 control-label">Código:</label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-barcode"></span></span>
								<input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" required maxlength="20" >
							</div>
						</div>
				</div>
			  
			  	<div class="form-group">
					<label for="nombre" class="col-sm-3 control-label">Nombre Producto:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" maxlength="50" required>
					</div>
			  	</div>
				
				<div class="form-group">
					<label for="nombrel" class="col-sm-3 control-label">Descripcion larga:</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="nombrel" name="nombrel" placeholder="Descripción larga del producto" maxlength="255" ></textarea>

					</div>
				</div>
				
			  	<div class="form-group">
					<label for="provee" class="col-sm-3 control-label">Proveedor:</label>
					<div class="col-sm-8">
					 <select class="form-control input-sm" id="id_provee" name="id_provee" >
						<option value="">-- Selecciona proveedor --</option>
						<?php
						$sql_provee=mysqli_query($con,"select id_prove,nombre_prove from proveedores");
						while ($rw=mysqli_fetch_array($sql_provee)){
							$id_provee=$rw["id_prove"];
							$nombre_provee=$rw["nombre_prove"];
					?>
					<option value="<?php echo $id_provee?>" <?php echo $selected;?>><?php echo $nombre_provee?></option>
					<?php
					}
					?>
					  </select>
					</div>
			  	</div>
			  
			<div class="form-group">
						<label for="unidad" class="col-sm-3 control-label">Unidad:</label>
						<div class="col-sm-8">
						<select class='form-control input-sm' name="id_unidad" required >
						<option value="">-- Selecciona Unidad --</option>
						<?php
							$sql_unidad=mysqli_query($con,"select id_unidad,nombre_unidad from unidades");
							while ($rw=mysqli_fetch_array($sql_unidad)){
								$id_unidad=$rw["id_unidad"];
								$nombre_unidad=$rw["nombre_unidad"];
						?>
						<option value="<?php echo $id_unidad?>" <?php echo $selected;?>><?php echo $nombre_unidad?></option>
						<?php
						}
						?>
					</select>
					</div>
			</div>
				
			 <div class="form-group">
					<label for="linea" class="col-sm-3 control-label">Linea:</label>
					<div class="col-sm-8">
					<select class='form-control input-sm' name="id_linea" required >
					<option value="">-- Selecciona Linea --</option>
					<?php
						$sql_linea=mysqli_query($con,"select id_linea,nombre_linea from lineas");
						while ($rw=mysqli_fetch_array($sql_linea)){
							$id_linea=$rw["id_linea"];
							$nombre_linea=$rw["nombre_linea"];
					?>
					<option value="<?php echo $id_linea?>" <?php echo $selected;?>><?php echo $nombre_linea?></option>
					<?php
					}
					?>
				</select>
				</div>
			  </div>
			  
			  <div class="form-group">
					<label for="marca" class="col-sm-3 control-label">Marca:</label>
					<div class="col-sm-8">
					<select class='form-control input-sm' name="id_marca" >
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
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
				
			 <div class="form-group">
				<label for="precio_cost" class="col-sm-3 control-label">Precio costo:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio_cost" name="precio_cost" placeholder="Precio de compra del producto" pattern="\d+(\.\d{2})?" onkeyup="fprecio_cost();" title="Ingresa sólo números" required>
				</div>
			  </div>
				
			  <div class="form-group">
				<label for="utili" class="col-sm-3 control-label">% Utilidades:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="utili1" name="utili1" placeholder="% de utilidad de ganancia precio 1"  pattern="\d{1,4}" maxlength="4" onkeyup="futili(1);" title="Ingresa sólo números" >
				  <input type="text" class="form-control" id="utili2" name="utili2" placeholder="% de utilidad de ganancia precio 2" pattern="\d{1,4}" maxlength="4" onkeyup="futili(2);" title="Ingresa sólo números" >
				  <input type="text" class="form-control" id="utili3" name="utili3" placeholder="% de utilidad de ganancia precio 3" pattern="\d{1,4}" maxlength="4" onkeyup="futili(3);" title="Ingresa sólo números" >
				  <input type="text" class="form-control" id="utili4" name="utili4" placeholder="% de utilidad de ganancia precio 4" pattern="\d{1,4}" maxlength="4" onkeyup="futili(4);" title="Ingresa sólo números" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="precio1" class="col-sm-3 control-label">Precio 1:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio1" name="precio1" placeholder="Precio 1 de venta del producto" required pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
				</div>
			  </div>
				
			  <div class="form-group">
				<label for="precio2" class="col-sm-3 control-label">Precio 2:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio2" name="precio2" placeholder="Precio 2 de venta del producto" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
				</div>
			  </div>
				
			  <div class="form-group">
				<label for="precio3" class="col-sm-3 control-label">Precio 3:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio3" name="precio3" placeholder="Precio 3 de venta del producto" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="precio4" class="col-sm-3 control-label">Precio 4:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio4" name="precio4" placeholder="Precio 4 de venta del producto" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" >
				</div>
			  </div>
				
			  <div class="form-group">
				<label class="col-sm-3 form-check-label">Utiliza IVA:</label>
				<div class="col-sm-8">
					<input type="checkbox" class="form-check-input" name="prod_iva" id="prod_iva" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="col-sm-3 form-check-label">Producto inventariable:</label>
				<div class="col-sm-8">
					<input type="checkbox" class="form-check-input" name="prod_invent" id="prod_invent" >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="stock_min" class="col-sm-3 control-label">Stock minimo:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="stock_min" name="stock_min" placeholder="Cantidad minima requerida en inventario" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" required  >
				</div>
			  </div>
				
			  <div class="form-group">
				<label for="invent_ini" class="col-sm-3 control-label">Inventario inicial:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="invent_ini" name="invent_ini" placeholder="Cantidad del producto contado al registro" pattern="^[0-9]+(\.[0-9]{1,2})?$" title="Ingresa sólo números" required >
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="imagen" class="col-sm-3 control-label">Imagen:</label>
				<div class="col-sm-8">
				  <input type="file" name="product_img" class="form-control" id="id_product_img" >
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
		
	
	function fprecio_cost(){
		
		var precio_cost = $("#precio_cost").val();
		var metod=0;
		var utili1 = $("#utili1").val();
		var utili2 = $("#utili2").val();
		var utili3 = $("#utili3").val();
		var utili4 = $("#utili4").val();
		
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
					$("#precio1").val(precio1);
					$("#precio2").val(precio2);
					$("#precio3").val(precio3);
					$("#precio4").val(precio4);
					 
                });
				}
			})
		
	}
		
	function futili(_n){
		
		var precio_cost = $("#precio_cost").val();
		var metod=1;
		var utili1 = $("#utili"+_n).val();
		
		var param = {"utili1":utili1,"precio_cost":precio_cost,"metod":metod};
		$.ajax({
				dataType: "json",
				type:"POST",
				url:'./ajax/preciosventa.php',
				data: param,
				 success:function(data){
				 $.each(data, function(index, element) {
					var precio= element.precio;
					$("#precio"+_n).val(precio);
                });
				}
			})
		
	}
		
	</script>


	<?php
		}
	?>