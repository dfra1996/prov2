<?php
	//Incluimos librería y archivo de conexión
	require'PHPExcel/Classes/PHPExcel.php';	
	require'conexion.php';
	//Consulta
	$sql = "SELECT pre.idprev, pre.idveh, pre.idusu, pre.fecpre, pre.expext, pre.chipper,pre.desequi, pre.kilo, pre.horo, pre.fuga, pre.desfuga, pre.novedad, pre.impre, pre.img,u.nomusu, u.apeusu, u.docid,u.lictran, u.vlictran, v.placaveh, v.docveh, v.soat, v.rtmcod, v.rtmexp, v.venstr, v.tipoveh,vr.nomval AS nomv, pre.nov, pre.imp FROM preoperacionalv AS pre INNER JOIN usuario AS u ON pre.idusu=u.idusu INNER JOIN vehiculo AS v ON pre.idveh=v.idveh INNER JOIN valor as vr ON v.tipoveh=vr.codval ORDER BY pre.fecpre DESC";
	$resultado = $mysqli->query($sql);
	$fila = 7; //Establecemos en que fila inciara a imprimir los datos
	$gdImage = imagecreatefrompng('img/myc.png');//Logotipo
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("UseR MYC")->setDescription("PREOPERACIONALES");
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Listado PREOPERACIONALES");
	$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
	$objDrawing->setName('Logotipo');
	$objDrawing->setDescription('Logotipo');
	$objDrawing->setImageResource($gdImage);
	$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
	$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
	$objDrawing->setHeight(100);
	$objDrawing->setCoordinates('F1');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	$estiloTituloReporte = array(
    'font' => array(
	'name'      => 'Arial',
	'bold'      => true,
	'italic'    => false,
	'strike'    => false,
	'size' =>16
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_NONE
	)
    ),
    'alignment' => array(
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	$estiloTituloColumnas = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => '538DD5')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    'font' => array(
	'name'  => 'Arial',
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
	'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	));
	$objPHPExcel->getActiveSheet()->getStyle('A1:P6')->applyFromArray($estiloTituloReporte);
	#Estilo titulo tabla
	$objPHPExcel->getActiveSheet()->getStyle('A6:P6')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'LISTADO PREOPERACIONALES');
	$objPHPExcel->getActiveSheet()->mergeCells('B3:F3');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'ID');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'FECHA Y HORA');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'CONDUCTOR');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'VEHICULO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'TIPO DE VEHICULO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'VENCIMIENTO EXTINTOR');	
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
	$objPHPExcel->getActiveSheet()->setCellValue('G6', 'NOVEDADES EQUIPO DE CARRETERA');		
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValue('H6', 'VEHICULO CHIPPER');		
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);	
	$objPHPExcel->getActiveSheet()->setCellValue('I6', 'KILOMETRAJE');	
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$objPHPExcel->getActiveSheet()->setCellValue('J6', 'HOROMETRO');	
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('K6', 'FUGAS');	
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
	$objPHPExcel->getActiveSheet()->setCellValue('L6', 'DESCRIPCION FUGA');	
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('M6', 'NOVEDADES');
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
	$objPHPExcel->getActiveSheet()->setCellValue('N6', 'DESCRIPCION NOVEDADES');
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('O6', 'REPARACIONES');	
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
	$objPHPExcel->getActiveSheet()->setCellValue('P6', 'DESCRIPCION REPARACIONES');					
	//	$sql = "SELECT idprev, idveh, idusu, fecpre FROM preoperacionalv";
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = $resultado->fetch_assoc()){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['idprev']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['fecpre']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['nomusu'].' '.$rows['apeusu']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['placaveh']);
		//$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, '=C'.$fila.'*D'.$fila);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['nomv']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['expext']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['desequi']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $rows['chipper']);		
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $rows['kilo']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $rows['horo']);
		if($rows['fuga']==1)
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, 'SI');
		else
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, 'NO');
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $rows['desfuga']);

		if($rows['nov']==1)
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, 'SI');
		else
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, 'NO');
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $rows['novedad']);
		if($rows['imp']==1)
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, 'SI');
		else
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, 'NO');
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $rows['impre']);				

		
		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
	$fila = $fila-1;
	
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:P".$fila);
	$filaGrafica = $fila+2;
	// definir origen de los valores
	$values = new PHPExcel_Chart_DataSeriesValues('Number', 'FUGAS! $K$7:$K$'.$fila);
	// definir origen de los rotulos
	$categories = new PHPExcel_Chart_DataSeriesValues('String', 'FUGAS! $K$7:$K$'.$fila);
	// definir  gráfico
	$series = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_BARCHART, // tipo de gráfico
	PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,
	array(0),
	array(),
	array($categories), // rótulos das columnas
	array($values) // valores
	);
	$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
	// inicializar gráfico
	$layout = new PHPExcel_Chart_Layout();
	$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
	// inicializar o gráfico
	$chart = new PHPExcel_Chart('exemplo', null, null, $plotarea);
	// definir título do gráfico
	$title = new PHPExcel_Chart_Title(null, $layout);
	$title->setCaption('Gráfico PHPExcel Chart Class');
	// definir posiciondo gráfico y título
	$chart->setTopLeftPosition('F'.$filaGrafica);
	$filaFinal = $filaGrafica + 10;
	$chart->setBottomRightPosition('E'.$filaFinal);
	$chart->setTitle($title);
	// adicionar o gráfico à folha
	$objPHPExcel->getActiveSheet()->addChart($chart);
	$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	// incluir gráfico
	//$writer->setIncludeCharts(TRUE);
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="PREOPERACIONALV.xlsx"');
	header('Cache-Control: max-age=0');
	$writer->save('php://output');
?>