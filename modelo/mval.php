<?php
class mval{
	#Metodo mostrar circuitos
	public function selval(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT v.codval, v.iddom, d.nomdom, v.nomval, v.parval
               FROM valor AS v INNER JOIN dominio AS d ON v.iddom=d.iddom";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}	
	public function selval1($codval){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT v.codval, v.iddom, v.nomval, v.parval
               FROM valor AS v INNER JOIN dominio AS d ON v.iddom=d.iddom 
               WHERE v.codval=:codval";
		//echo "<br><br><br><br><br>".$sql."<br>".$codval."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':codval', $codval);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function valiu($codval, $iddom, $nomval, $parval){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL valiu(:codval, :iddom, :nomval, :parval)";
		//echo "<br><br><br><br><br>".$sql."<br>'".$codval."','".$iddom."','".$nomval."','".$sigval."','".$parval."'<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':codval',$codval);
		$result->bindParam(':iddom',$iddom);
		$result->bindParam(':nomval',$nomval);

		$result->bindParam(':parval',$parval);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	public function valdel ($codval){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL valdel(:codval);";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':codval', $codval);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}	
	public function seldom (){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddom, nomdom FROM dominio;";
		// echo "<br><br><br><br><br>".$sql."<br><br>";
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