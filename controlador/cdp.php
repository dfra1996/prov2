<?php
require_once 'modelo/conexion.php';
require_once 'modelo/musu.php';
require_once 'modelo/mpagina.php';
$pg=1014;
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

#echo "<br><br><br><br>".$opera."-".$idusu."-".$nomusu."-".$apeusu."-".$docid."-".$pefid."-".$telusu."-".$codubi."-".$lictran."-".$vlictran."-".$emausu."-".$pasusu."-".$actusu."-END";
//Insertar
if($opera=="new"){
	if($nomusu AND $apeusu AND $docid){
		$musu->insusu($idusu,$nomusu,$apeusu,$docid,$pefid,$telusu,$codubi,$lictran,$vlictran,$emausu,$pasusu,$actusu);
		echo "<script>alert('Datos creados o actualizados correctamente');</script>";
		echo '<script>window.location="home.php?pg='.$pg.'";</script>';
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
function insdatos($idusu,$pg,$arc){
	$musu = new musu();
	$dtdto = $musu->seldep();
	$dtpef = $musu->selpef();
	$idusu = isset($_SESSION["idusu"]) ? $_SESSION["idusu"]:NULL;
	$perfil = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
	if($idusu){
		$dtusu = $musu->selusu1($idusu);
	}
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<h2>Datos personales</h2>';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
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
		}else{
			$txt .= '<input type="hidden" name="pefid" readonly value="'.$perfil.'" class="form-control" required>';
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
			$txt .= '<select name="codubi" class="form-control">';
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
	$txt .= subir();
	echo $txt;
}

?>

