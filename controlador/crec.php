<?php 
require_once 'controlador/optimg.php';
require_once 'modelo/conexion.php';
require_once 'modelo/mrec.php';
$pg = 1006;
$arc = "home.php";
$mrec = new mrec();

$idrec = isset($_POST['idrec']) ? $_POST['idrec']:NULL;
if(!$idrec)
	$idrec = isset($_GET['idrec']) ? $_GET['idrec']:NULL;
//echo "<br><br><br>".$idusu."-".$novedad."-".$archb."-".$estado."-".$opera."<br><br>";
//echo "<br><br><br>".$idzon."-".$dir."-".$idcir."-".$norden."-".$fotini."-".$arbol."-".$lat."-".$lng."-".$estado."<br><br>";

function mosdatos($idrec,$pg, $arc){
	$mrev = new mrec();
	$dtrec = $mrev->rec();
	$txt = '';
		$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';
		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Recolección</h6>';
		$txt .= '</div>';

		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado solicitudes de Recolección</h6>';
		$txt .= '</div>';
    	$txt .= '<div class="card-body">';
	        $txt .= '<div class="table-responsive">';
			if ($dtrec){			
					$txt .= '<table id="datatablesSimple">';
					$txt .= '<thead>';				
						$txt .= '<tr>';	
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>ORDEN</th>';
							$txt .= '<th>Inicio - Fin</th>';
							$txt .= '<th>P Poda</th>';
							$txt .= '<th>Zona</th>';
							$txt .= '<th>Municipio</th>';
							$txt .= '<th>Circuito</th>';
							$txt .= '<th>Dirección</th>';
							$txt .= '<th>P Recolección</th>';
							$txt .= '<th>Estado</th>';
						$txt .= '</tr>';
					$txt .= '</thead>';
					$txt .= '<tfoot>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>ORDEN</th>';
							$txt .= '<th>Inicio - Fin</th>';
							$txt .= '<th>P Poda</th>';					
							$txt .= '<th>Zona</th>';
							$txt .= '<th>Municipio</th>';
							$txt .= '<th>Circuito</th>';
							$txt .= '<th>Dirección</th>';
							$txt .= '<th>P Recolección</th>';
							$txt .= '<th>Estado</th>';				
						$txt .= '</tr>';
					$txt .= '</tfoot>';
					$txt .= '<tbody>';		
					foreach ($dtrec as $dt){
						$txt .= '<tr>';	
							$txt .= '<td>';	
								$txt .= '<a data-bs-toggle="modal" href="" data-bs-target="#myModal'.$dt['idrec'].'" title="Mostrar Páginas">';
									$txt .= '<i class="fas fa-eye fa-2x"></i>';
								$txt .= '</a> ';
								$txt .= modalins($dt['idrec'],$dt['fotini'],$dt['fotfin'],$pg);
								$txt .= '<a target="blank" href="https://www.google.com/maps?ll='.$dt['lat'].','.$dt['lng'].'&z=16&t=m&hl=es-419&gl=US&mapclient=embed&q=4%C2%B051%2731.7%22N+74%C2%B003%2719.1%22W+'.$dt['lat'].'00,+'.$dt['lng'].'@'.$dt['lat'].','.$dt['lng'].'" title="Ir al mapa">';
								$txt .= '<i class="fas fa-map-marked-alt fa-2x"></i>';
								$txt .= '</a>';	
							$txt .= '<a href="vista/vpdfrec.php?pdf=1547&idrec='.$dt['idrec'].'" title="Generar PDF">';
								$txt .= '<i class="far fa-file-pdf fa-2x"></i>';
							$txt .= '</a> ';

							$txt .= '</td>';		
							$txt .= '<td>'.$dt['norden'].'</td>';	
							if($dt['estado']==1){
								$txt .= '<td style="background-color:#eac88e;">';
							}elseif ($dt['estado'==2]) {
								$txt .= '<td style="background-color:#1cc88a;">';
							}
								$txt .= $dt['fecini'].' & '.$dt['fecfin'];
							$txt .= '</td>';
							$txt .= '<td>'.$dt['nomusu'].' '.$dt['apeusu'].'</td>';
							$txt .= '<td>'.$dt['zon'].'</td>';
							$txt .= '<td>'.$dt['mun'].'</td>';
							$txt .= '<td>'.$dt['nomcir'].'</td>';
							$txt .= '<td>'.$dt['dir'].'</td>';
							$txt .= '<td>'.$dt['uprec'].' '.$dt['aprec'].'</td>';
							$txt .= '<td>';
							if($dt['estado']==1)
								$txt .= 'Sin recolectar';
							else
								$txt .= 'Recolectado';
							$txt .= '</td>';
						$txt .= '</tr>';
					}	
				$txt .= '</tbody>';
			$txt .= '</table>';
		$txt .= '</div>';
	$txt .= '</div>';
	}else{
		echo "<h2>No existen recolecciones<h2>";
	}   
	$txt .= subir();
 
	echo $txt;

}
function modalins($idrec,$fotini,$fotfin,$pg){
	$mrev = new mrec();
	$txt = '';
	$txt .= '<div class="modal fade bd-example-modal-lg" id="myModal'.$idrec.'" tabindex="-1" role="dialog">';
		$txt .= '<div class="modal-dialog modal-lg">';
			$txt .= '<div class="modal-content">';
				$txt .= '<div class="modal-header">';
					$txt .= '<h5 class="m-0 font-weight-bold text-info">Nro de Recolección: '.$idrec.'</h5>';
					$txt .= '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>';
						$txt .= '</div>';
					$txt .= '<div class="modal-body">';
						$txt .= '<h6 class="m-0 font-weight-bold text-warning">Foto Inicio:</h6>';
						$txt .= '<div class="text-center">';
						  $txt .= '<img src="'.$fotini.'" class="img-fluid">';
						$txt .= '</div>';
						if ($fotfin){
							$txt .= '<h6 class="m-0 font-weight-bold text-warning">Foto final:</h6>';
							$txt .= '<div class="text-center">';
							  $txt .= '<img src="'.$fotfin.'" class="img-fluid">';
							$txt .= '</div>';
						}else{
							$txt .= '<h6 class="m-0 font-weight-bold text-danger">Aun no se ha realizado la recoleccion de residuos</h6>';
						}
				$txt .= '</div>';
				$txt .= '<div class="modal-footer">';
					$txt .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
				$txt .= '</div>';
			$txt .= '</div>';
		$txt .= '</div>';
	$txt .= '</div>';
	echo $txt;
}
?>