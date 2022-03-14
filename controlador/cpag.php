<?php 
require_once 'modelo/conexion.php';
require_once 'modelo/mpag.php';
require_once 'modelo/mpagina.php';
$pg = 308;
$arc = "home.php";
$mpag = new mpag();
$pagid = isset($_POST['pagid']) ? $_POST['pagid']:NULL;
if(!$pagid)
	$pagid = isset($_GET['pagid']) ? $_GET['pagid']:NULL;
$pagnom = isset($_POST['pagnom']) ? $_POST['pagnom']:NULL;
$pagarc = isset($_POST['pagarc']) ? $_POST['pagarc']:NULL;
$pagmos = isset($_POST['pagmos']) ? $_POST['pagmos']:NULL;
if(!$pagmos)
	$pagmos = isset($_GET['pagmos']) ? $_GET['pagmos']:NULL;
$pagord = isset($_POST['pagord']) ? $_POST['pagord']:NULL;
$pagmen = isset($_POST['pagmen']) ? $_POST['pagmen']:NULL;
$icono = isset($_POST['icono']) ? $_POST['icono']:NULL;
$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
//Insertar o Actualizar
//echo "<br>".$opera."-".$pagid."-".$pagnom."-".$pagarc."-".$pagmos."-".$pagord."-".$pagmen."-".$icono."<br>";
if($opera=="InsAct"){
	if($pagnom && $pagarc && $pagmos && $pagord && $pagmen && $icono){
		$mpag->pagiu($pagid,$pagnom,$pagarc,$pagmos,$pagord,$pagmen,$icono);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}	
	$pagid = NULL;
}
if($opera=="ActuOK"){
	if($pagid && $pagmos)
		$mpag->act($pagid,$pagmos);
	$pagid = NULL;
}
//Eliminar
if($opera=="Elim"){
	if($pagid){
		$mpag->pagdel($pagid);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
	$pagid = NULL;
	echo '<script>window.location="home.php?pg='.$pg.'";</script>';

}
function insdatos($pagid,$pg,$arc){
	$mpag = new mpag();
	$idpagper = $mpag->selpper();
	if($pagid) $dtpag = $mpag->selpag1($pagid);
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';				$txt .= '<div class="card-header py-3">';
					$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Paginas</h6>';
				$txt .= '</div>';

			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
				$txt .= '<label>Código</label>';
				$txt .= '<input type="number" name="pagid" class="form-control" ';
				if($pagid && $dtpag) $txt .= ' readonly value="'.$pagid.'"';
				$txt .=	'>';
				$txt .= '<label>Nombre</label>';
				$txt .= '<input type="text" name="pagnom" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagnom'].'"';
				$txt .=	'>';

				$txt .= '<label>Archivo</label>';
				$txt .= '<input type="text" name="pagarc" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagarc'].'"';
				$txt .=	'>';
				$txt .= '<label>Mostrar</label>';
				$txt .= '<select name="pagmos" class="form-control">';
					$txt .= '<option value="1"';
						if($pagid and $dtpag[0]['pagmos']==1){ $txt .= " selected "; }
					$txt .= '>Si</option>';
					$txt .= '<option value="2"';
						if($pagid and $dtpag[0]['pagmos']<>1){ $txt .= " selected "; }
					$txt .= '>No</option>';
				$txt .= '</select>';
				$txt .= '<label>Menu</label>';
				$txt .= '<select name="pagmen" class="form-control">';
					$txt .= '<option value="Home"';
						if($pagid and $dtpag[0]['pagmen']=="Home"){ $txt .= " selected "; }
					$txt .= '>Home</option>';
					$txt .= '<option value="Index"';
						if($pagid and $dtpag[0]['pagmen']=="Index"){ $txt .= " selected "; }
					$txt .= '>Index</option>';
				$txt .= '</select>';
				$txt .= '<label>Orden</label>';
				$txt .= '<input type="number" min="0" max="500" name="pagord" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagord'].'"';
				$txt .=	'>';
				$txt .= '<label>Icono</label>';
				$txt .= '<input type="text" name="icono" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['icono'].'"';
				$txt .=	'>';

				$txt .= '<input type="hidden" name="opera" value="InsAct">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-secondary" value="';
					if($pagid AND $dtpag)
						$txt .= 'Actualizar';
					else
						$txt .= 'Registrar';
					$txt .= '">';
				$txt .= '</div>';
			$txt .= '</form>';
		$txt .= '</div>';
	echo $txt;
}
function mosdatos($pg,$arc){
	$mpag = new mpag();
	$dtpag = $mpag->selpag(); 
	$txt = '';
		$txt .= '<div class="container-fluid">';
			$txt .= '<div class="card shadow mb-4">';
	    		$txt .= '<div class="card-header py-3">';
	    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de paginas</h6>';
	    		$txt .= '</div>';
	    	$txt .= '<div class="card-body">';
	        $txt .= '<div class="table-responsive">';
		if ($dtpag){
				$txt .= '<table id="datatablesSimple">';
				$txt .= '<thead>';
					$txt .= '<tr>';
						$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
						$txt .= '<th>ID</th>';
						$txt .= '<th>NOMBRE</th>';
						$txt .= '<th>Archivo</th>';
						$txt .= '<th>Menu</th>';
						$txt .= '<th>Icono</th>';
					$txt .= '</tr>';
				$txt .= '</thead>';
				$txt .= '<tfoot>';
						$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
						$txt .= '<th>ID</th>';
						$txt .= '<th>NOMBRE</th>';
						$txt .= '<th>Archivo</th>';
						$txt .= '<th>Menu</th>';
						$txt .= '<th>Icono</th>';
					$txt .= '</tr>';
				$txt .= '</tfoot>';
				$txt .= '<tbody>';
				foreach ($dtpag as $dt){
					$txt .= '<tr>';

						$txt .= '<td>';
							$txt .= velim ($dt['pagid'],"¿Esta seguro de elminar esta pagina?", $pg, $arc,"Elim","pagid");	
							$txt.= '<a href="'.$arc.'?pg='.$pg.'&pagid='.$dt['pagid'].'">';
								$txt.= '<i class="fas fa-edit fa-2x"></i>';
							$txt.= '</a>';
							if($dt['pagmos']==1){
								$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=ActuOK&pagmos=2&pagid='.$dt['pagid'].'">';
									$txt .= '<i class="fas fa-check-circle  ico2"></i>';
								$txt .= '</a>';
							}else{
								$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=ActuOK&pagmos=1&pagid='.$dt['pagid'].'">';
									$txt .= '<i class="fas fa-times-circle ico1"></i>';
								$txt .= '</a>';
							}
						$txt .= '</td>';
						$txt .= '<td>'.$dt['pagid'].'</td>';
						$txt .= '<td>'.$dt['pagnom'].'</td>';
						$txt .= '<td>'.$dt['pagarc'].'</td>';
						$txt .= '<td>'.$dt['pagmen'].'</td>';
						$txt .= '<td>'.$dt['icono'].'</td>';
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