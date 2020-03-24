	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">  
		<span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="main.php" title="Inicio">Maxim Ventas</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" role="navigation">
	   
		<li class="<?php echo $active_facturas;?>"><a href="facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Cotiza-Ventas <span class="sr-only">(current)</span></a></li>
		
		<li class="<?php echo $active_compras;?>"><a href="compras.php"><i class='glyphicon glyphicon-list-alt'></i> Compras <span class="sr-only">(current)</span></a></li> 
    	<!-- <li class="disabled"><a href="compras.php"><i class='glyphicon glyphicon-list-alt'></i> Compras <span class="sr-only">(current)</span></a></li> -->
	   
		<li class="dropdown">
		  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Catálogos
          <span class="caret" ></span></a>
		  <ul class="dropdown-menu">
			  <li class="<?php echo $active_productos;?>"><a href="productos.php"><i></i> Productos</a> <i class="fa-li fa fa-check-square"></i> </li>
	  		  <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i></i> Clientes</a></li>
			  <li class="<?php echo $active_proveedores;?>"><a href="proveedores.php"><i></i> Proveedores</a></li>
			  <li class="<?php echo $active_lineas;?>"><a href="lineas.php"><i></i> Lineas</a></li>
			  <li class="<?php echo $active_marcas;?>"><a href="marcas.php"><i></i> Marcas</a></li>
			  <li class="<?php echo $active_und;?>"><a href="unidades.php"><i></i> Unidades</a></li>
			  <li class="<?php echo $active_almacenes;?>"><a href="almacenes.php"><i></i> Almacenes</a></li>
        </ul>
        </li>
		  
		<li class="dropdown">
		  <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Operaciones
          <span class="caret" ></span></a>
		  <ul class="dropdown-menu">
			  <li class="<?php echo $active_entradas;?>"><a href="entradas.php"><i></i> Entrada Inventarios</a></li>
			  <li class="<?php echo $active_salidas;?>"><a href="salidas.php"><i></i> Salidas Inventarios</a></li>
        </ul>
        </li>
		  
		<li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>
		<li class="<?php if(isset($active_perfil)){echo $active_perfil;}?>"><a href="perfil.php"><i  class='glyphicon glyphicon-cog'></i> Configuración</a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>