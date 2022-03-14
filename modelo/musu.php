<?php
class musu{

	//Método de Insertar usuario
	#SELECT idusu, nomusu, apeusu, docid, pefid, telusu, codubi, lictran, vlictran, emausu, pasusu, actusu, fecsolusu, clausu FROM usuario WHERE 1
	public function insusu($idusu,$nomusu,$apeusu,$docid,$pefid,$telusu,$codubi,$lictran,$vlictran,$emausu,$pasusu,$actusu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL insusu(:idusu,:nomusu,:apeusu,:docid,:pefid,:telusu,:codubi,:lictran,:vlictran,:emausu,:pasusu,:actusu);";
		#echo "<br><br><br><br>".$sql."<br>'".$idusu."','".$nomusu."','".$apeusu."','".$pefid."','".$vlictran."','".$telusu."','".$codubi."','".$emausu."','".$pasusu."','".$actusu."','".$lictran."'<br>";
		$result = $conexion->prepare($sql);
		#$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		#echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		#echo $conexion->errorCode();
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':nomusu',$nomusu);
		$result->bindParam(':apeusu',$apeusu);
		$result->bindParam(':docid',$docid);		
		$result->bindParam(':pefid',$pefid);
		$result->bindParam(':telusu',$telusu);		
		$result->bindParam(':codubi',$codubi);
		$result->bindParam(':lictran',$lictran);
		$result->bindParam(':vlictran',$vlictran);
		$result->bindParam(':emausu',$emausu);
		if($pasusu){
			$pas = sha1(md5($pasusu));
			$result->bindParam(':pasusu',$pas);	
		}else{
			$result->bindParam(':pasusu',$pasusu);	
		}
		$result->bindParam(':actusu',$actusu);
		try {
		    $result->execute();
		    #echo "<script>alert('Datos insertados existosamente');</script>";
		} catch (PDOException $e) {
		    if ($e->getCode() == '23000')
		    	echo "<script>alert('Error: El email ya se encuentra registrado')</script>";
		        //echo "Syntax Error: ".$e->getMessage();
		}
	}

//Método de mostrar usuarios
	public function selusu(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.docid, u.pefid, u.telusu, u.codubi, u.lictran, u.vlictran, u.emausu, u.pasusu, u.actusu, u.fecsolusu, u.clausu, p.pefnom AS pfl FROM usuario AS u INNER JOIN perfil AS p ON u.pefid=p.pefid";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Método de mostrar un usuario PARA REALIZAR UN UPDATE
	public function selusu1($idusu){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.docid, u.pefid, u.telusu, u.codubi, u.lictran, u.vlictran, u.emausu, u.pasusu, u.actusu, u.fecsolusu, u.clausu, ubi.nomubi FROM usuario AS u INNER JOIN ubicacion AS ubi ON u.codubi=ubi.codubi  WHERE idusu=:idusu ;";
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
		$sql = "CALL delusu(:idusu);";
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
	//Metodo mostrar departamentos
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
	public function bloq($idusu,$actusu){
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
}

?>