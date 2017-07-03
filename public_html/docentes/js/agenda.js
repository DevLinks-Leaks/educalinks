
// JavaScript Document


function agen_add(div,url,curs_para_mate_prof_codi,curs_para_mate_codi)
{
	if(comprobarObligatoriosAgenda()){
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		var data = new FormData();
		var fecha_ini_dia,fecha_ini_mes,fecha_ini_ano,fecha_ini;
		fecha_ini_dia=document.getElementById('agen_fech_ini').value.substring(0,2);
		fecha_ini_mes=document.getElementById('agen_fech_ini').value.substring(3,5);
		fecha_ini_ano=document.getElementById('agen_fech_ini').value.substring(6,11);
		fecha_ini=fecha_ini_ano+""+fecha_ini_mes+""+fecha_ini_dia;
		var fecha_fin_dia,fecha_fin_mes,fecha_fin_ano,fecha_fin;
		fecha_fin_dia=document.getElementById('agen_fech_fin').value.substring(0,2);
		fecha_fin_mes=document.getElementById('agen_fech_fin').value.substring(3,5);
		fecha_fin_ano=document.getElementById('agen_fech_fin').value.substring(6,11);
		fecha_fin=fecha_fin_ano+""+fecha_fin_mes+""+fecha_fin_dia;

	    var mater_codi=null;
	    var archivo = document.getElementById('mater_codi');
	    if (archivo!=null)
	    	if (archivo.value!='')
				mater_codi = archivo.files[0];
	    else
	        mater_codi=null;

	    var agen_codi=$('#hd_agen_codi').val();
	    var hd_mater_codi=$('#hd_mater_codi').val();
	    if (agen_codi>0){
	        data.append('opc', 'agen_edit');
	        data.append('agen_codi', agen_codi);
	        data.append('mater_codi_edit',hd_mater_codi);
		}
	    else
	        data.append('opc', 'agen_add');
		data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
		data.append('agen_fech_ini', fecha_ini);
		data.append('agen_fech_fin', fecha_fin);
		data.append('agen_deta', document.getElementById('agen_deta').value);
		data.append('agen_titu', document.getElementById('agen_titu').value);
	    data.append('agen_tipo_codi', $('#agen_tipo_codi').val());
		data.append('agen_tiempo', ($('#agen_tiempo').val()=='00.00')? '' : $('#agen_tiempo').val());
	    data.append('agen_mater', (document.getElementById('agen_mater').value=='' ? '' : document.getElementById('agen_mater').value));
	    data.append('agen_crit', (document.getElementById('agen_crit').value=='' ? '' : document.getElementById('agen_crit').value));
	    data.append('agen_indi', (document.getElementById('agen_indi').value=='' ? '' : document.getElementById('agen_indi').value));
	    data.append('agen_retr', (document.getElementById('agen_retr').value=='' ? '' : document.getElementById('agen_retr').value));
	    data.append('mater_codi', mater_codi);

		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				if(xhr.responseText=="OK"){
					$.growl.notice({ title: "Informacion: ",message: "¡Se agend&oacute; correctamente!" });
					$('#agen_nuev').modal('hide');
					agen_view(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,'A');
				}else{
					$.growl.error({ title: "Informacion: ",message: "Ocurri&oacute; un error al agendar" });
					agen_view(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,'A');
				}
			}
		}
		xhr.send(data);
	}
}
function agen_view(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,tipo)
{
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		var data = new FormData();
		data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
		data.append('curs_para_mate_codi', curs_para_mate_codi);
		data.append('tipo', tipo);
		data.append('opc', 'agen_view');
			
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   document.getElementById(div).innerHTML = xhr.responseText;
				$("#tbl_agenda_main_view").DataTable();
			}
		};
		xhr.send(data);
		
	
}
 
function agen_del(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,agen_codi)
{
	if (confirm("Esta seguro que desea Eliminar")) {
		
		url='script_agen.php';
		var data = new FormData();
		data.append('agen_codi', agen_codi);	
		data.append('opc', 'agen_del');
			
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				$.growl.notice({ title: "Informacion: ",message: "¡Se Elimino registro correctamente!" });
				agen_view(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,'T');
			} 
		}
		xhr.send(data);
	}	
	 
}

function carga_agenda(div,url,curs_para_mate_prof_codi)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
    data.append('opc', 'agen_view');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
    {   document.getElementById(div).innerHTML=xhr.responseText;
    }
    };
    xhr.send(data);

}
function refresh_modal_agenda(){
    $("#agen_fech_ini").val(obtener_fecha('hoy'));
    $("#agen_fech_fin").val(obtener_fecha('hoy'));
    $('#agen_titu').val('');
    $('#agen_deta').val('');
}
function cambiar_por_tipo(value){
	if(value==2)
    	$('#div_dynamic').show();
	else
        $('#div_dynamic').hide();
}

function comprobarObligatoriosAgenda(){
	if ($('#agen_titu').val().trim()=='')
	{	$('#agen_titu').closest('.form-group').addClass('has-error');
		$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el título de la agenda." });
		return false;
	}
	else
	{	$('#agen_titu').closest('.form-group').removeClass('has-error');
	}
	if ($('#agen_deta').val().trim()=='')
	{	$('#agen_deta').closest('.form-group').addClass('has-error');
		$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el detalle de la agenda." });
		return false;
	}
	else
	{	$('#agen_deta').closest('.form-group').removeClass('has-error');
	}
	return true;
}

function load_modal_content(div,agen_codi,curs_para_mate_codi,curs_para_mate_prof_codi){
    // document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
            document.getElementById('hd_agen_codi').value=agen_codi;
            $("#agen_fech_ini").datepicker();
            $("#agen_fech_fin").datepicker();
            $('.timepicker').timepicker({
                showInputs: false,
                showMeridian:false
            });
            $('#agen_tiempo').val('00:00');
			$('#agen_nuev').modal('show');
        }
    }
    var data="agen_codi="+agen_codi+"&curs_para_mate_codi="+curs_para_mate_codi+"&curs_para_mate_prof_codi="+curs_para_mate_prof_codi;
    xmlhttp.open("POST",'agenda_modal.php',true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);
}