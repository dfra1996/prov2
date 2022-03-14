<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mzon.php';
require_once 'modelo/mpagina.php';

$pg = 1010;
$arc = "home.php";
$mzon = new mzon();

$idzon = isset($_POST['idzon']) ? $_POST['idzon']:NULL;
if(!$idzon){
	$idzon = isset($_GET['idzon']) ? $_GET['idzon']:NULL;
}
$nomzon = isset($_POST['nomzon']) ? $_POST['nomzon']:NULL;
$depzon = isset($_POST['depzon']) ? $_POST['depzon']:NULL;

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera){
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
}
//echo "<br><br>".$idzon."-".$nomzon."-".$depzon."<br><br>";
//Insertar o Actualizar
if($opera=="new"){
	if($nomzon && $depzon){
		$mzon->inszon($idzon, $nomzon, $depzon);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
    	echo '<script>window.location="home.php?pg='.$pg.'";</script>';
		$idzon = NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
//Eliminar
if($opera=="Elim"){
	if($idzon){
		$mzon->delzon($idzon);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
	$idzon = NULL;
}
function insdatos($idzon,$pg,$arc){
	$mzon = new mzon();
	$dtzon = $mzon->selzon();
	$z = $mzon->selzon1($idzon);
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';			$txt .= '<div class="card-header py-3">';
				$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Zonas</h6>';
			$txt .= '</div>';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($idzon){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="text" name="idzon" readonly value="'.$idzon.'" class="form-control" />';
			}
			$txt .= '<label>Zona</label>';
			if($dtzon){
			$txt .= '<select name="depzon" class="form-control" required>';
				$txt .= '<option value="">Seleccione la Zona</option>';
				foreach ($dtzon as $f) {
					$txt .= '<option value="'.$f['idzon'].'"';
					if($z[0]['id']==$f['idzon']) $txt .= ' selected ';
					$txt .= '>'.$f['nomzon'].'</option>';
				}
			}
			$txt .= '</select>';
			$txt .= '<label>Municipio</label>';
			$txt .= '<input type="text" class="form-control" name="nomzon"';
			if($idzon and $z) $txt .= ' value="'.$z[0]['nomzon'].'"';
			$txt .= ' required />';
			$txt .= '<input type="hidden" name="opera" value="new">';
				$txt .= '<div class="col text-center">';

					$txt .= '<input type="submit" class="btn btn-primary" value="';
					if($idzon)
						$txt .= 'Actualizar';
					else
						$txt .= 'Nueva';
					$txt .= '">';
				$txt .= '</div>';

		$txt .= '</form>';
	$txt .= '</div>';
	echo $txt;
}
//Mostrar datos
function mosdatos($idzon,$pg,$arc){
	$mzon = new mzon();
	$dtzon = $mzon->moszon();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
			$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de Municipios y Zonas</h6>';
    		$txt .= '</div>';
	    	$txt .= '<div class="card-body">';
				$txt .= '<div class="table-responsive">';

				if ($dtzon){			
					$txt .= '<table id="datatablesSimple">';
					$txt .= '<thead>';
						$txt .= '<tr>';				
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>MUNICIPIO</th>';
							$txt .= '<th>ZONA</th>';
						$txt .= '</tr>';
					$txt .= '</thead>';
					$txt .= '<tfoot>';
							$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
							$txt .= '<th>MUNICIPIO</th>';
							$txt .= '<th>ZONA</th>';
						$txt .= '</tr>';
					$txt .= '</tfoot>';
					$txt .= '<tbody>';
					foreach($dtzon AS $dt){
						$txt .= '<tr>';	
							//$txt .= '<td>'.$dt['idzon'].'</td>';						
							$txt .= '<td>';
								$txt .= '<a href="'.$arc.'?pg='.$pg.'&idzon='.$dt['idzon'].'" title="Editar">';
									$txt .= '<i class="fas fa-edit fa-2x"></i>';
								$txt .= '</a>';
								/*$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=delete&idzon='.$dt['idzon'].'" onclick="return eliminar();">';
									$txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
								$txt .= '</a>';*/

								$txt .= velim ($dt['idzon'],"¿Esta seguro de elminar esta zona?", $pg, $arc,"Elim","idzon");	


							$txt .= '</td>';					
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
?>