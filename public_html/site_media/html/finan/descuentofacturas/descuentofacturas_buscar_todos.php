<!-- Modal Visor Estado de cuenta-->
<div class="modal fade bs-example-modal-lg" id="modal_showDebtState" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Estado de cuenta</h4>
			</div>
			<div class="modal-body" id="modal_showDebtState_body">
			...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal" 
						onclick="print_pdf('{ruta_html_finan}/clientes/controller.php')"><span class='glyphicon glyphicon-print'></span>&nbsp;Imprimir</button>
				<!--<a href="/reporte/estadoCuenta/{codigoAlumno}/{periodo}/{fechaInicio}/{fechaFin}" class="btn btn-primary" role="button" >Imprimir</a>-->
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Visor Estado de cuenta-->
<!-- Modal Asignar-->
<div class="modal fade" id="modal_asign_descuentofactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asignar Descuento</h4>
      </div>
      <div class="modal-body" id="modal_asign_body_descuentofactura">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" 
			onclick="js_descuentofactura_save_asign('resultado','{ruta_html_finan}/descuentofacturas/controller.php')">
				<li class='fa fa-save'></li>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!--/. Modal Asignar-->
<!-- Modal Buscar cliente -->
<div class="modal fade" id="modal_busquedaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Busqueda de cliente</h4>
      </div>
      <div class="modal-body" id="modal_busquedaCliente_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="js_descuentofactura_selecciona('{ruta_html_finan}/descuentofacturas/controller.php')">Seleccionar</button>
      </div>
    </div>
  </div>
</div>
<!--/. Modal Buscar cliente -->
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
<!--/. Modal Asignar-->
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
<!--/. Modal Asignar Grupo Economico-->
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
<!--/. Modal Asignar representante-->
<!-- DEUDAS CLIENTE -->
<div id="div_modal_seleccionar_persona_lista" name="div_modal_seleccionar_persona_lista"></div>
<div id="deudasPendientesCliente">
  <!-- CLIENTE -->
  <div class='panel panel-info'>
		<div class="panel-heading">
			<table style='width:100%'>
				<tr>
					<td style='text-align:left;'>
						Cliente
						<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
							<a href='#' onmouseover='$(this).tooltip("show")' title="Para hacer descuento a una deuda, haga click a 'Buscar' para empezar por buscando un cliente." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
						</div>
						<div id='EducaLinksHelperCliente2' class='EducalinksHelper' style='display:none;font-size:small;text-align:left;vertical-align:middle;'>
							¿No est&aacute; seguro de haber cobrado una deuda correctamente? <a href='#' onmouseover='$(this).tooltip("show")' title="Si no est&aacute; seguro(a) de haber realizado un pago correctamente, puede verificar seleccionando desde el men&uacute; la opci&oacute;n de Ver/Pagos." data-placement='right'><span class='glyphicon glyphicon-info-sign'></span></a>
						</div>
					</td>
					<td style='text-align:right;'>
						<!--<button id="btnBuscarCliente" type="button" 
								class="btn btn-info btn-md" aria-hidden="true" data-toggle="modal" data-target="#modal_busquedaCliente" 
								onclick="js_descuentofactura_carga_busquedaCliente('modal_busquedaCliente_body','{ruta_html_finan}/cobros/controller.php')" {disabled_caja} >
							<span class='glyphicon glyphicon-search'></span>&nbsp;Buscar</button>-->
						<button class="btn btn-info btn-md" 
								onclick="js_persona_select_user_searchlist_2('span_button_save_person', 'div_modal_seleccionar_persona_lista', '','js_descuentofactura_selecciona')">
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
	</div>
  <!-- DEUDAS -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">
				Descuentos pendientes
			</h3>
		</div>
		<div class="box-body">
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
		<div class="box-footer">
			<div class="grid">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-8">
						<div class="input-group" >
							<span class="input-group-addon"><strong>T. Deudas: </strong>$</span>
							<input type="text" disabled="true" class="form-control" name="totalDeudasPendientes" id="totalDeudasPendientes" placeholder="00.00" required="required">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>