
	$(document).ready(function() {
		load(1);
		//$.get('./nueva_factura.php', { option: '$utilidad_1' },function(data) {
		//		alert('Load was performed.' + data);
        //});
		
	});

	function load(page) {
		var q= $("#q").val();
		var tipoprecclie = $('#tipo_prec_cliente').val();
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'ajax/productos_factura.php?action=ajax&page='+page+'&q='+q+'&tipoprecclie='+tipoprecclie,
			 beforeSend: function(objeto){
			 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
			}
		})
	}

	//Se guarda el documento a la tabla tmp (Temporal)
	function agregar (id) 	{
			
			var cantidad = $("#cantidad_"+id).val();
			var precio_venta = $("#precio_venta_"+id).val();
			var dato_adicional = $("#dato_adicional_"+id).val();
		
			//alert("precio_venta: " + typeof precio_venta);
		
			cantidad = cantidad.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
			precio_venta = precio_venta.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		
			//Inicia validacion
			if (isNaN(cantidad)) {
				window.alert('Dato cantidad tiene que ser númerico!');
				document.getElementById('cantidad_'+id).focus();
				return false;
			} else if(cantidad=="") {
				window.alert('Dato cantidad no puede quedar en blanco!');
				document.getElementById('cantidad_'+id).focus();
				return false;
			}
			
			if (isNaN(precio_venta)) {
				window.alert('Dato precio venta tiene que ser númerico!');
				document.getElementById('precio_venta_'+id).focus();
				return false;
			} else if(precio_venta=="") {
				window.alert('Dato precio venta no puede quedar en blanco!');
				document.getElementById('precio_venta_'+id).focus();
				return false;
			}
			
			$.ajax({
				type: "POST",
				url: "./ajax/agregar_facturacion.php",
				data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&dato_adicional="+dato_adicional,
				beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
				},
				success: function(datos) {
				$("#resultados").html(datos);
				},
				error: function (error) {
                  alert('error: ' + eval(error));
               }
			});
	}
		

	function eliminar (id) 	{
			
		$.ajax({
			type: "GET",
			url: "./ajax/agregar_facturacion.php",
			data: "id="+id,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			}
		});

	}

	function update_detalle_tmp (id) {
		
		var modo = 1;
		
		var n_c = $("#cantidad_tmp_"+id).val();
		var d_a = $("#dato_adicional_"+id).val();
		var n_p = $("#precio_tmp_"+id).val();
		
		n_c = n_c.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		n_p = n_p.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		
		if (isNaN(n_c)) {
			window.alert('Dato cantidad tiene que ser númerico!');
			$("#cantidad_tmp_"+id).focus();
			return false;
		} else if(n_c=="") {
			window.alert('Dato cantidad no puede quedar en blanco!');
			$("#cantidad_tmp_"+id).focus();
			return false;
		}
		
		if (isNaN(n_p)) {
			window.alert('Dato precio venta tiene que ser númerico!');
			$("#precio_tmp_"+id).focus();
			return false;
		} else if(n_p=="") {
			window.alert('Dato precio venta no puede quedar en blanco!');
			$("#precio_tmp_"+id).focus();
			return false;
		}
		
		$.ajax({
			type: "GET",
			url: "./ajax/agregar_facturacion.php",
			data: "id="+id+"&modo="+modo+"&d_a="+d_a+"&n_c="+n_c+"&n_p="+n_p,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			}
		});
	}

	function fvalid_cant_tmp (id) {
		//var inpObj = $("#cantidad_"+id);
		//var cant = document.getElementById("cantidad_tmp_"+id);
		/*
		if (input.checkValidity() == false) {
			//alert(inpObj.validationMessage);
			//this.setCustomValidity(inpObj.validationMessage);
			input.oninvalid = function(event) {
    			event.target.setCustomValidity('Username should only contain lowercase letters. e.g. john');
			}
		} else {
			//alert("ok");
		} 
		*/
	}

	function add_del_tax (id) 	{
		var add_del_tax=1;
		
		$.ajax({
			type: "POST",
			url: "./ajax/agregar_facturacion.php",
			data: "id="+id+"&add_del_tax="+add_del_tax,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			}
		});

	}
	
	
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
					//bootstrap_alert.warning('Cliente no seleccionado del catálogo, se tomará como cliente foraneo');
					id_cliente=0;
					alert("Cliente no seleccionado del catálogo, se tomará como cliente foraneo");
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
						//$("#resultados").html("Guardando documento...");
					},
					success: function(msg) {
						if(msg=='error') {
							//$("#resultados").html("");
							ner=1;
							//bootbox.alert('No hay productos agregados al documento!');
							//bootstrap_alert.warning('No hay productos agregados al documento!');
							alert("No hay productos agregados al documento!");
							return false;
						} else {
							ner=2;
						}
					}
			});
		
		//alert("nErr: " + ner);
		
		if (ner==2) {
			if (confirm("Guardar el documento ?") == true) {
				VentanaCentrada('./pdf/documentos/documento_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor +'&condiciones='+condiciones+'&tipo_doc='+tipo_doc+'&datoc1='+datoc1+'&datoc2='+datoc2+'&datoc3='+datoc3,name_doc, '', '1024', '768', 'true');
				//Reset del form de la nueva factura despues de la impresion
				$('#datos_factura').get(0).reset();
				$("#return_doc").click();
			}
		}
		
		event.preventDefault();
		
	});
	
	$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_cliente.php",
					data: parametros,
					beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
	})
	
	
	$( "#guardar_producto" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_productos").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_productos").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
	})
