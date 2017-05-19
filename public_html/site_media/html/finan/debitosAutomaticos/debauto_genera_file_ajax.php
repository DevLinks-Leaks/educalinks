<br/>
<div class="grid">
</div>
<div id="procesar" name="procesar" class="{grid">
	<input type='hidden' id='hd_caja_abierta' name='hd_caja_abierta' value='{hd_caja_abierta}'></input>
	<div class="row">
		<div class='col-sm-12'>
			<div class="alert alert-default" role="alert">
				<p><span class="fa fa-upload" aria-hidden="true"></span>
					Subida de archivo de respuesta del banco
					<hr style="padding:3px;margin:0px;">
					Cargue el archivo recibido del banco/instituci&oacute;n financiera. El archivo debe tener la siguiente informaci&oacute;n:
				<ul>
					<li><b><i>C&oacute;digo de deuda</i></b></li>
					<li><b><i>Valor de pago</i></b></li>
					<li><b><i>Estado del proceso en el banco</i></b></li>
				</ul>
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<br>
		<div class='col-sm-3' style='text-align:left;'>
			<div id='div_fecha_debito' name='div_fecha_debito' class='input-group'>
				<span id='span_ig_filainicia' name='span_ig_filainicia' class="input-group-addon"><small>Fecha de débito</small></span>
				<input class="form-control" name="txt_fecha_debito" id="txt_fecha_debito"
						data-placement="top"
						title='Fecha en la que el banco procesó el débito.'
						onfocus='$(this).tooltip("show")'
						onmouseover='$(this).tooltip("show")'
						type="text" required="required">
				<div class="help-block with-errors"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<br>
		<div class='col-sm-3'  style='text-align:left;'>
			<div id='div_ig_filainicia' name='div_ig_filainicia' class='input-group'>
				<span id='span_ig_filainicia' name='span_ig_filainicia' class="input-group-addon"><small>Cabecera inicia en fila</small></span>
				<input class="form-control" name="filainicia" id="filainicia"
						data-placement="top"
						title='Escriba el no. de la fila donde se encuentra la cabecera de datos.'
						onfocus='$(this).tooltip("show")'
						onmouseover='$(this).tooltip("show")'
						type="number" min="0" step="1" max="999999999"
						placeholder="0" required="required">
				<div class="help-block with-errors"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class='col-sm-3' style='text-align:right;'>
			<br>
		</div>
	</div>
	<div class="row">
		<div class='col-sm-3' style='text-align:left;'>
			<input type="file" name="fileToUpload" id="fileToUpload" required="required">
		</div>
	</div>
	<div class="row">
		<div class='col-sm-12'>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class='col-sm-7'>
			<div class='col-sm-7' style='display:inline;'>
					<button id='btn_formato_nuevo_generar' name='btn_formato_nuevo_generar' 
							class="btn btn-success btn-flat" type="button"
							onclick="js_debtAuto_subirarchivo();"
							data-placement="right"
							title='Importar archivo de respuesta del banco al sistema.'
							onfocus='$(this).tooltip("show")'
							onmouseover='$(this).tooltip("show")'><span class='fa fa-upload'></span> Importar archivo
					</button>
			</div>
		</div>
		<div class='col-sm-5' style='text-align:right;'>
			<div id='div_maint_file_status' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'></div><span id='span_info_formato' name='span_info_formato' style='font-size:x-small;'></span>
		</div>
	</div>
</div>