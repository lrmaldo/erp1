
	$(document).ready(function() {
		
		load(1);
		
		//Load date
		document.getElementById('fecha_fact').valueAsDate = new Date();
				
		$("input.numbers").keypress(function(event) {
			if (String.fromCharCode(event.keyCode).match(/^[0-9.,]+$/)) {
				return true;
			} else {
				return false;
			}
		});
		
		$("input.2numbers").keypress(function(event) {
			if (String.fromCharCode(event.keyCode).match(/^[0-9.]+$/)) {
				return true;
			} else {
				return false;
			}
		});
		
		$("input.intnumbers").keypress(function(event) {
			if (String.fromCharCode(event.keyCode).match(/[^0-9]/g)) return false;
		});
		
		//start windows scroll top
		var offset = 220;
    	var duration = 500;
    	jQuery(window).scroll(function() {
			if (jQuery(this).scrollTop() > offset) {
				jQuery('.back-to-top').fadeIn(duration);
			} else {
				jQuery('.back-to-top').fadeOut(duration);
			}
    	});
    
		jQuery('.back-to-top').click(function(event) {
			event.preventDefault();
			jQuery('html, body').animate({scrollTop: 0}, duration);
			return false;
		})
		//end windows scroll top
		
		$('#nombre_prove').focus();

	});


	function load(page) {
			var q= $("#q").val();
			
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'ajax/productos_compra.php?action=ajax&page='+page+'&q='+q,
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
	function agregar(id) {
			var cantidad = $("#cantidad_"+id).val();
			var precio_compra = $("#precio_compra_"+id).val();
			var dato_adicional = $("#dato_adicional_"+id).val();
		
			cantidad = cantidad.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
			precio_compra = precio_compra.replace(/[&\/\\#,+()$~%'":*?<>{}]/g, '');
		
			//Inicia validacion
			if (isNaN(cantidad)) {
				//window.alert('Dato cantidad tiene que ser númerico!');
				//document.getElementById('cantidad_'+id).focus();
				$("#cantidad_"+id).focus();
				return false;
			} else if(cantidad=="") {
				//window.alert('Dato cantidad no puede quedar en blanco!');
				//document.getElementById('cantidad_'+id).focus();
				$("#cantidad_"+id).focus();
				return false;
			}
			
			if (isNaN(precio_compra)) {
				//window.alert('Dato precio compra tiene que ser númerico!');
				//document.getElementById('precio_compra_'+id).focus();
				$("#precio_compra_"+id).focus();
				return false;
			} else if(precio_compra=="") {
				//window.alert('Dato precio compra no puede quedar en blanco!');
				//document.getElementById('precio_compra_'+id).focus();
				$("#precio_compra_"+id).focus();
				return false;
			}
			//Fin validacion
		
			$.ajax({
				type: "POST",
				url: "./ajax/agregar_compra.php",
				data: "id="+id+"&precio_compra="+precio_compra+"&cantidad="+cantidad+"&dato_adicional="+dato_adicional,
				 beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
				  },
				success: function(datos){
					$("#resultados").html(datos);
				}
			});
	}
		

	function eliminar (id) 	{
			
		$.ajax({
			type: "GET",
			url: "./ajax/agregar_compra.php",
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
			//window.alert('Dato cantidad tiene que ser númerico!');
			$("#cantidad_tmp_"+id).focus();
			return false;
		} else if(n_c=="") {
			//window.alert('Dato cantidad no puede quedar en blanco!');
			$("#cantidad_tmp_"+id).focus();
			return false;
		}
		
		if (isNaN(n_p)) {
			//window.alert('Dato precio compra tiene que ser númerico!');
			$("#precio_tmp_"+id).focus();
			return false;
		} else if(n_p=="") {
			//window.alert('Dato precio compra no puede quedar en blanco!');
			$("#precio_tmp_"+id).focus();
			return false;
		}
		
		$.ajax({
			type: "GET",
			url: "./ajax/agregar_compra.php",
			data: "id="+id+"&modo="+modo+"&d_a="+d_a+"&n_c="+n_c+"&n_p="+n_p,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados").html(datos);
			}
		});
	}
		
	

	
	$( "#guardar_proveedor" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var param = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_proveedor.php",
					data: param,
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
		  
		 var param = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_producto.php",
					data: param,
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
