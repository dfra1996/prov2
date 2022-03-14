<?php
class mmail{
	//SELECT idusu, nomusu, apeusu, pefid, dirusu, telusu, codubi, emausu, pasusu, espmed, idlab, fecsolusu, clausu FROM usuario
	public function vmail($mail){
		$res = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql= 'SELECT idusu, concat(nomusu," ",apeusu) As nom FROM usuario WHERE emausu=:mail;';
		//echo $sql;
		$result = $conexion->prepare($sql);
		$result->bindParam(':mail',$mail);
		if($result) $result->execute();
		while($f=$result->fetch())
			$res[] = $f;
		return $res;
	}
	public function ufc($idusu,$fecsolusu,$clausu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql= "UPDATE usuario SET fecsolusu=:fecsolusu, clausu=:clausu WHERE idusu=:idusu";
		//echo $sql;
		$result = $conexion->prepare($sql);	
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':fecsolusu',$fecsolusu);
		$result->bindParam(':clausu',$clausu);
		$result->execute();
	}
	public function upas($idusu,$pasusu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql= "UPDATE usuario SET pasusu=:pasusu WHERE idusu=:idusu";
		//echo $sql;
		$result = $conexion->prepare($sql);	
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':pasusu',$pasusu);
		$result->execute();
	}
	public function susucf($clausu,$fecsolusu){
		$res = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql= "SELECT idusu, nomusu, apeusu FROM usuario WHERE clausu=:clausu 
		AND ADDDATE(fecsolusu, INTERVAL 12 hour)>=:fecsolusu;";
		//echo "<br><br><br>".$sql."<br>'".$clausu."','".$fecsolusu."'<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':clausu',$clausu);
		$result->bindParam(':fecsolusu',$fecsolusu);
		if($result) $result->execute();
		while($f=$result->fetch())
			$res[] = $f;
		return $res;
	}
}
?>