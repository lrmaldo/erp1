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
	
	date_default_timezone_set('America/Mexico_city');
	
	$id_factura= intval($_GET['id_factura']);
	if (isset($_GET['nopc'])) {
		$nopc=$_GET['nopc'];
	} else {
		$nopc=0;
	}
	
	$sql_count=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Documento no encontrado')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$rw_factura=mysqli_fetch_array($sql_factura);
	$numero_factura=$rw_factura['numero_factura'];
	$id_cliente=$rw_factura['id_cliente'];
	$id_vendedor=$rw_factura['id_vendedor'];
	$fecha_factura=$rw_factura['fecha_factura'];
	$condiciones=$rw_factura['condiciones'];
	$datoc1=$rw_factura['cliente_foraneo'];
	$datoc2=$rw_factura['tel_cliente_foraneo'];
	$datoc3=$rw_factura['email_cliente_foraneo'];
    //New data for foraneos customer
    $datoc4=$rw_factura['direccion_cliente_foraneo'];
    $datoc5=$rw_factura['col_cliente_foraneo'];
	$datoc6=$rw_factura['ciudad_cliente_foraneo'];
	$datoc7=$rw_factura['rfc_cliente_foraneo'];

	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
	$tipo_doc=$rw_factura['tipo_doc'];

	//For email
	$mail_customer="";
	$vendedor="";

	if($tipo_doc==1) {
		$Titulo_doc = "VENTA Nº " . $numero_factura;
		$leyenda_doc="VENTA EN ATENCION A: ";
		$name_file_pdf="venta-" . $id_cliente . "-" . $numero_factura . ".pdf";
	} else if($tipo_doc==2) {
		$Titulo_doc = "COTIZACION Nº " . $numero_factura;
		$leyenda_doc="COTIZACION EN ATENCION A:";
		$name_file_pdf="cotizacion-" . $id_cliente . "-" . $numero_factura . "-" . date('dmY') . ".pdf";
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
    ob_start();
    include(dirname('__FILE__').'/res/ver_documento_html.php');
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
		if($nopc==0) {
			$html2pdf->Output($name_file_pdf);
		} else {
			//Param: "D", descarga el pdf automatic
			//Param: "F", sobreescritura
			$path=dirname(__DIR__) . "../../uploads/";
			$html2pdf->Output($path . $name_file_pdf, "F");
			//$html2pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/sattlink-pruebas/uploads/pollo.pdf", 'F');
		}
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

	if($nopc==1) {
		require_once ("../../libraries/PHPMailer/PHPMailerAutoload.php");

		//$pop = POP3::popBeforeSmtp('pop3.live.com', 110, 30, 'sistprof@hotmail.com', 'Elenita01', 1);
		
		//try {
			
			/*
			echo "<script>alert('Checando cliente si es F o R: <?php echo $mail_customer;?>'); </script>";
			echo "<script>window.close();</script>";
			exit;
			*/
			$user_id=$_SESSION['user_id'];
		
			$sql_perfil=mysqli_query($con,"select * from perfil where id_perfil=1");
			$rw_perfil=mysqli_fetch_array($sql_perfil);
			$issmtp=$rw_perfil['activate_smtp'];
			$host_mail=$rw_perfil['host_mail'];
			$host_port=$rw_perfil['host_port'];
			$type_encript=$rw_perfil['type_encript'];
			$subject=$rw_perfil['subject'];
			$body=$rw_perfil['body'];
			$contacto=$rw_perfil['telefono'];

			$sql_users=mysqli_query($con,"select * from users where user_id='$user_id'");
			$rw_users=mysqli_fetch_array($sql_users);
			$user_email=$rw_users['user_email'];
			$pasw_mail=$rw_users['pasw_mail'];

			$mail = new PHPMailer(true);

			// Enable verbose debug output
			//$mail->SMTPDebug = 2;
			
			//Ask for HTML-friendly debug output
			//$mail->Debugoutput = 'html';

			//Set mailer to use SMTP ***solo se activa en un servidor montado
			
			if ($issmtp==1) { $mail->isSMTP();}
			
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			
			
			if ($type_encript==0) { 
					$mail->SMTPSecure = 'tls';
			} else {
				$mail->SMTPSecure = 'ssl';
			}
			
			//$mail->Host = 'pop3.live.com';
			//$mail->Host = 'smtp.live.com';
			
			if ($host_mail=="") {
				echo "<script>alert('Nombre de de host de correo no especificado,se cancela el envio por correo!')</script>";
				echo "<script>window.close();</script>";
				exit;
			} else {
				$mail->Host=$host_mail;
			}
			
			if ($host_port==0 or $host_port<0) {
				echo "<script>alert('Puerto del host de corrreo no especificado,se cancela el envio por correo!')</script>";
				echo "<script>window.close();</script>";
				exit;
			} else {
				$mail->Port = $host_port;
			}

			//$mail->SMTPKeepAlive = false;
			//$mail->Username= 'sistprof@hotmail.com';         	  // SMTP username
			//$mail->Username = 'elio.mojica@sattlink.com';         // SMTP username
		
			if ($user_email=="") {
				echo "<script>alert('Dirección de correo remitente no especificado, se cancela el envio por correo!')</script>";
				echo "<script>window.close();</script>";
				exit;
			} else {
				$mail->Username=$user_email;
			}
		
			//$mail->Password = 'Elenita01';                        // SMTP password
			//$mail->Password = 'Sattlink.1';                        // SMTP password
			if ($pasw_mail=="") {
				echo "<script>alert('Contraseña de correo remitente no especificado, se cancela el envio por correo!')</script>";
				echo "<script>window.close();</script>";
				exit;
			} else {
				$mail->Password =$pasw_mail;
			}

			//$mail->setFrom('sistprof@hotmail.com', 'Sistemas Profesionales');
			//$mail->setFrom( $user_email, 'Super Sattlink');
			$mail->setFrom( $user_email);
			//$mail->addAddress('s.i.avanzados@outlook.com', 'Sistemas Avanzados');     // Add a recipient
		
			//$mail->addAddress('s.i.avanzados@outlook.com');     // Add a recipient
			if ($mail_customer=="") {
				echo "<script>alert('Correo destinatario no especificado, se cancela el envio por correo!')</script>";
				echo "<script>window.close();</script>";
				exit;
			} else {
				
				//Anexo automatico a la lita de envio con copia a Rafael Nuñez
				//*$mail_customer.=",rafael.nunez@sattlink.com";
				
				//$mail->addAddress($mail_customer);
				$addr = explode(',', $mail_customer);
				foreach ($addr as $ad) {
					$data[] = trim($ad);
				}
				$mail->addAddress($data[0]);
				$max = sizeof($data) - 1;
				//$mail->addReplyTo('sistprof@hotmail.com'); Not functions
				//$mail->addCC($data[1]);
				//$mail->addBCC('bcc@example.com');
				for ($x = 1; $x <= $max; $x++) {
					$mail->addCC($data[$x]);
				}
			}
		
			$path_file="../../uploads/" . $name_file_pdf;
			$mail->addAttachment($path_file, $name_file_pdf);         // Add attachments

			$mail->WordWrap=80;		// set word wrap
			$mail->isHTML(true);	// Set email format to HTML
			$mail->Subject=$subject;
			
			//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			
			//$msg = '<table><tr><td colspan="2"><img  src="cid:logo_jpg" alt="http://sattlink.com" width="250" height="100" border="0" /></td></tr></table>';
			$mail->AddEmbeddedImage("../../img/logo.jpg", "logo_jpg", "logo.jpg", "base64", "application/octet-stream");
		
			$footer = $body;
			$footer .= '<table style="width: 95%">';
			$footer .= '<tr>';
			$footer .= '<td>';
			$footer .= "<br/>
							Contacto: " . $contacto . "<br/>
							Correo: " . $user_email . "<br/><br/>
							<strong>Atentamente</strong><br/>".
							$vendedor;
			$footer .= '</td>';
			$footer .= '<td style="text-align:right" colspan="2">';
			$footer .= '<img src="cid:logo_jpg" alt="http://sattlink.com" width="250" height="100" border="0" />';
			$footer .= '</td>';
			$footer .= '</tr>';
			$footer .= '</table>';
		
			$mail->MsgHTML($footer);
			//$mail->Body=$body . "<br />\n" . "<br />\n" . "<b>Atentamente</b>" . "<br />\n".$vendedor;
			
			//$mail->send();
			
			$cgetvalue = $mail->GetLastMessageID(); //solo funciona si isSMTP se conecta
			//$mail->smtpClose();
			//echo $cgetvalue;
			//echo '0';

			if(! $mail->send()) {
				//echo '1';
				$mail->ClearAddresses();
				$mail->SmtpClose();
				echo $mail->ErrorInfo . ", " . $cgetvalue;
			} else {
				//echo 'El PDF ha sido enviado por correo electrónico';
				$mail->ClearAddresses();
				$mail->SmtpClose();
				echo '0';
				//echo $cgetvalue;
			}
			//exit;
		
		/*
		} catch (phpmailerException $e) {
				echo $e->errorMessage(); //error messages from PHPMailer
		
		} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
		}
		*/

	}

?>