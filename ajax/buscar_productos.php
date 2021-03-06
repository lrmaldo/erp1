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
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])) {
		$id_producto=intval($_GET['id']);
		//print "id_producto: " . $id_producto;
		$query=mysqli_query($con, "select * from detalle_factura where id_producto='".$id_producto."'");
		$count=mysqli_num_rows($query);
		
		if ($count==0) {
			if ($delete1=mysqli_query($con,"DELETE FROM products WHERE id_producto='".$id_producto."'")) {
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente. <?php echo mysqli_error($con);?>
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  producto. Existen cotizaciones vinculadas a éste producto. 
			</div>
			<?php
		}
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo_producto', 'nombre_producto');//Columnas de busqueda
		 //$sTable = " products INNER JOIN cant_products ON products.id_producto=cant_products.id_product 
		 //			 INNER JOIN unidades ON products.id_unidad=unidades.id_unidad";
		
		$sTable = " products LEFT JOIN cant_products ON products.id_producto=cant_products.id_product 
		 			 INNER JOIN unidades ON products.id_unidad=unidades.id_unidad";
		 
		$sWhere = "";
		
		$_SESSION['B_RPT01'] = "";
		
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			//$sWhere .= ' id_product = id_producto ';
			$sWhere .= ')';
			$_SESSION['B_RPT01'] = $q;
		}
		$sWhere.=" order by id_producto desc";
		include '2pagination.php'; //include pagination file
		//pagination variables
		
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page']:8;
		//print "per_page: " . $per_page;
		//$per_page = 8; //how much records you want to show
		//$per_page = 10001; //how much records you want to show
		
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		
		$total_pages = ceil($numrows/$per_page);
		//$total_pages = $numrows;
		
		$reload = './productos.php';
		
		$_SESSION['S_RPT01']="SELECT * FROM  $sTable $sWhere ";
		
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		
		//loop through fetched data
		if ($numrows>0) {
			$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>
			<div class="table-responsive">
			  <table class="table table-striped table-bordered table-hover">
				<tr  class="info">
					<th>IMAGEN</th>
					<th>CODIGO</th>
					<th>UND</th>
					<th>PRODUCTO</th>
					<th>ACT</th>
					<!-- <th>F.ALTA</th> -->
					<th class='text-right'>PRECIO 1</th>
					<th class='text-right'>PRECIO 2</th>
					<th class='text-right'>PRECIO 3</th>
					<th class='text-right'>PRECIO 4</th>
					<th class='text-right'>EXIST</th>
					<th class='text-right'>Opciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_producto=$row['id_producto'];
						$codigo_producto=$row['codigo_producto'];
						$nombre_unidad=$row['nombre_unidad'];
						$nombre_producto=$row['nombre_producto'];
						$nombrel_producto=$row['nombre_producto_l'];
						$status_producto=$row['status_producto'];
						$date_added= date('d/m/Y', strtotime($row['date_added']));
						$nombre_productol=$row['nombre_producto_l'];
						$id_provee=$row['id_provee'];
						$id_unidad=$row['id_unidad'];
						$id_linea=$row['id_linea'];
						$id_marca=$row['id_marca'];
						if ($status_producto==1){$text_estado="ON";$label_class='label-success';}
						else{$text_estado="OFF";$label_class='label-danger';}
						$precio_cost=$row['precio_cost'];
						$utili1=$row['utili'];
						$utili2=$row['utili2'];
						$utili3=$row['utili3'];
						$utili4=$row['utili4'];
						
						$precio_producto=number_format( $row['precio_producto'],2,'.',',');
						$precio2=number_format( $row['precio2'],2,'.',',');
						$precio3=number_format($row['precio3'],2,'.',',');
						$precio4=number_format($row['precio4'],2,'.',',');
					
						$precio_show1=number_format( $row['precio_producto'],2,'.','');
						$precio_show2=number_format( $row['precio2'],2,'.','');
						$precio_show3=number_format($row['precio3'],2,'.','');
						$precio_show4=number_format($row['precio4'],2,'.','');
					
						$prod_iva=$row['iva'];
						$prod_invent=$row['prod_invent'];
						$stock_min=$row['stock_min'];
						$invent_ini=$row['invent_ini'];
						
						$product_img=$row['product_img'];
						if (empty($product_img))  {
							$product_img="img-noavailable.png";
						}
						
						$existencia=$row['cantidad'];
						
					?>
					
					<input type="hidden" value="<?php echo $product_img;?>" id="product_img<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $codigo_producto;?>" id="codigo_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $nombre_producto;?>" id="nombre_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $status_producto;?>" id="estado<?php echo $id_producto;?>">
				    <input type="hidden" value="<?php echo $nombre_productol;?>" id="nombre_productol<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $id_provee;?>" id="id_provee<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $id_unidad;?>" id="id_unidad<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $id_linea;?>" id="id_linea<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $id_marca;?>" id="id_marca<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $precio_cost;?>" id="precio_cost<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $utili1;?>" id="utili1<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $utili2;?>" id="utili2<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $utili3;?>" id="utili3<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $utili4;?>" id="utili4<?php echo $id_producto;?>">
				  	
				  	<input type="hidden" value="<?php echo $precio_show1;?>" id="precio_show1<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $precio_show2;?>" id="precio_show2<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $precio_show3;?>" id="precio_show3<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $precio_show4;?>" id="precio_show4<?php echo $id_producto;?>">
				  
				  	<input type="hidden" value="<?php echo $precio_producto;?>" id="precio_producto<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $precio2;?>" id="precio2<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $precio3;?>" id="precio3<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $precio4;?>" id="precio4<?php echo $id_producto;?>">
				  	
				  	<input type="hidden" value="<?php echo $prod_invent;?>" id="prod_invent<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $stock_min;?>" id="stock_min<?php echo $id_producto;?>">
				  	<input type="hidden" value="<?php echo $invent_ini;?>" id="invent_ini<?php echo $id_producto;?>">
				    <input type="hidden" value="<?php echo $prod_iva;?>" id="prod_iva<?php echo $id_producto;?>">
				  
					<tr>
						<td><img class='img-round' src='./uploads/<?php echo $product_img;?>' style='height:50px; width:70px;' /></td>
						<td style="font-size: 09pt; font-family: arial"><?php echo $codigo_producto; ?></td>
						<td style="font-size: 09pt; font-family: arial"><?php echo $nombre_unidad; ?></td>
						
						<td style="font-size: 09pt; font-family: arial"><a href="#" data-toggle="tooltip" data-placement="top" 
						title="<?php echo $nombrel_producto;?>" ><?php echo $nombre_producto;?></a></td>
						
						
						<td style="font-size: 09pt; font-family: arial"><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<!-- <td style="font-size: 09pt; font-family: arial"><?php echo $date_added;?></td> -->
						
						<td width="8%" style="font-size: 09pt; font-family: arial"><a href="#" data-toggle="tooltip" data-placement="top" 
						title="<?php echo $utili1."% Utilidad de ganancia";?>"><span class='pull-right'><?php echo $simbolo_moneda." ".$precio_producto;?></span> </a></td>
						
						<td width="8%" style="font-size: 09pt; font-family: arial"><a href="#" data-toggle="tooltip" data-placement="top" 
						title="<?php echo $utili2."% Utilidad de ganancia";?>"><span class='pull-right'><?php echo $simbolo_moneda." ".$precio2;?></span></a></td>
						
						<td width="8%" style="font-size: 09pt; font-family: arial"><a href="#" data-toggle="tooltip" data-placement="top" 
						title="<?php echo $utili3."% Utilidad de ganancia";?>"><span class='pull-right'><?php echo $simbolo_moneda." ".$precio3;?></span></a></td>
						
						<td width="8%" style="font-size: 09pt; font-family: arial"><a href="#" data-toggle="tooltip" data-placement="top" 
						title="<?php echo $utili4."% Utilidad de ganancia";?>"><span class='pull-right'><?php echo $simbolo_moneda." ".$precio4;?></span></a></td>
						
						<td style="font-size: 09pt; font-family: arial"><span class='pull-right'><?php echo number_format($existencia,3);?></span></td>
						
					<td ><span class="pull-right">
						<a href="#" class='btn btn-danger' title='Editar producto' onclick="obtener_datos('<?php echo $id_producto;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-danger' title='Borrar producto' onclick="eliminar('<?php echo $id_producto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents, $per_page, $numrows);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>