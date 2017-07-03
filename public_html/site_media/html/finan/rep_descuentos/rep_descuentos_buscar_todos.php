<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reporte de Descuentos Otorgados</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
       
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
	<div class="panel-heading">
		<h3 class="panel-title">
			<a href="#/" class="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
			<div class="pull-right">
				<a href="#/" class="boton_busqueda" style='text-decoration:none;'><span class='fa fa-minus'></span></a>
			</div>
		</h3>
	</div>
	<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
		<div class="form-horizontal" role="form">
			<div class='col-md-7 col-sm-12'>
				<div class='row'>
					<div class='col-md-12 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Per&iacute;odo:</label>
							<div class="col-md-8 col-sm-8">
								<div id="comboPeriodo">
								   {combo_periodo}
								</div>
							</div>
						</div>
					</div>
					<div class='col-md-12 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Cursos:</label>
							<div class="col-md-8 col-sm-8">
								<div id="comboCursos">
								   {combo_curso}
								</div>
							</div>
						</div>
					</div>
					<div class='col-md-12 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Tipo de descuento:</label>
							<div class="col-md-8 col-sm-8">
								<div id="div_comboTipoDescuento">
									{combo_tipo_descuento}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='col-md-5 col-sm-12' style='text-align:center;'>
				<button type="button" 
						class="btn btn-primary" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
						onclick=" carga_reports_descuentos('modal_edit_body','{ruta_html_finan}/rep_descuentos/controller.php','print_descuentos')">
						<span class="fa fa-print"></span></button>
			</div>
		</div>
	</div>
</div>