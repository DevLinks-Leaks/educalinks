$(document).ready(function(){
	$('#fam_num_identificacion').focus();
	$('#fam_num_identificacion').keyup(function(e){
		if(e.keyCode == 13)
		{	validar_identificacion();
		}
	});
});
function desbloquear_formulario ()
{	$("input[name^='fam_']").prop('disabled', false);
	$("select[name^='fam_']").prop('disabled', false);
	if ($('#fam_parentesco_editable').val()==1)
		$('#fam_parentesco').prop('disabled',false);
	else
		$('#fam_parentesco').prop('disabled',true);
	$('#fam_nombre_1').focus();
}
function bloquear_formulario ()
{	$("input[name^='fam_']").prop('disabled', true);
	$("select[name^='fam_']").prop('disabled', true);
}
function bloquear_busqueda ()
{	$('#fam_num_identificacion').prop('disabled',true);
	$('#fam_tipo_identificacion').prop('disabled',true);
	$('#btn_buscar_fam').prop('disabled',true);
	$('#btn_guardar_fam').prop('disabled',false);
}
function validar_formulario ()
{	if ($('#fam_nombre_1').val().trim()=="")
	{	$('#fam_nombre_1').closest('div').addClass('has-warning');
		$('#fam_nombre_1').focus();
		return false;
	}
	else
	{	$('#fam_nombre_1').closest('div').removeClass('has-warning');
	}
	if ($('#fam_apellido_1').val().trim()=="")
	{	$('#fam_apellido_1').closest('div').addClass('has-warning');
		$('#fam_apellido_1').focus();
		return false;
	}
	else
	{	$('#fam_apellido_1').closest('div').removeClass('has-warning');
	}
	if ($('#fam_fecha_nac').val().trim()=="")
	{	$('#fam_fecha_nac').closest('div').addClass('has-warning');
		$('#fam_fecha_nac').focus();
		return false;
	}
	else
	{	$('#fam_fecha_nac').closest('div').removeClass('has-warning');
	}
	if ($('#fam_profesion').val().trim()=="")
	{	$('#fam_profesion').closest('div').addClass('has-warning');
		$('#fam_profesion').focus();
		return false;
	}
	else
	{	$('#fam_profesion').closest('div').removeClass('has-warning');
	}
	if ($('#fam_nacionalidad').val().trim()=="")
	{	$('#fam_nacionalidad').closest('div').addClass('has-warning');
		$('#fam_nacionalidad').focus();
		return false;
	}
	else
	{	$('#fam_nacionalidad').closest('div').removeClass('has-warning');
	}
	if ($('#fam_direccion').val().trim()=="")
	{	$('#fam_direccion').closest('div').addClass('has-warning');
		$('#fam_direccion').focus();
		return false;
	}
	else
	{	$('#fam_direccion').closest('div').removeClass('has-warning');
	}
	if ($('#fam_num_convencional').val().trim()=="")
	{	$('#fam_num_convencional').closest('div').addClass('has-warning');
		$('#fam_num_convencional').focus();
		return false;
	}
	else
	{	$('#fam_num_convencional').closest('div').removeClass('has-warning');
	}
	if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#fam_correo').val())))  
	{  $('#fam_correo').closest('div').addClass('has-warning');
	   $('#fam_correo').focus();
		return false;
	}  
	else
	{	$('#fam_correo').closest('div').removeClass('has-warning');
	}
	if ($('#fam_empresa_trabaja').val().trim()=="")
	{	$('#fam_empresa_trabaja').closest('div').addClass('has-warning');
		$('#fam_empresa_trabaja').focus();
		return false;
	}
	else
	{	$('#fam_empresa_trabaja').closest('div').removeClass('has-warning');
	}
	if ($('#fam_direccion_trabaja').val().trim()=="")
	{	$('#fam_direccion_trabaja').closest('div').addClass('has-warning');
		$('#fam_direccion_trabaja').focus();
		return false;
	}
	else
	{	$('#fam_direccion_trabaja').closest('div').removeClass('has-warning');
	}
	if ($('#fam_convencional_trabajo').val().trim()=="")
	{	$('#fam_convencional_trabajo').closest('div').addClass('has-warning');
		$('#fam_convencional_trabajo').focus();
		return false;
	}
	else
	{	$('#fam_convencional_trabajo').closest('div').removeClass('has-warning');
	}	
	return true;
}
function show()
{	if ($('#fam_num_identificacion').val().trim()!="")
	{	$('#wait_buscar_fam').removeClass('fa-search');
		$('#wait_buscar_fam').addClass('fa-sun-o fa-spin');
		tipo_id = $('#fam_tipo_identificacion').val();
		numero_id = $('#fam_num_identificacion').val();
		aspirante_id = $('#asp_persona_id').val();
		data_get = 'tipo_id='+tipo_id+'&numero_id='+numero_id+'&aspirante_id='+aspirante_id+'&method=show';
		$.ajax({
			type: "GET",
			url: "adm_familiar_func.php",
			data: data_get,
			success: function(data){
				json = JSON.parse(data);
				if (json[0]!=null)
				{	$('#fam_persona_id').val(json[0]["id"]);
					$('#fam_nombre_1').val(json[0]["nombre_1"]);
					$('#fam_nombre_2').val(json[0]["nombre_2"]);
					$('#fam_apellido_1').val(json[0]["apellido_1"]);
					$('#fam_apellido_2').val(json[0]["apellido_2"]);
					$('#fam_fecha_nac').val(json[0]["fecha_ncto"]["date"].substring(0,10));
					$('#fam_genero').val(json[0]["genero"]);
					$('#fam_profesion').val(json[0]["profesion"]);
					$('#fam_nacionalidad').val(json[0]["nacionalidad"]);
					$('#fam_direccion').val(json[0]["direccion"]);
					$('#fam_num_convencional').val(json[0]["convencional"]);
					$('#fam_num_celular').val(json[0]["celular"]);
					$('#fam_correo').val(json[0]["correo"]);
					$('#fam_empresa_trabaja').val(json[0]["empresa_trabaja"]);
					$('#fam_cargo').val(json[0]["cargo"]);
					$('#fam_direccion_trabaja').val(json[0]["direccion_trabaja"]);
					$('#fam_convencional_trabajo').val(json[0]["convencional_trabajo"]);
					$('#fam_celular_trabajo').val(json[0]["celular_trabajo"]);
					$('#fam_correo_trabajo').val(json[0]["correo_trabajo"]);
					$('#fam_colegio').val(json[0]["colegio"]);
					$('#fam_universidad').val(json[0]["universidad"]);
					if (json[0]["parentesco"])
						$('#fam_parentesco').val(json[0]["parentesco"]);
					$('#fam_motivo').val(json[0]["observacion"]);
				}
				$('#wait_buscar_fam').addClass('fa-search');
				$('#wait_buscar_fam').removeClass('fa-sun-o fa-spin');
				desbloquear_formulario();
				bloquear_busqueda();
			},
			error: function(data){
				
			}
		});
	}
	else
	{	alert ('Por favor ingrese el número de ID del familiar/representante.');
		$('#fam_num_identificacion').focus();
	}
}
function save()
{	if (validar_formulario()){
		json = {};
		json["id"] = $('#fam_persona_id').val();
		json["tipo_id"] = $('#fam_tipo_identificacion').val();
		json["numero_id"] = $('#fam_num_identificacion').val();
		json["nombre_1"] = $('#fam_nombre_1').val();
		json["nombre_2"] = $('#fam_nombre_2').val();
		json["apellido_1"] = $('#fam_apellido_1').val();
		json["apellido_2"] = $('#fam_apellido_2').val();
		json["genero"] = $('#fam_genero').val();
		json["fecha_ncto"] = $('#fam_fecha_nac').val();
		json["profesion"] = $('#fam_profesion').val();
		json["nacionalidad"] = $('#fam_nacionalidad').val();
		json["direccion"] = $('#fam_direccion').val();
		json["num_convencional"] = $('#fam_num_convencional').val();
		json["num_celular"] = $('#fam_num_celular').val();
		json["correo"] = $('#fam_correo').val();
		json["empresa_trabaja"] = $('#fam_empresa_trabaja').val();
		json["cargo"] = $('#fam_cargo').val();
		json["direccion_trabajo"] = $('#fam_direccion_trabaja').val();
		json["convencional_trabajo"] = $('#fam_convencional_trabajo').val();
		json["celular_trabajo"] = $('#fam_celular_trabajo').val();
		json["correo_trabajo"] = $('#fam_correo_trabajo').val();
		json["colegio"] = $('#fam_colegio').val();
		json["universidad"] = $('#fam_universidad').val();
		json["parentesco"] = $('#fam_parentesco').val();
		json["motivo"] = $('#fam_motivo').val();
		json["aspirante_id"] = $('#asp_persona_id').val();
		
		$('#wait_guardar_fam').removeClass('fa-search');
		$('#wait_guardar_fam').addClass('fa-sun-o fa-spin');
		
		data_get = "json="+JSON.stringify(json)+"&method=save";
		$.ajax({
			type: "GET",
			url: "adm_familiar_func.php",
			data: data_get,
			success: function(data){
				json = JSON.parse(data);
				$('#msg_info').css('display','none');
				if (json["id"]!=null)
				{	$('#fam_persona_id').val(json["id"]);
					$('#msg_info').addClass('label-success');
					$('#msg_info').text("¡Datos guardados con éxito!");
					$('#wait_guardar_fam').addClass('fa-save');
					$('#wait_guardar_fam').removeClass('fa-sun-o fa-spin');
					$("#msg_info").show('slow');
					$('#btn_guardar_fam').css('display','none');
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
{	num_identificacion	= $('#fam_num_identificacion').val();
	tipo_identificacion	= $('#fam_tipo_identificacion').val();
	data_get = 'numero_id='+num_identificacion+'&tipo_id='+tipo_identificacion+'&method=check_id';
	$.ajax({
		type: "GET",
		url: "adm_familiar_func.php",
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
				show();
		},
		error: function(data){
			
		}
	});
}
function set_tipo_representante(aspirante_id, representante_id, tipo)
{	data_get = 'aspirante_id='+aspirante_id+'&representante_id='+representante_id+'&tipo='+tipo+'&method=set_tipo_representante';
	$.ajax({
		type: "GET",
		url: "adm_familiar_func.php",
		data: data_get,
		success: function(data){
			json = JSON.parse(data);
			if (json.result=="success")
			{	$.growl.notice({ title: "Mensaje",message: "¡Cambio realizado exitosamente!" });				
			}
			else
			{	$.growl.error({ title: "Mensaje",message: "¡Cambio realizado exitosamente!" });	
			}
		},
		error: function(data){
			
		}
	});
}