<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
	require('/../../../core/rutas.php');
    $descuento = get_mainObject('DescuentosTipo');
    $permiso = get_mainObject('General');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                                    VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                                    VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $desc_data = get_frontData();

	if (!isset($_POST['busq'])){$desc_data['busq'] = "";}else{$desc_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "descuento_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case SET:
            $descuento->set($desc_data);
			echo $descuento->mensaje;
            break;		
        case GET:
			$descuento->get($desc_data['desc_codigo']);
            $data = array(
                'desc_codigo'			=> $desc_data['desc_codigo'],
				'desc_descripcion'		=> $descuento->desc_descripcion,
                'desc_porcentaje'		=> $descuento->desc_porcentaje,
                'desc_estado'			=> $descuento->desc_estado,
				'desc_aplicaprontopago'	=> ($descuento->aplicaprontopago == 'SI')? 'checked':'');
			if ( $descuento->desc_tipo == 0 )
			{   $data[ 'tipo0' ] = 'selected= "selected" ';
				$data[ 'tipo1' ] = '';
			}
			if ( $descuento->desc_tipo == 1 )
			{	$data[ 'tipo0' ] = '';
				$data[ 'tipo1' ] = 'selected= "selected" ';
			}
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $descuento->delete($desc_data['desc_codigo']);  
			echo $descuento->mensaje;         
            break;
        case EDIT:
            $descuento->edit($desc_data);
			echo $descuento->mensaje;
            break;
		case GET_ALL_DATA:
            $descuento->get_all($desc_data['busq']);
			if(count($descuento->rows)>0){
				global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 117);
                $opciones["Opciones"].="<div class='btn-group'>";
                if ($permiso->rows[0]['veri']==1)
                {
				  $opciones["Opciones"].= "<button type='button' onclick='js_tipo_descuento_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tipo_descuento/controller.php"'.")' class='btn btn-default btn-sm' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar información' data-placement='left'><span class='btn_opc_lista_editar fa fa-pencil cursorlink'></span><span class='hidden-sm hidden-xs hidden-md'> Editar</span></button>";
                }
                else
                {
                  $opciones["Opciones"].="";
                }

                $permiso->permiso_activo($_SESSION['usua_codigo'], 118);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Opciones"].= "<button type='button' onclick='js_tipo_descuento_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tipo_descuento/controller.php"'.")' class='btn btn-default btn-sm' aria-hidden='true'id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar registro'><span class='btn_opc_lista_eliminar fa fa-trash cursorlink'></span><span class='hidden-sm hidden-xs hidden-md'> Eliminar</span></button>";
                }
                else
                {
                  $opciones["Opciones"].="";
                }
				$opciones["Opciones"].="</div>";
                $permiso->permiso_activo($_SESSION['usua_codigo'], 116);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_descuento']="";
                } 
                else
                {
                    $data['disabled_agregar_descuento']="disabled='disabled'";
                }
				
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$descuento->rows,
                                        "encabezado" => array("Código","Descripción","Porcentaje","Estado","Aplica Prontopago","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"desc_codigo");
			}else{
				$data = array('mensaje'=>$descuento->mensaje.$descuento->ErrorToString());
			}
            retornar_result($data);
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $descuento->get_all( '0' );
			if(count($descuento->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 117);
				$opciones["Opciones"].="<div class='btn-group'>";
                if ($permiso->rows[0]['veri']==1)
                {
				  $opciones["Opciones"].= "<button type='button' onclick='js_tipo_descuento_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tipo_descuento/controller.php"'.")' class='btn btn-default btn-sm' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar información' data-placement='left'><span class='btn_opc_lista_editar fa fa-pencil cursorlink'></span><span class='hidden-sm hidden-xs hidden-md'> Editar</span></button>";
                }
                else
                {
                  $opciones["Opciones"].="";
                }

                $permiso->permiso_activo($_SESSION['usua_codigo'], 118);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Opciones"].= "<button type='button' onclick='js_tipo_descuento_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tipo_descuento/controller.php"'.")' class='btn btn-default btn-sm' aria-hidden='true'id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar registro'><span class='btn_opc_lista_eliminar fa fa-trash cursorlink'></span><span class='hidden-sm hidden-xs hidden-md'> Eliminar</span></button>";
                }
                else
                {
                  $opciones["Opciones"].="";
                }
				$opciones["Opciones"].="</div>";
                $permiso->permiso_activo($_SESSION['usua_codigo'], 116);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_descuento']="";
                } 
                else
                {
                    $data['disabled_agregar_descuento']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$descuento->rows,
                                        "encabezado" => array("Código","Descripción","Porcentaje","Estado","Aplica Prontopago","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"desc_codigo");
				//$data['mensaje'] = "Listado de Descuentos";
			}else{
				$data = array('mensaje'=>$descuento->mensaje.$descuento->ErrorToString());
			}
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
        default:
			$descuento->get_all($desc_data['busq']);
			if(count($descuento->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 117);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='js_tipo_descuento_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tipo_descuento/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar información' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }

                $permiso->permiso_activo($_SESSION['usua_codigo'], 118);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='js_tipo_descuento_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tipo_descuento/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar registro'></span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 116);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_descuento']="";
                } 
                else
                {
                    $data['disabled_agregar_descuento']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
									"clase"=>"table table-bordered table-hover",
									"id"=>$tabla,
									"datos"=>$descuento->rows,
									"encabezado" => array("Código","Modelo","Descripción","Estado","Aplica Prontopago","Opciones"),
									"options"=>array($opciones),
									"campo"=>"desc_codigo");
			}else{
				$data = array('mensaje'=>$descuento->mensaje.$descuento->ErrorToString());
			}
				
            retornar_vista($event, $data);
    }
}

handler();
?>