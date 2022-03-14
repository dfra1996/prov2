<?php 
require_once '../modelo/conexion.php';
require_once '../modelo/mpdfrec.php';

$pdf = isset($_GET['pdf']) ? $_GET['pdf']:NULL;

$idrec = isset($_POST['idrec']) ? $_POST['idrec']:NULL;
if(!$idrec)
	$idrec = isset($_GET['idrec']) ? $_GET['idrec']:NULL;
#http://localhost/pro/vista/vpdfprev.php?idrec=35
#http://localhost/pro/vista/vpdfprev.php?pdf=1547&idrec=35
$mpdfrec = new mpdfrec();
$dtrec = $mpdfrec->selrec($idrec);
$html = "";
if ($dtrec){
$html .= '<head>';
$html .= '<style type="text/css">';
$html .= 'html{';
$html .= 'margin: 0;';
$html .= '}';
$html .= 'body{';	     
$html .= 'font-size: 12px;';
$html .= 'margin: 10mm 20mm 10mm 20mm;';
$html .= '}';
$html .= 'td{';	     
$html .= 'font-size: 12px;';
$html .= 'color: #000;';
$html .= '}';
$html .= 'ul{';
$html .= 'column-count: 2;';
$html .= '}';
$html .= 'li{';
$html .= 'font-size: 12px;';
$html .= '}';
$html .= '#item{';
$html .= 'margin: 0px;';
$html .= 'padding: 0px;';
$html .= 'background-color: orange;';
$html .= ' }';
$html .= ' hr {';
  $html .= ' page-break-after: always;';
  $html .= ' border: 0;';
  $html .= ' margin: 10mm 10mm;';
  $html .= ' padding: 0;';
$html .= ' }';

$html .= '</style>';
$html .= '</head>';
	$html .= '<body>';
#CABECERA
$html .= '<table style="border-collapse: collapse; width: 100%; height: 18px;" border="1">';
$html .= '<tbody>';
$html .= '<tr style="height: 18px;">';
$html .= '<td style="width: 40%; height: 18px;"><center><img src="../img/myc.jpg"></center></td>';
$html .= '<td style="height: 18px; width: 60%; text-align: center;"><strong>RECOLECCIÓN DE RESIDUOS VEGETALES</strong></td>';
$html .= '</tr>';
$html .= '</tbody>';
$html .= '</table>';
foreach ($dtrec as $dt) {
	$html .= '<table style="border-collapse: collapse; width: 100%; height: 54px;" border="1">';
	$html .= '<tbody>';
	$html .= '<tr style="height: 18px;">';
	$html .= '<td style="width: 25%; height: 18px;">Fecha poda</td>';
	$html .= '<td style="width: 25%; height: 18px;">'.$dt['fecini'].'</td>';
	$html .= '<td style="width: 25%; height: 18px;">Fecha Recoleccion</td>';
	$html .= '<td style="width: 25%; height: 18px;">';
	if($dt['fecfin']){
		$html .= $dt['fecfin'];
	}else{
		$html .= 'No se ha realizado la recolección';
	}
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '<tr style="height: 18px;">';
	$html .= '<td style="width: 25%; height: 18px;">Zona</td>';
	$html .= '<td style="width: 25%; height: 18px;">'.$dt['zon'].'</td>';
	$html .= '<td style="width: 25%; height: 18px;">Municipio</td>';
	$html .= '<td style="width: 25%; height: 18px;">'.$dt['mun'].'</td>';
	$html .= '</tr>';
	$html .= '<tr style="height: 18px;">';
	$html .= '<td style="width: 25%; height: 36px;">Circuito</td>';
	$html .= '<td style="width: 25%; height: 36px;">'.$dt['nomcir'].'</td>';
	$html .= '<td style="width: 25%; height: 36px;">Direccion</td>';
	$html .= '<td style="width: 25%; height: 36px;">'.$dt['dir'].'</td>';
	$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';

	$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
	$html .= '<tbody>';
	$html .= '<tr>';
	$html .= '<td style="width: 50%;">Persona que poda</td>';
	$html .= '<td style="width: 50%;">'.$dt['nomusu'].' '.$dt['apeusu'].'</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td style="width: 50%;">Persona recolecci&oacute;n</td>';
	$html .= '<td style="width: 50%;">';
	if($dt['idpo']){
		$html .= $dt['uprec'].' '.$dt['aprec'];


	}else{
				$html .= 'No se ha realizado la recolección';
	}
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td style="width: 50%;">Latitud</td>';
	$html .= '<td style="width: 50%;">'.$dt['lat'].'</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td style="width: 50%;">Longitud</td>';
	$html .= '<td style="width: 50%;">'.$dt['lng'].'</td>';
	$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';
$html .= '<table style="border-collapse: collapse; width: 100%; height: 160px;" border="1">';
$html .= '<tbody>';
$html .= '<tr style="height: 18px;">';
$html .= '<td style="width: 50%; height: 18px;">Foto inicial</td>';
$html .= '<td style="width: 50%; height: 18px;">Foto Final</td>';
$html .= '</tr>';
$html .= '<tr style="height: 142px;">';
$html .= '<td style="width: 50%; height: 400px;"><center><img style="width:310px; height:100%;" src="../'.$dt['fotini'].'"></center></td>';
$html .= '<td style="width: 50%; height: 400px;">';
if($dt['fotfin']){
	$html .= '<center><img style="width:310px; height:100%;" src="../'.$dt['fotfin'].'"></center>';
}else{
	$html .= 'No se ha realizado la recolección';

}
$html .= '</td>';
$html .= '</tr>';
$html .= '</tbody>';
$html .= '</table>';

$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
$html .= '<tbody>';
$html .= '<tr>';


$html .= '<td style="width: 30%;">Cantidad Arboles</td>';
$html .= '<td style="width: 70%;">';

$html .= $dt['arbol'];

$html .= '</td>';

$html .= '</tr>';
$html .= '<tr>';


$html .= '<td style="width: 30%;">Novedades</td>';
$html .= '<td style="width: 70%;">';
if($dt['novedad']){
	$html .= $dt['novedad'];
}else{
	$html .= 'No se ha realizado la recolección';

}
$html .= '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td style="width: 30%;">Estado</td>';
$html .= '<td style="width: 70%;">';
if($dt['estado']==1){
	$html .= 'Abierto "Falta recolección"';
}elseif($dt['estado']==2){
	$html .= 'Cerrado';
}
$html .= '</td>';
$html .= '</tr>';
$html .= '</tbody>';
$html .= '</table>';

$html .= '</body>';
	}
}
?>