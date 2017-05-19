function tipo_view(tipo)
{   // para indicar si debe ver los curso en la opciones
    if (tipo=='K')
        document.getElementById('mesn_curs_para_codi').style.display='none';
    else
        document.getElementById('mesn_curs_para_codi').style.display='block';
}

function mens_alert_upda()
{   var div='mens_alert';     
    var url='../framework/funciones_mensajes_script_new.php';
    var data='';    
    
    if (window.XMLHttpRequest)
        xml_mensaje=new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
    else
        xml_mensaje=new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
	
    xml_mensaje.onreadystatechange=function()
    {
        if ( xml_mensaje.readyState === 4 && xml_mensaje.status === 200 )
		{   document.getElementById(div).innerHTML=xml_mensaje.responseText;    
        }
    };
    xml_mensaje.open("POST",url,true);
    xml_mensaje.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xml_mensaje.send(data);
    
}

function carga_usua()
{   var tipo = selectvalue(document.getElementById("mens_usua_tipo"));
    //var tipo = e.options[e.selectedIndex].value;
    
    if (document.getElementById("mens_de_tipo").value == 'A')
    {   curs_para_codi=    document.getElementById("mens_curs_para_codi").value;
    }
    else
    {   var e = document.getElementById("mesn_curs_para_codi");
        if (e.selectedIndex ==  -1) curs_para_codi=0; 
        else var curs_para_codi = e.options[e.selectedIndex].value;
    }
    tipo_view(tipo);
    if (tipo=='A')             load_ajax('usua_mens','mensajes_nuevo_usua.php','OP=' + tipo + '&curs_para_codi=' + curs_para_codi);
    else if (tipo=='R')        load_ajax('usua_mens','mensajes_nuevo_usua.php','OP=' + tipo + '&curs_para_codi=' + curs_para_codi);
    else if (tipo=='D')        load_ajax('usua_mens','mensajes_nuevo_usua.php','OP=' + tipo + '&curs_para_codi=' + curs_para_codi);
    else if (tipo=='K')        load_ajax('usua_mens','mensajes_nuevo_usua.php','OP=' + tipo + '&curs_para_codi=' + curs_para_codi);
}


function validar_envio()
{   tipo = document.getElementById('mens_tipo').value;
    cc = document.getElementById('mens_cc_usua').value;
    
    if ( document.getElementById('mens_titu').value === '' )
    {   alert('Debe existir un Titulo en el mensaje');
        return false;
    }
    
    mm=0;
    i=1;
    
    while (i<=cc)
    {   if (document.getElementById('ch_'+ tipo + '_' + i) != null)
        {   if (document.getElementById('ch_'+ tipo + '_' + i).checked)
            {   mm+=1;             
            }
        } 
        i+=1;
    }
    if (mm==0)
    {    alert('No hay Usuarios seleccionado');
        return false;
    }
 
    if (CKEDITOR.instances.mens_deta.getData()==''){
        if (confirm("No hay texto en el detalle del mensaje, desea enviar de todas formas?")==false)  {
            return false;
        }
    }
    return true;   
}
function validar_envio_respuesta()
{   if (document.getElementById('mens_titu').value=='')
    {   alert('Debe existir un Titulo en el mensaje');
        return false;
    }
    if (CKEDITOR.instances.mens_deta.getData()=='')
    {   if (confirm("No hay texto en el detalle del mensaje, desea enviar de todas formas?")==false)  {
            return false;
        }
    }
    return true;
}
i_cc=1;
function envio_mensaje()
{   if (validar_envio())
    {   tipo = document.getElementById('mens_tipo').value;
        cc = document.getElementById('mens_cc_usua').value;
        
        var url='mensajes_nuevo_script_envio.php';
        
        mens_ok=0;
        mens_ko=0;
        mm=0;
        i=1;
        while (i<=cc)
        {   if (document.getElementById('ch_'+ tipo + '_' + i) != null)
            {   if (document.getElementById('ch_'+ tipo + '_' + i).checked)
                {   mm+=1;
                    var data = new FormData();
                    data.append('mens_de', document.getElementById('mens_de').value );
                    data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
                    data.append('mens_para', document.getElementById('ch_'+ tipo + '_' + i).value);
                    data.append('mens_para_tipo', tipo);
                    data.append('mens_titu', document.getElementById('mens_titu').value);
                    data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
                    data.append('DO','ADD');
                
                    var xhr_mensaje = new XMLHttpRequest();
                    xhr_mensaje.open('POST', url , true);
                    xhr_mensaje.onload = function () {
                        // do something to response
                        //console.log(this.responseText);
                    };
                    xhr_mensaje.onreadystatechange=function()
                    {   if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200)
                        {   //DO NOTHING:
                        }              
                    };
                    xhr_mensaje.send(data);
                }
            }
            i+=1;
        }    
        if (mm>0)
        {   $.growl.notice({ title: "Información: ",message: "Mensajes enviado: (" + mm +  ")"});    
            $('#nuev_mens').modal('hide');        
        }
    }
}
function envio_respuesta_mensaje(){   
    if (validar_envio_respuesta())
    {   var url='mensajes_nuevo_script_envio.php';
        
        var data = new FormData();
        data.append('mens_de', document.getElementById('mens_de').value );
        data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
        data.append('mens_para', document.getElementById('mens_para').value);
        data.append('mens_para_tipo', document.getElementById('mens_tipo').value);
        data.append('mens_titu', document.getElementById('mens_titu').value);
        data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
        data.append('DO','ADD');
        var xhr_mensaje = new XMLHttpRequest();
        xhr_mensaje.open('POST', url , true);
        xhr_mensaje.onload = function () {
            // do something to response
            //console.log(this.responseText);
        };
        xhr_mensaje.onreadystatechange=function(){
            if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200){
                
                $.growl.notice({ title: "Información: ",message: "Mensajes enviado"});    
                $('#responder_mens').modal('hide');                     
            }
        };
        xhr_mensaje.send(data);
    }
}
function envio_mensaje22()
{   if (validar_envio())
    {   tipo = document.getElementById('mens_tipo').value;
        cc = document.getElementById('mens_cc_usua').value;
        
        var url='mensajes_nuevo_script_envio.php';
        
        mens_ok=0;
        mens_ko=0;
        mm=0;
        i=1;
        
        while (i<=cc)
        {   if (document.getElementById('ch_'+ tipo + '_' + i) != null)
            {   if (document.getElementById('ch_'+ tipo + '_' + i).checked)
                {   mm+=1;
                    var data = new FormData();
                    data.append('mens_de' + '_'+ i, document.getElementById('mens_de').value );
                    data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
                    data.append('mens_para', document.getElementById('ch_'+ tipo + '_' + i).value);
                    data.append('mens_para_tipo', tipo);
                    data.append('mens_titu', document.getElementById('mens_titu').value);
                    data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
                    data.append('DO','ADD');
                
                    var xhr_mensaje = new XMLHttpRequest();
                    xhr_mensaje.open('POST', url , true);
                    xhr_mensaje.onload = function ()
					{   //console.log(this.responseText);
                    };
                    xhr_mensaje.onreadystatechange=function()
                    {   if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200)
                        {   //DO NOTHING:                
                        }              
                    };
                    xhr_mensaje.send(data);
                }
            }
            i+=1;
        }
        if (mm>0)
        {   $.growl.notice({ title: "Educalinks informa", message: "Mensajes enviados: (" + mm +  ")"});    
            $('#nuev_mens').modal('hide');        
        }
    }
}
function elimina_mensaje( mens_codi )
{   document.getElementById('hd_del_mes_codi').value = mens_codi;
	$('#modal_del_sms').modal("show");
}
function elimina_mensaje_followed( )
{   url='mensajes_nuevo_script_envio.php';
	var data = new FormData();
	data.append('mens_codi', document.getElementById('hd_del_mes_codi').value );
	data.append('op', document.getElementById('hd_op').value );
	data.append('DO', 'DEL' );
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onload = function ()
	{   //console.log(this.responseText);
	};
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   $.growl.notice({ title: "Educalinks informa ",message: "Mensaje eliminado"});
			$('#modal_del_sms').modal("hide");
			mensaje_view( document.getElementById('hd_op').value );
		}
	};
	xhr.send(data);
}
/*function js_mensajes_delete_all_sms ()
{	if ( confirm( "¿Está seguro que desea eliminar todos los mensajes seleccionados?" ) )
    {   
		checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
		var mensajes=[];
		var mensajes = 0;
		for(var i = 0, n = checkboxes.length; i < n; i++ )
		{   if ( checkboxes[i].checked )
			{   mensajes.push(checkboxes[i].value);
				bandera++;
			}
		}
		console.log(mensajes);
		var data = new FormData();
		data.append('opc','delete_all');
	
		var xhr_mensaje = new XMLHttpRequest();
		xhr_mensaje.open('POST', 'script_mens_view.php' , true);
		xhr_mensaje.onload = function ()
		{   console.log(this.responseText);
		};
		xhr_mensaje.onreadystatechange=function()
		{   if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200)
			{   //DO NOTHING:                
			}
		};
		xhr_mensaje.send(data);
	}
}*/
function lista_mensajes()
{   document.getElementById('mens_main_info').style.display = 'none';
}
function mensaje_maximizar()
{   document.getElementById('mens_main_view').style.display = 'none';
    document.getElementById('mens_main_info').style.display = 'block';
    document.getElementById('mens_main_info').width='100%';
}
function mensaje_view(op)
{   if(op==3 || op==4)
        load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=' + op,5);
    else
        load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=' + op,4);
}
function select_todos_check(che_val)
{   cc=document.getElementById('mens_cc_usua').value;    
    op=document.getElementById('mens_tipo').value;
    
    for (i=1;i<=cc;i++)
    {   var input_view = document.getElementsByName('ch_' + op + '_' + i);
        if (input_view.length >0 )
        {   document.getElementById('ch_' + op + '_' + i).checked = che_val.checked;
        }    
    }
}
///////////////////INICIO DE FUNCIONES //////////////////////
//var Mensaje_timer=setInterval(function () {mens_alert_upda()}, 120000);