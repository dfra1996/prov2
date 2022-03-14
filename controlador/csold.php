<?php 
require_once 'modelo/conexion.php';
require_once 'modelo/msold.php';
require_once 'modelo/mpagina.php';

$idres = isset($_POST['idres']) ? $_POST['idres']:NULL;
if(!$idres)
	$idres = isset($_GET['idres']) ? $_GET['idres']:NULL;

$iditem [] = isset($_POST['iditem']) ? $_POST['iditem']:NULL;
$idsol = isset($_POST['idsol']) ? $_POST['idsol']:NULL;
if(!$idsol)
	$idsol = isset($_GET['idsol']) ? $_GET['idsol']:NULL;

$res = isset($_POST['res']) ? $_POST['res']:NULL;
$recibe = isset($_POST['recibe']) ? $_POST['recibe']:NULL;

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

# Variables para insertar segunda parte de la solicitud
$novedad = isset($_POST['novedad']) ? $_POST['novedad']:NULL;
$kilo = isset($_POST['kilo']) ? $_POST['kilo']:NULL;


//echo "<br><br><br>".$idres."-".$idsol."-".$res."-".$opera."-".$novedad."<br><br>";
//echo "<br> ID DE RESPUESTA: -- ".$idres." -- ";
//echo "<br> ID DE SOLICITUD: -- ".$idsol." -- <br>";
var_dump($iditem[0]);
$pg = 1004;
$arc = "home.php";
$msold = new msold();
if($opera=="new"){	
	//$novedad = "PRUEBA INSERT2";
	$entrega = $_SESSION["idusu"];	
	//$recibe = 2;
	$res = 1;
	$msold->deletes($idsol);
	$msold->inssol2($novedad, $entrega, $recibe, $idsol, $kilo);
	if ($res){		
		if($iditem){
			//For que recorre la tabla item y los inserta en la tabla respuestas
			for ($i=0; $i<count($iditem[0]) ; $i++) { 
				$msold->insres($idres, $iditem[0][$i], $idsol, $res);
			}	
			echo '<script>window.location="home.php?pg='.$pg.'";</script>';

		}	
	}else{
		echo "<script>alert('Error');</script>";
	}
}
function dtvehiculo($idsol,$pg,$arc){
	$msold = new msold();
	$dtsol = $msold->seldt($idsol);
	$txt='';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';	if($dtsol){
		foreach ($dtsol as $dt) {
			$txt .= '<br><br>';
				$txt .= '<table class="table table-hover">'; 
					$txt .= '<tr>';
      					$txt .= '<th scope="row" class="table-dark">Fecha</th>';
      					$txt .= '<td colspan="3" class="table-active">'.$dt['fecsol'].'</td>';
    				$txt .= '</tr>';
					$txt .= '<tr>';
						$txt .= '<th scope="row" class="table-dark">Motivo</th>';
						$txt .= '<td colspan="3" class="table-active">';
						if ($dt['motivo']==1){
							$txt .= 'Entrega';
						}elseif($dt['motivo']==2){
							$txt .= 'Devolucion';
						}
						$txt .= '</td>';
					$txt .= '</tr>';
					$txt .= '<tr>';
      					$txt .= '<th scope="row" class="table-dark">Tipo de vehiculo</th>';
      					$txt .= '<td colspan="3" class="table-active">'.$dt['tipov'].'</td>';
    				$txt .= '</tr>';
					$txt .= '<tr>';
						$txt .= '<th scope="row" class="table-dark">Placa del vehiculo</th>';
						$txt .= '<td colspan="3" class="table-active">'.$dt['placaveh'].'</td>';
					$txt .= '</tr>';
					$txt .= '<tr>';
      					$txt .= '<th scope="row" class="table-dark">Modelo</th>';
      					$txt .= '<td colspan="3" class="table-active">'.$dt['modelo'].'</td>';
    				$txt .= '</tr>';
					$txt .= '<tr>';
      					$txt .= '<th scope="row" class="table-dark">Servicio</th>';
      					$txt .= '<td colspan="3" class="table-active">'.$dt['servicio'].'</td>';
    				$txt .= '</tr>';
					$txt .= '<tr>';
      					$txt .= '<th scope="row" class="table-dark">Color</th>';
      					$txt .= '<td colspan="3" class="table-active">'.$dt['color'].'</td>';
    				$txt .= '</tr>';
    				$txt .= '</tbody>';
				$txt.='</table>';
		}
	}
	$txt .= '</div>';
	echo $txt;
}
function items($idsol,$idres,$pg,$arc){
	$msold = new msold();
	$dtitem = $msold->selitem();
	$dtsol = $msold->seldt($idsol);
	$dtcon = $msold->selcond();
	$txt = '';
	$txt .= '<div class="container-fluid">';

	$txt .= '<h2>ITEMS</h2>';
	$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';	
	$txt .= '<input type="hidden" name="idsol" readonly value="'.$idsol.'" class="form-control" />';
	$txt .= '<input type="hidden" name="idres" readonly value="'.$idres.'" class="form-control" />';
	if($dtitem){
		foreach ($dtitem as $dt) {			
				$marca = $msold->marcar($dt['iditem'], $idsol);
				$txt .= '<div class="colum">';		
					$txt .= '<input type="checkbox" name="iditem[]" value="'.$dt['iditem'].'"';
					if($marca) $txt .= 'checked';
					$txt .= '>';
					$txt .= "&nbsp;&nbsp;&nbsp;".$dt['nomitem'];
				$txt .= '</div>';	
						
		}
	}
		$txt .= '<label>Novedades</label>';
		$txt .= '<input type ="text" name="novedad" value="';
		if($dtsol) $txt .= $dtsol[0]['novedad'];
		$txt .= '" class="form-control">';

		$txt .= '<label>Kilometraje</label>';
		$txt .= '<input type ="number" name="kilo"value="';
		if($dtsol) $txt .= $dtsol[0]['kilo'];
		$txt .= '" class="form-control">';

		$txt .= '<label>Conductor que recibe</label>';	

		if($dtcon){
			$txt .= '<select name="recibe" class="form-control">';
			foreach ($dtcon as $dt) {
				$txt .= '<option value="'.$dt['idusu'].'"';
					if ($dtsol[0]['recibe']==$dt['idusu']) $txt .= " selected ";
				$txt .= '>'; 
					$txt .= $dt['nomusu'].' '.$dt['apeusu']; 
				$txt .= '</option>';				
			}
			$txt .= '</select>';
		}
		$txt .= '<input type="hidden" name="opera" value="new">';
		$txt .= '<div class="cen">';
			$txt .= '<input type="submit" class="btn btn-secondary" value="';
			if($idsol)
				$txt .= 'Registrar';			
			$txt .= '">';
		
		$txt .= '</form>';	
	$txt .= '</div>';

	echo $txt;
}
?>
