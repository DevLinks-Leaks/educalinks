<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reporte de Notas de Cr&eacute;dito</h4>
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
						<div class="form-group">
							<label class="col-md-4 col-sm-3 control-label"
								style='text-align: right; '>
								F. emisi&oacute;n inicio:
							</label>
							<div class="col-md-7 col-sm-7">
								<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
												value="{txt_fecha_ini}" placeholder="dd/mm/yyyy">
							</div>
							<div class="col-md-1 col-sm-1" style='text-align: right;'>
								<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();' checked>
							</div>
						</div>
					</div>
					<div class='col-md-12 col-sm-12'>
						<div class="form-group">
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;'>F. emisi&oacute;n fin:</label>
							<div class="col-md-7 col-sm-7">
								<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
												value="{txt_fecha_fin}" placeholder="dd/mm/yyyy">
							</div>
						</div>
					</div>
					
					<div class='col-md-12 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Cajero:</label>
							<div class="col-md-7 col-sm-7">
								{combo_cajero}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='col-md-5 col-sm-12' style='text-align:center;'>
				<button type="button" 
					class="btn btn-primary" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
					onclick=" carga_reports_notaCredito('modal_edit_body','{ruta_html_finan}/rep_notaCredito/controller.php','print_rep_notaCredito')" >
					<span class="fa fa-print"></span>&nbsp;</button>
			</div>
		</div>
	</div>
</div>