<?php 
require_once 'modelo/conexion.php';
require_once 'modelo/mcir.php';
require_once 'modelo/musu.php';
$pg = 1005;
$arc = "home.php";
$mcir = new mcir();
$idcir = isset($_POST['idcir']) ? $_POST['idcir']:NULL;
if(!$idcir)
	$idcir = isset($_GET['idcir']) ? $_GET['idcir']:NULL;
$idzon = isset($_POST['idzon']) ? $_POST['idzon']:NULL;
$nomcir = isset($_POST['nomcir']) ? $_POST['nomcir']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
#echo "<br><br><br>".$idcir."-".$idzon."-".$nomcir."-".$opera."<br><br>";
if($opera=="new"){
	if($idzon && $nomcir){
		$mcir->inscir($idcir,$idzon,$nomcir);
		echo "<script>alert('Datos insertados exitosamente');</script>";
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
		$idcir= NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
if($opera=="delete"){
	if($idcir){
		$mcir->delcir($idcir);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
	$idcir = NULL;
	echo '<script>window.location="home.php?pg='.$pg.'";</script>';
}
function insdatos($idcir,$pg,$arc){
	$musu = new musu();
	$mcir = new mcir();
	$dtcir = $mcir->selcir1($idcir);
	$dtzon = $mcir->zonas();
	$dtusu = $musu->seldep();
	$dtmn = $mcir->selmn();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';
		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Circuitos</h6>';
		$txt .= '</div>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($idcir){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="text" name="idcir" readonly value="'.$idcir.'" class="form-control" />';
			}
			$txt .= '<label>Elejir Zona</label>';
			$txt .= '<select name="zona" class="form-control" onChange="javascript:reczona(this.value);"';
			if(!$idcir) $txt .= 'required';
			$txt .= '>';
				$txt .= '<option value="">Zona</option>';
			if($dtzon){
				foreach ($dtzon as $f) {
					$txt .= '<option value="'.$f['idzon'].'"';
					if($dtcir[0]['zid'] == $f['idzon']) $txt .= ' selected ';
					$txt .= '>'.$f['nomzon'].'</option>';
				}
			}
			$txt .= '</select>';
			$txt .= '<div id="reloadzona">';
				$txt .= '<label>Municipio</label>';
				$txt .= '<select name="idzon" class="form-control" required>';
					$txt .= '<option value="">Seleccione Zona</option>';
					if($dtmn){
						foreach ($dtmn as $f) {
							$txt .= '<option value="'.$f['idzon'].'"';
							if($dtcir[0]['zid'] == $f['idzon']) $txt .= ' selected ';
							$txt .= '>'.$f['nomzon'].'</option>';
						}
					}
				$txt .= '</select>';
			$txt .= '</div>';
			$txt .= '<label>Nombre del Circuito</label>';
			$txt .= '<input type="text" class="form-control" name="nomcir"';
			if($idcir AND $dtcir) $txt .= ' value="'.$dtcir[0]['nomcir'].'"';
			$txt .= '" required>';
			$txt .= '<input type="hidden" name="opera" value="new">';
				$txt .= '<div class="col text-center">';
					$txt .= '<input type="submit" class="btn-sm btn-primary" value="';
					if($idcir)
						$txt .= 'Actualizar';
					else
						$txt .= 'Nuevo';
					$txt .= '">';
				$txt .= '</div>';
		$txt .= '</form>';
	$txt .= '</div>';
	echo $txt;
}
function mosdatos($idcir,$pg, $arc){
	$mcir = new mcir();
	$dtcir = $mcir->selcir();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
			$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de circuitos</h6>';
    		$txt .= '</div>';
	    	$txt .= '<div class="card-body">';
				$txt .= '<div class="table-responsive">';
				if ($dtcir){
					$txt .= '<table id="datatablesSimple">';
					$txt .= '<thead>';
						$txt .= '<tr>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>ID</th>';
							$txt .= '<th>NOMBRE</th>';
							$txt .= '<th>CIUDAD</th>';
							$txt .= '<th>ZONA</th>';
						$txt .= '</tr>';
					$txt .= '</thead>';
					$txt .= '<tfoot>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>ID</th>';
							$txt .= '<th>NOMBRE</th>';
							$txt .= '<th>CIUDAD</th>';
							$txt .= '<th>ZONA</th>';
						$txt .= '</tr>';
					$txt .= '</tfoot>';
					$txt .= '<tbody>';
					foreach($dtcir AS $dt){
						$txt .= '<tr>';
							
							$txt .= '<td>';
								$txt .= '<a href="'.$arc.'?pg='.$pg.'&idcir='.$dt['idcir'].'" title="Editar">';
									$txt .= '<i class="fas fa-edit fa-2x"></i>';
								$txt .= '</a>';		
								$txt .= velim ($dt['idcir'],"¿Esta seguro de elminar este circuito?", $pg, $arc,"delete","idcir");	
							$txt .= '</td>';
							$txt .= '<td>'.$dt['idcir'].'</td>';
							$txt .= '<td>'.$dt['nomcir'].'</td>';
							$txt .= '<td>'.$dt['nomzon'].'</td>';
							$txt .= '<td>'.$dt['zon'].'</td>';
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
function modalelm($pg, $idcir){
$txt = '';
	$txt .= '<div class="modal" id="myModal'.$idcir.'" tabindex="-1" role="dialog">';
		$txt .= '<div class="modal-dialog">';
			$txt .= '<div class="modal-content">';
				$txt .= '<div class="modal-header">';
					$txt .= '<h3 class="modal-title">Páginas</h3>';
					$txt .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
				$txt .= '</div>';
					$txt .= '<div class="modal-body">';
						$txt .= '<h3>Lllenar</h3>';
					$txt .= '</div>';
					$txt .= '<div class="modal-footer">';
						$txt .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
	        			$txt .= '<input type="submit" class="btn btn-primary" value="Guardar">';
					$txt .= '</div>';
				$txt .= '</form>';
			$txt .= '</div>';
		$txt .= '</div>';
	$txt .= '</div>';

	echo $txt;
}
?>
