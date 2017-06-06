<?php
session_start();
include("../../../framework/dbconf_main.php");
$params = array($domain);

$sql="{call dbo.clie_info_domain(?)}";
$resu_login = sqlsrv_query($conn, $sql, $params);  
$row = sqlsrv_fetch_array($resu_login);
$_SESSION['host']=$row['clie_instancia_db'];
$_SESSION['user']=$row['clie_user_db'];
$_SESSION['pass']=$row['clie_pass_db'];
$_SESSION['dbname']=$row['clie_base'];
$_SESSION['IN']= (isset($_SESSION['usua_codi']))?'OK':'KO';
$_SESSION['usua_codigo']=$_SESSION['usua_codi'];
$_SESSION['usua_pass']=$_SESSION['usua_pass'];
$_SESSION['modulo']='alumnos';

require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../common/catalogo/model.php');
require_once('../../finan/clientes/model.php');
require_once('../../finan/pagos/model.php');
//require_once('../../finan/general/model.php');

require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('funciones.php');
function handler() {
	require('../../../core/rutas.php');
	
    if (!isset($_POST['event']))
	{	if(!isset($_GET['event']))
		{	$event = INDEX;
		}
		else
		{	$event =$_GET['event'];
		}
	}
	else
	{	$event =$_POST['event'];
	}
	if (!isset($_POST['tabla']))
	{	$tabla= "tabla_rptDeudores";
	}
	else
	{	$tabla=$_POST['tabla'];
	}
	 
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(MAIN, VIEW_MAIN,PASS_CHANGED, 	PRINTREP_DEUDORES, PRINTREPVISOR, 
						VIEW_CONFIG_SIS,GET_DEBT, VIEW_HOME, VIEW_DEBT, VIEW_DEBT_ANS);
	
    foreach ($peticiones as $peticion)
	{	$uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true )
		{	$event = $peticion;
        }
    }
    //$gene_data 		= helper_data();	//variables que llegan por post desde el javascript
	$user_data 		= get_frontData(); //variables que llegan por post desde el javascript
    $general 		= set_obj();
	$gene			= set_obj();
	$cursos 		= set_obj();
	$periodos 		= set_obj();
	$periodo 		= get_mainObject('Periodo');
	$pensiones 		= set_obj();
    $apikey 		= set_obj();
	$deuda 			= set_obj();
	$permiso 		= get_mainObject('General');
	$tablacliente 	= get_mainObject('General');
	$pago 			= get_mainObject('Pagos');
	//echo "no locoxs asdadas";
    switch ($event) 
	{	case MAIN:
			global $diccionario;
			$_SESSION['IN']="OK";
			if( empty( $_SESSION['sidebar_status'] ) )
				$_SESSION['sidebar_status']='';
			
			$periodo->get_all();
			$cmb_sidebar_periodo = '<div class="btn-group-vertical" style="text-align:center;">';
			for($i=0;$i<count($periodo->rows)-1;$i++)
			{ 	$cmb_sidebar_periodo.= '<button type="button"
					id="btn_header_peri_'.$periodo->rows[$i]['peri_codi'].'" 
					name="btn_header_peri_'.$periodo->rows[$i]['peri_codi'].'" 
					data-deta="'.$periodo->rows[$i]['peri_deta'].'"
					class="'.( $periodo->rows[$i]['peri_codi'] == $_SESSION['peri_codi'] ? 'btn btn-primary': 'btn btn-default').'"
					onClick="js_general_change_periodo(document.getElementById(\'ruta_html_common\').value + \'/general/controller.php\','.$periodo->rows[$i]['peri_codi'].')"
					>ACTIVAR PERIODO LECTIVO '.$periodo->rows[$i]['peri_deta'].'</button>';
			}
			$cmb_sidebar_periodo.= '</div>';
		
		
			$data = array(
				'usua_codigo'=>$gene_data['usua_codigo'],
				'usua_nombres'=>$general->usua_nombres,
				'usua_apellidos'=>$general->usua_apellidos,
				'usua_correoElectronico'=>$general->usua_correoElectronico,
				'usua_codigoRol'=>$general->usua_codigoRol,
				'puntVent_codigo'=>$general->puntVent_codigo,
				'cmb_sidebar_periodo' => $cmb_sidebar_periodo );
				
			$_SESSION['ui_skin']='skin-blue';
			$_SESSION['toggle_fullscreen']='false';
			$_SESSION['usua_codigo']=$data['usua_codigo'];
			$_SESSION['usua_nombres']=$data['usua_nombres'];
			$_SESSION['usua_apellidos']=$data['usua_apellidos'];
			$_SESSION['cmb_sidebar_periodo']=$data['cmb_sidebar_periodo'];
			$_SESSION['usua_correoElectronico']=$data['usua_correoElectronico'];
			$_SESSION['usua_codigoRol']=$data['usua_codigoRol'];
			$_SESSION['puntVent_codigo']=$data['puntVent_codigo'];		
			
			$_SESSION['dir_logo_educalinks']=$ruta_logo_educalinks;
			
			$_SESSION['dir_logo_educalinks_long_red']=$ruta_logo_educalinks_long_red;
			$_SESSION['dir_logo_educalinks_long_red_small']=$ruta_logo_educalinks_long_red_sm;
			$_SESSION['dir_logo_educalinks_long_white']=$ruta_logo_educalinks_long_white;
			$_SESSION['dir_logo_educalinks_long_white_small']=$ruta_logo_educalinks_long_white_sm;
			$_SESSION['dir_logo_educalinks_long_white_red']=$ruta_logo_educalinks_long_white_red;
			
			$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_white'];
			$_SESSION['dir_logo_educalinks_long_small'] = $_SESSION['dir_logo_educalinks_long_white_small'];
			
			$_SESSION['dir_logo_redlinks_black']=$ruta_logo_redlinks_black;
			$_SESSION['dir_logo_redlinks_white']=$ruta_logo_redlinks_white;
			$_SESSION['dir_logo_links_md']=$ruta_logo_links_md;
			$_SESSION['dir_logo_links']=$ruta_logo_links;
			$_SESSION['print_dir_logo_educalinks']=$print_ruta_logo_educalinks;
			$_SESSION['print_dir_logo_educalinks_long_sm']=$print_ruta_logo_educalinks_long_small;
			$_SESSION['print_dir_logo_redlinks_black']=$print_ruta_logo_redlinks_black;
			$_SESSION['print_dir_logo_redlinks_white']=$print_ruta_logo_redlinks_white;
			$_SESSION['print_dir_logo_links_md']=$print_ruta_logo_links_md;
			$_SESSION['print_dir_logo_links']=$print_ruta_logo_links;
			$_SESSION['ruta_documentos_requisitos'] = $ruta_documentos_requisitos;
			$_SESSION['ruta_documentos_sintesis'] = $ruta_documentos_sintesis;
			
			$_SESSION['sgn_vps_pub'] = "-----BEGIN PUBLIC KEY-----\n".
			"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
			"TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
			"Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
			"DRr1jPeilfsiFwiO8wIDAQAB\n".
			"-----END PUBLIC KEY-----";
			
			$_SESSION['sgn_com_priv'] = '-----BEGIN RSA PRIVATE KEY-----\n'.
				'MIICXAIBAAKBgQDRcvWTo1vb3B1qimCJIU7E6TYe+TYdT/beT6L2XhK4CFw0srcT\n'.
				'8AnznPHEDF2NdjkgmIeemkNfZq16wPxuttAOM1RlzoS6lZ/pvzbWNj9squkppklE\n'.
				'OSc21IWo7qMYSXqJI0rym+TNt1BOsKXl6/YSxHXwrjUFaVugfzbnr4wk5wIDAQAB\n'.
				'AoGAN+85gioYOAj6mh9GVJjejluxpmfrebyHMyuVW7IX0an55eDsX5i1L6f0MOUU\n'.
				'ftjZvMi/Py33XBzxq1yqjW6o9QXFGNOw8KT+dVl1Usf1QdvcGQ7CIZ0CssRAzdij\n'.
				'GiBmQUG5B9ZNGCi5ptwrK89v6M2FcTvSxx4l29T91NU4ApECQQD7/RdFxdXNMhE0\n'.
				'Hrn/VNg6O8km9Hs5pXAWQlVsDf/0L1lOuv3jNabyGFT5svJs8bVEUWDDrgKdItO2\n'.
				'hxd3Q6P9AkEA1MiCn6ehyu3EiPLlWEtapcYGRCIkMdkhpm1rxQh9eIn4dAVFJl9P\n'.
				'o/016+1dLmXOXrs8yZ3fpn/bkuxXj9PXswJAYqx9s32/tgVYBT/O97QCo/MLVqy/\n'.
				'oBgvZxf8mT52LulnoFPK3XEB+aUbiVfQZGbV43W2XYnDTkL4Am6t+q7LBQJANytF\n'.
				'st9js5myO0++5wWimxicx02S1NnXP69fIdbxsS8UnABBzZEotPwR3vnMDxuWRjmF\n'.
				'qUClnCXKaG2exkvGwQJBANWIbuIYhC3s+3f119bDLsJDsE4t4B+MyU20ZYPohli2\n'.
				'EWQBSsVWyKSMULk3ICvAGYUK0LQ4A1NPE5ixkbEyTTI=\n'.
				'-----END RSA PRIVATE KEY-----';
				
			$_SESSION['domain'] = $domain;
			
			switch($domain){
				case  "ecobab.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobab.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_ecobab_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					$_SESSION['id_commerce_pagos_web'] = '7825';
					$_SESSION['id_commerce_diners_acquireid'] = 'https://ecobab.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '';
					$_SESSION['local_id_diners_pay'] = 'GN01';
					break;
				case  "dev.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='dev.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_desarrollo;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_desarrollo_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '7940';
					$_SESSION['id_commerce_diners_acquireid'] = 'http://dev.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '0992336919001';
					$_SESSION['local_id_diners_pay'] = 'GN01';
					break;
				case  "ecobabvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobabvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobabvesp;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_ecobabvesp_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobabvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7940';
					$_SESSION['id_commerce_diners_acquireid'] = 'https://ecobabvesp.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '';
					$_SESSION['local_id_diners_pay'] = 'GN02';
					break;
				case  "liceopanamericano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericano;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_liceopanamericano_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '7822';
					$_SESSION['id_commerce_diners_acquireid'] = 'https://liceopanamericano.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '0991505318001';
					$_SESSION['local_id_diners_pay'] = 'GN01';
					break;
				case  "liceopanamericanosur.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericanosur.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericanosur;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_liceopanamericanosur_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericanosur_bg;
					$_SESSION['id_commerce_pagos_web'] = '7938';
					$_SESSION['id_commerce_diners_acquireid'] = 'https://liceopanamericanosur.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '0991505318001';
					$_SESSION['local_id_diners_pay'] = 'GN02';
					break;
				case  "delfos.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfos.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfos;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_delfos_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfos_bg;
					$_SESSION['id_commerce_pagos_web'] = '7824';
					$_SESSION['id_commerce_diners_acquireid'] = 'https://delfos.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '0992336919001';
					$_SESSION['local_id_diners_pay'] = 'GN01';
					break;
				case  "delfosvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfosvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfosvesp;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_delfosvesp_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfosvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7939';
					$_SESSION['id_commerce_diners_acquireid'] = 'https://delfosvesp.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '0992336919001';
					$_SESSION['local_id_diners_pay'] = 'GN02';
					break;
				case  "moderna.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavemoderna;
					$_SESSION['passllaveactiva']=$clavellavemoderna;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='moderna.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_moderna;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_moderna_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_moderna_bg;
					$_SESSION['id_commerce_pagos_web'] = '7823';
					$_SESSION['id_commerce_diners_acquireid'] = 'https://moderna.educalinks.com.ec/alumnos/pagos/';
					$_SESSION['id_commerce_diners_pay'] = '0990606900001';
					$_SESSION['local_id_diners_pay'] = 'GN01';
					break;
				case  "americano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='americano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_americano_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				default:
					$_SESSION['llaveactiva']='default';
				break;
			}
			$tablaclientePaid = new General();
			$tablacliente->get_botonpago_deudas_listas( $_SESSION['alum_codi'], 'PC' );
			$tablaclientePaid->get_botonpago_deudas_listas( $_SESSION['alum_codi'], 'P' );
			$tabla_deudas_pdtes = tabla_deudas( $tablacliente, 'PC');
			$tabla_deudas_pasadas = tabla_deudas( $tablaclientePaid, 'P' );
			
			if ( $tabla_deudas_pdtes == '0' )
				$data['deudas_pdtes'] =  "No hay deudas pendientes de cobro.";
			else
				$data['deudas_pdtes'] =  $tabla_deudas_pdtes;
			
			if ( $tabla_deudas_pasadas == '0' )
				$data['deudas_pasadas'] = "No hay registro de deudas pagadas.";
			else
				$data['deudas_pasadas'] = $tabla_deudas_pasadas;
			retornar_vista_general(VIEW_HOME, $data);
        break;
		case GET_DEBT:
			global $diccionario;
			include("../../../includes/common/vpos_plugin.php");
			
			if( !isset( $_POST['ckb_deud_codigo'] ) )
				$deud_codigo = '';
			else 
			{   $true=0;
				$deud_codigo='<?xml version="1.0" encoding="iso-8859-1"?><deudas>';
				foreach ( $_POST['ckb_deud_codigo']  as $deuda )
				{   if( $deuda!= '' )
					{   $deud_codigo.='<deuda id="'.$deuda.'" />';
						$true=1;
					}
				}
				$deud_codigo.="</deudas>";
				if ( $true == 0 )
					$deud_codigo = "";
			}
			
			$general->get_deuda_informacion( $_SESSION['alum_codi'], $_SESSION['repr_codi'], $deud_codigo );
			$deuda = $general->rows;
			$vector = "F1A06EE948DC5B9B";
			
            //Llave Publica Crypto de Alignet. Nota olvidar ingresar los saltos de linea detallados con el valor \n
			//Publica de ellos
			//Privada de ellos nunca usamos
			
            $llaveVPOSCryptoPub = "-----BEGIN PUBLIC KEY-----\n".
			"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
			"TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
			"Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
			"DRr1jPeilfsiFwiO8wIDAQAB\n".
			"-----END PUBLIC KEY-----";
			
            //Llave Firma Privada del Comercio. Nota olvidar ingresar los saltos de linea detallados con el valor \n
			//Privada nuestra
            $llaveComercioFirmaPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
			"MIICXgIBAAKBgQDlwEgQZQZu3dT9WNTrOSA+nMZ6hj4HbY1qz7aEhbS6fs3mgLeS\n".
			"ED++JQyQbgxlEeto8Jy9mGQtXzZ4lIB0ejUCgXYvQi5RQS2yqSkrvWuNeR80jFPP\n".
			"2xwZwjPqxv/nFv+C/8KrTMXuuiz/mjhCNJhuHET1PZbhtPcid50XKR4B/wIDAQAB\n".
			"AoGBAN63/mP+OzVAUFfkREtejnaD7hgaiIkU11Fi2FExeFiN0jYQM2Qh4lkGe16L\n".
			"f/J+Y5HQJnHZB8vAEALmGnxPd5AGqq51LNBKIeA+RhW5F4MCOBFESClIYM3XEn7c\n".
			"xHcGbKXwmNBvQ7B8ugC4K9EOmfyDilGJMXggq96CGgFBZz1xAkEA/M23AhrEIgIt\n".
			"mLk1QEAruxgib8VNEiGK9ex3es/0XSgim6rqNo4AJX5ey0tN6Is6K0NivqELYfCx\n".
			"q7OUkwNgtwJBAOin8wz/OXT1P6KDtzJIo8qYbQ112Q8j+wDfBHCvebtSS7wRA0Ff\n".
			"zh4Css2wvoBNY4g1+uD6g6I/7uaX95UCkPkCQBTlSBAzeCy7c1thS6aA51xylT4Z\n".
			"19H81ciYABQ1piQhEiM90FgsCpUOyfURx2HGSEuVKU9Kbm9s/rKLiGdSaycCQQCH\n".
			"l5JUac7ftisvGNrE6IblBS7RYHRvmYWo/VEGJ46nuI/A/J1MFXz4CpSQwkhUWEYA\n".
			"1YzwX7Al+GLQa5L0ejlpAkEAyX5C5KLx9XmbgiKQC9l71YpsqB50wc8208Ccup1c\n".
			"5gmC3NiYMgBLvOAcmeHo3c2PRk4zmoW9rqGWsr7vfhprKQ==\n".
			"-----END RSA PRIVATE KEY-----";
			$deud_totalPendiente = 0; $deud_aux = 0;
			foreach ( $deuda as $row)
			{   $deud_totalPendiente = $deud_totalPendiente + $row['deud_totalPendiente'];
				$deud_aux++;
			}
            //Envío de Parametros a V-POS
            $array_send['acquirerId'] = '107'; //no cambia
            $array_send['commerceId'] = $_SESSION['id_commerce_pagos_web'];
            $array_send['purchaseOperationNumber'] = $row['pon_code'];
            //Monto incluido con impuestos
            $array_send['purchaseAmount'] = $deud_totalPendiente*100;
            $array_send['purchaseCurrencyCode'] = '840';
            $array_send['commerceMallId'] = '0';
            $array_send['language'] = 'SP';
            $array_send['billingFirstName'] = $row['repr_nomb'];
            $array_send['billingLastName'] = $row['repr_apel'];
            $array_send['billingEMail'] = $row['repr_email'];
            $array_send['billingAddress'] = $row['repr_domi'];
            $array_send['billingZIP'] = '090150';
            $array_send['billingCity'] = 'Guayaquil';
            $array_send['billingState'] = 'Guayaquil';
            $array_send['billingCountry'] = 'EC';
            $array_send['billingPhone'] = $row['repr_telf'];
            $array_send['shippingAddress'] = $row['repr_domi'];
            $array_send['terminalCode'] = '00000000';
            $array_send['reserved11'] = 'liceopanamericano';
			
			//Monto Grava VIA
            
            //Parametros Taxes Sobre Inclusión de Impuestos IVA
            $array_send['tax_1_name'] = 'Adicional';
            $array_send['tax_1_amount'] = '000';
            $array_send['tax_2_name'] = 'Monto Fijo';
            $array_send['tax_2_amount'] = '000';
            $array_send['tax_3_name'] = 'Monto IVA';
            $array_send['tax_3_amount'] = '000';
            $array_send['tax_4_name'] = 'Adicional';
            $array_send['tax_4_amount'] = '000';
            $array_send['tax_5_name'] = 'Adicional';
            $array_send['tax_5_amount'] = '000';
            $array_send['tax_6_name'] = 'Adicional';
            $array_send['tax_6_amount'] = '000';
            $array_send['tax_7_name'] = 'Adicional';
            $array_send['tax_7_amount'] = '000';
            $array_send['tax_8_name'] = 'Adicional';
            $array_send['tax_8_amount'] = '000';
            $array_send['tax_9_name'] = 'Monto No Grava IVA';
            $array_send['tax_9_amount'] = $deud_totalPendiente*100; //6000
            $array_send['tax_10_name'] = 'Monto Grava IVA';
            $array_send['tax_10_amount'] = '000';
            
            //Ejemplo envío campos reservados en parametro reserved1.
            $array_send['reserved1'] = 'SP';
            $array_send['reserved2'] = '000'; //Monto Grava IVA
            $array_send['reserved3'] = '000'; //Monto IVA
            $array_send['reserved4'] = '000';
            $array_send['reserved5'] = '000';
            $array_send['reserved9'] = '000';
            $array_send['reserved10']= '000'; //Monto Grava VIA
			
			  
   
			/*
			//Envío de Parametros a V-POS
            $array_send['acquirerId'] = '107';//no cambia
            $array_send['commerceId'] = $_SESSION['id_commerce_pagos_web'];
            $array_send['purchaseOperationNumber'] = $row['pon_code'];
            //Monto incluido con impuestos
            $array_send['purchaseAmount']='10000';
            $array_send['purchaseCurrencyCode']='840';
            $array_send['commerceMallId']='0';
            $array_send['language']='SP';
            $array_send['billingFirstName']='Juan';
            $array_send['billingLastName']='Perez';
            $array_send['billingEMail']='test@test.com';
            $array_send['billingAddress']='Direccion ABC';
            $array_send['billingZIP']='1234567890';
            $array_send['billingCity']='Quito';
            $array_send['billingState']='Quito';
            $array_send['billingCountry']='EC';
            $array_send['billingPhone']='123456789';
            $array_send['shippingAddress']='Direccion ABC';
            $array_send['terminalCode']='00000000';
            $array_send['reserved11']='Valor Reservado ABC'; //Monto Grava VIA
			
			//Parametros Taxes Sobre Inclusión de Impuestos IVA
            $array_send['tax_1_name']='Adicional';
            $array_send['tax_1_amount']='000';
            $array_send['tax_2_name']='Monto Fijo';
            $array_send['tax_2_amount']='000';
            $array_send['tax_3_name']='Monto IVA';
            $array_send['tax_3_amount']='1400';
            $array_send['tax_4_name']='Adicional';
            $array_send['tax_4_amount']='000';
            $array_send['tax_5_name']='Adicional';
            $array_send['tax_5_amount']='000';
            $array_send['tax_6_name']='Adicional';
            $array_send['tax_6_amount']='000';
            $array_send['tax_7_name']='Adicional';
            $array_send['tax_7_amount']='000';
            $array_send['tax_8_name']='Adicional';
            $array_send['tax_8_amount']='000';
            $array_send['tax_9_name']='Monto No Grava IVA';
            $array_send['tax_9_amount']='000';
            $array_send['tax_10_name']='Monto Grava IVA';
            $array_send['tax_10_amount']='8600';
			
			$array_send['reserved2']='8600'; //Monto Grava IVA
            $array_send['reserved3']='1400'; //Monto IVA
            $array_send['reserved4']='000';
            $array_send['reserved5']='000';
            $array_send['reserved9']='000';
            $array_send['reserved10']='8600'; //Monto Grava VIA
            */
			
            //Parametros de Solicitud de Autorización a Enviar
            $array_get['XMLREQ']="";
            $array_get['DIGITALSIGN']="";
            $array_get['SESSIONKEY']="";

            //Ejecución de Creación de Valores para la Solicitud de Autorización
			
			$data['datos_deuda'] = 
			'<div class="panel panel-info">
				<div class="panel-heading">Datos personales</div>
				<div class="panel-body" style="text-align:left;background-color:#f4f4f4;">'.
					'<br> <b>Nombre de venta:</b> ' . $row['repr_nomb'] . ' ' . $row['repr_apel'] .
					'<br> <b>E-mail:</b> ' . $row['repr_email'] .
					'<br> <b>Domicilio:</b> ' . $row['repr_domi'] .
					'<br> <b>Ciudad:</b> Guayaquil' .
					'<br> <b>Estado:</b> Guayaquil' .
					'<br> <b>País:</b> Ecuador' .
					'<br> <b>Teléfono:</b> ' . $row['repr_telf'] .
				'</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10">
					<div style="color:red">
						<b>Por favor, revisar que los datos del representante estén correctos para la impresión de factura.
						En caso de encontrar una novedad, comuníquese con la unidad educativa.</b>
					</div>
				</div>
			</div>';
				
			foreach ( $deuda as $row )
			{   $data['frm_pago_details'].= 
				'<br><b><span style="font-size:16px;color:#0066c0;">'.$row['prod_nombre'].'</span></b>'.
				' <span style="font-size:small">(código deuda: '.$row['deud_codigo'].')</span>'.
				'<br> Valor: ' . $row['deud_totalPendiente'] ;
			}
			
			if ( $deud_aux == '1' ) 
				$data['cantidad_total'] = '1 pensión';
			else
				$data['cantidad_total'].= $deud_aux . ' pensiones';
			
			$data['valor_total'] = " $".$deud_totalPendiente;
			
			VPOSSend($array_send,$array_get,$llaveVPOSCryptoPub,$llaveComercioFirmaPriv,$vector);
			//$privres = openssl_pkey_get_private(array($privatekey,null));
			
			/*
			/ -----------------------------------------------/
			/ DINERS PAY                                     /
			/ -----------------------------------------------/
			*/
			
			include_once("../../../includes/common/PlugInClient/PlugInClientSend.php");
			include_once("../../../includes/common/PlugInClient/RSAEncryption.php");
			$plugin = new PlugInClientSend(); 
			$AdquirerID = $_SESSION['id_commerce_diners_pay'];
			$MerchantID = $_SESSION['id_commerce_diners_pay'];
			$LocalID = $_SESSION['local_id_diners_pay']; 
			
			$moneda = "840";
			$URL_Tecnico = $_SESSION['id_commerce_diners_acquireid'];
			
			$vector_diners = "mV6VoYVJ54A=";
			$simetrica_diners = "g0yoaxPT4GQmvKIf7wcCV3Uv1SDgp9n0";
			
            
            $llaveVPOSCryptoPub_diners = "-----BEGIN PUBLIC KEY-----\n".
			"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCMEHg0R08b6SynYlich36KEnxe\n".
			"JRjRGG9thQpQOjy5j8qOVowx2NuD+Ew7ZC/dRtnpdh5rZGI3WMAymLd/zDa+mawA\n".
			"8Wg/8fa14ePumKhGhsfVXWPfBTAjo0gizKIIpinsF4LiDh+5zgv+2CtaaZloPqRC\n".
			"bO9en7FG4Xa7hnCoHQIDAQAB\n".
			"-----END PUBLIC KEY-----";
			
            $llaveComercioFirmaPriv_diners = "-----BEGIN RSA PRIVATE KEY-----\n".
			"MIICXQIBAAKBgQDDUnsVZqvVsYuhTmRM6Q1ePktIBn5Nnl3OqV30Cmf/Q1j8JGSa\n".
			"yORvintItmLYC9xZcAi9fP4s1bUb5phkN9w8ZHC5wKnEA0SEhLe/H47dw92KAc9S\n".
			"H0ElIDSDDhSFfWHe3gOGKJ3+aq1VYuybpuBImlLZyfaBp6ozjBykbsbupQIDAQAB\n".
			"AoGBAJnM19iZOROSs2U4Cii5lmowWS0E1+2clzdFDBM/InbQ/D/HFGUBbUcbX0p5\n".
			"O0ntxPu0CV3UD30UZoDqyfKYPdT73TBxgUG7AAD7dn3ndW0tGj+Sdjva1SjdqbFt\n".
			"Dbp5NBJfCz6NcyBfO8n6AskJLdU2vdHyN8u6iP/HqL6ORj2hAkEA5mbkcVRGzIMb\n".
			"iW2sLdavwDjBAMZFvEpv8G8W/+TwfC7SPsiMvMrt1eHnJYPfXSvCL1gW9QJyV3bx\n".
			"uFtX39X9LQJBANkF2SVlrMbAtzXg53GNN2b+5N681GdxdVKaVR489WcKhaJaQ4lV\n".
			"KV0Hqwevbll+9PNgHasKitCQ8cl5SaBf0lkCQHdZ44qlaot0eyZErsWMCbzcaXZa\n".
			"PzObp8L3+QUT9lON+ZFWWDlQMcXy4Mc5OdLM4SmfSz0eSFbwoaSrhKjJ8/0CQQDN\n".
			"NEpuogUMqYyS1WYCaJTKPpoKQmJUrWNSB7wUK2+fTsOtD8xsPqot3OJLEgY1eWYD\n".
			"+g4TfJRlQahd6OFFU1WBAkBk/S6KpzjQXnnE/GBbVChFw/moEonqHbhfZbxHKKSE\n".
			"J8zci75Ai6SA+8SPOcLTKsb0XPQFlIyGCt7eoGXbSGhj\n".
			"-----END RSA PRIVATE KEY-----";
			
            //Monto incluido con impuestos
            
			$e = $plugin->setLocalID( $LocalID );
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setTransacctionID( $row['pon_code'] );
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setTransacctionValue( $deud_totalPendiente*100 );
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setTaxValue1(000);
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setTaxValue2(000);
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setTipValue(000);
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setCurrencyID($moneda);
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setReferencia1("");
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setReferencia2("");
			if($e != "")
				echo "Error: $e";
			$e = $plugin->setReferencia3("");
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setReferencia4("");
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setReferencia5("");
			if($e!= "")
				echo "Error: $e";
			$e = $plugin->setIV( $vector_diners );
			if($e!= "")
				echo "Error: $e";
			try
			{
				$plugin->setSignPrivateKey( $llaveComercioFirmaPriv_diners );
				$plugin->setCipherPublicKey( $llaveVPOSCryptoPub_diners );
				$xmlGenerateKeyI = $plugin->CreateXMLGENERATEKEY();
				$plugin->XMLProcess($URL_Tecnico);
				$xmlRequest = $plugin->getXMLREQUEST();
				$xmlFirma 	= $plugin->getXMLDIGITALSIGN(); 
			}
			catch (Exception $e)
			{
				echo "Error: $e";
			}

			/* FIN DINERS CLUB */
			
			
			$data['frm_pago_sbmt'] = '
				<form name="frmVPOS" method="POST" action="https://integracion.alignetsac.com/VPOS/MM/transactionStart20.do">
																											
				<!--<form name="frmVPOS" method="POST" action="../pagos_respuesta/">-->
					<input TYPE="hidden" NAME="IDACQUIRER" 	ID="IDACQUIRER" 	value="'.$array_send['acquirerId'].'">
					<input TYPE="hidden" NAME="IDCOMMERCE" 	ID="IDCOMMERCE"		value="'.$array_send['commerceId'].'">
					<input TYPE="hidden" NAME="XMLREQ" 	 	ID="XMLREQ"			value="'.$array_get['XMLREQ'].'">
					<input TYPE="hidden" NAME="DIGITALSIGN" 	ID="DIGITALSIGN" 	value="'.$array_get['DIGITALSIGN'].'">
					<input TYPE="hidden" NAME="SESSIONKEY" 	ID="SESSIONKEY"		value="'.$array_get['SESSIONKEY'].'">
					<input TYPE="hidden" NAME="url" 			ID="url"			value="'.$_SESSION['id_commerce_pagos_web'].'">
					<input TYPE="hidden" NAME="name" 			ID="name"			value="'.$row['pon_code'].'">
																								   
																															   
																									 
					
					<input TYPE="hidden" NAME="ape" 			ID="ape"			value="Juan Perez">
					<input TYPE="hidden" NAME="email" 		ID="email"			value="'.$row['repr_email'].'">
					<input TYPE="hidden" NAME="valordeuda" 	ID="valordeuda"		value="8600">

					<button title="Visa / Mastercard Pagar con botón de pago Banco Bolivariano" onmouseover="$(this).tooltip(\'show\');" width="60%" class="btn btn-default" type="submit" NAME="btn_pagar" ID="btn_pagar">Pagar con&nbsp;
						<img width="25%" src="../../imagenes/mcvisa.png">
						<img width="25%" src="../../imagenes/bolivariano.png"></button>
					<br>
				</form>
				<form name="frmSolicitudPago" method="post" action="https://www3.optar.ec/webmpi/vpos">
				<!--Produccion <form name="frmSolicitudPago" method="post" action="https://www.interdinmpi.com.ec/webmpi/vpos?">-->
					<input type="text" name="XMLREQUEST"	 value="'.$xmlRequest.'">
					<input type="text" name="XMLDIGITALSIGN" value="'.$xmlFirma.'">
					<input type="text" name="XMLACQUIRERID"  value="'.$_SESSION['id_commerce_diners_acquireid'].'">
					<input type="text" name="XMLMERCHANTID"  value="'.$_SESSION['id_commerce_diners_pay'].'">
					<input type="text" name="XMLGENERATEKEY" value="'.$xmlGenerateKeyI.'">

					<button title="Visa / MasterCard  / Diners Pagar con botón de pago Diners Club" onmouseover="$(this).tooltip(\'show\');" width="60%" class="btn btn-default" type="submit" NAME="btn_pagar_diners" ID="btn_pagar_diners">Pagar con&nbsp;
					<img width="25%" src="../../imagenes/mcvisa.png">
					<img width="25%" src="../../imagenes/diners.png"></button>
					<br>
				</form>';
            
			retornar_vista_general(VIEW_DEBT, $data);
			break;
		case GET_DEBT_ANS_DINERS:
			global $diccionario;
			$_SESSION['IN']="OK";
			if( empty( $_SESSION['sidebar_status'] ) )
				$_SESSION['sidebar_status']='';
			
			include_once("../../../includes/common/PlugInClient/PlugInClientSend.php");
			include_once("../../../includes/common/PlugInClient/RSAEncryption.php");
			
			$periodo->get_all();
			$cmb_sidebar_periodo = '<div class="btn-group-vertical" style="text-align:center;">';
			for($i=0;$i<count($periodo->rows)-1;$i++)
			{ 	$cmb_sidebar_periodo.= '<button type="button"
					id="btn_header_peri_'.$periodo->rows[$i]['peri_codi'].'" 
					name="btn_header_peri_'.$periodo->rows[$i]['peri_codi'].'" 
					data-deta="'.$periodo->rows[$i]['peri_deta'].'"
					class="'.( $periodo->rows[$i]['peri_codi'] == $_SESSION['peri_codi'] ? 'btn btn-primary': 'btn btn-default').'"
					onClick="js_general_change_periodo(document.getElementById(\'ruta_html_common\').value + \'/general/controller.php\','.$periodo->rows[$i]['peri_codi'].')"
					>ACTIVAR PERIODO LECTIVO '.$periodo->rows[$i]['peri_deta'].'</button>';
			}
			$cmb_sidebar_periodo.= '</div>';
		
			$data = array(
				'usua_codigo'=>$gene_data['usua_codigo'],
				'usua_nombres'=>$general->usua_nombres,
				'usua_apellidos'=>$general->usua_apellidos,
				'usua_correoElectronico'=>$general->usua_correoElectronico,
				'usua_codigoRol'=>$general->usua_codigoRol,
				'puntVent_codigo'=>$general->puntVent_codigo,
				'cmb_sidebar_periodo' => $cmb_sidebar_periodo );
				
			$_SESSION['ui_skin']='skin-blue';
			$_SESSION['toggle_fullscreen']='false';
			$_SESSION['usua_codigo']=$data['usua_codigo'];
			$_SESSION['usua_nombres']=$data['usua_nombres'];
			$_SESSION['usua_apellidos']=$data['usua_apellidos'];
			$_SESSION['cmb_sidebar_periodo']=$data['cmb_sidebar_periodo'];
			$_SESSION['usua_correoElectronico']=$data['usua_correoElectronico'];
			$_SESSION['usua_codigoRol']=$data['usua_codigoRol'];
			$_SESSION['puntVent_codigo']=$data['puntVent_codigo'];		
			
			$_SESSION['dir_logo_educalinks']=$ruta_logo_educalinks;
			
			$_SESSION['dir_logo_educalinks_long_red']=$ruta_logo_educalinks_long_red;
			$_SESSION['dir_logo_educalinks_long_red_small']=$ruta_logo_educalinks_long_red_sm;
			$_SESSION['dir_logo_educalinks_long_white']=$ruta_logo_educalinks_long_white;
			$_SESSION['dir_logo_educalinks_long_white_small']=$ruta_logo_educalinks_long_white_sm;
			$_SESSION['dir_logo_educalinks_long_white_red']=$ruta_logo_educalinks_long_white_red;
			
			$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_white'];
			$_SESSION['dir_logo_educalinks_long_small'] = $_SESSION['dir_logo_educalinks_long_white_small'];
			
			$_SESSION['dir_logo_redlinks_black']=$ruta_logo_redlinks_black;
			$_SESSION['dir_logo_redlinks_white']=$ruta_logo_redlinks_white;
			$_SESSION['dir_logo_links_md']=$ruta_logo_links_md;
			$_SESSION['dir_logo_links']=$ruta_logo_links;
			$_SESSION['print_dir_logo_educalinks']=$print_ruta_logo_educalinks;
			$_SESSION['print_dir_logo_educalinks_long_sm']=$print_ruta_logo_educalinks_long_small;
			$_SESSION['print_dir_logo_redlinks_black']=$print_ruta_logo_redlinks_black;
			$_SESSION['print_dir_logo_redlinks_white']=$print_ruta_logo_redlinks_white;
			$_SESSION['print_dir_logo_links_md']=$print_ruta_logo_links_md;
			$_SESSION['print_dir_logo_links']=$print_ruta_logo_links;
			$_SESSION['ruta_documentos_requisitos'] = $ruta_documentos_requisitos;
			$_SESSION['ruta_documentos_sintesis'] = $ruta_documentos_sintesis;
			
			$_SESSION['domain'] = $domain;
			
			switch($domain){
				case  "ecobab.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobab.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					$_SESSION['id_commerce_pagos_web'] = '6924';
					break;
				case  "desarrollo.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='desarrollo.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_desarrollo;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '7822';
					break;
				case  "ecobabvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobabvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobabvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7058';
					break;
				case  "liceopanamericano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '6921';
					break;
				case  "liceopanamericanosur.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericanosur.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericanosur_bg;
					$_SESSION['id_commerce_pagos_web'] = '7056';
					break;
				case  "delfos.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfos.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfos_bg;
					$_SESSION['id_commerce_pagos_web'] = '6923';
					break;
				case  "delfosvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfosvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfosvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7057';
					break;
				case  "moderna.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavemoderna;
					$_SESSION['passllaveactiva']=$clavellavemoderna;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='moderna.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_moderna_bg;
					$_SESSION['id_commerce_pagos_web'] = '6922';
					break;
				case  "americano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='americano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				default:
					$_SESSION['llaveactiva']='default';
				break;
			}
			
			$firmaPrivada_comercio = "-----BEGIN PUBLIC KEY-----\n".
				"MIICXAIBAAKBgQCG2SM+eNoJwyYW5EbFgHk/Mw8K2PHIjBHBaCMR4V+xbw14mdGo\n".
				"1TklGIpJb1SKiNiqJa6i0YzTLQVZsU9ylCtFh+FOTQ5g56LozLY10ImhSWxxP9Cq\n".
				"5r7aC4q7wM8qT2/4sURcWZ/PFRNrqt+LsUZ0Lj13Kl/G76ldBMmeeRUs/QIDAQAB\n".
				"AoGARgnLo2vzm3RveR5Rn80trGShoHmzgv01T6X96RCMukS603PZEH7Gsny/forD\n".
				"dzzChAUUYl7CbQCKMd7FK/bHThGsOxIkHpZ5P9ZWwQICz2q7C9dTPjqceee6D8bx\n".
				"KZlMhqBcOGhlMqWKyjAj6CDG4AIhjYQt1Saco1sJiINCJQECQQDBrQgozyfNL9Qa\n".
				"mGkm6rrm8oDC+e5/lu2d4Tz93ETUx88cjPsCD/UBCwpcqZQQFTpAtd40foWe2C/Q\n".
				"S5Go5F69AkEAsj3lHuQHLvPRvcbVgkAx61vQefUtCQsGWdpDf2mhZ7BDS5uhWrVl\n".
				"Mx7RDrCGJLVO0/wgj+7blhHwNNbUKxMLQQJAOGvD+L+AhNHuJGFKIMA4+pai1Coj\n".
				"RKAfUOMQ9ZN5qdMbjuGzLgKgCVHCDwSH0bedZMSWmwxQuNmZ9EBPirgcsQJAa983\n".
				"vkVE766SHmeqqgSN8aIEfvraAaIReum0dfUIwQcVAzoyIgKsN48L+PbuiGLOTU9G\n".
				"qbVmYeGDXYcyqssAwQJBAKJX6O4xvTFze0ujcH2oJigZjwodVMVu4Su/QSi1ypwR\n".
				"Qzyf7Kgs2KXdga7R29gnQxYDPmHWdcz1LoNu1nhmRbg=\n".
				"-----END PUBLIC KEY-----";
			
			$firmaPublica_diners = '-----BEGIN RSA PRIVATE KEY-----\n'.
				'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCM6iId+CeR/CmgXJ5IbHLbtnZv\n'.
				'zbk/HGDowFdOVQZaa2ZFklTV+bmuhAfrwNJSDeakzT0OqnQgYc73Xfb5y6Kn8TFs\n'.
				'Hq9YW+/TCuMNdA6gQXO1lDxHTIAVgkHUaRJ5Gy/fvWzJuzqVWYFBo/WyPslO274h\n'.
				'1DYv/IbnU/IEmyq3hQIDAQAB\n'.
				'-----END RSA PRIVATE KEY-----';
			
			$plugin = new PlugInClientSend(); 
			$AdquirerID = $_SESSION['id_commerce_diners_pay'];
			$MerchantID = $_SESSION['id_commerce_diners_pay'];
			$LocalID = $_SESSION['local_id_diners_pay']; 
			
			$moneda = "840";
			$URL_Tecnico = $_SESSION['id_commerce_diners_acquireid'];
			
			$vector_diners = "mV6VoYVJ54A=";
			$simetrica_diners = "g0yoaxPT4GQmvKIf7wcCV3Uv1SDgp9n0";
			
			$xmlGenerateKey = $_POST["XMLGENERATEKEY"];
			$pluginr = new PlugInClientRecive();
			$pluginr->setIV($vector);
			
			$pluginr->setSignPublicKey( $firmaPublica_diners );
			$pluginr->setCipherPrivateKey( $firmaPrivada_comercio );
			$error = $pluginr->setXMLGENERATEKEY($xmlGenerateKey);
			$resultado = "";
			if($error != "")
			{
				$resultado = "Error:" . $error;
				return;
				 $general->set_operacion_auditoria(
												$pluginr->getAuthorizationCode(), $pluginr->getAuthorizationState(),
												$_POST['ERRORCODE'],  $error,
												'', '',
												$pluginr->getTransacctionID(), $pluginr->getTransacctionValue(),
												'' );
				$general->set_operacion_respuesta(
												$pluginr->getAuthorizationCode(), $pluginr->getAuthorizationState(),
												$_POST['ERRORCODE'],  $error,
												'', '',
												$pluginr->getTransacctionID(), $pluginr->getTransacctionValue(),
												'');
				$data['datos_deuda'] = "Error durante el proceso de interpretación de la respuesta. "
					."Verificar los componentes de seguridad: Vector Hexadecimal y Llaves.";
				
				$data['frm_pago_sbmt'] = "
				<div class='bs-callout bs-callout-danger'>
					<h4>Error</h4>
					Verificar los componentes de seguridad.
				</div>";
			}
			$cadeEnc = $_POST["XMLRESPONSE"];
			$firmaCorrecta = $pluginr->XMLProcess($cadeEnc, $_POST["XMLDIGITALSIGN"]);
			if($firmaCorrecta == 0)
			{
				//echo "<b>Los datos han sido alterados.</b><br>";
				return;
			}
			else
			{
				/*if($firmaCorrecta != 1)
				{
				$resultado = "<br><br>Error: $firmaCorrecta";
				return;
				}
				else 
					$resultado = "<b>Los datos no han sido alterados.</b><br>";*/
				$resultado = '<TABLE id="Table16" style="WIDTH: 456px; HEIGHT: 249px" height="249" cellSpacing="1" cellPadding="1" width="456" border="0">
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Transaccion ID Session Portal <? ?></TD>
						<TD>'.$pluginr->getTransacctionID().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Impuesto 1</TD>
						<TD>'.$pluginr->getTaxValue1().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Impuesto 2</TD>
						<TD>'.$pluginr->getTaxValue2().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Propina</TD>
						<TD>'.$pluginr->getTipValue().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Valor</TD>
						<TD>'.$pluginr->getTransacctionValue().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>ESTADO</TD>
						<TD>'.$pluginr->getAuthorizationState().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>NUMERO AUTORIZACION</TD>
						<TD>'.$pluginr->getAuthorizationCode().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Referencia 1</TD>
						<TD>'.$pluginr->getReferencia1().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Referencia 2</TD>
						<TD>'.$pluginr->getReferencia2().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Referencia 3</TD>
						<TD>'.$pluginr->getReferencia3().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Referencia 4</TD>
						<TD>'.$pluginr->getReferencia4().'</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 128px" width="128"></TD>
						<TD>Referencia 5</TD>
						<TD>'.$pluginr->getReferencia5().'</TD>
					</TR>
				</TABLE>';	
			}
			
			
			if(VPOSResponse($arrayIn,$arrayOut,$llaveVPOSFirmaPub,$llaveComercioCryptoPriv,$vector))
			{   $general->set_operacion_auditoria(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] );
				$general->set_operacion_respuesta(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] ); //reserved11 es el URL de procedencia de la solicitud.
				
				//$arrayOut['authorizationCode']
				if( $arrayOut['authorizationResult'] == '00') //AUTORIZADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-success'>
							<h4>Exito</h4>
							Operación Autorizada.
						</div>";
				if( $arrayOut['authorizationResult'] == '01') //DENEGADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-danger'>
							<h4>Error</h4>
							Operación Denegada.
						</div>";
				if( $arrayOut['authorizationResult'] == '05') //RECHAZADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-danger'>
							<h4>Error</h4>
							Operación Denegada.
						</div>";
				
				$data['datos_deuda'] = "
					<table>
						<tr><td>Resultado de la Transacción</td><td>".$arrayOut['authorizationResult']."</td></tr>
						<tr><td>Detalle del Resultado</td><td>". $arrayOut['errorCode'] . " - " . $arrayOut['errorMessage']."</td></tr>
						<tr><td>Número de la Tarjeta</td><td>". $arrayOut['cardNumber']."</td></tr>
						<tr><td>Marca de la Tarjeta</td><td>" . $arrayOut['cardType']."</td></tr>
						<tr><td>Número de Operacion</td><td>" . $arrayOut['purchaseOperationNumber']."</td></tr>
						<tr><td>Monto</td><td>S/. " . $arrayOut['purchaseAmount']/100 ."</td></tr>
					</table>
					<br/>
					<br/>";
				if( $arrayOut['authorizationResult'] == '00')
				{   $pagos = explode(";", $general->rows[0]['pagos']);
					$aux = 0; $html  = "";
					for ($aux = 0; $aux < count($pagos) ; $aux++ )
					{	$spanHTML="<span class='glyphicon glyphicon-print cursorlink' id='".$pagos[$aux]."_ver_pago' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n grande.' data-placement='left'></span>";
						$spanPDF="<span class='glyphicon glyphicon-print cursorlink' id='".$pagos[$aux]."_ver_pago_PDF' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n punto de venta.' data-placement='left'></span>";
						$html .="Recibo de pago no " . $pagos[$aux] . ": <a href='".$diccionario['ruta_html_finan']."/finan/PDF/imprimir/pago/".$pagos[$aux]."' target='_blank'>PDF</a> | ";
						$html .="<a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/pago/".$pagos[$aux]."' target='_blank'>HTML</a><br>";
					}
					$data['datos_deuda'] .=  $html;
				}
            }
			else
			{ $data['datos_deuda'] =  'Error al recibir respuesta del servico web de pagos Diners Club. Por favor, intente de nuevo.';
            }
			//$_SESSION['dominio_debt_ans'] = '';
			retornar_vista_general(VIEW_DEBT_ANS, $data);
			break;
		case GET_DEBT_ANS:
			global $diccionario;
			$_SESSION['IN']="OK";
			if( empty( $_SESSION['sidebar_status'] ) )
				$_SESSION['sidebar_status']='';
			
			$periodo->get_all();
			$cmb_sidebar_periodo = '<div class="btn-group-vertical" style="text-align:center;">';
			for($i=0;$i<count($periodo->rows)-1;$i++)
			{ 	$cmb_sidebar_periodo.= '<button type="button"
					id="btn_header_peri_'.$periodo->rows[$i]['peri_codi'].'" 
					name="btn_header_peri_'.$periodo->rows[$i]['peri_codi'].'" 
					data-deta="'.$periodo->rows[$i]['peri_deta'].'"
					class="'.( $periodo->rows[$i]['peri_codi'] == $_SESSION['peri_codi'] ? 'btn btn-primary': 'btn btn-default').'"
					onClick="js_general_change_periodo(document.getElementById(\'ruta_html_common\').value + \'/general/controller.php\','.$periodo->rows[$i]['peri_codi'].')"
					>ACTIVAR PERIODO LECTIVO '.$periodo->rows[$i]['peri_deta'].'</button>';
			}
			$cmb_sidebar_periodo.= '</div>';
		
		
			$data = array(
				'usua_codigo'=>$gene_data['usua_codigo'],
				'usua_nombres'=>$general->usua_nombres,
				'usua_apellidos'=>$general->usua_apellidos,
				'usua_correoElectronico'=>$general->usua_correoElectronico,
				'usua_codigoRol'=>$general->usua_codigoRol,
				'puntVent_codigo'=>$general->puntVent_codigo,
				'cmb_sidebar_periodo' => $cmb_sidebar_periodo );
				
			$_SESSION['ui_skin']='skin-blue';
			$_SESSION['toggle_fullscreen']='false';
			$_SESSION['usua_codigo']=$data['usua_codigo'];
			$_SESSION['usua_nombres']=$data['usua_nombres'];
			$_SESSION['usua_apellidos']=$data['usua_apellidos'];
			$_SESSION['cmb_sidebar_periodo']=$data['cmb_sidebar_periodo'];
			$_SESSION['usua_correoElectronico']=$data['usua_correoElectronico'];
			$_SESSION['usua_codigoRol']=$data['usua_codigoRol'];
			$_SESSION['puntVent_codigo']=$data['puntVent_codigo'];		
			
			$_SESSION['dir_logo_educalinks']=$ruta_logo_educalinks;
			
			$_SESSION['dir_logo_educalinks_long_red']=$ruta_logo_educalinks_long_red;
			$_SESSION['dir_logo_educalinks_long_red_small']=$ruta_logo_educalinks_long_red_sm;
			$_SESSION['dir_logo_educalinks_long_white']=$ruta_logo_educalinks_long_white;
			$_SESSION['dir_logo_educalinks_long_white_small']=$ruta_logo_educalinks_long_white_sm;
			$_SESSION['dir_logo_educalinks_long_white_red']=$ruta_logo_educalinks_long_white_red;
			
			$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_white'];
			$_SESSION['dir_logo_educalinks_long_small'] = $_SESSION['dir_logo_educalinks_long_white_small'];
			
			$_SESSION['dir_logo_redlinks_black']=$ruta_logo_redlinks_black;
			$_SESSION['dir_logo_redlinks_white']=$ruta_logo_redlinks_white;
			$_SESSION['dir_logo_links_md']=$ruta_logo_links_md;
			$_SESSION['dir_logo_links']=$ruta_logo_links;
			$_SESSION['print_dir_logo_educalinks']=$print_ruta_logo_educalinks;
			$_SESSION['print_dir_logo_educalinks_long_sm']=$print_ruta_logo_educalinks_long_small;
			$_SESSION['print_dir_logo_redlinks_black']=$print_ruta_logo_redlinks_black;
			$_SESSION['print_dir_logo_redlinks_white']=$print_ruta_logo_redlinks_white;
			$_SESSION['print_dir_logo_links_md']=$print_ruta_logo_links_md;
			$_SESSION['print_dir_logo_links']=$print_ruta_logo_links;
			$_SESSION['ruta_documentos_requisitos'] = $ruta_documentos_requisitos;
			$_SESSION['ruta_documentos_sintesis'] = $ruta_documentos_sintesis;
			
			$_SESSION['sgn_vps_pub'] = "-----BEGIN PUBLIC KEY-----\n".
			"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
			"TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
			"Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
			"DRr1jPeilfsiFwiO8wIDAQAB\n".
			"-----END PUBLIC KEY-----";
			
			$_SESSION['sgn_com_priv'] = '-----BEGIN RSA PRIVATE KEY-----\n'.
				'MIICXAIBAAKBgQDRcvWTo1vb3B1qimCJIU7E6TYe+TYdT/beT6L2XhK4CFw0srcT\n'.
				'8AnznPHEDF2NdjkgmIeemkNfZq16wPxuttAOM1RlzoS6lZ/pvzbWNj9squkppklE\n'.
				'OSc21IWo7qMYSXqJI0rym+TNt1BOsKXl6/YSxHXwrjUFaVugfzbnr4wk5wIDAQAB\n'.
				'AoGAN+85gioYOAj6mh9GVJjejluxpmfrebyHMyuVW7IX0an55eDsX5i1L6f0MOUU\n'.
				'ftjZvMi/Py33XBzxq1yqjW6o9QXFGNOw8KT+dVl1Usf1QdvcGQ7CIZ0CssRAzdij\n'.
				'GiBmQUG5B9ZNGCi5ptwrK89v6M2FcTvSxx4l29T91NU4ApECQQD7/RdFxdXNMhE0\n'.
				'Hrn/VNg6O8km9Hs5pXAWQlVsDf/0L1lOuv3jNabyGFT5svJs8bVEUWDDrgKdItO2\n'.
				'hxd3Q6P9AkEA1MiCn6ehyu3EiPLlWEtapcYGRCIkMdkhpm1rxQh9eIn4dAVFJl9P\n'.
				'o/016+1dLmXOXrs8yZ3fpn/bkuxXj9PXswJAYqx9s32/tgVYBT/O97QCo/MLVqy/\n'.
				'oBgvZxf8mT52LulnoFPK3XEB+aUbiVfQZGbV43W2XYnDTkL4Am6t+q7LBQJANytF\n'.
				'st9js5myO0++5wWimxicx02S1NnXP69fIdbxsS8UnABBzZEotPwR3vnMDxuWRjmF\n'.
				'qUClnCXKaG2exkvGwQJBANWIbuIYhC3s+3f119bDLsJDsE4t4B+MyU20ZYPohli2\n'.
				'EWQBSsVWyKSMULk3ICvAGYUK0LQ4A1NPE5ixkbEyTTI=\n'.
				'-----END RSA PRIVATE KEY-----';
				
			$_SESSION['domain'] = $domain;
			
			switch($domain){
				case  "ecobab.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobab.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					$_SESSION['id_commerce_pagos_web'] = '6924';
					break;
				case  "dev.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='desarrollo.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_desarrollo;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '7822';
					break;
				case  "ecobabvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobabvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobabvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7058';
					break;
				case  "liceopanamericano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '6921';
					break;
				case  "liceopanamericanosur.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericanosur.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericanosur_bg;
					$_SESSION['id_commerce_pagos_web'] = '7056';
					break;
				case  "delfos.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfos.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfos_bg;
					$_SESSION['id_commerce_pagos_web'] = '6923';
					break;
				case  "delfosvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfosvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfosvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7057';
					break;
				case  "moderna.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavemoderna;
					$_SESSION['passllaveactiva']=$clavellavemoderna;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='moderna.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_moderna_bg;
					$_SESSION['id_commerce_pagos_web'] = '6922';
					break;
				case  "americano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='americano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				default:
					$_SESSION['llaveactiva']='default';
				break;
			}
			include("../../../includes/common/vpos_plugin.php");
			
			$vector = "F1A06EE948DC5B9B";
			
			//Llave Firma Publica de Alignet
            $llaveVPOSFirmaPub = "-----BEGIN PUBLIC KEY-----\n". 
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCvJS8zLPeePN+fbJeIvp/jjvLW\n".
            "Aedyx8UcfS1eM/a+Vv2yHTxCLy79dEIygDVE6CTKbP1eqwsxRg2Z/dI+/e14WDRs\n".
            "g0QzDdjVFIuXLKJ0zIgDw6kQd1ovbqpdTn4wnnvwUCNpBASitdjpTcNTKONfXMtH\n".
            "pIs4aIDXarTYJGWlyQIDAQAB\n".
            "-----END PUBLIC KEY-----";

            //Llave Crypto Privada del Comercio
            $llaveComercioCryptoPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
            "MIICXQIBAAKBgQC6hOMFsiAVbHR5x2zPFyBo+Fhh7izXtk09pOJcmrb+TpQx8Wq+\n".
            "D6kqywWswYwh4hSCQlQ2WDIXlKeG04Z6CtzbXaPJGIfIoRXy/irfvsOLP34zHnfz\n".
            "MHd/jh+Prb5Bk8hTOKb1iIqPcjaTBshNS9JfXtCl3Ab6TOVlv2Xy2mvYJQIDAQAB\n".
            "AoGAHcCQzhnJ0GEKe1p6WtZfjx7+SjDJ6mbkD0875HWxdwNl1EmkM0kgPPlBoHsH\n".
            "NWhwyQ53jGupIeXOi002iEUvUXDyHvNcRqpFTT1buXAwPUZpJwM6S56iEoEF7I3X\n".
            "XxT+Qc5nhYMbuwpXAVHW9aLb4Ve3uofEVnJ2E2dHqwwCfcECQQDhDjAMB29jSpIX\n".
            "C4geFuYze+jtwvMML15F72ZvSCw4gXS16QnVtMpg8XXHda/HnEHOjzpL35J6f2Ci\n".
            "1i716QM5AkEA1Co+dH9RyJg1yZDmM0TT5sa/oGPseruWs2MbY69picWNPhfke83U\n".
            "+6uU08N4THzuNo2rov0VqzRcc8+4cKTgTQJBALn2aDs4VZEdCDQkojgCwfres2zr\n".
            "frud1G9DT0g6wdd7GP5LboX42pVaT/EdzL7K3hGZhhk1xyqTYD2Nb8Zg4PkCQQCl\n".
            "Y4jsJ5QJWx4S0vGgZbcJ30TiMwLVagZAMLHZM5SB4Y4JKXbjS8ELruWFbosIlRrd\n".
            "S/LQS5norBil7vdIWD7BAkAakLBSj5ZCrNfCnrbXNBFizotEuU4cTv8yPyEzwGZn\n".
            "HLiBear8u4ddEFKaHrHoqGIXLoYLcYsQgJZPKdDarxCa\n".
            "-----END RSA PRIVATE KEY-----";
			
			//Parametros de Recepción de Autorización
            $arrayIn['IDACQUIRER'] = $_POST['IDACQUIRER'];
            $arrayIn['IDCOMMERCE'] = $_POST['IDCOMMERCE'];
            $arrayIn['XMLRES'] 	   = $_POST['XMLRES'];
            $arrayIn['DIGITALSIGN']= $_POST['DIGITALSIGN'];
            $arrayIn['SESSIONKEY'] = $_POST['SESSIONKEY'];
            $arrayOut = '';
                
            //Ejecución de Creación de Valores para la Solicitud de Interpretación de la Respuesta
            if(VPOSResponse($arrayIn,$arrayOut,$llaveVPOSFirmaPub,$llaveComercioCryptoPriv,$vector))
			{   $general->set_operacion_auditoria(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] );
				$general->set_operacion_respuesta(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] ); //reserved11 es el URL de procedencia de la solicitud.
				
				//$arrayOut['authorizationCode']
				if( $arrayOut['authorizationResult'] == '00') //AUTORIZADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-success'>
							<h4>Exito</h4>
							Operación Autorizada.
						</div>";
				if( $arrayOut['authorizationResult'] == '01') //DENEGADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-danger'>
							<h4>Error</h4>
							Operación Denegada.
						</div>";
				if( $arrayOut['authorizationResult'] == '05') //RECHAZADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-danger'>
							<h4>Error</h4>
							Operación Denegada.
						</div>";
				
				$data['datos_deuda'] = "
					<table>
						<tr><td>Resultado de la Transacción</td><td>".$arrayOut['authorizationResult']."</td></tr>
						<tr><td>Detalle del Resultado</td><td>". $arrayOut['errorCode'] . " - " . $arrayOut['errorMessage']."</td></tr>
						<tr><td>Número de la Tarjeta</td><td>". $arrayOut['cardNumber']."</td></tr>
						<tr><td>Marca de la Tarjeta</td><td>" . $arrayOut['cardType']."</td></tr>
						<tr><td>Número de Operacion</td><td>" . $arrayOut['purchaseOperationNumber']."</td></tr>
						<tr><td>Monto</td><td>S/. " . $arrayOut['purchaseAmount']/100 ."</td></tr>
					</table>
					<br/>
					<br/>";
				if( $arrayOut['authorizationResult'] == '00')
				{   $pagos = explode(";", $general->rows[0]['pagos']);
					$aux = 0; $html  = "";
					for ($aux = 0; $aux < count($pagos) ; $aux++ )
					{	$spanHTML="<span class='glyphicon glyphicon-print cursorlink' id='".$pagos[$aux]."_ver_pago' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n grande.' data-placement='left'></span>";
						$spanPDF="<span class='glyphicon glyphicon-print cursorlink' id='".$pagos[$aux]."_ver_pago_PDF' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n punto de venta.' data-placement='left'></span>";
						$html .="Recibo de pago no " . $pagos[$aux] . ": <a href='".$diccionario['ruta_html_finan']."/finan/PDF/imprimir/pago/".$pagos[$aux]."' target='_blank'>PDF</a> | ";
						$html .="<a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/pago/".$pagos[$aux]."' target='_blank'>HTML</a><br>";
					}
					$data['datos_deuda'] .=  $html;
				}
            }
			else
			{   $general->set_operacion_auditoria(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] );
				$general->set_operacion_respuesta(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100 .".00",
												$arrayOut['reserved11'] );
				$data['datos_deuda'] = "Error durante el proceso de interpretación de la respuesta. "
					."Verificar los componentes de seguridad: Vector Hexadecimal y Llaves.";
				
				$data['frm_pago_sbmt'] = "
				<div class='bs-callout bs-callout-danger'>
					<h4>Error</h4>
					Verificar los componentes de seguridad.
				</div>";
            }
			$_SESSION['dominio_debt_ans'] = $arrayOut['reserved11'];
			retornar_vista_general(VIEW_DEBT_ANS, $data);
			break;
		case GET_OVERDUE_DEBT:
			global $diccionario;
			$general->get_deudasAnterioresVencidas($user_data['cabFact_codigo']);
			$json_deudas_vencidas=array();
			
			foreach($general->rows as $campo=>$valor)
			{   $json_deudas_vencidas[$campo]=$valor;
			}
			echo json_encode ($json_deudas_vencidas);
			break;
        default:
			$_SESSION['IN']="KO";
			$_SESSION['ERROR_MSG']="Por favor inicie sesión";
			echo "Resultado desconocido";
		break;
    }
}

function set_obj() {
    $obj = new General();
    return $obj;
}
handler();
function tabla_deudas( $tablacliente, $tabla_estado )
{   global $diccionario;

	$name = "";
	if ( $tabla_estado =='PC' )
	{   $name = 'tabla_estadoCuenta';
		$data = "
		<!--<form name='frmPagos' method='POST' action='".$diccionario['rutas_head']['ruta_main_ssl']."alumnos/pagos/'>-->
		<form name='frmPagos' method='POST' action='../../alumnos/pagos/'>
			<input TYPE='hidden' NAME='event' ID='evento' value='get_debt'>
			<table class='table table-bordered' id='".$name."' name='".$name."'>
				<thead>
					<tr id='tr_row_head'>
					    <th><div style='font-size:x-small;text-align:center;'>No. referencia</div></th>
					    <th><div style='font-size:x-small;text-align:center;'>Pensión</div></th>
					    <th><div style='font-size:x-small;text-align:center;'>Año lectivo</div></th>
						<th><div style='font-size:x-small;text-align:center;'>Fecha vencimiento</div></th>
						<th><div style='font-size:x-small;text-align:center;'>Valor de la deuda</div></th>
						<th id='select_deud_codigo_box' name='select_deud_codigo_box'>
							<div style='font-size:x-small;text-align:center;'>
								<input type='checkbox' id='ckb_deud_codigo_head' name='ckb_deud_codigo_head' onClick='js_pagos_select_all(this)'></input>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>";
	
		$i = 0;
		$num_linea = 0;
		foreach ( $tablacliente->rows as $row )
		{   if ( !empty( $row ) )
			{	$x = $codigoDeuda = $numeroFactura = $titularID = 0;
				if( $row['estado'] == 'POR COBRAR' && $row['totalAbonado'] == '0.00' )
					$data.="<tr id='tr_row_".$num_linea."'>";
				foreach( $row as $column )
				{	if( $row['estado'] == 'POR COBRAR' && $row['totalAbonado'] == '0.00' )
					{
						if ( $x == 0 )
						{   $titularID = $column;
						}
						if ( $x == 1 )
						{   $numeroFactura = $column;
						}
						if ( $x == 2 )
						{   $codigoDeuda = $column;
							/*$data = str_replace( "{yet_to_know_codigoDeuda}", $codigoDeuda, $data );
							//Hago el cambio del "{yet_to_know_codigoDeuda}" antes de saltar a la siguiente línea.
							//por ende, nunca habrá más de un "{yet_to_know_codigoDeuda}" a la vez.*/
						}
						if ( $row['estado'] == 'PAGADA' )
						{   if( $x != 0 && $x != 1 && $x != 5 && $x != 6 && $x != 10 && $x != 9  && $x != 11 )
								$data.="<td align='center'><div style='font-size:x-small;'>".$column."</div></td>";
						}
						if ( $row['estado'] == 'POR COBRAR' )
						{   if( $x != 0 && $x != 1 && $x != 5 && $x != 6 && $x != 7 && $x != 9  && $x != 11 )
								$data.="<td align='center'><div style='font-size:x-small;'>".$column."</div></td>";
						}
						$x++;
					}
				}
				if( $row['estado'] == 'POR COBRAR' && $row['totalAbonado'] == '0.00' )
				{	$i++;
					$data.="<td id='td_select_".$num_linea."' name='td_select_".$num_linea."' align='center'><div style='font-size:x-small;'>".
						"<input type='checkbox' id='ckb_deud_codigo' name='ckb_deud_codigo[]' value='".$codigoDeuda."'
							onclick='js_pagos_select_check_ind (this, ".$num_linea.")'></input>".
						"</div></td>
					</tr>";
				}
				$num_linea++;
			}
		}
		$data .= "	</tbody>".
			"	</table>".
			"<br>".
			"<button id='btn_pagar_deudas' name='btn_pagar_deudas' disabled='disabled' class='btn btn-success' type='submit' style='font-size:small;' >Pagar deudas marcadas</button>".
			"</form>";
	}
	if ( $tabla_estado =='P' )
	{   $name = 'tabla_estadoCuenta_paid';
		$data = "
				<input TYPE='hidden' NAME='event' ID='evento' value='get_debt'>
				<table class='table table-bordered' id='".$name."' name='".$name."'>
					<thead>
						<tr id='tr_row_head'>
							<th><div style='font-size:x-small;text-align:center;'>No. referencia</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Pensión</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Año lectivo</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Total Pago</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Opciones</div></th>
						</tr>
					</thead>
					<tbody>";
		$num_linea = 0;
		foreach ( $tablacliente->rows as $row )
		{   if ( !empty( $row ) )
			{	$x = $codigoDeuda = $numeroFactura = $titularID = 0;
				if( $row['estado'] == 'PAGADA' )
					$data.="<tr id='tr_row_".$num_linea."'>";
				foreach( $row as $column )
				{	if( $row['estado'] == 'PAGADA' )
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
						if( $x != 0 && $x != 1 && $x != 5 && $x != 6 && $x != 8 && $x != 9  && $x != 10 && $x != 11 )
							$data.="<td align='center'><div style='font-size:x-small;'>".$column."</div></td>";
						
						$x++;
					}
				}
				if( $row['estado'] == 'PAGADA' )
				{	$i++;
					$data.="
						<td align='center'  class='details-control'>".
							"<div style='font-size:x-small;'>".
								"<button class='btn btn-primary' id='".$codigoDeuda."_eliminar' style='font-size:small;' >Ver pago</button>".
							"</div>".
						"</td>".
					"</tr>";
				}
				$num_linea++;
			}
		}
		$data .= "	</tbody>".
			"	</table>";
	}
	if ($i == 0)
		return '0';
	else
		return $data;
}
?>