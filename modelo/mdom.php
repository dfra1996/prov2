<?php
class mdom{
	//Mostrar datos De dominio
		public function seldom(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddom, nomdom, pardom FROM dominio";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Mostrar un registro
	public function seldom1($iddom){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddom, nomdom, pardom FROM dominio";
		$sql .= " WHERE iddom=:iddom";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddom',$iddom);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Actualizar y/o Insertar
	public function domiu($iddom, $nomdom, $pardom){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL domiu(:iddom,:nomdom, :pardom);";
		//echo "<br><br><br><br>".$sql."<br>".$iddom."-".$nomdom."-".$pardom."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddom',$iddom);
		$result->bindParam(':nomdom',$nomdom);
		$result->bindParam(':pardom',$pardom);
		
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	//Eliminar
	public function deldom($iddom){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL domdel(:iddom);";
		//echo "<br><br><br><br>".$sql."<br>".$iddom."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddom',$iddom);
		
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
}
?>