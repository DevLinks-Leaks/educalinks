<!-- Modal para mostrar el resultado del pago -->
<div class="modal fade" id="modal_resultadoPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id='modal_resultadoPago_header'>
				<h4 class="modal-title" id="myModalLabel">Educalinks informa</h4>
			</div>
			<div class="modal-body" id="modal_resultadoPago_body">
				...
			</div>
			<div class="modal-footer"  id='modal_resultadoPago_foot'>
				<button type="button" id='btn_modal_resultadoPago_close' name='btn_modal_resultadoPago_close' class="btn btn-default" data-dismiss="modal">Entiendo</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal para mostrar el resultado del pago -->
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-clipboard"></i> Deudas pendientes</a></li>
		<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-list"></i> Deudas pagadas</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1">
			{deudas_pdtes}
		</div>
		<div class="tab-pane" id="tab_2">
			{deudas_pasadas}
		</div>
	</div>
</div>