<?php

	/*-------------------------
	Autor: Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database */
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if (isset($_GET['id'])){
		$id_prove=intval($_GET['id']);
		
		if ($id_prove>0){
			if ($delete1=mysqli_query($con,"DELETE FROM proveedores WHERE id_prove='".$id_prove."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
		}
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste proveedor. 
			</div>
			<?php
		}
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_prove');//Columnas de busqueda
		 $sTable = "proveedores";
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
		$sWhere.=" order by nombre_prove";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './proveedores.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>NOMBRE</th>
					<th>DIRECCION</th>
					<th>TELEFONO1</th>
					<th>TELEFONO2</th>
					<th>EMAIL</th>
					<th class='text-right'>Acciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_prove=$row['id_prove'];
						$nombre_prove=$row['nombre_prove'];
						$direccion_prove=$row['direccion_prove'];
						$tel1_prove=$row['tel1_prove'];
						$tel2_prove=$row['tel2_prove'];
						$email_prove=$row['email_prove'];
					?>
					
					<input type="hidden" value="<?php echo $nombre_prove;?>" id="nombre_prove<?php echo $id_prove;?>">
				  
				  	<tr>
						<td><?php echo $nombre_prove; ?></td>
						<td><?php echo $direccion_prove;?></td>
						<td><?php echo $tel1_prove;?></td>
						<td><?php echo $tel2_prove;?></td>
						<td><?php echo $email_prove;?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar proveedor' onclick="obtener_datos('<?php echo $id_prove;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Borrar proveedor' onclick="eliminar('<?php echo $id_prove; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right">
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