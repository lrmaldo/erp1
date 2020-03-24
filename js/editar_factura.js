
	$(document).ready(function() {
		Ini_load();
		//$( "#resultados" ).load( "ajax/editar_facturacion.php" );
		//load(1);
	
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

	function agregar (id)
		{
			var cantidad = $("#cantidad_"+id).val();
			var precio_venta = $("#precio_venta_"+id).val();
			var dato_adicional = $("#dato_adicional_"+id).val();
			
			var prod_iva = $("#prod_iva_"+id).val();
			
			cantidad = cantidad.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
			precio_venta = precio_venta.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
			//dato_adicional = dato_adicional.replace("&", " ");
			//dato_adicional = dato_adicional.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
			
			//Inicia validacion
			if (isNaN(cantidad)) {
				//window.alert('Dato cantidad tiene que ser númerico!');
				//document.getElementById('cantidad_'+id).focus();
				$("#cantidad_"+id).focus();
				return false;
			} else if(cantidad=="") {
				//window.alert('Dato cantidad no puede quedar en blanco narce o susy! :) ');
				//document.getElementById('cantidad_'+id).focus();
				$("#cantidad_"+id).focus();
				return false;
			}
			
			if (isNaN(precio_venta)) {
				//window.alert('Dato precio venta tiene que ser númerico!');
				//document.getElementById('precio_venta_'+id).focus();
				$("#precio_venta_"+id).focus();
				return false;
			} else if(precio_venta=="") {
				//window.alert('Dato precio venta no puede quedar en blanco narce o susy! :) ');
				//document.getElementById('precio_venta_'+id).focus();
				$("#precio_venta_"+id).focus();
				return false;
			}
			
			var info = [];
			info[0] = id;
			info[1] = cantidad;
			info[2] = precio_venta;
			info[3] = dato_adicional;
			info[4] = prod_iva;
			
			$.ajax({
				type: "POST",
				url: "./ajax/editar_facturacion.php",
				data: {'info':info},
				beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
				  },
				success: function(datos){
					$("#resultados").html(datos);
				}
			});
	}
		
	
	function eliminar (id, cerrada) {
		if (cerrada==0) {
			
			var info_udp = [];
			info_udp[0] = id;
			
			$.ajax({
				type: "GET",
				url: "./ajax/editar_facturacion.php",
				data: {'info_udp':info_udp},
				 beforeSend: function(objeto) {
					$("#resultados").html("Mensaje: Cargando...");
				  },
				success: function(datos) {
				$("#resultados").html(datos);
				}
			});
		} else {
			alert("No puede eliminar una partida de venta cuando es cerrada!");
		}

	}

	function update_detalle_doc (id,cerrada) {
		
		var modo = 1;
		
		var n_c = $("#cantidad_update_"+id).val();
		var d_a = $("#dato_adic_update_"+id).val();
		var n_p = $("#precio_update_"+id).val();
		
		var prod_iva=$("#prod_iva_update_"+id).is(":checked");
		//alert("prod_iva: "+prod_iva);
		if (prod_iva==true) {
			prod_iva=1;
		} else if(prod_iva==false) {
			prod_iva=0;
		}
		
		n_c = n_c.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		n_p = n_p.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		//d_a = d_a.replace("&", " ");
		//d_a = d_a.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		
		if (isNaN(n_c)) {
			//window.alert('Dato cantidad tiene que ser númerico!');
			$("#cantidad_update_"+id).focus();
			return false;
		} else if(n_c=="") {
			//window.alert('Dato cantidad no puede quedar en blanco!');
			$("#cantidad_update_"+id).focus();
			return false;
		}
		
		if (isNaN(n_p)) {
			//window.alert('Dato precio venta tiene que ser númerico!');
			$("#precio_update_"+id).focus();
			return false;
		} else if(n_p=="") {
			//window.alert('Dato precio venta no puede quedar en blanco!');
			$("#precio_update_"+id).focus();
			return false;
		}
		
		if (cerrada==0) {
			//data: "id="+id+"&modo="+modo+"&d_a="+d_a+"&n_c="+n_c+"&n_p="+n_p,
			
			var info_udp = [];
			info_udp[0] = id;
			info_udp[1] = modo;
			info_udp[2] = d_a;
			info_udp[3] = n_c;
			info_udp[4] = n_p;
			info_udp[5] = prod_iva;
			
			$.ajax({
				type: "GET",
				url: "./ajax/editar_facturacion.php",
				data: {'info_udp':info_udp},
				 beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
				  },
				success: function(datos) {
				$("#resultados").html(datos);
				}
			});
		} else {
			alert("No puede actualizar una partida de venta cuando es cerrada!");
		}
	}
		
	$("#datos_factura").submit(function(event){
		 var id_cliente=$("#id_cliente").val();
		 var name_cliente = $("#nombre_cliente").val();
		
		 if(id_cliente=="") {
			 if (name_cliente !== null ) {
				alert("Cliente no seleccionado del catálogo, se tomará como cliente foraneo");
				id_cliente=0;
			  }
		 }
 		 var param = $(this).serialize();
		 $.ajax({
				type: "POST",
				url: "ajax/editar_factura.php",
				data: param,
				 beforeSend: function(objeto){
					$(".editar_factura").html("Mensaje: Cargando...");
				 },
				success: function(datos){
					$(".editar_factura").html(datos);
				}
			});
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

	
	//cuando el documento se hizo y hubo cambios se puede generar de nuevo
	function imprimir_factura(id_factura) {
			//VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
			VentanaCentrada('./pdf/documentos/ver_documento_pdf.php?id_factura='+id_factura,'Documento','','1024','768','true');
			
	}