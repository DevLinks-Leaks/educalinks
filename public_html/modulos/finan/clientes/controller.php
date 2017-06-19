<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../finan/general/model.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('../../finan/clientes/constants.php');
require_once('../../finan/clientes/model.php');
require_once('../../finan/clientes/view.php');
require_once('../../../Framework/funciones.php');
require_once('../../finan/pagos/model.php');

function handler()
{
	$cliente 			= get_mainObject('Cliente');
	$tablacliente 		= get_mainObject('Cliente');
	$cliente_descuentos = get_mainObject('Cliente');
	$event 				= get_actualEvents(array(VIEW_GET_ALL, VIEW_SET, VIEW_SET_HOME), VIEW_GET_ALL);
	$user_data 			= get_frontData();
	$permiso 			= get_mainObject('General');
	$datosInst 			= get_mainObject('General');
	$periodo 			= get_mainObject('Periodo');
	$grupEcon 			= get_mainObject('GrupoEconomico');
	$pago 				= get_mainObject('Pagos');
	
	global $diccionario;
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "cliente_table";}else{$tabla =$_POST['tabla'];}
	
    switch ($event)
	{
        case VIEW_GET_ALL:
            if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            
			$periodo->get_all_selectFormat();
			$data['{cmb_periodo}'] = array("elemento"  => "combo", 
											"datos"     => $periodo->rows, 
                                            "options"   => array("name"=>"periodos","id"=>"periodos", "class"=>"form-control input-sm","disabled"=>"disabled",
																 "onChange"	=> "cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
											"selected"  => $_SESSION['peri_codi']);
			$grupEcon->getCategorias_selectFormat_with_all('');
			$data['{cmb_grupoEconomico}'] = array("elemento"  => "combo", 
											"datos"     => $grupEcon->rows, 
                                            "options"   => array("name"=>"cmb_grupo_economico","id"=>"cmb_grupo_economico", "class"=>"form-control input-sm"),
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
																		1 => '- Seleccione un curso -',
																		3 => ''), 
                                                                        2=> array()),
															"options"   => array("name"=>"cursos","id"=>"curso","required"=>"required","class"=>"form-control input-sm"),
										"selected"  => -1);
										
            $data['tabla'] = "<span style='font-size:small'>Haga clic en buscar para realizar una consulta.</span>";
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_CLIENTE_OPCIONES:
			global $diccionario;
			$permiso_179 = new General();
			$permiso_181 = new General();
			$permiso_179->permiso_activo($_SESSION['usua_codigo'], 179);
			$permiso->permiso_activo($_SESSION['usua_codigo'], 180);
			$permiso_181->permiso_activo($_SESSION['usua_codigo'], 181);
			$data['opciones_cliente'] = get_cliente_opciones($permiso,$user_data['codigoCliente'],'button',
															 $permiso_179->rows[0]['veri'],
															 $permiso->rows[0]['veri'],
															 $permiso_181->rows[0]['veri'] );
			retornar_result($data);
			break;
        case GET_ALL_DATA:
			global $diccionario;
			if(!isset($user_data['fechanac_ini']))
				$fechanac_ini = '';
			else 
				$fechanac_ini = $user_data['fechanac_ini'];
			
			if(!isset($user_data['fechanac_fin']))
				$fechanac_fin = '';
			else 
				$fechanac_fin = $user_data['fechanac_fin'];
			
			if(!isset($user_data['fechamatri_ini']))
				$fechamatri_ini = '';
			else 
				$fechamatri_ini = $user_data['fechamatri_ini'];
			
			if(!isset($user_data['fechamatri_fin']))
				$fechamatri_fin = '';
			else 
				$fechamatri_fin = $user_data['fechamatri_fin'];
			
			if(!isset($user_data['id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['id_titular'];
			if(!isset($user_data['id_cliente']))
				$id_cliente = '';
			else 
				$id_cliente = $user_data['id_cliente'];
			if(!isset($user_data['cod_estudiante']))
				$cod_estudiante = '-1';
			else 
				$cod_estudiante = $user_data['cod_estudiante'];
			if(!isset($user_data['nombre_estudiante']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['nombre_estudiante'];
			if(!isset($user_data['nombre_titular']))
				$nombre_repr = '';
			else 
				$nombre_repr = $user_data['nombre_titular'];
			
			if(!isset($user_data['estado']))
				$estado = 'A';
			else 
				$estado = $user_data['estado'];
			
			if(!isset($user_data['estado_reg']))
				$estado_reg = 'A';
			else 
				$estado_reg = $user_data['estado_reg'];
			
			if(!isset($user_data['periodo']))
				$periodos = '-1';
			else 
				$periodos = $user_data['periodo'];
			if(!isset($user_data['grupoEconomico']))
				$grupoEconomico = '-1';
			else 
				$grupoEconomico = $user_data['grupoEconomico'];
			if(!isset($user_data['nivelEconomico']))
				$nivelEconomico = '-1';
			else 
				$nivelEconomico = $user_data['nivelEconomico'];
			if(!isset($user_data['curso']))
				$curso = '-1';
			else 
				$curso = $user_data['curso'];
            $cliente->get_cliente_alumnos_general(  $cod_estudiante, 		$nombre_estudiante,		$fechanac_ini, 		$fechanac_fin,
													$fechamatri_ini,		$fechamatri_fin,
													$id_titular,			$nombre_repr,			$id_cliente,		$periodos,
													$curso,					$grupoEconomico,		$nivelEconomico,	$estado_reg,
													$estado);
            
			if ( ( $user_data['view'] == 1 ) )
			{
				if(count($cliente->rows)>0)
				{	global $diccionario;
					$permiso_179 = new General();
					$permiso_181 = new General();
					$permiso_10 = new General();
					$permiso_179->permiso_activo($_SESSION['usua_codigo'], 179);
					$permiso_181->permiso_activo($_SESSION['usua_codigo'], 181);
					$permiso_10->permiso_activo($_SESSION['usua_codigo'], 10);
					$permiso->permiso_activo($_SESSION['usua_codigo'], 180);
					
					$body= "<table id='".$tabla."' class='table table-hover table-striped'>";
					$body.= "<thead style='background-color:#F39C12;color:white;'>
								<tr><th style='text-align:center;font-size:small;'>Alumnos</th></tr>
							</thead>
							<tbody>";
					$c=0;
					$aux=0;
					foreach($cliente->rows as $row)
					{	$aux++;
					}
					foreach($cliente->rows as $row)
					{	if($c<($aux-1))
						{
							$body.="
								<tr>
									<td>
										<div class='form-horizontal'>
											<div class='row'>
												<div class='col-lg-6 col-md-6 col-sm-12 col-sm-12' style='text-align:left'>
													<b style='color:#2d3c4a;'>".$row["nombres"]." ".$row["apellidos"]."</b><br>
													<small><b style='color:#2d3c4a;'>Código:</b>&nbsp;".$row["codigo"]."</small><br>
													<small><b style='color:#2d3c4a;'>Estado:</b>&nbsp;";
														if ( $row["esta_deta"] == 'MATRICULADO' ) 
															$body.= '<span style=\'color:#17ca34\'>'.$row["esta_deta"].'</span>'; 
														else if ( $row["esta_deta"] == 'RETIRADO') 
															$body.= '<span style=\'color:#e24b4b\'>'.$row["esta_deta"].'</span>'; 
														else
															$body.= $row["esta_deta"];
													$body.="</small> |&nbsp<small><b style='color:#2d3c4a;'>Curso:</b>&nbsp;";
													if( $permiso_10->rows[0]['veri'] )
														$body.= "<a href='#' onclick='js_clientes_go_to_courses(\"../../../admin/cursos_paralelo_main.php?curs_para_codi=".$row['curs_para_codi']."\");' 
																	data-toggle='modal' data-target='#modal_acad'
																	title='Ver información del curso ".$row["curso"]."'>".$row["curso"]."</a>";
													else
														$body.= $row["curs_deta"]." - ".$row["para_deta"];
													$body.="</small>
												</div>
												<div class='col-lg-6 col-md-6 col-sm-12 col-sm-12' style='text-align:center'>".
													$opciones_print["EstadoCuenta"].' '.get_cliente_opciones($permiso, $row["codigo"], 'button',
																											 $permiso_179->rows[0]['veri'],
																											 $permiso->rows[0]['veri'],
																											 $permiso_181->rows[0]['veri'] )
											  ."</div>
											</div>
										</div>
									</td>
								</tr>";
							$c++;
						}
					}
					$body.="</tbody>";
					$body.="</table>";
					$data['tabla'] = $body;
					$data['mensaje'] = "Bandeja de estudiantes";
				}else{
				  $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
				}
			}
			if ( ( $user_data['view'] == 2 ) || ( $user_data['view'] == 3 )  )
			{
				if(count($cliente->rows)>0)
				{	global $diccionario;
					$permiso_179 = new General();
					$permiso_181 = new General();
					$permiso_179->permiso_activo($_SESSION['usua_codigo'], 179);
					$permiso_181->permiso_activo($_SESSION['usua_codigo'], 181);
					$permiso->permiso_activo($_SESSION['usua_codigo'], 180);
					
					$body= "<table id='".$tabla."' class='table table-hover table-striped'>";
					$body.= "<thead style='background-color:#F39C12;color:white;'>
								<tr>
									<th style='text-align:center;font-size:small;'>Código</th>
									<th style='text-align:center;font-size:small;'>Identificaci&oacute;n</th>
									<th style='text-align:center;font-size:small;'>Nombre</th>
									<th style='text-align:center;font-size:small;'>Dirección</th>
									<th style='text-align:center;font-size:small;'>Teléfono</th>
									<th style='text-align:center;font-size:small;'>F. Nacimiento</th>
									<th style='text-align:center;font-size:small;'>Curso</th>
									". ( $user_data['view'] == 2 ? "<th style='text-align:center;font-size:small;'></th>" : "" )."
								</tr>
							</thead>";
					$body.="<tbody>";
					$c=0;
					$aux=0;
					foreach($cliente->rows as $row)
					{	$aux++;
					}
					foreach($cliente->rows as $row)
					{	if($c<($aux-1))
						{	$body.="<tr>";
							$x=0;
							$codigo="";
							$nombre="";
							foreach($row as $column)
							{	if($x==0) $codigo = $column;
								if($x==2) $nombre = $column;
								else if($x==3)
								{
									$body.="<td style='text-align:center;font-size:x-small;'>".$column." ".$nombre."</td>";
								}
								else if($x==4)
								{
									$body.= "<td style='text-align:center;font-size:small;'><span style='color:#133361;'; class='detalle' id='".$codigo."_cliente_direccion' onmouseover='$(this).tooltip(".'"show"'.")' title='".$column."' data-placement='bottom'><span class='glyphicon glyphicon-home'></span></span></td>";
								}
								else if( $x==8 || $x==9 )
								{
									// do nothing;
								}
								else
								{
									$body.="<td style='text-align:center;font-size:small;'>".$column."</td>";
								}
								$x++;
							}
							$opciones_print["EstadoCuenta"]=str_replace('{codigo}',$codigo,$opciones["EstadoCuenta"]);
							if ( $user_data['view'] == 2 )
								$body.="<td style='text-align:center'>".$opciones_print["EstadoCuenta"].' '.get_cliente_opciones($permiso, $codigo, 'button',
																																 $permiso_179->rows[0]['veri'],
																																 $permiso->rows[0]['veri'],
																																 $permiso_181->rows[0]['veri'] )."</td>";
						}
						$body.="</tr>";
						$c++;
					}
					$body.="</tbody>";
					$body.="</table>";
					$data['tabla'] = $body;
					$data['mensaje'] = "Bandeja de estudiantes";
				}else{
				  $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
				}
			}
            retornar_result($data);
            break;
        case VIEW_SET:
            $tipoPersona = array(0 => array(0=>'N', 1=>'NATURAL'),
                                 1 => array(0=>'J', 1=>'JURIDICA'),
                                 2 => array());
            $tipoIdentificacion = array(0 => array(0=>'CI', 1=>'CEDULA'),
                                        1 => array(0=>'RUC', 1=>'RUC'),
                                        2 => array());
            $estadoCivil = array(0 => array(0=>'S', 1=>'SOLTERO(A)'),
                                 1 => array(0=>'C', 1=>'CASADO(A)'),
                                 2 => array(0=>'D', 1=>'DIVORCIADO(A)'),
                                 3 => array(0=>'V', 1=>'VIUDO(A)'),
                                 4 => array(0=>'UL', 1=>'UNION LIBRE'),
                                 5 => array());
            $data = array('{combo_tipoPersona}' => array("elemento"  => "combo", 
                                                         "datos"     => $tipoPersona,
                                                         "options"   => array("name"=>"tipoPersona_add",
																				"id"=>"tipoPersona_add",
																				"class"=>"form-control",
																				"required"=>"required"),
                                                         "selected"  => 0),
                          '{combo_tipoIdentificacion}' => array("elemento"  => "combo", 
                                                                "datos"     => $tipoIdentificacion,
                                                                "options"   => array("name"=>"tipoIdentificacion_add",
																					 "id"=>"tipoIdentificacion_add",
																					  "class"=>"form-control",
																					 "required"=>"required"),
                                                                "selected"  => 0),
                          '{combo_estadoCivil}' => array("elemento"  => "combo", 
                                                         "datos"     => $estadoCivil,
                                                         "options"   => array("name"=>"estadoCivil_add",
																		      "id"=>"estadoCivil_add",
																			  "class"=>"form-control",
																			  "required"=>"required"),
                                                         "selected"  => 0)
                        );
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $cliente->set($user_data);
            break;  
        case GET:
            $tipoPersona = array(0 => array(0=>'N', 1=>'NATURAL'),
                                 1 => array(0=>'J', 1=>'JURIDICA'),
                                 2 => array());
            $tipoIdentificacion = array(0 => array(0=>'CI', 1=>'CEDULA'),
                                        1 => array(0=>'RUC', 1=>'RUC'),
                                        2 => array());
            $estadoCivil = array(0 => array(0=>'S', 1=>'SOLTERO(A)'),
                                 1 => array(0=>'C', 1=>'CASADO(A)'),
                                 2 => array(0=>'D', 1=>'DIVORCIADO(A)'),
                                 3 => array(0=>'V', 1=>'VIUDO(A)'),
                                 4 => array(0=>'UL', 1=>'UNION LIBRE'),
                                 5 => array());

            $cliente->get($user_data['codigo']);
            $data = array(
                'clie_codigo'=>$user_data['codigo'],
                'clie_numIdentificacion'=>$cliente->numeroIdentificacion,
                'clie_nombres'=>$cliente->nombres,
                'clie_apellidos'=>$cliente->apellidos,
                'clie_direccion'=>$cliente->direccion,
                'clie_telefono'=>$cliente->telefono,
                'clie_fechaNacimiento'=>$cliente->fechaNacimiento,
                'clie_email'=>$cliente->email,
                '{combo_tipoPersona}' => array("elemento"  => "combo", 
                                               "datos"     => $tipoPersona,
                                               "options"   => array("name"=>"tipoPersona",
																	"id"=>"tipoPersona",
																		"required"=>"required",
																		"class"=>"form-control"),
                                               "selected"  => $cliente->tipoPersona),
                '{combo_tipoIdentificacion}' => array("elemento"  => "combo", 
                                                      "datos"     => $tipoIdentificacion,
                                                      "options"   => array("name"=>"tipoIdentificacion",
																			"id"=>"tipoIdentificacion",
																			"required"=>"required",
																			"class"=>"form-control"),
                                                      "selected"  => $cliente->tipoIdentificacion),
                '{combo_estadoCivil}' => array("elemento"  => "combo", 
                                               "datos"     => $estadoCivil,
                                               "options"   => array("name"=>"estadoCivil",
																	"id"=>"estadoCivil",
																	"required"=>"required",
																	"class"=>"form-control"),
                                               "selected"  => $cliente->estadoCivil)
                          );
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $cliente->delete($user_data['codigo']);
            break;
        case EDIT:
            $cliente->edit($user_data);
            break;
        case VIEW_SET_DISCOUNT:
            $cliente->getDscto_selectFormat();
            $dscto = $cliente->rows;
			
            $cliente_descuentos_activos = new Cliente();
			$cliente_descuentos_activos->getDescuentos_cliente($user_data['codigo'], 'A');
			
			$cliente_descuentos_inactivos = new Cliente();
			$cliente_descuentos_inactivos->getDescuentos_cliente($user_data['codigo'], 'I');
			
            $cliente->get($user_data['codigo']);
            global $diccionario;
			$opciones["Eliminar"] = "<span onclick='js_clientes_descuento_alumno_delete(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/descuentoalumnos/controller.php"'.",".'"'.$user_data['codigo']."\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'  data-toggle='modal' data-target='#modal_resend'  id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar' data-placement='left'></span>";
            $data = array('{combo_descto}'    => array("elemento"  => "combo", 
                                                       "datos"     => $dscto, 
                                                       "options"   => array("name"=>"codigo_descto",
                                                                            "id"=>"codigo_descto",
                                                                            "required"=>"required",
																			"class"=>"form-control",
                                                                            "onChange"=>"carga_porcentaje(this.value,'div_porcentaje_descto','".$diccionario['rutas_head']['ruta_html_finan']."/clientes/controller.php')"),
                                                       "selected"  => 0),
						  'peri_deta'      => $_SESSION['peri_deta'],
                          'clie_codigo'      => $user_data['codigo'],
                          'clie_nombres'     => $cliente->nombres,
                          'clie_apellidos'   => $cliente->apellidos,
                          '{tabla_descuentos}' =>array( "elemento"=>"tabla",
                                                        "clase"=>"table table-striped table-hover",
                                                        "datos"=>$cliente_descuentos_activos->rows,
                                                        "id"=>"tabla_descuentos_cliente",
                                                        "encabezado" => array("Ref.","Motivo","Porcentaje","Días validez","Período","Asignado el","Inactivar"),
														"options"=>array($opciones),
														"campo"=>"desc_alum_codigo"
                            ),
                          '{tabla_descuentos_inactivos}'=>array( "elemento"=>"tabla",
																"clase"=>"table table-striped table-hover",
																"datos"=>$cliente_descuentos_inactivos->rows,
																"id"=>"tabla_descuentos_inactivos_cliente",
																"encabezado" => array("Ref.","Motivo","Porcentaje","Días validez","Período","Inactivado el","Eliminar"),
																"options"=>array($opciones),
																"campo"=>"desc_alum_codigo"
                            )
                          );
            
            retornar_formulario(VIEW_SET_DISCOUNT, $data);
          break;
        case GET_PORCENTAJE:
            $cliente->getPorcentaje($user_data['desc_codigo']);
            
			if($cliente->desc_porcentaje!="")
				$descuento = $cliente->desc_porcentaje;
			else
				$descuento = '0.00';
			
			$porcentaje_sugerido='
				<div class="input-group"
							data-placement="right"
							title="Ej.: 10%."
							onmouseover=\'$(this).tooltip("show")\'>
					<input type="text" class="form-control" name="porcentaje_descto" id="porcentaje_descto"
							onkeypress="return spacebar_retorna_cero(event,this);" 
							pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01"
							maxlength="15" placeholder="00.00" required="required" value="'.$descuento.'">
					<span class="input-group-addon" id="basic-addon">%</span>
				</div>';
			$data['porcentaje_sugerido'] = $porcentaje_sugerido;
            
			retornar_result($data);
          break;
        case SET_DISCOUNT:
            $user_data['codigoUsuario']=$_SESSION['usua_codigo'];
			$resultado = $cliente->asignarDscto( $user_data );
			$data = array( "mensaje" => $resultado->mensaje );
			retornar_result($data);
          break;
        case SET_HOME:
            $user_data['codigoUsuario']=$_SESSION['usua_codigo'];
            $cliente->asignarDscto($user_data);
			break;
        case VIEW_FILTERS_REPORT:
			global $diccionario;
			$data['alumno_codigo'] = $user_data["codigoEstudiante"];

			$cliente->getPeriodos_selectFormat();
			$data['{combo_periodos}'] = array("elemento"  => "combo", 
                                            "datos"     => $cliente->rows, 
                                            "options"   => array("name"=>"combo_periodo",
                                                                 "id"=>"combo_periodo",
                                                                 "required"=>"required",
                                                                 "disabled"=>"true",
																 "class"=>"form-control",
                                                                 "onchange"=>"consultaDeudas("."'resultadoDeudas'".","."'".$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php'."'".")"),
                                            "selected"  => 0);

			// Consulta las deudas del estudiante
			$codigoAlumno = $user_data["codigoEstudiante"];
			//$cliente->getCabeceraEstadoCuenta($codigoAlumno, "","","");
			$tablacliente->getCabeceraEstadoCuentatabla($codigoAlumno, '','','');

			$data['tablaDeudas'] = tabla_deudas( $tablacliente );
			$data['tablaPagos'] = construct_table_pagos ( $codigoAlumno, '', '', '', $user_data['deuda'] );
			
			retornar_formulario(VIEW_FILTERS_REPORT, $data);
			break;
        case DELETE_DEUDA:
			global $diccionario;
			// Elimino la deuda
			$cliente->deleteDeuda($user_data["codigoDeuda"]);

			// Consulta las deudas del estudiante
			$codigoAlumno = $user_data["codigoEstudiante"];
			//$cliente->getCabeceraEstadoCuenta($codigoAlumno, "", "", "");
			$tablacliente->getCabeceraEstadoCuentatabla($codigoAlumno, '','','');
			$opciones = array();
			$deudas = array();
			/*foreach ($cliente->rows as $registro)
			{
				array_splice($registro, 2, 2); // Elimino 2 columnas del array que no requiero para mostrar
				$deudas[] = $registro;
			}*/
			$opciones["Eliminar"] = "<span onclick='eliminarDeuda(".'"{codigo}"'.",".'"resultadoDeudas"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar' data-placement='left'></span>";
			$data['tablaDeudas'] = tabla_deudas( $tablacliente );
			
			//$data['tablaPagos'] = construct_table_pagos ( $codigoAlumno, '', '', '' );
			retornar_result($data);
			break;
        case GET_DEUDAS:
			global $diccionario;

			$codigoAlumno = $user_data["codigoEstudiante"];
			$codigoPeriodo = $user_data["codigoPeriodo"];
			$fechaInicio = substr($user_data["fechaInicio"], 6, 4).substr($user_data["fechaInicio"], 3, 2).substr($user_data["fechaInicio"], 0, 2) ;
			$fechaFin = substr($user_data["fechaFin"], 6, 4).substr($user_data["fechaFin"], 3, 2).substr($user_data["fechaFin"], 0, 2) ;

			//$cliente->getCabeceraEstadoCuenta($codigoAlumno, $codigoPeriodo, $fechaInicio, $fechaFin);
			$tablacliente->getCabeceraEstadoCuentatabla($codigoAlumno, $codigoPeriodo, $fechaInicio, $fechaFin);
			$opciones = array();
			$deudas = array();
			/*foreach ($cliente->rows as $registro)
			{
				array_splice($registro, 2, 2); // Elimino 2 columnas del array que no requiero para mostrar
				$deudas[] = $registro;
			}*/
			$opciones["Eliminar"] = "<span onclick='eliminarDeuda(".'"{codigo}"'.",".'"resultadoDeudas"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar' data-placement='left'></span>";
			$data['tablaDeudas'] = tabla_deudas( $tablacliente );
			//$data['tablaPagos'] = construct_table_pagos ( $codigoAlumno, $fechaInicio, $fechaFin, $codigoPeriodo );
			retornar_result($data);
			break;
        case VIEW_SET_GRUPO_ECONOMICO:
			$cliente->getGrupoEconomicoAsignado($user_data["codigoEstudiante"]);
			$data["codigoEstudiante"] = $user_data["codigoEstudiante"];
			$data["codigoGrupoEconomico"] = $cliente->rows[0]["codigoGrupoEconomico"];
			$data["nombreGrupoEconomico"] = $cliente->rows[0]["nombreGrupoEconomico"];

			$grupoEconomico = new GrupoEconomico();
			$grupoEconomico->getCategorias_selectFormat();
			$data['{combo_grupoEconomicos}'] = array("elemento"  => "combo", 
												   "datos"     => $grupoEconomico->rows, 
												   "options"   => array("name"=>"combo_grupoEconomico",
																		"id"=>"combo_grupoEconomico",
																		"class"=>"form-control",
																		"required"=>"required"),
												   "selected"  => 0);

			retornar_formulario(VIEW_SET_GRUPO_ECONOMICO, $data);
			break;
        case SET_GRUPO_ECONOMICO:
			$resultado = $cliente->setGrupoEconomico($user_data["codigoEstudiante"], $user_data["codigoGrupoEconomico"]);
			$data['mensaje']=$resultado->mensaje;
			retornar_result($data);
			break;
        case PRINT_REPORT:
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='estado_cuenta.pdf'");

			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Sistema académico Educalinks");
			$pdf->SetAuthor("Sistema académico Educalinks");
			$pdf->SetTitle("Estado de cuenta");
			$pdf->SetSubject("Estado de cuenta");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			$codigoAlumno = $user_data["codigoAlumno"];
			$codigoPeriodo = $user_data["codigoPeriodo"];
			$fechaInicio = substr($user_data["fechaInicio"], 6, 4).substr($user_data["fechaInicio"], 3, 2).substr($user_data["fechaInicio"], 0, 2) ;
			$fechaFin = substr($user_data["fechaFin"], 6, 4).substr($user_data["fechaFin"], 3, 2).substr($user_data["fechaFin"], 0, 2) ;

			$cliente->getCabeceraEstadoCuenta($codigoAlumno, $codigoPeriodo, $fechaInicio, $fechaFin);
			$deudas = $cliente->rows;
			$codigoAlumno = $deudas[0]["codigoAlumno"];
			$nombresAlumno = $deudas[0]["nombreAlumno"];
			$periodoInicial = $deudas[0]["periodo"];
			if((strlen($user_data["fechaInicio"]) == 10) && (strlen($user_data["fechaFin"]) == 10))
				$desc_periodo = 'PERIODO del '.$user_data["fechaInicio"].' a '.$user_data["fechaFin"].'.';
			else
			{
				if (strlen($user_data["codigoPeriodo"]) > 0 )
					$desc_periodo = 'PERIODO '.$periodoInicial.'.';
				else
					$desc_periodo = 'REPORTE HISTORIAL COMPLETO.';
			}
			$datosInst->getDatosInstitucion_info();
			$contador = 1;
			$institucion = para_sist(2);
			$pdf->AddPage();
			$tabla = ' 
                     <table border="0" >
						<tr style="text-align:center;">
                          <td width="30%" style="text-align:left;vertical-align:top;">
							<span style="font-size:18px;"><strong>'.$datosInst->rows[0]['empr_razonSocial'].'</strong></span><br>
							<span style="font-size:10px;"><strong>RUC:</strong> '.$datosInst->rows[0]['empr_ruc'].'</span><br>
							<span style="font-size:10px;"><strong>Dirección:</strong> '.$datosInst->rows[0]['empr_direccionMatriz'].'</span><br>
							<span style="font-size:10px;"><strong>Telf.:</strong> '.$datosInst->rows[0]['empr_contactoTelefono'].'</span>
						  </td>
						  <td width="40%" style="vertical-align:top;"><strong>ESTADO DE CUENTA<BR>ESTUDIANTE</strong></td>
						  <td width="30%" style="text-align:right;vertical-align:top;font-size:10px;"><strong>'.$desc_periodo.'</strong>
							<br>
							'.print_usua_info().'
						  </td>
                        </tr>
                     </table></br><div /></br>'; //print_usua_info es llamado desde funciones.php.
			$cliente_da= new Cliente();
			$cliente_da->getDatosAdicionalesAlumno($codigoAlumno, $codigoPeriodo);
			if(count($cliente_da->rows)-1>0)
			{	$tabla.= '<table width="100%" style="font-size:xx-small;" border="0">
						  <tr>
							<td width="9%"><b>Cliente: </b></td>
							<td width="41%">'.$cliente_da->rows[0]['nombretitular'].'</td>
							<td width="9%"><b>Cédula: </b></td>
							<td width="10%">'.$cliente_da->rows[0]['cedulatitular'].'</td>
							<td width="12%"><b>Curso: </b></td>
							<td width="19%">'.$cliente_da->rows[0]['nombreCurso'].'</td>
						  </tr>
						  <tr>
							<td><b>Alumno: </b></td>
							<td>'.$nombresAlumno.'</td>
							<td><b>Código: </b></td>
							<td>'.$codigoAlumno.'</td>
							<td><b>Grupo econ.: </b></td>
							<td >'.$cliente_da->rows[0]['nombreGrupoEconomico'].'</td>
						  </tr>
						  <tr>
							<td><b>Dirección: </b></td>
							<td >'.$cliente_da->rows[0]['direcciontitular'].'</td>
							<td><b>Teléfono: </b></td>
							<td >'.$cliente_da->rows[0]['telefonotitular'].'</td>
							<td><b>Nivel econ.: </b></td>
							<td >'.$cliente_da->rows[0]['nombreNivelEconomico'].'</td>
						  </tr>
						</table>';
			}
			$pdf->writeHTML($tabla, true, false, true, false, '');
			$c_head=0;
			foreach ($deudas as $deuda)
			{	$detalle = "";
				$detalle.= '<style>
							table{
								font-size:small;
							}
							.tituloPeriodo{
								background-color:#F5ECCE;
								font-size:xx-small;
							}
							.tituloDeuda{
								background-color:#FAFAFA;
								text-align:center;
							}
							.cabeceraDeuda{
								text-align:center; 
								font-weight: bold;
								font-size: 8px;
								background-color:#F6E3CE;
							}
							.detalleDeuda{
								text-align: center;
								background-color:#FBF5EF;
							}
							.tituloPago{
								text-align:center; 
								margin-top:0px;
								padding:0px;
								background-color:#FBF5EF;
							}
							.cabeceraPago{
								background-color:#CEE3F6;
							}
							.detallePago{
								background-color:#EFF5FB;
							}
							</style>';
				if($c_head == 0 )
				{	$c_head++;
				}
				$cliente->getDetalleEstadoCuenta($deuda["codigoDeuda"]);
				
				$detalle .= '<table width="650px" border="0">';
				if( ( strlen( $user_data["codigoPeriodo"] ) == 0 ) || ( $user_data["codigoPeriodo"] == -1 ) )
				{   $detalle .= ' <tr class="tituloPeriodo">
								<td>Periodo</td>
								<td colspan="8">'.$deuda["periodo"].'</td>
							  </tr>';
				}
				/*$detalle .= '<tr class="tituloDeuda" >
								<td colspan="9" >Deudas</td>
							  </tr>';   */
				$detalle .=  '
						  <tr class="cabeceraDeuda">
                            <td>F. inicio Cobro</td>
							<td>Producto</td>
                            <td>T. Inicial</td>
							<td>T. N/C</td>
                            <td>Descuento</td>
                            <td>T. IVA</td>
                            <td>T. Abonado</td>
							<td>T. Pdte.</td>
							<td>Estado</td>
                          </tr>
                          <tr class="detalleDeuda" >
                            <td><div style="font-size:small">'.$deuda["fechaInicioCobro"].'</div></td>
							<td><div style="font-size:small">'.$deuda["descripcionDeuda"].'</div></td>
                            <td>$ '.$deuda["totalInicial"].'</td>
                            <td>$ '.$deuda["totalNotaCredito"].'</td>
							<td>$ '.$deuda["descuentofacturas"].'</td>
							<td>$ '.$deuda["totalIVA"].'</td>
							<td>$ '.$deuda["totalAbonado"].'</td>
                            <td>$ '.$deuda["totalPendiente"].'</td>
                            <td><strong>'.$deuda["estado"].'</strong></td>
                          </tr>
                          <tr>
                            <td colspan="4"></td>
                            <td class="tituloPago" colspan="6" >Pagos</td>
                          </tr>'; 


                $detalle .='<tr>
                            <td colspan="5"></td>
                            <td colspan="6" style="text-align: center;" >
                              <table border="0" width="100%">
                                <tr border="1" class="cabeceraPago" >
                                  <td>N°</td>
                                  <td>Fecha</td>
                                  <td>Pago</td>
								  <td>Forma pago</td>
								  <td>Cajero</td>
                                </tr>        
				';
				if(count($cliente->rows) == 0)
				{   $detalle .= '<tr class="detallePago" >
										<td colspan="5">- Sin pagos realizados -</td>
									  </tr>';
				}
				else
				{   foreach ($cliente->rows as $pago)
					{   $detalle .= '<tr class="detallePago" >
										<td>'.$pago["secuencial"].'</td>
										<td>'.$pago["fechaPago"].'</td>
										<td>$ '.$pago["totalPago"].'</td>
										<td>'.$pago["formaPago"].'</td>
										<td>'.$pago["usuario"].'</td>
									  </tr>';
					}
				}
					$detalle .= '</table></td></tr>
					  ';
				$detalle .= '</table>'; 
				$tabla = '<table border="1">
                        <tr><td><strong>DEUDAS</strong></td><tr>

                     </table>';

				$pdf->writeHTML($detalle, true, false, true, false, '');
			}
			$pdf->Output('estado_cuenta.pdf', 'I');

			break;
        case PRINT_CERT_REPORT:
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='certificado_financiero.pdf'");

			$pdf = new MYPDF_noheadfoot(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Sistema académico Educalinks");
			$pdf->SetAuthor("Sistema académico Educalinks");
			$pdf->SetTitle("Estado de cuenta");
			$pdf->SetSubject("Estado de cuenta");
			$pdf->SetMargins(30, PDF_MARGIN_TOP, 30);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->AddPage();
			
			$codigoAlumno = $user_data["codigoAlumno"];
			$codigoPeriodo = $user_data["codigoPeriodo"];
			$fechaInicio = substr($user_data["fechaInicio"], 6, 4).substr($user_data["fechaInicio"], 3, 2).substr($user_data["fechaInicio"], 0, 2) ;
			$fechaFin = substr($user_data["fechaFin"], 6, 4).substr($user_data["fechaFin"], 3, 2).substr($user_data["fechaFin"], 0, 2) ;
			
			$pensiones = new Cliente();
			$pensiones->get_alumPensiones_valore_reales( $user_data["codigoAlumno"], $user_data["codigoPeriodo"] );
			$Representante = $pensiones->rows[0]["Representante"];
			if((strlen($user_data["fechaInicio"]) == 10) && (strlen($user_data["fechaFin"]) == 10))
				$desc_periodo = 'PERIODO del '.$user_data["fechaInicio"].' a '.$user_data["fechaFin"].'.';
			else
			{
				if (strlen($user_data["codigoPeriodo"]) > 0 )
					$desc_periodo = 'PERIODO '.$periodoInicial.'.';
				else
					$desc_periodo = 'REPORTE HISTORIAL COMPLETO.';
			}
			$datosInst->getDatosInstitucion_info();
			
			$html = '<br>'.
					'<br>'.
					'<br>'.
					'<div align="left" style="align:left;">'.get_fecha_ciudad('false', 'true' ).'</div>'.
					'<br>'.
					'<br>'.
					'<h2 align="center" style="align:center;">'.
						'<b>C&nbsp;&nbsp;E&nbsp;&nbsp;R&nbsp;&nbsp;T&nbsp;&nbsp;I&nbsp;&nbsp;F&nbsp;&nbsp;I&nbsp;&nbsp;C&nbsp;&nbsp;A&nbsp;&nbsp;D&nbsp;&nbsp;O</b></h2>'.
					'<br>'.
					'<br>'.
					'<br>'.
					'<div style="text-align:justify;">Yo, <b>'.$datosInst->rows[0]['empr_representanteLegal_nomb'].'</b> con C.I. Nº. '.$datosInst->rows[0]['empr_representanteLegal_id'].','.
						'Representante Legal de <b>'.$datosInst->rows[0]['empr_razonSocial'].'</b>, con RUC. Nº '.$datosInst->rows[0]['empr_ruc'].
						', certificó que el/la <b>Sr./Sra. '.$Representante.'</b>,  a la fecha adeuda los siguientes valores por pensiones'.
						'correspondientes al periodo lectivo '.$_SESSION['peri_deta'].':</div>'; //print_usua_info es llamado desde funciones.php.
			
			$html .='<br>'.
					'.<table><tr><td width="20%"></td><td width="60%">'.
					'<table style="margin:0px auto" border="1" align="center">';
			$total_pensiones = 0.00;
			if( count($pensiones->rows) == 0 )
			{   $html .= '<tr class="detallePago" >
							<td colspan="2">- Sin deudas pendientes -</td>
						  </tr>';
			}
			else
			{   foreach ($pensiones->rows as $pension)
				{   if ( !empty( $pension ) )
					{	$html .= '<tr class="detallePago" >
								<td>'.$pension["descripcionDeuda"].'</td>
								<td>$'.$pension["totalPendiente"].'</td>
							  </tr>';
						$total_pensiones = $total_pensiones + $pension["totalPendiente"];
					}
				}
				$html .= '<tr class="detallePago" >
							<td><b>Total</b></td>
							<td><b>$'.$total_pensiones.'</b></td>
						 </tr>';
			}
			$html .= '</table></td><td width="20%"></td></tr></table>
			<br>
			<br>
			<br>
			<div style="text-align:justify;">Así constan en los registros financieros del plantel a los que me remito en caso necesario.</div>
			<br>
			<br>
			<br>
			<br>
			Atentamente,
			<br>
			<br>
			<br>
			<b>'.$datosInst->rows[0]['empr_representanteLegal_nomb'].'</b>
			<br>
			<b>Representante Legal</b>'; 
			//echo $html;
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('certificado_financiero.pdf', 'I');
			break;
        default :
			break;
    }
}
handler();
function construct_table_pagos($cod_alum, $fini, $ffin, $periodo, $deuda )
{   global $diccionario;
	if(!isset($fini))
		$fechavenc_ini = '';
	else 
		$fechavenc_ini = $fini;
	if(!isset($ffin))
		$fechavenc_fin = '';
	else 
		$fechavenc_fin = $ffin;
	$pago = new Pagos();
	$pago->get_PagosRealizados( '', $fechavenc_ini, $fechavenc_fin, '', '', '', 
								$cod_alum, '', '', '', '', '', '', '', 
								'', '0', '0', '-1', $periodo,'-1','-1','-1', $deuda );
	$construct_table="<br>
				<table class='table table-striped table-hover' id='pagosRealizados_table' style='width:100%;'>
					<thead style='background-color:#81d4fa;'><tr>".
			"<th style='font-size:small;text-align:center;'>Ref.</th>".
			"<th style='font-size:small;text-align:center;'>Total Pago</th>".
			"<th style='font-size:small;text-align:center;'>Forma de Pago</th>".
			"<th style='font-size:small;text-align:center;'>Fecha pago</th>".
			"<th style='font-size:small;text-align:center;'>PDF</th>".
			"<th style='font-size:small;text-align:center;'>HTML</th>".
			"<th style='font-size:small;text-align:center;'>Revertir</th>".
						"</tr>
					</thead>";
	
	$body.="<tbody>";
	$c=0;
	$aux=0;
	$archivo="";
	$archivoPDF = "";
	$archivoXML = "";
	$codigo="";
	$cedula="";
	foreach($pago->rows as $row)
	{	$aux++;
	}
	foreach($pago->rows as $row)
	{	if($c<($aux-1))
		{	$body.="<tr>";
			$x=0;
			$datos="";
			foreach($row as $column)
			{	if($x==1)
				{	if($column=="")
						$column = "N/A";
					$datos.="<div style=\"text-align:left;\">".
								"<table><tr><td style=\"vertical-align:top;\"><b>Titular:&nbsp;</b></td><td>". $column."</td></tr>";
				}
				elseif($x==2)
				{	if($column=="")
						$column = "C.I.";
					$datos.="<tr><td style='font-size:small;text-align:center;'><b>".$column.":&nbsp;</b></td><td>";
					$cedula = $column;
				}
				elseif($x==3)
				{	if($column=="")
						$column = "N/A";
					$datos.= $column."</td></tr>";
					$cedula = $column;
				}
				elseif( $x==4 || $x==7 || $x==8 || $x==9 || $x==10 || $x==12 || $x==13 )
				{	//do nothing;
				}
				else
				{	$body.="<td style='font-size:small;text-align:center;'>".$column."</div></td>";
					if($x==0)
					{	$codigo = $column;
					}
				}
				$x++;
			}
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
function get_cliente_opciones($permiso, $codigoCliente, $type='button', $permiso_179, $permiso_180, $permiso_181 )
{	global $diccionario;
	if($type=='span'){$tag=''; $space='&nbsp;';}
	if($type=='button'){$tag='button'; $space='';}
	$client_options = array();
	
	if ($permiso_180 == 1 )
	{	$opciones.= "<".$type." type='".$tag."' style='color:#DBBCDB;' class='btn btn-default btn-sm' onclick='carga_visorEstadoCuenta(\"".$codigoCliente."\",".'"modal_showDebtState_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_showDebtState'  id='".$codigoCliente."_verEstadoCuenta' onmouseover='$(this).tooltip(".'"show"'.")' title='Ver estado de cuenta' data-placement='left'><span class='fa fa-file'></span></".$type.">";
	}
	if ($permiso_179 == 1 )
	{	$opciones.= "<".$type." type='".$tag."' style='color:#3a3b45;' onclick='js_clientes_carga_asignacion(\"".$codigoCliente."\",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' class='btn btn-default btn-sm' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$codigoCliente."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Asignar Descuentos'  data-placement='left'><span class='fa fa-percent'></span></".$type.">";
	}
	if ( $permiso_181 == 1 )
	{	$opciones.= "<".$type." type='".$tag."' style='color:#D89C3F;' onclick='js_clientes_carga_asignacionGrupoEconomico(\"".$codigoCliente."\",".'"modal_showSetGrupoEconomico_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' class='btn btn-default btn-sm' aria-hidden='true' data-toggle='modal' data-target='#modal_showSetGrupoEconomico'  id='".$codigoCliente."_asignarGrupoEconomico' onmouseover='$(this).tooltip(".'"show"'.");' title='Asignar Grupo Económico'  data-placement='top'><span class='fa fa-group'></span></".$type.">";
	}
	$opciones.= "<".$type." type='".$tag."' style='color:red;' onclick='carga_tabla_asign_repr(\"".$codigoCliente."\",".'"div_asign_repr"'.",".'"'.$diccionario['rutas_head']['ruta_html_common'].'/representantes/controller.php"'.")' class='btn btn-default btn-sm' aria-hidden='true' data-toggle='modal' data-target='#modal_asign_repr'  id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Asignar representante' data-placement='top'><span class='fa fa-heart-o'></span></".$type.">";
	
	return $opciones;
}
function tabla_deudas( $tablacliente )
{   global $diccionario;
	$data = "<table class='table table-striped table-hover' id='tabla_estadoCuenta' name='tabla_estadoCuenta'>
				<thead style='background-color:#d1427e;color:white;'>
					<tr>
					   <th style=\"text-align:center;vertical-align:middle\"></th>
					   <th><div style='font-size:x-small;text-align:center;'>No. deuda</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Detalle</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Per&iacute;odo</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Total Inicial</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Total N/C</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Total Abonado</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Total Pendiente</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Estado</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Creaci&oacute;n Deuda</div></th>
					   <th><div style='font-size:x-small;text-align:center;'>Eliminar</div></th>
					</tr>
				</thead>
				<tbody>";
	foreach ( $tablacliente->rows as $row )
	{   if ( !empty( $row ) )
		{	$data.="<tr><td class='details-control'><i style='color:green;' class='fa fa-plus-circle'></i></td>";
			$x = $codigoDeuda = $numeroFactura = $titularID = 0;
			foreach( $row as $column )
			{	
				if ( $x == 0 )
				{   $titularID = $column;
				}
				if ( $x == 1 )
				{   $numeroFactura = $column;
				}
				if ( $x == 2 )
				{   $codigoDeuda = $column;
				}
				if ( $x == 9 )
				{   $codigoAlumno = $column;
					if ( !empty( $row['numeroFactura'] ) )
						$data.="<td><div style='font-size:x-small;'>".$column." <br>[<a href='/documentos/autorizados/".$_SESSION['directorio']."/".$titularID."/FAC".$numeroFactura.".PDF' target='_blank' onmouseover='$(this).tooltip(".'"show"'.")' title='FAC ".$numeroFactura."' data-placement='left'>FACTURA</a>]</div></td>";
					else
						$data.="<td><div style='font-size:x-small;'>".$column."</div></td>";
				}
				if( $x != 0 && $x != 1 && $x != 9  && $x != 11 )
					$data.="<td><div style='font-size:x-small;'>".$column."</div></td>";
				
				$x++;
			}
			$data.="<td><div style='font-size:x-small;'>".
					"<span onclick='eliminarDeuda(".'"'.$codigoDeuda.'"'.",".'"resultadoDeudas"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/clientes/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='".$codigoDeuda."_eliminar' onmouseover='$(this).tooltip(".'"show"'.")' title='Eliminar' data-placement='left'></span>".
					"</div></td>";
			$data.="</tr>";
		}
	}
	$data.="</tbody></table>";
	return $data;
}
function get_fecha_ciudad($print_time='true', $print_day='false')
{
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$fecha_det = get_ciudad_institucion() . ', '; //funcion en funciones.php
	if ($print_day=='true') 
		$fecha_det .= $dias[date('w')] . " ";
	$fecha_det .= date('d') . " de " . $meses[date('n')-1] . " del " . date('Y') . '.' ;
	if ($print_time=='true') $fecha_det .= ' '. date('H:i:s') . '.' ;
	return $fecha_det;
}
?>