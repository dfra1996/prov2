<?php 
class mexepre{
	public function iexepre (){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pre.idprev, pre.idveh, pre.idusu, pre.fecpre, pre.expext, pre.chipper,pre.desequi, pre.kilo, pre.horo, pre.fuga, pre.desfuga, pre.novedad, pre.impre, pre.img,u.nomusu, u.apeusu, u.docid,u.lictran, u.vlictran, v.placaveh, v.docveh, v.soat, v.rtmcod, v.rtmexp, v.venstr, v.tipoveh,vr.nomval AS nomv, pre.nov, pre.imp FROM preoperacionalv AS pre INNER JOIN usuario AS u ON pre.idusu=u.idusu INNER JOIN vehiculo AS v ON pre.idveh=v.idveh INNER JOIN valor as vr ON v.tipoveh=vr.codval ORDER BY pre.fecpre DESC";
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