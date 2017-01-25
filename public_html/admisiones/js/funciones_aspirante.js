$(document).ready(function(){
	//bloquear_formulario();
	$('#asp_vive_con').on('change', function (){
		if (this.value=="Otros")
		{	$('#asp_vive_con_especifique').prop('disabled',false);
			$('#asp_vive_con_especifique').focus();
		}
		else
		{	$('#asp_vive_con_especifique').prop('disabled',true);
			$('#asp_vive_con_especifique').val('');
		}
	});
	$('#asp_num_identificacion').focus();
	$('#asp_num_identificacion').keyup(function(e){
		if(e.keyCode == 13)
		{	show_asp();
		}
	});
});
function desbloquear_formulario_asp ()
{	$("input[name^='asp_']").prop('disabled', false);
	$("select[name^='asp_']").prop('disabled', false);
	$('#asp_vive_con_especifique').prop('disabled', true);
	$('#asp_nombre_1').focus();
}
function bloquear_formulario_asp ()
{	$("input[name^='asp_']").prop('disabled', true);
	$("select[name^='asp_']").prop('disabled', true);
}
function bloquear_busqueda_asp ()
{	$('#asp_num_identificacion').prop('disabled',true);
	$('#asp_tipo_identificacion').prop('disabled',true);
	$('#btn_buscar_asp').prop('disabled',true);
	$('#btn_guardar_asp').prop('disabled',false);
}
function validar_formulario_asp ()
{	if ($('#asp_nombre_1').val().trim()=="")
	{	$('#asp_nombre_1').closest('div').addClass('has-warning');
		$('#asp_nombre_1').focus();
		return false;
	}
	else
	{	$('#asp_nombre_1').closest('div').removeClass('has-warning');
	}
	if ($('#asp_apellido_1').val().trim()=="")
	{	$('#asp_apellido_1').closest('div').addClass('has-warning');
		$('#asp_apellido_1').focus();
		return false;
	}
	else
	{	$('#asp_apellido_1').closest('div').removeClass('has-warning');
	}
	if ($('#asp_fecha_nac').val().trim()=="")
	{	$('#asp_fecha_nac').closest('div').addClass('has-warning');
		$('#asp_fecha_nac').focus();
		return false;
	}
	else
	{	$('#asp_fecha_nac').closest('div').removeClass('has-warning');
	}
	if ($('#asp_religion').val().trim()=="")
	{	$('#asp_religion').closest('div').addClass('has-warning');
		$('#asp_religion').focus();
		return false;
	}
	else
	{	$('#asp_religion').closest('div').removeClass('has-warning');
	}
	if ($('#asp_pais_nac').val().trim()=="")
	{	$('#asp_pais_nac').closest('div').addClass('has-warning');
		$('#asp_pais_nac').focus();
		return false;
	}
	else
	{	$('#asp_pais_nac').closest('div').removeClass('has-warning');
	}
	if ($('#asp_provincia_nac').val().trim()=="")
	{	$('#asp_provincia_nac').closest('div').addClass('has-warning');
		$('#asp_provincia_nac').focus();
		return false;
	}
	else
	{	$('#asp_provincia_nac').closest('div').removeClass('has-warning');
	}
	if ($('#asp_ciudad_nac').val().trim()=="")
	{	$('#asp_ciudad_nac').closest('div').addClass('has-warning');
		$('#asp_ciudad_nac').focus();
		return false;
	}
	else
	{	$('#asp_ciudad_nac').closest('div').removeClass('has-warning');
	}
	if ($('#asp_direccion').val().trim()=="")
	{	$('#asp_direccion').closest('div').addClass('has-warning');
		$('#asp_direccion').focus();
		return false;
	}
	else
	{	$('#asp_direccion').closest('div').removeClass('has-warning');
	}
	if ($('#asp_num_convencional').val().trim()=="")
	{	$('#asp_num_convencional').closest('div').addClass('has-warning');
		$('#asp_num_convencional').focus();
		return false;
	}
	else
	{	$('#asp_num_convencional').closest('div').removeClass('has-warning');
	}
	/*if ($('#asp_num_celular').val().trim()=="")
	{	$('#asp_num_celular').closest('div').addClass('has-warning');
		$('#asp_num_celular').focus();
		return false;
	}
	else
	{	$('#asp_num_celular').closest('div').removeClass('has-warning');
	}
	if ($('#asp_correo').val().trim()=="")
	{	$('#asp_correo').closest('div').addClass('has-warning');
		$('#asp_correo').focus();
		return false;
	}
	else
	{	$('#asp_correo').closest('div').removeClass('has-warning');
	}*/  
	/*if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#asp_correo').val())))  
	{  $('#asp_correo').closest('div').addClass('has-warning');
	   $('#asp_correo').focus();
		return false;
	}  
	else
	{	$('#asp_correo').closest('div').removeClass('has-warning');
	}*/
	return true;
}
function show_asp()
{	if ($('#asp_num_identificacion').val().trim()!="")
	{	$('#wait_buscar_asp').removeClass('fa-search');
		$('#wait_buscar_asp').addClass('fa-sun-o fa-spin');
		tipo_id = $('#asp_tipo_identificacion').val();
		numero_id = $('#asp_num_identificacion').val();
		data_get = 'tipo_id='+tipo_id+'&numero_id='+numero_id+'&method=show';
		$.ajax({
			type: "GET",
			url: "adm_aspirante_func.php",
			data: data_get,
			success: function(data){
				json = JSON.parse(data);
				if (json[0]!=null)
				{	$('#asp_persona_id').val(json[0]["id"]);
					$('#asp_nombre_1').val(json[0]["nombre_1"]);
					$('#asp_nombre_2').val(json[0]["nombre_2"]);
					$('#asp_apellido_1').val(json[0]["apellido_1"]);
					$('#asp_apellido_2').val(json[0]["apellido_2"]);
					$('#asp_fecha_nac').val(json[0]["fecha_ncto"]["date"].substring(0,10));
					$('#asp_pais_nac').val(json[0]["pais_ncto"]);
					$('#asp_religion').val(json[0]["religion"]);
					$('#asp_provincia_nac').val(json[0]["provincia_ncto"]);
					$('#asp_ciudad_nac').val(json[0]["ciudad_ncto"]);
					$('#asp_direccion').val(json[0]["direccion"]);
					$('#asp_num_convencional').val(json[0]["convencional"]);
					$('#asp_num_celular').val(json[0]["celular"]);
					$('#asp_correo').val(json[0]["correo"]);
					$('#asp_vive_con_especifique').val(json[0]["vive_con_especifique"]);
					$('#asp_facebook').val(json[0]["facebook"]);
					$('#asp_instagram').val(json[0]["instagram"]);
					$('#asp_twitter').val(json[0]["twitter"]);
					$('#asp_vive_con').val(json[0]["vive_con"]);
					$('#asp_genero').val(json[0]["genero"]);
				}
				$('#wait_buscar_asp').addClass('fa-search');
				$('#wait_buscar_asp').removeClass('fa-sun-o fa-spin');
				desbloquear_formulario_asp();
				bloquear_busqueda_asp();
			},
			error: function(data){
				
			}
		});
	}
	else
	{	alert ('Por favor ingrese el número de ID del aspirante.');
		$('#asp_num_identificacion').focus();
	}
}
function save()
{	if (validar_formulario_asp()){
		json = {};
		json["id"] = $('#asp_persona_id').val();
		json["tipo_id"] = $('#asp_tipo_identificacion').val();
		json["numero_id"] = $('#asp_num_identificacion').val();
		json["nombre_1"] = $('#asp_nombre_1').val();
		json["nombre_2"] = $('#asp_nombre_2').val();
		json["apellido_1"] = $('#asp_apellido_1').val();
		json["apellido_2"] = $('#asp_apellido_2').val();
		json["genero"] = $('#asp_genero').val();
		json["fecha_ncto"] = $('#asp_fecha_nac').val();
		json["religion"] = $('#asp_religion').val();
		json["pais_nac"] = $('#asp_pais_nac').val();
		json["provincia_nac"]  = $('#asp_provincia_nac').val();
		json["ciudad_nac"] = $('#asp_ciudad_nac').val();
		json["direccion"] = $('#asp_direccion').val();
		json["num_convencional"] = $('#asp_num_convencional').val();
		json["num_celular"] = $('#asp_num_celular').val();
		json["correo"] = $('#asp_correo').val();
		json["vive_con"] = $('#asp_vive_con').val();
		json["vive_con_especifique"] = $('#asp_vive_con_especifique').val();
		json["facebook"] = $('#asp_facebook').val();
		json["instagram"] = $('#asp_instagram').val();
		json["twitter"] = $('#asp_twitter').val();
		
		$('#wait_guardar_asp').removeClass('fa-search');
		$('#wait_guardar_asp').addClass('fa-sun-o fa-spin');
		data_get = "json="+JSON.stringify(json)+"&method=save";
		$.ajax({
			type: "GET",
			url: "adm_aspirante_func.php",
			data: data_get,
			success: function(data){
				json = JSON.parse(data);
				$('#msg_info').css('display','none');
				if (json["id"]!=null)
				{	$('#asp_persona_id').val(json["id"]);
					$('#btn_continuar').attr('href',$('#btn_continuar').attr('href')+json["id"]);
					$('#msg_info').addClass('label-success');
					$('#msg_info').text("¡Datos guardados con éxito!");
					$('#wait_guardar_asp').addClass('fa-save');
					$('#wait_guardar_asp').removeClass('fa-sun-o fa-spin');
					$("#msg_info").show('slow');
					$('#btn_guardar_asp').css('display','none');
					$('#btn_continuar').show('slow');
				}
				else
				{	$('#msg_info').addClass('label-error');
					$('#msg_info').text("¡Ocurrió un error, comuníquese con el administrador!");
					$("#msg_info").show('slow');
				}
			},
			error: function(data){
				
			}
		});
	}
}
function validar_identificacion ()
{	num_identificacion	= $('#asp_num_identificacion').val();
	tipo_identificacion	= $('#asp_tipo_identificacion').val();
	data_get = 'numero_id='+num_identificacion+'&tipo_id='+tipo_identificacion+'&method=check_id';
	$.ajax({
		type: "GET",
		url: "adm_aspirante_func.php",
		data: data_get,
		success: function(data){
			json = JSON.parse(data);
			$('#msg_info').css('display','none');
			if (json["result"]=="error")
			{	$('#msg_info').addClass('label-danger');
				$('#msg_info').text(json["message"]);
				$("#msg_info").show('slow');
			}
			else
				show_asp();
		},
		error: function(data){
			
		}
	});
}