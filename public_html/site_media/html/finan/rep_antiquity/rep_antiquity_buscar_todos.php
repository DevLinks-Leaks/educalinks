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
				<h4 class="modal-title" id="myModalLabel">Reporte de antigüedad de saldos</h4>
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
<form id="file_form" action="{ruta_html_finan}/rep_antiquity/controller.php" enctype="multipart/form-data" method="post" target="_blank">
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
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right; '>
									Fecha de corte:
								</label>
								<div class="col-md-7 col-sm-8">
									<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
													value="" placeholder="dd/mm/yyyy" disabled='disabled'>
								</div>
								<div class="col-md-1 col-sm-1" style='text-align: right;'>
									<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='js_rep_antiquity_check_fecha();'>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Per&iacute;odo:</label>
								<div class="col-md-7 col-sm-8">
									{combo_periodo}
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Per&iacute;odo:</label>
								<div class="col-md-7 col-sm-8">
									{combo_periodo}
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nivel econ.:</label>
								<div class="col-md-7 col-sm-8">
									<div id="resultadoNivelEcon">
										{combo_nivel}
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Curso:</label>
								<div class="col-md-7 col-sm-8">
									<div id="resultadoCursos">
										{combo_cursos}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-5 col-sm-12' style='text-align:center;'>
					<!--<button 
						type="button"
						class="btn btn-primary"
						onclick="js_rep_antiquity_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/rep_antiquity/controller.php','print_deudores_html')">
							<span class="fa fa-search"></span></button>-->
					<button 
						type="button"
						class="btn btn-default"
						onclick="js_rep_antiquity_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/rep_antiquity/controller.php','print_deudores')">
							<span style="color:red;" class="fa fa-file-pdf-o"></span></button>
					<button 
						type="button"
						class="btn btn-default"
						onclick="js_rep_antiquity_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/rep_antiquity/controller.php','print_deudores_xls')">
							<span style="color:green;" class="fa fa-file-excel-o"></span></button>
				</div>
			</div>
		</div>
	</div>
						
	<div class="box box-default">
		<div class="box-body">
			<div class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-md-12 col-sm-12">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<!--<div class="box box-default">
	<div class="box-header with-border">
	    <h3 class="box-title">Consulta</h3>
	</div>
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>-->