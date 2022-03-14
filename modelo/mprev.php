<?php 
class mprev{
	# SELECT idveh, tipoveh FROM vehiculo WHERE placaveh=
	//Metodo consultar un vehiculo por placa
	public function selplaca($placaveh){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idveh, tipoveh FROM vehiculo";
		$sql .= " WHERE placaveh=:placaveh";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':placaveh',$placaveh);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo para crear un nuevo preoperacional Primera parte
	public function inspre($idprev, $idveh, $idusu, $fecpre){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL inspre(:idprev, :idveh, :idusu, :fecpre);";
		echo "<br><br><br><br>".$sql."<br>'".$idprev."'-'".$idusu."'<br>";
		$result = $conexion->prepare($sql);
		#echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idprev',$idprev);
		$result->bindParam(':idveh',$idveh);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':fecpre',$fecpre);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
		//Metodo para llevar ID de preoperacional al preoperacional 2
	public function selpreo($fecpre, $idveh, $idusu){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idprev FROM preoperacionalv WHERE fecpre=:fecpre and idveh=:idveh and idusu=:idusu";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':fecpre',$fecpre);
		$result->bindParam(':idveh',$idveh);
		$result->bindParam(':idusu',$idusu);
		
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
		//Metodo para llevar ID de preoperacional al preoperacional 2
	public function selpb($idprev){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idveh FROM preoperacionalv WHERE idprev=:idprev";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idprev',$idprev);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo para traer los datos de todos lo preoperacionales y mostrarlos en una tabla  o modal
	public function dtpreo(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pre.idprev, pre.idveh, pre.idusu, pre.fecpre, TIMESTAMPDIFF(DAY,pre.fecpre,NOW()) AS hace, pre.expext, pre.desequi, pre.kilo, pre.horo, pre.fuga, pre.desfuga, pre.novedad, pre.impre, u.nomusu, u.apeusu, v.placaveh, vr.nomval, pre.img, pre.nov, pre.imp FROM preoperacionalv AS pre INNER JOIN usuario AS u ON pre.idusu=u.idusu INNER JOIN vehiculo AS v ON pre.idveh=v.idveh INNER JOIN valor AS vr ON v.tipoveh=vr.codval ORDER BY fecpre DESC";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$result->bindParam(':idprev',$idprev);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo traer los datos de un properacional dependiendo del usario
	public function dtpreo1($idusu){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pre.idprev, pre.idveh, pre.idusu, pre.fecpre, TIMESTAMPDIFF(DAY,pre.fecpre,NOW()) AS hace, pre.expext, pre.desequi, pre.kilo, pre.horo, pre.fuga, pre.desfuga, pre.novedad, pre.impre, u.nomusu, u.apeusu, v.placaveh, vr.nomval, pre.img, pre.nov, pre.imp FROM preoperacionalv AS pre INNER JOIN usuario AS u ON pre.idusu=u.idusu INNER JOIN vehiculo AS v ON pre.idveh=v.idveh INNER JOIN valor AS vr ON v.tipoveh=vr.codval  WHERE pre.idusu=:idusu ORDER BY fecpre DESC";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idusu',$idusu);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>