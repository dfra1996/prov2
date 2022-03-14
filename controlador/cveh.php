<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mveh.php';
require_once 'modelo/musu.php';
require_once 'modelo/mpagina.php';
$pg = 1002;
$arc = "home.php";
$mveh = new mveh();
$idveh = isset($_POST['idveh']) ? $_POST['idveh']:NULL;
if(!$idveh){
	$idveh = isset($_GET['idveh']) ? $_GET['idveh']:NULL;
}
$tipoveh = isset($_POST['tipoveh']) ? $_POST['tipoveh']:NULL;
$placaveh = isset($_POST['placaveh']) ? $_POST['placaveh']:NULL;
$ciuexp = isset($_POST['codubi']) ? $_POST['codubi']:NULL;
$modelo = isset($_POST['modelo']) ? $_POST['modelo']:"N/A";
$marca = isset($_POST['marca']) ? $_POST['marca']:"N/A";
$docveh = isset($_POST['docveh']) ? $_POST['docveh']:"N/A";
$fecmat = isset($_POST['fecmat']) ? $_POST['fecmat']:"N/A";
$color = isset($_POST['color']) ? $_POST['color']:NULL;
$tiposer = isset($_POST['tiposer']) ? $_POST['tiposer']:NULL;
$certdi = isset($_POST['certdi']) ? $_POST['certdi']:"N/A";
$certizaje = isset($_POST['certizaje']) ? $_POST['certizaje']:"N/A";
$codop = isset($_POST['codop']) ? $_POST['codop']:"N/A";
$vencodop = isset($_POST['vencodop']) ? $_POST['vencodop']:"N/A";
$empsoat = isset($_POST['empsoat']) ? $_POST['empsoat']:NULL;
$soat = isset($_POST['soat']) ? $_POST['soat']:"N/A";
$rtmcod = isset($_POST['rtmcod']) ? $_POST['rtmcod']:"N/A";
$rtmexp = isset($_POST['rtmexp']) ? $_POST['rtmexp']:"N/A";
$segcont = isset($_POST['segcont']) ? $_POST['segcont']:"N/A";
$vensc = isset($_POST['vensc']) ? $_POST['vensc']:"N/A";
$segecont = isset($_POST['segecont']) ? $_POST['segecont']:"N/A";
$vensecont = isset($_POST['vensecont']) ? $_POST['vensecont']:"N/A";
$emptr = isset($_POST['emptr']) ? $_POST['emptr']:NULL;
$venstr = isset($_POST['venstr']) ? $_POST['venstr']:"N/A";
$extracto = isset($_POST['extracto']) ? $_POST['extracto']:"N/A";
$revpre = isset($_POST['revpre']) ? $_POST['revpre']:"N/A";
$restriccion = isset($_POST['restriccion']) ? $_POST['restriccion']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera){
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
}
/*
echo "<br><br><br>".$idveh."-".$tipoveh."-".$placaveh."-".$ciuexp."<br><br>";
echo "<br><br><br>".$modelo."-".$marca."-".$docveh."-".$fecmat."<br><br>";
echo "<br><br><br>".$color."-".$tiposer."-".$certdi."-".$certizaje."<br><br>";
echo "<br><br><br>".$codop."-".$vencodop."-".$empsoat."-".$soat."<br><br>";
echo "<br><br><br>".$rtmcod."-".$rtmexp."-".$segcont."-".$vensc."<br><br>";
echo "<br><br><br>".$segecont."-".$vensecont."-".$emptr."-".$venstr."<br><br>";
echo "<br><br><br>".$extracto."-".$revpre."-".$restriccion."-".$opera."<br><br>";
*/
if($opera=="new"){
	if($tipoveh && $placaveh && $ciuexp){
		$mveh->insveh($idveh, $tipoveh, $placaveh, $ciuexp,$modelo, $marca, $docveh, $fecmat, $color, $tiposer, $certdi, $certizaje, $codop, $vencodop, $empsoat, $soat, $rtmcod, $rtmexp, $segcont, $vensc, $segecont, $vensecont, $emptr, $venstr, $extracto, $revpre, $restriccion);
     	echo "<script>alert('Datos insertados y/o Actualizados exitosamente');</script>";
     	$idveh = NULL;
	}else{
     	echo "<script>alert('Datos incompletos verifique algunos campos');</script>";

	}	
}
//Mostrar datos de vehiculos  
function insdatos($idveh,$pg, $arc){
	$mveh = new mveh();
	$musu = new musu();
	$dtdto = $musu->seldep();
	$dttveh = $mveh->seltveh();
	$dtmar = $mveh->selmarv();
	$dttser = $mveh->seltser();
	$dteso = $mveh->seleso();
	$dttra = $mveh->seltra();
	$dveh= NULL;
	if($idveh) $dveh = $mveh->selveh1($idveh);
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';	$txt .= '<div class="card-header py-3">';
		$txt .= '<h6 class="m-0 font-weight-bold text-primary">Gestion vehiculos</h6>';
	$txt .= '</div>';
	$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
		if($idveh){
			$txt .= '<label>Id</label>';
			$txt .= '<input type="text" name="idveh" readonly value="'.$idveh.'" class="form-control">';
		}		
		$txt .= '<label class="m-0 font-weight-bold text-primary">Tipo de vehiculo</label>';
		if ($dttveh){
			$txt .= '<select name ="tipoveh" class="form-control" required>';
			$txt .= '<option value="">Seleccione el tipo de vehiculo</option>';

			foreach ($dttveh as $dt) {
				$txt .= '<option value="'.$dt['codval'].'"';
					if ($dttveh AND $dveh AND $dt['codval']==$dveh[0]['tipoveh']) $txt .= " selected ";
				$txt .= '>'; 
					$txt .= $dt['nomval'];
				$txt .= '</option>';
			}
			$txt .= '</select>';
		}
		$txt .= '<label class="m-0 font-weight-bold text-primary">Placa</label>';
		$txt .= '<input type="text" name="placaveh" class="form-control" required maxlength="7"';
		if($idveh AND $dveh) $txt .= 'value="'.$dveh[0]['placaveh'].'"';
		$txt .= '>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Departamento de expedicion</label>';
		$txt .= '<select name="depto" class="form-control" required onChange="javascript:recCiudad(this.value);">';
			$txt .= '<option value=0>Seleccione Departamento</option>';
		if($dtdto){
			foreach ($dtdto as $f) {
				$txt .= '<option value="'.$f['codubi'].'">'.$f['nomubi'].'</option>';
			}
		}
		$txt .= '</select>';
		$txt .= '<div id="reloadMun">';
			$txt .= '<label class="m-0 font-weight-bold text-primary">Municipio</label>';
			$txt .= '<select name="codubi" class="form-control" required>';
				$txt .= '<option value=0>Seleccione Departamento</option>';
			if($dveh){
				$txt .= '<option value="'.$dveh[0]['ciuexp'].'" selected >'.$dveh[0]['ciu'].'</option>';
			}
			$txt .= '</select>';
		$txt .= '</div>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Modelo del vehiculo</label>';
		$txt .= '<input type="year" name="modelo" class="form-control" required maxlength="4"';
		if($idveh AND $dveh) $txt .= 'value="'.$dveh[0]['modelo'].'"';
		$txt .= '>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Marca del vehiculo</label>';
		if ($dtmar){
			$txt .= '<select name ="marca" class="form-control">';
			foreach ($dtmar as $dt) {
				$txt .= '<option value="'.$dt['codval'].'"';
				if ($dttveh AND $dveh AND $dt['codval']==$dveh[0]['marca']) $txt .= " selected";
				$txt .= '>'; 
					$txt .= $dt['nomval']; 
				$txt .= '</option>';
			}
			$txt .= '</select>';
		}
		$txt .= '<label class="m-0 font-weight-bold text-primary">Licencia de transito</label>';
		$txt .= '<input type="text" name="docveh" class="form-control" maxlength="15"';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['docveh'].'"';
		$txt .= '>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Fecha de matricula</label>';
		$txt .= '<input type="date" name="fecmat" class="form-control" ';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['fecmat'].'"';
		$txt .= '>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Color</label>';
		$txt .= '<input type="text" name="color" class="form-control" required maxlength="25"';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['color'].'"';
		$txt .= '>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Tipo de servicio</label>';
		if ($dttser){
			$txt .= '<select name ="tiposer" class="form-control">';
			foreach ($dttser as $dt) {
				$txt .= '<option value="'.$dt['codval'].'"';
					if ($dttser AND $dveh[0]['tiposer']==$dt['codval']) $txt .= " selected ";
				$txt .= '>'; 
					$txt .= $dt['nomval'];
				$txt .= '</option>';
			}
			$txt .= '</select>';
		}
		$txt .= '<label class="m-0 font-weight-bold text-primary">Certificacion Dielectrica</label>';
		$txt .= '<input type="date" name="certdi" id="dacert" class="form-control"';
		if($idveh AND $dveh) $txt .= 'value="'.$dveh[0]['certdi'].'"';
		$txt .= '>';

		$txt .= '<label class="m-0 font-weight-bold text-primary">Certificacion Izaje</label>';
		$txt .= '<input type="date" name="certizaje" id="daizaje" class="form-control"';
		
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['certizaje'].'"';
		$txt .= '>';

		#$txt .= '<label class="m-0 font-weight-bold text-primary">Tarjeta de operaciones: </label>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Tarjeta de operaciones Codigo</label>';
		$txt .= '<input type="text" name="codop" id="cop" class="form-control" maxlength="12"';

		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['codop'].'"';
		$txt .= '>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Tarjeta de operaciones Fecha de vencimiento</label>';
		$txt .= '<input type="date" name="vencodop" id="icodop" class="form-control"';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['vencodop'].'"';
		$txt .= '>';

		#$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Obligatorio SOAT</label>';

		$txt .= '<label class="m-0 font-weight-bold text-primary">Empresa Aseguradora SOAT</label>';
		if ($dteso){
			$txt .= '<select name ="empsoat" class="form-control">';
			foreach ($dteso as $dt) {
				$txt .= '<option value="'.$dt['codval'].'"';
				if ($dttveh AND $dveh AND $dt['codval']==$dveh[0]['empsoat']) $txt .= " selected";
				$txt .= '>'; 
					$txt .= $dt['nomval']; 
				$txt .= '</option>';
			}
			$txt .= '</select>';
		}

		$txt .= '<label class="m-0 font-weight-bold text-primary">Fecha de vencimiento SOAT</label>';
		$txt .= '<input type="date" name="soat" id="isoat" class="form-control"';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['soat'].'"';
		$txt .= '>';

		
		#$txt .= '<label class="m-0 font-weight-bold text-primary">Revision TECNO-MECANICA</label>';
		
		$txt .= '<label class="m-0 font-weight-bold text-primary">Codigo RTM</label>';
		$txt .= '<input type="text" name="rtmcod" id="irtm" class="form-control" maxlength="15"';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['rtmcod'].'"';
		$txt .= '>';

		$txt .= '<label class="m-0 font-weight-bold text-primary">Fecha de vencimiento RTM</label>';
		$txt .= '<input type="date" name="rtmexp" id="irtmexp" class="form-control" ';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['rtmexp'].'"';
		$txt .= '>';	

		#$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Contractual</label>';
		
		$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Contractual Codigo</label>';
		$txt .= '<input type="text" name="segcont" id="isegcont" class="form-control" maxlength="15"';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['segcont'].'"';
		$txt .= '>';

		$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Contractual Fecha de vencimiento</label>';
		$txt .= '<input type="date" name="vensc" id="ivensc" class="form-control"';

		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['vensc'].'"';
		$txt .= '>';
		#$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Extra-Contractual</label>';

		$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Extra-Contractual Codigo</label>';
		$txt .= '<input type="text" name="segecont" id="isegecont" class="form-control" maxlength="15"';

		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['segecont'].'"';
		$txt .= '>';

		$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Extra-Contractual Fecha de vencimiento</label>';
		$txt .= '<input type="date" name="vensecont" id="ivensecont" class="form-control"';

		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['vensecont'].'"';
		$txt .= '>';


		#$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Todo Riesgo</label>';
	

		$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Todo Riesgo Empresa Aseguradora</label>';
		if ($dteso){
			$txt .= '<select name ="emptr" class="form-control">';
			foreach ($dteso as $dt) {
				$txt .= '<option value="'.$dt['codval'].'"';
				if ($dttveh AND $dveh AND $dt['codval']==$dveh[0]['emptr']) $txt .= " selected";
				$txt .= '>'; 
					$txt .= $dt['nomval']; 
				$txt .= '</option>';
			}
			$txt .= '</select>';
		}
		$txt .= '<label class="m-0 font-weight-bold text-primary">Seguro Todo Riesgo Fecha de vencimiento</label>';
		$txt .= '<input type="date" name="venstr" id="ivenstr" class="form-control" ';
		
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['venstr'].'"';
		$txt .= '>';

		$txt .= '<label class="m-0 font-weight-bold text-primary">Extracto</label>';
		$txt .= '<input type="date" name="extracto" id="iextra" class="form-control" ';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['extracto'].'"';
		$txt .= '>';



		$txt .= '<label class="m-0 font-weight-bold text-primary">Revision preventiva</label>';
		$txt .= '<input type="date" name="revpre" id="irevpre" class="form-control" ';
		if($idveh AND $dveh) $txt .= ' value="'.$dveh[0]['revpre'].'"';
		$txt .= '>';
		$txt .= '<label class="m-0 font-weight-bold text-primary">Restriccion</label>';

		if ($dttra){
			$txt .= '<select name ="restriccion" class="form-control">';
			foreach ($dttra as $dt) {
				$txt .= '<option value="'.$dt['codval'].'"';
				if ($dttveh AND $dveh AND $dt['codval']==$dveh[0]['restriccion']) $txt .= " selected";
				$txt .= '>'; 
					$txt .= $dt['nomval']; 
				$txt .= '</option>';
			}
			$txt .= '</select>';
		}
		$txt .= '<input type="hidden" name="opera" value="new">';
			$txt .= '<div class="col text-center">';
				$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($idveh)
					$txt .= 'Actualizar';
				else
					$txt .= 'Nueva';
				$txt .= '">';
			$txt .= '</div>';
	$txt .= '</form>';
	$txt .= '</div><br>';
	echo $txt;
}
function mosdatos($pg,$arc){
	$mveh = new mveh();
	$dtveh = $mveh->selveh();
	$txt = '';
	$txt .= '<div class="container-fluid">';
		$txt .= '<div class="card shadow mb-4">';
			$txt .= '<div class="card-header py-3">';
    			$txt .= '<h6 class="m-0 font-weight-bold text-danger">Listado de vehiculos</h6>';
    		$txt .= '</div>';
    	$txt .= '<div class="card-body">';
        $txt .= '<div class="table-responsive">';
	
		$txt .= '<table id="datatablesSimple">';
			$txt.= '<thead>';
				$txt.= '<tr>';
					$txt .= '<th><i class="fas fa-cog fa-2x"></i></th>';
					$txt.= '<th>ID</th>';
					$txt.= '<th>Tipo</th>';
					$txt.= '<th>Placa</th>';
					$txt.= '<th>Ciudad expedicion</th>';
					$txt.= '<th>Modelo</th>';
					$txt.= '<th>Marca</th>';
					$txt.= '<th>Licencia Nro*</th>';
					$txt.= '<th>Fecha de matricula*</th>';
					$txt.= '<th>Color</th>';
					$txt.= '<th>Tipo servicio</th>';
					$txt.= '<th>C.Dielectrica</th>';
					$txt.= '<th>C.Izaje</th>';
					$txt.= '<th>Cod.OPE</th>';
					$txt.= '<th>ven.OPE</th>';
					$txt.= '<th>SOAT</th>';
					$txt.= '<th>SOAT.VEN</th>';
					$txt.= '<th>RTM.COD</th>';
					$txt.= '<th>RTM.VEN</th>';
					$txt.= '<th>SEGURO CON</th>';
					$txt.= '<th>VENCE SEGURO CON</th>';
					$txt.= '<th>Seguro Extracontractual COD</th>';
					$txt.= '<th>Seguro Extracontractual Vence</th>';
					$txt.= '<th>Seguro todo riesgo</th>';
					$txt.= '<th>Vence Seguro todo riesgo</th>';
					$txt.= '<th>Extracto</th>';
					$txt.= '<th>Revision preventiva</th>';
					$txt.= '<th>Restriccion</th>';
				$txt.= '</tr>';
			$txt.= '</thead>';
			$txt.= '<tbody>';
			foreach ($dtveh as $dt){
				$txt .= '<tr>';
					$txt.= '<td>';
						/*$txt .= '<button data-bs-toggle="modal" data-bs-target="#myModal'.$dt['idveh'].'" title="Datos vehiculo">';
									$txt .= '<i class="fas fa-eye fa-2x"></i>';
						$txt .= '</button>';
						$txt .= modal($pg,$dt['idveh']);*/
						$txt.= '<a href="'.$arc.'?pg='.$pg.'&idveh='.$dt['idveh'].'">';
							$txt.= '<i class="fas fa-edit fa-2x"></i>';
						$txt.= '</a>';
					$txt.= '</td>';
					$txt.= '<td>'.$dt['idveh'].'</td>';
					$txt.= '<td>'.$dt['tipo'].'</td>';
					$txt.= '<td>'.$dt['placaveh'].'</td>';
					$txt.= '<td>'.$dt['ciu'].'</td>';
					$txt.= '<td>'.$dt['modelo'].'</td>';
					$txt.= '<td>'.$dt['mar'].'</td>';
					$txt.= '<td>'.$dt['docveh'].'</td>';
					$txt.= '<td>'.$dt['fecmat'].'</td>';
					$txt.= '<td>'.$dt['color'].'</td>';
					$txt.= '<td>'.$dt['tipo'].'</td>';
					$txt.= '<td>'.$dt['certdi'].'</td>';
					$txt.= '<td>'.$dt['codop'].'</td>';
					$txt.= '<td>'.$dt['vencodop'].'</td>';
					$txt.= '<td>'.$dt['certizaje'].'</td>';
					$txt.= '<td>'.$dt['so'].'</td>';
					$txt.= '<td>'.$dt['soat'].'</td>';
					$txt.= '<td>'.$dt['rtmcod'].'</td>';
					$txt.= '<td>'.$dt['rtmexp'].'</td>';
					$txt.= '<td>'.$dt['segcont'].'</td>';
					$txt.= '<td>'.$dt['segecont'].'</td>';
					$txt.= '<td>'.$dt['vensecont'].'</td>';
					$txt.= '<td>'.$dt['vensc'].'</td>';
					$txt.= '<td>'.$dt['tor'].'</td>';
					$txt.= '<td>'.$dt['venstr'].'</td>';
					$txt.= '<td>'.$dt['extracto'].'</td>';
					$txt.= '<td>'.$dt['revpre'].'</td>';
					$txt.= '<td>'.$dt['rest'].'</td>';

				$txt .= '</tr>';
			}
			$txt.= '</tbody>';
		$txt.= '</table>';
	$txt.= '</div>';
	echo $txt;
}
/*function modal($pg, $idveh){
$txt = '';
	$txt .= '<div class="modal" id="myModal'.$idveh.'" tabindex="-1" role="dialog">';
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
}*/
?>
