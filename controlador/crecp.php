<?php 
require_once 'controlador/optimg.php';
require_once 'modelo/conexion.php';
require_once 'modelo/mrec.php';
$pg = 1012;
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
$cantr = isset($_POST['cantr']) ? $_POST['cantr']:NULL;
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
#La variable ArrayName muestra el array a convertir en una cadena.
/*$JsonObject = json_encode($arbol);
echo "The array is converted to the JSON string.";
echo "\n"; 
echo"The JSON string is $JsonObject";

var_dump($JsonObject);

echo "<br><br><br>".$lat."-".$lng."-".$archa."-".$estado."-".$opera."<br><br>";
echo "<br><br><br>".$cantr;
*/
if($opera=="new"){
	if($arbol){
		$usupo = $_SESSION["idusu"];
		$fecini = date('Y-m-d');
		$mrec->insrec($idrec,$usupo, $fecini, $idzon, $dir, $idcir, $norden, $fotini, $cantr, $JsonObject, $lat, $lng, $estado);	
		echo "<script>alert('Datos insertados exitosamente');</script>";
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
		$idrec= NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
function insdatos($idrec,$pg,$arc){
	$mrec = new mrec();
	$dtusu = $mrec->selusu();
	$dtzon = $mrec->zonas();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';	$txt .= '<div class="card-header py-3">';
		$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Recoleccion de residuos</h6>';
	$txt .= '</div>';	

	$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST" enctype="multipart/form-data">';

		$txt .= '<label>Seleccione la Zona</label>';
		$txt .= '<select name="zona" class="form-control" onChange="javascript:reczona(this.value);" required>';
			$txt .= '<option value="-1">Seleccione Zona</option>';
		if($dtzon){
			foreach ($dtzon as $dt) {
				$txt .= '<option value="'.$dt['idzon'].'">'.$dt['nomzon'].'</option>';
			}
		}
		$txt .= '</select>';
		$txt .= '<div id="reloadzona">';
			$txt .= '<label>Municipio</label>';
			$txt .= '<select name="idzon" class="form-control" required>';
				$txt .= '<option value="-1">Seleccione Municipio</option>';
			$txt .= '</select>';
		$txt .= '</div>';
		$txt .= '<div id="reloadcircuito">';
		$txt .= '<label>Seleccione el circuito</label>';
			$txt .= '<select name="idcir" class="form-control" required>';
				$txt .= '<option value="-1">Seleccione circuito</option>';
			$txt .= '</select>';
		$txt .= '</div>';  
		$txt .= '<label>ORDEN NRO: </label>';
		$txt .= '<input type ="text" name="norden" class="form-control" required maxlength="5">';
		$txt .= '<label>Dirección</label>';
		$txt .= '<input type ="text" name="dir" class="form-control" maxlength="50" required>';
		$txt .= '<label>Foto Inicial</label>';
		$txt .= '<input type="file" name="archa" class="form-control" accept="image/jpg, image/jpeg, image/png" required>';
		$txt .= '<label>Cantidad</label>';
		$txt .= '<textarea type ="text" name="cantr" class="form-control" maxlength="300" required>';
		$txt .= '</textarea>';

		$txt .= '<label>Arbol Nro: </label>';
		$txt .= '<div class="field_wrapper">';
		    $txt .= '<div>';
		        $txt .= '<input type="text" name="arbol[]" value="" class="form-control" maxlength="6" required/>';
		    $txt .= '</div>';
	        $txt .= '<a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field">Añadir arbol</a>';
		$txt .= '</div>';
		$txt .= '<a data-bs-toggle="modal" href="" onclick="getLocation()" title="Determinar Ubicacion">';
			$txt .= '<i class="fas fa-map-marked-alt fa-2x">Determinar Ubicacion</i>';
		$txt .= '</a><br>';
		$txt .= '<label>Latitud: </label>';
		$txt .= '<input type ="text" name="lat" id="lat" required class="form-control">';
		$txt .= '<label>Longitud: </label>';
		$txt .= '<input type ="text" name="lng" id="lng" required class="form-control">';
			$txt .= '<input type ="hidden" name="estado" value="1">';
			$txt .= '<input type="hidden" name="opera" value="new">';
			$txt .= '<div class="col text-center">';
				$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($idrec)
					$txt .= 'Actualizar';
				else
					$txt .= 'Nueva';
				$txt .= '">';
			$txt .= '</div>';
	$txt .= '</form>';
	$txt .= '</div>';
	$txt .= subir();
	echo $txt;
}
?>