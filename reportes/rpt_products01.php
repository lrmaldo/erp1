<?php

session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
	exit;
}

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/* Connect To Database*/
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
include("../funciones.php");

//$sqry = " select * from products LEFT JOIN cant_products ON products.id_producto=cant_products.id_product 
//		 			 INNER JOIN unidades ON products.id_unidad=unidades.id_unidad";

if ($_SESSION['B_RPT01']=='') {
	$filter="Sin filtro";
} else {
	$filter='Filtrado por: ' . $_SESSION['B_RPT01'];
}

$sqry = $_SESSION['S_RPT01'];
$qry_prod=mysqli_query( $con, $sqry );

/** Include PHPExcel */
require_once '../classes/PHPExcel.php';
//require_once '../classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Sattlink")
							 ->setLastModifiedBy("Sattlink-26Dic2017")
							 ->setTitle("ERP Productos - Sattlink")
							 ->setSubject("Sattlink Reporte de Productos")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");

$dDate=date('d/m/Y h:i:s a', time());
$sheet=$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B1', 'Reporte del Cátalogo de Productos - Erp Sattlink  ver 2.11b  ' . $dDate )
			->setCellValue('C1', $filter )
            ->setCellValue('A3', 'CODIGO')
            ->setCellValue('B3', 'PRODUCTO')
			->setCellValue('C3', 'PRECIO COSTO')
			->setCellValue('D3', 'UND')
			->setCellValue('E3', 'P.I.')
			->setCellValue('F3', 'PRECIO 1')
			->setCellValue('G3', 'EXIST.ACTUAL')
			->setCellValue('H3', 'NUEVA EXIST.');

// Set Orientation, size and scaling
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E3')->getText()->createTextRun('Producto Inventariable');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	  			'rotation'   => 90,
	 			'startcolor' => array(
	 				'argb' => 'FFA0A0A0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FFFFFFFF'
	 			)
	 		)
		)
);

// Set alignments
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

// Set fills Head
//$objPHPExcel->getActiveSheet()->getStyle('B1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$objPHPExcel->getActiveSheet()->getStyle('B1:F1')->getFill()->getStartColor()->setARGB('FF808080');

// Logo
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../'.get_row('perfil','logo_url', 'id_perfil', 1));
$objDrawing->setHeight(36);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

/*
foreach($products as $product){
	$sheet->setCellValue('A'.$start, $product->codigo_producto)
	->setCellValue('B'.$start, $product->nombre_producto)
$start++;
}
*/
$start = 4;
while ($rw=mysqli_fetch_array($qry_prod)){
	$sheet->setCellValue('A'.$start, $rw['codigo_producto'])
	->setCellValue('B'.$start, $rw['nombre_producto'])
	->setCellValue('C'.$start, $rw['precio_cost'])
	->setCellValue('D'.$start, $rw['nombre_unidad'])
	->setCellValue('E'.$start, $svalue=($rw['prod_invent']==1) ? "S" : "N"  )
	->setCellValue('F'.$start, $rw['precio_producto'])
	->setCellValue('G'.$start, $rw['cantidad']);
	$start++;
}

//$objPHPExcel->getActiveSheet()->getStyle('F3:F'.$start)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel->getActiveSheet()->getStyle('F3:F'.$start)->getNumberFormat()->setFormatCode('"$"##,##0.00_-');

// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
//$callStartTime = microtime(true);

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
//$callEndTime = microtime(true);
//$callTime = $callEndTime - $callStartTime;

// Redirect output to a client’s web browser (OpenDocument)
header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
header('Content-Disposition: attachment;filename="productos-'.$dDate.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
//header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
