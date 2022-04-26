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
	$txt .= '<div class="card shadow mb-4">';
		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de paginas</h6>';
		$txt .= '</div>';
	$txt .= '<div class="card-body">';
	$txt .= '<div class="table-responsive">';
if ($dtrec){
		$txt .= '<table id="datatablesSimple">';
		$txt .= '<thead>';
			$txt .= '<tr>';
				$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
				$txt .= '<th>NOMBRE</th>';
				$txt .= '<th>Archivo</th>';
				$txt .= '<th>Menu</th>';
				$txt .= '<th>Icono</th>';
			$txt .= '</tr>';
		$txt .= '</thead>';
		$txt .= '<tfoot>';
				$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
				$txt .= '<th>NOMBRE</th>';
				$txt .= '<th>Archivo</th>';
				$txt .= '<th>Menu</th>';
				$txt .= '<th>Icono</th>';
			$txt .= '</tr>';
		$txt .= '</tfoot>';
		$txt .= '<tbody>';
		foreach ($dtrec as $dt){
			$txt .= '<tr>';
				$txt .= '<td>'.$dt['idrec'].'</td>';
				$txt .= '<td>'.$dt['arbol'].'</td>';
				$txt .= '<td>'.$dt['arbol'].'</td>';
				$txt .= '<td>'.$dt['arbol'].'</td>';
				$txt .= '<td>'.$dt['estado'].'</td>';
			$txt .= '</tr>';
		}	
		$txt .= '</tbody>';
	$txt .= '</table>';
	$txt .= '</div>';
$txt .= '</div>';
$txt .= '</div>';
}else{
$txt .= '<h4>No existen datos para mostrar</h4>';
}
$txt .= '</div>';
echo $txt;	

}
?>