<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mdom.php';
require_once 'modelo/mpagina.php';
$pg = 301;
$arc = "home.php";
$mdom = new mdom();

$iddom = isset($_POST['iddom']) ? $_POST['iddom']:NULL;
if(!$iddom)
	$iddom = isset($_GET['iddom']) ? $_GET['iddom']:NULL;
$nomdom = isset($_POST['nomdom']) ? $_POST['nomdom']:NULL;
$pardom = isset($_POST['pardom']) ? $_POST['pardom']:NULL;
$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br><br>".$iddom."-".$nomdom."-".$pardom."-".$filtro."-".$opera."<br><br>";
//Insertar
if($opera=="InsAct"){
	if($nomdom){
		$mdom->domiu($iddom, $nomdom, $pardom);
		echo "<script>alert('Datos insertados y/o actualizados existosamente');</script>";
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
	$iddom = NULL;
}
//Eliminar
if($opera=="Eliminar"){
	if($iddom){
		$mdom->deldom($iddom);
		echo "<script>alert('Datos eliminados existosamente');</script>";
	}
	$iddom = NULL;
}
//Insertar datos
function insdatos($iddom,$pg,$arc){
	$mdom = new mdom();
	$dtdom = NULL;
	if($iddom) $dtdom = $mdom->seldom1($iddom);
	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';
		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Dominios</h6>';
		$txt .= '</div>';

		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($iddom and $dtdom){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="text" name="iddom" readonly value="'.$iddom.'" class="form-control" />';
			}
			$txt .= '<label>Dominio</label>';
			$txt .= '<input type="text" name="nomdom" maxlength="70" class="form-control"';
				if($iddom and $dtdom) $txt .= ' value="'.$dtdom[0]['nomdom'].'"';
			$txt .= ' required />';
			$txt .= '<label>Parametro</label>';
			$txt .= '<input type="text" name="pardom" maxlength="50" class="form-control"';
				if($iddom and $dtdom) $txt .= ' value="'.$dtdom[0]['pardom'].'"';
			$txt .= ' />';
			$txt .= '<input type="hidden" name="opera" value="InsAct">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-secondary" value="';
				if($iddom and $dtdom)
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
function mosdatos($iddom,$pg,$arc){
	$mdom = new mdom();
	$dtdom = $mdom->seldom();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
			$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de dominos</h6>';
    		$txt .= '</div>';
	    	$txt .= '<div class="card-body">';
				$txt .= '<div class="table-responsive">';
				if ($dtdom){
					$txt .= '<table id="datatablesSimple">';
					$txt .= '<thead>';
						$txt .= '<tr>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>ID</th>';
							$txt .= '<th>NOMBRE</th>';
							$txt .= '<th>Parametro</th>';
						$txt .= '</tr>';
					$txt .= '</thead>';
					$txt .= '<tfoot>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>ID</th>';
							$txt .= '<th>NOMBRE</th>';
							$txt .= '<th>Parametro</th>';
						$txt .= '</tr>';
					$txt .= '</tfoot>';
					$txt .= '<tbody>';
					foreach($dtdom AS $dt){
						$txt .= '<tr>';
							
							$txt .= '<td>';
								$txt .= '<a href="'.$arc.'?pg='.$pg.'&iddom='.$dt['iddom'].'" title="Editar">';
									$txt .= '<i class="fas fa-edit fa-2x"></i>';
								$txt .= '</a>';
								/*$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Eliminar&iddom='.$dt['iddom'].'" onclick="return eliminar();">';
									$txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
								$txt .= '</a>';*/
								$txt .= velim ($dt['iddom'],"¿Esta seguro de elminar este dominio?", $pg, $arc,"Eliminar","iddom");	

							$txt .= '</td>';
							$txt .= '<td>'.$dt['iddom'].'</td>';
							$txt .= '<td>'.$dt['nomdom'].'</td>';
							$txt .= '<td>'.$dt['pardom'].'</td>';
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