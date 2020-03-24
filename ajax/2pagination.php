<?php
function paginate($reload, $page, $tpages, $adjacents, $per_page, $count) {
	$prevlabel = "&lsaquo; Anterior";
	$nextlabel = "Siguiente &rsaquo;";
	$allrecords = "Todos"; 
	$bloques = "Paginación por bloques"; 
	$out = '<div style="text-align:center">';
	$out .= '<ul class="pagination pagination-large">';
	
	//print "tpages: " . $tpages . " ". "per_page: " . $per_page . " " . "count: " . $count;
		
	//if only is one page and count is more big and records per paginate is more big than eigth
	if ($tpages==1) {
		//print "here 1 ";
		if ($per_page == 10001 ) {
			if ($count > 8) {
				//print "here 2";
				$out.= "<li><span><a href='javascript:void(0);' onclick='load(".($page).",8)'>$bloques</a></span></li>";
				$out.= "</ul></div>";
				return $out;
			}
		}
	}
	
	// previous label
	if($page==1) {
		$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
	} else if($page==2) {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(1,8)'>$prevlabel</a></span></li>";
	}else {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(".($page-1).",8)'>$prevlabel</a></span></li>";
	}
	
	// first label
	if($page>($adjacents+1)) {
		$out.= "<li><a href='javascript:void(0);' onclick='load(1,8)'>1</a></li>";
	}
	// interval
	if($page>($adjacents+2)) {
		$out.= "<li><a>...</a></li>";
	}

	// pages
	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<li class='active'><a>$i</a></li>";
		}else if($i==1) {
			$out.= "<li><a href='javascript:void(0);' onclick='load(1,8)'>$i</a></li>";
		}else {
			$out.= "<li><a href='javascript:void(0);' onclick='load(".$i.",8)'>$i</a></li>";
		}
	}

	// interval
	if($page<($tpages-$adjacents-1)) {
		$out.= "<li><a>...</a></li>";
	}

	// last
	if($page<($tpages-$adjacents)) {
		$out.= "<li><a href='javascript:void(0);' onclick='load($tpages,8)'>$tpages</a></li>";
	}

	// next
	if($page<$tpages) {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(".($page+1).",8)'>$nextlabel</a></span></li>";
		
		// show flag all records
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(1,10001)'>$allrecords</a></span></li>";

	} else {
		
		$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		
		// show flag all records
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(1,10001)'>$allrecords</a></span></li>";
	}
	
	$out.= "</ul></div>";
	return $out;
}
?>