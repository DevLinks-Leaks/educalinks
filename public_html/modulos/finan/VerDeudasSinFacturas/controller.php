<?php

session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/general/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('../../finan/puntos_emision/model.php');
require_once('constants.php');
require_once '../../../includes/finan/proc_comp_elec.php';
require_once('../../finan/facturas/model.php');
require_once('../../finan/notaCredito/model.php');
require_once('../../finan/notaDebito/model.php');
require_once('../../finan/items/model.php');
require_once('view.php');

function handler()
{	require('../../../core/rutas.php');
    $permiso 	= get_mainObject('General');
    $sucursales = get_mainObject('PtoEmision');
	$item 		= get_mainObject('Item');
	$periodo 	= get_mainObject('Periodo');
	$grupEcon 	= get_mainObject('GrupoEconomico');
    $event 		= get_actualEvents(array(VIEW_GET_ALL, RESEND_TO_SRI), VIEW_GET_ALL);
    $user_data 	= get_frontData();
	global $diccionario;
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "facturasPendiente_table";}else{$tabla =$_POST['tabla'];}
    switch ($event)
	{	case VIEW_GET_ALL:
            #  CASE QUE SE CARGA AL INICIO DE LA PAGINA
            if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			$data = array("txt_num_sucursal"		=> '',
						  "txt_num_ptoVenta"		=> '',
						  "txt_num_factura"			=> '',
						  "sucursal_codigo"			=> '',
						  "puntVent_codigo"			=> '',
						  'combo_sucursal' 			=> $sucu_combo
                          );
			
			$today=new DateTime('yesterday');
			$tomorrow=new DateTime('today');
			$data['txt_fecha_ini'] = $today->format('d/m/Y');
			$data['txt_fecha_fin'] = $tomorrow->format('d/m/Y');
			$item->get_item_selectFormat('');
			$select = "<select multiple='multiple' id=\"cmb_producto\" name=\"cmb_producto[]\" class='form-control' data-placeholder='- Seleccione producto -' style='width:320px;'>";
			
			foreach( $item->rows as $options )
			{   if (!empty($options))
				{   $select .= "<option value='".$options[0]."' >".$options[1]."</option>";
				}
			}
			$select.= "</select>";
			
			$data['cmb_producto'] = $select;
			$periodo->get_all_selectFormat();
			$data['{cmb_periodo}'] = array("elemento"  => "combo", 
											"datos"     => $periodo->rows, 
                                            "options"   => array("name"=>"periodos","id"=>"periodos", "class"=>"form-control input-sm",
																 "onChange"	=> "cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
											"selected"  => 0);
			$grupEcon->getCategorias_selectFormat_with_all('');
			$data['{cmb_grupoEconomico}'] = array("elemento"  => "combo", 
											"datos"     => $grupEcon->rows, 
                                            "options"   => array("name"=>"cmb_grupoEconomico","id"=>"cmb_grupoEconomico", "class"=>"form-control input-sm"),
											"selected"  => 0);
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			$data['{cmb_nivelEconomico}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																"id"=>"cmb_nivelesEconomicos",
																"required"=>"required",
																"class"=>"form-control input-sm",
																"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"));
			$data['{cmb_curso}']=array("elemento"  => "combo", 
										"datos"     => array(0 => array(0 => -1, 
																		1 => '- Seleccione curso -',
																		3 => ''), 
                                                                        2=> array()),
															"options"   => array("name"=>"cursos","id"=>"curso","required"=>"required","class"=>"form-control input-sm"),
										"selected"  => -1);
			
			$sucursales->get_all_sucursales_withPrefix( );
			$sucu_combo ='<select class="form-control input-sm" id="pto_sucursal" name="pto_sucursal">';
			foreach ($sucursales->rows as $sucursal)
			{   if( !empty( $sucursal ) )
					$sucu_combo.="<option data-sucu_codigo='".$sucursal[0]."' value='".$sucursal[2]."'>".$sucursal[1]."</option>";
			}
			$sucu_combo.="</select>";
			
			$data['mensaje'] = "";
			$data['tabla'] = "<div style='font-size:small;'>Haga clic en buscar para realizar una consulta.</div>";
            retornar_vista(VIEW_GET_ALL, $data);	
            break;
		case PRINT_EXCEL_ALL_DATA:
			global $diccionario;
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			//////////////////////////////////////////////////
			
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
			if(!isset($user_data['txt_ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['txt_ref_factura'];
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
			if(!isset($user_data['cmb_estado']))
				$estado = '';
			else 
				$estado = $user_data['cmb_estado'];
			if(!isset($user_data['txt_tneto_ini']))
				$tneto_ini = 0;
			else 
				$tneto_ini = (float)$user_data['txt_tneto_ini'];
			if(!isset($user_data['txt_tneto_fin']))
				$tneto_fin = 0;
			else 
				$tneto_fin = (float)$user_data['txt_tneto_fin'];
			
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator( 'Redlinks' )
			->setLastModifiedBy( 'Redlinks' )
			->setTitle("Exportación de datos de bandeja de Facturas y Documentos no autorizados en el sistema")
			->setSubject("Exportación de datos de bandeja de Facturas y Documentos no autorizados en el sistema")
			->setDescription("Exportación de datos de bandeja de Facturas y Documentos no autorizados en el sistema");
			
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
			if($tipo_documento=='FAC')
			{	if( $user_data['tipo_reporte'] == 'completo' )
				{   $cabeceras ='Factura ref.,Número de factura,Producto,Tipo Id,Id del titular,Titular,email titular,Número de autorización,'.
								'Clave de acceso,Fecha de autorización,Numero secuencial,Total bruto,Total descuento,Total I.V.A.,Total I.C.E.,Total neto,Total abonado,Alumno/Cliente ref. interna,'.
								'Alumno/Cliente nombre,Alumno/Cliente cedula,Alumno/Cliente fecha nacimiento,Fecha creacion DNA/Fecha de pago,Fecha de creación de deuda,Estado electrónico,Curso,Alumno Estado';
				}
				if( $user_data['tipo_reporte'] == 'mini' )
				{   $cabeceras ='Factura ref.,Titular,Id del titular,Sucursal,Punto de venta,Número secuencial,Total neto,Cliente ref. interna,Cliente nombre,Fecha de emisión,estado electrónico';
				}
			}
			$cabecera = explode( ",", $cabeceras );
			$i_cabe=0;//Contador de cabeceras
			$column = 'A';
			foreach($cabecera as $head)
			{	if(!empty( $head ) )
				{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i_cabe, 1, $head);
					$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(30);
					$i_cabe=$i_cabe+1;
					$column++;
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:'.$column.'1')->applyFromArray( $styleEncabezado );
			
			if($tipo_documento=='FAC')
			{	$factura = new Factura();
				if( $user_data['tipo_reporte'] == 'completo' )
				{   $factura->get_facturas_to_excel('DEUDAS SIN FACTURA', $fechavenc_ini, $fechavenc_fin,
													$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
													$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
													$estado, $tneto_ini, $tneto_fin,
													$user_data['periodos'],$user_data['cmb_grupoEconomico'],$user_data['cmb_nivelesEconomicos'],
													$user_data['cursos'],$user_data['txt_fecha_deuda_ini'],$user_data['txt_fecha_deuda_fin'],
													$user_data['txt_fecha_aut_ini'],$user_data['txt_fecha_aut_fin'] );
				}
				if( $user_data['tipo_reporte'] == 'mini' )
				{   $factura->get_facturas( 'DEUDAS SIN FACTURA', $fechavenc_ini, $fechavenc_fin,
											$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
											$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
											$estado, $tneto_ini, $tneto_fin,
											$user_data['periodos'],$user_data['cmb_grupoEconomico'],$user_data['cmb_nivelesEconomicos'],
											$user_data['cursos'],$user_data['txt_fecha_deuda_ini'],$user_data['txt_fecha_deuda_fin'],
											$user_data['txt_fecha_aut_ini'],$user_data['txt_fecha_aut_fin'] );
				}
			}
            $facturas=$factura->rows;
			$i_deta_fila=2;
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 1;
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}
			foreach ($facturas as $registro)
			{	$i_deta_col=0;
			  	foreach ($registro as $campo =>$valor )
				{	
					if ( ( $user_data['tipo_reporte'] == 'mini' && $i_deta_col == 10 ) ||  ( $user_data['tipo_reporte'] == 'completo' && $i_deta_col == 23 ) )
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i_deta_col, $i_deta_fila, 'DEUDA SIN FACTURA');
					else
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i_deta_col, $i_deta_fila, $valor);
					$i_deta_col++;
				}
				$i_deta_fila++;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Bandeja de facturas');
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_bandeja_gestion_facturas.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case GET_ALL_DATA:
            #  CASE QUE SE CARGA AL INICIO DE LA PAGINA
			if(!isset($user_data['tipoDocumentoAutorizado']))
				$tipo_documento = 'FAC';
			else 
				$tipo_documento = $user_data['tipoDocumentoAutorizado'];
			//////////////////////////////////////////////////
			
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
			if(!isset($user_data['ref_factura']))
				$ref_factura = '';
			else 
				$ref_factura = $user_data['ref_factura'];
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
				$tneto_ini = 0;
			else 
				$tneto_ini = (float)$user_data['tneto_ini'];
			if(!isset($user_data['tneto_fin']))
				$tneto_fin = 0;
			else 
				$tneto_fin = (float)$user_data['tneto_fin'];
			
			////////////////////////////////////
			if($tipo_documento=='FAC')
			{	$factura = new Factura();
				$factura->get_facturas('DEUDAS SIN FACTURA', $fechavenc_ini, $fechavenc_fin,
										$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
										$nombre_titular, $ptvo_venta, $sucursal, $ref_factura, $prod_codigo, 
										$estado, $tneto_ini, $tneto_fin,
										$user_data['periodo'],$user_data['grupoEconomico'],$user_data['nivelEconomico'],
										$user_data['curso'],$user_data['fechadeuda_ini'],$user_data['fechadeuda_fin'],
										$user_data['fechaAut_ini'],$user_data['fechaAut_fin']);
				//$data['mensaje'] = "Bandeja de facturas autoziadas";
			}
			$data['tabla'] = tablaDeudaSinFactura($tabla, $factura, $permiso, $tipo_documento);
			retornar_result($data);
            break;
        case CONVERT_TO_FAC:
			$factura = new Factura();
			$factura->convert_DNA_to_FAC( 	$user_data['codigoDocumento'], 
											$user_data['sucursal'],
											$user_data['ptoVenta'],
											$user_data['puntoVenta_codigo'],
											$user_data['numeroFactura'],
											$_SESSION['usua_codigo'],
											$_SESSION['USUA_TIPO_CODI']);
			echo $factura->mensaje;
            break;
        default:
            break;
    }
}
handler();
function tablaDeudaSinFactura($tabla, $factura, $permiso, $tipo_documento)
{	global $diccionario;
	$anidado = "";
	if ($tipo_documento=='FAC')
	{	$dir_tdoc_detail='factura';
		$anidado = "<th style=\"text-align:center;vertical-align:middle\"></th>";
	}
	$opciones="";
	$construct_table="
				<br>
				<table class='table table-striped table-hover' id='".$tabla."' cellpadding='0' cellspacing='0' border='0' >
					<thead>
						<tr style='font-size:small;text-align:center; background-color:#E55A2F;color:white;'>
							".$anidado."
							<th >Ref.</th>
							<th>T. Neto</th>
							<th>C&oacute;digo</th>
							<th>Estudiante</th>
							<th>Fecha pago</th>
							<th style='text-align:center'>DNA HTML</th>
							<th style='text-align:center'>Convertir en Factura</th>
						</tr>
					</thead>";
	$body="<tbody>";
	$c=0;
	$aux=0;
	$archivo="";
	$archivoXML = "";
	$codigo="";
	$cedula="";
	$dontprint = "false";
	$permiso_179 	= new General();
	$permiso_181 	= new General();
	$permiso 		= new General();
	$permiso_179->permiso_activo($_SESSION['usua_codigo'], 179);
	$permiso->permiso_activo($_SESSION['usua_codigo'], 180);
	$permiso_181->permiso_activo($_SESSION['usua_codigo'], 181);
	foreach($factura->rows as $row)
	{	$aux++;
	}
	foreach($factura->rows as $row)
	{   $dontprint = "false";
		if($c<($aux-1))
		{	$body.="<tr style='font-size:11px;'>";
			if ($tipo_documento=='FAC')
				$body.="<td class='details-control'><i style='color:green;' class='fa fa-plus-circle'></i></td>";
			$x=0;
			$datos="";
			foreach($row as $column)
			{	if($x==1)
				{	$datos.="<div style=\"text-align:left;\">".
								"<table><tr><td style=\"vertical-align:top;\"><b>Titular:&nbsp;</b></td><td>". $column."</td></tr>";
				}
				elseif($x==2)
				{	$datos.="<tr><td><b>C&eacute;dula:&nbsp;</b></td><td>". $column."</td></tr>";
					$cedula = $column;
				}
				elseif($x==3)
				{	$archivo = $column;
				}
				elseif($x==4)
				{	$archivo.= "-" . $column;
				}
				elseif($x==5)
				{	if ( $column == NULL )
						$dontprint = 'true';
					
					$archivo.= "-" . $column;
					$datos.="<tr><td><b>".$tipo_documento.":&nbsp;</b></td><td>". $archivo."</td></tr></table></div>";
				}
				elseif($x==6)
				{	if ( $dontprint == 'true' )
					{
						//$body.="<td></td>"; //no hacer nada
					}	
					else
						$body.= "<td style='text-align:center;'>".
								"<span class='detalle' id='".$codigo."_cliente_direccion' onmouseover='$(this).tooltip(".'"show"'.")' title='".$datos."' data-placement='bottom'>".
									"<span class='fa fa-search'></span></span></td>";
					
					
					$body.="<td>".$column."</td>";
				}
				elseif( $x == 8 )
				{	$opc = get_cliente_opciones( $permiso,$row['codigoAlumno'],'span',
												 $permiso_179->rows[0]['veri'],
												 $permiso->rows[0]['veri'],
												 $permiso_181->rows[0]['veri'] );
					$body .= '<td style="font-size:small;">
						<div class="btn-group">
							<a href="#/" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								'.$column.'
							</a>
							'.$opc.'
						</div></td>';
				}
				elseif($x==10)
				{	//: do nothing
				}
				elseif($x==11)
				{	//: do nothing
				}
				else
				{	$body.="<td>".$column."</td>";
					if($x==0)
					{	$codigo = $column;
					}
				}
				$x++;
			}
			$dir_archivos = $ruta_visor."/documentos/autorizados/".$_SESSION['directorio']."/".$cedula."/";
			if ($row['totalNetoFactura'] == '$0.00' )
				$spanXML= 'N/A';
			else
				$spanXML= "<span class='fa fa-refresh btn_opc_lista_eliminar' id='".$row['codigoFactura']."_makeFAC' onmouseover='$(this).tooltip(".'"show"'.")' 
					onclick='js_verDeudasSinFacturas_convertToFAC(".$codigo.");'
					data-target='#modal_convertToFac' data-toggle='modal'
					title='Generar factura y enviarla a bandeja de gestión facturas' data-placement='bottom'></span>";
				
			$spanHTML="<span class='glyphicon glyphicon-print' id='".$codigo."_ver_factura' onmouseover='$(this).tooltip(".'"show"'.")' title='Ver documento en HTML' data-placement='left'></span>";
			$body.="<td style='text-align:center'><a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/".$dir_tdoc_detail."/".$codigo."' target='_blank'>".$spanHTML."</a></td>";
			$body.="<td style='text-align:center'>".$spanXML."</td>";
		}
		$body.="</tr>";
		$c++;
	}
	$construct_table.=$body;
	$construct_table.="</tbody></table>";
	return $construct_table;
}
function get_cliente_opciones($permiso, $codigoCliente, $type='span', $permiso_179, $permiso_180, $permiso_181 )
{	global $diccionario;
	if($type=='span'){$tag=''; $space='&nbsp;';}
	$client_options = array();
	$opciones = '<ul class="dropdown-menu">';
	if ($permiso_180 == 1 )
	{	$opciones.= "<li><a href='#/' onclick='carga_visorEstadoCuenta(\"".$codigoCliente."\",".'"modal_showDebtState_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_showDebtState'  id='".$codigoCliente."_verEstadoCuenta' onmouseover='$(this).tooltip(".'"show"'.")' style='cursor:pointer;' data-placement='left'><span style='color:#DBBCDB;' class='fa fa-file'></span> Ver estado de cuenta</a></li>";
	}
	if ($permiso_179 == 1 )
	{	$opciones.= "<li><a href='#/' onclick='js_clientes_carga_asignacion(\"".$codigoCliente."\",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$codigoCliente."_asignar' 
	onmouseover='$(this).tooltip(".'"show"'.");' data-placement='left' style='cursor:pointer;' 
	><span style='color:#3a3b45;' class='fa fa-percent'></span> Asignar Descuentos</a></li>";
	}
	if ( $permiso_181 == 1 )
	{	$opciones.= "<li><a href='#/' onclick='js_clientes_carga_asignacionGrupoEconomico(\"".$codigoCliente."\",".'"modal_showSetGrupoEconomico_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_showSetGrupoEconomico'  id='".$codigoCliente."_asignarGrupoEconomico' onmouseover='$(this).tooltip(".'"show"'.");'
	style='cursor:pointer;' data-placement='top'><span style='color:#D89C3F;' class='fa fa-group'></span>Asignar Grupo Económico</a></li>";
	}
	$opciones.= "<li><a href='#/'
	onclick='carga_tabla_asign_repr(\"".$codigoCliente."\",".'"div_asign_repr"'.",".'"'.$diccionario['rutas_head']['ruta_html_common'].'/representantes/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_asign_repr'  id='".$codigoCliente."_asignar_repr' 
	style='cursor:pointer;' onmouseover='$(this).tooltip(".'"show"'.");' data-placement='top'><span style='color:#E55A2F;' class='fa fa-heart-o'></span> Asignar representante</a></li>";
	
	return $opciones."</ul>";
}