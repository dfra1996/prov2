<?php 
require_once '../modelo/conexion.php';
require_once '../modelo/mpdfacta.php';

$pdf = isset($_GET['pdf']) ? $_GET['pdf']:NULL;

$idsol = isset($_POST['idsol']) ? $_POST['idsol']:NULL;
if(!$idsol)
	$idsol = isset($_GET['idsol']) ? $_GET['idsol']:NULL;
$mpdfacta = new mpdfacta();
$dtacta = $mpdfacta->selacta2($idsol);
$dtitem = $mpdfacta->lisitem();
//$dtres = $mpdfacta->respuestas($idsol);
$html = "";
if ($dtacta){
	$html .= '<head>';
	$html .= '<style type="text/css">';
	$html .= 'html{';
	$html .= 'margin: 0;';
	$html .= '}';
	$html .= 'body{';	     
	$html .= 'font-size: 10px;';
	$html .= 'margin: 10mm 20mm 10mm 20mm;';
	$html .= '}';
	$html .= 'td{';	     
	$html .= 'font-size: 10px;';
	$html .= 'color: #000;';
	$html .= '}';
	$html .= 'ul{';
	$html .= 'column-count: 2;';
	$html .= '}';
	$html .= 'li{';
	$html .= 'font-size: 10px;';
	$html .= '}';
	$html .= '#item{';
	$html .= 'margin: 0px;';
	$html .= 'padding: 0px;';
	$html .= 'background-color: orange;';
	$html .= ' }';
	$html .= '</style>';
		$html .= '</head>';
		$html .= '<body>';
		$html .= '<table style="border-collapse: collapse; width: 100%; height: 50px;" border="1">';
		$html .= '<tbody>';
		$html .= '<tr style="height: 50px;">';
		$html .= '<td style="width: 40%; height: 50px;"><center><img src="../img/myc.jpg"></center></td>';
		$html .= '<td style="height: 50px; width: 60%; text-align: center;"><strong>ACTA DE ENTREGA Y RECIBO DE VEHICULOS</strong></td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table style="border-collapse: collapse; width: 100%; height: 18px;" border="1">';
		$html .= '<tbody>';
			$html .= '<tr style="height: 18px;">';
				$html .= '<td style="width: 33.33333333%; height: 10px;"><center>F-72</center></td>';
				$html .= '<td style="width: 33.33333333%; height: 10px;"><center>Versión Digital</center></td>';
				$html .= '<td style="width: 33.33333333%; height: 10px;"><center>Sept 21</center></td>';
			$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';	
		


foreach ($dtacta as $dt) {
	$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
	$html .= '<tbody>';
	$html .= '<tr>';
	$html .= '<td style="width: 25%; height: 10px;">FECHA&nbsp;</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['fecsol'].'</td>';
	$html .= '<td style="width: 25%; height: 10px;">PLACA</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['placaveh'].'</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td style="width: 25%; height: 10px;">MOTIVO</td>';
	$html .= '<td style="width: 25%; height: 10px;">';
	if($dt['motivo']==1)
		$html .= 'Entrega';
	elseif ($dt['motivo']==2)
		$html .= 'Devolucion';


	$html.= '</td>';
	$html .= '<td style="width: 25%; height: 10px;">MODELO&nbsp;</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['modelo'].'</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td style="width: 25%; height: 10px;">TIPO DE VEHICULO</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['tipov'].'</td>';
	$html .= '<td style="width: 25%; height: 10px;">COLOR&nbsp;</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['color'].'</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td style="width: 25%; height: 10px;">SERVICIO</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['tis'].'</td>';
	$html .= '<td style="width: 25%; height: 10px;">KILOMETRAJE</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['kilo'].'</td>';
	$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';
}
$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
$html .= '<tbody>';
$html .= '<tr>';
$html .= '<td style="width: 70%; text-align: center; height: 10px;"><strong>ITEM</strong></td>';
$html .= '<td style="width: 30%; height: 10px; text-align: center;"><strong>ESTADO</strong></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td style="width: 70%;">';
foreach ($dtitem as $dt) {
	$html .= $dt['nomitem'].'<br>';
}
$html .= '</td>';

$html .= '<td style="width: 30%;">';
foreach ($dtitem as $dt) {
	$marca = $mpdfacta->marcar($dt['iditem'], $idsol);

	//$html .= $dt['nomitem'].'<br>';
	if($marca){
    	$html .= 'Bueno<br>';    
    }
    else{
    	$html .= 'Malo<br>';   
    }
}
$html .= '</td>';
$html .= '</tr>';
$html .= '</tbody>';
$html .= '</table>';


$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
$html .= '<tbody>';
$html .= '<tr>';
$html .= '<td style="width: 100%;">NOVEDADES ENCONTRADAS:&nbsp;</td>';
$html .= '</tr>';
$html .= '</tbody>';
$html .= '</table>';







$html .= '</body>';

}
?>