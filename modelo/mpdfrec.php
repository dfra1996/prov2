<?php 
class mpdfrec{
	#METODO SELECCIONAR DATOS DE RECOLECCION
	public function selrec($idrec){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT rec.idrec, rec.usupo, rec.fecini, rec.idrec,rec.idcir, rec.norden, rec.fotini, rec.arbol, rec.fotfin, rec.lat, rec.lng, rec.novedad,u.idusu,u.nomusu, rec.dir,u.apeusu,rec.fecfin, rec.estado, c.nomcir, z.nomzon as mun, zon.nomzon AS zon, urec.idusu AS idpo,urec.nomusu AS uprec, urec.apeusu aprec FROM recoleccion AS rec INNER JOIN usuario AS u ON rec.usupo=u.idusu INNER JOIN circuito AS c ON rec.idcir=c.idcir INNER JOIN zona AS z ON c.idzon=z.idzon INNER JOIN zona AS zon ON z.depzon=zon.idzon LEFT JOIN usuario as urec ON rec.usure=urec.idusu";
		$sql .= " WHERE idrec=:idrec";

		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idrec',$idrec);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>