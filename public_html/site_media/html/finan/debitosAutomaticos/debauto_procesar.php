<br>
<div id="procesar" class="form-small" style='align:center;'>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-4'>
				<button type="button" class="btn btn-warning" onclick="js_debitosAutomaticos_genera_file_ajax();"><li class="fa fa-chevron-left"></li> Volver</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-4'>
				<hr>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				{txt_mensaje}
			</div>
		</div>
	</div>
	<div id='div_muestra_si_archivo_ok' name='div_muestra_si_archivo_ok' {display_muestra_archivo_ok}>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<input type="hidden" name="event" id="evento" value="subir_archivo" />
				<label for="fecha_debito" class='control-label'>Fecha del débito</label>
			</div>
			<div class='col-sm-3'>
				<input type="text" class="form-control" name="fecha_debito" id="fecha_debito" value="{txt_fecha_debito}" readonly='readonly' />
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="combo_codigodeuda" class='control-label'>Campo C&oacute;digo Deuda</label>
			</div>
			<div class='col-sm-3'>
				{combo_codigodeuda}
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="combo_valor" class='control-label'>Campo Valor</label>
			</div>
			<div class='col-sm-3'>
				{combo_valor}
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="combo_estado" class='control-label'>Campo de Estado (indica si dueda fue procesada)</label>
			</div>
			<div class='col-sm-3'>
				{combo_estado}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				<hr>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<input type="hidden" name="event" id="evento" value="subir_archivo" />
				<label for="textook" class='control-label'>Texto Confirmaci&oacute;n</label>
			</div>
			<div class='col-sm-3'>
				<input type="text" class="form-control" name="textook" id="textook" placeholder="Texto de confirmación" />
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				<input type='checkbox' id='ckb_procesa_reprobados' name='ckb_procesa_reprobados' onclick='js_debitosAutomaticos_procesa_reprobados(this)'/>
				&nbsp;<span style="font-size:small;">Marcar como con cuenta sin liquidez a los clientes que tengan la transacción reprobada.
					<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
						<a tabindex="0" data-toggle="popover" 
							title="Clientes con cuentas sin liquidez"
							data-content="<div style='font-size:x-small'>Los clientes pasarán a la lista histórica de clientes sin liquidez.
							<br>
							<br>
							Aparecerá un mensaje notificando que tiene una cuenta de liquidez la próxima vez que se intente exportar el archivo de débito.</div>"
							data-placement='top'><span class='fa fa-info-circle'></span></a>
					</div>
				</span>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<input type="hidden" name="event" id="evento" value="subir_archivo" />
				<label for="textonook" class='control-label'>Texto de reprobación</label>
			</div>
			<div class='col-sm-3'>
				<input type="text" class="form-control" name="textonook" id="textonook" disabled='disabled' placeholder="Texto de reprobación" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				<hr>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-3'>
				<label for="textook" class='control-label'>Forma de pago</label>
			</div>
			<div class='col-sm-3'>
				<select class='form-control' id='cmb_formaPago' name='cmb_formaPago'>
					<option value="8" selected='selected'>- Débito bancario -</option>
					<option value="10">- Convenio de pago -</option>
					<option value="11">- Pago por ventanilla del banco -</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6'>
				<br>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" >
			<div class='col-sm-6' style='text-align:center;'>
				<button class="btn btn-primary" type="button"
					id='btn_procesar_carga_xls' name='btn_procesar_carga_xls'
					onclick="procesar_Archivo('procesar','{ruta_html_finan}/debitosAutomaticos/controller.php');">Procesar</button>
			</div>
		</div>
	</div>
</div>
