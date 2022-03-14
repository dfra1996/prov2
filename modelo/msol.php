<?php 
class msol{
	//Funcion para seleccionar datos de acta
	public function selacta(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT s.idsol, s.fecsol, s.motivo, s.idveh, s.novedad, s.entrega, s.recibe, v.placaveh, u.nomusu, u.apeusu FROM solicitud AS s INNER JOIN vehiculo AS v ON s.idveh=v.idveh LEFT JOIN usuario AS u ON s.entrega=u.idusu";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Seleccionar datos del acta con tablas anidadas VEHICULO, VALOR, SOLICITUD, ITEM, RESPUESTA
	public function selacta2($idsol){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT s.idsol, s.fecsol, s.motivo, s.idveh, s.novedad, s.entrega, s.recibe, s.kilo, v.placaveh,v.modelo,v.color,v.soat, v.rtmexp, t.nomval AS tipov, ts.nomval as tis, en.nomusu as nomen, en.apeusu AS apeen, re.nomusu AS nomre, re.apeusu AS apere FROM solicitud AS s INNER JOIN vehiculo AS v ON s.idveh=v.idveh INNER JOIN valor AS t ON v.tipoveh=t.codval LEFT JOIN valor as ts ON v.tiposer=ts.codval  INNER JOIN usuario AS en ON s.entrega=en.idusu INNER JOIN usuario AS re ON s.recibe=re.idusu  WHERE idsol=:idsol";

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
	# Funcion para listar los items que tiene la solicitud
	public function items($idsol){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT r.idres, r.iditem, r.idsol, r.res, i.nomitem FROM respuesta AS r INNER JOIN item AS i ON r.iditem=i.iditem WHERE idsol=:idsol";
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
	//Funcion para mostrar vehiculos
	public function selveh(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idveh, tipoveh, placaveh, ciuexp, modelo, marca, docveh, fecmat, color, tiposer, certdi, certizaje, codop, vencodop, empsoat, soat, rtmcod, rtmexp, segcont, vensc, segecont, vensecont, emptr, venstr, extracto, revpre, restriccion FROM vehiculo";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Funcion para insertar primera parde de la solicitud idsol, fecsol, motivo, res 
	public function inssol($idsol, $fecsol, $motivo, $idveh){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL inssol(:idsol,:fecsol, :motivo, :idveh);";
		#echo "<br><br><br><br><br>".$sql."<br>".$idsol."-".$fecsol."-".$motivo."-".$idveh;
		$result = $conexion->prepare($sql);
		$result->bindParam(':idsol',$idsol);
		$result->bindParam(':fecsol',$fecsol);
		$result->bindParam(':motivo',$motivo);
		$result->bindParam(':idveh',$idveh);		
		//echo $conexion->serAtrribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();		
	}
	//Funcion para llevar datos del vehiculo a las segunda parte de la solicitud, la consulta da como resultado el ID del vehiculo
	public function selsol2($fecsol, $motivo, $idveh){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idsol FROM solicitud WHERE fecsol=:fecsol and motivo=:motivo and idveh=:idveh";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':fecsol',$fecsol);
		$result->bindParam(':motivo',$motivo);
		$result->bindParam(':idveh',$idveh);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>