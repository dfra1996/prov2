<?php
	require_once('modelo/conexion.php');

	$valor = $_REQUEST["valor"];
	$data = selzon($valor);
	$i=0;
	if($data){
		foreach ($data as $res) {
			$mmun[$i]["value"]=$res["idzon"];
			$mmun[$i]["nombre"]=$res["nomzon"];
			$i++;
		}
		$html = '<div id="reloadzon">';
		$html .= '<label>Municipio</label>';
			$html .= '<select name="idzon" class="form-control" required onChange="javascript:recCircuito(this.value);">';
			$html .= '<option value="">Seleccione Municipio</option>';

			foreach ($mmun as $res) {
				$html .= '<option value="'.$res['value'].'">'.$res['nombre'].'</option>';
			}
			$html .= '</select>';
		$html .= '</div>';
		echo $html;
	}else{
		echo '<h6 class="m-0 font-weight-bold text-danger">No existen Municipios</h6>';
	}

	function selzon($valor){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idzon, nomzon FROM zona WHERE depzon=:valor ORDER BY nomzon;";
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