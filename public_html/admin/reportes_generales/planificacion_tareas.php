<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='planificacion_tareas.pdf'");
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once('../../framework/EnLetras.php');
	require_once('../../framework/dbconf.php');	
	require_once('../../framework/funciones.php');		
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);


	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			$this->Image($logo_web, 95, 8, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
	
		public function Footer() 
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
//			$this->Cell(0, 10, 'Usuario que imprimió: '.strtoupper($_SESSION["usua_codi"]).'     Fecha/Hora impresión: '.date("d/m/Y H:m").'     Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}
	 
	$pageDimension = array('500,300');
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	$agen_codi=$_GET['agen_codi'];
    $curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
	
	//Datos del profesor
	$params = array($curs_para_mate_prof_codi);
	$sql="{call curs_para_mate_prof_info (?)}";
	$dat_profesor = sqlsrv_query($conn, $sql, $params);
	$prof_row=sqlsrv_fetch_array($dat_profesor);

    //Datos del agenda
    $params = array($agen_codi);
    $sql="{call agen_info (?)}";
    $agen_info = sqlsrv_query($conn, $sql, $params);
    $row_agen_info=sqlsrv_fetch_array($agen_info);

	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	$fecha_hoy=strftime("%d de %B de %Y");


    /*Tabla con información general*/
    $tbl_info='<table width="100%">';
    $tbl_info.='<tr>';
    $tbl_info.='<td colspan="2" align="center" class="titulos">'.para_sist(36).' '.para_sist(3).'<br/></td>';
    $tbl_info.='</tr>';
    $tbl_info.='<tr>';
    $tbl_info.='<td colspan="2" align="center" class="titulos" >PLANIFICACIÓN DE TAREAS ESCOLARES</td>';
    $tbl_info.='</tr>';
    $tbl_info.='<tr>';
    $tbl_info.='<td align="center" class="titulos" colspan="2" >AÑO LECTIVO '.$_SESSION['peri_deta'].'<br></td>';
    $tbl_info.='</tr>';
    $tbl_info.='<tr>';
    $tbl_info.='<td align="left" class="titulos" >ASIGNATURA: '.mb_strtoupper($prof_row['mate_deta'],'UTF-8').'</td>';
    $tbl_info.='<td align="left" class="titulos" >DOCENTE: '.mb_strtoupper($prof_row['prof_apel'].' '.$prof_row['prof_nomb'],'UTF-8').'</td>';
    $tbl_info.='</tr>';
    $tbl_info.='<tr>';
    $tbl_info.='<td align="left" class="titulos" colspan="2">'.mb_strtoupper($prof_row['curs_deta'].' "'.$prof_row['para_deta'].'" '.$prof_row['nive_deta'],'UTF-8').'</td>';
    $tbl_info.='</tr>';
    $tbl_info.='<tr>';
    $tbl_info.='<td align="left" class="titulos" >FECHA: '.$fecha_hoy.'</td>';
    $tbl_info.='<td align="left" class="titulos" >JORNADA: '.mb_strtoupper($prof_row['jorn_deta'],'UTF-8').'</td>';
    $tbl_info.='</tr>';
    $tbl_info.='<tr>';

    $tbl_info.='</tr>';
    $tbl_info.='</table>';


    $ancho=25;

	$tbl_agenda='<table border="1" cellpadding="5" cellspacing="0" align="center" width="100%">';
	$tbl_agenda.="<tr>";
	$tbl_agenda.='<td class="titulos" align="left" width="'.$ancho.'%">CRITERIO DE EVALUACIÓN </td>';
	$tbl_agenda.='<td class="texto" width="'.(100-$ancho).'%">'.$row_agen_info['agen_crit'].'</td>';
	$tbl_agenda.='</tr>';
    $tbl_agenda.="<tr>";
    $tbl_agenda.='<td class="titulos" align="left" width="'.$ancho.'%">INDICADOR DE EVALUACIÓN </td>';
    $tbl_agenda.='<td class="texto" width="'.(100-$ancho).'%">'.$row_agen_info['agen_indi'].'</td>';
    $tbl_agenda.='</tr>';
    $tbl_agenda.="<tr>";
    $tbl_agenda.='<td class="titulos" align="left" width="'.$ancho.'%">TAREA: </td>';
    $tbl_agenda.='<td class="texto" width="'.(100-$ancho).'%">'.$row_agen_info['agen_titu'].'</td>';
    $tbl_agenda.='</tr>';
    $tbl_agenda.="<tr>";
    $tbl_agenda.='<td class="titulos" align="left" width="'.$ancho.'%">TIEMPO: </td>';
    $tbl_agenda.='<td class="texto" width="'.(100-$ancho).'%">'.$row_agen_info['agen_tiempo'].' horas </td>';
    $tbl_agenda.='</tr>';
    $tbl_agenda.="<tr>";
    $tbl_agenda.='<td class="titulos" align="left" width="'.$ancho.'%">MATERIALES: </td>';
    $tbl_agenda.='<td class="texto" width="'.(100-$ancho).'%">'.$row_agen_info['agen_mater'].'</td>';
    $tbl_agenda.='</tr>';
    $tbl_agenda.="<tr>";
    $tbl_agenda.='<td class="titulos" align="left" width="'.$ancho.'%">ACTIVIDADES: </td>';
    $tbl_agenda.='<td class="texto" width="'.(100-$ancho).'%">'.$row_agen_info['agen_deta'].'</td>';
    $tbl_agenda.='</tr>';
    $tbl_agenda.="<tr>";
    $tbl_agenda.='<td class="titulos" align="left" width="'.$ancho.'%">RETROALIMENTACIÓN: </td>';
    $tbl_agenda.='<td class="texto" width="'.(100-$ancho).'%">'.$row_agen_info['agen_retr'].'</td>';
    $tbl_agenda.='</tr>';
    $tbl_agenda.='</table>';

	

	
	/*Firmas*/
	$tbl_firmas='<table width="100%">';
	$tbl_firmas.='<tr>';
	$tbl_firmas.='<td class="firma" width="50%">_______________________________________</td>';
	$tbl_firmas.='<td class="firma" width="50%">_______________________________________</td>';
	$tbl_firmas.='</tr>';
	$tbl_firmas.='<tr>';
	$tbl_firmas.='<td class="firma" width="50%">DOCENTE</td>';
	$tbl_firmas.='<td class="firma" width="50%">DIRECTOR/A DE ÁREA</td>';
	$tbl_firmas.='</tr>';
	$tbl_firmas.='</table>';
		
	$tbl=<<<EOF
	<style>
	.encabezados
	{
		text-align: center;
		font-family: sans-serif;
		font-size: 8px;
		font-weight: bold;
		line-height: 150%;
	}
	.texto
	{
		font-size: 12px;
		text-align: left;
		line-height: 130%;
		font-family: sans-serif;
		letter-spacing: 0.5px;
	}
	.titulos
	{
		text-align: left;
		font-family: sans-serif;
		font-size: 12px;
		font-weight: bold;
		letter-spacing: 0.5px;
	}
	.calificaciones
	{
		font-size: 10px;
		text-align: center;
		line-height: 130%;
		font-family: sans-serif;
	}
	.firma
	{
		font-size: 10px;
		font-weight: bold;
		text-align: center;
		font-family: sans-serif;
	}
	</style>
	<br/>
	{$tbl_info}
	<br/><br/><br/><br/>
	{$tbl_agenda}
	<br/><br/><br/><br/><br/><br/>
	{$tbl_firmas}
EOF;
	$pdf->AddPage();
	$pdf->writeHTML($tbl, true, false, false, false, '');
	$pdf->Output('planificacion_tareas.pdf', 'I');
	//echo htmlentities($tbl);
?>