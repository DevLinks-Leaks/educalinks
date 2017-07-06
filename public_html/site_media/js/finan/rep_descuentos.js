function carga_reports_descuentos(div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    periodos= document.getElementById('periodos').value;
	tipo_descuentos= document.getElementById('cmb_tipo_descuentos').value;
	cursos= document.getElementById('curso').value;
	
	var data = new FormData();
	
	data.append('event', 'printvisor');
	data.append('periodos', periodos);
	data.append('curso', cursos);
	data.append('tipo_descuentos', tipo_descuentos);
	url2=url+'?event='+evento+'&periodos='+periodos+'&curso='+cursos+'&tipo_descuentos='+tipo_descuentos;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			
		} 
	}
	xhr.send(data);
}