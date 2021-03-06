<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('/../items/model.php');
require_once('constants.php');
require_once('model.php');
require_once('/../bancos/model.php');
require_once('/../tarjetasCredito/model.php');
require_once('view.php');

function handler()
{	$debito 	= get_mainObject('DebitosAutomaticos');
	$formatos 	= get_mainObject('DebitosAutomaticos');
	$carga		= get_mainObject('DebitosAutomaticos');
	$settings	= get_mainObject('DebitosAutomaticos');
	$para_sist	= get_mainObject('General');
	$item 		= get_mainObject('Item');
    $event 		= get_actualEvents(array(VIEW_CARGA_FILE,VIEW_MAINT,VIEW_GENERA_FILE,UPLOAD,CREATE_FILE,GET_FORMATOS,VIEW_MENSAJE), VIEW_GENERA_FILE);
    $debito_data= get_frontData();
	$tarjCredito= get_mainObject('tarjCredito');
	$banco		=get_mainObject('Bancos');
	if (!isset($_POST['busq'])){$debito_data['busq'] = "";}else{$debito_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "genera_file_table";}else{$tabla=$_POST['tabla'];}
	
    switch ($event)
	{	case VIEW_GENERA_FILE:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            
			$debito->get_all_campos( 'V_DatosAlumnosDebitos_Detalle' );
			$formatos->get_all_formatos();
			$item->get_item_selectFormat('');
			$item->rows[0][1]='- Todos -';
			$banco->get_bancofromCatologoSelectFormat( 1 ); //1 para que traiga opción 'todos'
			$tarjCredito->get_tarjetasfromCatologoSelectFormat( 1 ); //1 para que traiga opción 'todos'
			$settings->get_debitoautomatico_config();

			$data = array(	'{combo_campos_file}' =>array("elemento"=> "combo",
                                                      	"datos"     => $debito->rows, 
                                                      	"options"   => array("name"=>"campos_add","id"=>"campos_add","required"=>"required","class"=>"form-control"),
                                                      	"selected"  => 0),
						    '{cmb_copyPaste_formato}' => array(  	"elemento"  => "combo", 
																	"datos"     => $formatos->rows, 
																	"options"   => array("name"=>"formatos_add","id"=>"formatos_add","required"=>"required","class"=>"form-control","disabled"=>"disabled"),
																	"selected"  => 0),
							'{cmb_banco}' => array( "elemento"  => "combo",
													"datos"     => $banco->rows,
													"options"   => array(	"name" => "cmb_banco",
																			"class" => "form-control",
																			"id" => "cmb_banco"),
													"selected"  => 0),
							'{cmb_tarjCredito}' =>array("elemento"  => "combo",
													"datos"     => $tarjCredito->rows,
													"options"   => array(	"name" => "cmb_tarjCredito",
																			"class" => "form-control",
																			"id" => "cmb_tarjCredito"),
													"selected"  => 0),
							'hd_exp_opc_ant' 	=> $settings->rows[0]['check_exp_opc_ant'],
							'hd_exp_opc_ctas'	=>$settings->rows[0]['check_exp_opc_ctas'],
							'mensaje'			=>$debito->mensaje);
			
			$item->get_item_selectFormat('');
			$select = "<select multiple='multiple' id=\"cmb_producto\" name=\"cmb_producto[]\" class='form-control' data-placeholder='- Seleccione producto -' style='width:320px;'>";
			
			foreach( $item->rows as $options )
			{   if (!empty($options))
				{   $select .= "<option value='".$options[0]."' >".$options[1]."</option>";
				}
			}
			$select.= "</select>";
			
			$formatos->get_all_formatos();
			$combo = "<select multiple='multiple' class='select2-select form-control' id='formatos_add' name='formatos_add[]' style='width: 400px;'>";
			foreach( $formatos->rows as $rows)
			{ 	if( !empty( $rows ) )
					$combo.= "<option value='".$rows['form_debi_codigo']."'>".$rows['form_debi_descripcion']."</option>";
			}
			$combo.= "</select>";
			$data['cmb_carga_formato'] = $combo;

			$data['cmb_producto'] = $select;
			$data['active1']='';
			$data['active2']='';
			$data['active3']='in active';
			$data['tab_class1']='';
			$data['tab_class2']='';
			$data['tab_class3']='class="active"';
			if(( $_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0) or empty($_SESSION['puntVent_codigo']))
			{   $data['hd_caja_abierta']='false';
			}
			else
			{   $data['hd_caja_abierta']='true';
			}
			retornar_vista(VIEW_GENERA_FILE, $data);
			break;
		case GET_DEBT_AUT_SETTINGS:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			$settings->get_debitoautomatico_config();
			echo '<label>Al momento de exportar:</label>
						<div class="checkbox" style="display:none;">
							<label>
								<input type="checkbox" id="check_exp_opc_ant" 
									name="check_exp_opc_ant" '.($settings->rows[0]['check_exp_opc_ant'] == 'S' ? 'checked': '' ).'> Preguntar por clientes con deudas antiguas por pagar.
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" id="check_exp_opc_ctas" 
									name="check_exp_opc_ctas" '.($settings->rows[0]['check_exp_opc_ctas'] == 'S' ? 'checked': '' ).'> Preguntar por clientes con intentos fallidos de débito.
							</label>
						</div>';
			break;
		case SET_DEBT_AUT_SETTINGS:
			$check_exp_opc_ant = $check_exp_opc_ctas = "";

			if ( $debito_data['check_exp_opc_ant'] == 'true' )
				$check_exp_opc_ant = 'S';
			else
				$check_exp_opc_ant = 'N';

			if ( $debito_data['check_exp_opc_ctas'] == 'true' )
				$check_exp_opc_ctas = 'S';
			else
				$check_exp_opc_ctas = 'N';

			$settings->set_debitoautomatico_config( $check_exp_opc_ant , $check_exp_opc_ctas );
			print_r($settings->mensaje);
			break;
		case VIEW_GENERA_FILE_AJAX:
			if(( $_SESSION['caja_fecha']< date('Ymd') or $_SESSION['caja_codi']==0) or empty($_SESSION['puntVent_codigo']))
			{   $data['hd_caja_abierta']='false';
			}
			else
			{   $data['hd_caja_abierta']='true';
			}
			retornar_formulario(VIEW_GENERA_FILE_AJAX, $data);
			break;
		case GET_MAINT:
			global $diccionario;
			$url = '"'.$diccionario['rutas_head']['ruta_html_finan'].'/debitosAutomaticos/controller.php"';
			$formatos->get_all_formatos_maint();
			
			$body.="<table class='table table-striped table-hover' id='table_formato' name='table_formato'>
						<thead style='background-color:#E55A2F;color:white;'>
							<tr>
								<th>Lista de formatos creados</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>";
			foreach ($formatos->rows as $rows)
			{
				if( !empty( $rows ) )
				{
					$body.="<tr>
								<td data-codigo='".$rows['ref']."'>
									<span title='Haz click aquí para exportar formato' onclick='js_debtAut_genera_archivoind(".$rows['ref'].");'  style='font-size:large;cursor:pointer;'><b><i style='color:#17ca34' class='fa fa-file-excel-o'></i> ".$rows['name']."</b></span><br><span style='font-size:x-small;'><b>Ref.:</b> ".$rows['ref']." | <b>Usuario creador:</b> ".$rows['user'].
									" | <b>Fecha creación:</b> ".$rows['date']."</span>
								</td>
								<td span style='font-size:small;' data-source='".$rows['form_debi_vista']."'>
									<span style='font-size:medium;'>Información: <span style='color:#797B7D'>".$rows['fuente_datos']."</span></span>".
									"<br><span style='font-size:x-small;'>".$rows['numero_campos']." columnas ".($rows['secuencial'] == 1 ? '(incluída secuencial)' : '' )."</span></td>
								<td style='vertical-align:middle'>
									<span onclick='js_debtAut_genera_archivoind(".$rows['ref'].");' 
										class='btn_opc_lista_exportar glyphicon glyphicon-export cursorlink' 
										aria-hidden='true' id='".$rows['ref']."_genera_archivo' onmouseover='$(this).tooltip(".'"show"'.")' 
										data-placement='left' title='Exportar formato'></span>&nbsp;&nbsp;
									<span onclick='js_debtAut_copiar_archivo_open_modal(".$rows['ref'].",".$url.")'
										class='btn_opc_lista_copiar glyphicon glyphicon-copy cursorlink' 
										aria-hidden='true' id='".$rows['ref']."_copiar_archivo' onmouseover='$(this).tooltip(".'"show"'.")' 
										data-placement='bottom' title='Copiar formato'></span>&nbsp;&nbsp;
									<span onclick='js_debtAut_del(".$rows['ref'].",".'"div_tbl_format"'.",".$url.")'
										class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' 
										aria-hidden='true'id='".$rows['ref']."_del' onmouseover='$(this).tooltip(".'"show"'.")'
										data-placement='top' title='Eliminar formato'></span>
								</td>
							</tr>";
				}
			}
			$body.="	</tbody>
					</table>";

			$data['tbl_formato'] = $body;
			retornar_formulario(VIEW_MAINT, $data);
			break;
		case GET_FORMATOS:
            global $diccionario;
			$formatos->get_all_formatos();
			$combo = "<select multiple='multiple' class='js-example-basic-single' id='formatos_add' name='formatos_add[]' style='width: 400px;'>";
			foreach( $formatos->rows as $rows)
			{ 	if( !empty( $rows ) )
					$combo.= "<option value='".$rows[0]."'>".$rows[1]."</option>";
			}
			$combo.= "</select>";
			$data['cmb_carga_formato'] = $combo;
			retornar_result($data);
            break;
		case GET_FORMATOS_COPYPASTE:
            global $diccionario;
			$formatos->get_all_formatos();
			$data = array('{cmb_formato_copyPaste}' => array("elemento"  => "combo", 
                                                      	"datos"     => $formatos->rows, 
                                                      	"options"   => array("name"=>"cmb_formato_copyPaste","id"=>"cmb_formato_copyPaste","required"=>"required","class"=>"form-control","disabled"=>"disabled"),
                                                      	"selected"  => 0),
							'mensaje'=>$debito->mensaje);
			
			retornar_result($data);
            break;
		case DELETE:
            global $diccionario;
			$formatos->delete_specific_format();
			$resultado = $formatos->delete_specific_format($debito_data['form_debi_codigo']);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;
		case SAVE_FORMAT_FILE:
            $formato=array();
			$formato = json_decode($debito_data['formato'], true);
			
			$lineaDetalle = 0;
            $esquemaXML = '<?xml version="1.0" encoding="iso-8859-1"?>';
            $esquemaXML .= '<cobro>';
            $esquemaXML .=  '<cabecera ';
            $esquemaXML .=    'nombreformato="'	.$formato['nombre_formato'].'" ';
			$esquemaXML .=    'idformato="'		.$formato['id_formato'].'" ';
            $esquemaXML .=    'usuario="'		.$_SESSION['usua_codigo'].'" ';
         	$esquemaXML .=    'secuencial="'	.$debito_data['check'].'" ';
			$esquemaXML .=    'secuencia="'		.$debito_data['iniciosecuencial'].'" ';
			$esquemaXML .=    'ubicasecuencia="'.$debito_data['ubicasecuencia'].'" ';
			$esquemaXML .=    'vista="'			.$debito_data['vista'].'" ';
            $esquemaXML .=  "/>";
            $esquemaXML .=  '<detalles>';
			
			foreach ($formato['detalles'] as $detalle)
			{   if($detalle['campo']!='')
				{   $lineaDetalle += 1;
					$esquemaXML .=  '<linea ';
					$esquemaXML .=    'campo="'				.$detalle['campo'].'" ';
					$esquemaXML .=    'text_predefinido="'	.$detalle['text_predif'].'" ';
					$esquemaXML .=    'cabecera="'        	.$detalle['cabecera'].'" ';
					$esquemaXML .=    'numcaracteres="'   	.$detalle['num_caracteres'].'" ';
					$esquemaXML .=    'orden="'	   			.$detalle['orden'].'" ';
					$esquemaXML .=    'izquierda="'			.$detalle['izquierda'].'" ';
					$esquemaXML .=    'derecha="'  			.$detalle['derecha'].'" ';
					$esquemaXML .=    'caracder="' 			.$detalle['caracder'].'" ';
					$esquemaXML .=    'caracizq="' 			.$detalle['caracizq'].'" ';
					$esquemaXML .=  ' />';
				}
			}
			$esquemaXML .=  "</detalles>";
            $esquemaXML .= "</cobro>";
			$resultado = $debito->setdebito($esquemaXML);
			$data = array("mensaje" 				=> $resultado->mensaje,
						  "hd_nombreformato" 		=> $resultado->nombreformato_out,
						  "hd_id_cabecera"			=> $resultado->id_cabecera_out);
			echo json_encode($data, true);
			break;
		case UPLOAD:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión"; echo "KO";}
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel/IOFactory.php');
			$target_dir= "../../../uploads/";
			
			$nombrearchivo=$_FILES["fileToUpload"]["name"];
			$_FILES["fileToUpload"]["name"]='Cargabancaria.xls';
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"]))
			{	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false)
				{	//echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				}
				else
				{	//echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file))
			{	//echo "El archivo ya existe y ser&aacute; reemplzado.";
				$uploadOk = 1;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000)
			{	//echo "El archivo es demasiado pesado.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "xlsx" && $imageFileType != "xls" )
			{	//echo "Solo xlsx, xls archivos son permitidos.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0)
			{	//echo "El archivo no se pudo cargar.";
			// if everything is ok, try to upload file
			}
			else 
			{	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
				{	//echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " fue cargado.";
				}
				else
				{	//echo "Ha habido un error cargando el archivo.";
				}
			}
			break;
		case VIEW_MENSAJE:
				
			$data =	array(	"saldoafavor"	=>$_POST['contador3'],
							"pagado"	=>$_POST['contador1'],
							"nopagado"	=>$_POST['contador2'],
							
						
			);
			retornar_vista(VIEW_SHOWMENSAJE, $data);
			break;
		case PROCESAR_FORM:
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel/IOFactory.php');
			$target_dir = "../../../uploads/";	
			$target_file = $target_dir . 'Cargabancaria.xls';
			
			try
			{	class myReadFilter implements PHPExcel_Reader_IReadFilter
				{	private $_startRow = 0;
					private $_endRow = 0;
				
					/**  Set the list of rows that we want to read  */
					public function setRows($startRow) {
						$this->_startRow    = $startRow;
				
					}
				
					public function readCell($column, $row, $worksheetName = '') {
						//  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow
						if (($row >= $this->_startRow)) {
							return true;
						}
						return false;
					}
				}
				
				$inputFileType = PHPExcel_IOFactory::identify($target_file);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				
				$primerafila=0;
				$textook=0;
				if($debito_data['textook']=='')
				{$textook='ok';}
				else
				{$textook=$debito_data['textook'];}
				
				if($debito_data['filainicia']!='')
				{$primerafila=$debito_data['filainicia'];}
				else
				{ $primerafila=0;}
				$chunkFilter = new myReadFilter();
				$objReader->setReadFilter($chunkFilter);
				$chunkFilter->setRows($primerafila);
				
				$objPHPExcel = $objReader->load($target_file);
				
			}
			catch(Exception $e)
			{	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
			$highestColumn = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());
			$codigodeuda=0;$valor=0;
			$columna=0;$columna2=0;$columna3=0;
			$contador1=0;$contador2=0;$contador3=0;$rowcontador=0;
			
			//  Loop through each row of the worksheet in turn
			$acu=0;
			$error_espacio = 0;
			for ($i=$primerafila; $i<=$highestRow; $i++)
			{	$cabec[][] = array();

				$params[][] = array();
				for ($j=0; $j<$highestColumn; $j++)
				{
					$params[$i][$j] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
					//var_dump($params);
					if ( $params[$i][$j] != '' && $params[$i][$j] != null )
					{   if( $i == $primerafila )
						{   $cabec[$acu][0]=$acu;
							if( $params[$i][$j]!='' && $params[$i][$j] != null  )
							{	$cabec[$acu][1] = $params[$i][$j];
								$docu.= $params[$i][$j];
								if (preg_match('/\s/',$params[$i][$j]))
									$error_espacio ++;
							}
							$acu=$acu+1;
						}
					}
				}
			}
			//echo $docu;
			
			$data =	array(	'{combo_codigodeuda}'=>array("elemento" => "combo", 
                                                      	"datos"     => ($error_espacio == 0 ? $cabec : array()), 
                                                      	"options"   => array("name"=>"coddeuda","id"=>"coddeuda","required"=>"required","class"=>"form-control"),
                                                      	"selected"  => 0),
							'{combo_estado}' => array("elemento"  => "combo", 
                                                      	"datos"     => ($error_espacio == 0 ? $cabec : array()), 
                                                      	"options"   => array("name"=>"estado","id"=>"estado","required"=>"required","class"=>"form-control"),
                                                      	"selected"  => 0),
							'{combo_valor}' => array("elemento"  => "combo", 
                                                      	"datos"     => ($error_espacio == 0 ? $cabec : array()), 
                                                      	"options"   => array("name"=>"valor","id"=>"valor","required"=>"required","class"=>"form-control"),
                                                      	"selected"  => 0),
					);
			
			if ( $error_espacio >0  )
			{	$data['txt_mensaje'] = '<div class="alert alert-danger" role="alert">
					<p><span class="fa fa-times-circle" aria-hidden="true"></span>
						Educalinks Informa
						<hr style="padding:3px;margin:0px;">
						Los campos de la cabecera no pueden tener espacios en blanco. Por favor, revisar que no existan caracteres de espacio y subir nuevamente.</p>
				</div>';
				$data['display_muestra_archivo_ok'] = 'style="display:none;"';
			}
			else
			{	$data['txt_mensaje'] = '<div class="alert alert-success" role="alert">
					<p><span class="fa fa-check" aria-hidden="true"></span>&nbsp;<span class="fa fa-file-excel-o" aria-hidden="true"></span>&nbsp;
						Educalinks Informa
						<hr style="padding:3px;margin:0px;">
						El archivo fue cargado con &eacute;xito y est&aacute; listo para procesarse.</p>
				</div>';
				$data['display_muestra_archivo_ok'] = '';
			}
			$data['txt_fecha_debito'] = $debito_data['txt_fecha_debito'];
			retornar_formulario(VIEW_PROCESAR,$data);
			break;
		case PROCESAR_ARCHIVO:
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel/IOFactory.php');
			$target_dir = "../../../uploads/";	
			$target_file = $target_dir . 'Cargabancaria.xls';
			
			try 
			{	class myReadFilter implements PHPExcel_Reader_IReadFilter
				{	private $_startRow = 0;
				
					private $_endRow = 0;
				
					/**  Set the list of rows that we want to read  */
					public function setRows($startRow)
					{	$this->_startRow    = $startRow;
					}
				
					public function readCell($column, $row, $worksheetName = '')
					{	//  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow
						if (($row >= $this->_startRow))
						{	return true;
						}
						return false;
					}
				}
			
				$inputFileType = PHPExcel_IOFactory::identify($target_file);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$primerafila=0;
				$textook=0;
				$textonook=0;
				if($debito_data['textook']=='')
				{	$textook='ok';
				}
				else
				{	$textook=$debito_data['textook'];
				}
				
				if($debito_data['textonook']=='')
				{	$textonook='ko';
				}
				else
				{	$textonook=$debito_data['textonook'];
				}

				if($debito_data['filainicia']!='')
				{	$primerafila=$debito_data['filainicia'];
				}
				else
				{ 	$primerafila=0;
				}
				$chunkFilter = new myReadFilter();
				$objReader->setReadFilter($chunkFilter);
				$chunkFilter->setRows($primerafila);
				
				$objPHPExcel = $objReader->load($target_file);
				
			}
			catch(Exception $e)
			{	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
			$highestColumn = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());
			$codigodeuda=0;$valor=0;
			$columna=0;$columna2=0;$columna3=0;
			$contador1 = $contador2 = $contador3 = $contador4 = $contador5 = $rowcontador=0;
			$pago = $sinliquidez = 0;
			//  Loop through each row of the worksheet in turn
			$acu=0;
			for ($i=$primerafila; $i<=$highestRow; $i++)
			{	$cabec[][] = array();

				$params[][] = array();
				for ($j=0; $j<$highestColumn; $j++)
				{	$params[$i][$j]=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
				
					if($params[$i][$j]==$debito_data['codeuda'])
					{	$columna=$j;
					}
					if($params[$i][$j]==$debito_data['estado'])
					{	$columna3=$j;
					}
					if($params[$i][$j]==$debito_data['valor'])
					{	$columna2=$j;
					}
					if($params[$i][$columna]!='' &&  $j==$columna)
					{	$codigodeuda=$params[$i][$columna];
					}
					if($params[$i][$columna2]!='' &&  $j==$columna2)
					{	$valor=$params[$i][$columna2];	
					}
					if($params[$i][$columna3]==$textook &&  $j==$columna3)
					{	$pago=$pago+1;
					}
					if($params[$i][$columna3]==$textonook &&  $j==$columna3)
					{	$sinliquidez = $sinliquidez+1;
					}
					else if($params[$i][$columna3]!=$textook && $params[$i][$columna3]!=$textonook && $j==$columna3 && $params[$i][$columna3]!='')
					{	$pago=$pago+0;
						$contador4 = $contador4 + 1;
						//$hola=$params[$i][$columna3];
					}
					else
					{ 	$pago=$pago+0;
					}
				}
				if($pago>0)
				{	$carga->setpagodebito( $codigodeuda, str_replace(",", ".", $valor), $_SESSION['usua_codigo'], $nombrearchivo, $debito_data['fecha_debito'], $debito_data['id_formaPago'] );
					$rowcontador = $carga->rows[0];
					$contador1 = $contador1 + $rowcontador['contadorpagados'];
					$contador2 = $contador2 + $rowcontador['contadorabonados'];
					$contador3 = $contador3 + $rowcontador['contadorsaldoafavor'];
				}
				if($sinliquidez>0)
				{
					if ( $debito_data['id_formaPago'] == 8 ) //sólo si es débito bancario, registra cuenta sin liquidez.
					{	$carga->setpagodebito_sinliquidez( $codigodeuda, str_replace(",", ".", $valor), $_SESSION['usua_codigo'],
															$nombrearchivo, $debito_data['fecha_debito'], $debito_data['id_formaPago'] );
						$contador5 = $contador5 + 1;
					}
				}
				$pago = $sinliquidez = 0;
			}	
			$data =	array(	"saldoafavor"	=> $contador3 ,
							"pagado"		=> $contador1 ,
							"abonado"		=> $contador2 ,
							"nonada"		=> $contador4,
							"sinliquidez"	=> $contador5
					);
			$data['active1']='';
			$data['active2']='in active';
			$data['active3']='';
			$data['tab_class1']='class="active"';
			$data['tab_class2']='';
			$data['tab_class3']='';
			$data['tab_class4']='';
			//header("Location: http://".$_SERVER['HTTP_HOST']."/finan/site_media/html/debitosAutomaticos/debauto_resultado.php?event=mensaje&contador1=$contador1&contador2=$contador2&contador3=$contador3&columna=$highestColumn&row=$highestRow&estado=$pago");
			retornar_formulario(VIEW_SHOWMENSAJE,$data);
			break;
		case GET_CAMPOS:
			$data =	array(	"label"			=> $debito_data['value'],
							"descripcion"	=> "",
							"name"			=> "campo_".$debito_data['num_campo'],
							"id"			=> "campo_".$debito_data['num_campo'],
							"placeholder"	=> $debito_data['text'],
							"num_campo"		=> $debito_data['num_campo'],
							"text_predif" 	=> "",
							"num_caracteres"=> "",
							"text_izq" 		=> "",
							"text_der" 		=> ""
						  );
			if($debito_data['value'] != 'otro')
			{	$data['cabe_readonly'] = " readonly='readonly' ";
				$data['descripcion'] = $debito_data['text'];
				$data['name'] = $debito_data['value'];
				$data['id'] = $debito_data['value'];
			}
			if($debito_data['val_izq'] == true)
			{   $data['val_izq'] = ' checked = "checked" ';
				$data['text_izq_dis'] = '';
			}
			else
			{	$data['val_izq'] = '';
				$data['text_izq_dis'] = ' disabled="disabled" ';
			}
			if($debito_data['val_der'] == true)
			{   $data['val_der'] = ' checked = "checked" ';
				$data['text_der_dis'] = '';
			}
			else
			{	$data['val_der'] = '';
				$data['text_der_dis'] = ' disabled="disabled" ';
			}
			retornar_formulario(VIEW_CAMPOS, $data);
			break;
		case CARGA_FORMATO:
			$debi_cab_datos=array();
			$form_debi_deta_codigos=array();
			$formatos->get_formato($debito_data['formatos_add']);
			$debi_cab_datos=$formatos->rows;
			$formulario_retornado="";
			$i=0;
			foreach($formatos->rows as $valor)
			{	$form_debi_deta_codigos[$i]['codigo'] = $valor['form_debi_deta_codigo'];
				$form_debi_deta_codigos[$i]['value'] = $valor['form_debi_deta_campo'];
				$form_debi_deta_codigos[$i]['text'] = $valor['form_debi_deta_cabecera'];
				$form_debi_deta_codigos[$i]['num_campo'] = $valor['form_debi_deta_orden'];
				$form_debi_deta_codigos[$i]['text_predif'] = $valor['form_debi_deta_text_predif'];
				$form_debi_deta_codigos[$i]['num_caracteres'] = $valor['form_debi_deta_num_caracteres'];
				$form_debi_deta_codigos[$i]['val_izq'] = $valor['form_debi_deta_val_izq'];
				$form_debi_deta_codigos[$i]['text_izq'] = $valor['form_debi_deta_text_izq'];
				$form_debi_deta_codigos[$i]['val_der'] = $valor['form_debi_deta_val_der'];
				$form_debi_deta_codigos[$i]['text_der'] = $valor['form_debi_deta_text_der'];
				$i++;
			}
			array_pop($form_debi_deta_codigos);
			$data = array("secuencial" 				=> $debi_cab_datos[0]['form_debi_colsecuencial'],
						  "secuencia" 				=> $debi_cab_datos[0]['form_debi_ultsecuencial'],
						  "ubicacion" 				=> $debi_cab_datos[0]['form_debi_ubicasecuencial'],
						  "vista" 					=> $debi_cab_datos[0]['form_debi_vista'],
						  "numrows"					=> count($formatos->rows),
						  "hd_id_cabecera"			=> $debi_cab_datos[0]['form_debi_codigo'],
						  "hd_nombreformato"		=> $debi_cab_datos[0]['form_debi_descripcion'],
						  "form_debi_deta_codigos"	=> $form_debi_deta_codigos
						  );
			echo json_encode($data, true);
			break;
		case CARGA_FORMATO_CAMPO:
			$data =	array(	"label"			=> $debito_data['value'],
							"descripcion"	=> $debito_data['text'],
							"name"			=> "campo_".$debito_data['num_campo'],
							"id"			=> "campo_".$debito_data['num_campo'],
							"placeholder"	=> $debito_data['text'],
							"num_campo"		=> $debito_data['num_campo'],
							"text_predif" 	=> $debito_data['text_predif'],
							"num_caracteres"=> $debito_data['num_caracteres'],
							"text_izq" 		=> $debito_data['text_izq'],
							"text_der" 		=> $debito_data['text_der']
						  );
			if(substr($debito_data['value'],0,5) != 'campo')
			{	$data['cabe_readonly'] = " readonly='readonly' ";
				$data['name'] = $debito_data['value'];
				$data['id'] = $debito_data['value'];
			}
			if($debito_data['val_izq'] == true)
			{   $data['val_izq'] = ' checked = "checked" ';
				$data['text_izq_dis'] = '';
			}
			else
			{	$data['val_izq'] = '';
				$data['text_izq_dis'] = ' disabled="disabled" ';
			}
			if($debito_data['val_der'] == true)
			{   $data['val_der'] = ' checked = "checked" ';
				$data['text_der_dis'] = '';
			}
			else
			{	$data['val_der'] = '';
				$data['text_der_dis'] = ' disabled="disabled" ';
			}
			retornar_formulario(VIEW_CAMPOS, $data);
			break;
		case CREATE_FILE:
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator($para_sist->para_sist(2))
			->setLastModifiedBy($para_sist->para_sist(2))
			->setTitle("Archivo de carga de débitos")
			->setSubject("Formato de Carga de Débitos")
			->setDescription("Archivo para carga de débitos automáticos al banco.");
			
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
			$cabeceras=array();
			$cabeceras_campo="";
			$cabecera_completa="";
			$debi_cab_datos=array();
		
			$formatos->get_formato($debito_data['hd_id_formato_exp']);
			
			$debi_cab_datos=$formatos->rows;
			
			$cabe_aux = 0;
			foreach($debi_cab_datos as $valor)
			{	$cabe_aux++;
				if( $debi_cab_datos[0]['form_debi_ubicasecuencial'] == $cabe_aux )
				{   if($debi_cab_datos[0]['form_debi_colsecuencial']=="1")
					{	$cabeceras[]="ID";
						$cabeceras_campo.="ID,";
					}
				}
				$cabeceras[]=$valor['form_debi_deta_cabecera'];
				$cabeceras_campo.=$valor['form_debi_deta_campo'].",";
			}
			$cabecera_completa=substr_replace($cabeceras_campo,'',strripos($cabeceras_campo,","),strripos($cabeceras_campo,","));
			
			array_pop($cabeceras);
			$aux_tarjeta = 0;
			$flag_tarjeta = 0;
			$i_cabe=0;//Contador de cabeceras
			foreach($cabeceras as $cabecera)
			{	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i_cabe, 1, $cabecera);
				if( $cabecera == 'Banco/Tarjeta Número' )
				{   $aux_tarjeta = $i_cabe;
					$flag_tarjeta = 1;
				}
				$i_cabe = $i_cabe + 1;
			}
			
			$xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
			foreach ( $debito_data['cmb_producto']  as $producto )
			{
				$xml_productos.='<producto id="'.$producto.'" />';
			}
			$xml_productos.="</productos>";
			
			$debito->get_all_deudas($cabecera_completa,$debito_data['hd_id_formato_exp'], $xml_productos,
									$debito_data['cmb_fac_estado'], $debito_data['cmb_banco'], $debito_data['cmb_tarjCredito'], $_SESSION['peri_codi'] , $debito_data['hd_opc_ctas_ant'] , $debito_data['hd_opc_ctas_inl'] );
			$debitos_datos=$debito->rows;
			$i_deta_fila=2;
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 1;
			for ($column = 'A'; $column != $latestBLColumn; $column++)
			{	$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			}
			foreach ( $debitos_datos as $registro )
			{	$i_deta_col=0;
			  	foreach ($registro as $campo =>$valor )
				{	if( ( $aux_tarjeta == $i_deta_col ) && ( $flag_tarjeta == 1 ) )
					{   if( !is_numeric ( $valor ) )
						{   $alum_resp_form_banc_tarj_nume_dec=base64_decode($valor);
							$iv = base64_decode($_SESSION['clie_iv']);
							$alum_resp_form_banc_tarj_nume=mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume_dec, MCRYPT_MODE_CBC, $iv );
							$alum_resp_form_banc_tarj_nume=preg_replace('/[^A-Za-z0-9\-]/', '', $alum_resp_form_banc_tarj_nume);
							$valor = $alum_resp_form_banc_tarj_nume;
						}
					}
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i_deta_col, $i_deta_fila, $valor);       
					$i_deta_col=$i_deta_col+1;
				}
				$i_deta_fila=$i_deta_fila+1;
			}
			if(strlen($debito_data['txt_nombre_exp']) == 0)
				$nombre_archivo = 'debitosAutomaticos';
			else
				$nombre_archivo = $debito_data['txt_nombre_exp'];
			
			$objPHPExcel->getActiveSheet()->setTitle('DebitosAutomaticos');
			$objPHPExcel->setActiveSheetIndex(0);
			
			if($debito_data['cmb_tipo_formato']=='xlsx')
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			else
				header('Content-Type: text/csv');
			header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.'.$debito_data['cmb_tipo_formato'].'"');
			header('Cache-Control: max-age=0');
			
			if($debito_data['cmb_tipo_formato']=='xlsx')
			{   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			}
			else
			{   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'csv');	
				$objWriter->setDelimiter($debito_data["cmb_tipo_formato_delimitador"]);
				$objWriter->setEnclosure($debito_data["cmb_tipo_formato_cercado"]);
				$objWriter->setLineEnding($debito_data["cmb_tipo_formato_fin_de_linea"]);
			}
			$objWriter->save('php://output');
			exit;
			break;
		case GET_DEUD_CTAS_ANTIQ :
			$productos = json_decode($debito_data['cmb_producto'], true);

			$xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
			foreach ( $productos as $producto )
			{
				$xml_productos.='<producto id="'.$producto.'" />';
			}
			$xml_productos.="</productos>";

			$formatos->get_deudores_ctas_antiguas(	$xml_productos , $_SESSION['peri_codi'] , $debito_data['hd_id_formato_exp'] ,
													$debito_data['cmb_fac_estado'] , $debito_data['cmb_banco'] , $debito_data['cmb_tarjCredito'] );
			print_r($formatos->rows[0]['ctas_antiguas']);
			break;
		case RESET_CTAS_INL :
			$formatos->reset_deudores_ctas_inliquidas( $_SESSION['usua_codigo'] );
			print_r($formatos->mensaje);
			break;
		case GET_DEUD_CTAS_INLIQ :
			$formatos->get_deudores_ctas_inliquidas( $debito_data['hd_id_formato_exp'] , $_SESSION['peri_codi'] );
			print_r($formatos->rows[0]['ctas_inliquidas']);
			break;
		case COPY_FILE :
			//$global diccionario;
			$resultado = $formatos->copy_formato($debito_data['form_debi_codigo'], $debito_data['form_debi_descripcion'], $_SESSION['usua_codigo']);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case CAMBIAR_VISTA :
			//$global diccionario;
			$debito->get_all_campos( $debito_data['vista'] );
			$data = array(	'{combo_campos_file}' =>array("elemento"=> "combo", 
                                                      	"datos"     => $debito->rows, 
                                                      	"options"   => array("name"=>"campos_add","id"=>"campos_add","required"=>"required","class"=>"form-control"),
                                                      	"selected"  => 0));

			retornar_result($data);
			break;
        default:
			break;
    }
}
function cellsToMergeByColsRow($startcol = NULL, $endcol = NULL, $startrow = NULL, $endrow = NULL)
{	$merge = 'A1:A1';
	if($startcol>=0 && $endcol>=0 && $startrow>0 && $endrow>0)
	{	$startcol = PHPExcel_Cell::stringFromColumnIndex($startcol);
		$endcol = PHPExcel_Cell::stringFromColumnIndex($endcol);
		$merge = "$start{$startrow}:$end{$endrow}";
	}
	return $merge;
}
handler();
?>