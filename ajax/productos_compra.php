<?php

	/*-------------------------
	Autor: Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo_producto', 'nombre_producto');//Columnas de busqueda
		 $sTable = "products";
		 $sWhere = "";
		
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table table-bordered table-hover">
				<tr class="warning">
					<th>CODIGO</th>
					<th>PRODUCTO</th>
					<th>OBSERVACION POR PARTIDA</th>
					<th><span class="pull-right">CANT.</span></th>
					<th><span class="pull-right">PRECIO DE COMPRA</span></th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
			
				while ($row=mysqli_fetch_array($query)){
					$id_producto=$row['id_producto'];
					$codigo_producto=$row['codigo_producto'];
					$nombre_producto=$row['nombre_producto'];
					$precio_compra="";
					?>
					<tr>
						<td><?php echo $codigo_producto; ?></td>
						<td><?php echo $nombre_producto; ?></td>
						
						<td class='col-xs-3' ><div class="pull-left">
							<textarea class="form-control" id="dato_adicional_<?php echo $id_producto; ?>"  value="" cols="60" rows="3"  ></textarea>
						</div></td>
						
						<td class='col-xs-1'>
						<div class="pull-right">
						<input type="number" class="form-control numbers" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>" onkeydown="fkeydown_cant(event,<?php echo $id_producto; ?>)" min="1" step="1" value="1" >
						</div></td>
						
						<td class='col-xs-2'><div class="pull-right">
							<div class="pull-right">
							<input type="text" class="form-control numbers" id="precio_compra_<?php echo $id_producto; ?>" onkeydown="fkeydown(event,<?php echo $id_producto; ?>)" value="<?php echo $precio_compra; ?>">
							</div>
						</div>
						</td>
						
						<td class='text-center'><a class='btn btn-info' href="#" onclick="agregar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>

			<script>
				
				$("input.numbers").keypress(function(event) {
					if (String.fromCharCode(event.keyCode).match(/^[0-9.,]+$/)) {
						return true;
					} else {
						return false;
					}
				});

				function fkeydown_cant( event, nid ) {
				  if ( event.which == 13 ) {
					 event.preventDefault();
					 $('#precio_compra_'+nid).focus();
				  }
				}

				function fkeydown( event, nid ) {
				  if ( event.which == 13 ) {
					 event.preventDefault();
					 agregar(nid);
				  }
				}
				
			</script>

			<?php
		}
	}
?>