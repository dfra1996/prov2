<?php 
require_once 'controlador/optimg.php';
require_once 'modelo/conexion.php';
require_once 'modelo/mrec.php';
$pg = 1013;
$arc = "home.php";
$mrec = new mrec();
$idrec = isset($_POST['idrec']) ? $_POST['idrec']:NULL;
if(!$idrec)
	$idrec = isset($_GET['idrec']) ? $_GET['idrec']:NULL;
$idusu = isset($_POST['idusu']) ? $_POST['idusu']:NULL;
$idzon = isset($_POST['idzon']) ? $_POST['idzon']:NULL;
$dir = isset($_POST['dir']) ? $_POST['dir']:NULL;
$idcir = isset($_POST['idcir']) ? $_POST['idcir']:NULL;
$norden = isset($_POST['norden']) ? $_POST['norden']:NULL;
$fotini = isset($_POST['fotini']) ? $_POST['fotini']:NULL;
$arbol = isset($_POST['arbol']) ? $_POST['arbol']:NULL;
$lat = isset($_POST['lat']) ? $_POST['lat']:NULL;
$lng = isset($_POST['lng']) ? $_POST['lng']:NULL;
## Segunda parte
$fotfin = isset($_POST['fotfin']) ? $_POST['fotfin']:NULL;
$novedad = isset($_POST['novedad']) ? $_POST['novedad']:NULL;
$fecfin = isset($_POST['fecfin']) ? $_POST['fecfin']:NULL;
$estado = isset($_POST['estado']) ? $_POST['estado']:1;
if(!$estado)
	$estado = isset($_GET['estado']) ? $_GET['estado']:1;

$archa = isset($_FILES['archa']["name"]) ? $_FILES['archa']["name"]:NULL;
if($archa && $norden){
	$fotini = opti($_FILES['archa'], $norden, "imgrec","fotini");
}
$archb = isset($_FILES['archb']["name"]) ? $_FILES['archb']["name"]:NULL;
if($archb && $idrec){
	$fotfin = opti($_FILES['archb'], $idrec, "imgrec","fotfin");
}
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br><br>".$idusu."-".$novedad."-".$archb."-".$estado."-".$opera."<br><br>";
//echo "<br><br><br>".$idzon."-".$dir."-".$idcir."-".$norden."-".$fotini."-".$arbol."-".$lat."-".$lng."-".$estado."<br><br>";

if($opera=="recolectar"){
	if($fotfin AND $novedad){
		$usure = $_SESSION["idusu"];
		$fecfin = date('Y-m-d');
		$mrec->insrec2($fotfin,$usure,$novedad,$fecfin,$estado,$idrec);
		echo "<script>alert('Datos Recolección ok');</script>";
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
		$idrec = NULL;
	}
}
function recolectar($idrec,$pg,$arc){
	$mrev = new mrec();
	$dtrec = $mrev->reco2();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';	$txt .= '<div class="card-header py-3">';
		$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Recoleccion</h6>';
	$txt .= '</div>';	
	if($dtrec){
		foreach($dtrec AS $dt){
			$txt .= '<div class="card border-bottom-warning shadow h-100 py-2" style="max-width: 100rem;">';
			 	$txt .= '<div class="card-header">';
			  		$txt .= '<h6 class="m-0 font-weight-bold text-primary">Fecha de la poda: '.$dt['fecini'].'</h6>';
					$txt .= '<div class="text-center">';
						$txt .= '<h6 class="m-0 font-weight-bold text-primary">Foto Inicial</h6>';
						$txt .= '<label><img class="img-fluid" alt="Responsive image" src="'.$dt['fotini'].'"></label>';
					$txt .= '</div>';
			  	$txt .= '</div>';
				$txt .= '<div class="card-body">';
					$txt .= '<table class="table table-hover">';
					  $txt .= '<thead>';
					    $txt .= '<tr>';
					      $txt .= '<th></th>';
					      $txt .= '<th></th>';
					    $txt .= '</tr>';
					  $txt .= '</thead>';
					  $txt .= '<tbody>';
					    $txt .= '<tr>';
					      $txt .= '<th>Zona</th>';
					      $txt .= '<td>'.$dt['zon'].'</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';
					      $txt .= '<th>Municipio</th>';
					      $txt .= '<td>'.$dt['mun'].'</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';
					      $txt .= '<th>Circuito</th>';
					      $txt .= '<td>'.$dt['nomcir'].'</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';
					      $txt .= '<th>Dirección</th>';
					      $txt .= '<td>'.$dt['dir'].'</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';


					    $txt .= '<tr>';
					      $txt .= '<th>Arboles</th>';
					      $txt .= '<td>'.$dt['arbol'].'</td>';
					    $txt .= '</tr>';
					    $txt .= '<tr>';

					    $txt .= '<th>Ubicacion</th>';
					      $txt .= '<td>';
							$txt .= '<a target="blank" href="https://www.google.com/maps?ll='.$dt['lat'].','.$dt['lng'].'&z=16&t=m&hl=es-419&gl=US&mapclient=embed&q=4%C2%B051%2731.7%22N+74%C2%B003%2719.1%22W+'.$dt['lat'].'00,+'.$dt['lng'].'@'.$dt['lat'].','.$dt['lng'].'" title="Ir al mapa">';
							$txt .= '<i class="fas fa-map-marked-alt fa-2x"></i>';
							$txt .= '</a>';
					      $txt .= '</td>';
					    $txt .= '</tr>';
					  $txt .= '</tbody>';
					$txt .= '</table>';

				$txt .= '<form name="frm2" action="'.$arc.'?pg='.$pg.'" method="POST" enctype="multipart/form-data">';
					$txt .= '<input type="hidden" name="idrec" value="'.$dt['idrec'].'">';
					$txt .= '<label>Foto Final</label>';
					$txt .= '<input type="file" name="archb" class="form-control" accept="image/jpg, image/jpeg, image/png" required>';
					$txt .= '<label>NOVEDADES</label>';
					$txt .= '<textarea type="text" name="novedad" required class="form-control"required>';
					$txt .= '</textarea>';
					$txt .= '</div>';
					$txt .= '<div class="modal-footer">';
					$txt .= '<input type="hidden" name="estado" value="2">';
					$txt .= '<input type="hidden" name="opera" value="recolectar">';
        			$txt .= '<input type="submit" class="btn btn-warning" value="Recolectar OK">';
				$txt .= '</form>';
				$txt.= '</div>';
			$txt.= '</div>';
			$txt.= 'idrec: '.$dt['idrec'];

		}
	}
	$txt.= '</div>';
	$txt.= subir();
	echo $txt;

}
?>