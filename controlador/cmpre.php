<?php 
require_once 'modelo/conexion.php';
require_once 'modelo/mprev.php';
require_once 'modelo/mpdfprev.php';
$pg = 1011;
$arc = "home.php";
$mprev = new mprev();
$idprev = isset($_POST['idprev']) ? $_POST['idprev']:NULL;
if(!$idprev)
	$idprev = isset($_GET['idprev']) ? $_GET['idprev']:NULL;
function mosdatos($idprev,$pg, $arc){
	$mprev = new mprev();	
	$dtpreo = $mprev->dtpreo();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion preoperacionales</h6>';
		$txt .= '</div>';

		$txt .= '<div class="card shadow mb-4">';
    		$txt .= '<div class="card-header py-3">';					
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado PREOPERACIONALES</h6>';
    			$txt .= '<a href="vexel.php" title="Descargar tabla Exel"><i class="fas fa-table fa-2x"></i></a>';
    		$txt .= '</div>';
    	$txt .= '<div class="card-body">';
        $txt .= '<div class="table-responsive">';
	if ($dtpreo){			
			$txt .= '<table id="datatablesSimple">';
			$txt .= '<thead>';
				$txt .= '<tr>';	
					$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
					$txt .= '<th>FECHA</th>';
					$txt .= '<th>Persona</th>';
					$txt .= '<th>Vehiculo</th>';
					$txt .= '<th>Tipo de vehiculo</th>';
					$txt .= '<th>Extintor</th>';
					$txt .= '<th>Novedad Equipo</th>';
					$txt .= '<th>Kilometraje</th>';
					$txt .= '<th>Horometro</th>';
					$txt .= '<th>¿Fugas?</th>';
					$txt .= '<th>Descripción Fuga</th>';
					$txt .= '<th>Novedades?</th>';
					$txt .= '<th>Descripción Novedades</th>';
					$txt .= '<th>Reparaciones?</th>';
					$txt .= '<th>Descripción Reparaciones</th>';										
				$txt .= '</tr>';
			$txt .= '</thead>';	
			$txt .= '<tfoot>';
					$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
					$txt .= '<th>FECHA</th>';
					$txt .= '<th>Persona</th>';
					$txt .= '<th>Vehiculo</th>';
					$txt .= '<th>Tipo de vehiculo</th>';
					$txt .= '<th>Extintor</th>';
					$txt .= '<th>Novedad Equipo</th>';	
					$txt .= '<th>Kilometraje</th>';				
					$txt .= '<th>Horometro</th>';				
					$txt .= '<th>¿Fugas?</th>';	
					$txt .= '<th>Descripción Fuga</th>';	
					$txt .= '<th>Novedades?</th>';
					$txt .= '<th>Descripción Novedades</th>';	
					$txt .= '<th>Reparaciones?</th>';
					$txt .= '<th>Descripción Reparaciones</th>';												
				$txt .= '</tr>';
			$txt .= '</tfoot>';
			$txt .= '<tbody>';		
			foreach ($dtpreo as $dt){
				if($dt['hace']==0){
					$txt .= '<tr style="background-color:cornsilk;">';
				}else{
					$txt .= '<tr>';
				}
					$txt .= '<td>';		
						$txt .= '<a href="vista/vpdfprev.php?pdf=1547&idprev='.$dt['idprev'].'" title="Generar PDF">';
							$txt .= '<i class="far fa-file-pdf fa-2x"></i>';
						$txt .= '</a> ';				
						$txt .= '<a data-bs-toggle="modal" href="" data-bs-target="#myModal'.$dt['idprev'].'" title="Imagen">';
							$txt .= '<i class="fas fa-eye fa-2x"></i>';
						$txt .= '</a> ';
						$txt .= modal($dt['idprev'],$dt['fecpre']);
					$txt .= '</td>';
					$txt .= '<td>'.$dt['fecpre'].'</td>';
					$txt .= '<td>'.$dt['nomusu'].' '.$dt['apeusu'].'</td>';
					$txt .= '<td>'.$dt['placaveh'].'</td>';
					$txt .= '<td>'.$dt['nomval'].'</td>';	
					$txt .= '<td>'.$dt['expext'].'</td>';	
					$txt .= '<td>'.$dt['desequi'].'</td>';										
					$txt .= '<td>'.$dt['kilo'].'</td>';									
					$txt .= '<td>'.$dt['horo'].'</td>';								
					$txt .= '<td>';
					if($dt['fuga']==1)
						$txt .= 'SI';
					elseif($dt['fuga']==2)
						$txt .= 'NO';
					$txt .='</td>';	
					$txt .= '<td>'.$dt['desfuga'].'</td>';		
					$txt .= '<td>';
					if($dt['nov']==1)
						$txt .= 'SI';
					elseif($dt['nov']==2)
						$txt .= 'NO';
					$txt .='</td>';	
					$txt .= '<td>'.$dt['novedad'].'</td>';
					$txt .= '<td>';
					if($dt['imp']==1)
						$txt .= 'SI';
					elseif($dt['imp']==2)
						$txt .= 'NO';
					$txt .='</td>';	
					$txt .= '<td>'.$dt['impre'].'</td>';		
															

				$txt .= '</tr>';
			}	
			$txt .= '</tbody>';
		$txt .= '</table>';
		$txt .= '</div>';
	$txt .= '</div>';
	$txt .= '</div>';
	}else{
		echo "<h2>No tiene Formatos PREOPERACIONALES<h2>";
	}
	$txt .= subir();    
	echo $txt;
}
function modal ($idprev, $fecpre){
	$mpdfprev = new mpdfprev();
	$dtprev = $mpdfprev->selpre1($idprev);
	$dtitem = $mpdfprev->itemse($idprev);
	$dtest = $mpdfprev->itemses($idprev);
	$txt = '';
	$txt .= '<div class="modal fade bd-example-modal-lg" id="myModal'.$idprev.'" tabindex="-1" role="dialog">';
		$txt .= '<div class="modal-dialog modal-lg">';
			$txt .= '<div class="modal-content">';
				$txt .= '<div class="modal-header">';
					$txt .= '<h5 class="modal-title">Preoperacional Nro : '.$idprev.'  Fecha: '.$fecpre.' </h5>';					
					$txt .= '<button type="button" class="close" data-bs-dismiss="modal">x</button>';
				$txt .= '</div>';	
				$txt .= '<div class="modal-body">';	
				if($idprev AND $dtprev AND $dtest){
					$txt .= '<table class="table table-hover">';
						$txt .= '<thead>';

					foreach ($dtprev as $dt) {
						    $txt .= '<tr>';
						      $txt .= '<th scope="col"><h6 class="m-0 font-weight-bold text-danger">Datos del conductor</h6></th>';
						      $txt .= '<th scope="col"></th>';
						    $txt .= '</tr>';
						  $txt .= '<tbody>';
						    $txt .= '<tr>';
						      $txt .= '<th scope="row">Nombre</th>';
						      $txt .= '<td>'.$dt['nomusu'].' '.$dt['apeusu'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
						      $txt .= '<th scope="row">Documento de identidad</th>';
						      $txt .= '<td>'.$dt['docid'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
						    $txt .= '<th scope="row">Licencia de conduccion</th>';
						      $txt .= '<td>'.$dt['lictran'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
						    $txt .= '<th scope="row">Vencimiento licencia de conduccion</th>';
						      $txt .= '<td>'.$dt['vlictran'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
						      $txt .= '<th scope="col"><h6 class="m-0 font-weight-bold text-danger">Datos del vehiculo</h6></th>';
						      $txt .= '<th scope="col"></th>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
							    $txt .= '<th scope="row">Placa del vehiculo</th>';
							    $txt .= '<td>'.$dt['placaveh'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
						    	$txt .= '<th scope="row">Licencia de transito</th>';
						      	$txt .= '<td>'.$dt['docveh'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
							    $txt .= '<th scope="row">Vencimiento SOAT</th>';
							    $txt .= '<td>'.$dt['soat'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
						    $txt .= '<th scope="row">RTM</th>';
						      $txt .= '<td>'.$dt['rtmcod'].'</td>';
						    $txt .= '</tr>';
						    $txt .= '<tr>';
						    	$txt .= '<th scope="row">Vencimiento RTM</th>';
						      	$txt .= '<td>'.$dt['rtmexp'].'</td>';
						    $txt .= '</tr>';
					}
				  	$txt .= '</thead>';

						if($dtitem){						
						    $txt .= '<tr>';
							    if($dtprev[0]['tipoveh']==6){
									$txt .= '<th scope="col"><h6 class="m-0 font-weight-bold text-danger">Items equipo de protección</h6></th>';
								    $txt .= '<td></td>';
								}
								else{
									$txt .= '<th scope="col"><h6 class="m-0 font-weight-bold text-danger">Items equipo de carretera</h6></th>';
							   		$txt .= '<td></td>';	
							   	}
						    $txt .= '</tr>';
								$txt .= '<tr>';	

							foreach($dtitem AS $dt){
						    		$txt .= '<th>';								   
							     		$txt .= $dt['nomitem'];
 							      		$txt .= '<br><h6 class="m-0 font-weight-bold text-warning">'.$dt['descri'].'</h6>';		      
									$txt .= '</th>';
							$txt .= '<td>';	
						      	if($dt['res']==1)
									$txt .= 'TIENE';	
								elseif($dt['res']==2)
									$txt .= 'NO TIENE';										

								$txt .= '</td>';	
								$txt .= '</tr>';
							}
					    	foreach ($dtprev as $dt) {
							    $txt .= '<tr>';
							    $txt .= '<th scope="row">Fecha de vencimiento extintor</th>';
							      $txt .= '<td>'.$dt['expext'].'</td>';
							    $txt .= '</tr>';	

							    $txt .= '<tr>';				    	
								if($dtprev[0]['tipoveh']==6)
							    	$txt .= '<th sscope="row">Novedades del equipo de protección</th>';
							    else
							    	$txt .= '<th scope="row">Novedades del equipo de carretera</th>';
							      $txt .= '<td>'.$dt['desequi'].'</td>';
							    $txt .= '</tr>';	
							 }
							}	
						    if($dtprev[0]['tipoveh']==5){	
							    $txt .= '</tr>';	
							      $txt .= '<th scope="col"><h6 class="m-0 font-weight-bold text-danger">Vehiculo con el que se desplaza</h6></th>';
							      $txt .= '<th scope="col">';
									foreach ($dtprev as $dt) 
										$txt .= $dt['chipper'];				      
							      $txt .= '</th>';
							    $txt .= '</tr>';	
							}												    
					foreach ($dtprev as $dt) {
					    $txt .= '<tr>';
					    $txt .= '<th scope="row">Kilometraje</th>';
					      $txt .= '<td>'.$dt['kilo'].'</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';
					    $txt .= '<th scope="row">Horometro</th>';
					      $txt .= '<td>'.$dt['horo'].'</td>';
					    $txt .= '</tr>';
					}
						$txt .= '<tr>';
						    $txt .= '<th scope="col"><h6 class="m-0 font-weight-bold text-danger">Lista de chequeo</h6></th>';
						    $txt .= '<th scope="col"></th>';
						$txt .= '</tr>';
						foreach($dtest AS $dt){
						    $txt .= '<tr>';
 						    $txt .= '<th>'.$dt['nomitem'];
					      		$txt .= '<br><h6 class="m-0 font-weight-bold text-warning">'.$dt['descri'].'</h6>';				      
 						    $txt .= '</th>';
						    $txt .= '<td>';
					      	if($dt['res']==3)
								$txt .= 'BUENO';	
							elseif($dt['res']==4)
								$txt .= 'MALO';
						    $txt .= '</td>';
					  	$txt .= '</tr>';							
						}
					foreach ($dtprev as $dt) {
					    $txt .= '<tr>';
					    if($dtprev[0]['tipoveh']==5 OR $dtprev[0]['tipoveh']==1)
					    	$txt .= '<th scope="row">¿La maquina presenta fugas?</th>';
					    else
					      	$txt .= '<th scope="row">¿El vehiculo presenta fugas?</th>';
					    $txt .= '<td>';
					    if($dt['fuga']==1) 
					    	$txt .= 'SI';	
					    else if($dt['fuga']==2) 
					    	$txt .= 'NO';	
					    $txt .='</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';
	   					    $txt .= '<th scope="row"><h6 class="m-0 font-weight-bold text-warning">'.$dt['desfuga'].'</h6></th>';
	   					    $txt .= '<th scope="row"></th>';

					    $txt .= '</tr>';
					    $txt .= '<tr>';
					    	$txt .= '<th scope="row">¿Novedades?</th>';
					    $txt .= '<td>';
					    if($dt['nov']==1) 
					    	$txt .= 'SI';	
					    else if($dt['nov']==2) 
					    	$txt .= 'NO';	
					    $txt .='</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';
	   					    $txt .= '<th scope="row"><h6 class="m-0 font-weight-bold text-warning">'.$dt['novedad'].'</h6></th>';
	   					    $txt .= '<th scope="row"></th>';
					    $txt .= '</tr>';

					    $txt .= '</tr>';
					    $txt .= '<tr>';
					    	$txt .= '<th scope="row">¿Imprevistos o reparaciones?</th>';
					    $txt .= '<td>';
					    if($dt['imp']==1) 
					    	$txt .= 'SI';	
					    else if($dt['imp']==2) 
					    	$txt .= 'NO';	
					    $txt .='</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';
	   					    $txt .= '<th scope="row"><h6 class="m-0 font-weight-bold text-warning">'.$dt['impre'].'</h6></th>';
	   					    $txt .= '<th scope="row"></th>';
					    $txt .= '</tr>';
					}
						  $txt .= '</tbody>';
						$txt .= '</table>';
						foreach ($dtprev as $dt) {
							if($dt['img']){
								$txt .= '<h6 class="m-0 font-weight-bold text-primary">Foto del vehiculo</h6>';
								$txt .= '<div class="text-center">';
								  $txt .= '<img src="'.$dt['img'].'" class="img-fluid">';
								$txt .= '</div>';	
							}					
						}
				}else{
					$txt .= 'No existen datos del PREOPERACIONAL';
					$txt .= '<a href="home.php?pg=1009&idprev='.$idprev.'" title="Agregar datos">';
						$txt .= '<i class="fas fa-edit fa-4x"></i>';
					$txt .= '</a>';
				}	
				$txt .= '</div>';
				$txt .= '<div class="modal-footer">';
					$txt .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
				$txt .= '</div>';				
			$txt .= '</div>';
		$txt .= '</div>';
	$txt .= '</div>';
	return $txt;	
}

?>