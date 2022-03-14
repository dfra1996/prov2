<?php 
class mpdfprev{
	#METODO SELECCIONAR DATOS DE UN PREOPERACIONAL POR IDPREV
	public function selpre1($idprev){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pre.idprev, pre.idveh, pre.idusu, pre.fecpre, pre.expext, pre.chipper,pre.desequi, pre.kilo, pre.horo, pre.fuga, pre.desfuga, pre.nov, pre.novedad, pre.imp, pre.impre, pre.img,u.nomusu, u.apeusu, u.docid,u.lictran, u.vlictran, v.placaveh, v.docveh, v.soat, v.rtmcod, v.rtmexp, v.venstr, v.tipoveh,vr.nomval AS nomv FROM preoperacionalv AS pre INNER JOIN usuario AS u ON pre.idusu=u.idusu INNER JOIN vehiculo AS v ON pre.idveh=v.idveh INNER JOIN valor as vr ON v.tipoveh=vr.codval";
		$sql .= " WHERE idprev=:idprev";

		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idprev',$idprev);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#FUNCION TRAER ITEMS EQUIPO DE CARRETERA
	public function itemse($idprev){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pre.idprev, pre.iditem, pre.res, i.nomitem, pre.descri FROM preoperacionalres AS pre INNER JOIN item AS i ON pre.iditem=i.iditem WHERE pre.idprev=:idprev AND NOT pre.res=3 AND NOT pre.res=4 ORDER BY pre.iditem";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idprev',$idprev);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	#Funcion para traer items calificados del preoperacional
	public function itemses($idprev){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pre.idprev, pre.iditem, pre.res, i.nomitem, i.iditem, pre.descri FROM preoperacionalres AS pre INNER JOIN item AS i ON pre.iditem=i.iditem WHERE pre.idprev=:idprev AND NOT pre.res=1 AND NOT pre.res=2 ORDER BY pre.iditem";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idprev',$idprev);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}



}
?>