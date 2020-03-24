	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Maxim Ventas</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       <!-- <li class="<?php echo $active_cotizaciones;?>"><a href="cotizaciones.php"><i class='glyphicon glyphicon-list-alt'></i> Cotizaciones <span class="sr-only">(current)</span></a></li>  -->
	   <li class="<?php echo $active_facturas;?>"><a href="facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Documentos <span class="sr-only">(current)</span></a></li>
	   <li class="dropdown">
		  <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Catálogos
          <span class="caret glyphicon glyphicon-th-list" ></span></a>
		  <ul class="dropdown-menu">
			  <li class="<?php echo $active_productos;?>"><a href="productos.php"><i></i> Productos</a></li>
			  <li class="<?php echo $active_proveedores;?>"><a href="proveedores.php"><i></i> Proveedores</a></li>
			  <li class="<?php echo $active_lineas;?>"><a href="lineas.php"><i></i> Lineas</a></li>
			  <li class="<?php echo $active_marcas;?>"><a href="marcas.php"><i></i> Marcas</a></li>
			  <li class="<?php echo $active_und;?>"><a href="unidades.php"><i></i> Unidades</a></li>
			  <li class="<?php echo $active_almacenes;?>"><a href="almacenes.php"><i></i> Almacenes</a></li>
        </ul>
        </li>
        <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Clientes</a></li>
		<li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>
		<li class="<?php if(isset($active_perfil)){echo $active_perfil;}?>"><a href="perfil.php"><i  class='glyphicon glyphicon-cog'></i> Configuración</a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://maximcode.com/" target='_blank'><i class='glyphicon glyphicon-envelope'></i> Soporte</a></li>
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>