<!-- Modal Cargando-->
<div class="modal modal-transparent fade" id="modal_msg" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modal_msg_body" style='text-align:center;font-size:small;'>
                <div align="center" style="height:100%;">
					Por favor, espere
					<br>
					<br>
					<i style="color:darkred;" class="fa fa-cog fa-spin"></i>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Cargando-->
<div class="modal modal-transparent fade modal-warning" id="modal_acad" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel" >Educalinks</h4>
			</div>
			<div class="modal-body" id="modal_acad_body" style='text-align:center;font-size:small;'>
                ¿Ir al módulo académico?
				<input type='hidden' id='hd_url_acad' name='hd_url_acad' value=''/>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left"
					onclick="js_clientes_go_to_courses_followed()"><span class='fa fa-university'></span>&nbsp;Ir</button>
				<button type="button" class="btn btn-outline pull-right" data-dismiss='modal'>En otro momento</button>
			</div>
        </div>
    </div>
</div>
<!-- Modal Visor Estado de cuenta-->
<div class="modal fade bs-example-modal-lg" id="modal_showDebtState" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#f4f4f4">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel" >Estado de cuenta</h4>
			</div>
			<div class="modal-body" id="modal_showDebtState_body" style="background-color:#f4f4f4;">
			...
			</div>
			<div class="modal-footer" style="background-color:#f4f4f4;">
				<button type="button" class="btn btn-success"
					onclick="print_cert_pdf('{ruta_html_finan}/clientes/controller.php')"><i class='fa fa-file-pdf-o'></i>&nbsp;Certificado financiero</button>
				<button type="button" class="btn btn-primary"
					onclick="print_pdf('{ruta_html_finan}/clientes/controller.php')"><i class='fa fa-file-pdf-o'></i>&nbsp;Estado de cuenta</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Visor Estado de cuenta-->
<!-- Modal Asignar-->
<div class="modal fade" id="modal_asign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="modal_asign_body">
			...
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar-->
<!-- Modal Asignar Grupo Economico-->
<div class="modal fade" id="modal_showSetGrupoEconomico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div id="modal_showSetGrupoEconomico_body">
			...
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar Grupo Economico-->
<!-- Modal Asignar representante-->
<div class="modal fade" id="modal_asign_repr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Asignar representante</h4>
			</div>
			<div class="modal-body" id='div_asign_repr' name='div_asign_repr'>
			...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar representante-->
<form id="file_form" action="{ruta_html_finan}/clientes/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="mini"/>
	<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
		<div class="panel-heading">
			<h3 class="panel-title"><a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
				<div class="pull-right">
					<a href="#/"  id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class='fa fa-minus'></span></a>
					<!--<a href="#/" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a>-->
				</div>
			</h3>
		</div>
		<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
			<div class="form-horizontal" role="form">
				<div class='row'>
					<div class='col-md-6 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='alum_codi_in'>Cod. del alumno:</label>
							<div class="col-md-8 col-sm-8"
									data-placement="bottom"
									title='C&oacute;digo del representado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control input-sm" name="alum_codi_in" id="alum_codi_in" >
							</div>
						</div>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='alum_apel_in'>Nombre del alumno:</label>
							<div class="col-md-8  col-sm-8"
									data-placement="bottom"
									title='Nombre del cliente representado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control input-sm" name="alum_apel_in" id="alum_apel_in" >
							</div>
						</div>
					</div>
					<div class='col-md-6 col-sm-12'>
						<div class='form-group'>
							<div class="checkbox checkbox-info col-md-4 col-sm-4  col-md-offset-0 col-sm-offset-4" style='text-align:right'>
								<label for='ckb_opc_adv'>
									<input type="checkbox" id='ckb_opc_adv' name='ckb_opc_adv' onclick='js_clientes_check_opc_avanzadas();'>
										<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
								</label>
							</div>
							<div class='col-md-6 col-sm-4' style='text-align:left'>
								<button class="btn btn-primary" type="button"
									id='btn_search' name='btn_search'
									data-placement="bottom"
									title='Buscar estudiantes'
									onmouseover='$(this).tooltip("show")'
									onclick="js_clientes_buscar('resultado','{ruta_html_finan}/clientes/controller.php', 1)"><span class='fa fa-search'></span></button>
								<div class="btn-group">
									<button type="button" 
											title="Exportar búsqueda" onmouseover="$(this).tooltip('show');"
											class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span style='color:green;' class='fa fa-file-excel-o'>&nbsp;</span><span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#" onclick="js_alumnos_lista_general();">Rep. Lista General</a></li>
									</ul>
								</div>
								<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:text-bottom;'>
									<a href='#' onmouseover='$(this).tooltip("show")' 
									title="Los filtros de búsqueda funcionan también para todos los reportes en Excel." data-placement='right'><span class='glyphicon glyphicon-info-sign'></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id='div_opc_adv' name='div_opc_adv' class='collapse'>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_alum_id'>No. Id. alumno:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_alum_id" id="txt_alum_id" >
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_grupo_economico'>Grupo Económico:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='grupo Económico'
										onmouseover='$(this).tooltip("show")'>
									{cmb_grupoEconomico}
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Período:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='Período en el que se generó la deuda'
										onmouseover='$(this).tooltip("show")'>
									{cmb_periodo}
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Nivel Económico:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='Nivel económico'
										onmouseover='$(this).tooltip("show")'>
									<div id='resultadoNivelEcon' name='resultadoNivelEcon'>{cmb_nivelEconomico}</div>
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='curs_para_codi_in'>Curso Paralelo:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='Curso del alumno'
										onmouseover='$(this).tooltip("show")'>
									<div id='resultadoCursos' name='resultadoCursos'>{cmb_curso}</div>
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>F. nacimiento:</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
										 title='valor total neto, desde, hasta.'
										 onmouseover='$(this).tooltip("show")'>
										<span class="input-group-addon">
											<input type="checkbox" id='chk_fecha_nac' name='chk_fecha_nac' onclick='js_clientes_check_fecha_nac();'>
										</span>			
										<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">de</span>
										<input type="text" class="form-control input-sm" name="txt_fecha_nac_ini" id="txt_fecha_nac_ini" placeholder='dd/mm/yyyy' disabled='disabled'>
										<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">a</span>
										<input type="text" class="form-control input-sm" name="txt_fecha_nac_fin" id="txt_fecha_nac_fin" placeholder='dd/mm/yyyy' disabled='disabled'>
									</div>
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_fecha_matri_ini'>F. matriculaci&oacute;n:</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group" id="div_fini" name="div_fini" data-placement="bottom"
										 title='Fecha de matriculación, desde, hasta.'
										 onmouseover='$(this).tooltip("show")'>
										<span class="input-group-addon">
											<input type="checkbox" id='chk_fecha_matri' name='chk_fecha_matri' onclick='js_alumnos_main_check_fechamatr();'>
										</span>		
										<span class="input-group-addon">
											<small>Inicio</small></span>
										<input type="text" class="form-control input-sm" name="txt_fecha_matri_ini" id="txt_fecha_matri_ini" 
													value="" placeholder="yyyy-mm-dd" disabled='disabled'>
									
										<span class="input-group-addon">
											<small>Fin</small></span>
										<input type="text" class="form-control input-sm" name="txt_fecha_matri_fin" id="txt_fecha_matri_fin" 
													value="" placeholder="yyyy-mm-dd" disabled='disabled'>
									</div>
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Id. titular:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_id_titular" id="txt_id_titular" >
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_titular'>Nombre titular:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='Nombre del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_nom_titular" id="txt_nom_titular" >
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_alum_estado'>Estado:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='Estado de la factura'
										onmouseover='$(this).tooltip("show")'>
									<select class='form-control input-sm' id='cmb_alum_estado' name='cmb_alum_estado'>
										<option value="-1" selected='selected'>- Todos -</option>
										<option value="1">RESERVADO</option>
										<option value="2">MATRICULADO POR PAGAR</option>
										<option value="3">MATRICULADO</option>
										<option value="4">OYENTE</option>
										<option value="5">RETIRADO</option>
										<option value="6">ADMITIDO</option>
										<option value="7">GRADUADO</option>
									</select>
								</div>
							</div>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_estado'>Estado reg.:</label>
								<div class="col-md-8  col-sm-8"
										data-placement="bottom"
										title='Estado de la factura'
										onmouseover='$(this).tooltip("show")'>
									<select class='form-control input-sm' id='cmb_estado' name='cmb_estado'>
										<option value='A' selected='selected'>Activo</option>
										<option value='E'>Eliminado</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="box box-default">
	<div class="box-header with-border">
	    <div class="box-header with-border">
			<h3 class="box-title">Bandeja de alumnos</h3>
			 <div class="box-tools pull-right">
				<h3 class="box-title">
					<div class="btn-group hidden-sm hidden-xs">
						<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"
							title='Opciones de vista'>
						<i class="fa fa-ellipsis-v"></i></button>
						<ul class="dropdown-menu" role="menu">
						<li><a href="#" onclick="js_clientes_buscar('resultado','{ruta_html_finan}/clientes/controller.php', 1)"><i class='fa fa-list-ul'></i> Mostrar en diseño nuevo</a></li>
						<li><a href="#" onclick="js_clientes_buscar('resultado','{ruta_html_finan}/clientes/controller.php', 2)"><i class='fa fa-list-alt'></i> Mostrar en cuadrícula</a></li>
						<li><a href="#" onclick="js_clientes_buscar('resultado','{ruta_html_finan}/clientes/controller.php', 3)"><i class='fa fa-print'></i> Mostrar cuadrícula para impresión</a></li>
						</ul>
					</div>
				</h3>
			</div>
			<input type='hidden' id='tipo_bandeja' name='tipo_bandeja' value=''/>
		</div><!-- /.box-header -->
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>