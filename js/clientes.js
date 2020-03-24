		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_clientes.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
	function eliminar (id) 	{
	
	var q= $("#q").val();
	
	if (confirm("Realmente deseas eliminar el cliente")) {
		$.ajax({
			type: "GET",
			url: "./ajax/buscar_clientes.php",
			data: "id="+id,"q":q,
			 beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			  },
			success: function(datos){
				$("#resultados").html(datos);
				load(1);
			}
			});
		}
	}
		
		
	
$( "#guardar_cliente" ).submit(function( event ) {
  //$('#guardar_datos').attr("disabled", true);
  
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
			$('#guardar_datos').attr("disabled", true);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_cliente" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_cliente.php",
			data: parametros,
			beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			},
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var nombre_cliente = $("#nombre_cliente"+id).val();
			var telefono_cliente = $("#telefono_cliente"+id).val();
			var email_cliente = $("#email_cliente"+id).val();
			var direccion_cliente = $("#direccion_cliente"+id).val();
			var status_cliente = $("#status_cliente"+id).val();
			
			var ape_pat_cliente = $("#ape_pat_cliente"+id).val();
			var ape_mat_cliente = $("#ape_mat_cliente"+id).val();
			var col_cliente = $("#col_cliente"+id).val();
			var cp_cliente = $("#cp_cliente"+id).val();
			var ciudad_cliente = $("#ciudad_cliente"+id).val();
			var estado_cliente = $("#estado_cliente"+id).val();
			var pais_cliente = $("#pais_cliente"+id).val();
			var tipo_cliente = $("#tipo_cliente"+id).val();
			var rfc_cliente = $("#rfc_cliente"+id).val();
			var tipo_prec_cliente = $("#tipo_prec_cliente"+id).val();
			var lim_cred_cliente = $("#lim_cred_cliente"+id).val();
			var act_cred_cliente = $("#act_cred_cliente"+id).val();
			
			$("#mod_nombre").val(nombre_cliente);
			$("#mod_telefono").val(telefono_cliente);
			$("#mod_email").val(email_cliente);
			$("#mod_direccion").val(direccion_cliente);
			$("#mod_estatus").val(status_cliente);
			
			$("#mod_ape_pat_clie").val(ape_pat_cliente);
			$("#mod_ape_mat_clie").val(ape_mat_cliente);
			$("#mod_col_clie").val(col_cliente);
			$("#mod_cp_clie").val(cp_cliente);
			$("#mod_ciudad_clie").val(ciudad_cliente);
			$("#mod_estado_clie").val(estado_cliente);
			$("#mod_pais_clie").val(pais_cliente);
			$("#mod_tipo_clie").val(tipo_cliente);
			$("#mod_rfc_clie").val(rfc_cliente);
			$("#mod_tipo_prec_clie").val(tipo_prec_cliente);
			$("#mod_lim_cred_clie").val(lim_cred_cliente);
			$('#mod_act_cred_clie').attr('checked', act_cred_cliente == 1 ? true : false);
			$("#mod_id").val(id);
		
			fmodchktiporfc();
		
		}

$('#nuevoCliente').on('hidden.bs.modal', function () {
	$('#alert1').hide();
	$('#alert2').hide();
	$('#nuevoCliente').find('form').trigger('reset');
	$('#guardar_datos').attr("disabled", false);
})

$('#myModal2').on('hidden.bs.modal', function () {
	$('#alert1').hide();
	$('#alert2').hide();
	$('#editar_cliente').find('form').trigger('reset');
})
