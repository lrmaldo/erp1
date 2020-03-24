<style type="text/css">
	.client_foraneos{
	padding: 4px 4px 4px;
	color:red;
	font-weight:bold;
	font-size:12px;
	}
	
	
table.blueTable {
  border: 1px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  background: #D0E4F5;
  background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  border-top: 2px solid #444444;
}
table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}
	
</style>

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
	include("../funciones.php");
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_factura=intval($_GET['id']);
		$del1="delete from facturas where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_factura where numero_factura='".$numero_factura."'";
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $sTable = "facturas, clientes, users";
		 $sWhere = "";
		 $sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id";
		if ( $_GET['q'] != "" )
		{
			//$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or facturas.numero_factura like '%$q%' or cliente_foraneo like '%$q%' ) ";
			$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or facturas.numero_factura like '%$q%' or cliente_foraneo like '%$q%' 
				or clientes.ape_pat_cliente like '%$q%' or clientes.ape_mat_cliente like '%$q%' ) ";
		}
		$sWhere.=" order by facturas.id_factura desc";
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
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="blueTable table-bordered table-hover" data-toggle="table">
				<thead>
				<tr>
					<th data-field="id_factura" data-sortable="true" >#</th>
					<th>FECHA</th>
					<th>CLIENTE</th>
					<th>TC</th>
					<th>VENDEDOR</th>
					<th>TIPO DOC.</th>
					<th>ESTADO</th>
					<th class='text-right'>TOTAL</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				</thead>
				<tbody>
				<?php
				$num_cliente_foraneo=get_row('perfil','numeracion_cliente_foraneo', 'id_perfil', 1);
				while ($row=mysqli_fetch_array($query)){
						$id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						
						//$num_cliente_foraneo=14;
						$facturas_id_cliente = $row['id_cliente'];
						if($facturas_id_cliente<>$num_cliente_foraneo) {
							$tipo_cliente=$row['tipo_cliente'];
							if ($tipo_cliente=1) {
								$nombre_cliente=$row['nombre_cliente'].' '.$row['ape_pat_cliente'].' '.$row['ape_mat_cliente'];
							} else {
							$nombre_cliente=$row['nombre_cliente'];
							}
							$telefono_cliente=$row['telefono_cliente'];
							$email_cliente=$row['email_cliente'];
							$text_tipo_cli="R";
							$label_class_tc='label-primary';
						
						} else {
							$nombre_cliente=$row['cliente_foraneo'];
							$telefono_cliente=$row['tel_cliente_foraneo'];
							$email_cliente=$row['email_cliente_foraneo'];
							$text_tipo_cli="F";
							$label_class_tc='label-warning';
						}
						
						$nombre_vendedor=$row['firstname']." ".$row['lastname'];
						$tipo_doc=$row['tipo_doc'];
						if ($tipo_doc==1){$text_tipo_doc="Venta";$label_class1='label-primary';}
						else{$text_tipo_doc="Cotización";$label_class1='label-default';}
					
						if ($tipo_doc==1){
							$estado_factura=$row['estado_factura'];
							if ($estado_factura==1){$text_estado="Pagada";$label_class2='label-success';}
								else{$text_estado="Pendiente";$label_class2='label-warning';}
						} else {
							$text_estado="Sin aplicar";
							$label_class2='label-default';
						}
						
						$total_venta=$row['total_venta'];
					?>
					<tr>
						<td><?php echo $numero_factura; ?></td>
						<td><?php echo $fecha; ?></td>
						
						<td><a href="#" data-toggle="tooltip" data-placement="top" 
						title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?> 
						<br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<td><span class="label <?php echo $label_class_tc;?>"><?php echo $text_tipo_cli; ?></span></td>
						
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class1;?>"><?php echo $text_tipo_doc; ?></span></td>
						<td><span class="label <?php echo $label_class2;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>					
						
						<td >
							 <div class="dropdown">
							  <button class="btn btn-danger dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">OPCIONES
							  <span class="caret"></span></button>
							  <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="menu1" >
								<li ><a href="editar_factura.php?id_factura=<?php echo $id_factura;?>"> Editar <span class="glyphicon glyphicon-edit pull-right"></span></a></li>
								<li ><a href="#" onclick="imprimir_factura('<?php echo $id_factura;?>',0);"> Ver <span class="glyphicon glyphicon-download pull-right"></span></a></li>
								
								<!-- original <li ><a role="presentation" href="#" onclick="imprimir_factura('<?php echo $numero_factura; ?>',1)"> Enviar <span class="glyphicon glyphicon-envelope pull-right"></span></a></li>  -->
								<li ><a href="#" onclick="imprimir_factura('<?php echo $numero_factura; ?>',1)"> Enviar <span class="glyphicon glyphicon-envelope pull-right"></span></a></li>
                                <!-- <li ><a onclick="obtener_datos('<?php echo $numero_factura;?>');" data-toggle="modal" href="#mailsend" > Enviar <span class="glyphicon glyphicon-envelope pull-right"></span></a></li>  -->
								
								<li ><a role="presentation" href="#" onclick="eliminar('<?php echo $numero_factura; ?>')"> Borrar <span class="glyphicon glyphicon-trash pull-right"></span></a></li>
							  </ul>
							</div>
						</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </tbody>
			  </table>
			</div>

			<?php
		}
	}
?>