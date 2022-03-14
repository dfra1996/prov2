<?php
require_once 'modelo/conexion.php';
function erroraute(){
	$error = isset($_GET['error']) ? $_GET['error']:NULL;
	if($error=="ok"){
		$txt = '<div class="col-xl-3 col-md-6 mb-4">';
            $txt = '<div class="card border-left-danger shadow h-100 py-2">';
            $txt .= '<div class="card-body">';
                $txt .= '<div class="row no-gutters align-items-center">';
                    $txt .= '<div class="col mr-2">';
                        $txt .= '<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">';
                            $txt .= 'Datos incorrectos</div>';
                        $txt .= '<div class="h5 mb-0 font-weight-bold text-gray-800">*Intente de nuevo*</div>';
                    $txt .= '</div>';
                    $txt .= '<div class="col-auto">';
                        $txt .= '<i class="fas fa-exclamation-triangle"></i>';
                    $txt .= '</div>';
                $txt .= '</div>';
            $txt .= '</div>';
        $txt .= '</div>';		
		echo $txt;
	}
}
?>