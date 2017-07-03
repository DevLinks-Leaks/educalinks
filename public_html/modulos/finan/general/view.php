<?php
session_start();
require_once("../../../core/viewBase.php");
$diccionario = array(
    'subtitle'=>array(  VIEW_HOME=>'Inicio',
                        VIEW_PASSWORD=>'Administrar contraseña',
                        VIEW_INFO_USER=>'Información del Usuario',
						VIEW_CONFIG_SIS=>'Información del Sistema',
    ),
    'active_menu'=>array(
		'open'  => '{open0}',
        'submenu'  => '{menu001}', 
        'mainmenu' => '{menu0}'
	),
	'rutas_head'=>array(),
    'links_menu'=>array(
        'cmb_sidebar_periodo'  => $_SESSION['cmb_sidebar_periodo']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array();
function get_main($form='main') {
    $file = '../../../site_media/html/'.HTML_FILES.$form.'.php';
    $template = file_get_contents($file);
    return $template;
}
function get_index() {
    /*$file = '../../index.php';
    $template = file_get_contents($file);
    return $template;*/
    global $diccionario;
    //echo $diccionario['rutas_head']['ruta_index_header'];
    header($diccionario['rutas_head']['ruta_index_header']);
}

function retornar_vista_general($vista, $data=array()) {
    global $diccionario;
    
    if($vista==VIEW_MAIN || $vista==VIEW_PASSWORD || $vista==VIEW_HOME || $vista==VIEW_INFO_USER || $vista==VIEW_CONFIG_SIS || $vista=PRINTREP_DEUDORES || $vista=PRINTREPVISOR)
	{   $html = get_main('main');
    }
	else
	{   $html = get_index();
    }
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{sidebar_status}', $_SESSION['sidebar_status'], $html);
    $html = str_replace('{ui_skin}', $_SESSION['ui_skin'], $html);
    $html = str_replace('{toggle_fullscreen}', $_SESSION['toggle_fullscreen'], $html);
    $html = str_replace('{formulario}', get_main($vista), $html);
    $html = str_replace('{navbar}', get_navbar(), $html);
    $html = str_replace('{menu}', get_menu(), $html);
    $html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, array('usua_nombres'  => $_SESSION['usua_nombres'],'usua_apellidos' => $_SESSION['usua_apellidos'],'usua_codigo' => $_SESSION['usua_codigo']));
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html); 
       
	if ( $_SESSION['caja_fecha'] < date('Ymd') )
	{	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
		$date = new DateTime($_SESSION['caja_fecha']);
		$mensaje = 
		'<div id="div_caja_antigua_abierta" name="div_caja_antigua_abierta"
				style="padding: 20px 30px; background: rgb(243, 156, 18); z-index: 999999; font-size: 16px; font-weight: 600;">
				<p" style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;">Tiene una caja abierta del 
				' .  $dias[ $date->format( 'w' ) ]." ". $date->format( 'd' ) ." de ".$meses[$date->format( 'n' )-1]. " del ".$date->format( 'Y' ) . '.</p>
				<a class="btn btn-default btn-sm" href="#" onclick="js_general_close_and_open_cash();"
					style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);">¡Cerrar caja y abrir caja de hoy!</a></div>';
		$html = str_replace('{div_caja_antigua_abierta}', $mensaje, $html);
	}
	else
	{
		$html = str_replace('{div_caja_antigua_abierta}', '', $html);
	}					
    if(array_key_exists('mensaje', $data))
	{   $mensaje = $data['mensaje'];
    }
	else
	{   $mensaje = '';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}

?>