<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}

	$target_path = "../importacion_datos/biblio/uploads/".$_SESSION['directorio']."/";
	$target_path = $target_path . basename( $_FILES['file']['name']);
	if ($_FILES['file']['error'])
	{
		$result= json_encode(array ('state'=>'error',
						'result'=>'Error al subir archivo.' ));
	}else{
		$fileType = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
		if( $fileType != "xls" ) {
		    $result= json_encode(array ('state'=>'error',
						'result'=>'Favor ingresar el formato correcto de subida.'.$fileType ));
		}else{
			if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) 
			{ 
				$result= json_encode(array ('state'=>'error',
						'result'=>"Ha ocurrido un error, trate de nuevo!" ));
			}
			
			if (file_exists($target_path))
			{
				try
				{
					require_once ('../framework/PHPExcel/Classes/PHPExcel/IOFactory.php');
					require_once ('../framework/dbconf.php');
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objReader -> setReadDataOnly(true);
					$objPHPExcel = $objReader->load($target_path);
					$objPHPExcel->setActiveSheetIndex(0);		
					$filas = $objPHPExcel->getActiveSheet()->getHighestRow();
					$columnas = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());
					
					switch($opc){
						case 'auto':
							$xml_autor = new DOMDocument("1.0","UTF-8");
							$root_auto = $xml_autor->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$autor = $xml_autor->createElement("autor");
								
								$autor->setAttribute('auto_apel',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$autor->setAttribute('auto_nomb',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->getValue());
								$root_auto->appendChild($autor);
							}
							$xml_autor->appendChild($root_auto);


							$params = array($xml_autor->saveXML());
							$sql="{call lib_migracion_autores_xls(?)}";
							$migracion_autores_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_autores_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;

						case 'cate':
							$xml_categoria = new DOMDocument("1.0","UTF-8");
							$root_cate = $xml_categoria->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$cate = $xml_categoria->createElement("cate");
								
								$cate->setAttribute('cate_deta',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$root_cate->appendChild($cate);
							}
							$xml_categoria->appendChild($root_cate);


							$params = array($xml_categoria->saveXML());
							$sql="{call lib_migracion_categorias_xls(?)}";
							$migracion_categorias_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_categorias_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;

						case 'desc':
							$xml_descriptor = new DOMDocument("1.0","UTF-8");
							$root_desc = $xml_descriptor->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$desc = $xml_descriptor->createElement("desc");
								
								$desc->setAttribute('desc_deta',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$root_desc->appendChild($desc);
							}
							$xml_descriptor->appendChild($root_desc);


							$params = array($xml_descriptor->saveXML());
							$sql="{call lib_migracion_descriptores_xls(?)}";
							$migracion_descriptores_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_descriptores_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;

						case 'tipo':
							$xml_tipos = new DOMDocument("1.0","UTF-8");
							$root_tipo = $xml_tipos->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$tipo = $xml_tipos->createElement("tipo");
								
								$tipo->setAttribute('tipo_deta',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$root_tipo->appendChild($tipo);
							}
							$xml_tipos->appendChild($root_tipo);


							$params = array($xml_tipos->saveXML());
							$sql="{call lib_migracion_tipos_xls(?)}";
							$migracion_tipos_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_tipos_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;

						case 'cole':
							$xml_coleccion = new DOMDocument("1.0","UTF-8");
							$root_cole = $xml_coleccion->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$cole = $xml_coleccion->createElement("cole");
								
								$cole->setAttribute('cole_deta',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$root_cole->appendChild($cole);
							}
							$xml_coleccion->appendChild($root_cole);


							$params = array($xml_coleccion->saveXML());
							$sql="{call lib_migracion_coleccion_xls(?)}";
							$migracion_coleccion_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_coleccion_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;

						case 'edit':
							$xml_editorial = new DOMDocument("1.0","UTF-8");
							$root_edit = $xml_editorial->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$edit = $xml_editorial->createElement("edit");
								
								$edit->setAttribute('edit_deta',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$root_edit->appendChild($edit);
							}
							$xml_editorial->appendChild($root_edit);


							$params = array($xml_editorial->saveXML());
							$sql="{call lib_migracion_editorial_xls(?)}";
							$migracion_editorial_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_editorial_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;

						case 'proc':
							$xml_procedencia = new DOMDocument("1.0","UTF-8");
							$root_proc = $xml_procedencia->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$proc = $xml_procedencia->createElement("proc");
								
								$proc->setAttribute('proc_deta',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$root_proc->appendChild($proc);
							}
							$xml_procedencia->appendChild($root_proc);

							$params = array($xml_procedencia->saveXML());
							$sql="{call lib_migracion_procedencia_xls(?)}";
							$migracion_procedencia_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_procedencia_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;

						case 'recu_libr':
							$xml_recurso = new DOMDocument("1.0","UTF-8");
							$root_recu = $xml_recurso->createElement("root");
							for ($i=2; $i<=$filas; $i++)
							{
								$recu = $xml_recurso->createElement("recu");
								
								$recu->setAttribute('recu_titu',$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								$root_recu->appendChild($recu);
							}
							$xml_recurso->appendChild($root_recu);

							$params = array($xml_recurso->saveXML());
							$sql="{call lib_migracion_procedencia_xls(?)}";
							$migracion_procedencia_xls = sqlsrv_query($conn, $sql, $params);
							if ($migracion_procedencia_xls===false)
							{
								//echo "Ha ocurrido un error en la base de datos.";
								//exit ();
								$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
								// die(print_r(sqlsrv_errors(),true));
							}else{
								$result= json_encode(array ('state'=>'success',
									'result'=>'importación realizada con éxito.' ));
							}

						break;
					}
					
				}
				catch (Exception $e)
				{
					$result= json_encode(array ('state'=>'error',
									'result'=>'Error al realizar la importación.' ));
				}
			}
		
		}
	}

	echo $result;
?>