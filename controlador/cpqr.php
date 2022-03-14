<?php 
require_once 'modelo/conexion.php';
require_once 'modelo/mpqr.php';
$pg = 1015;
$arc = "home.php";
$mpqr = new mpqr();
function mosdatos(){
	$mpqr = new mpqr();
	$dtpqr = $mpqr->dtpqr();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
			$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de PQR S</h6>';
    		$txt .= '</div>';
	    	$txt .= '<div class="card-body">';
				$txt .= '<div class="table-responsive">';
				if ($dtpqr){
					$txt .= '<table id="datatablesSimple">';
					$txt .= '<thead>';
						$txt .= '<tr>';
							$txt .= '<th>PAGINA</th>';
							$txt .= '<th>PERSONA</th>';
							$txt .= '<th>MENSAJE</th>';
							$txt .= '<th>ESTADO</th>';

						$txt .= '</tr>';
					$txt .= '</thead>';
					$txt .= '<tfoot>';
							$txt .= '<th>PAGINA</th>';
							$txt .= '<th>PERSONA</th>';
							$txt .= '<th>MENSAJE</th>';
							$txt .= '<th>ESTADO</th>';

						$txt .= '</tr>';
					$txt .= '</tfoot>';
					$txt .= '<tbody>';
					foreach($dtpqr AS $dt){
						$txt .= '<tr>';						
							$txt .= '<td>'.$dt['pagnom'].'</td>';
							$txt .= '<td>'.$dt['nomm'].'</td>';
							$txt .= '<td>'.$dt['msn'].'</td>';
							$txt .= '<td>N/A</td>';
						$txt .= '</tr>';
					}
				}else{
					$txt .= '<h2 class="text-danger">No existen datos</h2>';
				}
				$txt .= '</div>';
			$txt .= '</div>';
		$txt .= '</div>';
	$txt .= '</div>';
	echo $txt;
}
?>
