<?php
require_once('modelo/conexion.php');
require_once('modelo/mmen.php');

function mosmen($pagmen, $pefid){
	$mmen = new mmen();
	$result = $mmen->selmen($pagmen, $pefid);
	$pm = strtolower($pagmen);
	$idusu = isset($_SESSION["idusu"]) ? $_SESSION["idusu"]:NULL;
	$nom = isset($_SESSION["nomusu"]) ? $_SESSION["nomusu"]:NULL;
	// Llamado Datos Usuario
	// Validar que trae la variable
	#var_dump ($dt[0]['imgus']);
	// Asignar 0 a valor Null para que no salgan errores
	//if($dt[0]['imgus']==NULL) $dt[0]['imgus'] = 0;
	$txt = '';
    $txt .= '<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">';
        $txt .= '<!-- Navbar Brand-->';
        $txt .= '<a class="navbar-brand ps-3" href="home.php">MyC</a>';
        $txt .= '<!-- Sidebar Toggle-->';
        $txt .= '<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>';
        $txt .= '<!-- Navbar Search-->';
        $txt .= '<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">';
            $txt .= '<div class="input-group">';
            	#En una actualizacion futura poner a funcionar el filtro de busqueda de toda la pagina en general
                $txt .= '<input class="form-control" type="hidden" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />';
               
            $txt .= '</div>';
        $txt .= '</form>';
        $txt .= '<!-- Navbar-->';
        $txt .= '<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">';
            $txt .= '<li class="nav-item dropdown">';
                $txt .= '<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>';
                $txt .= '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">';
                    $txt .= '<li><a class="dropdown-item" href="home.php?pg=1014">Datos personales</a></li>';
                    $txt .= '<li><hr class="dropdown-divider" /></li>';
                    $txt .= '<li><a class="dropdown-item" href="home.php?pg=1070">Salir</a></li>';
                $txt .= '</ul>';
            $txt .= '</li>';
        $txt .= '</ul>';
    $txt .= '</nav>';
	if($result){
        $txt .= '<div id="layoutSidenav">';
            $txt .= '<div id="layoutSidenav_nav">';
                $txt .= '<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">';
                   $txt .= '<div class="sb-sidenav-menu">';
                        $txt .= '<div class="nav">';
                        foreach($result as $dt){
                        	if($dt['pagarc']=="#Espacio"){
                            	$txt .= '<div class="sb-sidenav-menu-heading">'.$dt['pagnom'].'</div>';
                        	}else{
                        		$txt .= '<a class="nav-link" href="'.$pm.'.php?pg='.$dt['pagid'].'">';
	                                $txt .= '<div class="sb-nav-link-icon"><i class="'.$dt['icono'].'"></i></div>';
	                                $txt .= $dt["pagnom"];
                            	$txt .= '</a>';     
                        	}              
                   		}
                   		$txt .= '</div>';
                    $txt .= '</div>';
                    $txt .= '<div class="sb-sidenav-footer">';
                        $txt .= '<div class="small">¡BIENVENIDO!</div>';
                        $txt .= $nom;
                    $txt .= '</div>';
                $txt .= '</nav>';
            $txt .= '</div>';
        echo $txt;
	}
	function moscon($pefid,$pg){
		$mmen = new mmen();
		$datpgpf = $mmen->selpgpf($pefid);

		if($pefid)
			if(!$pg) $pg = $datpgpf[0]['pagprin'];
		else
			if(!$pg) $pg = 5555;

		$result = $mmen->selpgact($pg, $pefid);
		if($result){
			foreach ($result as $f) {
				require_once($f['pagarc']);
			}
		}else{
			$txt = "<div class='textinf'>";
				$txt .= "Usted no tiene permisos para ver esta página. Comuniquese con su administrador.";
			$txt .= "</div>";
			echo $txt;
		}
	}
}
?>