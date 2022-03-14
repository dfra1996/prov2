<?php 
class mcir{
	//Metodo para insertar un nuevo circuito o actualizar uno ya existente
	public function inscir($idcir,$idzon,$nomcir){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL inscir(:idcir,:idzon,:nomcir);";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);		

		$result->bindParam(':idcir',$idcir);
		$result->bindParam(':idzon',$idzon);
		$result->bindParam(':nomcir',$nomcir);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	#Metodo mostrar circuitos
	public function selcir(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT c.idcir, c.idzon, c.nomcir, u.nomzon, z.nomzon AS zon FROM circuito as c INNER JOIN zona AS u ON c.idzon=u.idzon INNER JOIN zona AS z ON u.depzon=z.idzon";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo mostrar las Zonas
	public function zonas(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idzon, nomzon, depzon FROM zona WHERE depzon=0 ORDER BY nomzon;";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo mostrar las Zonas
	public function selmn(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idzon, nomzon, depzon FROM zona WHERE NOT depzon=0";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Funciopn traer datos de un solo registro en circuito
	public function selcir1($idcir){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT c.idcir, c.idzon, c.nomcir, z.idzon as zid FROM circuito AS c INNER JOIN zona AS z ON c.idzon=z.idzon";
		$sql .= " WHERE c.idcir=:idcir";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idcir',$idcir);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Funcion para eliminar un circuito
	public function delcir($idcir){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL delcir(:idcir);";
		//echo "<br><br><br><br>".$sql."<br>".$idcir."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idcir',$idcir);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
}
?>