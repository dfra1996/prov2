<?php 
class mpqr{
	#Metodo mostrar PQR'S
	public function dtpqr(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = 'SELECT p.idpqr, p.idpag, pg.pagnom ,p.idusu, p.msn, concat(u.nomusu," ",u.apeusu) AS nomm FROM pqr AS p INNER JOIN pagina AS pg ON p.idpag=pg.pagid INNER JOIN usuario AS u ON p.idusu=u.idusu';
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