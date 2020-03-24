<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Lo siento, Login no puede correr sobre una version de PHP mas pequeña que 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
   	//header("location: facturas.php");
	header("location: main.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
	$_SESSION = array();
	//session_destroy();
	
    ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Acceso | Maxim Inventory</title>
	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">  -->
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- CSS  -->
   <link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<style>

	body { 
	  background: url("img/login-bg.jpg") no-repeat center center fixed; 
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;
	}
	
	.panel-default {
	opacity: 0.9;
	margin-top:30px;
	}
	.form-group.last { margin-bottom:0px; }
	
	
	.well-searchbox {
	  min-height: cover;
	  min-width: cover;
	  padding: 19px;
	  position: center;
	  z-index: 80;
	  top: cover;
	  right: cover;
	  background: rgba(0, 0, 0, 0.6);
	  margin-bottom: cover;
	  border: 1px solid #e3e3e3;
	  border-radius: 4px;
	  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
			  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
	}

</style>
	
<?php
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	include("funciones.php");
?>
	
<body>
 <div class="container-fluid">
        <div class="well-searchbox col-md-4 col-md-offset-4">
            <!-- <img id="profile-img" class="profile-img-card" src="img/avatar_2x.png" /> -->
			<!-- <img id="profile-img" class="card-img-top" style="width:100%" src="img/logo.jpg"/> -->
			<img id="profile-img" class="img-fluid card-img-top center-block" style="width:50%" src="<?php echo get_row('perfil','logo_url', 'id_perfil', 1);?>"/>
			
			<p id="profile-name" class="profile-name-card"></p>
			
            <form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="form-signin ">
			<?php
				// show potential errors / feedback (from login object)
				if (isset($login)) {
					if ($login->errors) {
						?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						    <strong>Error!</strong> 
						
						<?php 
						foreach ($login->errors as $error) {
							echo $error;
						}
						?>
						</div>
						<?php
					}
					if ($login->messages) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						    <strong>Aviso!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $message;
						}
						?>
						</div> 
						<?php 
					}
				}
				?>
                <span id="reauth-email" class="reauth-email"></span>
				
                <input class="form-control input-sm" placeholder="Usuario" name="user_name" type="text" value="" autofocus="" required>
                <input class="form-control input-sm" placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off" required>
                <button type="submit" class="btn btn-lg btn-success btn-block btn-signin" name="login" id="submit">Iniciar Sesión</button>
            </form><!-- /form -->
				
        </div><!-- /card-container -->
    </div><!-- /container -->
  </body>
</html>

	<?php
}
