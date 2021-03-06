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
<!-- Modal Buscar cliente -->
<div class="modal fade" id="modal_busquedaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Búsqueda de cliente</h4>
      </div>
      <div class="modal-body" id="modal_busquedaCliente_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="selecciona('{ruta_html_finan}/notaCredito/controller.php')">Seleccionar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Buscar cliente -->
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
<!-- Modal Agregar valor a reducir -->
<div class="modal fade" id="modal_addValorNC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Valor a reducir</h4>
      </div>
      <div class="modal-body" id="modal_addValorNC_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addDetalleNC('{ruta_html_finan}/notaCredito/controller.php')">Agregar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar valor a reducir -->

<!-- Modal para mostrar el resultado del pago -->
<div class="modal fade" id="modal_resultadoNC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Resultado de la operación</h4>
      </div>
      <div class="modal-body" id="modal_resultadoNC_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="cancelar();" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="ImprimirFactura('{ruta_html_finan}/cobros/controller.php')">Imprimir factura</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal para mostrar el resultado del pago -->
<div id="div_modal_seleccionar_persona_lista" name="div_modal_seleccionar_persona_lista"></div>
<!-- CLIENTE -->
<div class='panel panel-info'>
	<div class="panel-heading">
		<table style='width:100%'>
			<tr>
				<td style='text-align:left;'>
					Cliente
					<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
						<a href='#' onmouseover='$(this).tooltip("show")' title="Para generar una nota de cr&eacute;dito, haga click en 'Buscar' para empezar por buscando un cliente." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
					</div>
				</td>
				<td style='text-align:right;'>
					<!--<button id="btnBuscarCliente" type="button" 
						class="btn btn-info btn-md" aria-hidden="true" data-toggle="modal" data-target="#modal_busquedaCliente" 
						onclick="carga_busquedaCliente('modal_busquedaCliente_body','{ruta_html_finan}/cobros/controller.php')" {disabled_caja} >
					<span class='glyphicon glyphicon-search'></span>&nbsp;Buscar</button>-->
					<button class="btn btn-info btn-md" 
							onclick="js_persona_select_user_searchlist_2('span_button_save_person', 'div_modal_seleccionar_persona_lista', '','js_notaCredito_selecciona')">
							<span class="glyphicon glyphicon-search"></span>&nbsp;Buscar</button>
				</td>
			</tr>
		</table>
	</div>
	<div class="panel-footer">
		<div id="datosCliente" name="datosCliente" class="grid">
			<div class="row">
				<div class="col-sm-2">
					<input type="hidden" readonly class="form-control" id="hd_tipo_persona" name="hd_tipo_persona" />
					<input type="text" readonly class="form-control" id="codigoCliente" name="codigoCliente" placeholder="Codigo" />
				</div>
				<div class="col-sm-2">
					<input type="text" readonly class="form-control" id="numeroIdentificacionCliente" name="numeroIdentificacionCliente" placeholder="CI / RUC" />
				</div>
				<div class="col-sm-4">
					<input type="text" readonly class="form-control" id="nombresCliente" name="nombresCliente" placeholder="Nombres" />
					<input type="hidden" class="form-control" id="hd_prontopago" name="hd_prontopago" value='{hd_prontopago}' />
				</div>
				<div class="col-sm-4" style='text-align:right;'>
					<div style='vertical-align:middle;' id='client_options'>{opciones_cliente}</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div  id='div_datos_academicos_estudiante' name='div_datos_academicos_estudiante' style='display:inline;'>
				<div class="col-sm-4">
					<input id="txt_curso" type="text" class="form-control" placeholder="Grado/Curso" disabled style="width:100%" />
				</div>
				<div class="col-sm-4">
					<input id="txt_grupo_economico" type="text" class="form-control" placeholder="Grupo económico" disabled style="width:100%" />
				</div>
				<div class="col-sm-4">
					<input id="txt_nivel_economico" type="text" class="form-control" placeholder="Nivel económico" disabled style="width:100%" />
				</div>
			</div>
		</div>
	</div>
</div>
				
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Formulario de Nota de crédito</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> NO REMOVER-->
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div >
			<div id="deudasPendientesAlumno">
				<!-- DEUDAS -->
				<div id="deudasnotacredito" class='panel panel-info'>
					<div class="panel-heading">
						<table style='width:100%'>
							<tr>
								<td style='text-align:left;'>
									Facturas emitidas
								</td>
								<td style='text-align:right;'>
								</td>
							</tr>
						</table>
					</div>
					<div class="panel-body">
						<div class="grid">
							<div class="row">
								<div class="col-sm-12">
									<div id="resultado" class="form-group"> 
										{tabla_deudasPendientes}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="datosOperacion" class='panel panel-info'>
					<div class="panel-heading">
						<table style='width:100%'>
							<tr>
								<td style='text-align:left;'>
									Nota de crédito
								</td>
								<td style='width:20%' style='text-align:right;'>
									<div class="input-group"><span class="input-group-addon"><b>Total:</b> $</span>
										<input type="text" disabled="true" readonly class="form-control" name="totalValoresNotaCredito" id="totalValoresNotaCredito" placeholder="00.00" required="required">
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="panel-body">
						<div role="tabpanel" id="tbOperacion">
						  <!-- Menu Name tabs -->
						  <ul class="nav nav-tabs" id="tabOperacion" role="tablist">
							<li role="presentation" class="active"><a href="#cabeceraNC" aria-controls="cabeceraNC" role="tab" data-toggle="tab">Información NC</a></li>
							<li role="presentation"><a href="#detalleFactura" aria-controls="detalleFactura" role="tab" data-toggle="tab">Detalle Factura</a></li>
							<li role="presentation"><a href="#detalleNC" aria-controls="detalleNC" role="tab" data-toggle="tab">Detalle NC</a></li>
						  </ul> 
						  <!-- Tab panes -->
						  <div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="cabeceraNC">
								<!-- =====> CABECERA DE LA FACTURA Y/O NOTA DE CRÉDITO <===== -->
								<div class="form-group">
								  <div class="col-md-4">
									<input style="width:100%"  type="text" maxlength="15" class="form-control" id="tipoIdentificacionTitular" name="tipoIdentificacionTitular" placeholder="Tipo Id" readonly="readonly" />
								  </div>
								  <div class="col-md-8">
									<input style="width:100%"  type="text" maxlength="15" onkeypress="return validaNumerosEnteros(event, this);" class="form-control" id="numeroIdentificacionTitular" name="numeroIdentificacionTitular" placeholder="Numero Id" readonly="readonly" />
								  </div>
								  <div class="col-md-12">
									<input style="width:100%" type="text" maxlength="50" class="form-control" id="nombreTitular" name="nombreTitular" placeholder="Nombres" readonly="readonly" />
								  </div>
								  <div class="col-md-8">
									<input style="width:100%" type="email" maxlength="50" class="form-control" id="emailTitular" name="emailTitular" placeholder="email" readonly="readonly" />  
								  </div>
								  <div class="col-md-4">
									<input style="width:100%" type="text" maxlength="10" onkeypress="return validaNumerosEnteros(event, this);" class="form-control" id="telefonoTitular" name="telefonoTitular" placeholder="Tel." readonly="readonly" />  
								  </div>
								  <div class="col-md-12">
									<input style="width:100%" type="text" maxlength="100" class="form-control" id="direccionTitular" name="direccionTitular" placeholder="Direccion" readonly="readonly" />
								  </div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="detalleFactura">
								<!-- =====> RESUMEN DE LA CABECERA DE LA FACTURA <===== -->
								<div id="" class="row form-group">
								  <div class="col-md-2">
									<label for="numeroFactura"><h5>N° Factura</h5></label>
									<div class="input-group">
									  <span class="input-group-addon" id="prefijoSucursal">{prefijoSucursal}</span>
									  <span class="input-group-addon" id="prefijoPuntoVenta">{prefijoPuntoVenta}</span>
									  <input type="text" readonly class="form-control input-sm" id="numeroFactura" name="numeroFactura" value="" placeholder="0000" />
									</div>
								  </div>  

								  <div class="col-md-2 col-md-offset-0">
									<label for="codigoFactura"><h5># Factura</h5></label>
									  <input type="text" readonly class="form-control input-sm" id="codigoFactura" name="codigoFactura" placeholder="0000" />
								  </div> 

								  <div class="col-md-2 col-md-offset-0">
									<label for="totalNetoFactura"><h5>Total Factura</h5></label>
									<div class="input-group">
									  <span class="input-group-addon">$</span>
									  <input type="text" readonly class="form-control input-sm" id="totalNetoFactura" name="totalNetoFactura" placeholder="00.00" />
									  
									</div>
									 
								  </div> 
								  
								  <div class="col-md-2 col-md-offset-0">
									<label for="totalSinImpFactura"><h5>Total Fact Sin Imp.</h5></label>
									<div class="input-group">
									  <span class="input-group-addon">$</span>
									  <input type="text" readonly class="form-control input-sm" id="totalSinImpFactura" name="totalSinImpFactura" placeholder="00.00" />
									  
									</div>
									 
								  </div>                      
								  

								   <div class="col-md-2 col-md-offset-0">
									<label for="totalAbonoFactura"><h5>Total Abono</h5></label>
									<div class="input-group">
									  <span class="input-group-addon">$</span>
									  <input type="text" readonly class="form-control input-sm" id="totalAbonoFactura" name="totalAbonoFactura" placeholder="00.00" />
									</div>
								  </div>  

								  <div class="col-md-2 col-md-offset-0">
									<label for="totalNotaCreditoFactura"><h5>Total N/C</h5></label>
									<div class="input-group">
									  <span class="input-group-addon">$</span>
									  <input type="text" readonly class="form-control input-sm" id="totalNotaCreditoFactura" name="totalNotaCreditoFactura" placeholder="00.00" />
									</div>
								  </div>  
								   
								</div>
								<!-- DETALLE DE LA FACTURA -->
								<div id="resultadoDetalleFactura" class="form-group"> 
									{tabla_detalleFactura}
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="detalleNC">
								<!-- =====> DETALLE DE LA NOTA DE CREDITO <===== -->
								<div id="resultadoDetalleNotaCredito" class="form-group"> 
									 {tabla_detalleNotaCredito}
								</div>
							</div>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
	<div class="box-footer">
		<div id="cobro_opciones" class="btn-group pull-right">
			<button type="button" class="btn btn-default btn-md" onclick="limpiaPagina('true')" ><span class='fa fa-eraser'></span> Limpiar todo</button>
			<button type="button" class="btn btn-primary btn-md" aria-hidden="true" data-toggle="modal" data-target="#modal_resultadoNC"  
				onclick="generaNotaCredito('modal_resultadoNC_body','{ruta_html_finan}/notaCredito/controller.php')" {disabled_confirmar_nota_credito}>
					<span class='glyphicon glyphicon-record'></span>  Confirmar Nota de crédito</button>
		</div>
	</div>
</div>
<!-- DEUDAS CLIENTE -->