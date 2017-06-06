<!-- Modal Configuración Colecturía-->
<div class="modal fade" id="modal_configColecturia" tabindex="-1" role="dialog" aria-labelledby="modal_configColecturia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#1A286A'>
				<h4 class="modal-title" id="modal_configColecturia" style='color:white;'>
					<i style="font-size:large;color:white;" class="fa fa-cog fa-spin"></i>&nbsp;Parámetros del sistema</h4>
			</div>
			<div class="modal-body" id="modal_configColecturia_body" style='background-color:#f4f4f4;'>
			</div>
			<div class="modal-footer" style='background-color:#f4f4f4;'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary"
					onclick="js_general_settings_change(
							document.getElementById('check_usa_pp_dv').checked,
							document.getElementById('desc_pronto').value,
							document.getElementById('desc_prepago').value,
							document.getElementById('check_enviar_fac_sri_en_cobro').checked,
							document.getElementById('check_enviar_cheque_a_bandeja').checked,
							document.getElementById('check_quitar_limite_dias_validez').checked,
							document.getElementById('check_bloqueo').checked,
							document.getElementById('txt_config_apikey').value,
							document.getElementById('txt_config_apikey_token').value,
							document.getElementById('check_genera_deuda_matr').checked,
							document.getElementById('check_bloqueo_matr_por_deuda').checked,
							document.getElementById('check_biblio_genera_multa_por_mora').checked,
							document.getElementById('check_biblio_bloquea_prestamo_por_deuda').checked,
							'{ruta_html_finan}/general/controller.php')">
						<span class='fa fa-wrench'></span>&nbsp;Guardar configuración</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Configuración Colecturía-->
<!-- Modal Configuración Botón-->
<div class="modal fade" id="modal_configBoton" tabindex="-1" role="dialog" aria-labelledby="modal_configBoton" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#1A286A'>
				<h4 class="modal-title" id="modal_configBoton" style='color:white;'>
					<i style="font-size:large;color:white;" class="fa fa-desktop"></i>&nbsp;Configuración de Botón de Pagos</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<!--<form id='frm_ptoEmisionAdd' name='frm_ptoEmisionAdd' 
					onsubmit="return js_general_config_bdp_change( )" role="form" data-toggle="validator">-->
				<div class="modal-body" id="modal_configBoton_body" style='background-color:#f4f4f4;'>
				</div>
				<div class="modal-footer" style='background-color:#f4f4f4;'>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="text" class="btn btn-primary" 
						onClick="return js_general_config_bdp_change( )" >
							<span class='fa fa-wrench'></span>&nbsp;Guardar configuración</button>
				</div>
			<!--</form>-->
		</div>
	</div>
</div>
<!-- Modal Configuración Botón-->
<!-- Modal quick access-->
<div class="modal fade" id="modal_quick_access" tabindex="-1" role="dialog" aria-labelledby="modal_configBoton" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#1A286A'>
				<h4 class="modal-title" id="modal_configBoton" style='color:white;'>
					<i style="font-size:large;color:white;" class="fa fa-desktop"></i>&nbsp;Educalinks</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="modal_quick_access_body" style='background-color:#f4f4f4;'>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<a href="../../../admin/index.php" title="Ir al módulo académico">
							<div class="info-box">
								<span class="info-box-icon bg-yellow"><i class="fa fa-graduation-cap"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Académico</span>
									<span class="info-box-number"><small>Notas, tutoría, clase virtual</small></span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<a href="../../../main_finan.php" title="Ir al módulo académico">
							<div class="info-box">
								<span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Financiero</span>
									<span class="info-box-number"><small>Colecturía, cobranza y facturación electrónica</small></span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<a href="../../../biblio/index.php" title="Ir al módulo académico">
							<div class="info-box">
								<span class="info-box-icon bg-blue"><i class="fa fa-book"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Biblioteca</span>
									<span class="info-box-number"><small>Mantenimiento de inventario de biblioteca</small></span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<a href="../../../main_medic.php" title="Ir al módulo académico">
							<div class="info-box">
								<span class="info-box-icon bg-red"><i class="fa fa-medkit"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Médico</span>
									<span class="info-box-number"><small>Inventario médico y ficha médica ocupacional</small></span>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<a href="../../../main_admisiones.php" title="Ir al módulo académico">
							<div class="info-box">
								<span class="info-box-icon bg-purple"><i class="fa fa-child"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Admisiones</span>
									<span class="info-box-number"><small>Módulo de Pre-selección</small></span>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="modal-footer" style='background-color:#f4f4f4;'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Módulos-->
<div class="modal fade" id="ModalEducalinksMoludos" tabindex="-1" role="dialog" aria-labelledby="modal_configBoton" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#E55A2F'>
				<h4 class="modal-title" id="ModalEducalinksMoludos_head" style='color:white;text-align:center;'>
					<i style="font-size:large;color:white;" class="fa fa-briefcase"></i>&nbsp;Módulos del sistema</h4>
			</div>
			<div class="modal-body" id="ModalEducalinksMoludos_body" style='background-color:#F5F5F5;'>
				<div class="row">
					<div class="col-xs-12">
					{mod}
					</div>
				</div>
			</div>
			<div class="modal-footer" style='background-color:#F5F5F5;text-align:center'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>