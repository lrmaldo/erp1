
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
	function agregar (id) {
			
			var cantidad = $("#cantidad_"+id).val();
			var precio_venta = $("#precio_venta_"+id).val();
			var dato_adicional = $("#dato_adicional_"+id).val();
		    var prod_iva = $("#prod_iva_"+id).val();
		
			cantidad = cantidad.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
			precio_venta = precio_venta.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
			//dato_adicional = dato_adicional.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		
			//Inicia validacion
			if (isNaN(cantidad)) {
				//bootbox.alert('Dato cantidad tiene que ser númerico!');
				//document.getElementById('cantidad_'+id).focus();
				$("#cantidad_"+id).focus();
				
				return false;
			} else if(cantidad=="") {
				//bootbox.alert('Dato cantidad no puede quedar en blanco!');
				$("#cantidad_"+id).focus();
				return false;
			}
			
			if (isNaN(precio_venta)) {
				//bootbox.alert('Dato precio venta tiene que ser númerico!');
				//document.getElementById('precio_venta_'+id).focus();
				$("#precio_venta_"+id).focus();
				return false;
			} else if(precio_venta=="") {
				//bootbox.alert('Dato precio venta no puede quedar en blanco!');
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
				url: "./ajax/agregar_facturacion.php",
				data: {'info':info},
				beforeSend: function(objeto) {
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
		
		var info_udp = [];
		info_udp[0] = id;
			
		$.ajax({
			type: "GET",
			url: "./ajax/agregar_facturacion.php",
			data: {'info_udp':info_udp},
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
		//var prod_iva = $("#prod_iva_tmp_"+id).val();
		
		var prod_iva=$("#prod_iva_tmp_"+id).is(":checked");
		//alert("prod_iva: "+prod_iva);
		if (prod_iva==true) {
			prod_iva=1;
		} else if(prod_iva==false) {
			prod_iva=0;
		}
		
		n_c = n_c.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		n_p = n_p.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		
		if (isNaN(n_c)) {
			//bootbox.alert('Dato cantidad tiene que ser númerico!');
			$("#cantidad_tmp_"+id).focus();
			return false;
		} else if(n_c=="") {
			//bootbox.alert('Dato cantidad no puede quedar en blanco!');
			$("#cantidad_tmp_"+id).focus();
			return false;
		}
		
		if (isNaN(n_p)) {
			//bootbox.alert('Dato precio venta tiene que ser númerico!');
			$("#precio_tmp_"+id).focus();
			return false;
		} else if(n_p=="") {
			//bootbox.alert('Dato precio venta no puede quedar en blanco!');
			$("#precio_tmp_"+id).focus();
			return false;
		}
		
		var info_udp = [];
			info_udp[0] = id;
			info_udp[1] = modo;
			info_udp[2] = d_a;
			info_udp[3] = n_c;
			info_udp[4] = n_p;
		    info_udp[5] = prod_iva;
		
		$.ajax({
			type: "GET",
			url: "./ajax/agregar_facturacion.php",
			data: {'info_udp':info_udp},
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
