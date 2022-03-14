<?php require_once("modelo/seguridad.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MyC</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/styles.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
	<body class="sb-nav-fixed">
		<header>
			<?php 
				$nu = 2;
				$alto = "0px";
				$pg = isset($_REQUEST["pg"]) ? $_REQUEST["pg"]:NULL;
				$pefid = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
				//include ("vista/cabe.php");
			?>			
		</header>
		<!-- Section Menu Interno -->
			<section>
				<?php
					$pefid = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;				
					include("vista/vmen.php");
					require_once 'controlador/ayudas.php';

				?>		
			</section>


		<!-- Contenido -->
		<div id="layoutSidenav">
			<div id="layoutSidenav_content">
				<main>
					<section><?php 
						moscon($pefid,$pg);
					?></section>
				</main>
			</div>
		</div>

		<script src="js/classie.js"></script>
		<script src="js/gnmenu.js"></script>
		<script type="text/javascript" src="js/valida.js"></script> 
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>	 	 

	</body>
</html>