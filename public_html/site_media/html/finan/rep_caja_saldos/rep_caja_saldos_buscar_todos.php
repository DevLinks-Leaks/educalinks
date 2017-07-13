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
<!-- Modal Cargando-->
<div class="modal modal-transparent fade" id="modal_wait" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modal_resend_body" style='text-align:center;font-size:small;'>
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
<!-- Modal Revertir deuda y borrar pago-->
<div class="modal fade" id="modal_revert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<form id="file_form" action="{ruta_html_finan}/rep_caja_saldos/controller.php" enctype="multipart/form-data" method="POST" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="completo"/>
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
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>F. emisi&oacute;n</label>
							<div class="col-md-8 col-sm-8" id="div_fini" name="div_fini" >
								<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
									 title='Fecha de emisión, desde, hasta.'
									 onmouseover='$(this).tooltip("show")'>
									<span class="input-group-addon">
										<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();' checked>
									</span>			
									<span class="input-group-addon">
										<small>Inicio</small></span>
									<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
												value="{txt_fecha_ini}" placeholder="dd/mm/yyyy" required="required">
								
									<span class="input-group-addon">
										<small>Fin</small></span>
									<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
												value="{txt_fecha_fin}" placeholder="dd/mm/yyyy" required="required">
								</div>
							</div>
						</div>
					</div>
					<div class='col-md-6 col-sm-12' style='text-align:right;'>
						<div class='form-group'>
							<div class="checkbox checkbox-info col-md-4 col-sm-4  col-md-offset-0 col-sm-offset-4" style='text-align:right'>
								<label for='ckb_opc_adv'>
									<input type="checkbox" id='ckb_opc_adv' name='ckb_opc_adv' onclick='js_rep_caja_saldos_check_opc_avanzadas();'>
										<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
								</label>
							</div>
							<div class='col-md-6 col-sm-4' style='text-align:left'>
								<!--<button type="button" class='btn btn-primary' id='btn_selectPago_search' name='btn_selectPago_search'
									onmouseover='$(this).tooltip("show")' 
									title="Buscar pagos" 
									onclick="return js_rep_caja_saldos_carga_PagosRealizados('resultadoProcesoPagos');"><span class='fa fa-search'></span>
								</button>
								<button type="button" class='btn btn-default' id='btn_selectFem_excel' name='btn_selectFem_excel' 
									onclick="js_rep_caja_saldos_carga_reports('print_excel_all_data');"><span style='color:green;' class='fa fa-file-excel-o'></span></button>-->
								<button type="button" 
									class="btn btn-default" aria-hidden="true" 
									onclick="js_rep_caja_saldos_carga_reports('print_pdf_all_data');"">
									<span style='color:red;' class="fa fa-file-pdf-o"></span></button>
								<!--<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:text-bottom;'>
									<a href='#' onmouseover='$(this).tooltip("show")' 
									title="Los filtros de búsqueda funcionan también para todos los reportes en Excel y PDF." data-placement='right'><span class='glyphicon glyphicon-info-sign'></span></a>
								</div>-->
							</div>
						</div>
					</div>
				</div>
				<div id='div_opc_adv' name='div_opc_adv' class='collapse'>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Ref. Pago:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='C&oacute;digo del representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control" name="txt_codigo_pago" id="txt_codigo_pago" >
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>
									<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:text-bottom;'>
										<a href='#' onmouseover='$(this).tooltip("show")' 
										title="En caso de filtrar por 'forma de pago', considere lo siguiente: si una deuda fue cancelada con dos formas de pago diferentes, 
											y una de ellas es la forma de pago que filtró, se mostrará tanto el valor completo del pago, como la lista de todas las formas de pago aplicada
											a un mismo pago." data-placement='left'><span class='glyphicon glyphicon-info-sign'></span></a>
									</div>
									Forma de pago:</label>
								<div class="col-md-8 col-sm-8">
									{cmb_forma_pago}
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_num_factura'>Ref. FAC.:</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" max='99999999999999' min='1' class="form-control" name="txt_num_factura" id="txt_num_factura">
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Cajero:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Producto facturado'
										onmouseover='$(this).tooltip("show")'>
									{combo_cajas}
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_num_factura'>Categoría producto:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Categoría de producto'
										onmouseover='$(this).tooltip("show")'>
									{cmb_categoria}
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Producto:</label>
								<div class="col-md-8 col-sm-8">
									<div id="resultadoProducto" name="resultadoProducto">
										{cmb_producto}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_num_factura'>Sucursal:</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" max='9999' min='1' class="form-control" name="txt_sucursal" id="txt_sucursal">
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_num_factura'>Pto. Venta:</label>
								<div class="col-md-8 col-sm-8">
									<input type="number" max='9999' min='1' class="form-control" name="txt_ptoVenta" id="txt_ptoVenta" >
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Total Neto:</label>
								<div class="col-md-8 col-sm-8">
									<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
										 title='valor total neto, desde, hasta.'
										 onmouseover='$(this).tooltip("show")'>
										<span class="input-group-addon">
											<input type="checkbox" id='chk_tneto' name='chk_tneto' onclick='js_rep_caja_saldos_check_tneto();'>
										</span>			
										<span class="input-group-addon" style="text-align:right;font-size:small;font-weight:bold;">de $</span>
										<input type="text" class="form-control" name="txt_tneto_ini" id="txt_tneto_ini" placeholder='0.00' disabled='disabled'>
										<span class="input-group-addon" style="text-align:right;font-size:small;font-weight:bold;">a $</span>
										<input type="text" class="form-control" name="txt_tneto_fin" id="txt_tneto_fin"  placeholder='0.00' disabled='disabled'>
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
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
									<input type="text" class="form-control" name="txt_id_titular" id="txt_id_titular" >
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Nombre titular:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Nombre del titular del documento autorizado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control" name="txt_nom_titular" id="txt_nom_titular" >
								</div>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Cod. estudiante:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='C&oacute;digo del representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control" name="txt_cod_cliente" id="txt_cod_cliente" >
								</div>
							</div>
						</div>
						<div class='col-md-6 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Nombre estudiante:</label>
								<div class="col-md-8 col-sm-8"
										data-placement="bottom"
										title='Nombre del cliente representado'
										onmouseover='$(this).tooltip("show")'>
									<input type="text" class="form-control" name="txt_nom_cliente" id="txt_nom_cliente" >
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
				</div>
			</div>
		</div>
	</div>
</form>
<!--
<div class="box box-default">
	<div class="box-body">
		<div id="resultadoProcesoPagos">
			<div style='text-align:center; font-size:small'>Haga una consulta </div>
			{tabla_pagos}
		</div>
	</div>
</div>-->