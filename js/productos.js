		$(document).ready(function(){
			load(1,8);
		});

		function load(page,per_page) {
			var q= $("#q").val();
			
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_productos.php?action=ajax&page='+page+'&q='+q+'&per_page='+per_page,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

		
		function _eliminar (id) 	{
			var q= $("#q").val();
			if (confirm("Realmente deseas eliminar el producto")){	
				alert("Eliminación del producto cancelado, no tiene autorización");
				/*
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
				*/
			}
		}

		function eliminar (id) 	{
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
							load(1,8);
						}
					});
				}
			});
			//if (sta==1) {
			//	bootbox.alert("Eliminación del producto cancelado, no se tiene autorización");
			//}
		}
