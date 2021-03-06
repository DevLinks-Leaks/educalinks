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
<div class="modal fade bs-example-modal-lg" id="modal_showDebtState" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="false" >
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Visor Estado de cuenta-->
<!-- Modal Visor Estado de cuenta Cliente externo-->
<div class="modal fade bs-example-modal-lg" id="modal_showDebtState_ext" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="false" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#f4f4f4">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel" >Estado de cuenta</h4>
			</div>
			<div class="modal-body" id="modal_showDebtState_ext_body" style="background-color:#f4f4f4;">
			...
			</div>
			<div class="modal-footer" style="background-color:#f4f4f4;">
				<button type="button" class="btn btn-primary"
					onclick="print_pdf('{ruta_html_finan}/clientes_externos/controller.php')"><i class='fa fa-file-pdf-o'></i>&nbsp;Estado de cuenta</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Visor Estado de cuenta-->
<!-- Modal Revertir deuda y borrar pago-->
<div class="modal fade" id="modal_revert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style='background-color:#3C8DBC;color:white;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Revertir deuda y borrar pago</h4>
            </div>
            <div class="modal-body" id="modal_revert_body">
            </div>
        </div>
    </div>
</div>
<!-- Modal Revertir deuda y borrar pago-->
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
<!--Modal editar datos factura-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"">
        <div class="modal-content">
			<div id="modal_edit_body">
                ...
            </div>
        </div>
    </div>
</div>
<!--Modal /. editar datos factura-->
<!-- Modal envío y reenvío individual factura al SRI -->
<div class="modal fade" id="modal_send" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style='background-color:#E55A2F;color:white;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Respuesta de Envío individual</h4>
            </div>
            <div class="modal-body" id="modal_send_body">
                ...
            </div>
            <div class="modal-footer">
			<a href='https://declaraciones.sri.gob.ec/comprobantes-electronicos-internet/publico/validezComprobantes.jsf' target='_blank'
				class="btn btn-danger"><i class='icon icon-sri'></i> Revisar facturas en sitio del SRI</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal envío y reenvío individual factura al SRI-->
<!-- Modal Envio y Reenvío por lote al SRI -->
<div class="modal fade" id="modal_lote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style='background-color:#E55A2F;color:white;'>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Resultado de Envio en lote</h4>
            </div>
            <div class="modal-body">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#modal_lote_body" aria-controls="modal_lote_body" role="tab" data-toggle="tab"><i class='fa fa-cog fa-spin'></i> Proceso</a></li>
						<li role="presentation"><a href="#lote_detail_body" aria-controls="lote_detail_body" role="tab" data-toggle="tab"><i class='fa fa-clipboard'></i>Detalle</a></li>
					</ul>
					<div class="tab-content">
						<div id="modal_lote_body" role="tabpanel" class="tab-pane active" >
						</div>
						<div id="lote_detail_body" role="tabpanel" class="tab-pane">
							<div style='height:245px;overflow-y:scroll;'>
								<div class="box-body">
									<div class="box-group" id="accordion">
									<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
										<div class="panel box box-success">
											<div class="box-header with-border">
												<h4 class="box-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="">
														AUTORIZADOS <span id="span_log_lote_autorizadas"></span>
													</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true">
												<div id="div_log_lote_autorizadas" class="box-body">
												</div>
											</div>
										</div>
										<div class="panel box box-warning">
											<div class="box-header with-border">
												<h4 class="box-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
														NO AUTORIZADOS <span id="span_log_lote_no_autorizadas"></span>
													</a>
												</h4>
											</div>
											<div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
												<div id="div_log_lote_no_autorizadas" class="box-body">
												</div>
											</div>
										</div>
										<div class="panel box box-primary">
											<div class="box-header with-border">
												<h4 class="box-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
														DEVUELTAS <span id="span_log_lote_devueltas"></span>
													</a>
												</h4>
											</div>
											<div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
												<div id="div_log_lote_devueltas" class="box-body">
												</div>
											</div>
										</div>
										<div class="panel box box-info">
											<div class="box-header with-border">
												<h4 class="box-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="collapsed" aria-expanded="false">
														PROCESADAS <span id="span_log_lote_procesadas"></span>
													</a>
												</h4>
											</div>
											<div id="collapseFour" class="panel-collapse collapse" aria-expanded="false">
												<div id="div_log_lote_procesadas" class="box-body">
												</div>
											</div>
										</div>
										<div class="panel box box-danger">
											<div class="box-header with-border">
												<h4 class="box-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" class="collapsed" aria-expanded="false">
														CON ERRORES <span id="span_log_lote_errores"></span>
													</a>
												</h4>
											</div>
											<div id="collapseFive" class="panel-collapse collapse" aria-expanded="false">
												<div id="div_log_lote_errores" class="box-body">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
            <div class="modal-footer">
			<a href='https://declaraciones.sri.gob.ec/comprobantes-electronicos-internet/publico/validezComprobantes.jsf' target='_blank'
				class="btn btn-danger"><i class='icon icon-sri'></i> Revisar facturas en sitio del SRI</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal Envio por lote al SRI. Data string para envio al SRI, chartgrama y codigos-->
<form id="file_form" action="{ruta_html_finan}/gestionFacturas/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="mini"/>
	<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
		<div class="panel-heading">
			<h3 class="panel-title"><a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
			<div class="pull-right">
				<a href="#/"  id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class='fa fa-minus'></span></a>
					<!--<a href="#/" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a>-->
			</div>
		</div>
		<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
			<div class="form-horizontal" role="form">
				<div class='form-group'>
					<div class='col-md-6 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Fecha pago:</label>
							<div class="col-md-8 col-sm-8" id="div_fini" name="div_fini" >
								<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
									 title='Fecha de pago, desde, hasta.'
									 onmouseover='$(this).tooltip("show")'>
									<span class="input-group-addon">
										<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();'>
									</span>			
									<span class="input-group-addon">
										<small>Inicio</small></span>
									<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
												value="" placeholder="dd/mm/yyyy" disabled='disabled'>
								
									<span class="input-group-addon">
										<small>Fin</small></span>
									<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
												value="" placeholder="dd/mm/yyyy" disabled='disabled'>
								</div>
							</div>
						</div>
					</div>
					<div class='col-md-6 col-sm-12' style='text-align:right;'>
						<div class='form-group'>
							<div class="checkbox checkbox-info col-md-4 col-sm-4  col-md-offset-0 col-sm-offset-4" style='text-align:right;'>
								<label for='ckb_gestionFactura_opc_adv'>
									<input type="checkbox" id='ckb_gestionFactura_opc_adv' name='ckb_gestionFactura_opc_adv' onclick='js_gestionFactura_check_opc_avanzadas();'>
										<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
								</label>
							</div>
							<div class='col-md-6 col-sm-4' style='text-align:left;'>
								<button class="btn btn-primary" type="button" 
										data-placement="bottom"
										title='Buscar facturas'
										onmouseover='$(this).tooltip("show")'
										onclick="js_gestionFactura_carga_busquedaFacturas('resultadoProceso','{ruta_html_finan}/gestionFacturas/controller.php')">
											<span class='fa fa-search'></span></button>
								<div class="btn-group">
									<button type="button" 
											title="Exportar búsqueda" onmouseover="$(this).tooltip('show');"
											class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span style='color:green;' class='fa fa-file-excel-o'>&nbsp;</span><span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#" onclick="js_gestionFactura_to_excel_busquedaFacturas('print_excel_all_data','mini');">Reporte reducido</a></li>
										<li><a href="#" onclick="js_gestionFactura_to_excel_busquedaFacturas('print_excel_all_data','completo');">Reporte completo</a></li>
									</ul>
								</div>
								<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:text-bottom;'>
									<a href='#' onmouseover='$(this).tooltip("show")' 
									title="Los filtros de búsqueda aplican también para todos los reportes en Excel." data-placement='right'><span class='glyphicon glyphicon-info-sign'></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id='div_gestionFactura_opc_adv' name='div_gestionFactura_opc_adv' class='collapse'>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Ref. Doc.:</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" max='99999999999999' min='1' class="form-control input-sm" name="txt_ref_factura" id="txt_ref_factura">
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_sucursal'>Sucursal:</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" max='9999' min='1' class="form-control input-sm" name="txt_sucursal" id="txt_sucursal">
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ptoVenta'>Pto. Venta:</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" max='9999' min='1' class="form-control input-sm" name="txt_ptoVenta" id="txt_ptoVenta" >
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ptoVenta'>No. factura:</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" max='9999' min='1' class="form-control input-sm" name="txt_numeroFactura" id="txt_numeroFactura" >
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Producto:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Producto facturado'
										onmouseover='$(this).tooltip("show")'>
									{cmb_producto}
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Total Neto:</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
										 title='valor total neto, desde, hasta.'
										 onmouseover='$(this).tooltip("show")'>
										<span class="input-group-addon">
											<input type="checkbox" id='chk_tneto' name='chk_tneto' onclick='js_gestionFactura_check_tneto();'>
										</span>		
										<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">de $</span>
										<input type="text" class="form-control input-sm" name="txt_tneto_ini" id="txt_tneto_ini" placeholder='0.00' disabled='disabled'>
										<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">a $</span>
										<input type="text" class="form-control input-sm" name="txt_tneto_fin" id="txt_tneto_fin"  placeholder='0.00' disabled='disabled'>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_fecha_deuda_ini'>F. creaci&oacute;n deuda:</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
										 title='Fecha de creación de deuda, desde, hasta.'
										 onmouseover='$(this).tooltip("show")'>
										<span class="input-group-addon">
											<input type="checkbox" id='chk_fecha_deuda' name='chk_fecha_deuda' onclick='js_gestionFactura_check_fechadeuda();'>
										</span>		
										<span class="input-group-addon">
											<small>Inicio</small></span>
										<input type="text" class="form-control input-sm" name="txt_fecha_deuda_ini" id="txt_fecha_deuda_ini" 
													value="" placeholder="dd/mm/yyyy" disabled='disabled'>
									
										<span class="input-group-addon">
											<small>Fin</small></span>
										<input type="text" class="form-control input-sm" name="txt_fecha_deuda_fin" id="txt_fecha_deuda_fin" 
													value="" placeholder="dd/mm/yyyy" disabled='disabled'>
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_fecha_aut_ini'>F. autorizaci&oacute;n:</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
										 title='Fecha de autorización, desde, hasta.'
										 onmouseover='$(this).tooltip("show")'>
										<span class="input-group-addon">
											<input type="checkbox" id='chk_fecha_aut' name='chk_fecha_aut' onclick='js_gestionFactura_check_fechaAut();'>
										</span>			
										<span class="input-group-addon">
											<small>Inicio</small></span>
										<input type="text" class="form-control input-sm" name="txt_fecha_aut_ini" id="txt_fecha_aut_ini" 
													value="" placeholder="dd/mm/yyyy" disabled='disabled'>
									
										<span class="input-group-addon">
											<small>Fin</small></span>
										<input type="text" class="form-control input-sm" name="txt_fecha_aut_fin" id="txt_fecha_aut_fin" 
													value="" placeholder="dd/mm/yyyy" disabled='disabled'>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Id. titular:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_id_titular" id="txt_id_titular" >
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Cod. estudiante:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='C&oacute;digo del representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_cod_cliente" id="txt_cod_cliente" >
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_titular'>Nombre titular:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Nombre del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_nom_titular" id="txt_nom_titular" >
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nombre estudiante:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Nombre del cliente representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control input-sm" name="txt_nom_cliente" id="txt_nom_cliente" >
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Período:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Período en el que se generó la deuda'
										onmouseover='$(this).tooltip("show")'>
									{cmb_periodo}
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Grupo Económico:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='grupo Económico'
										onmouseover='$(this).tooltip("show")'>
									{cmb_grupoEconomico}
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Nivel Económico:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Nivel económico'
										onmouseover='$(this).tooltip("show")'>
									<div id='resultadoNivelEcon' name='resultadoNivelEcon'>{cmb_nivelEconomico}</div>
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Curso Paralelo:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Curso del alumno'
										onmouseover='$(this).tooltip("show")'>
									<div id='resultadoCursos' name='resultadoCursos'>{cmb_curso}</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_estado'>Estado:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Estado de la factura'
										onmouseover='$(this).tooltip("show")'>
									<select class='form-control input-sm' id='cmb_estado' name='cmb_estado'>
										<option value=''>Seleccione...</option>
										<option value='P' selected='selected'>Pagado</option>
										<option value='PC'>Por cobrar</option>
										<option value='PV'>Por validar</option>
										<option value='A'>Anulado</option>
									</select>
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_estadoElectronico'>Estado electr&oacute;nico:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Estado electr&oacute;nico de la factura'
										onmouseover='$(this).tooltip("show")'>
									<select class='form-control input-sm' id='cmb_estadoElectronico' name='cmb_estadoElectronico'>
										<option value='' selected='selected'>Todos en gestión (DNA's)</option>
										<option value='AUTORIZADO'>Autorizado</option>
										<option value='NO AUTORIZADO'>No Autorizado</option>
										<option value='NO ENVIADO'>No Enviado</option>
										<option value='PROCESANDOSE'>Procesándose</option>
										<option value='ERROR'>Error</option>
										<option value='DEVUELTA'>Devuelta</option>
										<option value='CONTINGENTE'>Contingente</option>
										<option value='MFANF'>MFANF</option>
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
		<h3 class="box-title">
			<button class="btn btn-default" type='button' id='ckb_codigoDocumento_head2' name='ckb_codigoDocumento_head2'
				onClick='js_gestionFactura_select_all2( )'>
				<span id='span_codigoDocumento_head1' class="fa fa-square-o"></span>&nbsp;
				<span id='span_codigoDocumento_head2'>Marcar todos</span></button>
			<button class="btn btn-success fa fa-upload" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_lote'
					id='btn_send' name='btn_send'
					data-placement="bottom"
					title='Envío al SRI por lote'
					onmouseover='$(this).tooltip("show")'
					onclick="js_gestionFactura_envio_facturasPorLote('modal_lote_body','{ruta_html_finan}/gestionFacturas/controller.php')" {disabled_enviar_lote}></button>
			<button class="btn btn-warning fa fa-repeat" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_lote' 
					id='btn_resend' name='btn_resend'
					data-placement="bottom"
					title='Reenvío al SRI por lote'
					onmouseover='$(this).tooltip("show")'
					onclick="js_gestionFactura_autorizar_facturasPorLote('modal_lote_body','{ruta_html_finan}/gestionFacturas/controller.php')" {disabled_enviar_lote}></button>
			<span id='div_por_cobrar' name='div_por_cobrar' style='font-size:x-small;color:red;'></span>
		</h3>
	</div>
	<div class="box-body">
		<div id="resultadoProceso">
			{tabla}
		</div>
	</div>
</div>