
	
	function eliminar (id) {
		bootbox.alert("Partida de compra no puede eliminarse cuando es cerrada");
	}

	function update_detalle_doc (id) {
		bootbox.alert("Partida de compra no puede actualizarse cuando es cerrada");
	}
		
	
	//cuando el documento se hizo y hubo cambios se puede generar de nuevo
	function imprimir_factura(id_factura) {
			//VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
			VentanaCentrada('./pdf/documentos/ver_documento_pdf.php?id_factura='+id_factura,'Documento','','1024','768','true');
			
	}