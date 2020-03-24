<?php

	if (isset($_REQUEST['precio_cost'])){
		$costo=floatval($_REQUEST['precio_cost']);
		$utili1=intval($_REQUEST['utili1']);
		$utili2=intval($_REQUEST['utili2']);
		$utili3=intval($_REQUEST['utili3']);
		$utili4=intval($_REQUEST['utili4']);
		
		$utili1=($costo * $utili1) /100;
		$precio_v1=$costo + $utili1;
		$precio_v1=number_format($precio_v1,2,'.','');
		
		$utili2=($costo * $utili2) /100;
		$precio_v2=$costo + $utili2;
		$precio_v2=number_format($precio_v2,2,'.','');
		
		$utili3=($costo * $utili3) /100;
		$precio_v3=$costo + $utili3;
		$precio_v3=number_format($precio_v3,2,'.','');
		
		$utili4=($costo * $utili4) /100;
		$precio_v4=$costo + $utili4;
		$precio_v4=number_format($precio_v4,2,'.','');
		
		if ($_REQUEST['metod']==0 ){
			$price[] = array('precio1'=> $precio_v1,'precio2'=> $precio_v2,'precio3'=> $precio_v3,'precio4'=> $precio_v4);
		}
		else {
			$price[] = array('precio'=> $precio_v1);
		}
		//Create JSON
		$json_string = json_encode($price);
		echo $json_string;
	}
		
?>