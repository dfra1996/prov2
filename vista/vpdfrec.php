<?php 
include '../controlador/cpdfrec.php';
ini_set('memory_limit', '512M');
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
if($pdf==1547){
	//echo $html;
	$dompdf = new DOMPDF();
	$paper_size = array(0,0,612,792);

	//$paper_size = array(0,0,612,792);
	$dompdf->set_Paper($paper_size);
	$dompdf->loadHtml($html); 
	$dompdf->render(); 
	$dt = date("Ymd"); 
	$dompdf->stream("Acta de recoleccion Nro ".$idrec." Fecha".$dt.".pdf");	
	$dompdf->setPaper('A4', 'landscape');
}else{
	echo $html;
	echo "<script type='text/javascript'>window.print();</script>";
}
?>