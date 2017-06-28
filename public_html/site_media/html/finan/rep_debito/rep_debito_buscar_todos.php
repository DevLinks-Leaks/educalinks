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
				<div class='col-md-6 col-sm-12'>
					<div class='row'>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Per&iacute;odo:</label>
								<div class="col-md-8 col-sm-8">
									{combo_periodo}
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nivel econ.:</label>
								<div class="col-md-8 col-sm-8">
									<div id="resultadoNivelEcon">
										{combo_nivel}
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Curso:</label>
								<div class="col-md-8 col-sm-8">
									<div id="resultadoCursos">
										{combo_cursos}
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-12 col-sm-12'>
							<div class='form-group'>
								<label class="col-md-4 col-sm-3 control-label" for="rdb_quienes" style='text-align: right;'>Mostrar:</label>
								<div class="col-md-8 col-sm-8">
									<div id="resultadoCursos" class='checkbox'>							
										<input type="radio" id="rdb_quienes" name="rdb_quienes" value="1" checked='checked'> Sólo personas con información de bancos/tarjetas<br>
										<input type="radio" id="rdb_quienes" name="rdb_quienes" value="2" > Sólo personas sin información de bancos/tarjetas<br>
										<input type="radio" id="rdb_quienes" name="rdb_quienes" value="3" > Todos
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6 col-sm-12' style='text-align:center;'>
					<button 
				type="button"
				class="btn btn-default"
				onclick="js_rep_debito_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/Rep_debito/controller.php','print_deudores_xls')">
					<span style="color:green;" class="fa fa-file-excel-o"></span>&nbsp;</button>
				</div>
			</div>
		</div>
	</div>
</form>