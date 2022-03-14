<?php
class mveh{
	//Funcion Mostrar datos vehiculos
	public function selveh(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT v.idveh, v.tipoveh , v.placaveh,v.ciuexp, ubi.nomubi as ciu,v.modelo, v.marca,m.nomval as mar, v.docveh, v.fecmat, v.color, v.tiposer, ti.nomval as tipo,v.certdi, v.certizaje, v.codop, v.vencodop, so.nomval as so,v.empsoat, v.soat, v.rtmcod, v.rtmexp, v.segcont, v.vensc, v.segecont, v.vensecont, v.emptr,tr.nomval as tor, v.venstr, v.extracto, v.revpre, v.restriccion,res.nomval as rest FROM vehiculo AS v LEFT JOIN valor AS t ON v.tipoveh=t.codval LEFT JOIN ubicacion AS ubi ON v.ciuexp=ubi.codubi LEFT JOIN valor AS m on v.marca=m.codval LEFT JOIN valor AS ti ON v.tiposer=ti.codval LEFT JOIN valor as so ON v.empsoat=so.codval LEFT JOIN valor as tr ON v.emptr=tr.codval LEFT JOIN valor as res ON v.restriccion=res.codval";
		//echo "<br> <br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Funcion Mostrar datos de un solo vehiculo
	public function selveh1($idveh){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT v.idveh, v.tipoveh , v.placaveh,v.ciuexp, ubi.nomubi as ciu,v.modelo, v.marca,m.nomval as mar, v.docveh, v.fecmat, v.color, v.tiposer, ti.nomval as tipo,v.certdi, v.certizaje, v.codop, v.vencodop, so.nomval as so,v.empsoat, v.soat, v.rtmcod, v.rtmexp, v.segcont, v.vensc, v.segecont, v.vensecont, v.emptr,tr.nomval as tor, v.venstr, v.extracto, v.revpre, v.restriccion,res.nomval as rest FROM vehiculo AS v LEFT JOIN valor AS t ON v.tipoveh=t.codval LEFT JOIN ubicacion AS ubi ON v.ciuexp=ubi.codubi LEFT JOIN valor AS m on v.marca=m.codval LEFT JOIN valor AS ti ON v.tiposer=ti.codval LEFT JOIN valor as so ON v.empsoat=so.codval LEFT JOIN valor as tr ON v.emptr=tr.codval LEFT JOIN valor as res ON v.restriccion=res.codval";
		$sql.= " WHERE idveh=:idveh";
		#echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idveh',$idveh);
		#echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Metodo para insertar un nuevo circuito o actualizar uno ya existente
	public function insveh($idveh, $tipoveh, $placaveh, $ciuexp, $mdl, $marca, $docveh, $fecmat, $color, $tiposer, $certdi, $certizaje, $codop, $vencodop, $empsoat, $soat, $rtmcod, $rtmexp, $segcont, $vensc, $segecont, $vensecont, $emptr, $venstr, $extracto, $revpre, $restriccion){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL insveh(:idveh, :tipoveh, :placaveh, :ciuexp, :mdl, :marca, :docveh, :fecmat, :color, :tiposer, :certdi, :certizaje, :codop, :vencodop, :empsoat, :soat, :rtmcod, :rtmexp, :segcont, :vensc, :segecont, :vensecont, :emptr, :venstr, :extracto, :revpre, :restriccion);";
		#echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		#echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idveh',$idveh);
		$result->bindParam(':tipoveh',$tipoveh);
		$result->bindParam(':placaveh',$placaveh);
		$result->bindParam(':ciuexp',$ciuexp);
		$result->bindParam(':mdl',$mdl);
		$result->bindParam(':marca',$marca);
		$result->bindParam(':docveh',$docveh);
		$result->bindParam(':fecmat',$fecmat);
		$result->bindParam(':color',$color);
		$result->bindParam(':tiposer',$tiposer);
		$result->bindParam(':certdi',$certdi);
		$result->bindParam(':certizaje',$certizaje);
		$result->bindParam(':codop',$codop);
		$result->bindParam(':vencodop',$vencodop);
		$result->bindParam(':empsoat',$empsoat);
		$result->bindParam(':soat',$soat);
		$result->bindParam(':rtmcod',$rtmcod);
		$result->bindParam(':rtmexp',$rtmexp);
		$result->bindParam(':segcont',$segcont);
		$result->bindParam(':vensc',$vensc);
		$result->bindParam(':segecont',$segecont);
		$result->bindParam(':vensecont',$vensecont);
		$result->bindParam(':emptr',$emptr);
		$result->bindParam(':venstr',$venstr);
		$result->bindParam(':extracto',$extracto);
		$result->bindParam(':revpre',$revpre);
		$result->bindParam(':restriccion',$restriccion);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
# INSERTAR PQR	
	public function inspqr($idpqr,$pg,$idusu,$msn){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL inspqr(:idpqr,:pg,:idusu,:msn);";
		#echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		#echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idpqr',$idpqr);
		$result->bindParam(':pg',$pg);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':msn',$msn);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	#SELECCIONAR TIPO DE VEHICULO
	public function seltveh(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codval, iddom, nomval, parval FROM valor WHERE iddom = 1";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#SELECCIONAR MARCA DE VEHICULO
	public function selmarv(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codval, iddom, nomval, parval FROM valor WHERE iddom = 4";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#SELECCIONAR TIPO DE SERVICIO
	public function seltser(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codval, iddom, nomval, parval FROM valor WHERE iddom = 7";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}	
	#SELECCIONAR EMPRESA ASEGURADORA
	public function seleso(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codval, iddom, nomval, parval FROM valor WHERE iddom = 5";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#SELECCIONAR tipo de tramite
	public function seltra(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codval, iddom, nomval, parval FROM valor WHERE iddom = 8";
		//echo "<br><br><br><br>".$sql."<br><br>";
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