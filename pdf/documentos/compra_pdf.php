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
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados al documento compra')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_prove=intval($_GET['id_prove']);
	$id_vendedor=intval($_GET['id_vendedor']);
	
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	//Fin de variables por GET
	
	$sql=mysqli_query($con, "select LAST_INSERT_ID(id_compra) as last from compras order by id_compra desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	//Se recupera el numero de factura insertado
	$numero_factura=$rw['last']+1;
	
	$Titulo_doc = "COMPRA Nº " . $numero_factura;
	$leyenda_doc="VENTA EN ATENCION A: ";
	$name_file_pdf="venta-" . $id_cliente . "-" . $numero_factura . ".pdf";
	
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
    // get the HTML
     ob_start();
    include(dirname('__FILE__').'/res/compra_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
		ob_end_clean();
		$html2pdf->Output($name_file_pdf);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
