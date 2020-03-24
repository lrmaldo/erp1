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
					<label for="typeuser" class="col-sm-3 control-label">Tipo de usuario:</label>
					<div class="col-sm-8">
					<select class="form-control" id="type_user" name="type_user" title="Usuario: Admin-Tiene todos los privilegios y normal No" required>
						<option value="0" selected>Normal</option>
						<option value="1">Admin</option>
					  </select>
					</div>
			  </div>





<?php 
		if (!empty($membresias_selections)) {
	?>
		<br>
		<div style="font-size:11pt;text-align:center;font-weight:bold">*MEMBRESIAS</div>
		<table class="myTableLeye">
			<tr>
				<th>C O N C E P T O</th>
		  		<th>P R E C I O</th>
			</tr>
			<tr>
	<?php 
		for($i = 0; $i < sizeof($string_array); $i++) {
			//echo $string_array[$i] . "<br />\n";
			$sql_prod=mysqli_query($con, "select * from products where id_producto='".$string_array[$i]."'");
			while ($row_prod_memb=mysqli_fetch_array($sql_prod)) {
					//echo $row_prod_memb['nombre_producto'] . $row_prod_memb['precio_producto'] . "<br />\n";
				?>
				<td> <?php echo $row_prod_memb['nombre_producto']; ?> </td>
				<td> <?php echo $row_prod_memb['precio_producto']; ?> </td>
				</tr>
		</table>
	<?php 
			}
		}
	}	
	?>