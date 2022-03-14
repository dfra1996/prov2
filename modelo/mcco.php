<?php
class mcco{
	//SELECT idcc, nomcc, codubi, depcc FROM centrocosto
	public function selubi($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idcc, u.nomcc AS CenC, u.codubi,b.nomubi, u.depcc AS Emp, d.nomcc AS Nemp FROM centrocosto AS u INNER JOIN centrocosto AS d ON u.depcc=d.idcc INNER JOIN ubicacion AS b ON u.codubi=b.codubi";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql .= " WHERE u.depcc=:filtro OR u.nomcc LIKE :filtro2";
		}
		$sql .= " ORDER BY u.idcc LIMIT $rvalini, $rvalfin;";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($filtro){
			$result->bindParam(':filtro',$filtro);
			$result->bindParam(':filtro2',$filtro2);
		}
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selubi1($idcc){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idcc, u.nomcc AS CenC, u.codubi,b.nomubi, u.depcc AS Emp, d.nomcc AS Nemp FROM centrocosto AS u INNER JOIN centrocosto AS d ON u.depcc=d.idcc INNER JOIN ubicacion AS b ON u.codubi=b.codubi WHERE u.idcc=:idcc";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idcc',$idcc);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql = "SELECT COUNT(u.idcc) AS Npe FROM centrocosto AS u INNER JOIN centrocosto AS d ON u.depcc=d.idcc";
		if($filtro){
			$sql .= " WHERE u.depcc='$filtro' OR u.nomcc LIKE '%$filtro%';";
		}
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}

	public function ccver($idcc, $nomcc, $codubi, $depcc){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL ccver(:idcc, :nomcc, :codubi, :depcc)";
		//echo "<br><br><br><br>".$sql."<br>'".$idcc."','".$nomcc."','".$codubi."','".$depcc."'<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idcc',$idcc);
		$result->bindParam(':nomcc',$nomcc);
		$result->bindParam(':codubi',$codubi);
		$result->bindParam(':depcc',$depcc);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

	public function ccdel($idcc){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL ccdel(:idcc)";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idcc',$idcc);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}

	public function selubi2(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idcc, nomcc, codubi, depcc FROM centrocosto WHERE depcc=0 ORDER BY nomcc;";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Metodo muestre las Ciudades
	public function selciu(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT c.codubi, c.nomubi AS ciu, d.nomubi AS dep FROM ubicacion AS c INNER JOIN ubicacion AS d ON c.depubi=d.codubi ORDER BY c.nomubi";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function seldep(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codubi, nomubi FROM ubicacion WHERE depubi=0 ORDER BY nomubi";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>