<?php
	/*-------------------------
	Autor: Elio Mojica
	Web: maximcode.com
	Mail: admin@maximcode.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	//Archivo de funciones PHP
	include("../../funciones.php");
	
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	
	//Variables por GET Recepcion por array
	$adata = $_REQUEST["data"];
	$data = json_decode($adata, true);
	//$cnsult = count($data);

	//echo "<script type='text/javascript'>window.alert('datoc3');</script>";

    $tipo_doc=$data['tipo_doc'];
	$id_cliente=intval($data['id_cliente']);
	$id_vendedor=intval($data['id_vendedor']);
	
	$datoc1=$data['datoc1'];	//Name customer
	$datoc2=$data['datoc2'];	//Tel
	$datoc3=$data['datoc3'];	//Email
	$datoc4=$data['datoc4'];	//Address
	$datoc5=$data['datoc5'];	//Colonia
	$datoc6=$data['datoc6'];	//City
	$datoc7=$data['datoc7'];	//Rfc
	$datoc8=$data['datoc8'];	//Item membresias selections
	
	//$date_added=date('Y-m-d',strtotime($data['fecha_doc'])); //fecha add 27feb18
	$date_added=date('Y-m-d',strtotime($data['fecha_doc'])); //fecha add 27feb18

	$condiciones=mysqli_real_escape_string($con,(strip_tags($data['condiciones'], ENT_QUOTES)));
	//Fin de variables por GET
	
	$sql=mysqli_query($con, "select count(*) as ncount from facturas");
	$rw=mysqli_fetch_array($sql);
	$ncount=intval($rw['ncount']);
	
	//if($ncount==0) {
	//	$numero_factura=1302;
	//} else {
		$sql=mysqli_query($con, "select LAST_INSERT_ID(id_factura) as last from facturas order by id_factura desc limit 0,1 ");
		$rw=mysqli_fetch_array($sql);
		//Se recupera el numero de factura insertado
		$numero_factura=$rw['last']+1;	// Mientras se desactiva para poder empezar con los documentos en 1032
	//}
	
	if($tipo_doc==1) {
		$Titulo_doc = "VENTA Nº " . $numero_factura;
		$leyenda_doc="VENTA EN ATENCION A: ";
		$name_file_pdf="venta-" . $id_cliente . "-" . $numero_factura . ".pdf";
		$cerrada=1;
	} else if($tipo_doc==2) {
		$Titulo_doc = "COTIZACION Nº " . $numero_factura;
		$leyenda_doc="COTIZACION EN ATENCION A:";
		$name_file_pdf="cotizacion-" . $id_cliente . "-" . $numero_factura . "-" . date('dmY') . ".pdf";
		$cerrada=0;
	}
	
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
    
	//* get the HTML
    //ob_start();
    
	include(dirname('__FILE__').'/res/factura_html.php');
    
	//$content = ob_get_clean();

    /*
	try
    
	{
        //* init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        //* display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        //* Convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //* Send the PDF
		ob_end_clean();
		$html2pdf->Output($name_file_pdf);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	*/
	
	$_SESSION["num_doc"]=$numero_factura;

	//Return data
	echo $numero_factura;
?>