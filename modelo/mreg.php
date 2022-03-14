<?php
class mreg{

//Método de Insertar usuario
	//public function usuver($idusu, $nomusu, $apeusu, $pefid, $dirusu, $telusu, $codubi, $emausu, $pasusu, $actusu, $idcc){
	public function usuver($idusu, $nomusu, $pefid, $telusu, $emausu, $pasusu, $actusu, $idcc){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL usuver(:idusu, '0', :nomusu, '', :pefid, '', :telusu, '25899', :emausu, :pasusu, :actusu, :idcc);";
		//echo "<br><br><br><br>".$sql."<br>'".$idusu."','".$nomusu."','".$apeusu."','".$pefid."','".$dirusu."','".$telusu."','".$codubi."','".$emausu."','".$pasusu."','".$actusu."','".$idcc."'<br>";
		$result = $conexion->prepare($sql);
		$error = $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo $conexion->errorCode();
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':nomusu',$nomusu);
		//$result->bindParam(':apeusu',$apeusu);
		$result->bindParam(':pefid',$pefid);
		//$result->bindParam(':dirusu',$dirusu);
		$result->bindParam(':telusu',$telusu);
		//$result->bindParam(':codubi',$codubi);
		$result->bindParam(':emausu',$emausu);
		if($pasusu){
			$pas = sha1(md5($pasusu));
			$result->bindParam(':pasusu',$pas);	
		}else{
			$result->bindParam(':pasusu',$pasusu);	
		}
		$result->bindParam(':actusu',$actusu);
		$result->bindParam(':idcc',$idcc);

		try {
		    $result->execute();
		    echo "<script>alert('Datos insertados existosamente');</script>";
		} catch (PDOException $e) {
		    if ($e->getCode() == '23000')
		    	echo "<script>alert('Error: El email ya se encuentra registrado')</script>";
		        //echo "Syntax Error: ".$e->getMessage();
		}
	}

//Método de mostrar usuarios
	public function selusu($filtro,$rvalini,$rvalfin){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.pefid, p.pefnom, u.dirusu, u.telusu, u.codubi, b.nomubi, u.emausu, u.actusu, u.idcc, v.nomcc FROM usuario AS u INNER JOIN ubicacion AS b ON u.codubi=b.codubi INNER JOIN perfil as p ON u.pefid=p.pefid LEFT JOIN centrocosto AS v ON u.idcc=v.idcc";
		if($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE u.nomusu LIKE :filtro OR u.apeusu LIKE :filtro";
		}
		$sql .= " ORDER BY u.nomusu, u.apeusu LIMIT $rvalini, $rvalfin";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		if ($filtro){
			$result->bindParam(':filtro', $filtro);
		}
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Método contar los registros de usuarios
	public function sqlcount($filtro){
		$sql = "SELECT count(u.idusu) AS Npe FROM usuario AS u INNER JOIN ubicacion AS b ON u.codubi=b.codubi INNER JOIN perfil as p ON u.pefid=p.pefid LEFT JOIN centrocosto AS v ON u.idcc=v.idcc";
		if($filtro)
			$sql .= " WHERE u.nomusu LIKE '%$filtro%' OR u.apeusu LIKE '%$filtro%'";
		return $sql;
	}

//Método de mostrar un usuario
	public function selusu1($idusu){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.pefid, p.pefnom, u.dirusu, u.telusu, u.codubi, b.nomubi, u.emausu, u.actusu, u.idcc, v.nomcc FROM usuario AS u INNER JOIN ubicacion AS b ON u.codubi=b.codubi INNER JOIN perfil as p ON u.pefid=p.pefid LEFT JOIN centrocosto AS v ON u.idcc=v.idcc WHERE idusu=:idusu";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idusu',$idusu);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Método de eliminar usuarios
	public function eliusu($idusu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL usudel (:idusu);";
		//echo "<br><br><br><br>".$sql."<br>'".$idusu."'";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idusu',$idusu);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}
//Método de activar o desactivar usuarios
	public function act($idusu,$actusu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "UPDATE usuario SET actusu=:actusu WHERE idusu=:idusu;";
		//echo "<br><br><br><br>".$sql."<br>'".$idusu."'";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':actusu',$actusu);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
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
//Metodo muestre los Perfiles
	public function selpef(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pefid, pefnom FROM perfil";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
//Metodo muestre los Centros de Costo
	public function selcc(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idcc, nomcc FROM centrocosto";
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