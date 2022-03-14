<?php 
require_once 'modelo/conexion.php';
require_once 'modelo/msol.php';

$idsol = isset($_POST['idsol']) ? $_POST['idsol']:NULL;
if(!$idsol)
	$idsol = isset($_GET['idsol']) ? $_GET['idsol']:NULL;

$motivo = isset($_POST['motivo']) ? $_POST['motivo']:NULL;

$idveh = isset($_POST['idveh']) ? $_POST['idveh']:NULL;
if(!$idveh)
	$idveh = isset($_POST['idveh']) ? $_POST['idveh']:NULL;

$fecsol = isset($_POST['fecsol']) ? $_POST['fecsol']:NULL;
if(!$fecsol)
	$fecsol = isset($_GET['fecsol']) ? $_GET['fecsol']:NULL;	

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;	



//echo "<br><br><br>".$fecsol."-".$idsol."-".$motivo."-".$idveh."-".$opera."<br><br>";

$pg = 1003;
$arc = "home.php";
$msol = new msol();

if($opera=="new"){
	if($idveh){
		$fecsol = date('Y-m-d');
		$msol->inssol($idsol,$fecsol,$motivo,$idveh);
		$solicitud = $msol->selsol2($fecsol,$motivo, $idveh);
		echo '<script>window.location="home.php?pg=1004&idsol='.$solicitud[0]['idsol'].'";</script>';
		$idsol= NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

function insdatos($idsol,$pg,$arc){
	$msol = new msol();
	$dtveh = $msol->selveh();	
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion entrega de vehiculos</h6>';
		$txt .= '</div>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
		if($idsol){
			$txt .= '<label>Id</label>';
			$txt .= '<input type="text" name="idsol" readonly value="'.$idsol.'" class="form-control" />';
		}
			$txt .= '<label>Seleccione el Vehiculo</label><br>';
			if($dtveh){
				$txt .= '<select name ="idveh" class="form-control">';
				foreach ($dtveh as $dpg) {
					$txt .= '<option value="'.$dpg['idveh'].'"';
						if ($dtveh[0]['idveh']==$dpg['placaveh']) $txt .= " selected ";
					$txt .= '>'; 
						$txt .= $dpg['placaveh']; 
					$txt .= '</option>';
				}
				$txt .= '</select>';
			$txt .= '<label>Motivo</label><br>';
			if($dtveh){
				$txt .= '<select name ="motivo" class="form-control">';
					$txt .= '<option value="1">Entrega</option>';
					$txt .= '<option value="2">Devolucion</option>';
				$txt .= '</select>';
			}
			$txt .= '<input type="hidden" name="opera" value="new">';
			$txt .= '<div class="col text-center">';				

			$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($idsol)
					$txt .= 'Actualizar';
				else
					$txt .= 'Nueva';
				$txt .= '">';	
			$txt .= '</div>';	
			$txt .= '</form>';
		}
	$txt .= '</div>';	
	echo $txt;
}
function mosdatos($idsol,$pg, $arc){
	$msol = new msol();
	$dtac = $msol->selacta();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
    		$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Actas de entrega</h6>';
    		$txt .= '</div>';
    	$txt .= '<div class="card-body">';
        $txt .= '<div class="table-responsive">';
	if ($dtac){			
			$txt .= '<table id="datatablesSimple">';
			$txt .= '<thead>';
				$txt .= '<tr>';					
					$txt .= '<th>ID</th>';
					$txt .= '<th>ADMIN</th>';
					$txt .= '<th>Fecha</th>';
					$txt .= '<th>Persona que Entrega</th>';
					$txt .= '<th>Placa de vehiculo</th>';
				$txt .= '</tr>';
			$txt .= '</thead>';
			$txt .= '<tfoot>';
					$txt .= '<tr>';					
					$txt .= '<th>ID</th>';
					$txt .= '<th>ADMIN</th>';
					$txt .= '<th>Fecha</th>';
					$txt .= '<th>Persona que Entrega</th>';
					$txt .= '<th>Placa de vehiculo</th>';
				$txt .= '</tr>';
			$txt .= '</tfoot>';
			$txt .= '<tbody>';		
			foreach ($dtac as $dt){				
				$txt .= '<tr>';		
					$txt .= '<td>'.$dt['idsol'].'</td>';

					$txt .= '<td>';
						$txt .= '<a href="home.php?pg=1004&idsol='.$dt['idsol'].'" title="Modificar">';
							$txt .= '<i class="fas fa-edit fa"></i>';
						$txt .= '</a>';

						$txt .= '<a data-bs-toggle="modal" href="" data-bs-target="#myModal'.$dt['idsol'].'" title="Mostrar Páginas">';
							$txt .= '<i class="fas fa-eye fa"></i>';
						$txt .= '</a> ';

						$txt .= '<a href="vista/vpdfacta.php?idsol='.$dt['idsol'].'" target="_blank" title="Imprimir">';
							$txt .= '<i class="fas fa-print"></i>';
						$txt .= '</a> ';
						$txt .= '<a href="vista/vpdfacta.php?pdf=1547&idsol='.$dt['idsol'].'" title="Generar PDF">';
							$txt .= '<i class="far fa-file-pdf"></i>';
						$txt .= '</a> ';

						$txt .= modal($dt['idsol'],$pg);
					$txt .= '</td>';

					$txt .= '<td>'.$dt['fecsol'].'</td>';
					$txt .= '<td>'.$dt['nomusu'].' '.$dt['apeusu'].'</td>';
					$txt .= '<td>'.$dt['placaveh'].'</td>';
				$txt .= '</tr>';
				
			}	
			$txt .= '</tbody>';

		$txt .= '</table>';

		$txt .= '</div>';
	$txt .= '</div>';

	$txt .= '</div>';


	}else{
		echo "<h2>Sin actas<h2>";
	}

	//subir();
	$txt .= '<a class="scroll-to-top rounded" href="#page-top">';
        $txt .= '<i class="fas fa-angle-up"></i>';
    $txt .= '</a>';
    
	echo $txt;

}
function modal ($idsol, $pg){
	$msol = new msol();
	$dtacta = $msol->selacta2($idsol);
	$lisit = $msol->items($idsol);
	$txt = '';
	$txt .= '<div class="modal fade bd-example-modal-lg" id="myModal'.$idsol.'" tabindex="-1" role="dialog">';

		$txt .= '<div class="modal-dialog modal-lg">';
			$txt .= '<div class="modal-content">';
				$txt .= '<div class="modal-header">';
					$txt .= '<h3 class="modal-title">Solicitud Nro: '.$idsol.'</h3>';
					//$txt .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
					  $txt .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					$txt .= '</div>';
					$txt .= '<div class="modal-body">';				
					if($dtacta){
						//$txt .= "<h2>ITEMS<h2>";
						foreach ($dtacta as $dt) {
							$txt .= '<ul class="list-group list-group-flush">';
								$txt .= '<li class="list-group-item">Fecha: '.$dt['fecsol'].'</li>';
								$txt .= '<li class="list-group-item">Motivo: ';
								if($dt['motivo']==1){
									$txt .= 'Entrega';
								}else{
									$txt .= 'Devolucion';
								}
								$txt .= '</li>';
								$txt .= '<li class="list-group-item">Kilometraje: '.$dt['kilo'].' Kms</li>';
								$txt .= '<li class="list-group-item">Tipo de vehiculo '.$dt['tipov'].'</li>';
								$txt .= '<li class="list-group-item">Placa del vehiculo: '.$dt['placaveh'].'</li>';
								$txt .= '<li class="list-group-item">Modelo del vehiculo: '.$dt['modelo'].'</li>';
								$txt .= '<li class="list-group-item">Tipo de servicio: '.$dt['tis'].'</li>';
								$txt .= '<li class="list-group-item">Color: '.$dt['color'].'</li>';
								$txt .= '<li class="list-group-item">Fecha de vencimiento SOAT: '.$dt['soat'].'</li>';
								$txt .= '<li class="list-group-item">Fecha de vencimiento R.T.M: '.$dt['rtmexp'].'</li>';
							$txt .= '</ul>';			
						}
						if($lisit) {
							$txt .= '<h4>ITEM</h4>';
							foreach ($lisit AS $dt){							
								$txt .= '<div class="container-fluid">';
								  	    $txt .= '<div class="row">';
									      $txt .= '<div class="col-sm-9">'.$dt['nomitem'].'</div>';
									    $txt .= '</div>';						   						  
								$txt .= '</div>';
							}
						}						
						$txt .= '<h4>Novedades</h4>';
						foreach ($dtacta AS $dt){	
							$txt .= '<ul class="list-group list-group-flush">';
								$txt .= '<li class="list-group-item">Novedades '.$dt['novedad'].'</li>';
								$txt .= '<li class="list-group-item">Entrega: '.$dt['nomen'].' '.$dt['apeen'].'</li>';
								$txt .= '<li class="list-group-item">Recibe: '.$dt['nomre'].' '.$dt['apere'].'</li>';

							$txt .= '</ul>';	

						}
						
					}else{
						$txt .= "<h2>No existen datos<h2>";
					}		
					$txt .= '</div>';

					$txt .= '<div class="modal-footer">';
						$txt .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
					$txt .= '</div>';
				$txt .= '</form>';
			$txt .= '</div>';
		$txt .= '</div>';
	$txt .= '</div>';

	return $txt;	
}
?>
