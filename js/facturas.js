	$(document).ready(function() {
		//alert("Hola");
		$.ajaxSetup({ cache:false });
			load(1);
	});

	function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_facturas.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

		
	function eliminar (id) 	{
		var q= $("#q").val();
		
		//Pruebas para la creacion del archivo mikrotik.txt
		/*
		$.ajax({
			type: "POST",
			url: "./ajax/post_data.php",
			data: "data1=email&data2=2871112334&data3=nombre&data4=2008-07-08&data5=M",
			beforeSend: function(objeto) {
			  },
			success: function(data) {
				var obj = JSON.parse(data);
				alert("Return success:"+obj.title);
			},
			error: function(returnerr) {
				alert("Return error:"+returnerr);
			}
		});
		*/
		
		//Prueba send param with ajax
		/*
		var id_cliente=211;
		var id_vendedor=322;
		var aparam={'id_cliente':id_cliente,'id_vendedor':id_vendedor};
		$.ajax({
			url: "./ajax/post_get_pruebas.php",
			data:  { result : JSON.stringify(aparam) },
			beforeSend: function(objeto) {
			  },
			success: function(data) {
				var obj = JSON.parse(data);
				alert("Return success:"+obj.data2);
			},
			error: function(returnerr) {
				alert("Return error:"+returnerr);
			}
		});
		*/
		
		if (confirm("Realmente deseas eliminar el documento seleccionado ?")) {	
			alert("eliminación cancelada, no tiene autorización");
			/*
			$.ajax({
				type: "GET",
				url: "./ajax/buscar_facturas.php",
				data: "id="+id,"q":q,
				 beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$("#resultados").html(datos);
				load(1);
				}
			});
			*/
		}
	}
		
	//Descargar la factura de la lista de documentos principal
	function imprimir_factura(id_factura, nopc) {
		if (nopc==0) {
			VentanaCentrada('./pdf/documentos/ver_documento_pdf.php?id_factura='+id_factura+'&nopc='+nopc,'Documento','','1024','768','true');
		} else {
			//bootbox.alert("Modulo en construccion.");
			//return;
			var q= $("#q").val();
				$("#loader").fadeIn('slow');
				$.ajax({
					url:'./pdf/documentos/ver_documento_pdf.php?id_factura='+id_factura+'&nopc='+nopc,
					 beforeSend: function(objeto){
					 $('#loader').html('<img src="./img/ajax-loader.gif"> Enviando por correo...');
				  },
					success:function(data) {
						$('#loader').html('');
						//bootbox.alert(data);	//Ojo Tmp
						if (data==0) {
							bootbox.alert("Correo enviado correctamente.");
						} else {
							bootbox.alert("Error, correo no pudo ser enviado: " + data);
						}
					}
				})
		}
	}
