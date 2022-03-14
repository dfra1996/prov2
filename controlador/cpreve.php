<?php
# Lllamar archivos requeridos
require_once 'controlador/optimg.php';
require_once 'modelo/conexion.php';
require_once 'modelo/mpreve.php';
require_once 'modelo/mpdfprev.php';
# Capturar variables ya sea por metodo GET o POST
$idveh = isset($_POST['idveh']) ? $_POST['idveh']:NULL;
if(!$idveh)
	$idveh = isset($_GET['idveh']) ? $_GET['idveh']:NULL;
$idprev = isset($_POST['idprev']) ? $_POST['idprev']:NULL;
if(!$idprev)
	$idprev = isset($_GET['idprev']) ? $_GET['idprev']:NULL;
$tipoveh = isset($_POST['tipoveh']) ? $_POST['tipoveh']:NULL;
if(!$tipoveh)
	$tipoveh = isset($_GET['tipoveh']) ? $_GET['tipoveh']:NULL;
$idres = isset($_POST['idres']) ? $_POST['idres']:NULL;
if(!$idres)
	$idres = isset($_GET['idres']) ? $_GET['idres']:NULL;
$expext = isset($_POST['expext']) ? $_POST['expext']:'N/A';
$desequi = isset($_POST['desequi']) ? $_POST['desequi']:'N/A';
$chipper = isset($_POST['chipper']) ? $_POST['chipper']:'N/A';
$kilo = isset($_POST['kilo']) ? $_POST['kilo']:'N/A';
$horo = isset($_POST['horo']) ? $_POST['horo']:'N/A';
$fuga = isset($_POST['fuga']) ? $_POST['fuga']:NULL;
$desfuga = isset($_POST['desfuga']) ? $_POST['desfuga']:'N/A';
$novedad = isset($_POST['novedad']) ? $_POST['novedad']:NULL;
$nov = isset($_POST['nov']) ? $_POST['nov']:NULL;
$imp = isset($_POST['imp']) ? $_POST['imp']:NULL;
$impre = isset($_POST['impre']) ? $_POST['impre']:'N/A';
$equiv [] = isset($_POST['equiv']) ? $_POST['equiv']:NULL;
$equif [] = isset($_POST['equif']) ? $_POST['equif']:NULL;
$descrie []= isset($_POST['descrie']) ? $_POST['descrie']:NULL;
$itemv [] = isset($_POST['itemv']) ? $_POST['itemv']:NULL;
$itemf [] = isset($_POST['itemf']) ? $_POST['itemf']:NULL;
$descri []= isset($_POST['descri']) ? $_POST['descri']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
$img = isset($_POST['img']) ? $_POST['img']:NULL;
$arch = isset($_FILES['arch']["name"]) ? $_FILES['arch']["name"]:NULL;
if($arch && $idprev){
	$img = opti($_FILES['arch'], $idprev, "imgprev","imgprev");
}
#DEFINIR NUMERO DE LA PAGINA PARA QUE PUEDA SER INGRESADA EN LA INTERFAZ PAGINA POR EL USUARIO
$pg = 1009;
#ARCHIVO HOME O INDEX
$arc = "home.php";
#INSTANCIAR LA CLASE mpreve para traer las funciones creadas en el archivo mpreve
$mpreve = new mpreve();
$mpdfprev = new mpdfprev();
#Realizar la insersion de todos los datos del preoperacional "ITEMS y estado de cada item"
$dtitem = $mpdfprev->itemse($idprev);
if($dtitem ){
	echo '<script>window.location="home.php";</script>';
}
if($opera=="new"){
	if($idprev){
		$mpreve->updprev($expext, $desequi, $chipper,$kilo, $horo, $fuga, $desfuga, $novedad, $impre, $idprev, $img, $nov, $imp);
		if($equiv){
			$res = 1;
			//For que recorre la tabla item y los inserta en la tabla respuestas cuando un item de equipo de carretera CUMPLE
			for ($i=0; $i<count($equiv[0]) ; $i++) { 
				$mpreve->inspreo($idprev, $equiv[0][$i], $res, NULL);
			}
		}
		if($equif){
			$res = 2;
			//For que recorre la tabla item y los inserta en la tabla respuestas cuando un item de equipo de carretera NO CUMPLE
			for ($i=0; $i<count($equif[0]) ; $i++) {
				$mpreve->inspreo($idprev, $equif[0][$i], $res, $descrie[0][$i]);
			}
		}		
		if ($itemv){
		$res=3;
			//For que recorre la tabla item y los inserta en la tabla respuestas cuando item Cumple
			for ($i=0; $i<count($itemv[0]) ; $i++) {
				$mpreve->inspreo($idprev, $itemv[0][$i], $res, NULL);
			}
		}
		if ($itemf){
		$res=4;
			//For que recorre la tabla item y los inserta en la tabla respuestas cuando item  NO Cumple
			for ($i=0; $i<count($itemf[0]); $i++) {
				$mpreve->inspreo($idprev, $itemf[0][$i], $res, $descri[0][$i]);
			}
		}
		echo "<script>alert('Datos insertados exitosamente');</script>";
		echo '<script>window.location="home.php?pg=1007";</script>';
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
function insdatos($idprev,$idveh,$tipoveh,$pg,$arc){
	$mpreve = new mpreve();
	$tipo = $mpreve->tipo($idveh);
	$dtitem = $mpreve->selequ();
	$dep = NULL;
	$txt = '';
	if($idprev AND $idveh){
		$txt .= '<div class="container-fluid">';
		$txt .= '<div class="d-flex justify-content-center">';
		 	$txt .= vayuda("Nuevo Preoperacional", "Esperando mensaje...");
		 	$txt .= vpqr($pg);	
		$txt .= '</div>';
		$txt .= '<h2 class="m-0 font-weight-bold text-secodary">LISTA DE CHEQUEO VEHICULO: '.$tipo[0]['nomval'].'</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST" enctype="multipart/form-data">';	
		$txt .= '<input type="hidden" name="idprev" readonly value="'.$idprev.'" class="form-control"/>';
		$txt .= '<input type="hidden" name="idveh" readonly value="'.$idveh.'" class="form-control"/>';
		if($tipo[0]['codval']==6){
			$dtpro = $mpreve->selpro();
			$txt .= '<table class="table table-hover">';
				$txt .= '<thead>';
				$txt .= '<tr>';
			  			$txt .= '<th></th>';
			  			$txt .= '<th>TIENE</th>';
			  			$txt .= '<th></th>';
			  		$txt .= '</tr>';
			  		$txt .= '<tr>';
			  			$txt .= '<th>Item</th>';
			  			$txt .= '<th>SI</th>';
			  			$txt .= '<th>NO</th>';
			  		$txt .= '</tr>';
		  		$txt .= '</thead>';
		  		$txt .= '<tbody>';
				foreach ($dtpro as $dt) {
			  		$txt .= '<tr>';
			  			$txt .= '<td>'.$dt['nomitem'].'</td>';
			  			$txt .= '<td><input type="checkbox" class="form-check-input pre" name="equiv[]" value="'.$dt['iditem'].'" id="a'.$dt['iditem'].'" onclick="cambio(1,a'.$dt['iditem'].',b'.$dt['iditem'].'); chec2(a'.$dt['iditem'].',i'.$dt['iditem'].');" required ></td>';
			  			$txt .= '<td><input type="checkbox" class="form-check-input pre" name="equif[]" value="'.$dt['iditem'].'" id="b'.$dt['iditem'].'" onclick="cambio(2,a'.$dt['iditem'].',b'.$dt['iditem'].'); chec1(b'.$dt['iditem'].',i'.$dt['iditem'].');" required></td>';	
			  		$txt .= '</tr>';
			  		$txt .= '<tr>';
			  			$txt .= '<td><input type="text" class="form-control name="descrie[]" id="i'.$dt['iditem'].'" style="display:none" placeholder="Descripción" maxlength="100"></td>';
			  			$txt .= '<td></td>';
			  			$txt .= '<td></td>';
			  		$txt .= '</tr>';
					$txt .= '</div>';
				}
				$txt .= '<tbody>';
		  	$txt .= '</table>';
			$txt .= '<label>Novedades del equipo protección</label>';
			$txt .= '<input type ="text" name="desequi" class="form-control" maxlength="150">';
		}else if($tipo[0]['codval']==1 OR $tipo[0]['codval']==2 OR $tipo[0]['codval']==3 OR $tipo[0]['codval']==4){
			$txt .= '<table class="table table-hover">';
		  		$txt .= '<thead>';
			  		$txt .= '<tr>';
			  			$txt .= '<th></th>';
			  			$txt .= '<th>TIENE</th>';
			  			$txt .= '<th></th>';
			  		$txt .= '</tr>';
			  		$txt .= '<tr>';
			  			$txt .= '<th>Item</th>';
			  			$txt .= '<th>SI</th>';
			  			$txt .= '<th>NO</th>';
			  		$txt .= '</tr>';
		  		$txt .= '</thead>';
		  		$txt .= '<tbody>';
				foreach ($dtitem as $dt) {
			  		$txt .= '<tr>';
			  			$txt .= '<td>'.$dt['nomitem'].'</td>';
			  			$txt .= '<td><input type="checkbox" class="form-check-input pre" name="equiv[]" value="'.$dt['iditem'].'" id="a'.$dt['iditem'].'" onclick="cambio(1,a'.$dt['iditem'].',b'.$dt['iditem'].'); chec2(a'.$dt['iditem'].',i'.$dt['iditem'].');" required></td>';
			  			$txt .= '<td><input type="checkbox" class="form-check-input pre" name="equif[]" value="'.$dt['iditem'].'" id="b'.$dt['iditem'].'" onclick="cambio(2,a'.$dt['iditem'].',b'.$dt['iditem'].'); chec1(b'.$dt['iditem'].',i'.$dt['iditem'].');" required></td>';	
			  		$txt .= '</tr>';
			  		$txt .= '<tr>';
			  			$txt .= '<td><input type="text" class="form-control name="descrie[]" id="i'.$dt['iditem'].'" style="display:none" placeholder="Descripción" maxlength="100"></td>';
			  			$txt .= '<td></td>';
			  			$txt .= '<td></td>';
			  		$txt .= '</tr>';
				$txt .= '</div>';
				}
				$txt .= '<tbody>';
		  	$txt .= '</table>';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Fecha de vencimiento del extintor</h6>';
			$txt .= '<input type ="month" name="expext" required class="form-control">';
			$txt .= '<label>Novedades del equipo de carretera</label>';
			$txt .= '<input type ="text" name="desequi" class="form-control" maxlength="150">';
		}
		if($tipo[0]['codval']==5){
			$dtpro = $mpreve->selpro();
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">Vehiculo con el que se desplaza</h6>';
			$txt .= '<input type="text" class="form-control" name="chipper" required maxlength="20">';
		}
		$txt .= '<h6 class="m-0 font-weight-bold text-danger">ESTADO GENERAL VEHICULO</h6>';
		if ($tipo[0]['codval'] <> 5){
			$txt .= '<label>Kilometraje Actual</label>';
			$txt .= '<input type ="number" name="kilo" required class="form-control" maxlength="10">';
		}
		if($tipo[0]['codval']==1 OR $tipo[0]['codval']==5){
			$txt .= '<label>Horas de trabajo</label>';
			$txt .= '<input type ="number" name="horo" required class="form-control" maxlength="10">';
		}	
	#Tabla
	//              -----------------   ITEMS ESTADO GENERAL && Revision electrica y luces -----------------------------------
		#Estado general CANASTA
	$txt .= '<div class="card-group">';
		$txt .= checki($idveh, 1, 4, "Estado GeneraL Canasta");
		#Estado general camion recoleccion
		$txt .= checki($idveh, 2, 116, "Estado General Camion-recoleccion");
		#ESTADO GENERAL SUPERVISOR CAMPERO
		$txt .= checki($idveh, 3, 148, "Estado General Supervisor-Campero");
		#ESTADO GENERAL CAMIONETA CUADRILLA
		$txt .= checki($idveh, 4, 175, "Estado General Camioneta-Cuadrilla"); 
		#ESTADO GENERAL CHIPPER
		$txt .= checki($idveh, 5, 205, "Estado General Chipper"); 
		#ESTADO GENERAL MOTOCICLETA
		$txt .= checki($idveh, 6, 235, "Estado General Motocicleta");     
		#Revision electrica y luces CANASTA
		$txt .= checki($idveh, 1, 89, "Revision electrica y luces canasta");  
		#Revision electrica y luces CAMION RECOLECCION
		$txt .= checki($idveh, 2, 126, "Revision electrica y luces Camion-recoleccion");  
		#Revision electrica y luces SUPERVISOR CAMPERO
		$txt .= checki($idveh, 3, 158, "Revision electrica y luces Supervisor-Campero");
		#Revision electrica y luces CUADRILLA
		$txt .= checki($idveh, 4, 185, "Revision electrica y luces Camioneta-Cuadrilla"); 
		#Revision electrica y luces CHIPPER
		$txt .= checki($idveh, 5, 221, "Revision electrica y luces Chipper"); 
		#Revision electrica y luces MOTOCICLETA	
		$txt .= checki($idveh, 6, 250, "Revision electrica y luces Motocicleta"); 
	$txt .= '</div>';
	#------------------------------------------NIVELES LIQUIDO && FUGAS#------------------------------------------
	$txt .= '<div class="card-group">';
		#NIVELES DE LIQUIDOS	CANASTA
		$txt .= checki($idveh, 1, 97, "Niveles de liquido canasta"); 
		#NIVELES DE LIQUIDOS	CAMION RECOLECCION
		$txt .= checki($idveh, 2, 134, "Niveles de liquido Camion-recoleccion"); 
		#NIVELES DE LIQUIDOS	SUPERVISOR CAMPERO
		$txt .= checki($idveh, 3, 165, "Niveles de liquido Supervisor campero");
		#NIVELES DE LIQUIDOS 	CUADRILLA
		$txt .= checki($idveh, 4, 192, "Niveles de liquido Camioneta-cuadrilla");
		#NIVELES DE LIQUIDOS 	CHIPPER
		$txt .= checki($idveh, 5, 228, "Niveles de liquido Chipper");
		#NIVELES DE LIQUIDOS 	MOTOCICLETA
		$txt .= checki($idveh, 6, 257, "Niveles de liquido Motocicleta");
		$txt .= '<div class="card">';    
	    	$txt .= '<div class="card-body">';
			$txt .= '<h6 class="m-0 font-weight-bold text-primary">FUGAS</h6>';
			$txt .= '<label><strong>El vehiculo presenta fugas</strong></label>';
			$txt .= '<div class="form-check form-check-inline">';
				$txt .= '<input type="radio" class="form-check-input pre" name="fuga" required id="ch1" onChange="cradio(ch1,boton);" value="1">';
				$txt .= '<label for="ch1">SI</label><br>';
				$txt .= '<input type="radio" class="form-check-input pre" name="fuga" id="ch2" onChange="ctexa(ch2,boton);" value="2">';
				$txt .= '<label for="ch2">NO</label><br>';
			$txt .= '</div>';
			$txt .= '<label><strong>¿Que fugas presenta el Vehiculo?</strong></label>';
			$txt .= '<textarea type="text" name="desfuga" id="boton" style="display:none" class="form-control" maxlength="100">';
			$txt .= '</textarea>';
	   		$txt .= '</div>';
	  	$txt .= '</div>';
	$txt .= '</div>';
	#------------------------------------------EQUIPO HIDRAULICO CANASTA#------------------------------------------
	if($tipo[0]['codval']==1){
		$txt .= '<div class="card-group">';	
			$txt .= checki($idveh, 1, 102, "Equipo hidraulico canasta");
		$txt .= '</div>';
	}
	#------------------------------------------SISTEMA DE FRENOS && ESTADO DE LLANTAS------------------------------------------
	$txt .= '<div class="card-group">';
		#SISTEMA DE FRENOS CANASTA
		$txt .= checki($idveh, 1, 108, "Sistema de frenos canasta");
		#SISTEMA DE FRENOS CAMION RECOLECCION
		$txt .= checki($idveh, 2, 140, "Sistema de frenos Camion-recoleccion");
		#SISTEMA DE FRENOS SUPERVISOR CAMPERO
		$txt .= checki($idveh, 3, 268, "Sistema de frenos Supervisor-Campero");
		#SISTEMA DE FRENOS CUADRILLA
		$txt .= checki($idveh, 4, 198, "Sistema de frenos Camioneta-Cuadrilla");
		#SISTEMA DE FRENOS MOTOCICLETA
		$txt .= checki($idveh, 6, 260, "Sistema de frenos Motocicleta");
		#ESTADO DE LLANTAS CANASTA
		$txt .= checki($idveh, 1, 112, "Estado de llantas canasta");
		#ESTADO DE LLANTAS CAMION RECOLECCION
		$txt .= checki($idveh, 2, 144, "Estado de llantas Camion-recoleccion");
		#ESTADO DE LLANTAS SUPERVISOR
		$txt .= checki($idveh, 3, 171, "Estado de llantas Camion-recoleccion");
		#ESTADO DE LLANTAS CUADRILLA
		$txt .= checki($idveh, 4, 201, "Estado de llantas Camioneta-Cuadrilla");
		#ESTADO DE LLANTAS CHIPPER
		$txt .= checki($idveh, 5, 232, "Estado de llantas Chipper");
		#ESTADO DE LLANTAS MOTOCICLETA
		$txt .= checki($idveh, 6, 264, "Estado de llantas Motocicleta");
	$txt .= '</div>';
		$txt .= '<div class="card">';
	    	$txt .= '<div class="card-body">';
			$txt .= '<h6 class="m-0 font-weight-bold text-danger">DESCRIPCIÓN DE NOVEDADES E IMPREVISTOS</h6>';
			$txt .= '<label><strong>NOVEDADES</strong></label>';
				$txt .= '<div class="form-check form-check-inline">';
					$txt .= '<input type="radio" class="form-check-input pre" name="nov" required id="nov1" onChange="cradio(nov1,texa1);" value="1">';
					$txt .= '<label for="nov1">SI</label><br>';
					$txt .= '<input type="radio" class="form-check-input pre" name="nov" id="nov2" onChange="ctexa(nov2,texa1);" value="2">';
					$txt .= '<label for="nov2">NO</label><br>';
				$txt .= '</div>';
			$txt .= '<textarea type="text" name="novedad" id="texa1" style="display:none" class="form-control" maxlength="50">';
			$txt .= '</textarea>';
			$txt .= '</div>';
		$txt .= '</div>';
	 	$txt .= '<div class="card">';    
	    	$txt .= '<div class="card-body">';
			$txt .= '<label><strong>IMPREVISTOS Y REPARACIONES</strong></label>';
				$txt .= '<div class="form-check form-check-inline">';
					$txt .= '<input type="radio" class="form-check-input pre" name="imp" required id="imp1" onChange="cradio(imp1,texa);" value="1">';
					$txt .= '<label for="imp1">SI</label><br>';
					$txt .= '<input type="radio" class="form-check-input pre" name="imp" id="imp2" onChange="ctexa(imp2,texa);" value="2">';
					$txt .= '<label for="imp2">NO</label><br>';
				$txt .= '</div>';
			$txt .= '<textarea type="text" name="impre" id="texa" style="display:none" class="form-control" maxlength="50">';
			$txt .= '</textarea>';
			$txt .= '</div>';
		$txt .= '</div>';
		$txt .= '<div class="card">';    
	    	$txt .= '<div class="card-body">';
			$txt .= '<label>IMG</label>';
			$txt .= '<input type="file" name="arch" class="form-control" accept="image/jpeg, image/png, image/jpg">';
			$txt .= '</div>';
		$txt .= '</div>';
		$txt .= '<input type="hidden" name="opera" value="new">';
		$txt .= '<div class="col text-center">';
			$txt .= '<input type="submit" id="guardar" class="btn btn-secondary" value="';
			if($idprev)
				$txt .= 'Crear';
			$txt .= '">';
			$txt .= '</div>';
			$txt .= '</form>';
		$txt .= '</div>';
		$txt .= '</div><br><br><br><br>';
		$txt .= subir();
		echo $txt;
	}else if(!$idprev OR !$idveh){
		errormsn("Sin permisos para editar este registro","Vuelva a ingresar");
	}
}
#FUNCION QUE MUESTRA LOS ITEMS DEPENDIENDO DEL TIPO DE VEHICULO
function checki($idveh, $tipov, $dei, $tit){
	$mpreve = new mpreve();
	$tipo = $mpreve->tipo($idveh);
	$dtitem = $mpreve->selequ();
	$dep = NULL;
	$li = "";
	if($tipo[0]['codval']==$tipov){
		$li .= '<div class="card">';    
			$li .= '<div class="card-body">';
	    	$li .= '<small class="text-danger">Todos los campos son obligatorios *</small>';
			$dep = $dei;
			$listi = $mpreve->lista($dep);
			$li .= '<h6 class="m-0 font-weight-bold text-primary">'.$tit.'</h6>';
					foreach ($listi AS $i) {
					$li .= '<label ><strong>'.$i['nomitem'].'</strong></label>';
						$li .= '<div class="form-check">';
							$li .= '<input type="checkbox" class="form-check form-check-inline pre" name="itemv[]" id="a'.$i['iditem'].'" value="'.$i['iditem'].'" onclick="cambio(1,a'.$i['iditem'].',b'.$i['iditem'].'); che2(a'.$i['iditem'].',i'.$i['iditem'].');" required>';
							$li .= '<label class="form-check-label" for="a'.$i['iditem'].'">CUMPLE</label>';
						$li .= '</div>';
						$li .= '<div class="form-check">';
							$li .= '<input type="checkbox" class="form-check form-check-inline pre" name="itemf[]" id="b'.$i['iditem'].'" value="'.$i['iditem'].'" onclick="cambio(2,a'.$i['iditem'].',b'.$i['iditem'].'); che1(b'.$i['iditem'].',i'.$i['iditem'].');" required>';
							$li .= '<label class="form-check-label" for="b'.$i['iditem'].'">NO CUMPLE</label>';
						$li .= '</div>';
						$li .= '<input type="text" name="descri[]" id="i'.$i['iditem'].'" style="display:none" maxlength="100" placeholder="Novedad" class="form-control">';
					}
			$li .= '</div>';
		$li .= '</div>'; 
	}
	return $li;
}
?>