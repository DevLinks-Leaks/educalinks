<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reportes de facturas emitidas</h4>
			</div>
			<div class="modal-body" id="modal_edit_body" >
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
    </div>
</div>
<!-- Modal Editar-->
<form id="file_form" action="{ruta_html_finan}/rep_facturas/controller.php" enctype="multipart/form-data" method="POST" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="completo"/>
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
									{combo_cajas}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-5 col-sm-12' style='text-align:center;'>
					<button type="button" class='btn btn-default' id='btn_selectFem_excel' name='btn_selectFem_excel' 
						onclick="js_rep_facturas_excel('print_excel','completo');"><span style='color:green;' class='fa fa-file-excel-o'></span></button>
					<button type="button" 
						class="btn btn-default" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
						onclick=" js_rep_facturas_carga_reports_descuentos('modal_edit_body','{ruta_html_finan}/rep_facturas/controller.php','print_cierres')">
						<span style='color:red;' class="fa fa-file-pdf-o"></span></button>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- SELECT2 EXAMPLE -->
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Reporte de facturas</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> NO REMOVER-->
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="formulario">
		</div>
	</div>
</div>