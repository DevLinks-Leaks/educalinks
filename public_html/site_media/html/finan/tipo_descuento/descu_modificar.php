<div id="frm_modificacionItem" class="form-medium" > 
    <div class="form-group">
    	<input type="hidden" class="form-control" name="codigo_mod" id="codigo_mod" value="{desc_codigo}" required="required">
    	<label for="descripcion_mod">Descripci&oacute;n</label>
        <input type="text" class="form-control" name="descripcion_mod" id="descripcion_mod" placeholder="Descripción del Descuento" value="{desc_descripcion}" required="required">
    </div>
    <div class="form-group"> 
    	<label for="porcentaje_mod">Porcentaje</label>
        <div class="input-group">
          <input type="text" class="form-control" name="porcentaje_mod" id="porcentaje_mod" placeholder="Porcentaje del Descuento" value="{desc_porcentaje}" required="required" aria-describedby="basic-addon2">
          <span class="input-group-addon" id="basic-addon2">%</span>
        </div>
    </div>
	<div class="form-group" style="display:none;">
    	<label for="porcentaje_add">Tipo de descuento
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
				<a tabindex="0" data-toggle="popover" data-placement='right' title="Tipo de descuento" data-content="<div style='font-size:x-small'>Una vez creado el descuento, el tipo de descuento no se puede modificar. Por favor, elimínelo y créelo nuevamente.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
			</div>
		</label>
        <select id='cmb_tipo_descuento' name='cmb_tipo_descuento' class='form-control' disabled='disabled' >
			<option value='0' {tipo0}>Descuento del sistema</option>
			<option value='1' {tipo1}>Descuento para Convenio de pago</option>
		</select>
    </div>
    <div class="form-group">
    	<label for="aplicaprontopago_mod" class="checkbox-inline">
    		<input type="checkbox" id="aplicaprontopago_mod" name="aplicaprontopago_mod" {desc_aplicaprontopago}/>	
            Aplica Prontopago
    	</label>
	</div>
</div>