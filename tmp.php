
$(function() {
  $('.dropdown-menu a').click(function() {
    console.log($(this).attr('data-value'));
    $(this).closest('.dropdown').find('input.countrycode')
      .val('(' + $(this).attr('data-value') + ')');
  });
});


					
<?php
		$cpr=0;
		foreach ($_POST as $param_name => $param_val) {
			//echo "Param: $param_name; Value: $param_val<br />\n";
			$cpr++;
		}
?>

http://www.css3maker.com/css-3-rgba.html
.background-color: rgba(235, 235, 235, 0.80);
.back-to-top:hover {    
    background-color: rgba(135, 135, 135, 0.50);

0bt0bf7tk36gn2btl7n3hicls5 	


<script src="js/bootbox.js"></script>
		function eliminar (id) 	{
			var sta;
			var q= $("#q").val();
			bootbox.confirm("Realmente deseas eliminar el producto ?.", function (confirmed) {
				if (confirmed) {
					$.ajax({
						type: "GET",
						url: "./ajax/buscar_productos.php",
						data: "id="+id,"q":q,
						 beforeSend: function(objeto){
							$("#resultados").html("Mensaje: Cargando...");
						  },
							success: function(datos) {
							$("#resultados").html(datos);
							load(1);
						}
					});
				}
			});
			//if (sta==1) {
			//	bootbox.alert("Eliminación del producto cancelado, no se tiene autorización");
			//}
		}


http://bootboxjs.com/documentation.html
bootbox.setDefaults({'locale': 'es'});
bootbox.confirm("Seguro de guardar la compra ?.", function (confirmed) {



OJO va en el archivo .htaccess

    <FilesMatch "\.(php|js)$">
    Header unset Cache-Control
    Header unset Expires
    Header unset Last-Modified
    FileETag None
    Header unset Pragma
    </FilesMatch>

<IfModule mod_headers.c>
    Header set Cache-Control "no-cache, no-store, must-revalidate"
    Header set Pragma "no-cache"
    Header set Expires 0
</IfModule>




//Se guarda el documento a la tabla facturas y se pasa a la generación del pdf///////////////////////////////////////////////////
	$("#datos_factura").submit(function(event) {
		
		  var tipo_doc = $("#tipo_doc").val();
		  var name_doc;
		  
		  if (tipo_doc==1) {
			  name_doc="Venta";
		  } else {
			  name_doc="Cotización";
		  }
		  
		  var id_cliente = $("#id_cliente").val();
		  var name_cliente = $("#nombre_cliente").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var condiciones = $("#condiciones").val();
		  
		  if (id_cliente=="" )  {
			  if (name_cliente !== null ) {
					//bootbox.alert("Cliente no seleccionado del catálogo, se tomará como cliente foraneo");
					id_cliente=0;
					var datoc1 = $("#nombre_cliente").val();
					var datoc2 = $("#tel1").val();
					var datoc3 = $("#mail").val();
			  } else {
					alert("Se debe seleccionar un cliente");
					$("#nombre_cliente").focus();
					return false;				 
			  }
			} else {
				var datoc1 = "";
				var datoc2 = "";
				var datoc3 = "";
			}
			
			var ner = 0;
			$.ajax({
					type: "POST",
					async: false,
					cache: false,
					url: "ajax/before_save_doc.php",
					beforeSend: function(objeto) {
						$("#resultados").html("Guardando documento...");
					},
					success: function(msg) {
						if(msg=='error') {
							ner=1;
							$("#resultados").html("");
							//bootbox.alert('No hay productos agregados al documento');
							alert('No hay productos agregados al documento');

						} else {
							ner=2;
						}
					}
			});
		
		//alert("nErr: " + ner);
		
		if (ner==2) {
			bootbox.confirm("Seguro de guardar la compra ?.", function (confirmed) {
				if (confirmed) {
					VentanaCentrada('./pdf/documentos/documento_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor +'&condiciones='+condiciones+'&tipo_doc='+tipo_doc+'&datoc1='+datoc1+'&datoc2='+datoc2+'&datoc3='+datoc3,name_doc, '', '1024', '768', 'true');
					//Reset del form de la nueva factura despues de la impresion
					$('#datos_factura').get(0).reset();
					$("#return_doc").click();
				}
			});
		}
		
		event.preventDefault();
		
	});
	
	
	if (confirm("Guardar el documento ?") == true) {
				VentanaCentrada('./pdf/documentos/documento_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor +'&condiciones='+condiciones+'&tipo_doc='+tipo_doc+'&datoc1='+datoc1+'&datoc2='+datoc2+'&datoc3='+datoc3,name_doc, '', '1024', '768', 'true');
				//Reset del form de la nueva factura despues de la impresion
				$('#datos_factura').get(0).reset();
				$("#return_doc").click();
	}
			
			
			
<div class="alert alert-danger" style="display: none; width:200px"> 
	<a class="close" onclick="$('.alert').hide()">×</a>  
	<strong>Warning!</strong> Best check yo self, you're not looking too good.  
</div>
$('.alert').show();


<div id = "alert_placeholder" class='col-md-12' style="margin-top:10px" ></div>
bootstrap_alert = function() {}
	bootstrap_alert.warning = function(message) {
        $('#alert_placeholder').html('<div class="alert alert-danger" role="alert" ><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
    }


myConfirm('Cliente no seleccionado del catálogo, se tomará como cliente foraneo ?', function () {
	alert('You clicked OK');
	}, function () {
	alert('You clicked Cancel');
	 },
	'Confirmación de Maxim-Ventas'
);		


function myConfirm(dialogText, okFunc, cancelFunc, dialogTitle) {
		$('<div style="padding: 10px; max-width: 500px; word-wrap: break-word;">' + dialogText + '</div>').dialog({
		draggable: false,
		modal: true,
		resizable: false,
		width: 'auto',
		title: dialogTitle || 'Confirm',
		minHeight: 75,
		buttons: {
		  OK: function () {
			if (typeof (okFunc) == 'function') {
			  setTimeout(okFunc, 50);
			}
			$(this).dialog('destroy');
		  },
		  Cancel: function () {
			if (typeof (cancelFunc) == 'function') {
			  setTimeout(cancelFunc, 50);
			}
			$(this).dialog('destroy');
		  }
		}
	  });
	}
		
	function myDialog(dialogText, okFunc, dialogTitle) {
		$('<div style="padding: 10px; max-width: 500px; word-wrap: break-word;">' + dialogText + '</div>').dialog({
		draggable: false,
		modal: true,
		resizable: false,
		width: 'auto',
		title: dialogTitle || 'Confirm',
		minHeight: 75,
		buttons: {
		  OK: function () {
			if (typeof (okFunc) == 'function') {
			  setTimeout(okFunc, 50);
			}
			$(this).dialog('destroy');
		  }
		  
		}
	  });
	}


/*
			$.datepicker.regional['es'] = {
			 closeText: 'Cerrar',
			 prevText: '< Ant',
			 nextText: 'Sig >',
			 currentText: 'Hoy',
			 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			 weekHeader: 'Sm',
			 dateFormat: 'dd/mm/yy',
			 firstDay: 1,
			 isRTL: false,
			 showMonthAfterYear: false,
			 yearSuffix: ''
			 };
			$.datepicker.setDefaults($.datepicker.regional['es']);
			$( "#fecha_fact" ).datepicker();
*/
				 
				 
				 1969-12-31 00:00:00
				 
				 
//Paso V Guardar encabezado insert compras--------------------------------------------------------------------------------------
	$insert_compra = mysqli_query($con, "INSERT INTO compras VALUES 
	(default, '$id_prove', '$id_locat', '$num_fact', '$pedido', '$fecha_fact', '$plazo_pago_dias', 
	'$fecha_fact_venc', '$metodo_pago', '$forma_pago', '$cargo_envio_fact', '$cargo_externo_flete', 
	'$desc1', '$desc2', '$total_factura' )");
	
	if ($insert_compra) {
		//$messages[] = "Compra ha sido ingresado satisfactoriamente.";
		$sql=mysqli_query($con, "select LAST_INSERT_ID(id_compra) as last from compras order by id_compra desc limit 0,1 ");
		$rw=mysqli_fetch_array($sql);
		//Se recupera el numero de factura insertado
		$id_last_compra=$rw['last'];	// Mientras se desactiva para poder empezar con los documentos en 1032
	
	} else {
			$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Insert compras ".mysqli_error($con);
	}
				 
				 

//Paso I insert en la tabla deta_compras
		$insert_detail = mysqli_query($con, "INSERT INTO deta_compras (id_deta_compra, numero_factura, id_producto, cantidad, precio_costo,
		obser_partida, importe, iva ) VALUES ('$id_last_compra','$num_fact', '$id_producto_tmp', '$cantidad_tmp', '$precio_tmp', '$obser_partida_tmp', 
		'$importe_total', '$total_iva' )");
		
		if ($insert_detail) {
			//$messages[] = "Inventario ha sido ingresado satisfactoriamente.";
		} else {
			$errors []= "Lo siento algo ha salido mal intenta nuevamente. Ref: Compras, insert deta_compras ".mysqli_error($con);
		}