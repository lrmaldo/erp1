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
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from facturas where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM clientes WHERE id_cliente='".$id_cliente."'")){
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
			  <strong>Error!</strong> No se pudo eliminar éste  cliente. Existen facturas vinculadas a éste producto. 
			</div>
			<?php
		}
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_cliente', 'clientes.ape_pat_cliente', 'clientes.ape_mat_cliente');//Columnas de busqueda
		 $sTable = "clientes";
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
		$sWhere.=" order by nombre_cliente";
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
		$reload = './clientes.php';
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
					<th>APELLIDO PATERNO</th>
					<th>APELLIDO MATERNO</th>
					<th>EMAIL</th>
					<th>DIRECCION</th>
					<th>ACTIVADO</th>
					<th>F.ALTA</th>
					<th class='text-right'>Acciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_cliente=$row['id_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
						$direccion_cliente=$row['direccion_cliente'];
						$status_cliente=$row['status_cliente'];
						if ($status_cliente==1){$text_estado="ON";$label_class='label-success';}
						else{$text_estado="OFF";$label_class='label-danger';}
						$date_added= date('d/m/Y', strtotime($row['date_added']));
						
						$ape_pat_cliente=$row['ape_pat_cliente'];
						$ape_mat_cliente=$row['ape_mat_cliente'];
						$col_cliente=$row['col_cliente'];
						$cp_cliente=$row['cp_cliente'];
						$ciudad_cliente=$row['ciudad_cliente'];
						$estado_cliente=$row['estado_cliente'];
						$pais_cliente=$row['pais_cliente'];
						$tipo_cliente=$row['tipo_cliente'];
						$rfc_cliente=$row['rfc_cliente'];
						$tipo_prec_cliente=$row['tipo_prec_cliente'];
						$lim_cred_cliente=$row['lim_cred_cliente'];
						$act_cred_cliente=$row['act_cred_cliente'];
					?>
					
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
				  	<input type="hidden" value="<?php echo $ape_pat_cliente;?>" id="ape_pat_cliente<?php echo $id_cliente;?>">
				  	<input type="hidden" value="<?php echo $ape_mat_cliente;?>" id="ape_mat_cliente<?php echo $id_cliente;?>">
				  	<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $email_cliente;?>" id="email_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $status_cliente;?>" id="status_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $col_cliente;?>" id="col_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $cp_cliente;?>" id="cp_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $ciudad_cliente;?>" id="ciudad_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $estado_cliente;?>" id="estado_cliente<?php echo $id_cliente;?>">
				  	<input type="hidden" value="<?php echo $pais_cliente;?>" id="pais_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $tipo_cliente;?>" id="tipo_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $rfc_cliente;?>" id="rfc_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $tipo_prec_cliente;?>" id="tipo_prec_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $lim_cred_cliente;?>" id="lim_cred_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $act_cred_cliente;?>" id="act_cred_cliente<?php echo $id_cliente;?>">
				  
				  	<tr>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $ape_pat_cliente;?></td>
						<td><?php echo $ape_mat_cliente;?></td>
						<td><?php echo $email_cliente;?></td>
						<td><?php echo $direccion_cliente;?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td><?php echo $date_added;?></td>
						
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
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