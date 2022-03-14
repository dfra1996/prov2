<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mubi.php';
require_once 'modelo/mpagina.php';
$pg = 309;
$arc = "home.php";
$mubi = new mubi();
$codubi = isset($_POST['codubi']) ? $_POST['codubi']:NULL;
if(!$codubi){
	$codubi = isset($_GET['codubi']) ? $_GET['codubi']:NULL;
}
$nomubi = isset($_POST['nomubi']) ? $_POST['nomubi']:NULL;
$depubi = isset($_POST['depubi']) ? $_POST['depubi']:NULL;
$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro){
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
}
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera){
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
}

//echo "<br><br>".$codubi."-".$nomubi."-".$depubi."-".$filtro."<br><br>";

//Insertar o Actualizar
if($opera=="InsAct"){
	if($codubi && $nomubi && $depubi){
		$mubi->ubiiu($codubi, $nomubi, $depubi);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		$codubi = NULL;
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
//Eliminar
if($opera=="Elim"){
	if($codubi){
		$mubi->ubidel($codubi);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
	$codubi = NULL;
	echo '<script>window.location="home.php?pg='.$pg.'";</script>';

}
//Paginacion
function insdatos($codubi,$pg,$arc){
	$mubi = new mubi();
	$datdep = $mubi->selubi2();
	if($codubi) $dtubi = $mubi->selubi1($codubi);
	$txt = '';

	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Ubicacion</h6>';
		$txt .= '</div>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			$txt .= '<label>Codigo</label>';
			$txt .= '<input type="number" name="codubi" value="'.$codubi.'" class="form-control" />';
			$txt .= '<label>Departamento o Municipio</label>';
			$txt .= '<input type="text" name="nomubi" maxlength="70" class="form-control"';
				if($codubi and $dtubi) $txt .= ' value="'.$dtubi[0]['Nom'].'"';
			$txt .= ' required />';
			$txt .= '<label>Departamento depende</label>';
			if($datdep){
				$txt .= '<select name="depubi" class="form-control">';
				foreach ($datdep as $ddp) {
					$txt .= '<option value="'.$ddp['codubi'].'" ';
					if($codubi && $dtubi && $dtubi[0]['Dep']==$ddp['codubi']) $txt .= ' selected ';
					$txt .= '>';
						$txt .= $ddp['codubi'].'   -   '.$ddp['nomubi'];
					$txt .= '</option>';
				}
				$txt .= '</select>';
			}
			$txt .= '<input type="hidden" name="opera" value="InsAct">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($codubi and $dtubi)
					$txt .= 'Actualizar';
				else
					$txt .= 'Registrar';
				$txt .= '">';
			$txt .= '</div>';
		$txt .= '</form>';
	$txt .= '</div>';
	echo $txt;
}

//Mostrar datos
function mosdatos($codubi,$pg,$arc){
	$mubi = new mubi();
	$datdep = $mubi->selubi2();
	$dtsubi = $mubi->selubi();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
			$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de ubicaciones</h6>';
    		$txt .= '</div>';
	    	$txt .= '<div class="card-body">';
				$txt .= '<div class="table-responsive">';
				if ($dtsubi){
					$txt .= '<table id="datatablesSimple">';
					$txt .= '<thead>';
						$txt .= '<tr>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>Codigo Ubicacion</th>';
							$txt .= '<th>Cidad</th>';
							$txt .= '<th>Departamento</th>';
						$txt .= '</tr>';
					$txt .= '</thead>';
					$txt .= '<tfoot>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>Codigo Ubicacion</th>';
							$txt .= '<th>Cidad</th>';
							$txt .= '<th>Departamento</th>';
						$txt .= '</tr>';
					$txt .= '</tfoot>';
					$txt .= '<tbody>';
					foreach($dtsubi AS $dt){
						$txt .= '<tr>';
							
							$txt .= '<td>';
								$txt .= '<a href="'.$arc.'?pg='.$pg.'&codubi='.$dt['codubi'].'" title="Editar">';
									$txt .= '<i class="fas fa-edit fa-2x"></i>';
								$txt .= '</a>';
								/*$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=delete&codubi='.$dt['codubi'].'" onclick="return eliminar();">';
									$txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
								$txt .= '</a>';*/
								$txt .= velim ($dt['codubi'],"¿Esta seguro de elminar esta Ubicacion?", $pg, $arc,"Elim","codubi");	

							$txt .= '</td>';
							$txt .= '<td>'.$dt['codubi'].'</td>';
							$txt .= '<td><strong>'.$dt['Nom'].'</strong></td>';
							$txt .= '<td>'.$dt['nDp'].'</td>';
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