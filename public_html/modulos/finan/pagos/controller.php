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
require_once('../../finan/facturas/model.php');

function handler() {
    
	require('../../../core/rutas.php');
	$pago 		= get_mainObject('Pagos');
    $permiso 	= get_mainObject('General');
	$categoria 	= get_mainObject('Categoria');
	$item 		= get_mainObject('Item');
	$periodo 	= get_mainObject('Periodo');
	$grupEcon 	= get_mainObject('GrupoEconomico');
	$usuariosFinancieros = get_mainObject('General');//
    $event		= get_actualEvents(array(VIEW_GET_ALL, GET_PENDING_BILLS, SEND_TO_SRI, RESEND_TO_SRI), VIEW_GET_ALL);
    $user_data 	= get_frontData();
	
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "facturasPendiente_table";}else{$tabla =$_POST['tabla'];}
    switch ($event) {
		case VIEW_GET_ALL:
            #  Presenta la pagina inicial
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
		case GET_PAYMENTS:
            global $diccionario;
			$data['tabla_pagos'] = construct_table_pagos( $user_data );
            retornar_result($data);
            break;
		case REVERT_FACTURA:
			global $diccionario;
			$resultado = $pago->revertir_factura($user_data['codigoDocumento']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case REVERT_FACTURA_KEEP_E_INFO:
			global $diccionario;
			$resultado = $pago->revertir_factura_keep_e_info($user_data['codigoDocumento']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case PRINT_EXCEL_ALL_DATA:
			global $diccionario;
			if(!isset($user_data['txt_codigo_pago']))
				$codigo_pago = '';
			else 
				$codigo_pago = $user_data['txt_codigo_pago'];
			if(!isset($user_data['cmb_forma_pago']))
				$forma_pago = '';
			else 
				$forma_pago = $user_data['cmb_forma_pago'];
			if(!isset($user_data['cmb_categoria']))
				$categoria_codigo = '';
			else 
				$categoria_codigo = $user_data['cmb_categoria'];
			if(!isset($user_data['cmb_producto']))
				$prod_codigo = '';
			else 
			{   $true=0;
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $user_data['cmb_producto']  as $producto )
				{	if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = "";
			}
			if(!isset($user_data['txt_fecha_ini']))
				$fechavenc_ini = '';
			else 
				$fechavenc_ini = $user_data['txt_fecha_ini'];
			
			if(!isset($user_data['txt_fecha_fin']))
				$fechavenc_fin = '';
			else 
				$fechavenc_fin = $user_data['txt_fecha_fin'];
			if(!isset($user_data['cod_titular']))
				$cod_titular = '';
			else 
				$cod_titular = $user_data['cod_titular'];
			if(!isset($user_data['txt_id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['txt_id_titular'];
			if(!isset($user_data['txt_cod_cliente']))
				$cod_estudiante = '';
			else 
				$cod_estudiante = $user_data['txt_cod_cliente'];
			if(!isset($user_data['txt_nom_cliente']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['txt_nom_cliente'];
			if(!isset($user_data['txt_nom_titular']))
				$nombre_titular = '';
			else 
				$nombre_titular = $user_data['txt_nom_titular'];
			if(!isset($user_data['txt_ptoVenta']))
				$ptvo_venta = '';
			else 
				$ptvo_venta = $user_data['txt_ptoVenta'];
			if(!isset($user_data['txt_sucursal']))
				$sucursal = '';
			else 
				$sucursal = $user_data['txt_sucursal'];
			if(!isset($user_data['num_factura']))
				$num_factura = '';
			else 
				$num_factura = $user_data['num_factura'];
			if(!isset($user_data['txt_ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['txt_ref_factura'];
			if(!isset($user_data['estado']))
				$estado = '';
			else 
				$estado = $user_data['estado'];
			if(!isset($user_data['txt_tneto_ini']))
				$tpago_ini = 0;
			else 
				$tpago_ini = (float)$user_data['txt_tneto_ini'];
			if(!isset($user_data['txt_tneto_fin']))
				$tpago_fin = 0;
			else 
				$tpago_fin = (float)$user_data['txt_tneto_fin'];
			
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Exportación de datos de bandeja de Pagos en el sistema")
			->setSubject("Exportación de datos de bandeja de Pagos en el sistema")
			->setDescription("Exportación de datos de bandeja de Pagos en el sistema");
			
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
			//IMPRIMIENDO CABECERAS
			$styleEncabezado = array(
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'font' => array('color' => array('rgb'=>'FFFFFF'),
									'size' => 11,
									'name' => 'Helvetica'),
					'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
									'color' => array('rgb' => '3C8DBC'))
				);
			if ( $user_data['tipo_visual'] == '1' )
			{   $cabeceras ='Pago ref.,Titular,Titular doc.,Titular id.,Número de documento,Total pago(menos Saldo a favor),Saldo a favor,Forma de pago,Cliente ref. interna,Cliente id.,Cliente nombre,Curso Paralelo,Fecha de pago,Cajero,Observaciones';
			}
			if ( $user_data['tipo_visual'] == '2' )
			{   $cabeceras ='Pago ref.,Titular,Titular doc.,Titular id.,Número de documento,Total pago(incluído saldo a favor),Forma de pago,Cliente ref. interna,Cliente id.,Cliente nombre,Curso Paralelo,Fecha de pago,Cajero,Observaciones';
			}
			$cabecera = explode( ",", $cabeceras );
			$i_cabe=0;//Contador de cabeceras
			$column = 'A';
			foreach($cabecera as $head)
			{	if( !empty( $head ) )
				{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, 1, $head );
					$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(30);
					$i_cabe=$i_cabe+1;
					$column++;
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->getFont()->setBold( true );
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->applyFromArray( $styleEncabezado );
			
			$pago = new Pagos();
			if( $user_data['tipo_reporte'] == 'completo' )
			{   if ( $user_data['tipo_visual'] == '1' )
					$pago->get_PagosRealizados( $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
												$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
												$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $categoria_codigo, $prod_codigo, 
												$estado, $tpago_ini, $tpago_fin, $user_data['cmb_usuario_cajero'], $user_data['periodos'],$user_data['cmb_grupoEconomico'],
												$user_data['cmb_nivelesEconomicos'], $user_data['cursos'], $user_data['deuda'] );
				if ( $user_data['tipo_visual'] == '2' )
					$pago->get_PagosRealizados2($codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
												$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
												$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $categoria_codigo, $prod_codigo, 
												$estado, $tpago_ini, $tpago_fin, $user_data['cmb_usuario_cajero'], $user_data['periodos'],$user_data['cmb_grupoEconomico'],
												$user_data['cmb_nivelesEconomicos'], $user_data['cursos'], $user_data['deuda'] );
			}
            $pagos=$pago->rows;
			$i_deta_fila=2;
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 1;
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}
			foreach ($pagos as $registro)
			{	$i_deta_col=0;
			  	foreach ($registro as $campo =>$valor )
				{	if ( substr($valor, -4) == '<br>' )
						$valor = substr( $valor, 0, -4 );
					$valor = str_replace("<br>","\n", $valor);
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i_deta_col, $i_deta_fila, "".$valor."");
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_col, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_col, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$i_deta_col=$i_deta_col+1;
				}
				$i_deta_fila=$i_deta_fila+1;
			}
			foreach( range('A','O') as $columnID )
			{   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Bandeja de facturas');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_bandeja_pagos.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case PRINT_PDF_ALL_DATA:
			global $diccionario;
			if(!isset($user_data['txt_codigo_pago']))
				$codigo_pago = '';
			else 
				$codigo_pago = $user_data['txt_codigo_pago'];
			if(!isset($user_data['cmb_forma_pago']))
				$forma_pago = '';
			else 
				$forma_pago = $user_data['cmb_forma_pago'];
			if(!isset($user_data['cmb_categoria']))
				$categoria_codigo = '';
			else 
				$categoria_codigo = $user_data['cmb_categoria'];
			if(!isset($user_data['cmb_producto']))
				$prod_codigo = '';
			else 
			{   $true=0;
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $user_data['cmb_producto']  as $producto )
				{   if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = "";
			}
			if(!isset($user_data['txt_fecha_ini']))
				$fechavenc_ini = '';
			else 
				$fechavenc_ini = $user_data['txt_fecha_ini'];
			
			if(!isset($user_data['txt_fecha_fin']))
				$fechavenc_fin = '';
			else 
				$fechavenc_fin = $user_data['txt_fecha_fin'];
			if(!isset($user_data['cod_titular']))
				$cod_titular = '';
			else 
				$cod_titular = $user_data['cod_titular'];
			if(!isset($user_data['txt_id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['txt_id_titular'];
			if(!isset($user_data['txt_cod_cliente']))
				$cod_estudiante = '';
			else 
				$cod_estudiante = $user_data['txt_cod_cliente'];
			if(!isset($user_data['txt_nom_cliente']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['txt_nom_cliente'];
			if(!isset($user_data['txt_nom_titular']))
				$nombre_titular = '';
			else 
				$nombre_titular = $user_data['txt_nom_titular'];
			if(!isset($user_data['txt_ptoVenta']))
				$ptvo_venta = '';
			else 
				$ptvo_venta = $user_data['txt_ptoVenta'];
			if(!isset($user_data['txt_sucursal']))
				$sucursal = '';
			else 
				$sucursal = $user_data['txt_sucursal'];
			if(!isset($user_data['num_factura']))
				$num_factura = '';
			else 
				$num_factura = $user_data['num_factura'];
			if(!isset($user_data['txt_ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['txt_ref_factura'];
			if(!isset($user_data['estado']))
				$estado = '';
			else 
				$estado = $user_data['estado'];
			if(!isset($user_data['txt_tneto_ini']))
				$tpago_ini = 0;
			else 
				$tpago_ini = (float)$user_data['txt_tneto_ini'];
			if(!isset($user_data['txt_tneto_fin']))
				$tpago_fin = 0;
			else 
				$tpago_fin = (float)$user_data['txt_tneto_fin'];
			
			header("Content-type:application/pdf");
          	header("Content-Disposition:attachment;filename='reporte_bandeja_pagos.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de pagos realizados");
			$pdf->SetSubject("Reporte de pagos realizados en el sistema");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 8, '', 'false');
			
			$caja_cier_codigo = $user_data["codigo"];
			$fecha_ini= " del " . $user_data["txt_fecha_ini"];
			$fecha_fin= " al " . $user_data["txt_fecha_fin"];
			
			$reporte = new Pagos();
			$reporte->get_caja_cierre_fp(   $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
											$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
											$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $categoria_codigo, $prod_codigo, 
											$estado, $tpago_ini, $tpago_fin, $user_data['cmb_usuario_cajero'], $user_data['periodos'],$user_data['cmb_grupoEconomico'],
											$user_data['cmb_nivelesEconomicos'],$user_data['cursos'], $user_data['tipo_reporte'] );
			$tranx = $reporte->rows;
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			$item_actual="";
			$usuario_actual="";
			$suborden_actual="";
			if( empty( $user_data["txt_fecha_ini"] ) && empty( $user_data["txt_fecha_fin"] ) )
				$html = '<h2>Reporte de Formas de Pago: Historial completo </h2>';
			else
				$html = '<h2>Reporte de Formas de Pago:'.$fecha_ini.$fecha_fin.'</h2>';
			
			$html .='<table border="0" cellspacing="0" cellpadding="0">';
			$detaPago_total_gene=0;
			$detaPago_total_cajero=0;
			$div_by_user = '0';
			
			if( substr( $user_data['tipo_reporte'], 0, 5 ) == 'curso' )
			{   $item_orden = 'niveEcon';
				$item_nomen = 'Nivel Económico';
				$subitem_orden = 'formPago_nombre';
				$suborden = 'Forma de pago';
				if( $user_data['tipo_reporte'] == 'curso_caja' )
					$div_by_user = '1';
				else
					$div_by_user = '0';
			}
			if( substr( $user_data['tipo_reporte'], 0, 13 ) == 'forma_de_pago' )
			{   $item_orden = 'formPago_nombre';
				$item_nomen = 'Forma de pago';
				$subitem_orden = 'niveEcon';
				$suborden = 'Nivel Económico';
				if( $user_data['tipo_reporte'] == 'forma_de_pago_caja' )
					$div_by_user = '1';
				else
					$div_by_user = '0';
			}
			for($i=0;$i<count($reporte->rows)-1;$i++)
			{   if( $usuario_actual != $tranx[$i]['usua_codi'] && $div_by_user == '1')
				{   if( $i != 0 )
					{   $html.='<tr><td colspan="8"><hr/></td></tr>';
						$html.='<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><b>Subtotal '.$suborden_actual.'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="right"><b>$'.number_format($detaPago_subtotal,2).'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="8">&nbsp;</td>
						</tr>';
						$html.='<tr><td colspan="8"><hr/></td></tr>';
						$html.='<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><b>Subtotal '.$item_actual.'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="right"><b>$'.number_format($detaPago_total,2).'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="8">&nbsp;</td>
						</tr>';
						$html.='<tr><td colspan="8"><hr/></td></tr>';
						$html.='<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><b>Subtotal cajero '."Subtotal cajero ". $usuario_actual.'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="right"><b>$'.number_format($detaPago_total_cajero,2).'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="8">&nbsp;</td>
						</tr>';
					}
					$html.='<tr><td colspan="8"><h2>Cajero: '.$tranx[$i]['usua_codi'].'</h2></td></tr>';
					$html.='<tr><td colspan="8"><h3>'.$item_nomen.': '.$tranx[$i][$item_orden].'</h3></td></tr>';
					$html.='<tr><td colspan="8"><h4>'.$suborden.': '.$tranx[$i][$subitem_orden] .'</h4></td></tr>';
					$html.='<tr>
						<th style="width:3%">#</th>
						<th style="width:6%">Recibo</th>
						<th style="width:21%">Curso</th>
						<th style="width:25%">Alumno</th>
						<th style="width:15%">Factura</th>
						<th style="width:6%" align="right">Total abonado</th>
						<th style="width:10%" align="right">Fecha</th>
						<th style="width:14%" align="right">Detalle</th>
					</tr>
					<tr>
					<td colspan="8"><hr/></td>
					</tr>';
					$detaPago_total = 0;
					$detaPago_total_cajero = 0;
				}
				else
				{   if( $item_actual != $tranx[$i][$item_orden] )
					{   if( $i != 0 )
						{   $html.='<tr><td colspan="8"><hr/></td></tr>';
							$html.='<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><b>Subtotal '.$suborden_actual.'</b> </td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td align="right"><b>$'.number_format($detaPago_subtotal,2).'</b> </td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="8">&nbsp;</td>
							</tr>';
							$html.='<tr><td colspan="8"><hr/></td></tr>';
							$html.='<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><b>Subtotal '.$item_actual.'</b> </td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td align="right"><b>$'.number_format($detaPago_total,2).'</b> </td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="8">&nbsp;</td>
							</tr>';
						}
						$html.='<tr><td colspan="8"><h3>'.$item_nomen.': '.$tranx[$i][$item_orden].'</h3></td></tr>';
						$html.='<tr><td colspan="8"><h3>'.$suborden.': '.$tranx[$i][$subitem_orden].'</h3></td></tr>';
						$html.='<tr>
							<th style="width:3%">#</th>
							<th style="width:6%">Recibo</th>
							<th style="width:21%">Curso</th>
							<th style="width:25%">Alumno</th>
							<th style="width:15%">Factura</th>
							<th style="width:6%" align="right">Total abonado</th>
							<th style="width:10%" align="right">Fecha</th>
							<th style="width:14%" align="right">Detalle</th>
						</tr>
						<tr>
						<td colspan="8"><hr/></td>
						</tr>';
						$detaPago_subtotal=0;
						$detaPago_total=0;
					}
					else
					{   if( $suborden_actual != $tranx[$i][$subitem_orden] )
						{   if( $i != 0 )
							{	$html.='<tr><td colspan="8"><hr/></td></tr>';
								$html.='<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td><b>Subtotal '.$suborden_actual.'</b> </td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="right"><b>$'.number_format($detaPago_subtotal,2).'</b> </td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="8">&nbsp;</td>
								</tr>';
							}
							$html.='<tr><td colspan="8"><h4>'.$suborden.': '.$tranx[$i][$subitem_orden].'</h4></td></tr>';
							$html.='<tr>
								<th style="width:3%">#</th>
								<th style="width:6%">Recibo</th>
								<th style="width:21%">Curso</th>
								<th style="width:25%">Alumno</th>
								<th style="width:15%">Factura</th>
								<th style="width:6%" align="right">Total abonado</th>
								<th style="width:10%" align="right">Fecha</th>
								<th style="width:14%" align="right">Detalle</th>
							</tr>
							<tr>
							<td colspan="8"><hr/></td>
							</tr>';
							$detaPago_subtotal=0;
						}
					}
				}
				$html.='<tr>
				<td style="font-size:small;">'.($i+1).'</td>
				<td style="font-size:small;">'.$tranx[$i]['cabepago_codigo'].' </td>
				<td style="font-size:small;">'.$tranx[$i]['cliente_curso'].' </td>
				<td style="font-size:small;">'.$tranx[$i]['alum_codi'].' - '.$tranx[$i]['cliente_nombre'].' </td>
				<td style="font-size:small;">'.$tranx[$i]['deud_codigoDocumento'].' </td>
				<td style="font-size:small;" align="right">$'.$tranx[$i]['detaPago_total'].' </td>
				<td style="font-size:small;" align="right">'.$tranx[$i]['detaPago_fechaCreacion'].' </td>
				<td style="font-size:small;" align="right">'.$tranx[$i]['observacion'].' </td>
				</tr>';
				$usuario_actual = $tranx[$i]['usua_codi'];
				$item_actual = $tranx[$i][$item_orden];
				$suborden_actual = $tranx[$i][$subitem_orden];
				$detaPago_total = $detaPago_total + $tranx[$i]['detaPago_total'];
				$detaPago_subtotal = $detaPago_subtotal + $tranx[$i]['detaPago_total'];
				$detaPago_total_cajero = $detaPago_total_cajero + $tranx[$i]['detaPago_total'];
				$detaPago_total_gene = $detaPago_total_gene + $tranx[$i]['detaPago_total'];
				if( $i == count( $reporte->rows )-2 )
				{   $html.='<tr><td colspan="8"><hr/></td></tr>';
					$html.='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Subtotal '.$suborden_actual.'</b> </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right"><b>$'.number_format($detaPago_subtotal,2).'</b> </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td colspan="8">&nbsp;</td>
					</tr>';
					$html.='<tr><td colspan="8"><hr/></td></tr>';
					$html.='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Subtotal '.$item_actual.'</b> </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right"><b>$'.number_format($detaPago_total,2).'</b> </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td colspan="8">&nbsp;</td>
					</tr>';
					if ($div_by_user == '1') 
						$html.='
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><b>Subtotal cajero '. $usuario_actual .'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="right"><b>$'.number_format($detaPago_total_cajero,2).'</b> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="8">&nbsp;</td>
						</tr>';
					$html.='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Diario</b> </td>
					<td align="right"><b>$'.number_format($detaPago_total_gene,2).'</b> </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td colspan="8">&nbsp;</td>
					</tr>';
					
					$cabePago_total = 0;
					$detaFact_totalNeto = 0;
					$detaFact_totalDescuento=  0;
				}
			}
			$html.='</table>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('reporte_bandeja_pagos.pdf', 'I');
			
			break;
		case PRINT_EXCEL_ALL_DATA2:
			$hoy = getdate();
			global $diccionario;
			if(!isset($user_data['txt_codigo_pago']))
				$codigo_pago = '';
			else 
				$codigo_pago = $user_data['txt_codigo_pago'];
			if(!isset($user_data['cmb_forma_pago']))
				$forma_pago = '';
			else 
				$forma_pago = $user_data['cmb_forma_pago'];
			if(!isset($user_data['cmb_categoria']))
				$categoria_codigo = '';
			else 
				$categoria_codigo = $user_data['cmb_categoria'];
			if(!isset($user_data['cmb_producto']))
				$prod_codigo = '';
			else 
			{   $true=0;
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $user_data['cmb_producto']  as $producto )
				{	if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = "";
			}
			if(!isset($user_data['txt_fecha_ini']))
				$fechavenc_ini = '';
			else 
				$fechavenc_ini = $user_data['txt_fecha_ini'];
			
			if(!isset($user_data['txt_fecha_fin']))
				$fechavenc_fin = '';
			else 
				$fechavenc_fin = $user_data['txt_fecha_fin'];
			if(!isset($user_data['cod_titular']))
				$cod_titular = '';
			else 
				$cod_titular = $user_data['cod_titular'];
			if(!isset($user_data['txt_id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['txt_id_titular'];
			if(!isset($user_data['txt_cod_cliente']))
				$cod_estudiante = '';
			else 
				$cod_estudiante = $user_data['txt_cod_cliente'];
			if(!isset($user_data['txt_nom_cliente']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['txt_nom_cliente'];
			if(!isset($user_data['txt_nom_titular']))
				$nombre_titular = '';
			else 
				$nombre_titular = $user_data['txt_nom_titular'];
			if(!isset($user_data['txt_ptoVenta']))
				$ptvo_venta = '';
			else 
				$ptvo_venta = $user_data['txt_ptoVenta'];
			if(!isset($user_data['txt_sucursal']))
				$sucursal = '';
			else 
				$sucursal = $user_data['txt_sucursal'];
			if(!isset($user_data['num_factura']))
				$num_factura = '';
			else 
				$num_factura = $user_data['num_factura'];
			if(!isset($user_data['txt_ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['txt_ref_factura'];
			if(!isset($user_data['estado']))
				$estado = '';
			else 
				$estado = $user_data['estado'];
			if(!isset($user_data['txt_tneto_ini']))
				$tpago_ini = 0;
			else 
				$tpago_ini = (float)$user_data['txt_tneto_ini'];
			if(!isset($user_data['txt_tneto_fin']))
				$tpago_fin = 0;
			else 
				$tpago_fin = (float)$user_data['txt_tneto_fin'];
			
			$caja_cier_codigo = $user_data["codigo"];
			$fecha_ini= " del " . $user_data["txt_fecha_ini"];
			$fecha_fin= " al " . $user_data["txt_fecha_fin"];
			
			if( empty( $user_data["txt_fecha_ini"] ) && empty( $user_data["txt_fecha_fin"] ) )
				$titulo = 'Reporte de Formas de Pago: Historial completo';
			else
				$titulo = 'Reporte de Formas de Pago:'.$fecha_ini.$fecha_fin.'';
			
			$reporte = new Pagos();
			$reporte->get_caja_cierre_fp(   $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
											$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
											$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $categoria_codigo, $prod_codigo, 
											$estado, $tpago_ini, $tpago_fin, $user_data['cmb_usuario_cajero'], $user_data['periodos'],$user_data['cmb_grupoEconomico'],
											$user_data['cmb_nivelesEconomicos'],$user_data['cursos'], $user_data['tipo_reporte'] );
			
			$tranx = $reporte->rows;
			
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Exportación de datos de bandeja de Pagos en el sistema")
			->setSubject("Exportación de datos de bandeja de Pagos en el sistema")
			->setDescription("Exportación de datos de bandeja de Pagos en el sistema");
			
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
			
			$colores_headers_trama = '3c8dbc,398439,31b0d5,d73925,ec971f';
			$colores_headers = explode(",", $colores_headers_trama);
			
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
			$styleCabeceras = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('size' => 9,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'E1EAF8'))
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
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, $titulo );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 2, 'Fecha de impresión: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 3, "" );
			$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
			$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( $styleTitulo );
			
			$objPHPExcel->getActiveSheet()->getColumnDimension( A )->setWidth(50);
				
			$column = 'A';
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold( true );
			
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 4;
			$i_deta_fila=4;
			
			$detaPago_total_gene=0;
			
			$div_by_user = '0';
			
			if( substr( $user_data['tipo_reporte'], 0, 5 ) == 'curso' )
			{   $item_orden = 'niveEcon';
				$item_nomen = 'Nivel Económico';
				$subitem_orden = 'formPago_nombre';
				$suborden = 'Forma de pago';
				if( $user_data['tipo_reporte'] == 'curso_caja' )
					$div_by_user = '1';
				else
					$div_by_user = '0';
			}
			if( substr( $user_data['tipo_reporte'], 0, 13 ) == 'forma_de_pago' )
			{   $item_orden = 'formPago_nombre';
				$item_nomen = 'Forma de pago';
				$subitem_orden = 'niveEcon';
				$suborden = 'Nivel Económico';
				if( $user_data['tipo_reporte'] == 'forma_de_pago_caja' )
					$div_by_user = '1';
				else
					$div_by_user = '0';
			}
			for($i=0;$i<count($reporte->rows)-1;$i++)
			{   if( $usuario_actual != $tranx[$i]['usua_codi'] && $div_by_user == '1' )
				{   if( $i != 0 )
					{   //Subtotal suborden
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal ".$suborden_actual );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Subtotal suborden VALOR
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_subtotal,2) );
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
						
						//Subtotal orden
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal ".$item_actual );
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Subtotal orden VALOR
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_total,2) );
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
						
						//Subtotal cajero
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal cajero ". $usuario_actual );
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Subtotal cajero valor
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_total_cajero,2) );
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
							
					}
					//CAJERO
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, 'CAJERO: '.$tranx[$i]['usua_codi'] );
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila=$i_deta_fila+1;
					
					//item_nomen
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0,  $i_deta_fila, $item_nomen.': '.$tranx[$i][$item_orden] );
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila=$i_deta_fila+1;
					
					//suborden
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $suborden.': '.$tranx[$i][$subitem_orden] );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila=$i_deta_fila+1;
					
					$cabeceras ='#,No. Recibo,Curso,Alumno/Cliente,Factura,Total abonado,Fecha,Detalle';
					$cabecera = explode( ",", $cabeceras );
					
					$i_cabe = 0;//Contador de cabeceras
					$column = 'A';
					
					foreach($cabecera as $head)
					{	if( !empty( $head ) )
						{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
							$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
							$i_cabe = $i_cabe+1;
							$column++;
						}
					}
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
					
					$i_deta_fila=$i_deta_fila+1;
					$detaPago_total = 0;
					$detaPago_total_cajero = 0;
				}
				else
				{   if( $item_actual != $tranx[$i][$item_orden] )
					{   if( $i != 0 )
						{   //Subtotal suborden
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal ".$suborden_actual );
							$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							//Subtotal suborden VALOR
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_subtotal,2) );
							$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleCabeceras );
								
							$i_deta_fila=$i_deta_fila+1;
							
							//Total orden
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total: ".$item_actual );
							$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							//Total orden VALOR
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_total,2) );
							$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
								
							$i_deta_fila=$i_deta_fila+1;
						}
						//ITEM NOMENCLATURA: ITEM ORDEN
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $item_nomen.': '.$tranx[$i][$item_orden] );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
						
						//SUBITEM NOMENCLATURA: SUBITEM ORDEN
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $suborden.': '.$tranx[$i][$subitem_orden] );
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
						
						$cabeceras ='#,Recibo,Curso,Alumno/Cliente,Factura,Total abonado,Fecha,Detalle';
						$cabecera = explode( ",", $cabeceras );
						
						$i_cabe = 0;//Contador de cabeceras
						$column = 'A';
						
						foreach($cabecera as $head)
						{	if( !empty( $head ) )
							{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
								$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
								$i_cabe = $i_cabe+1;
								$column++;
							}
						}
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleCabeceras );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
						
						$detaPago_subtotal=0;
						$detaPago_total=0;
					}
					else
					{   if( $suborden_actual != $tranx[$i][$subitem_orden] )
						{   if( $i != 0 )
							{	//Subtotal suborden
								$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal ".$suborden_actual );
								$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
								$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
								
								//Subtotal suborden VALOR
								$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_subtotal,2) );
								$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
								$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
								
								$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
								$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleCabeceras );
								
								$i_deta_fila=$i_deta_fila+1;
							}
							//suborden: subitem_orden
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $suborden.': '.$tranx[$i][$subitem_orden] );
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
							$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
							$i_deta_fila=$i_deta_fila+1;
							
							$cabeceras ='#,Recibo,Curso,Alumno/Cliente,Factura,Total abonado,Fecha,Detalle';
							$cabecera = explode( ",", $cabeceras );
							
							$i_cabe = 0;//Contador de cabeceras
							$column = 'A';
							
							foreach($cabecera as $head)
							{	if( !empty( $head ) )
								{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
									$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
									$i_cabe = $i_cabe+1;
									$column++;
								}
							}
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleCabeceras );
							$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
							
							$i_deta_fila=$i_deta_fila+1;
							
							$detaPago_subtotal=0;
						}
					}
				}
				//No.
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, ($i+1) );
				$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//cabepago_codigo
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, $tranx[$i]['cabepago_codigo'] );
				$objPHPExcel->getActiveSheet()->getStyle( 1, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//curso
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, $tranx[$i]['cliente_curso'] );
				$objPHPExcel->getActiveSheet()->getStyle( 2, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//alum_codi
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, $tranx[$i]['alum_codi'].' - '.$tranx[$i]['cliente_nombre'] );
				$objPHPExcel->getActiveSheet()->getStyle( 3, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//deud_codigoDocumento
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, $tranx[$i]['deud_codigoDocumento'] );
				$objPHPExcel->getActiveSheet()->getStyle( 4, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//detaPago_total
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, $tranx[$i]['detaPago_total'] );
				$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//detaPago_fechaCreacion
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, $tranx[$i]['detaPago_fechaCreacion'] );
				$objPHPExcel->getActiveSheet()->getStyle( 6, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//observacion
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, $tranx[$i]['observacion'] );
				$objPHPExcel->getActiveSheet()->getStyle( 7, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle( 7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$i_deta_fila=$i_deta_fila+1;
				
				$usuario_actual = $tranx[$i]['usua_codi'];
				$item_actual = $tranx[$i][$item_orden];
				$suborden_actual = $tranx[$i][$subitem_orden];
				$detaPago_total = $detaPago_total + $tranx[$i]['detaPago_total'];
				$detaPago_subtotal = $detaPago_subtotal + $tranx[$i]['detaPago_total'];
				$detaPago_total_cajero = $detaPago_total_cajero + $tranx[$i]['detaPago_total'];
				$detaPago_total_gene = $detaPago_total_gene + $tranx[$i]['detaPago_total'];
				if( $i == count( $reporte->rows )-2 )
				{   //Subtotal suborden
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal ".$suborden_actual );
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Subtotal suborden VALOR
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_subtotal,2) );
					$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleCabeceras );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
					$i_deta_fila=$i_deta_fila+1;
					
					//Subtotal orden
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total ".$item_actual );
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Subtotal orden VALOR
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_total,2) );
					$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
					$i_deta_fila=$i_deta_fila+1;
					
					if ($div_by_user == '1') 
					{
						//Subtotal Cajero
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal cajero ". $usuario_actual );
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Subtotal Cajero
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_total_cajero,2) );
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
							
						$i_deta_fila=$i_deta_fila+1;
						
					}
					
					
					//TOTAL DIARIO
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total Diario" );
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//TOTAL DIARIO VALOR
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, '$'.number_format($detaPago_total_gene,2) );
					$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':H'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
					$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
					$i_deta_fila=$i_deta_fila+1;
					
					$cabePago_total = 0;
					$detaFact_totalNeto = 0;
					$detaFact_totalDescuento=  0;
				}
			}
			foreach( range('B','H') as $columnID )
			{   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Reporte de formas de pago');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_formas_de_pago.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
        default:
            break;
    }
}
handler();
function construct_table_pagos($user_data)
{   global $diccionario;
	if(!isset($user_data['codigo_pago']))
		$codigo_pago = '';
	else 
		$codigo_pago = $user_data['codigo_pago'];
	if(!isset($user_data['forma_pago']))
		$forma_pago = '';
	else 
		$forma_pago = $user_data['forma_pago'];
	if(!isset($user_data['fechavenc_ini']))
		$fechavenc_ini = '';
	else 
		$fechavenc_ini = $user_data['fechavenc_ini'];
	if(!isset($user_data['fechavenc_fin']))
		$fechavenc_fin = '';
	else 
		$fechavenc_fin = $user_data['fechavenc_fin'];
	if(!isset($user_data['cod_titular']))
		$cod_titular = '';
	else 
		$cod_titular = $user_data['cod_titular'];
	if(!isset($user_data['id_titular']))
		$id_titular = '';
	else 
		$id_titular = $user_data['id_titular'];
	if(!isset($user_data['cod_estudiante']))
		$cod_estudiante = '';
	else 
		$cod_estudiante = $user_data['cod_estudiante'];
	if(!isset($user_data['nombre_estudiante']))
		$nombre_estudiante = '';
	else 
		$nombre_estudiante = $user_data['nombre_estudiante'];
	if(!isset($user_data['nombre_titular']))
		$nombre_titular = '';
	else 
		$nombre_titular = $user_data['nombre_titular'];
	if(!isset($user_data['ptvo_venta']))
		$ptvo_venta = '';
	else 
		$ptvo_venta = $user_data['ptvo_venta'];
	if(!isset($user_data['sucursal']))
		$sucursal = '';
	else 
		$sucursal = $user_data['sucursal'];
	if(!isset($user_data['num_factura']))
		$num_factura = '';
	else 
		$num_factura = $user_data['num_factura'];
	if(!isset($user_data['categoria_codigo']))
		$categoria_codigo = '';
	else 
		$categoria_codigo = $user_data['categoria_codigo'];
	if(!isset($user_data['prod_codigo']))
		$prod_codigo = '';
	else 
	{   $true=0;
		$productos = json_decode($user_data['prod_codigo'], true);
		$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
		foreach ( $productos  as $producto )
		{   if( $producto!= '' )
			{   $prod_codigo.='<producto id="'.$producto.'" />';
				$true=1;
			}
		}
		$prod_codigo.="</productos>";
		if ( $true == 0 )
			$prod_codigo = "";
	}
	if(!isset($user_data['estado']))
		$estado = '';
	else 
		$estado = $user_data['estado'];
	if(!isset($user_data['tneto_ini']))
		$tpago_ini = 0;
	else 
		$tpago_ini = (float)$user_data['tneto_ini'];
	if(!isset($user_data['tneto_fin']))
		$tpago_fin = 0;
	else 
		$tpago_fin = (float)$user_data['tneto_fin'];
	$pago = new Pagos();
	
	if ( $user_data['tipo_visual'] == NULL )
		$tipo_visual = 1;
	else
		$tipo_visual = $user_data['tipo_visual'];
	
	if ( $tipo_visual == '1' )
		$pago->get_PagosRealizados( $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $categoria_codigo, $prod_codigo, 
									$estado, $tpago_ini, $tpago_fin, $user_data['usuario_cajero'], $user_data['periodo'],$user_data['grupoEconomico'],
									$user_data['nivelEconomico'],$user_data['cursos'], $user_data['deuda'] );
	
	if ( $tipo_visual == '2' )
		$pago->get_PagosRealizados2( $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
									$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
									$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $categoria_codigo, $prod_codigo, 
									$estado, $tpago_ini, $tpago_fin, $user_data['usuario_cajero'], $user_data['periodo'],$user_data['grupoEconomico'],
									$user_data['nivelEconomico'],$user_data['cursos'], $user_data['deuda'] );
	$nombre_extendido = ""; /* Agosto 18 2016. Hasta esta fecha, el único lugar de donde se puede recibir deuda es desde Cliente, Estado de cuento (clientes.js).*/
	
	if ( !empty( $user_data['deuda'] ) )
		$nombre_extendido = "_".$user_data['deuda'];
	if ( $user_data['bandeja_factura'] == 'SI' )
		$nombre_extendido = "_".$num_factura;
	$construct_table="
				<table class='table table-hover table-striped' id='pagosRealizados_table".$nombre_extendido."'>
					<thead>
						<tr style='background-color:rgba(60, 176, 188, 0.53);color:black;'>".
							"<th style=\"text-align:center;vertical-align:middle\"></th>".
							"<th style='font-size:x-small;text-align:center;'>Ref.</th>".
							"<th style='font-size:x-small;text-align:right;'>Total Pago</th>".
							( $tipo_visual == '1' ? "<th style='font-size:x-small;text-align:right;'>Saldo a favor</th>" : "" ).
							"<th style='font-size:x-small;text-align:center;'>Formas de Pago</th>".
							"<th style='font-size:x-small;text-align:center;'>Alumno/Cliente</th>".
							"<th style='font-size:x-small;text-align:center;'>Información pago</th>".
							"<th style='font-size:x-small;text-align:center;'>PDF</th>".
							"<th style='font-size:x-small;text-align:center;'>HTML</th>".
							"<th style='font-size:x-small;text-align:center;'>Revertir</th>
						</tr>
					</thead>";
	//}
	$body.="<tbody>";
	$c=0;
	$aux=0;
	$archivo="";
	$archivoPDF = "";
	$archivoXML = "";
	$codigo="";
	$cedula="";
	$permiso_179 	= new General();
	$permiso_181 	= new General();
	$permiso 		= new General();
	$permiso_10 	= new General();
	$permiso_10->permiso_activo($_SESSION['usua_codigo'], 10);
	$permiso_179->permiso_activo($_SESSION['usua_codigo'], 179);
	$permiso->permiso_activo($_SESSION['usua_codigo'], 180);
	$permiso_181->permiso_activo($_SESSION['usua_codigo'], 181);
	foreach($pago->rows as $row)
	{	$aux++;
	}
	foreach($pago->rows as $row)
	{	if($c<($aux-1))
		{	$codigo = $row['codigoPago'];
			$body.="<tr style='font-size:12px;'>
					<td class='details-control'><i style='color:green;' class='fa fa-plus-circle' title='Ver facturas relacionadas'></i></td>";
			$body.='<td>'.$row['codigoPago'].'</td>
					<td style="text-align:right">'.$row['totalPago'].'</td>'.
					( $tipo_visual == '1' ? '<td style="text-align:right">'.$row['saldoafavor'].'</td>' : "" ).
				   '<td>'.$row['formaPago'].'</td>';
			$opc = get_cliente_opciones( $permiso,$row['codigoAlumno'],'span',
										 $permiso_179->rows[0]['veri'],
										 $permiso->rows[0]['veri'],
										 $permiso_181->rows[0]['veri'], $row["curso"] );
			$body .= '<td>
				<div class="btn-group">
					<a href="#/" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						'.$row['nombresAlumno'].' 
					</a>'.$opc.'
				</div><br>
				'.$row['codigoAlumno'].' | ';
			
			if( $permiso_10->rows[0]['veri'] && $row["curso"] != 'CLIENTE EXTERNO' )
				$body.= "<a href='#' onclick='js_clientes_go_to_courses(\"../../../admin/cursos_paralelo_main.php?curs_para_codi=".$row['curs_para_codi']."\");' 
							data-toggle='modal' data-target='#modal_acad'
							title='Ver información del curso ".$row["curso"]."'>".$row["curso"]."</a></td>";
			else
				$body.= $row["curso"].'</td>';
				
			$body .='<td>
						<span title="Fecha de pago" onmousover="$(this).tooltip(\'show\');"><i class="fa fa-clock-o"></i> '.$row['fechaPago'].'</span> | '.
						'<span title="Cajero" onmousover="$(this).tooltip(\'show\');"><i class="fa fa-user"></i> '.$row['cajero'].'</span></td>';
				
			$spanHTML="<span class='glyphicon glyphicon-print cursorlink' id='".$codigo."_ver_pago' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n grande.' data-placement='left'></span>";
			$spanPDF="<span class='glyphicon glyphicon-print cursorlink' id='".$codigo."_ver_pago_PDF' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n punto de venta.' data-placement='left'></span>";
			$spanRevertir="<div align='center' style='display:inline-block;'><span   onclick='js_Pago_revertir(".'"'.$codigo.'"'.",".'"modal_revert_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/pagos/controller.php"'.")'    class='btn_opc_lista_eliminar fa fa-history cursorlink'  aria-hidden='true' id='".$codigo."_revertir'   onmouseover='$(this).tooltip(".'"show"'.")' data-placement='left' title='Revertir y borrar pago.'></span></div>";
			$body.="<td style='text-align:center'><a href='".$diccionario['ruta_html_finan']."/finan/PDF/imprimir/pago/".$codigo."' target='_blank'>".$spanPDF."</a></td>";
			$body.="<td style='text-align:center'><a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/pago/".$codigo."' target='_blank'>".$spanHTML."</a></td>";
			$body.="<td style='text-align:center'>".$spanRevertir."</td>";
		}
		$body.="</tr>";
		$c++;
	}
	$body.="</tbody>";
	$construct_table.=$body;
	$construct_table.="</table>";
	return $construct_table;
}
function get_cliente_opciones($permiso, $codigoCliente, $type='span', $permiso_179, $permiso_180, $permiso_181, $curso )
{	global $diccionario;
	
	if ( $curso != 'CLIENTE EXTERNO' )
	{	$cliente = 'clientes';
		$modal = 'modal_showDebtState';
	}
	else
	{   $cliente = 'clientes_externos';
		$modal = 'modal_showDebtState_ext';
	}
	if($type=='span'){$tag=''; $space='&nbsp;';}
	$client_options = array();
	$opciones = '<ul class="dropdown-menu">';
	if ($permiso_180 == 1 )
	{	$opciones.= "<li><a href='#/' onclick='carga_visorEstadoCuenta(\"".$codigoCliente."\",".'"'.$modal.'_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/'.$cliente.'/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#".$modal."'  id='".$codigoCliente."_verEstadoCuenta' onmouseover='$(this).tooltip(".'"show"'.")' style='cursor:pointer;' data-placement='left'><span style='color:#DBBCDB;' class='fa fa-file'></span> Ver estado de cuenta</a></li>";
	}
	if ($permiso_179 == 1 )
	{	$opciones.= "<li><a href='#/' onclick='js_clientes_carga_asignacion(\"".$codigoCliente."\",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/'.$cliente.'/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$codigoCliente."_asignar' 
	onmouseover='$(this).tooltip(".'"show"'.");' data-placement='left' style='cursor:pointer;' 
	><span style='color:#3a3b45;' class='fa fa-percent'></span> Asignar Descuentos</a></li>";
	}
	if ( $permiso_181 == 1 && $curso != 'CLIENTE EXTERNO' )
	{	$opciones.= "<li><a href='#/' onclick='js_clientes_carga_asignacionGrupoEconomico(\"".$codigoCliente."\",".'"modal_showSetGrupoEconomico_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/'.$cliente.'/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_showSetGrupoEconomico'  id='".$codigoCliente."_asignarGrupoEconomico' onmouseover='$(this).tooltip(".'"show"'.");'
	style='cursor:pointer;' data-placement='top'><span style='color:#D89C3F;' class='fa fa-group'></span>Asignar Grupo Económico</a></li>";
	}
	if ( $curso != 'CLIENTE EXTERNO' ) 
	{   $opciones.= "<li><a href='#/'
	onclick='carga_tabla_asign_repr(\"".$codigoCliente."\",".'"div_asign_repr"'.",".'"'.$diccionario['rutas_head']['ruta_html_common'].'/representantes/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_asign_repr'  id='".$codigoCliente."_asignar_repr' 
	style='cursor:pointer;' onmouseover='$(this).tooltip(".'"show"'.");' data-placement='top'><span style='color:#E55A2F;' class='fa fa-heart-o'></span> Asignar representante</a></li>";
	}
	return $opciones."</ul>";
}