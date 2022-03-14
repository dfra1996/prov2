<?php 
class mpreve{	
	//Metodo consultar el tipo de vehiculo por ID del vehiculo
	public function tipo($idveh){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT v.tipoveh, vr.nomval, vr.codval FROM vehiculo AS v INNER JOIN valor as vr ON v.tipoveh=vr.codval";
		$sql .= " WHERE v.idveh=:idveh";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idveh',$idveh);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo actualizar e insertar segunda parte del preoperacional
	public function updprev($expext, $desequi, $chipper,$kilo, $horo, $fuga, $desfuga, $novedad, $impre, $idprev, $img, $nov, $imp){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "UPDATE preoperacionalv SET expext=:expext, chipper=:chipper,desequi=:desequi, kilo=:kilo, horo=:horo, fuga=:fuga, desfuga=:desfuga, novedad=:novedad, impre=:impre, img=:img , nov=:nov, imp=:imp WHERE idprev=:idprev;";
		#$sql = 'UPDATE preoperacionalv SET expext= "1", desequi="1", kilo="1", horo="1", fuga="1", desfuga="1", novedad="1", impre="1" WHERE idprev=56;';
		#echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':expext',$expext);
		$result->bindParam(':chipper',$chipper);
		$result->bindParam(':desequi',$desequi);
		$result->bindParam(':kilo',$kilo);
		$result->bindParam(':horo',$horo);
		$result->bindParam(':fuga',$fuga);
		$result->bindParam(':desfuga',$desfuga);
		$result->bindParam(':novedad',$novedad);
		$result->bindParam(':impre',$impre);
		$result->bindParam(':idprev',$idprev);
		$result->bindParam(':img',$img);
		$result->bindParam(':nov',$nov);		
		$result->bindParam(':imp',$imp);		

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	#METODO INSERTAR ITEM EQUIPO DE CARRETERA
	public function inseq($idres, $iditem, $idprev, $res){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL inseq(:idres,:iditem, :idprev, :res);";
		//echo "<br><br><br><br><br> ECHO VARIABLES DE LA CLASE: ".$sql."<br>".$idres."-".$iditem."-".$res;
		//echo "<br><br><br><br><br> ECHO".$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result = $conexion->prepare($sql);

		$result->bindParam(':idres',$idres);
		$result->bindParam(':iditem',$iditem);
		$result->bindParam(':idprev',$idprev);
		$result->bindParam(':res',$res);	
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	#METODO INSERTAR ITEMS CUMPLE O NO CUMPLE
	public function inspreo($idprev, $iditem, $res, $descri){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL inspreo(:idprev, :iditem, :res, :descri);";
		//echo "<br><br><br><br><br> ECHO VARIABLES DE LA CLASE: ".$sql."<br>".$idprev."-".$iditem."-".$res;
		//var_dump($descri);

		$result = $conexion->prepare($sql);
		//echo "<br><br><br><br><br> ECHO".$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idprev',$idprev);
		$result->bindParam(':iditem',$iditem);
		$result->bindParam(':res',$res);			
		$result->bindParam(':descri',$descri);			
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

	#METODO PARA TRAER LOS DATOS DEL VEHICULO
	public function veh($idprev){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idveh FROM preoperacionalv";
		$sql .= " WHERE idprev=:idprev";
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
	#Metodo traer items equipo de carretera
	public function selequ(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();		
		$sql = 'SELECT iditem, nomitem FROM item WHERE depite=2';
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
	#Metodo traer items del equipo de proteccion
	public function selpro(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();		
		$sql = 'SELECT iditem, nomitem FROM item WHERE depite=3';
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
	#Metodo listar item dependiendo del tipo delvehiculo con un parametro
	public function lista($depite){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();		
		$sql = 'SELECT iditem, nomitem FROM item WHERE depite=:depite';
		#$sql = "SELECT i.iditem, i.nomitem FROM item as i LEFT JOIN respuesta as r on i.iditem=r.iditem";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':depite',$depite);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}	
?>