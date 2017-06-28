<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reporte de Saldos a favor</h4>
			</div>
			<div class="modal-body" id="modal_edit_body">
			 ...
			 </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
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
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nivel Econ&oacute;mico:</label>
							<div class="col-md-8 col-sm-8">
								<div id="comboNIvelesEconomicos">
								   {combo_nivel}
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
				</div>
			</div>
			<div class='col-md-5 col-sm-12' style='text-align:center;'>
				<button type="button" 
					class="btn btn-primary" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
					onclick="js_rep_saldoafavor_reporte('modal_edit_body','{ruta_html_finan}/rep_saldosafavor/controller.php','print_saldosafavor')">
					<span class="fa fa-print"></span>&nbsp;PDF</button>
			</div>
		</div>
	</div>
</div>
<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">
			<a class="btn btn-info" href='../../finan/saldoaFavor/'>
				<span class="fa fa-balance-scale"></span>&nbsp;Ir a Saldos a favor</a>
		</h3>
		<div class="box-tools pull-right">
			<!--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
		</div>
	</div>
	<div class="box-body">
		
	</div>
</div>