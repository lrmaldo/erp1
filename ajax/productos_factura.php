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
	$tipoprecclie = (isset($_REQUEST['tipoprecclie'])&& $_REQUEST['tipoprecclie'] !=NULL)?$_REQUEST['tipoprecclie']:'';
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo_producto', 'nombre_producto');//Columnas de busqueda
		 $sTable = "products";
		 $sWhere = "WHERE status_producto=1";
		
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ') and status_producto=1';
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
		$sql="SELECT * FROM $sTable $sWhere LIMIT $offset, $per_page";
		//echo "=".$sql;
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table table-bordered table-hover">
				<tr  class="warning">
					<th>IMAGEN</th>
					<th>CODIGO</th>
					<th>PRODUCTO</th>
					<th>DATO ADICIONAL</th>
					<th><span class="pull-right">CANT.</span></th>
					<th><span class="pull-right">PRECIO</span></th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
			
				$aactive = array(
					1 => "",
					2 => "",
					3 => "",
					4 => "",
					);
				
				if ($tipoprecclie=="") {
					$namefield="precio_producto";
					$aactive[1]="active";
				} else {
					if ($tipoprecclie==1) {
						$namefield="precio_producto";
						$aactive[1]="active";
					} else {
						$namefield="precio".$tipoprecclie;
						$aactive[$tipoprecclie]="active";
					}
				}
			
				while ($row=mysqli_fetch_array($query)){
					
					$product_img=$row['product_img'];
					if (empty($product_img))  {
						$product_img="img-noavailable.png";
					}
					
					$id_producto=$row['id_producto'];
					$codigo_producto=$row['codigo_producto'];
					$nombre_producto=$row['nombre_producto'];
					$precio_venta=$row[$namefield];
					$precio_venta=number_format($precio_venta,2,'.','');
					$prod_iva=$row['iva'];
					
					?>
				  	
					<input type="hidden" value="<?php echo $prod_iva;?>" id="prod_iva_<?php echo $id_producto;?>">
				  
				    <tr>
						<td><img class="img-round" id="imgrow" src='./uploads/<?php echo $product_img;?>' style='height:70px; width:70px;' /></td>
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
							<div class="input-group dropdown row-fluid">
							  <input type="text" class="form-control numbers preciosproducts dropdown-toggle" id="precio_venta_<?php echo $id_producto; ?>" onkeydown="fkeydown(event,<?php echo $id_producto; ?>)" value="<?php echo $precio_venta; ?>">
							  <?php
								$sql_precios=mysqli_query($con,"select precio_producto,precio2,precio3,precio4,utili,utili2,utili3,utili4 from products where id_producto='".$id_producto."'");
								$rw=mysqli_fetch_array($sql_precios);
								
								$array=array(
								  1 => array (
									   1 => "Precio 1:(" . $rw["utili"] . "%)" , 
									   2 => "Precio 2:(" . $rw["utili2"] . "%)" , 
									   3 => "Precio 3:(" . $rw["utili3"] . "%)" , 
									   4 => "Precio 4:(" . $rw["utili4"] . "%)"
									 ),
								  2 => array (
									1 => number_format($rw["precio_producto"],2,'.',''),
									2 => number_format($rw["precio2"],2,'.',''),
									3 => number_format($rw["precio3"],2,'.',''),
									4 => number_format($rw["precio4"],2,'.','')
									 )
								);
								?>
							  <ul class="dropdown-menu">
								<li class="<?php echo $aactive[1];?>" style="text-align: right;" ><a href="#" data-value="<?php echo $array[2][1];?>"> <?php echo $array[1][1];?> <?php echo $array[2][1];?></a></li>
								<li class="<?php echo $aactive[2];?>" style="text-align: right;" ><a href="#" data-value="<?php echo $array[2][2];?>"> <?php echo $array[1][2];?> <?php echo $array[2][2];?></a></li>
								<li class="<?php echo $aactive[3];?>" style="text-align: right;" ><a href="#" data-value="<?php echo $array[2][3];?>"> <?php echo $array[1][3];?> <?php echo $array[2][3];?></a></li>
								<li class="<?php echo $aactive[4];?>" style="text-align: right;" ><a href="#" data-value="<?php echo $array[2][4];?>"> <?php echo $array[1][4];?> <?php echo $array[2][4];?></a></li>
							  </ul>
							  <span role="button" class="input-group-addon btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></span>
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

			<?php
		}
	}
?>

	<script>
				
		$("input.numbers").keypress(function(event) {
			if (String.fromCharCode(event.keyCode).match(/^[0-9.,]+$/)) {
				return true;
			} else {
			return false;
			}
		});

		$(function() {
		  $('.dropdown-menu a').click(function() {
			console.log($(this).attr('data-value'));
			$(this).closest('.dropdown').find('input.preciosproducts')
			.val( $(this).attr('data-value') );
		  });
		});
				
		function fkeydown_cant( event, nid ) {
		  if ( event.which == 13 ) {
			 event.preventDefault();
			 $('#precio_venta_'+nid).focus();
		  }
		}

		function fkeydown( event, nid ) {
		  if ( event.which == 13 ) {
			 event.preventDefault();
			 agregar(nid);
		  }
		}
				
	</script>