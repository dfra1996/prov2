<?php
	require_once('modelo/conexion.php');

	$valor = $_REQUEST["valor"];
	$dtc = selcircuito($valor);
	$i=0;
	if($dtc){
		foreach ($dtc as $res) {
			$mmun[$i]["value"]=$res["idcir"];
			$mmun[$i]["nombre"]=$res["nomcir"];
			$i++;
		}	
		$html = '<div id="reloadCir">';
			$html .= '<label>Seleccione el circuito</label>';
			$html .= '<select name="idcir" class="form-control" required>';
				$html .= '<option value="">Seleccione el circuito</option>';
			foreach ($mmun as $res) {
				$html .= '<option value="'.$res['value'].'">'.$res['nombre'].'</option>';
			}
			$html .= '</select>';
		$html .= '</div>';
		echo $html;
	}else{
		echo '<h6 class="m-0 font-weight-bold text-danger">No existen circuitos en este municipio</h6>';
	}

	function selcircuito($valor){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		//$sql = "SELECT idcir, nomcir FROM zona WHERE depubi=:valor ORDER BY nomzon;";
		$sql = "SELECT c.idcir, c.nomcir, u.idzon FROM circuito AS c INNER JOIN zona AS u ON u.idzon=c.idzon WHERE c.idzon=:valor ORDER BY nomzon;";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':valor',$valor);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
?>