<?php
require_once 'modelo/conexion.php';
require_once 'modelo/musu.php';
require_once 'modelo/mpagina.php';
$pg=1008;
$arc="home.php";
$musu = new musu();
#SELECT `idusu`, `nomusu`, `apeusu`, `docid`, `pefid`, `telusu`, `codubi`, `lictran`, `vlictran`, `emausu`, `pasusu`, `actusu`, `fecsolusu`, `clausu` FROM `usuario` WHERE 1
$idusu = isset($_POST["idusu"]) ? $_POST["idusu"]:NULL;
if(!$idusu)
	$idusu = isset($_GET["idusu"]) ? $_GET["idusu"]:NULL;
$nomusu = isset($_POST["nomusu"]) ? $_POST["nomusu"]:NULL;
$apeusu = isset($_POST["apeusu"]) ? $_POST["apeusu"]:NULL;
$docid = isset($_POST["docid"]) ? $_POST["docid"]:NULL;
$pefid = isset($_POST["pefid"]) ? $_POST["pefid"]:NULL;
$telusu = isset($_POST["telusu"]) ? $_POST["telusu"]:NULL;
$codubi = isset($_POST["codubi"]) ? $_POST["codubi"]:NULL;
$lictran = isset($_POST["lictran"]) ? $_POST["lictran"]:NULL;
$vlictran = isset($_POST["vlictran"]) ? $_POST["vlictran"]:NULL;
$emausu = isset($_POST["emausu"]) ? $_POST["emausu"]:NULL;
$pasusu = isset($_POST["pasusu"]) ? $_POST["pasusu"]:NULL;
$actusu = isset($_POST["actusu"]) ? $_POST["actusu"]:NULL;
if(!$actusu)
	$actusu = isset($_GET["actusu"]) ? $_GET["actusu"]:1;
$opera = isset($_POST["opera"]) ? $_POST["opera"]:NULL;
if(!$opera)
	$opera = isset($_GET["opera"]) ? $_GET["opera"]:NULL;
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"]:NULL;
if(!$filtro)
	$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;

#echo "<br><br><br><br>".$opera."-".$idusu."-".$nomusu."-".$apeusu."-".$docid."-".$pefid."-".$telusu."-".$codubi."-".$lictran."-".$vlictran."-".$emausu."-".$pasusu."-".$actusu."-END";
//Insertar
if($opera=="new"){
	if($nomusu and $pefid and $emausu){
		$musu->insusu($idusu,$nomusu,$apeusu,$docid,$pefid,$telusu,$codubi,$lictran,$vlictran,$emausu,$pasusu,$actusu);
		echo "<script>alert('Datos creados o actualizados correctamente');</script>";
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
	$idusu = '';
}
#Funcion bloquear usuario 
if($opera=="bloq"){
	if($idusu && $actusu)
		$musu->bloq($idusu,$actusu);
	$idusu = NULL;
	echo '<script>window.location="home.php?pg='.$pg.'";</script>';

}
//Eliminar
if($opera=="ElMn"){
	if($idusu){
		$musu->eliusu($idusu);
		echo "<script>alert('Registro eliminado existosamente');</script>";
	}
	$idusu = NULL;
	echo '<script>window.location="home.php?pg='.$pg.'";</script>';
}
function insdatos($idusu,$pg,$arc){
	$musu = new musu();
	$dtdto = $musu->seldep();
	$dtpef = $musu->selpef();

	$dtusu = NULL;
	$perfil = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
	if($idusu){
		$dtusu = $musu->selusu1($idusu);
	}
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';		$txt .= '<div class="card-header py-3">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion Usuarios</h6>';
		$txt .= '</div>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
		if($idusu){
			$txt .= '<label>Id</label>';
			$txt .= '<input type="text" name="idusu" readonly value="'.$idusu.'" class="form-control" required>';
		}
		$txt .= '<label>Nombres</label>';
		$txt .= '<input type="text" name="nomusu" class="form-control" maxlength="50" onkeypress="return "';
			if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['nomusu'].'"';
		$txt .= ' required>';
		$txt .= '<label>Apellidos</label>';
		$txt .= '<input type="text" name="apeusu" class="form-control" maxlength="50" onkeypress="return "';
			if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['apeusu'].'"';
		$txt .= ' required>';
	
		$txt .= '<label>Documento de identificación</label>';
		$txt .= '<input type="text" name="docid" class="form-control" maxlength="50" onkeypress="return "';
			if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['docid'].'"';
		$txt .= ' required>';
//Perfil
		if($perfil==4 OR $perfil==1){
			$txt .= '<label>Perfil</label>';
			$txt .= '<select name="pefid" class="form-control" required>';
			if($dtpef){
				foreach ($dtpef as $f) {
					$txt .= '<option value="'.$f['pefid'].'"';
						if ($idusu && $dtusu && $f['pefid']==$dtusu[0]['pefid']) $txt .= " selected ";
					$txt .= '>'.$f['pefnom'].'</option>';
				}
			}
			$txt .= '</select>';
		}
		$txt .= '<label>Teléfono</label>';
		$txt .= '<input type="number" min="1111111111" max="9999999999" name="telusu" onkeypress="return solonum(event);" class="form-control"';
			if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['telusu'].'"';
		$txt .= '>';
		$txt .= '<label>Departamento</label>';
		$txt .= '<select name="depto" class="form-control" required onChange="javascript:recCiudad(this.value);">';
			$txt .= '<option value=0>Seleccione Departamento</option>';
		if($dtdto){
			foreach ($dtdto as $f) {
				$txt .= '<option value="'.$f['codubi'].'">'.$f['nomubi'].'</option>';
			}
		}
		$txt .= '</select>';
		$txt .= '<div id="reloadMun">';
		$txt .= '<label>Municipio</label>';
			$txt .= '<select name="codubi" class="form-control" required>';
				$txt .= '<option value=0>Seleccione Departamento</option>';
			if($dtusu){
				$txt .= '<option value="'.$dtusu[0]['codubi'].'" selected >'.$dtusu[0]['nomubi'].'</option>';
			}
			$txt .= '</select>';
		$txt .= '</div>';

		$txt .= '<label>Licencia de Transito Nro</label>';
		$txt .= '<input type="text" name="lictran" class="form-control" maxlength="50" onkeypress="return"';
			if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['lictran'].'"';
		$txt .= ' required>';

		$txt .= '<label>Fecha de vencimiento Licencia de Transito</label>';
		$txt .= '<input type="date" name="vlictran" class="form-control" maxlength="50" onkeypress="return"';
			if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['vlictran'].'"';
		$txt .= ' required>';

		$txt .= '<label>E-mail</label>';
		$txt .= '<input type="email" name="emausu" class="form-control"';
			if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['emausu'].'"';
		$txt .= ' required>';
			$txt .= ' <div';
			if($idusu && $dtusu) $txt .= ' style="display:none"';
			$txt .= '>';

			$txt .= '<label>Contraseña</label>';
			$txt .= '<input type="password" name="pasusu" class="form-control" ';
				if(!$idusu or !$dtusu) $txt .= 'required';
			$txt .= '>';
		$txt .= ' </div>';

		$txt .= '<input type="hidden" name="opera" value="new">';
		$txt .= '<div class="col text-center">';
			$txt .= '<input type="submit" class="btn btn-secondary" value="';
			if($idusu && $dtusu)
				$txt .= 'Actualizar';
			else
				$txt .= 'Registrar';
			$txt .= '">';
			$txt .= '</div>';
		$txt .= '</form>';
	$txt .= '</div>';
	echo $txt;
}
function mosdatos($idusu,$pg,$arc){
	$musu = new musu();
	$dtusu = $musu->selusu();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
    		$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de Usuarios</h6>';
    		$txt .= '</div>';
    	$txt .= '<div class="card-body">';
        $txt .= '<div class="table-responsive">';
	if ($dtusu){
			$txt .= '<table id="datatablesSimple">';
			$txt .= '<thead>';
				$txt .= '<tr>';
					$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
					$txt .= '<th>ID</th>';
					$txt .= '<th>Nombre</th>';
					$txt .= '<th>Documento de identidad</th>';
					$txt .= '<th>Celular / Telefono</th>';
					$txt .= '<th>Perfil</th>';
				$txt .= '</tr>';
			$txt .= '</thead>';
			$txt .= '<tfoot>';
				$txt .= '<tr>';
					$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
					$txt .= '<th>ID</th>';
					$txt .= '<th>Nombre</th>';
					$txt .= '<th>Documento de identidad</th>';
					$txt .= '<th>Celular / Telefono</th>';
					$txt .= '<th>Perfil</th>';
				$txt .= '</tr>';
			$txt .= '</tfoot>';
			$txt .= '<tbody>';
			foreach ($dtusu as $dt){
				$txt .= '<tr>';

					$txt .= '<td>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&idusu='.$dt['idusu'].'" title="Editar Usuario">';
							$txt .= '<i class="fas fa-edit fa-2x"></i>';
						$txt .= '</a>';

						$txt .= '<a data-bs-toggle="modal" href="" data-bs-target="#myModal'.$dt['idusu'].'"';
						if ($dt['actusu']==1){
							$txt .= 'title="Bloquear Usuario">';
								$txt .= '<i class="far fa-check-circle fa-2x"></i>';
						}else{
							$txt .= 'title="Desbloquear Usuario">';
								$txt .= '<i class="fas fa-ban fa-2x"></i>';
						}
						$txt .= velim ($dt['idusu'],"¿Esta seguro de elminar este Usuario?", $pg, $arc,"ElMn","idusu");	
						$txt .= '</a> ';
						$txt .= modal($dt['idusu'],$pg, $dt['actusu'],$arc,$dt['nomusu'],$dt['apeusu']);
					$txt .= '<td>'.$dt['idusu'].'</td>';
					$txt .= '</td>';
					$txt .= '<td>'.$dt['nomusu'].' '.$dt['apeusu'].'</td>';
					$txt .= '<td>'.$dt['docid'].'</td>';
					$txt .= '<td>'.$dt['telusu'].'</td>';
					$txt .= '<td>'.$dt['pfl'].'</td>';
				$txt .= '</tr>';
			}	
			$txt .= '</tbody>';
		$txt .= '</table>';
		$txt .= '</div>';
	$txt .= '</div>';

	$txt .= '</div>';
	}else{
		echo "<h2>No existen Usuarios<h2>";
	}
	subir();
	echo $txt;
}
function modal ($idusu, $pg, $actuss,$arc,$nombre,$apel){
$txt = '';
$txt .= '<div class="modal" id="myModal'.$idusu.'" tabindex="-1" role="dialog">';
	$txt .= '<div class="modal-dialog">';
		$txt .= '<div class="modal-content">';
			$txt .= '<form>';
				$txt .= '<div class="modal-body">';
					$txt .= '<div class="row justify-content-center">';
					if($actuss==1){
		    			$txt .= '<h6 class="m-0 font-weight-bold text-primary">¿Esta seguro que desea desbloquear a este usuario?</h6>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=bloq&actusu=2&idusu='.$idusu.'" class="btn btn-danger">';
							$txt .= 'SI, Bloquear';
						$txt .= '</a>';
					}else{
		    			$txt .= '<h6 class="m-0 font-weight-bold text-warning">¿Esta seguro que desea desbloquear a este usuario?</h6><br>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=bloq&actusu=1&idusu='.$idusu.'" class="btn btn-primary">';
						$txt .= 'SI, Desbloquear';
						$txt .= '</a>';
					}
        			#$txt .= '<input type="submit" class="btn btn-danger" value="Bloquear Usuario">';
					$txt .= '<button type="button" class="btn btn-primary" data-bs-dismiss="modal">NO, Cancelar</button>';
					$txt .= '</div>';
				$txt .= '</div>';
			$txt .= '</form>';
		$txt .= '</div>';
	$txt .= '</div>';
$txt .= '</div>';
	echo $txt;
}
?>

