<?php
session_start();
require_once("modelHTML.php");
require_once("rutas.php");
require_once("diccionario_menu.php");


# ======================================================
# Procedimientos de soporte para las interfaces
# ======================================================
function get_template($form='get') {
    $file = '../../../site_media/html/'.HTML_FILES.$form.'.php';
    $template = file_get_contents($file);
    return $template;
}
function get_menu(){
	global $diccionario_menu;
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/menu.php';
	$menu=file_get_contents($file);
	for($i=0;$i<count($_SESSION['usua_permiso'])-1;$i++){
		foreach($diccionario_menu as $campo => $valor){
			$array = explode("</span>", $valor['texto']);
			if(trim($valor['permiso'])==trim($_SESSION['usua_permiso'][$i][0])){
				if($valor['href']=='../../finan/gestionFacturas/'){
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_fac_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/gestionNotascredito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nc_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/gestionNotasdebito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nd_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/convenio_pago/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_cp_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/gestionContifico/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_contifico"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/valida_cheques/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_cheques_in"></span></a>',$menu);
				}
				else{
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].'</span></a>',$menu);
				}
			}
		}
	}
	foreach($diccionario_menu as $campo => $valor){
		if(trim($valor['permiso'])!=trim($_SESSION['usua_permiso'][$i][0])){
			$menu=str_replace($campo,'',$menu);
		}
	}
	$print_foto="";
	
	$file_exi = '../../'.$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
	
	if ( file_exists( $file_exi ) )
	{   $print_foto = '../'.$_SESSION["ruta_foto_usuario"].$_SESSION["usua_codi"].'.jpg';
	}
	else
	{	$print_foto = '../'.$_SESSION["ruta_foto_usuario"].'admin.jpg';
	}
	$menu = str_replace('{fotoUsuario}', $print_foto, $menu);
	$menu = str_replace('{logo_institucion}',   '../../'.$_SESSION['dir_logo_cliente_bg'],  $menu);
	$menu = str_replace('{nombre_institucion}', $_SESSION['menu_institucion'],$menu);
	$menu = str_replace('{nombre_del_modulo}',  $_SESSION['nombre_del_modulo'], $menu);
	
	if ( $_SESSION["modulo"] == 'alumnos' )
	{   if( !$_SESSION['cita_medica'] )
			$menu = str_replace('{citas_display}', " style='display:none;' ",$menu);
	}
	
	//$_SESSION['print_dir_logo_cliente'];
	//$_SESSION['print_dir_logo_cliente_bg'];
	
	return $menu;
}
function get_menuNew(){
	global $diccionario_menu;
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/menu.php';
	$menu=file_get_contents($file);
	for($i=0;$i<count($_SESSION['usua_permiso'])-1;$i++){
		foreach($diccionario_menu as $campo => $valor){
			if(trim($valor['permiso'])==trim($_SESSION['usua_permiso'][$i][0])){
				if($valor['href']=='../gestionFacturas/'){
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_fac_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionNotascredito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nc_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionNotasdebito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nd_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionContifico/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_contifico"></span></a>',$menu);
				}
				elseif($valor['href']=='../valida_cheques/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_cheques_in"></span></a>',$menu);
				}
				else{
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].'</span></a>',$menu);
				}
			}
		}
	}
	foreach($diccionario_menu as $campo => $valor){
		if(trim($valor['permiso'])!=trim($_SESSION['usua_permiso'][$i][0])){
			$menu=str_replace($campo,'',$menu);
		}
	}
	return $menu;
}
function get_navbar(){
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/navbar.php';
	$navbar=file_get_contents($file);
	
	$print_foto="";
	
	$file_exi = '../../'.$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
	
	if ( file_exists( $file_exi ) )
	{   $print_foto = '../'.$_SESSION["ruta_foto_usuario"].$_SESSION["usua_codi"].'.jpg';
	}
	else
	{	$print_foto = '../'.$_SESSION["ruta_foto_usuario"].'admin.jpg';
	}
	
	$navbar = str_replace('{fotoUsuario}', $print_foto, $navbar);
	$navbar = str_replace('{navbar_logo_educalinks}', '../..'.$_SESSION['dir_logo_educalinks_long'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks_small}', '../..'.$diccionario['rutas_head'].$_SESSION['dir_logo_educalinks_long_small'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks}', '../..'.$_SESSION['dir_logo_educalinks_long'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks_small}', '../..'.$diccionario['rutas_head'].$_SESSION['dir_logo_educalinks_long_small'] , $navbar);
	$navbar = str_replace('{cmb_sidebar_periodo}', $_SESSION['cmb_sidebar_periodo'], $navbar );
	$navbar = str_replace('{peri_deta}', $_SESSION['peri_deta'], $navbar );
	$navbar = str_replace('{SMS_USUA_DE}', $_SESSION['USUA_DE'], $navbar );
	$navbar = str_replace('{SMS_USUA_TIPO}', $_SESSION['USUA_TIPO'], $navbar );
	return $navbar;
}
function get_navbar_alumnos()
{   $file='../../../site_media/html/'.$_SESSION['modulo'].'/navbar.php';
	$navbar=file_get_contents($file);
	
	$print_foto="";
	
	$file_exi = '../../'.$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
	
	if ( file_exists( $file_exi ) )
	{   $print_foto = '../../'.$_SESSION["ruta_foto_usuario"].$_SESSION["usua_codi"].'.jpg';
	}
	else
	{	$print_foto = '../../'.$_SESSION["ruta_foto_usuario"].'admin.jpg';
	}
	$combo = str_replace('../fotos', '../../fotos', $_SESSION['cmb_alum_sel'] );
	$navbar = str_replace('{select_alumno}', $combo, $navbar);
	$navbar = str_replace('{ruta_foto_header}', $_SESSION['ruta_foto_header'], $navbar);
	$navbar = str_replace('{navbar_logo_educalinks}', '../..'.$_SESSION['dir_logo_educalinks_long'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks_small}', '../..'.$diccionario['rutas_head'].$_SESSION['dir_logo_educalinks_long_small'] , $navbar);
	$navbar = str_replace('{peri_deta}', $_SESSION['peri_deta'], $navbar );
	return $navbar;
}
function get_menu_sidebar(){
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/menu_sidebar.php';
	$sidebar=file_get_contents($file);
	$cmb = str_replace("value='".$_SESSION['peri_codi']."'", "value='".$_SESSION['peri_codi']."' selected='selected' " , $_SESSION['cmb_sidebar_periodo'] );
	
	$mod = "";
	
	if($_SESSION['certus_acad']){
		$mod.= "<a href='../../../admin/index.php' title=-Ir al módulo académico- style='width:100%' class='btn btn-warning'>
			<i class='fa fa-graduation-cap'></i>&nbsp;Académico
		</a><br><br>";}
	if($_SESSION['certus_finan']){ if($_SESSION['rol_finan']==1){
		$mod.= "<a href='../../../main_finan.php' title=-Ir al módulo financiero- style='width:100%' class='btn btn-success'>
			<i class='fa fa-dollar'></i>&nbsp;Financiero
		</a><br><br>";}}
	if($_SESSION['certus_biblio']){ if($_SESSION['rol_biblio']==1){
		$mod.= "<a href='../../../biblio/index.php' title=-Ir al módulo biblioteca- style='width:100%' class='btn btn-primary'>
			<i class='fa fa-book'></i>&nbsp;Biblioteca
		</a><br><br>";}}
	if($_SESSION['certus_medic']){ if($_SESSION['rol_medico']==1){
		$mod.= "<a href='../../../main_medic.php' title=-Ir al módulo médico- style='width:100%' class='btn btn-danger'>
		<i class='fa fa-medkit'></i>&nbsp;Médico
		</a><br><br>";}}
	$sidebar = str_replace('{mod}', $mod, $sidebar );
	return $sidebar;
}
function get_footer(){
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/footer.php';
	$footer=file_get_contents($file);
	return $footer;
}
function get_menuVisor(){
    $file='../../../site_media/html/'.$_SESSION['modulo'].'/menuVisor.php';
    $menu=file_get_contents($file);
    return $menu;
}
function get_navbarVisor(){
    $file='../../../site_media/html/finan/navbarVisor.php';
	$navbar = str_replace('{navbar_logo_educalinks}', '../..'.$_SESSION['dir_logo_educalinks_long'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks_small}', '../..'.$diccionario['rutas_head'].$_SESSION['dir_logo_educalinks_long_small'] , $navbar);
    $navbar=file_get_contents($file);
	return $navbar;
}
function add_rutas( $this )
{   require('../../../core/rutas.php');
	$this['rutas_head']=array(
		'css_all'  =>'
			<!-- Jquery -->
			<link href="{ruta_includes_common}/jquery/jquery-ui/jquery-ui.css" rel="stylesheet">
			<!-- Datepicker -->
			<link rel="stylesheet" href="{ruta_includes_common}/plugins/daterangepicker/daterangepicker-bs3.css">
			<link rel="stylesheet" href="{ruta_includes_common}/plugins/datepicker/datepicker3.css" />
			<link rel="shortcut icon" href="{ruta_imagenes_common}/favicon.png" />
			<!-- Datatable -->
			<link href="{ruta_includes_common}/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
			<link href="{ruta_includes_common}/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">
			<!-- Datatable Buttons -->
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
			<link href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap.min.css" rel="stylesheet">
			<!-- Slick Carousel -->
			<link href="{ruta_includes_common}/slick/slick.css" rel="stylesheet" type="text/css">
			<link rel="stylesheet" type="text/css" href="{ruta_includes_common}/slick/slick-theme.css"/>
			<!-- Bootstrap 3.3.5 -->
			<link rel="stylesheet" href="{ruta_includes_common}/bootstrap/css/bootstrap.css">
			<!-- Font Awesome -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
			<!-- Ionicons -->
			<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
			<!-- Theme style -->
			<link rel="stylesheet" href="{ruta_includes_common}/dist/css/AdminLTE.min.css">
			<!-- Select 2 -->
			<link rel="stylesheet" href="{ruta_includes_common}/plugins/select2/select2.min.css">
			<!-- AdminLTE Skins. Choose a skin from the css/skins
				 folder instead of downloading all of them to reduce the load. -->
			<link rel="stylesheet" href="{ruta_includes_common}/dist/css/skins/_all-skins.min.css">
			<!-- iCheck -->
			<link rel="stylesheet" href="{ruta_includes_common}/plugins/iCheck/flat/blue.css">',
		'js_all'  =>'
			<!-- jQuery 2.1.4 -->
			<script src="{ruta_includes_common}/plugins/jQuery/jQuery-2.1.4.min.js"></script>
			<!-- jQuery UI 1.11.4 -->
			<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
			<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
			<script>
				$.widget.bridge("uibutton", $.ui.button);
			</script>
			<!-- Bootstrap 3.3.5 -->
			<script src="{ruta_includes_common}/bootstrap/js/bootstrap.min.js"></script>
			<script src="{ruta_includes_common}/plugins/select2/select2.full.min.js"></script>
			<!-- DataTables -->
			<script src="{ruta_includes_common}/plugins/datatables/jquery.dataTables.min.js"></script>
			<script src="{ruta_includes_common}/plugins/datatables/dataTables.bootstrap.min.js"></script>
			<!-- InputMask -->
			<script src="{ruta_includes_common}/plugins/input-mask/jquery.inputmask.js"></script>
			<script src="{ruta_includes_common}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
			<script src="{ruta_includes_common}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
			<!-- Buttons -->
			<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
			<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
			<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
			<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
			<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
			<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
			<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js"></script>
			<!-- Morris.js charts -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
			<script src="{ruta_includes_common}/plugins/morris/morris.min.js"></script>
			<!-- Sparkline -->
			<script src="{ruta_includes_common}/plugins/sparkline/jquery.sparkline.min.js"></script>
			<!-- jvectormap -->
			<script src="{ruta_includes_common}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
			<script src="{ruta_includes_common}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
			<!-- jQuery Knob Chart -->
			<script src="{ruta_includes_common}/plugins/knob/jquery.knob.js"></script>
			<!-- daterangepicker -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
			<script src="{ruta_includes_common}/plugins/daterangepicker/daterangepicker.js"></script>
			<!-- datepicker -->
			<script src="{ruta_includes_common}/plugins/datepicker/bootstrap-datepicker.js"></script>
			<!-- Bootstrap WYSIHTML5 -->
			<script src="{ruta_includes_common}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
			<!-- Slimscroll -->
			<script src="{ruta_includes_common}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
			<!-- FastClick -->
			<script src="{ruta_includes_common}/plugins/fastclick/fastclick.min.js"></script>
			<!-- AdminLTE App -->
			<script src="{ruta_includes_common}/dist/js/app.js"></script>
			<!-- iCheck -->
			<script src="{ruta_includes_common}/plugins/iCheck/icheck.min.js"></script>
			<!-- AdminLTE for demo purposes -->
			<script src="{ruta_includes_common}/dist/js/demo.js"></script>
			
			<script src="{ruta_includes_common}/growl/jquery.growl.js" type="text/javascript"></script>
			<link  href="{ruta_includes_common}/growl/jquery.growl.css" rel="stylesheet" type="text/css" />
			<script src="{ruta_includes_common}/maskmoney/src/jquery.maskMoney.js" type="text/javascript"></script>
			<script src="{ruta_includes_common}/bootstrap-validator-master/js/validator.js" type="text/javascript"></script>
			<script src="{ruta_includes_common}/plugins/jQuery/numeric.js"></script>
			<script src="{ruta_includes_common}/shortcut.js"></script>
			<script type="text/javascript" src="{ruta_includes_common}/slick/slick.min.js"></script>
			<script src="{ruta_includes_common}/plugins/jQuery/notify.js"></script>
			
			
			<script src="{ruta_js_common}/general.js?i='. rand() . rand(). '"></script>
			<script src="{ruta_js_common}/mensajeria.js?i='. rand() . rand(). '"></script>',
		'rutas_all'  =>'
			<input type="hidden" id="hd_ui_skin" name="hd_ui_skin" value="{ui_skin}" />
			
			<input type="hidden" id="ruta_imagenes_acad" name="ruta_imagenes_acad" value="{ruta_imagenes_acad}" />
			<input type="hidden" id="ruta_html_acad" name="ruta_html_acad" value="{ruta_html_acad}" />
			<input type="hidden" id="ruta_js_acad" name="ruta_js_acad" value="{ruta_js_acad}" />
			<input type="hidden" id="ruta_css_acad" name="ruta_css_acad" value="{ruta_css_acad}" />
			
			<input type="hidden" id="ruta_imagenes_alumnos" name="ruta_imagenes_alumnos" value="{ruta_imagenes_alumnos}" />
			<input type="hidden" id="ruta_html_alumnos" name="ruta_html_alumnos" value="{ruta_html_alumnos}" />
			<input type="hidden" id="ruta_js_alumnos" name="ruta_js_alumnos" value="{ruta_js_alumnos}" />
			<input type="hidden" id="ruta_css_alumnos" name="ruta_css_alumnos" value="{ruta_css_alumnos}" />
			
			<input type="hidden" id="ruta_imagenes_admisiones" name="ruta_imagenes_admisiones" value="{ruta_imagenes_admisiones}" />
			<input type="hidden" id="ruta_html_admisiones" name="ruta_html_admisiones" value="{ruta_html_admisiones}" />
			<input type="hidden" id="ruta_js_admisiones" name="ruta_js_admisiones" value="{ruta_js_admisiones}" />
			<input type="hidden" id="ruta_css_admisiones" name="ruta_css_admisiones" value="{ruta_css_admisiones}" />
			
			<input type="hidden" id="ruta_imagenes_biblio" name="ruta_imagenes_biblio" value="{ruta_imagenes_biblio}" />
			<input type="hidden" id="ruta_html_biblio" name="ruta_html_biblio" value="{ruta_html_biblio}" />
			<input type="hidden" id="ruta_js_biblio" name="ruta_js_biblio" value="{ruta_js_biblio}" />
			<input type="hidden" id="ruta_css_biblio" name="ruta_css_biblio" value="{ruta_css_biblio}" />
			
			<input type="hidden" id="ruta_imagenes_medic" name="ruta_imagenes_medic" value="{ruta_imagenes_medic}" />
			<input type="hidden" id="ruta_html_medic" name="ruta_html_medic" value="{ruta_html_medic}" />
			<input type="hidden" id="ruta_js_medic" name="ruta_js_medic" value="{ruta_js_medic}" />
			<input type="hidden" id="ruta_css_medic" name="ruta_css_medic" value="{ruta_css_medic}" />
			
			<input type="hidden" id="ruta_imagenes_common" name="ruta_imagenes_common" value="{ruta_imagenes_common}" />
			<input type="hidden" id="ruta_html_common" name="ruta_html_common" value="{ruta_html_common}" />
			<input type="hidden" id="ruta_js_common" name="ruta_js_common" value="{ruta_js_common}" />
			<input type="hidden" id="ruta_css_common" name="ruta_css_common" value="{ruta_css_common}" />
			
			<input type="hidden" id="ruta_imagenes_finan" name="ruta_imagenes_finan" value="{ruta_imagenes_finan}" />
			<input type="hidden" id="ruta_html_finan" name="ruta_html_finan" value="{ruta_html_finan}" />
			<input type="hidden" id="ruta_js_finan" name="ruta_js_finan" value="{ruta_js_finan}" />
			<input type="hidden" id="ruta_css_finan" name="ruta_css_finan" value="{ruta_css_finan}" />',
			'ui_skin'					=> $_SESSION['ui_skin'],
			'sidebar_status'				=> $_SESSION['sidebar_status'],
			'ruta_css_finan'			=> $ruta_css_finan,
			'ruta_html_finan'			=> $ruta_html_finan,
			'ruta_js_finan'				=> $ruta_js_finan,
			'ruta_imagenes_finan'		=> $ruta_imagenes_finan,
			'ruta_includes_finan'		=> $ruta_includes_finan,
			'ruta_css_common'			=> $ruta_css_common,
			'ruta_html_common'			=> $ruta_html_common,
			'ruta_js_common'			=> $ruta_js_common,
			'ruta_imagenes_common'		=> $ruta_imagenes_common,
			'ruta_includes_common'		=> $ruta_includes_common,
			'ruta_css_acad'				=> $ruta_css_acad,
			'ruta_html_acad'			=> $ruta_html_acad,
			'ruta_js_acad'				=> $ruta_js_acad,
			'ruta_imagenes_acad'		=> $ruta_imagenes_acad,
			'ruta_includes_acad'		=> $ruta_includes_acad,
			'ruta_css_alumnos'			=> $ruta_css_alumnos,
			'ruta_html_alumnos'			=> $ruta_html_alumnos,
			'ruta_js_alumnos'			=> $ruta_js_alumnos,
			'ruta_imagenes_alumnos'		=> $ruta_imagenes_alumnos,
			'ruta_includes_alumnos'		=> $ruta_includes_alumnos,
			'ruta_css_admisiones'		=> $ruta_css_admisiones,
			'ruta_html_admisiones'		=> $ruta_html_admisiones,
			'ruta_js_admisiones'		=> $ruta_js_admisiones,
			'ruta_imagenes_admisiones'	=> $ruta_imagenes_admisiones,
			'ruta_includes_admisiones'	=> $ruta_includes_admisiones,
			'ruta_css_medic'			=> $ruta_css_medic,
			'ruta_html_medic'			=> $ruta_html_medic,
			'ruta_js_medic'				=> $ruta_js_medic,
			'ruta_imagenes_medic'		=> $ruta_imagenes_medic,
			'ruta_includes_medic'		=> $ruta_includes_medic,
			'ruta_css_biblio'			=> $ruta_css_biblio,
			'ruta_html_biblio'			=> $ruta_html_biblio,
			'ruta_js_biblio'			=> $ruta_js_biblio,
			'ruta_imagenes_biblio'		=> $ruta_imagenes_biblio,
			'ruta_includes_biblio'		=> $ruta_includes_biblio,
			'ruta_index_header'			=> $ruta_index_header,
			'ruta_main'					=> $ruta_main,
			'ruta_main_ssl'				=> $ruta_main_ssl,
			'proyecto'					=> 'Educalinks'
		);
	return $this;
}
function activa_menu($vista,$html){
	global $diccionario;
    $html = str_replace($diccionario['active_menu']['mainmenu'] , 'active', $html);
    $html = str_replace($diccionario['active_menu']['submenu'] , 'active', $html);
	$html = str_replace($diccionario['active_menu']['open'] , 'active', $html);
	return $html;
}
function render_dinamic_content($html, $data){
    foreach ($data as $clave=>$valor) {
        if( $clave[0]=="{" && $clave[strlen($clave)-1]=="}" ){
            # Elementos HTML con contenido dinamico
            switch ($valor['elemento']) {
				case 'a':
                    $html = str_replace($clave, HTML::a($valor['href'],$valor['content'],$valor['optional']), $html);
					break;
				case 'barChart':
                    $html = str_replace($clave, HTML::barChart($valor['datos'], $valor['label'], $valor['contenedor']), $html);
                    break;
				case 'lineChart':
                    $html = str_replace($clave, HTML::lineChart($valor['datos'], $valor['label'], $valor['contenedor']), $html);
                    break;
				case 'pieChart':
                    $html = str_replace($clave, HTML::pieChart($valor['datos'], $valor['contenedor']), $html);
                    break;
                case 'combo':
                    $html = str_replace($clave, HTML::select($valor['datos'],$valor['options'],$valor['selected']), $html);
                    break;
				case 'div':
                    $html = str_replace($clave, HTML::div($valor['content'],$valor['optional']), $html);
                    break;
                case 'tabla':
                    $html = str_replace($clave, HTML::table($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo']), $html);
                    break;
				case 'tabla_deudas':
                    $html = str_replace($clave, HTML::TableDeudasPendientes($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo']), $html);
                    break;
                case 'tabla_anidada':
                    $html = str_replace($clave, HTML::table_anidada($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
					break;
				case 'lista':
                    $html = str_replace($clave, HTML::ul($valor['datos'],$valor['options']), $html);
                    break;
                case 'text_box':
                    $html = str_replace($clave, HTML::input($valor['valor'], $valor['options']), $html);
                    break;
                case 'tablaSencilla':
                    $html = str_replace($clave, HTML::singleTable($valor['datos'], $valor['encabezado'], $valor['atributos']), $html); 
					break;                   
				case 'checkListBox':
                    $html = str_replace($clave, HTML::checkListBox($valor['datos'], $valor['campoVisualizacion'], $valor['campoValor'], /*$valor['atributos'],*/ $valor['valoresSeleccionados'], $valor['funcion']), $html);                
                    break;
                case 'tablaVisor':
                    $html = str_replace($clave, HTML::tableVisor($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
                    break;
				case 'tablaArrayIn':
                    $html = str_replace($clave, HTML::tableArrayIn($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
                    break;
                default:
                    break;
			 case 'tablaInputsencilla':
                    $html = str_replace($clave, HTML::tablaInputsencilla($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
					break;   
            }
        }else{
            # Datos estaticos
            $html = str_replace('{'.$clave.'}', $valor, $html);
        }
    }
    return $html;
}

# ======================================================
# Interfaces para el controlador
# ======================================================

function retornar_vista_submit($vista, $data=array()) {
	
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{menu}', get_menu(), $html);
	$html = str_replace('{navbar}', get_navbar(), $html);
	$html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
	$html = render_dinamic_content($html, $diccionario['usua_datos']);
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html);
        
    if(array_key_exists('mensaje', $data)) {
        $mensaje = $data['mensaje'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
function retornar_vista($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{menu}', get_menu(), $html);
	$html = str_replace('{navbar}', get_navbar(), $html);
	$html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
	$html = render_dinamic_content($html, $diccionario['usua_datos']);
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html);
        
    if(array_key_exists('mensaje', $data)) {
        $mensaje = $data['mensaje'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
function retornar_vista_in($vista, $data_in=array()) {
    global $diccionario;
    $html = get_template($vista);
    $html = render_dinamic_content($html, $data_in);
        
    if(array_key_exists('mensaje_in', $data_in)) {
        $mensaje = $data_in['mensaje_in'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje_in}', $mensaje, $html);
	return $html;
    
}
function retornar_formulario($vista, $data=array()) {
    global $diccionario;
    $html = get_template($vista);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, $data);
    $html = str_replace('{mensaje}', $mensaje, $html);
    print $html;
}

function retornar_result($data=array()){
    $html = "";
    foreach ($data as $elemento => $valor) {
        if( $elemento[0]=="{" && $elemento[strlen($elemento)-1]=="}" ){
            $html .= $elemento;
        }else{
            $html .= "{".$elemento."}";
        }
    }
    $html = render_dinamic_content($html,$data);

    print $html;
}

function retornar_pagina($vista, $data=array()) {
    $html = get_template($vista);
    $html = render_dinamic_content($html, $data);
    print $html;
}

function retornar_mensaje($mensaje) {
    //$html = get_template($vista);
    $html = $mensaje;
    print $html;
}


function retornar_vistaVisor($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{navbar}', get_navbarVisor(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, $diccionario['usua_datos']);
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html);
        
    if(array_key_exists('mensaje', $data))
	{   $mensaje = $data['mensaje'];
    }else
	{   $mensaje = 'Listado de usuarios:';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
?>