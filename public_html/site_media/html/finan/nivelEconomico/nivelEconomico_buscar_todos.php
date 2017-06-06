<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Nivel Económico</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" 
		onclick="save_edited(document.getElementById('codigo_mod').value,'resultado','{ruta_html_finan}/nivelEconomico/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<!-- Modal Agregar-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Nivel Económico</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="add('resultado','{ruta_html_finan}/nivelEconomico/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<div class="form-horizontal">
	<div class="form-group">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Config. Nivel económico</h3>
					<div class="box-tools">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body no-padding">
					<ul class="nav nav-pills nav-stacked">
						<li id="nav_aniosPeriodo_1" class="active"><a href="../../finan/nivelEconomico/">1. Crear nivel económico
						<li id="nav_aniosPeriodo_2"><a  href="../../finan/nivelEconomicoCursos/">2. Agrupar cursos por nivel económico</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">
						<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
							onclick="carga_add('modal_add_body','{ruta_html_finan}/nivelEconomico/controller.php')" {disabled_agregar_nivel_economico}>
							<i class='fa fa-diamond'></i></span>&nbsp;<i class='fa fa-plus'></i></button>
					</h3>
				</div>
				<div class="box-body">
					<div id="resultado">
						{tabla}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>