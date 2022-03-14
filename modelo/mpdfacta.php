<?php 
class mpdfacta{
	public function selacta2($idsol){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT s.idsol, s.fecsol, s.motivo, s.idveh, s.novedad, s.entrega, s.recibe, s.kilo,v.placaveh,v.modelo,v.color,v.soat, v.rtmexp, t.nomval AS tipov, ts.nomval as tis, en.nomusu as nomen, en.apeusu AS apeen, re.nomusu AS nomre, re.apeusu AS apere FROM solicitud AS s INNER JOIN vehiculo AS v ON s.idveh=v.idveh INNER JOIN valor AS t ON v.tipoveh=t.codval LEFT JOIN valor as ts ON v.tiposer=ts.codval  INNER JOIN usuario AS en ON s.entrega=en.idusu INNER JOIN usuario AS re ON s.recibe=re.idusu  WHERE idsol=:idsol";

		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idsol',$idsol);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;		
	}
		public function lisitem(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iditem, nomitem FROM item WHERE depite=1";

		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;		
	}
	public function selres($idsol){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idres, iditem, idsol, res FROM respuesta WHERE idsol=:idsol";

		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idsol',$idsol);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;		
	}
	public function marcar($iditem, $idsol){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idres, iditem, idsol, res FROM respuesta WHERE iditem = :iditem AND idsol = :idsol";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':iditem',$iditem);
		$result->bindParam(':idsol',$idsol);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;		
	}
}
?>