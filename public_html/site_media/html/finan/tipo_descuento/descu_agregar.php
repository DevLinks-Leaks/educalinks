<div id="frm_ingresoItem" class="form-medium" >
    <div class="form-group">
    	<label for="descripcion_add">Descripci&oacute;n</label>
        <input type="text" class="form-control" name="descripcion_add" id="descripcion_add" placeholder="Descripción del Descuento" required="required">
    </div>
    <div class="form-group"> 
    	<label for="porcentaje_add">Porcentaje</label>
        <div class="input-group">
          <input type="text" class="form-control" name="porcentaje_add" id="porcentaje_add" placeholder="Porcentaje del Descuento" required="required" aria-describedby="basic-addon2">
          <span class="input-group-addon" id="basic-addon2">%</span>
        </div>
    </div>
	<div class="form-group" style="display:none;"> 
    	<label for="porcentaje_add">Tipo de descuento
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
				<a tabindex="0" data-toggle="popover" data-placement='right' title="Tipo de descuento" data-content="<div style='font-size:x-small'>Una vez creado el descuento, el tipo de descuento no se puede modificar.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
			</div>
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
				<a tabindex="0" data-toggle="popover" data-placement='right' title="¿Qué es tipo de descuento?" data-content="<div style='font-size:x-small'><b>Descuentos del sistema:</b> Utilizado para asignar descuentos a los alumnos.
					<br>
					<br>
					<b>Convenio de pago:</b> sirve para crear los descuentos que se vayan a usar para Convenio de pago (prepago).</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
			</div>
		</label>
        <select id='cmb_tipo_descuento' name='cmb_tipo_descuento' class='form-control' onchange="js_descuento_cmb_tipo_descuento_change();">
			<option value='0' selected='selected'>Descuento del sistema</option>
			<option value='1'>Descuento para Convenio de pago</option>
		</select>
    </div>
    <div class="form-group"> 
    	<label for="aplicaprontopago_add" class="checkbox-inline">
    		<input type="checkbox" id="aplicaprontopago_add" name="aplicaprontopago_add" />	
            Aplica Prontopago
    	</label>
	</div>
</div>