<?php 
require_once '../modelo/conexion.php';
require_once '../modelo/mpdfprev.php';

$pdf = isset($_GET['pdf']) ? $_GET['pdf']:NULL;

$idprev = isset($_POST['idprev']) ? $_POST['idprev']:NULL;
if(!$idprev)
	$idprev = isset($_GET['idprev']) ? $_GET['idprev']:NULL;
#http://localhost/pro/vista/vpdfprev.php?idprev=35
#http://localhost/pro/vista/vpdfprev.php?pdf=1547&idprev=35
$mpdfprev = new mpdfprev();
$dtprev = $mpdfprev->selpre1($idprev);
$dtitem = $mpdfprev->itemse($idprev);
$dtest = $mpdfprev->itemses($idprev);
$html = "";
if ($dtprev){
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
$html .= ' footer {';
$html .= ' position: fixed; ';
$html .= ' bottom: -30px; ';
$html .= ' left: 0px; ';
$html .= ' right: 0px;';
$html .= ' height: 50px;';
$html .= ' margin: 10px;';
$html .= ' header {';
$html .= ' position: fixed; ';
$html .= ' top: -60px; ';
$html .= ' left: 0px; ';
$html .= ' right: 0px;';
//$html .= ' height: 50px;';
$html .= ' }';

$html .= ' hr {';
  $html .= ' page-break-after: always;';
  $html .= ' border: 0;';
  $html .= ' margin: 0;';
  $html .= ' padding: 0;';
$html .= ' }';


$html .= '</style>';
	$html .= '</head>';
	$html .= '<body>';
#CABECERA
$html .= '<header>';	
	$html .= '<table style="border-collapse: collapse; width: 100%; height: 50px;" border="1">';
	$html .= '<tbody>';
	$html .= '<tr style="height: 50px;">';
	$html .= '<td style="width: 40%; height: 50px;"><center><img src="../img/myc.jpg"></center></td>';
	$html .= '<td style="height: 50px; width: 60%; text-align: center;"><strong>LISTA DE CHEQUEO VEHICULOS</strong></td>';
	$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';

	$html .= '<table style="border-collapse: collapse; width: 100%; height: 18px;" border="1">';
	$html .= '<tbody>';
		$html .= '<tr style="height: 18px;">';	



			$html .= '<td style="width: 33.33333333%; height: 10px;"><center>';
			if($dtprev[0]['tipoveh']==1)
				$html .= 'F-104';
			elseif($dtprev[0]['tipoveh']==2)
				$html .= 'F-103';
			elseif($dtprev[0]['tipoveh']==3)
				$html .= 'F-102';
			elseif($dtprev[0]['tipoveh']==4)
				$html .= 'F-101';
			elseif($dtprev[0]['tipoveh']==5)
				$html .= 'F-120';
			elseif($dtprev[0]['tipoveh']==6)
				$html .= 'F-119';			

			$html .= '</center></td>';
			$html .= '<td style="width: 33.33333333%; height: 10px;"><center>Versión Digital</center></td>';
			$html .= '<td style="width: 33.33333333%; height: 10px;"><center>Sept 21</center></td>';
		$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';

$html .= '</header>';	

foreach ($dtprev as $dt) {


	$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
	$html .= '<tbody>';

	$html .= '<tr style="height: 10px;">';
	$html .= '<td style="width: 25%; height: 10px;"><strong>FECHA Y HORA DEL PREOPERACIONAL</strong></td>';
	$html .= '<td style="width: 25%; height: 10px;"><strong>'.$dt['fecpre'].'</strong></td>';




	$html .= '</tr>';

	$html .= '</tbody>';
	$html .= '</table>';	




	$html .= '<table style="border-collapse: collapse; width: 100%; height: 90px;" border="1">';
	$html .= '<tbody>';

	$html .= '<tr style="height: 10px;">';
	$html .= '<td style="width: 25%; height: 10px;">NOMBRE</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['nomusu'].' '.$dt['apeusu'].'</td>';
	$html .= '<td style="width: 25%; height: 10px;">SOAT</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['soat'].'</td>';
	$html .= '</tr>';
	$html .= '<tr style="height: 10px;">';
	$html .= '<td style="width: 25%; height: 10px;">CC</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['docid'].'</td>';
	$html .= '<td style="width: 25%; height: 10px;">RTM</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['rtmexp'].'</td>';
	$html .= '</tr>';
	$html .= '<tr style="height: 10px;">';
	$html .= '<td style="width: 25%; height: 10px;">VEN LICENCIA</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['vlictran'].'</td>';
	$html .= '<td style="width: 25%; height: 10px;">POLIZA</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['venstr'].'</td>';
	$html .= '</tr>';
	$html .= '<tr style="height: 10px;">';
	$html .= '<td style="width: 25%; height: 10px;">PLACA</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['placaveh'].'</td>';
	$html .= '<td style="width: 25%; height: 10px;">TIPO DE VEHICULO</td>';
	$html .= '<td style="width: 25%; height: 10px;">'.$dt['nomv'].'</td>';
	$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';
}



	if($dtprev[0]['tipoveh']==5){
		$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td style="width: 30%;">VEHICULO CON EL QUE SE DESPLAZA</td>';
		$html .= '<td style="width: 70%;">';
		foreach ($dtprev as $dt) {
			$html .= $dt['chipper'].'.';
	}	
		$html .= '</td>';		
		$html .= '</tr>';		
		$html .= '</tbody>';
		$html .= '</table>';
	}

#ITEMS EQUIPO DE CARRETERA
if($dtitem){
	$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
	$html .= '<tbody>';
	$html .= '<tr>';
	if($dtprev[0]['tipoveh']==6)
		$html .= '<td style="width: 30%;">EQUIPO DE PROTECCIÓN</td>';
	else
		$html .= '<td style="width: 30%;">EQUIPO DE CARRETERA</td>';
	$html .= '<td style="width: 70%;">';
	foreach ($dtitem as $dt) {
		$html .= $dt['nomitem'].', ';
	}
		
		$html .= '.</td>';	
		$html .= '</tr>';	
		$html .= '<tr>';
	foreach ($dtprev as $dt) {
			$html .= '<td style="width: 30%;">FECHA DE VENCIMIENTO EXTINTOR</td>';
			$html .= '<td style="width: 70%;">'.$dt['expext'].'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			if($dtprev[0]['tipoveh']==6)
				$html .= '<td style="width: 30%;">NOVEDADES EQUIPO DE PROTECCIÓN</td>';
			else
				$html .= '<td style="width: 30%;">NOVEDADES EQUIPO DE CARRETERA</td>';
			$html .= '<td style="width: 70%;">'.$dt['desequi'].'</td>';
		}	

	$html .= '</tr>';
	
	$html .= '</tbody>';
	$html .= '</table>';
}

#KILOMETRAJE
$html .= '<table style="border-collapse: collapse; width: 100%;" border="1">';
$html .= '<tbody>';
$html .= '<tr>';
if ($dtprev){
	foreach($dtprev AS $dt){
		$html .= '<td style="width: 25%;">KILOMETRAJE</td>';
		$html .= '<td style="width: 25%;">'.$dt['kilo'].'</td>';
		$html .= '<td style="width: 25%;">HOROMETRO</td>';
		$html .= '<td style="width: 25%;">'.$dt['horo'].'</td>';
	}
}
$html .= '</tr>';
$html .= '</tbody>';
$html .= '</table>';

#ITEMS
if ($dtest){	
	//$html .= 'h l '.$dtest[0]['nomitem'];
	$html .= '<table style="border-collapse: collapse; width: 100%; height: 36px;" border="1">';
	$html .= '<tbody>';
	$html .= '<tr style="height: 18px;">';
	$html .= '<td style="width: 73.2075%; height: 18px;"><strong>ITEM</strong></td>';
	$html .= '<td style="width: 26.7925%; height: 18px;"><strong>ESTADO</strong></td>';
	$html .= '</tr>';
	$html .= '<tr style="height: 18px;">';

	$html .= '<td style="width: 75%; height: 18px;">';
	foreach($dtest AS $dt){
		$html .= $dt['nomitem'].'<br>';	
	}	
	$html .= '</td>';
	$html .= '<td style="width: 25%; height: 18px;">';
	foreach($dtest AS $dt){
		if($dt['res']==3)
			$html .= 'BUENO<br>';	 
			#$html .= '<img src="../img/ok.png"><br>';
		elseif($dt['res']==4)
			#$html .= '<img src="../img/x.png"><br>';
			$html .= 'MALO<br>';	
	}		
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	foreach ($dtprev AS $dt){
		$html .= '<td style="width: 80%;">¿EL VEHICULO PRESENTA FUGAS?</td>';
		$html .= '<td>';
		if($dt['fuga']==1) {
			$html .= 'SI'; 
		}
		else{
			$html .= 'NO';
		}
		$html .='</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="width: 80%;">CUALES: '.$dt['desfuga'].'</td>';
	}
	$html .= '<td></td>';
	$html .= '</tr>';

	$html .= '</tbody>';
	$html .= '</table>';
}	
foreach ($dtprev as $dt) {
	$html .= '<table style="border-collapse: collapse; width: 100%; height: 54px; margin-bottom:10px;" border="1">';
	$html .= '<tbody>';
	$html .= '<tr style="height: 100px;">';			
	$html .= '<td style="width: 100%; height: 100px;">';
	$html .= '<p>NOVEDADES</p>';
	$html .= '<p>'.$dt['novedad'].'</p>';
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '<tr style="height: 100px;">';
	$html .= '<td style="width: 100%; height: 100px;">';
	$html .= '<p>IMPREVISTOS Y REPARACIONES</p>';
	$html .= '<p>'.$dt['impre'].'</p>';	
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';
}
$html .= '<footer>';
	//$html .= '<p>END OF LINE</p>';
$html .= '</footer>';
$html .= '<hr>';
foreach ($dtprev as $dt) {
	if($dt['img']){
		$html .= '<p>IMAGEN DEL VEHICULO</p>';
		$html .= '<img style="width:100%; height:100%;" src="../'.$dt['img'].'">';
	}
}	
	$html .= '</body>';
}else{
	echo "no data";
}
?>