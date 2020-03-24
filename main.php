<style>
.texto_grande {
    font-size: 2.5rem;
    color: white;
} 
#icone_grande {
    font-size: 8rem;
    color:#fff;
} 
</style>

<?php
	/*-------------------------
	Autor: Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
    }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	include("funciones.php");

	$count_products=get_count_field("products","id_producto");
	$count_clientes=get_count_field("clientes","id_cliente");

	$active_facturas="";
	$title="Inicio | Maxim Ventas";

?>
<!DOCTYPE html>
<html lang="es">
  <head>
	<?php include("head.php");?>

  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container-fluid">
			<div class="panel-body">
				<!-- <img src="img/logo.jpg" class="img-responsive img-center">  -->
				<div class="col-md-11 col-lg-3 " align="center"> 
					<img src="<?php echo get_row('perfil','logo_url', 'id_perfil', 1);?>" class="img-responsive center-block" >
				</div>
			</div>
			
			<div class="col-md-3">
				<a href="facturas.php" class="btn btn-block btn-lg btn-success" >
					<i class="fa fa-money" id="icone_grande" ></i> <br><br>
					<span class="texto_grande" >COTIZA-VENTAS</span></a>
      		</div>
			<div class="col-md-3">
				<a href="productos.php" class="btn btn-block btn-lg btn-primary" >
					<i class="fa fa-tags" id="icone_grande"></i> <br><br>
					<span class="texto_grande">PRODUCTOS</span></a>
      		</div>
			<div class="col-md-3">
				<a href="compras.php" class="btn btn-block btn-lg btn-warning" >
					<i class="fa fa-shopping-cart" id="icone_grande"></i> <br><br>
					<span class="texto_grande">COMPRAS</span></a>
      		</div>
			<div class="col-md-3">
				<a href="clientes.php" class="btn btn-block btn-lg btn-info" >
					<i class="fa fa-group" id="icone_grande"></i> <br><br>
					<span class="texto_grande">CLIENTES</span></a>
      		</div>
		
	  	</div>
	  
	  
	  	<section class="content">
          	<br>
			<div class="alert alert-success" id="alert1" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Productos registrados:</strong> 
					<?php
						echo $count_products;
					?>
			</div>
			<div class="alert alert-info" id="alert1" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Clientes registrados:</strong> 
					<?php
						echo $count_clientes;
					?>
			</div>
			
			<!-- <div class="alert alert-warning" id="alert1" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Ventas registradas:</strong> 
					<?php
						echo "2000";
					?>
			</div>
			<div class="alert alert-danger fade in" id="alert1" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Compras registradas:</strong> 
					<?php
						echo "2000";
					?>
			</div>  -->
			
		</section>
	  
	  
	  
	<hr>
	<?php
		include("footer.php");
	?>
	
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/cssrefresh.js"></script>
	<link href="css/font-awesome.min.css" rel="stylesheet">
  </body>
</html>

<script>

</script>