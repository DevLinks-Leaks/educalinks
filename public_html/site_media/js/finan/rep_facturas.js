$(document).ready(function(){
    $("#txt_fecha_ini").datepicker();
    $("#txt_fecha_fin").datepicker();
	$(".boton_busqueda").click(function(){
		$("#desplegable_busqueda").slideToggle(200);
	});
	$("#desplegable_busqueda").show();
});
function js_rep_facturas_carga_reports_descuentos( div, url, evento )
{   var cajero = document.getElementById("cmb_usuario_cajero").value;
    var fecha_ini= document.getElementById('txt_fecha_ini').value;
    var fecha_fin= document.getElementById('txt_fecha_fin').value;
    url2=url+'?event='+evento+'&caja='+cajero+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin;
	window.open(url2);
    
	/*
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    $('#modal_edit').modal('show');
	var data = new FormData();
    
    data.append('event', 'printvisor');
    data.append('caja', cajero);
    data.append('fecha_ini', fecha_ini);
    data.append('fecha_fin', fecha_fin);
	
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);*/
}
function js_rep_facturas_excel( evento, tipo_reporte )
{   document.getElementById( 'evento' ).value = evento;
    document.getElementById( 'tipo_reporte' ).value = tipo_reporte;
    document.getElementById( 'file_form' ).submit();
}
function js_rep_facturas_check_opc_avanzadas()
{   var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
    if(ckb_opc_adv)
    {   $("#div_opc_adv").collapse(200).collapse('show');
    }
    else
    {   $("#div_opc_adv").collapse(200).collapse('hide');
    }
}
function js_rep_facturas_check_tneto()
{    var chk_tneto = document.getElementById("chk_tneto").checked;
    if(chk_tneto)
    {   document.getElementById("txt_tneto_ini").disabled = false;
        document.getElementById("txt_tneto_fin").disabled = false;
    }
    else
    {   document.getElementById("txt_tneto_ini").disabled = true;
        document.getElementById("txt_tneto_fin").disabled = true;
		document.getElementById("txt_tneto_ini").value = "";
        document.getElementById("txt_tneto_fin").value = "";
    }
}