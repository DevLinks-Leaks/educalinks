<!--<div id='save_ans' name='save_ans'
	style="text-align:right; padding: 20px 30px; background: rgb(66, 133, 244); z-index: 999999; font-size: 16px; font-weight: 100;">
	<p" style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;"><span class='fa fa-graduation-cap'><span></p>
	<a class="btn btn-default btn-sm" href="#" onclick="dismiss_process_ans();"
		style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);">Ocultar</a></div>-->
<?php
	$params = array(
		$_SESSION['usua_codi'],
		$_POST['curso_cupos'],
		$_POST['inst_siglas'],
		$_POST['inst_nomb'],
		$_POST['inst_nombre_legal'],
		$_POST['rector_nomb'],
		$_POST['rector_etiqueta'],
		(empty($_POST['rector_sexo']) ? 'F':'M'),
		$_POST['secr_nomb'],
		$_POST['secr_etiqueta'],
		(empty($_POST['secr_sexo']) ? 'F':'M'),
		$_POST['es_militar'],
		$_POST['ciudad'],
		$_POST['pais'],
		$_POST['jornada'],
		$_POST['inst_antes_de_su_nombre'],
		$_POST['financiero_nombre'],
		$_POST['distr_antes_de_su_nombre'],
		$_POST['distr_educativo_nomb'],
		$_POST['inst_dir'],
		$_POST['url_oficial'],
		$_POST['url_pagina_academico'],
		$_POST['coordinacion_zonal_nomb'],
		$_POST['codigo_AMIE'],
		$_POST['alum_codi_digitos'],
		(empty($_POST['incluir_alum_ret']) 			 		? '0':'1'),
		(empty($_POST['modo_genera_alum_codi']) 	 		? '0':'1'),
		(empty($_POST['bloqueo_preinscr_pantalla_bloqueo']) ? '0':'1'),
		(empty($_POST['show_obs_matri']) 			 		? '0':'1'),
		(empty($_POST['bloq_matr_por_aprobacion'])   		? '0':'1'),
		(empty($_POST['frm_alum_debito_mandatorio']) 		? '0':'1'),
		(empty($_POST['frm_alum_cedula_mandatorio']) 		? '0':'1'),
		(empty($_POST['libretas_show_user_pass'])    		? '0':'1'),
		(empty($_POST['notas_decimales']) 			 		? '0':'1'),
		$_POST['cantidad_decimales'],
		$_POST['min_aceptable_supl'],
		(empty($_POST['mostrar_pase_en_libreta']) 			? '0':'1'),
		$_POST['vista_libr_repr'],
		(empty($_POST['sms_alum_admin'])? 'N':'A'),
		(empty($_POST['sms_alum_doc'])  ? 'N':'A'),
		(empty($_POST['sms_alum_alum']) ? 'N':'A'),
		(empty($_POST['sms_alum_repr']) ? 'N':'A'),
		(empty($_POST['sms_repr_admin'])? 'N':'A'),
		(empty($_POST['sms_repr_doc'])  ? 'N':'A'),
		(empty($_POST['sms_repr_alum']) ? 'N':'A'),
		(empty($_POST['sms_repr_repr']) ? 'N':'A'),
		(empty($_POST['sms_doc_admin']) ? 'N':'A'),
		(empty($_POST['sms_doc_doc'])   ? 'N':'A'),
		(empty($_POST['sms_doc_alum'])  ? 'N':'A'),
		(empty($_POST['sms_doc_repr'])  ? 'N':'A'),
		$_POST['ms_host'],
		$_POST['ms_user'],
		$_POST['ms_pass'],
		$_POST['ms_port'],
		$_POST['ms_sll'],
		(empty($_POST['mod_doc_citas']) ? '0':'1'),
		(empty($_POST['mod_alum_cambiar_foto']) ? '0':'1'),
		$_POST['iva_upd_deudas_cero'],
		$_POST['prontopago'],
		$_POST['iva'],
		(empty($_POST['enviar_fac_sri_en_cobro']) ? 'N':'S'),
		(empty($_POST['enviar_cheque_a_bandeja']) ? 'N':'S'),
		(empty($_POST['quitar_limite_dias_validez']) ? 'N':'S'),
		$_POST['rdb_metodo_descuento'],
		(empty($_POST['bloqueo']) ? 'N':'S'),
		$_POST['apikey'],
		$_POST['apikeytoken'],
		(empty($_POST['generar_deuda_matricula']) 			? 'N':'S'),
		(empty($_POST['bloquear_matricula_deuda']) 			? 'N':'S'),
		(empty($_POST['biblio_genera_multa_por_mora']) 		? 'N':'S'),
		(empty($_POST['biblio_bloquea_prestamo_por_deuda']) ? 'N':'S'),
		(empty($_POST['incl_mat_group_calc']) 				? '0':'1'),
		(empty($_POST['prom_nota_padre_supl']) 				? '0':'1'),
		(empty($_POST['ingr_notas_alum_retirados']) 		? 'N':'S')
		
	);
	$sql="{call str_commonParametros_upd(".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?)}";
	$para_sist_busq = sqlsrv_query($conn, $sql, $params);  
	$row_para_sist = sqlsrv_fetch_array($para_sist_busq);
?>
<div id='save_ans' name='save_ans'
	style="padding: 20px 30px; background: #00a65a; z-index: 999999; font-size: 16px; font-weight: 600;">
	<p" style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;">Los cambios han sido realizados!</p>
	<a class="btn btn-default btn-sm" href="#" onclick="dismiss_process_ans();"
		style="margin-top: -5px; border: 0px; box-shadow: none; color: #00a65a; font-weight: 600; background: rgb(255, 255, 255);">¡Entendido!</a></div>
		