<!-- Modal Msg-->
<div class="modal fade" id="modal_msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Educalinks</h4>
			</div>
			<div class="modal-body" id='modal_msg_body'>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Msg-->
<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reporte de mediación</h4>
			</div>
			<div class="modal-body" id="modal_edit_body" >
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<form id="file_form" action="{ruta_html_finan}/rep_ctasporcobrar/controller.php" enctype="multipart/form-data" method="post" target="_blank">
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
									<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:text-bottom;'>
										<a href='#' onmouseover='$(this).tooltip("show")' 
										title="Esta selección es para filtrar deudas generadas en un rango de fecha específico" data-placement='top'><span class='glyphicon glyphicon-info-sign'></span></a>
									</div>
									F. emisión inicio:
								</label>
								<div class="col-md-7 col-sm-7">
									<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
													value="" placeholder="dd/mm/yyyy" disabled='disabled'>
								</div>
								<div class="col-md-1 col-sm-1" style='text-align: right;' style='width:20px; position:relative; left: 200px; vertical-align:middle;'>
									<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='js_rep_mediacion_check_fecha();'>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class="form-group">
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;'>F. emisión fin:</label>
								<div class="col-md-7 col-sm-7">
									<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
													value="" placeholder="dd/mm/yyyy" disabled='disabled'>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Per&iacute;odo:</label>
								<div class="col-md-7 col-sm-7">
									{combo_periodo}
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nivel econ.:</label>
								<div class="col-md-7 col-sm-7">
									<div id="resultadoNivelEcon">
										{combo_nivel}
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Curso:</label>
								<div class="col-md-7 col-sm-7">
									<div id="resultadoCursos">
										{combo_cursos}
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Producto:</label>
								<div class="col-md-7 col-sm-7">
									{cmb_producto}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-5 col-sm-12' style='text-align:center;'>
					<!--<button
					type="button"
					class="btn btn-default"
					onclick="js_rep_mediacion_get_config( );"
					aria-hidden='true' data-toggle='modal' data-target='#modal_configSaf'>
					&nbsp;<span class='fa fa-cog'></span>&nbsp;</button>-->
					<button 
						type="button"
						class="btn btn-default"
						onclick="js_rep_mediacion_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/rep_mediacion/controller.php','print_deudores_xls')">
							<span style="color:green;" class="fa fa-file-excel-o"></span>&nbsp;</button>
				</div>
			</div>
		</div>
	</div>
	<div class="box box-default">
		<div class="box-header with-border">
			<div class="pull-right">
				<a class="btn btn-default" href='../../finan/cobranza/'>
					<span class="fa fa-phone-square"></span>&nbsp;CRM Cobranza</a>
			</div>
		</div>
		<div class="box-body">
		</div>
	</div>
</form>