<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('constants.php');
require_once('view.php');
require_once('model.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('../../finan/general/model.php');
require_once('../../finan/categorias/model.php');
require_once('../../finan/items/model.php');
require_once('../../finan/pagos/model.php');

function handler() {
	
    $reporte 	= get_mainObject('Rep_facturas');
	$pago 		= get_mainObject('Pagos');
    $permiso 	= get_mainObject('General');
	$categoria 	= get_mainObject('Categoria');
	$item 		= get_mainObject('Item');
	$periodo 	= get_mainObject('Periodo');
	$periodos	= get_mainObject('General');
	$grupEcon 	= get_mainObject('GrupoEconomico');
	$usuariosFinancieros = get_mainObject('General');//
	$reporte_aux= get_mainObject('General');
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}
    $event = get_actualEvents( array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL, VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $user_data = get_frontData();

    switch ($event) {
        case PRINTREPVISOR:
			$caja_cier_codigo = $user_data["cmb_usuario_cajero"];
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-deuda" src="'.$user_data['url'].'"></iframe>
					
				  </div>';
			
			break;
		case PRINTREP_CIERRES:
			header("Content-type:application/pdf");
          	header("Content-Disposition:attachment;filename='CierreCaja.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de facturas emitidas");
			$pdf->SetSubject("Reporte de facturas emitidas");
			$pdf->SetMargins( 0, 10, 0 );
			$pdf->SetAutoPageBreak( TRUE, 0 );
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$caja_cier_codigo = $user_data["cmb_usuario_cajero"];
			$fecha_ini=$user_data["fecha_ini"];
			$fecha_fin=$user_data["fecha_fin"];
			$reporte->get_caja_cierre_items($caja_cier_codigo, $fecha_ini, $fecha_fin);
			$tranx = $reporte->rows;
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			$usuario_actual = "";
			$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
			$meses_h = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$fecha_h = explode('-',$tranx[0]['cabePago_fecha']);
			$fecha_h_result = $meses_h[(int)$fecha_h[1]-1].' '.$fecha_h[2].', '.$fecha_h[0];
			
			if( empty( $user_data["fecha_ini"] ) && empty( $user_data["fecha_fin"] ) )
				$html = '<h2>Reporte de Facturas emitidas: Historial completo </h2>';
			else
				$html = '<h2>Reporte de Facturas emitidas: del '.$fecha_ini.' al '.$fecha_fin.'</h2>';
			
			$html .='<h3>Fecha impresión: '.$fecha_h_result.'. Usuario: '.$tranx[0]['usua_codi'].'</h3>';
			$html .='<p style="font-size: x-small;">*DSD: Descuento sobre descuento. *DS: Descuento sumado</p>';
			
			$html .='<table border="0" cellspacing="0" cellpadding="0">';
			$cabePago_total_gene=0;
			$detaFact_totalNeto_gene=0;
			$detaFact_totalDescuento_gene=0;
			$detaFact_totalIVA_gene=0;
			$detaFact_totalICE_gene=0;
			$detaPago_total_cajero=0;
			for($i=0;$i<count($reporte->rows)-1;$i++)
			{   if( $usuario_actual != $tranx[$i]['usua_codi'] )
				{   if( $i != 0 )
					{   $html.='<tr><td colspan="12"><hr/></td></tr>';
						$html.='<tr>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;"><b>Subtotal cajero'. $usuario_actual.'</b> </td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
								<td align="right" style="font-size:small;"><b>$'.number_format($detaPago_total_cajero,2).'</b> </td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
								<td style="font-size:small;">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="12">&nbsp;</td>
						</tr>';
					}
					$html.='<tr><td colspan="12"><h2>Cajero: '.$tranx[$i]['usua_codi'].'</h2></td></tr>';
					$html.='<tr><td colspan="12"></td></tr>';
					$html.='
						<tr>
							<th style="text-align: center; font-size:x-small; 	width: 3%"><b>#</b></th>
							<th style="text-align: center; font-size:8;			width: 9%"><b>Descripción</b></th>
							<th style="text-align: center; font-size:small;		width:24%"><b>Cliente/Alumno</b></th>
							<th style="text-align: center; font-size:small;		width:11%"><b>Factura</b></th>
							<th style="text-align: right;  font-size:small;		width: 5%"><b>Recibo</b></th>
							<th style="text-align: right;  font-size:x-small;		width: 5%"><b>Tot. Bruto</b></th>
							<th style="text-align: right;  font-size:x-small;	width: 5%"><b>(-)Pronto p.</b></th>
							<th style="text-align: right;  font-size:small;		width: 5%"><b>(-)Dscto.</b></th>
							<th style="text-align: right;  font-size:small;		width: 5%"><b>I.V.A.</b></th>
							<th style="text-align: right;  font-size:x-small;		width: 5%"><b>Tot. abonado</b></th>
							<th style="text-align: right;  font-size:x-small;	width:18%"><b>Tipo descuento</b></th>
							<th style="text-align: right;  font-size:small;		width:5%"><b>Fecha</b></th>
						</tr>';
					$html.='<tr><td colspan="12"><hr/></td></tr>';
					$detaPago_total = 0;
					$detaPago_total_cajero = 0;
				}
				$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
				$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
				$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalCE;
				$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
				$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
				$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
				
				$cabePago_total=0;
				$detaFact_totalIVA=0;
				$detaFact_totalCE=0;
				$detaFact_totalNeto=0;
				$detaFact_totalDescuento=0;
				$fecha = explode('-',$tranx[$i]['cabePago_fecha']);
				$fecha_result = $meses[(int)$fecha[1]-1].' '.$fecha[2].', '.$fecha[0];
				$pagos = str_replace('Pagos: ','',$tranx[$i]['cabePago_codigo']);
				$tipo_dcto = str_replace('Descuento ','Dscto. ',$tranx[$i]['detaFact_desc_descripcion']);
				$html.='<tr>
				<td style="text-align: center; font-size:x-small;">'.($i+1).' </td>
				<td style="text-align: left; font-size:small;">'.$tranx[$i]['prod_nombre'].' </td>
				<td style="text-align: left; font-size:x-small;">'.$tranx[$i]['alum_codi'].' - '.$tranx[$i]['alum_nombre'].' </td>
				<td style="text-align: left; font-size:small;">'.$tranx[$i]['deud_codigoDocumento'].' </td>
				<td style="text-align: right; font-size:small;">'.$pagos.' </td>
				<td style="text-align: right; font-size:small;">$'.$tranx[$i]['detaFact_totalbruto'].' </td>
				<td style="text-align: right; font-size:small;">$'.number_format((float)$tranx[$i]['deud_totalProntopago'],2,'.','').'</td>
				<td style="text-align: right; font-size:small;">$'.$tranx[$i]['detaFact_totalDescuento'].' </td>
				<td style="text-align: right; font-size:small;">$'.$tranx[$i]['detaFact_totalIVA'].'</td>
				<td style="text-align: right; font-size:small;">$'.$tranx[$i]['cabePago_total'].' </td>
				<td style="text-align: right; font-size:small;">'.$tipo_dcto.'</td>
				<td style="text-align: right; font-size:small;">'.$fecha_result.'</td>
				<td style="text-align: right; font-size:small;">'.$tranx[$i]['usua_codi'].' </td>
				</tr>';
				$usuario_actual = $tranx[$i]['usua_codi'];
				$detaPago_total_cajero = $detaPago_total_cajero + $tranx[$i]['cabePago_total'];
				$cabePago_total=$cabePago_total+$tranx[$i]['cabePago_total'];
				$detaFact_totalIVA=$detaFact_totalIVA+$tranx[$i]['detaFact_totalIVA'];
				$detaFact_totalICE=$detaFact_totalICE+$tranx[$i]['detaFact_totalICE'];
				$detaFact_totalNeto=$detaFact_totalNeto+$tranx[$i]['detaFact_totalbruto'];
				$deud_totalProntopago=$deud_totalProntopago+$tranx[$i]['deud_totalProntopago'];
				$detaFact_totalDescuento=$detaFact_totalDescuento+$tranx[$i]['detaFact_totalDescuento'];
				if($i==count($reporte->rows)-2)
				{   $html.='<tr><td colspan="12"><hr/></td></tr>';
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalICE;
					$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
					$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					$html.='<tr>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;"><b>Subtotal cajero'. $usuario_actual.'</b> </td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td align="right" style="font-size:small;"><b>$'.number_format($detaPago_total_cajero,2).'</b> </td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
							<td style="font-size:small;">&nbsp;</td>
					</tr>';
					$html.='<tr>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;"><b>Total Diario</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalNeto_gene,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($deud_totalProntopago_gene,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalDescuento_gene,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($detaFact_totalIVA,2).'</b> </td>
					<td align="right" style="font-size:small;"><b>$'.number_format($cabePago_total_gene,2).'</b> </td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					<td style="font-size:small;">&nbsp;</td>
					</tr>';
					
					$cabePago_total=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
					$detaFact_totalNeto=0;
					$deud_totalProntopago=0;
					$detaFact_totalDescuento=0;
				}
			}
			$html.='</table>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('CierreCaja.pdf', 'I');
			
			break;
		case VIEW_GET_ALL:
            global $diccionario;
            if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			$today = new DateTime('yesterday');
			$tomorrow = new DateTime('today');
			$data['txt_fecha_ini'] = $today->format('d/m/Y');
			$data['txt_fecha_fin'] = $tomorrow->format('d/m/Y');
			$categoria->get_selectFormat_all("");
            $categorias = $categoria->rows;
			$data['{cmb_categoria}'] = array("elemento"  => "combo",
											   "datos"     => $categorias,
											   "options"   => array("name"		=>"cmb_categoria",
																	"id"		=>"cmb_categoria",
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>"js_item_cargaItem('resultadoProducto','cmb_producto',this.value);"),
											   "selected"  => 0);
			$item->get_item_selectFormat('');
			$select = "<select multiple='multiple' id=\"cmb_producto\" name=\"cmb_producto[]\" class='form-control' data-'.number_format($detaPago_subtotal,2).'='- Seleccione producto -' style='width:320px;'>";
			
			foreach( $item->rows as $options )
			{   if (!empty($options))
				{   $select .= "<option value='".$options[0]."' >".$options[1]."</option>";
				}
			}
			$select.= "</select>";
			
			$data['cmb_producto'] = $select;
			$pago->get_formaPagoSelectFormat();
			$data['{cmb_forma_pago}']= array("elemento"  => "combo",
										    "datos"     => $pago->rows,
										    "options"   => array("name" => "cmb_forma_pago",
																 "id" 	=> "cmb_forma_pago",
																 "class"=> "form-control input-sm"),
										    "selected"  => 0);
			$periodo->get_all_selectFormat();
			$data['{cmb_periodo}'] = array("elemento"  => "combo", 
											"datos"    => $periodo->rows, 
                                            "options"  => array("name"		=>"periodos",
																"id"		=>"periodos",
																"class"		=>"form-control input-sm",
																"onChange"	=> "cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
											"selected"  => 0);
			$grupEcon->getCategorias_selectFormat_with_all('');
			$data['{cmb_grupoEconomico}'] = array(  "elemento"  => "combo", 
													"datos"     => $grupEcon->rows, 
													"options" 	=> array("name"	=>"cmb_grupoEconomico",
																		 "id"	=>"cmb_grupoEconomico",
																		 "class"=>"form-control input-sm"),
													"selected"  => 0);
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			$data['{cmb_nivelEconomico}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"		=>"cmb_nivelesEconomicos",
																"id"		=>"cmb_nivelesEconomicos",
																"required"	=>"required",
																"class"		=>"form-control input-sm",
																"onChange"	=>"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"));
			$data['{cmb_curso}']=array("elemento"  => "combo", 
										"datos"     => array(0 => array(0 => -1, 
																		1 => '- Seleccione curso -',
																		3 => ''), 
                                                                        2=> array()),
															"options"   => array("name"=>"cursos","id"=>"curso","required"=>"required","class"=>"form-control input-sm"),
										"selected"  => -1);
			$usuariosFinancieros->get_all_financial_users(1,'CAJA','A');
            $data['{combo_cajas}'] = array(  "elemento"  => "combo", 
											 "datos"     => $usuariosFinancieros->rows, 
											 "options"   => array("name"=>"cmb_usuario_cajero","id"=>"cmb_usuario_cajero","required"=>"required",
											 "class"=>"form-control input-sm",
											 "onChange"=>""),
											 "selected"  => 0);
			$data['tabla_pagos'] = "";
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case PRINTREP_CIERRES_XLS:
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Reporte de facturas emitidas")
			->setSubject("Reporte de facturas emitidas")
			->setDescription("Reporte de facturas emitidas");
			
			//Escala de impresión
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55);
			
			//Horizontal
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			
			//Márgenes
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
			
			//ESPACIO AMPLIO PARA CABECERAS
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			//CONTENIDO DEL ARCHIVO
			$colores_headers_trama = '3c8dbc,398439,31b0d5,d73925,ec971f';
			$colores_headers = explode(",", $colores_headers_trama);
			//IMPRIMIENDO CABECERAS
			$styleTitulo = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'000000'),
								'size' => 14,
								'bold' => true,
								'name' => 'Helvetica')
			);
			$styleEncabezado = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 11,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '5A8FDC'))
			);
			$styleTotalFinal = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 12,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '20529b'))
			);
			$item_actual="";
			$caja_cier_codigo = $user_data["cmb_usuario_cajero"];
			$fecha_ini=$user_data["txt_fecha_ini"];
			$fecha_fin=$user_data["txt_fecha_fin"];
			
			$reporte->get_caja_cierre_items($caja_cier_codigo, $fecha_ini, $fecha_fin);
			$tranx = $reporte->rows;
			
			$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
			$meses_h = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$fecha_h = explode('-',$tranx[0]['cabePago_fecha']);
			$fecha_h_result = $meses_h[(int)$fecha_h[1]-1].' '.$fecha_h[2].', '.$fecha_h[0];
			
			if( empty( $user_data["txt_fecha_ini"] ) && empty( $user_data["txt_fecha_fin"] ) )
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, 'Reporte de Facturas Emitidas: Historial completo' );
			else
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, 'Reporte de Facturas Emitidas: del '.$fecha_ini.' al '.$fecha_fin ); 
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 2, 'Fecha de impresión: '. $fecha_h_result .'. Usuario: '.$_SESSION['usua_codi'].'.' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 3, "" );
			$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:L3');
			$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( $styleTitulo );
			
			$objPHPExcel->getActiveSheet()->getColumnDimension( A )->setWidth(50);
				
			$column = 'A';
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold( true );
			
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 4;
			$i_deta_fila=4;
			
			$cabePago_total_gene=0;
			$detaFact_totalNeto_gene=0;
			$detaFact_totalDescuento_gene=0;
			$detaFact_totalIVA_gene=0;
			$detaFact_totalICE_gene=0;
			$color_aux = 0;
			for($i=0;$i<count($reporte->rows)-1;$i++)
			{   
				$styleCabeceras = array(
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'font' => array('color' => array('rgb'=>'FFFFFF'),
									'size' => 9,
									'bold' => true,
									'name' => 'Helvetica'),
					'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
									'color' => array('rgb' => $colores_headers[ $color_aux ] ) )
				);
				if( $usuario_actual != $tranx[$i]['usua_codi'] )
				{   if($i!=0)
					{   
						//Subtotal suborden
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "Subtotal Cajero " . $usuario_actual );
						
						//4-9
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($detaFact_totalNeto,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($deud_totalProntopago,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($detaFact_totalDescuento,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($detaFact_totalIVA,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($detaFact_totalICE,2) );
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($cabePago_total,2) );
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':L'.$i_deta_fila )->applyFromArray( $styleCabeceras );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila = $i_deta_fila + 1;
						
						$color_aux = $color_aux + 1;
						if ( $color_aux == 5) $color_aux = 0;
						$styleCabeceras = array(
							'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
							'font' => array('color' => array('rgb'=>'FFFFFF'),
											'size' => 9,
											'bold' => true,
											'name' => 'Helvetica'),
							'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
											'color' => array('rgb' => $colores_headers[ $color_aux ] ) )
						);
					}
					//CAJERO
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, 'CAJERO: '.$tranx[$i]['usua_codi'] );
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':L'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					$i_deta_fila = $i_deta_fila + 1;
					if( $user_data['tipo_reporte'] == 'completo' )
					{   $cabeceras ='#,Descripción,Cliente/Alumno,Factura,Recibo,Tot. Bruto,(-)Pronto p.,(-)Dscto.,I.V.A.,Tot. Neto,Tipo descuento,Fecha';
					}
					$cabecera = explode( ",", $cabeceras );
					$i_cabe=0;//Contador de cabeceras
					$column = 'A';
					foreach($cabecera as $head)
					{	if( !empty( $head ) )
						{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe = $i_cabe+1;
							$column++;
						}
					}
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':L'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila = $i_deta_fila + 1;
					
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalCE;
					$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
					$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					
					$cabePago_total=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
					$detaFact_totalNeto=0;
					$detaFact_totalDescuento=0;
				}
				$fecha = explode('-',$tranx[$i]['cabePago_fecha']);
				$fecha_result = $meses[(int)$fecha[1]-1].' '.$fecha[2].', '.$fecha[0];
				$pagos = str_replace('Pagos: ','',$tranx[$i]['cabePago_codigo']);
				$tipo_dcto = str_replace('Descuento ','Dscto. ',$tranx[$i]['detaFact_desc_descripcion']);
				
				//
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, ( $i + 1 ) );
				//Prod nombre
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $tranx[$i]['prod_nombre'] );
				
				//Alumno nombre y codigo
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, $tranx[$i]['alum_codi'].' - '.$tranx[$i]['alum_nombre'] );
				
				//código factura
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, $tranx[$i]['deud_codigoDocumento'] );
				
				//Pagos
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, $pagos );
				
				//4-9
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalbruto'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format((float)$tranx[$i]['deud_totalProntopago'],2,'.','') );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalDescuento'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalIVA'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($tranx[$i]['detaFact_totalICE'],2) );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($tranx[$i]['cabePago_total'],2) );
				
				//10 Tipo de descuento
				$tipo_dcto = str_replace('<b>', '', $tipo_dcto );
				$tipo_dcto = str_replace('</b>', '', $tipo_dcto );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(10, $i_deta_fila, $tipo_dcto );
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(11, $i_deta_fila, $fecha_result );
								
				$i_deta_fila = $i_deta_fila + 1;
				
				$usuario_actual=$tranx[$i]['usua_codi'];
				$cabePago_total=$cabePago_total+$tranx[$i]['cabePago_total'];
				$detaFact_totalIVA=$detaFact_totalIVA+$tranx[$i]['detaFact_totalIVA'];
				$detaFact_totalICE=$detaFact_totalICE+$tranx[$i]['detaFact_totalICE'];
				$detaFact_totalNeto=$detaFact_totalNeto+$tranx[$i]['detaFact_totalbruto'];
				$deud_totalProntopago=$deud_totalProntopago+$tranx[$i]['deud_totalProntopago'];
				$detaFact_totalDescuento=$detaFact_totalDescuento+$tranx[$i]['detaFact_totalDescuento'];
				if($i==count($reporte->rows)-2){
					//Subtotal suborden
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila,  "Subtotal Cajero " . $usuario_actual );
					
					//4-9
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($detaFact_totalNeto,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($deud_totalProntopago,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($detaFact_totalDescuento,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($detaFact_totalIVA,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($detaFact_totalICE,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($cabePago_total,2) );
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':L'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila = $i_deta_fila + 1;
					
					$cabePago_total_gene=$cabePago_total_gene+$cabePago_total;
					$detaFact_totalIVA_gene=$detaFact_totalIVA_gene+$detaFact_totalIVA;
					$detaFact_totalICE_gene=$detaFact_totalICE_gene+$detaFact_totalICE;
					$detaFact_totalNeto_gene=$detaFact_totalNeto_gene+$detaFact_totalNeto;
					$deud_totalProntopago_gene=$deud_totalProntopago_gene+$deud_totalProntopago;
					$detaFact_totalDescuento_gene=$detaFact_totalDescuento_gene+$detaFact_totalDescuento;
					
					//Subtotal suborden
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "Total Diario" );
					
					//4-9
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, '$'.number_format($detaFact_totalNeto_gene,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($deud_totalProntopago_gene,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, '$'.number_format($detaFact_totalDescuento_gene,2) );
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, '$'.number_format($detaFact_totalIVA_gene,2) ); //aqui puede haber error, probar.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, '$'.number_format($detaFact_totalICE_gene,2) ); //aqui puede haber error, probar.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, '$'.number_format($cabePago_total_gene,2) );
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':L'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila = $i_deta_fila + 1;
					
					$cabePago_total=0;
					$detaFact_totalIVA=0;
					$detaFact_totalCE=0;
					$detaFact_totalNeto=0;
					$deud_totalProntopago=0;
					$detaFact_totalDescuento=0;
				}
			}
			
			foreach(range('A','M') as $columnID)
			{   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Reporte de facturas emitidas');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_facturas_emitidas.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
        	break;
    }
}

handler();
?>