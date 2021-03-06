function check_repr_finan(check){
	$('.check_finan').prop('checked',false);
	$(check).prop('checked',true);
}
function CargarBancosTarjetas (codigo)
{   var xmlhttp;
    if (window.XMLHttpRequest)
    {   xmlhttp = new XMLHttpRequest ();
    }
    else
    {   xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xmlhttp.onreadystatechange = function ()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   
            if(xmlhttp.responseText==''){
                $('#alum_cuen_banc_tarj').attr('disabled','disabled');
                document.getElementById('alum_cuen_banc_tarj').innerHTML='<option value="0">SELECCIONE</option>';
            }
            else{
                $('#alum_cuen_banc_tarj').attr('disabled',false);
                document.getElementById('alum_cuen_banc_tarj').innerHTML=xmlhttp.responseText;
                // $('#alum_cuen_banc_tarj').select2({
                //     placeholder: "SELECCIONE",
                //     allowClear: true,
                //     language: "es"
                // });
            }
        }
    }
    xmlhttp.open("GET", "select_banco_tarjeta.php?idpadre="+codigo, true);
    xmlhttp.send();
}
function mostrar_tarjeta(value){
    if (value==23)
        $('#div_tarjeta').collapse(200).collapse('show');
    else
        $('#div_tarjeta').collapse('hide');
}
function CargarProvincias(id,value)
{	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	xmlhttp = new XMLHttpRequest ();
	}
	else
	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "select_provincia.php?codigo="+value, true);
	xmlhttp.send();
}
function CargarCiudades(id,value)
{	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	xmlhttp = new XMLHttpRequest ();
	}
	else
	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "select_ciudad.php?codigo="+value, true);
	xmlhttp.send();
}
function CargarParroquias(id,value)
{	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	xmlhttp = new XMLHttpRequest ();
	}
	else
	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "select_parroquia.php?codigo="+value, true);
	xmlhttp.send();
}
function load_modal_preinscripcion_view(div,url,data){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;
			$("#repr_fech_promoc").datepicker();
			$("#repr_fech_naci").datepicker();
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function actualizar_representante(repr_codi)
{	
	if(comprobarObligatoriosRepre()){
		$('#btn_guardar_repr').button('loading');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		data.append('opc', 'repr_upd');
		data.append('repr_codi', repr_codi);
		data.append('repr_nomb', document.getElementById('repr_nomb').value);
		data.append('repr_apel', document.getElementById('repr_apel').value);
		data.append('repr_email', document.getElementById('repr_email').value);
		data.append('repr_telf', document.getElementById('repr_telf').value);
		data.append('repr_celular', document.getElementById('repr_celular').value);
		data.append('repr_domi', document.getElementById('repr_domi').value);
		data.append('repr_celular', document.getElementById('repr_celular').value);
		data.append('repr_profesion', document.getElementById('repr_profesion').value);
		data.append('repr_nacionalidad', document.getElementById('repr_nacionalidad').value);
		data.append('repr_lugar_trabajo', document.getElementById('repr_lugar_trabajo').value);
		data.append('repr_direc_trabajo', document.getElementById('repr_direc_trabajo').value);
		data.append('repr_telf_trab', document.getElementById('repr_telf_trab').value);
		data.append('repr_cargo', document.getElementById('repr_cargo').value);
		data.append('repr_religion', $('#idreligion').val());
		data.append('repr_estudios', document.getElementById('repr_estudios').value);
		data.append('repr_institucion', document.getElementById('repr_institucion').value);
		data.append('repr_motivo_representa', document.getElementById('repr_motivo_representa').value);
		data.append('repr_estado_civil', $('#idestadocivil').val());
		data.append('repr_escolaborador',$('#repr_escolaborador').prop('checked'));
		data.append('repr_fech_promoc', document.getElementById('repr_fech_promoc').value);
		data.append('repr_ex_alum',$('#repr_ex_alum').prop('checked') );
		data.append('repr_fech_naci', $('#repr_fech_naci').val());
		data.append('repr_pais_naci', ($('#repr_pais_naci').val()=='' ? '' : $('#repr_pais_naci option:selected').text()));
		data.append('repr_prov_naci', ($('#repr_prov_naci').val()=='' ? '' : $('#repr_prov_naci option:selected').text()));
		data.append('repr_ciud_naci', ($('#repr_ciud_naci').val()=='' ? '' : $('#repr_ciud_naci option:selected').text()));
		data.append('identificacion_niv_1', ($('#identificacion_niv_1').val() > 0 ? $('#identificacion_niv_1').val() : ''));
        data.append('identificacion_niv_2', ($('#identificacion_niv_2').val() > 0 ? $('#identificacion_niv_2').val() : '') );
        data.append('identificacion_niv_3', ($('#identificacion_niv_3').val() > 0 ? $('#identificacion_niv_3').val() : '') );

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Educalinks informa:",message: json.result });
					$('#btn_guardar_repr').button('reset');
					$('#modal_preinscripcion').modal('hide');
					
				}else{
					$.growl.error({ title: "Educalinks informa:",message: json.result });
					console.log(json.console);
					$('#btn_guardar_repr').button('reset');
					
				}
			}
		}
		xmlhttp.open("POST","script_preinscripcion.php",true);
		// xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function load_cuentas(div,url,data){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(div).innerHTML=xmlhttp.responseText;
            $.extend(
                $.fn.dataTable.RowReorder.defaults,
                { selector: '.roworder' }
            );  
            $('#tbl_metodo_pago').DataTable({
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "bSort": false ,
                rowReorder: true,
                "info": false,
                // "ordering": false,
                "searching":false,
                "lengthChange":false,
                "paging":false
            });
        }
    }
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data); 
}
function cuenta_add(url,alum_codi){
    if(ValidarCuenta()){
        $('#btn_guardar_cuen').button('loading');
        //document.getElementById(div).innerHTML='';
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        $alum_cuen_codi = document.getElementById('alum_cuen_codi').value;
        var data = new FormData();
        data.append('opc', 'alum_cuen_add');
        data.append('alum_cuen_codi', $alum_cuen_codi);
        data.append('alum_codi', alum_codi);
        data.append('alum_cuen_form_pago', $('#sl_form_pago').val());
        data.append('alum_cuen_banc_tarj', $('#alum_cuen_banc_tarj').val());
        data.append('alum_cuen_banc_emis', ($('#alum_cuen_banc_emis').val()=='' ? 0 : $('#alum_cuen_banc_emis').val()));
        data.append('alum_cuen_fech_venc', $('#alum_cuen_fech_venc').val());
        data.append('alum_cuen_nume', $('#alum_cuen_nume').val());
        data.append('alum_cuen_tipo', (document.getElementById('cta_corriente').checked?'C':'A'));
        data.append('alum_cuen_nomb', $('#alum_cuen_nomb').val());
        data.append('alum_cuen_cedu', $('#alum_cuen_cedu').val());
        data.append('alum_cuen_tipo_iden', $('#alum_cuen_tipo_iden').val());
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                var json = JSON.parse(xmlhttp.responseText);
                if (json.state=="success"){             
                    $.growl.notice({ title: "Listo!",message: json.result });               
                }else{
                    $.growl.error({ title: "Atención!",message: json.result }); 
                }
                $('#btn_guardar_cuen').button('reset');
                $('#modal_metodo_pago').modal('hide');
                load_cuentas('opcion82','preinscripcion_add_cuentas.php','alum_codi='+alum_codi);
            }
        }
        xmlhttp.open("POST",url,true);
        // xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlhttp.send(data); 
    }
}
function load_modal_cuentas(div,url,data){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(div).innerHTML=xmlhttp.responseText;
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
            $("#alum_cuen_fech_venc").datepicker();
        }
    }
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data); 
}
function preinscribir_alumno()
{	
	if(comprobarObligatoriosAlum()){
		$('#btn_reservar').button('loading');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		data.append('opc', 'res_add');
		data.append('alum_nomb', document.getElementById('alum_nomb').value);
		data.append('alum_apel', document.getElementById('alum_apel').value);
		data.append('alum_fech_naci', document.getElementById('alum_fech_naci').value);
		data.append('alum_genero', $('.alum_genero:checked').val());
		data.append('alum_cedu', document.getElementById('alum_cedu').value);
		data.append('alum_tipo_iden', $('#alum_tipo_iden').val());
		data.append('alum_mail', document.getElementById('alum_mail').value);
		data.append('alum_celu', document.getElementById('alum_celu').value);
		data.append('alum_domi', document.getElementById('alum_domi').value);
		data.append('alum_telf', document.getElementById('alum_telf').value);
		data.append('alum_ciud', $('#alum_ciud option:selected').text());
		data.append('alum_parroquia', $('#alum_parroquia option:selected').text());
		data.append('alum_nacionalidad', $('#alum_nacionalidad').val());
		data.append('alum_religion', $('#alum_religion').val());
		data.append('alum_vive_con', $('#alum_vive_con').val());
		data.append('alum_parentesco_vive_con', $('#alum_parentesco_vive_con').val());
		data.append('alum_estado_civil_padres', $('#alum_estado_civil_padres').val());
		data.append('alum_movilizacion',$('#alum_movilizacion option:selected').text());
		data.append('alum_activ_deportiva', document.getElementById('alum_activ_deportiva').value);
		data.append('alum_activ_artistica',document.getElementById('alum_activ_artistica').value );
		data.append('alum_enfermedades', document.getElementById('alum_enfermedades').value);
		data.append('alum_telf_emerg', document.getElementById('alum_telf_emerg').value);
		data.append('alum_parentesco_emerg', $('#alum_parentesco_emerg').val());
		data.append('alum_pers_emerg', document.getElementById('alum_pers_emerg').value);
		data.append('alum_tipo_sangre', $('#alum_tipo_sangre').val());
		data.append('alum_pais',$('#alum_pais option:selected').text());
		data.append('alum_prov_naci', $('#alum_prov_naci option:selected').text());
		data.append('alum_ciud_naci', $('#alum_ciud_naci option:selected').text());
		data.append('alum_parr_naci', $('#alum_parr_naci option:selected').text());
		data.append('alum_sect_naci', $('#alum_sect_naci option:selected').text());
		data.append('alum_ex_plantel', $('#alum_ex_plantel').val());
		data.append('alum_ex_plantel_dire', $('#alum_ex_plantel_dire').val());
		data.append('alum_repr_finan', $('.check_finan:checked').attr('id'));
		data.append('alum_prov', $('#alum_prov option:selected').text());

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Educalinks informa:",message: json.result });
					// $('#btn_reservar').button('reset');
					// $('#modal_preinscripcion').modal('hide');
					window.location.reload();
					
				}else{
					$.growl.error({ title: "Educalinks informa:",message: json.result });
					console.log(json.console);
					$('#btn_reservar').button('reset');
					
				}
			}
		}
		xmlhttp.open("POST","script_preinscripcion.php",true);
		// xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function CargarIdentNiv2(id){
	$('#identificacion_niv_3').empty();
	var data = "id="+id+"&opc=cargar_idenficacion_nivel_2";
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {	if (xmlhttp.readyState==4 && xmlhttp.status==200){
        	resp = JSON.parse(xmlhttp.responseText);
        	options = "<option value='-1'>Seleccione</option>";
			if (resp.res == "success")
			{	for (key in resp.data)
                options = options + "<option value='"+resp.data[key].id+"'>"+resp.data[key].nombre+"</option>";
                document.getElementById('identificacion_niv_2').innerHTML = options;
			}
        }
    }
    xmlhttp.open("POST","script_preinscripcion.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(data);
}
function CargarIdentNiv3(id){
    var data = "id="+id+"&opc=cargar_idenficacion_nivel_3";
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {	if (xmlhttp.readyState==4 && xmlhttp.status==200){
        resp = JSON.parse(xmlhttp.responseText);
        options = "<option value='-1'>Seleccione</option>";
        if (resp.res == "success")
        {	for (key in resp.data)
            options = options + "<option value='"+resp.data[key].id+"'>"+resp.data[key].nombre+"</option>";
            document.getElementById('identificacion_niv_3').innerHTML = options;
        }
    }
    }
    xmlhttp.open("POST","script_preinscripcion.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(data);
}
function ValidarCuenta ()
{   
    if ($('#sl_form_pago').val().trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor escoja la forma de pago." });
        $('#sl_form_pago').closest('.form-group').addClass('has-error');
        $('#sl_form_pago').focus();
        return false;
    }
    else
    {   $('#sl_form_pago').closest('.form-group').removeClass('has-error');
    }
    if ($('#alum_cuen_banc_tarj').val().trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor escoja el Banco/Tarjeta." });
        $('#alum_cuen_banc_tarj').closest('.form-group').addClass('has-error');
        $('#alum_cuen_banc_tarj').focus();
        return false;
    }
    else
    {   $('#alum_cuen_banc_tarj').closest('.form-group').removeClass('has-error');
    }
    if($('#sl_form_pago').val()==23){
        if ($('#alum_cuen_banc_emis').val().trim() == '')
        {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el banco emisor de la tarjeta de crédito." });
            $('#alum_cuen_banc_emis').closest('.form-group').addClass('has-error');
            $('#alum_cuen_banc_emis').focus();
            return false;
        }
        else
        {   $('#alum_cuen_banc_emis').closest('.form-group').removeClass('has-error');
        }
        if ($('#alum_cuen_fech_venc').val().trim() == '')
        {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la fecha de vencimiento de la tarjeta de crédito." });
            $('#alum_cuen_fech_venc').closest('.form-group').addClass('has-error');
            $('#alum_cuen_fech_venc').focus();
            return false;
        }
        else
        {   $('#alum_cuen_fech_venc').closest('.form-group').removeClass('has-error');
        }
    }
    if ($('#alum_cuen_nomb').val().trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el nombre del propietario de la cuenta." });
        $('#alum_cuen_nomb').closest('.form-group').addClass('has-error');
        $('#alum_cuen_nomb').focus();
        return false;
    }
    else
    {   $('#alum_cuen_nomb').closest('.form-group').removeClass('has-error');
    }
    if (document.getElementById('alum_cuen_cedu').value.trim() == '' ){
        $('#alum_cuen_cedu').closest('.form-group').addClass('has-error');
        $.growl.error({ title: 'Educalinks informa', message: 'Por favor ingrese el número de identificación del propietario de la cuenta.' });
        document.getElementById('alum_cuen_cedu').focus();
        return false;
    }
    else if (document.getElementById('alum_cuen_cedu').value.trim() != '')
    {
        response = validarNI(document.getElementById('alum_cuen_cedu').value,document.getElementById('alum_cuen_tipo_iden').options[document.getElementById('alum_cuen_tipo_iden').selectedIndex].value);
        if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" )
        {   $('#alum_cuen_cedu').closest('.form-group').removeClass('has-error');
        }
        else
        {   $.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación de acuerdo al tipo correctamente." });
            $('#alum_cuen_cedu').closest('.form-group').addClass('has-error');
            document.getElementById('alum_cuen_cedu').focus();
            return false;
        }
    }
    if (document.getElementById('alum_cuen_nume').value.trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese número de cuenta o tarjeta." });
        $('#alum_cuen_nume').closest('.form-group').addClass('has-error');
        document.getElementById('alum_cuen_nume').focus();
        return false;
    }
    else
    {   $('#alum_cuen_nume').closest('.form-group').removeClass('has-error');
    }
    
    return true;
}
function comprobarObligatoriosRepre(){
	if ($('#repr_nomb').val().trim()=='')
	{	$('#repr_nomb').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_nomb').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_apel').val().trim()=='')
	{	$('#repr_apel').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_apel').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_email').val().trim()=='')
	{	$('#repr_email').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_email').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_telf').val().trim()=='')
	{	$('#repr_telf').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_telf').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_celular').val().trim()=='')
	{	$('#repr_celular').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_celular').closest('.form-group').removeClass('has-error');
	}
	return true;
}
function comprobarObligatoriosAlum(){
	if ($('#alum_fech_naci').val().trim()=='')
	{	$('#alum_fech_naci').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingrese fecha de nacimiento del alumno.' });
		return false;
	}
	else
	{	$('#alum_fech_naci').closest('.form-group').removeClass('has-error');
	}
	if (document.getElementById('alum_cedu').value.trim()=='' && $('#alum_cedu').hasClass('required'))
	{	$('#alum_cedu').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingrese la cédula del alumno.' });
		return false;
	}else{
		var response = validarNI(document.getElementById('alum_cedu').value,document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value);
		if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" ){
			$('#alum_cedu').closest('.form-group').removeClass('has-error');
		}else{
			$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar número de cédula o RUC correcto.' });
			$('#alum_cedu').closest('.form-group').addClass('has-error');
			return false;
		}
	}
	if ($('#alum_domi').val().trim()=='')
	{	$('#alum_domi').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar domicilio del alumno.' });
		return false;
	}
	else
	{	$('#alum_domi').closest('.form-group').removeClass('has-error');
	}
	if ($('#alum_ciud').text().trim()=='')
	{	$('#alum_ciud').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar ciudad domicilio del alumno.' });
		return false;
	}
	else
	{	$('#alum_ciud').closest('.form-group').removeClass('has-error');
	}
	if ($('#alum_parroquia').text().trim()=='')
	{	$('#alum_parroquia').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar parroquia domicilio del alumno.' });
		return false;
	}
	else
	{	$('#alum_parroquia').closest('.form-group').removeClass('has-error');
	}
	
	if (!document.getElementById('aceptar_terminos').checked)
	{	$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor acepte los términos.' });
		document.getElementById('aceptar_terminos').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('aceptar_terminos').style.border='';
	}
	return true;
}
// *JBZ*
function validarNI(strCedula,tipo_iden)
{	
	if (tipo_iden==3){
			return 'Pasaporte';
	}else if(isNumeric(strCedula))
	{	
		var total_caracteres=strCedula.length;// se suma el total de caracteres
		if(tipo_iden==1)
		{
			if(total_caracteres==10)
			{	//compruebo que tenga 10 digitos la cedula
				var nro_region=strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
				if(nro_region>=1 && nro_region<=24)
				{	// compruebo a que region pertenece esta cedula//
					var ult_digito=strCedula.substring( total_caracteres-1,total_caracteres);//extraigo el ultimo digito de la cedula
					//extraigo los valores pares//
					var valor2=parseInt(strCedula.charAt(1));
					var valor4=parseInt(strCedula.charAt(3));
					var valor6=parseInt(strCedula.charAt(5));
					var valor8=parseInt(strCedula.charAt(7));
					var suma_pares=(valor2 + valor4 + valor6 + valor8);
					//extraigo los valores impares//
					var valor1=parseInt(strCedula.charAt(0));
					valor1=(valor1 * 2);
					if(valor1>9){ valor1=(valor1 - 9); }else{ }
					var valor3=parseInt(strCedula.charAt(2));
					valor3=(valor3 * 2);
					if(valor3>9){ valor3=(valor3 - 9); }else{ }
					var valor5=parseInt(strCedula.charAt(4));
					valor5=(valor5 * 2);
					if(valor5>9){ valor5=(valor5 - 9); }else{ }
					var valor7=parseInt(strCedula.charAt(6));
					valor7=(valor7 * 2);
					if(valor7>9){ valor7=(valor7 - 9); }else{ }
					var valor9=parseInt(strCedula.charAt(8));
					valor9=(valor9 * 2);
					if(valor9>9){ valor9=(valor9 - 9); }else{ }

					var suma_impares=(valor1 + valor3 + valor5 + valor7 + valor9);
					var suma=(suma_pares + suma_impares);
					var temp=''+suma;
					var dis=parseInt(temp.charAt(0));//extraigo el primer numero de la suma
					var dis=((dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
					var digito=(dis - suma);
					if(digito==10){ digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
					if (digito==parseInt(ult_digito))
					{	//comparo los digitos final y ultimo
						return "Cédula Correcta";
					}
					else
					{	return "Cédula Incorrecta";
					}
				}else
				{	//echo "Este Nro de Cedula no corresponde a ninguna provincia del ecuador";
					return "Cédula Incorrecta";
				}
				//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".total_caracteres."";

			}else //numero 10
			{	//echo "Es un Numero y tiene solo".total_caracteres;
				return "Cédula Incorrecta";
			}
		} else if (tipo_iden==2)
		{
			if(total_caracteres==13)
			{	//compruebo que tenga 10 digitos la cedula
				var nro_region=strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
				if(nro_region>=1 && nro_region<=24)
				{	
					var primeros_digitos;
					var array_coeficientes;
					var digito_verificador;
					var valor3 = strCedula.charAt(2);
					if(valor3>=0 && valor3<=5){ //Persona natural
						primeros_digitos = strCedula.substring( 0, 9);
						array_coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
						digito_verificador = parseInt(strCedula.charAt(9));
						primeros_digitos = primeros_digitos.split("");

						var total = 0;

						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            if (valor_Posicion >= 10) {
				            	var valor_char = valor_Posicion.toString();
				                valor_char = valor_char.split("");
				                var temp=0;
				                valor_char.forEach(function(item){
				                	temp = temp + parseInt(item);
				                });
				                valor_Posicion = temp;
				            }
				            total = total + valor_Posicion;
						});

				        var residuo =  total % 10;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 10 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else if (valor3==6){ // Entidad Publica
						primeros_digitos = strCedula.substring( 0, 8);
						array_coeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
						digito_verificador = parseInt(strCedula.charAt(8));
						primeros_digitos = primeros_digitos.split("");


						var total = 0;
						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            total = total + valor_Posicion;
						});

				        var residuo =  total % 11;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 11 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else if (valor3==9){ // Sociedad Privada
						primeros_digitos = strCedula.substring( 0, 9);
						array_coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
						digito_verificador = parseInt(strCedula.charAt(9));
						primeros_digitos = primeros_digitos.split("");

						var total = 0;
						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            total = total + valor_Posicion;
						});
				        var residuo =  total % 11;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 11 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else {
						return 'RUC Incorrecto';
					}	
				}else
				{	//echo "Este Nro de RUC no corresponde a ninguna provincia del ecuador";
					return 'RUC Incorrecto';
				}
				//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".$total_caracteres."";

			}else //numero 10
			{	//return "Es un Numero y tiene solo".$total_caracteres;
				return 'RUC Incorrecto';
			}
		}
	}else
	{	return "Esta Cédula o RUC no corresponde a un Nro de Identidad de Ecuador";
		//return "Incorrecto"
	}
	
}
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}