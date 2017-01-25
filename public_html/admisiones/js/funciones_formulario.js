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