<?php 
class msold{

	//Funcion traer datos del vehiculo de las solicitud y del vehiculo
	public function seldt($idsol){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();		
		$sql ="SELECT s.idsol, s.fecsol,s.motivo, s.idveh,v.placaveh, vr.nomval as tipov, sr.nomval as servicio , v.modelo, v.color, s.novedad, s.kilo, s.recibe FROM solicitud AS s LEFT JOIN vehiculo AS v ON s.idveh=v.idveh LEFT JOIN valor as vr on v.tipoveh=vr.codval LEFT JOIN  valor AS sr ON v.tiposer=sr.codval";
		$sql.=" WHERE idsol=:idsol";		
			//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idsol',$idsol);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Metodo traer items a evaluar
	public function selitem(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();		
		$sql = 'SELECT iditem, nomitem FROM item WHERE depite=1';
		#$sql = "SELECT i.iditem, i.nomitem FROM item as i LEFT JOIN respuesta as r on i.iditem=r.iditem";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Metodo para Seleccionar conductor
	public function selcond(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();		
		$sql = 'SELECT idusu, nomusu, apeusu, pefid FROM usuario WHERE pefid = 2';
		#$sql = "SELECT i.iditem, i.nomitem FROM item as i LEFT JOIN respuesta as r on i.iditem=r.iditem";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	//Metodo para insertar respuestas de los ITEMS
	public function insres($idres, $iditem, $idsol, $res){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL insres(:idres,:iditem, :idsol, :res);";
		//echo "<br><br><br><br><br> ECHO VARIABLES DE LA CLASE: ".$sql."<br>".$idres."-".$iditem."-".$res;
		//echo "<br><br><br><br><br> ECHO".$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result = $conexion->prepare($sql);
		$result->bindParam(':idres',$idres);
		$result->bindParam(':iditem',$iditem);
		$result->bindParam(':idsol',$idsol);
		$result->bindParam(':res',$res);	
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	#METODO PARA ACTUALIZAR O LLENAR ULTIMOS CAMPOS DE LA SOLICITUD 2 PARTE
	public function inssol2($novedad, $entrega, $recibe, $idsol, $kilo){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "UPDATE solicitud SET novedad=:novedad, entrega=:entrega, recibe=:recibe, kilo=:kilo WHERE idsol=:idsol";
		#echo "<br><br><br><br>".$sql."<br>'".$novedad."'-'".$entrega."'-'".$recibe."'<br>";
		$result = $conexion->prepare($sql);
		#echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':novedad',$novedad);
		$result->bindParam(':entrega',$entrega);
		$result->bindParam(':recibe',$recibe);
		$result->bindParam(':kilo',$kilo);
		$result->bindParam(':idsol',$idsol);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	//Eliminar ITEMS de la solicitud en la tabla respuesta para actualizar de nuevo 
	public function deletes($idsol){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "DELETE FROM respuesta WHERE idsol=:idsol ";
		//echo "<br><br><br><br>".$sql."<br>'".$pefid."'-'".$pefnom."'-'".$pagprin."'<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idsol',$idsol);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	//Funcion para marcar los item Seleccionador al momento de realizar una solicitud
	public function marcar($iditem, $idsol){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idres, iditem, idsol, res FROM respuesta WHERE iditem = :iditem AND idsol = :idsol";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':iditem',$iditem);
		$result->bindParam(':idsol',$idsol);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;		
	}
}
?>