<?php
	//Importando librerías necesarias
	require_once ('funciones.php');
	require_once ('../../framework/dbconf.php');
	require_once ('../../framework/funciones.php');
	require_once ('../../framework/lenguaje.php');
	require_once ('../../framework/PHPExcel/Classes/PHPExcel.php');
	//Iniciando sesión
	session_start();
	$current_language=current_language();
	
	//Obteniendo parámetros
	$curs_para_codi=test_input($_GET['curs_para_codi']);
	$curs_para_mate_codi=test_input($_GET['curs_para_mate_codi']);
	$peri_dist_codi=test_input($_GET['peri_dist_codi']);
	if(isset($_GET['report_logo']))
		$report_logo=test_input($_GET['report_logo']);
	if(isset($_GET['font_size']))
		$font_size=test_input($_GET['font_size']);
	if(isset($_GET['font_type']))
		$font_type=test_input($_GET['font_type']);
	if(isset($_GET['report_logo_minis']))
		$report_logo_minis=test_input($_GET['report_logo_minis']);
	if(isset($_GET['pu']))
		$print_user=test_input($_GET['pu']);
	if(isset($_GET['pfd']))
		$print_full_date=test_input($_GET['pfd']);
	//Variables globales
	$curso_descr = $periodo_descrp = "";
	$cont_retirados=0;
	//Estilo para los bordes de cada celda y las letras
	$styleArray = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            )
	);
        $styleArrayNotaParcial = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DCE6F1')
            )
	);
        $styleArrayFaltasInjustificadas = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FDE9D9')
            )
	);
        $styleArrayRecomendacionesYPlan = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'F2F2F2')
            )
	);
        $styleArrayFont = array(
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            )
	);
        $styleArrayFontEncabezado = array(
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size + 4,
                'bold' => true,
		'name' => $font_type
            )
	);
        $styleArrayC = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'EBF1DE')
            )
	);
        $styleArrayN = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            )
	);
	$styleArrayNPromedio = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E4DFEC')
            )
	);
	$styleArrayNNotaParcial = array(
            'borders' => array(
		'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
            ),
            'font' => array(
		'color' => array('rgb'=>'000000'),
                'size' => $font_size,
		'name' => $font_type
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DCE6F1')
            )
	);
	
	//Archivo de Excel
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()
	->setCreator(para_sist(2))
	->setLastModifiedBy(para_sist(2))
	->setTitle("Acta de calificaciones")
	->setSubject("Acta de calificaciones")
	->setDescription("Acta de calificaciones por parcial y materia.");
	
	//Escala de impresión
	$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(58);
	
	//Horizontal
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	
	//Márgenes
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
	
	$una=true;
	if ($curs_para_mate_codi==-1)
	{   $una=false;
            $curs_para_codi_aux=$curs_para_codi;
	}
	else
	{   $curs_para_codi_aux=-1;
	}
		
	//Consulta de calificaciones
	$sql="{call curs_peri_mate_view (?)}";
	$params = array($curs_para_codi_aux);
	$stmt_all = sqlsrv_query($conn, $sql, $params);
	
	while (($row_all=sqlsrv_fetch_array($stmt_all)) or ($una))
	{   if ($una)
            {   $una=false;
            }
            else
            {   $curs_para_mate_codi=$row_all['curs_para_mate_codi'];
            }
	
            //Consulta de calificaciones
            $sql="{call acta_nota_parc_mate (?,?)}";
            $params = array($curs_para_mate_codi, $peri_dist_codi);
            $stmt = sqlsrv_query($conn, $sql, $params);
	
            if( $stmt === false )
            {   echo "Error in executing statement .\n";
                exit ();
            }
		
            if (sqlsrv_has_rows($stmt))
            {   //Columnas y filas
				$row=array();
                unset($datos);
                unset($aux_col);
                unset($aux_fil);
		$i=0;
		while ($row = sqlsrv_fetch_array($stmt))
		{   $aux_col[$i][0] = $row['peri_dist_codi'];
                    //$aux_col[$i][1] = $row['peri_dist_abre'];
                    $aux_col[$i][1] = $row['peri_dist_deta'];
                    //$aux_col[$i][2] = $row['nota'];
                    $aux_fil[$i][0] = $row['alum_curs_para_mate_codi'];
                    $aux_fil[$i][1] = $row['alum_apel'];
                    $aux_fil[$i][2] = $row['alum_nomb'];
                    $aux_fil[$i][3] = $row['alum_est_det'];
                    $datos[]=$row;
                    $i++;
		}
		
		//Columnas finales
		$columnas = arrayUnique ($aux_col);
		
		//Filas finales
		$filas = arrayUnique ($aux_fil);
		
		//Quimestre y Parcial
		$params = array($peri_dist_codi);
		$sql="{call peri_dist_peri_codi (?)}";
		$cab_view = sqlsrv_query($conn, $sql, $params);  
		$cab_row=sqlsrv_fetch_array($cab_view);
		
		//Datos del profesor
		$params = array($curs_para_mate_codi);
		$sql="{call prof_curs_para_mate_cons (?)}";
		$dat_profesor = sqlsrv_query($conn, $sql, $params);  
		$prof_row=sqlsrv_fetch_array($dat_profesor);
		
		//Datos de la materia
		$params = array($curs_para_mate_codi);
		$sql="{call curs_para_mate_info(?)}";
		$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
		$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
		
		//Datos del curso
		$params = array($curs_para_codi);
		$sql="{call curs_para_info(?)}";
		$curs_info = sqlsrv_query($conn, $sql, $params);
		$row_curs_info = sqlsrv_fetch_array($curs_info);
		
		//Tabla de notas cualitativas
		$params = array($row_curs_peri_info['nota_refe_cab_tipo'], $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
		
		//Creando archivo de Excel
		//Nombre de la Institución
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, pasarMayusculas(show_this_phrase(20000006)) . ' '.para_sist(3));
		$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($styleArrayFontEncabezado);
		
		//Periodo distribución
		$periodo_descrp=$cab_row['nivel_1'].', '.$cab_row['nivel_2'];
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A2:Q2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 2, pasarMayusculas(show_this_phrase(20000002)) . '. '.$periodo_descrp);
		$objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleArrayFontEncabezado);
		
		//Año lectivo
		$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->mergeCells('A3:Q3');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 3, pasarMayusculas(show_this_phrase(20000005)) . ' '.$_SESSION['peri_deta']);
		$objPHPExcel->getActiveSheet()->getStyle('A3:Q3')->applyFromArray($styleArrayFontEncabezado);
		
		// Setea altura de fila 1,2,3, es decir, del encabezado.
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);
                
		$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);
				
		//Nivel
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 4, pasarMayusculas(show_this(10000004)).': '.$row_curs_info['nive_deta'].'(Tutor: '.$row_curs_info['tutor'].')');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'4')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'4')->applyFromArray($styleArrayFont);

		//Curso
		$curso_descr=$row_curs_peri_info['curs_deta'].' '.$row_curs_peri_info['para_deta'];
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 5, $curso_descr);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'5')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'5')->applyFromArray($styleArrayFont);

		//Asignatura
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 6, pasarMayusculas(show_this(10000005)).': '.$row_curs_peri_info['mate_deta']);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'6')->applyFromArray($styleArrayFont);
		
		if($print_full_date=='true')
		{	//Fecha
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, 4, PrimeraMayuscula(show_this(10000003)).': '.get_fecha_ciudad($current_language,'true','true'));
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'4')->getFont(1)->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'4')->applyFromArray($styleArrayFont);
		}
		else
		{	//Fecha
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, 4, PrimeraMayuscula(show_this(10000003)).': '.get_fecha_ciudad($current_language));
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'4')->getFont(1)->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'4')->applyFromArray($styleArrayFont);
		}
		if(!isset($_SESSION['usua_codi']))
		{	$usuario=$_SESSION['prof_usua'];
		}else
		{	$usuario=$_SESSION['usua_codi'];
		}
		if($print_user=='true')
		{
			//Usuario que genera
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, 5, PrimeraMayuscula(show_this(10000001)) . ': ' . $usuario);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'5')->getFont(1)->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'5')->applyFromArray($styleArrayFont);			
		}

		//Profesor
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, 6, PrimeraMayuscula(show_this(10000002)).': '.$prof_row["prof_nomb"]." ".$prof_row["prof_apel"]);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'6')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(14).'6')->applyFromArray($styleArrayFont);
		
		//Matriz de calificaciones
		//Número
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 7,'No.');
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(5);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(0).'7:'.PHPExcel_Cell::stringFromColumnIndex(0).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).'7:'.PHPExcel_Cell::stringFromColumnIndex(0).'8')->applyFromArray($styleArray);
		
		//Nombre
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 7, pasarMayusculas(show_this(10000015)));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(58.85);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7')->getFont(1)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex(1).'7:'.PHPExcel_Cell::stringFromColumnIndex(1).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).'7:'.PHPExcel_Cell::stringFromColumnIndex(1).'8')->applyFromArray($styleArray);
		
		//Rubros
		$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(50);
		$w=0;
		for ($i=0;$i<count($columnas);$i++)
                {
                    $w+=2;
                    $objPHPExcel->getActiveSheet()->mergeCells(cellsToMergeByColsRow($w, $w+1, 7));
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, $columnas[$i][1]);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(10);
                    $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w+1))->setWidth(8.5);
                    
                    //Bordes
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle(cellsToMergeByColsRow($w, $w+1, 7))->applyFromArray($styleArray);
                }

		//Faltas injustificadas
		$w+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, pasarMayusculas(show_this_phrase(20000010)));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(10);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArrayFaltasInjustificadas);
		
		//Recomendaciones
		$w++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, pasarMayusculas(show_this(10000016)));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArrayRecomendacionesYPlan);
	
		//Plan de mejoramiento
		$w++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 7, pasarMayusculas(show_this_phrase(20000009)));
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setTextRotation(90);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($w))->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7')->getFont($w)->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'7:'.PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArrayRecomendacionesYPlan);
		
		//Cualitativa - Numérico
		$w=0;
		for ($i=0;$i<count($columnas);$i++)
		{
                    $w+=2;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 8, 'C');
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->getFont($w)->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    //Bordes
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArray);
			
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, 8, 'N');
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->getFont($w)->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    //Bordes
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->applyFromArray($styleArray);
		} 
		$w+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, 8, 'C');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->applyFromArray($styleArrayC);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->getFont($w)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, 8, 'N');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->applyFromArray($styleArrayNNotaParcial);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->getFont($w)->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).'8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
	
		/*Inicio*/
		$sum_curso=0;
		$prom_curso=0;
		$cont_alumnos=0;
	 	unset($notas_prom);
                for ($i=0;$i<count($filas);$i++) 
                {	$asterisco="";
					$retirado_switch=false;
					if ($filas[$i][3]=='RETIRADO') 
					{	$cont_retirados++;
						$asterisco = "*";
						$retirado_switch = true;
					}
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $i+9, $i+1);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $i+9, $asterisco . $filas[$i][1].' '.$filas[$i][2]);
                    //Bordes
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+9))->applyFromArray($styleArray);
                    //Bordes
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(1).($i+9))->applyFromArray($styleArray);

                    $acum_parcial=0;
                    $cont_parcial=0;
                    $w=0;
                    for ($j=0;$j<count($columnas);$j++) 
                    {
						$w+=2;
						$nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_curs_para_mate_codi', 'peri_dist_codi');//notas de las 5 columnas
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+9, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota));
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, $i+9, ($row_curs_peri_info['nota_refe_cab_tipo']=='C'?number_format($nota,2,'.',','):'-'));
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$cont_parcial++;
						$acum_parcial=$acum_parcial+$nota;
                        //Bordes
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

						//Bordes
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    }
                    $nota_final=$acum_parcial/$cont_parcial;//promedio parcial

					//Faltas injustificadas
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+2).($i+9))->applyFromArray($styleArray);
			
                    //Recomendaciones
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+3).($i+9))->applyFromArray($styleArray);
			
                    //Plan mejoramiento
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+4).($i+9))->applyFromArray($styleArray);
					
					if($retirado_switch==false)
					{
						$cont_alumnos++;
						$sum_curso=$sum_curso+$nota_final;
						$notas_prom[]=$nota_final;
					}
                }
                $prom_curso=$sum_curso/$cont_alumnos;
		//El promedio del curso solo se presenta si es una materia cuantitativa
		if($cont_retirados>0)
		{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $i+9, "* " . show_this_phrase(20000007));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $i+10, "** " . show_this_phrase(20000003));
		}
		if ($row_curs_peri_info['nota_refe_cab_tipo']=='C')
		{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w-3, $i+9, show_this_phrase(20000012).':');
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w-3).($i+9))->getFont($w-3)->setBold(true);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w+1, $i+9, number_format(round($prom_curso,2),2,'.',','));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getFont($w+1)->setBold(true);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($w, $i+9, notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$prom_curso));
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w).($i+9))->getFont($w)->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($w+1).($i+9))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		}
		//Cuadro de resumen
		$objPHPExcel->getActiveSheet()->mergeCells('A'.($i+11).':B'.($i+11));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, ($i+11), pasarMayusculas(show_this(10000018)));
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(1).($i+11))->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C'.($i+11).':D'.($i+11));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, ($i+11), pasarMayusculas(show_this(10000019)));
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(2).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(3).($i+11))->applyFromArray($styleArray);
		 
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, ($i+11), 'ABRE.');
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).($i+11))->applyFromArray($styleArray);
		 
		$objPHPExcel->getActiveSheet()->mergeCells('F'.($i+11).':G'.($i+11));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, ($i+11), pasarMayusculas(show_this_phrase(20000013)));
		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(5).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(6).($i+11))->applyFromArray($styleArray);
		 
		$objPHPExcel->getActiveSheet()->mergeCells('H'.($i+11).':I'.($i+11));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, ($i+11), pasarMayusculas(show_this(10000017)));
		//BORDES
		$objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(6).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(8).($i+11))->applyFromArray($styleArray);

		while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) 
		{ 
                    $i++;
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.($i+11).':B'.($i+11));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, ($i+11), $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']);
                    //BORDES
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(0).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(1).($i+11))->applyFromArray($styleArray);

                    $objPHPExcel->getActiveSheet()->mergeCells('C'.($i+11).':D'.($i+11));
                    //El rango de calificación solo se muestra si la materia es cuantitativa
                    if ($row_curs_peri_info['nota_refe_cab_tipo']=='C')
                    {   
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, ($i+11), number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], 2, '.', '').' - '.(number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_fin'], 2, '.', '')));
                    }
                    //BORDES
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(2).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(3).($i+11))->applyFromArray($styleArray);
			
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, ($i+11), $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']);
                    //BORDES
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(4).($i+11))->applyFromArray($styleArray);

                    $objPHPExcel->getActiveSheet()->mergeCells('F'.($i+11).':G'.($i+11));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, ($i+11), contar_notas_num($notas_prom, $row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], $row_nota_peri_cual_tipo_view['nota_peri_cual_fin']));
                    //BORDES
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(5).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(6).($i+11))->applyFromArray($styleArray);
			
                    $objPHPExcel->getActiveSheet()->mergeCells('H'.($i+11).':I'.($i+11));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, ($i+11), number_format(contar_notas_porc($notas_prom, $row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], $row_nota_peri_cual_tipo_view['nota_peri_cual_fin']),2, '.', '').' %');
                    //Bordes
                    $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(7).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(8).($i+11))->applyFromArray($styleArray);
                }
				//Logotipo del ministerio
				$first_logo_w="";
				if($report_logo=='true')
				{
					$maxWidth = 150;
					$maxHeight = 75;
					$objDrawing = new PHPExcel_Worksheet_Drawing();
					$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
					$objDrawing->setName("Logo escuela");
					$objDrawing->setDescription("Logo escuela");
					$objDrawing->setPath('../'.$_SESSION['ruta_foto_logo_web']);
					$objDrawing->setCoordinates('A1');
					$objDrawing->setHeight($maxHeight);
					//$objDrawing->setWidth($maxWidth);
					$offsetX =$maxWidth - $objDrawing->getWidth();
					$objDrawing->setOffsetX($offsetX);	
					$first_logo_w=$maxWidth+$objDrawing->getWidth();
				}
				if($report_logo_minis=='true')
				{
					$maxWidth = 100;
					$maxHeight = 75;
					$objDrawing = new PHPExcel_Worksheet_Drawing();
					$objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
					$objDrawing->setName("Logo Ministerio");
					$objDrawing->setDescription("Logo Ministerio");
					$objDrawing->setPath('../'.$_SESSION['ruta_foto_logo_minis_long']);
					$objDrawing->setCoordinates('B1');
					$objDrawing->setHeight($maxHeight);
					//$objDrawing->setWidth($maxWidth);
					$offsetX = $first_logo_w;
					$objDrawing->setOffsetX($offsetX);	
				}
            }
            else
            {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, 1, show_this_phrase(20000004));
            }
		 
            /*Fin*/
			
            // Setea altura de fila 7.
            $objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(120);
            
            // Renombrar Hoja
            $objPHPExcel->getActiveSheet()->setTitle('Acta parcial');
			
			//Oculta lineas no sombreadas
			$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	
            // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
            $objPHPExcel->setActiveSheetIndex(0);
			
			// Establecer seguridad para que no se pueda manipular el excel.
			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setPassword('Educ@link5');
			
            // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.show_this_phrase(20000002).' '.  $periodo_descrp. ' '.pasarMayusculas($curso_descr).'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
	}
	
	function cellsToMergeByColsRow($start = NULL, $end = NULL, $row = NULL)
	{   $merge = 'A1:A1';
            if($start>=0 && $end>=0 && $row>0)
            {
                $start = PHPExcel_Cell::stringFromColumnIndex($start);
                $end = PHPExcel_Cell::stringFromColumnIndex($end);
                $merge = "$start{$row}:$end{$row}";
            }
            return $merge;
	}