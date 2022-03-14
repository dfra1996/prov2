<!DOCTYPE html>
<html>
<head>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MyC</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
	<body>
		<header>
		<?php 
			$pg = isset($_REQUEST["pg"]) ? $_REQUEST["pg"]:NULL;
			$pefid = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
		?>			
		</header>
		<!-- Contenido -->
		<section>
			<?php 
				if($pg=="200" OR !$pg)
					include ("vista/vini.php");
				elseif($pg=="201")
			 		include ("vista/vreg.php"); 
				elseif($pg=="105")
			 		include ("vista/vmail.php");
				elseif($pg=="110")
			 		include ("vista/vcc.php");
				elseif($pg=="111")
			 		include ("vista/vcod.php");?>
		</section>
		<footer>
			<?php include ("vista/pie.php"); ?>
		</footer>
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script type="text/javascript" src="js/valida.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	    <script src="js/scripts.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
	    <script src="assets/demo/chart-area-demo.js"></script>
	    <script src="assets/demo/chart-bar-demo.js"></script>
	    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	    <script src="js/datatables-simple-demo.js"></script>	 	
	</body>
</html>