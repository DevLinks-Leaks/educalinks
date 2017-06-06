$(document).ready(function(){
	$('#form_nivel_aplic').on('change', function (){
		show_cursos_niv(this.value);
	});
	$('#rad_repetidor_si').on('click', function (){
		show_cursos();
	});
	$('#rad_repetidor_no').on('click', function (){
		$('#form_curso_rep').empty();
	});
});
function show_cursos_niv(nive_codi)
{	$('#form_curso_aplic').empty();
	data_get = "nive_codi="+nive_codi+"&method=show_cursos_niv";
	$.ajax({
		type: "GET",
		url: "adm_formulario_func.php",
		data: data_get,
		success: function(data){
			json = JSON.parse(data);
			$.each(json, function(key, value){
				$('#form_curso_aplic').append('<option value="'+value.curs_codi+'">'+value.curs_deta+'</option>');
			});
		},
		error: function(data){
			
		}
	});
}
function show_cursos()
{	$('#form_curso_rep').empty();
	data_get = "method=show_cursos";
	$.ajax({
		type: "GET",
		url: "adm_formulario_func.php",
		data: data_get,
		success: function(data){
			json = JSON.parse(data);
			$.each(json, function(key, value){
				$('#form_curso_rep').append('<option value="'+value.curs_codi+'">'+value.curs_deta+'</option>');
			});
		},
		error: function(data){
			
		}
	});
}
function save()
{	//if (validar_formulario()){
		json = {};
		json["id"] = $('#form_id').val();
		json["asp_codi"] = $('#form_asp_id').val();
		json["peri_codi"] = $('#form_peri_codi').val();
		json["nivel_aplic"] = $('#form_nivel_aplic').val();
		json["curso_aplic"] = $('#form_curso_aplic').val();
		json["form_curso_aplic"] = ($('#rad_repetidor_si').is(':checked')?1:0);
		json["curs_repite"] = $('#form_curso_rep').val();
		json["apoyo_acad"] = ($('#rad_apoy_acad_si').is(':checked')?1:0);
		json["apoyo_social"] = ($('#rad_apoy_social_si').is(':checked')?1:0);
		json["apoyo_ingles"] = ($('#rad_apoy_ingles_si').is(':checked')?1:0);
		json["apoyo_otro"] = $('#form_otro_apoyo').val();
		json["apoyo_aspectos"] = $('#form_apoyo_aspectos').val();
		json["programa_terapia_ext"] = ($('#rad_terapia_ext_si').is(':checked')?1:0);
		json["programa_drogas"] = ($('#rad_drogas_si').is(':checked')?1:0);
		json["otros_programas"] = $('#form_otros_programas').val();
		json["pertenece_grupo_cat"] = ($('#rad_grupo_cat_si').is(':checked')?1:0);
		json["grupo_cat"] = $('#form_grupo_cat').val();
		json["es_deportista"] = ($('#rad_deportista_si').is(':checked')?1:0);
		json["deporte"] = $('#form_deporte').val();
		json["familiares_est"] = $('#form_familiares_est').val();
		json["retiro_sug"] = ($('#rad_retiro_sug_si').is(':checked')?1:0);
		json["probl_acad"] = ($('#rad_probl_acad_si').is(':checked')?1:0);
		json["probl_discip"] = $('#form_probl_discip').val();
		json["historial_ue"] = $('#form_historial_ue').val();
		json["es_enfermo"] = ($('#rad_es_enfermo_si').is(':checked')?1:0);
		json["enfermedad"] = $('#form_enfermedad').val();
		json["es_alergico"] = ($('#rad_es_alergico_si').is(':checked')?1:0);
		json["alergia"] = $('#rad_alergia').val();
		
		$('#wait_guardar_fam').removeClass('fa-search');
		$('#wait_guardar_fam').addClass('fa-sun-o fa-spin');
		
		data_get = "json="+JSON.stringify(json)+"&method=save";
		$.ajax({
			type: "GET",
			url: "adm_formulario_func.php",
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
	//}
}