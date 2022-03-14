<?php 
class mrec{
	#Metodo para seleccionar todas las recolecciones y mostrarlas en la tabla dinamica
	public function selrec(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.nomubi FROM circuito AS c INNER JOIN ubicacion as u ON c.codubi=u.codubi";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	
	public function reco2(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT rec.idrec, rec.usupo, rec.fecini, rec.idrec,rec.idcir, rec.norden, rec.fotini, rec.arbol, rec.fotfin, rec.lat, rec.lng, rec.novedad,u.nomusu, rec.dir,u.apeusu,rec.fecfin, rec.estado, c.nomcir, z.nomzon as mun, zon.nomzon AS zon, urec.nomusu AS uprec, urec.apeusu aprec FROM recoleccion AS rec INNER JOIN usuario AS u ON rec.usupo=u.idusu INNER JOIN circuito AS c ON rec.idcir=c.idcir INNER JOIN zona AS z ON c.idzon=z.idzon INNER JOIN zona AS zon ON z.depzon=zon.idzon LEFT JOIN usuario as urec ON rec.usure=urec.idusu WHERE rec.estado=1 ORDER BY z.nomzon";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo para seleccionar todas las recolecciones y mostrarlas en la tabla dinamica
	public function rec(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT rec.idrec, rec.usupo, rec.fecini, rec.idrec,rec.idcir, rec.norden, rec.fotini, rec.arbol, rec.fotfin, rec.lat, rec.lng, rec.novedad,u.nomusu, rec.dir,u.apeusu,rec.fecfin, rec.estado, c.nomcir, z.nomzon as mun, zon.nomzon AS zon, urec.nomusu AS uprec, urec.apeusu aprec FROM recoleccion AS rec INNER JOIN usuario AS u ON rec.usupo=u.idusu INNER JOIN circuito AS c ON rec.idcir=c.idcir INNER JOIN zona AS z ON c.idzon=z.idzon INNER JOIN zona AS zon ON z.depzon=zon.idzon LEFT JOIN usuario as urec ON rec.usure=urec.idusu";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Metodo traer ZONAS  
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
	#Metodo traer USUARIOS
	public function selusu(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		#$sql = "SELECT c.idcir, c.codubi, c.nomcir, u.nomubi FROM circuito AS c INNER JOIN ubicacion AS u ON c.codubi=u.codubi";
		$sql = "SELECT idusu, nomusu, apeusu FROM usuario";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#INSERTAR RECOLECCION PRIMERA PARTE
	public function insrec($idrec,$usupo, $fecini, $idzon, $dir, $idcir, $norden, $fotini, $cantr, $arbol, $lat, $lng, $estado){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL insrec(:idrec, :usupo, :fecini, :idzon, :dir,:idcir, :norden, :fotini, :cantr,:arbol, :lat, :lng, :estado);";
		echo "<br><br><br><br><br>".$sql;
		$result = $conexion->prepare($sql);
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		$result->bindParam(':idrec',$idrec);
		$result->bindParam(':usupo',$usupo);
		$result->bindParam(':fecini',$fecini);
		$result->bindParam(':idzon',$idzon);
		$result->bindParam(':dir',$dir);
		$result->bindParam(':idcir',$idcir);
		$result->bindParam(':norden',$norden);
		$result->bindParam(':fotini',$fotini);
		$result->bindParam(':cantr',$cantr);
		$result->bindParam(':arbol',$arbol);
		$result->bindParam(':lat',$lat);
		$result->bindParam(':lng',$lng);
		$result->bindParam(':estado',$estado);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();		
	}
	#INSERTAR RECOLECCION SEGUNDA PARTE
	public function insrec2($fotfin,$usure,$novedad,$fecfin,$estado,$idrec){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "UPDATE recoleccion SET fotfin=:fotfin,usure=:usure, novedad=:novedad,fecfin=:fecfin,estado=:estado WHERE idrec=:idrec;";
		echo "<br><br><br><br><br>".$sql;
		$result = $conexion->prepare($sql);	
		$result->bindParam(':fotfin',$fotfin);
		$result->bindParam(':usure',$usure);	
		$result->bindParam(':novedad',$novedad);
		$result->bindParam(':fecfin',$fecfin);
		$result->bindParam(':estado',$estado);
		$result->bindParam(':idrec',$idrec);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();		
	}
}
?>