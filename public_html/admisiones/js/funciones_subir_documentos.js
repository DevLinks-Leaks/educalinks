function upload_doc(asp_id, docu_peri_id, peri_id)
{	if ($('#doc_'+asp_id+'_'+docu_peri_id).val()!='')
	{	var form_data = new FormData();
		var file_data = $('#doc_'+asp_id+'_'+docu_peri_id).prop('files')[0];
		form_data.append('file', file_data);
		form_data.append('method', 'upload_doc');
		form_data.append('asp_id', asp_id);
		form_data.append('docu_peri_id', docu_peri_id);
		$('#span_'+docu_peri_id).removeClass('fa-upload');
		$('#span_'+docu_peri_id).addClass('fa-sun-o fa-spin');
		$.ajax({
			url: 'adm_subir_docs_func.php', // point to server-side PHP script 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(php_script_response){
				actualizar_tabla_docs(asp_id, peri_id);
			}
		});
	}
	else
	{
		alert ("Por favor seleccione un archivo.");
	}
}
function actualizar_tabla_docs(asp_id, peri_id)
{	data = 'peri_codi='+peri_id+'&asp_id='+asp_id;
	$.ajax({
			type: "GET",
			url: "adm_tabla_subir_docs.php",
			data: data,
			success: function(data){
				$('#div_tabla_docs').html(data);
			},
			error: function(data){
				
			}
		});
}