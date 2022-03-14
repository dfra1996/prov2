<?php 
class mpag{
	public function selpag(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT p.pagid, p.pagnom, p.pagarc, p.pagmos, p.pagord, p.pagmen, p.icono FROM pagina AS p";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);		
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function act($pagid,$pagmos){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "UPDATE pagina SET pagmos=:pagmos WHERE pagid=:pagid;";
		//echo "<br><br><br><br>".$sql."<br>'".$pagid."'";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':pagid',$pagid);
		$result->bindParam(':pagmos',$pagmos);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}

	public function selpag1($pagid){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT p.pagid, p.pagnom, p.pagarc, p.pagmos, p.pagord, p.pagmen, p.icono 
		FROM pagina AS p WHERE p.pagid=:pagid ";

		$result = $conexion->prepare($sql);
		$result->bindParam(':pagid',$pagid);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo Insertar o editar una pagina
	public function pagiu($pagid,$pagnom, $pagarc, $pagmos, $pagord, $pagmen, $icono){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL pagiu(:pagid,:pagnom, :pagarc, :pagmos, :pagord, :pagmen, :icono);";
		//echo "<br><br><br><br><br>".$sql."<br>".$pagid."-".$pagnom."-".$pagarc."-".$pagmos."-".$pagord."-".$pagmen."-".$icono."<br>";

		$result = $conexion->prepare($sql);
		$result->bindParam(':pagid',$pagid);
		$result->bindParam(':pagnom',$pagnom);
		$result->bindParam(':pagarc',$pagarc);
		$result->bindParam(':pagmos',$pagmos);
		$result->bindParam(':pagord',$pagord);
		$result->bindParam(':pagmen',$pagmen);
		$result->bindParam(':icono',$icono);
		
		//echo $conexion->serAtrribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	#Metodo eliminar una pagina
	public function pagdel($pagid){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL pagdel(:pagid);";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";

		$result = $conexion->prepare($sql);
		//echo $conexion->serAtrribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':pagid',$pagid);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
	
	public function selpper(){
		$result = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pagid FROM pagper";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>