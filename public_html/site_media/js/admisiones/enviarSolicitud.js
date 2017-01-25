// Consulta filtrada
function js_enviarSolicitud_nueva()//nombre sin usar, está libre, usable, etc.
{   document.getElementById('div_opciones_principales').style.display = 'none';
    document.getElementById('div_formulario_solicitud').style.display = 'block';
}//
function js_enviarSolicitud_continuar()
{   document.getElementById('div_opciones_principales').style.display = 'none';
    document.getElementById('div_continuar_solicitud').style.display = 'block';
}
function js_enviarSolicitud_get_solicitud( url )
{   var id_solicitud = document.getElementById('txt_id_solicitud').value;
    document.getElementById('formulario_continuar_solicitud').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event' , 'get_solicitud_especifica' );
    data.append( 'id_solicitud' , id_solicitud );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( 'formulario_continuar_solicitud' ).innerHTML = xhr.responseText;
            $("#per_fecha_nac").datepicker();
        }
    };
    xhr.send(data);
}
function js_get_solicitud_enviado( url, id_solicitud )
{   document.getElementById('formulario_continuar_solicitud').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event' , 'get_solicitud_especifica' );
    data.append( 'id_solicitud' , id_solicitud );    
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( 'formulario_continuar_solicitud' ).innerHTML = xhr.responseText;
            document.getElementById('div_opciones_principales').style.display = 'none';
            document.getElementById('div_formulario_solicitud').style.display = 'none';
            document.getElementById('div_continuar_solicitud').style.display = 'block';
        }
    };
    xhr.send(data);
}
function js_enviarSolicitud_enviar(url)
{   if( document.getElementById('hd_num_doc_up') )
    {   var id_solicitud = document.getElementById('hd_id_solicitud').value;
        var soli_estado = document.getElementById('hd_soli_estado').value;
        var num_doc = document.getElementById('hd_num_doc').value;
        var num_doc_up = document.getElementById('hd_num_doc_up').value;
        document.getElementById('send_id').innerHTML = id_solicitud;
        document.getElementById('send_ea').innerHTML = soli_estado;
        document.getElementById('send_dr').innerHTML = num_doc;
        document.getElementById('send_ds').innerHTML = num_doc_up;
        $('#modal_enviar_solicitud').modal('show');
    }else
    {   //jAlert('Para poder enviar una solicitud, debe guardar los cambios, primero', 'Educalinks Admisiones');
        alert("Para poder enviar una solicitud, debe guardar los cambios, primero.");
    }
}
function js_enviarSolicitud_enviar_followed(url)
{   if ( confirm( "¿Está seguro de enviar la solicitud ahora? Una vez enviado, no podrá modificar ningún dato." ) )
    {   var id_solicitud = document.getElementById('hd_id_solicitud').value;
        var data = new FormData();
        data.append('event' , 'send');
        data.append('id_solicitud' , id_solicitud);
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , url , true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   $('#modal_enviar_solicitud').modal('hide');
                obj = JSON.parse(xhr.responseText);//3 ABRIL 2016
                if( obj['MENSAJE'] )
                {   var n = obj['MENSAJE'].length;
                    if ( n > 0 )
                    {   valida_tipo_growl(obj['MENSAJE']);
                        document.getElementById('hd_per_codi').value = obj['PER_CODI'];
                    }
                    else
                    {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                    }    
                }
                js_get_solicitud_enviado( url, id_solicitud );
            }
        };
        xhr.send(data);    
    }
}
function js_enviarSolicitud_carga_formulario( id_solicitud, estudiante_per_codi, div, url, deband ) //se llama desde el case 'GET_SOLICITUD_ESPECIFICA' del controller de 'enviarSolicitud'.
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event' , 'form_continue' );
    data.append( 'deband' , deband );
    data.append( 'id_solicitud' , id_solicitud );
    data.append( 'estudiante_per_codi' , estudiante_per_codi );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , url , true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML = xhr.responseText;
            document.getElementById(div).style.display = 'block';
            document.getElementById('div_opciones_principales').style.display = 'none';
            document.getElementById('div_continuar_solicitud').style.display = 'none';
            $("#per_fecha_nac").datepicker();
            $("#per_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            
            $("#repr1_fecha_nac").datepicker();
            $("#repr1_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            
            $("#repr2_fecha_nac").datepicker();
            $("#repr2_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //qwe div de repr ponerlo none en php, y ponerlo block aquí.
			/*$("#per_email_personal").inputmask({
				mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
				greedy: false,
				onBeforePaste: function (pastedValue, opts) {
					pastedValue = pastedValue.toLowerCase();
					return pastedValue.replace("mailto:", "");
				},
				definitions: {
				  '*': {
					validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
					cardinality: 1,
					casing: "lower"
				  }
				}
			});*/
        }
    };
    xhr.send(data);
}
function js_enviarSolicitud_validate_email( span_object ) {
    var email = document.getElementById('per_email_personal').value;

    var emailFilter = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var phoneFilter = /^http:\/\//;

    if (!emailFilter.test(email)) {
		document.getElementById( span_object ).innerHTML = '* Por favor, ingrese una cuenta de correo electrónico válida.';
        return false;
    }
	else
		document.getElementById( span_object ).innerHTML = '';
    return true;
}
function js_enviarSolicitud_get_formulario_nuevo( url )
{   document.getElementById('div_formulario_solicitud').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event' , 'form');
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   if (xhr.responseText.length > 0)
            {   document.getElementById('div_formulario_solicitud').innerHTML = xhr.responseText;
                document.getElementById('div_formulario_solicitud').style.display = 'block';
                document.getElementById('div_opciones_principales').style.display = 'none';
                $("#per_fecha_nac").datepicker();
                $("#per_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                
                $("#repr1_fecha_nac").datepicker();
                $("#repr1_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                
                $("#repr2_fecha_nac").datepicker();
                $("#repr2_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            }
            else
            {   document.getElementById('div_formulario_solicitud').innerHTML = "Hubo un error con su solicitud al sistema. Por favor intente de nuevo.";
                document.getElementById('div_formulario_solicitud').style.display = 'block';
            }
        }
    };
    xhr.send(data);
}
function js_enviarSolicitud_colegio_no_encontrado( checked )
{   if( checked )
    {   document.getElementById( 'per_col_anterior' ).disabled = false;
    }
    else
    {   document.getElementById( 'per_col_anterior' ).disabled = true;
        document.getElementById( 'per_col_anterior' ).value = "";
    }
}
function js_enviarSolicitud_tiene_hermanos_en_colegio( checked )
{   if( checked )
    {   document.getElementById( 'per_tiene_hermanos_en_colegio' ).disabled = false;
    }
    else
    {   document.getElementById( 'per_tiene_hermanos_en_colegio' ).disabled = true;
        document.getElementById( 'per_tiene_hermanos_en_colegio' ).value = "";
    }
}
function js_enviarSolicitud_tiene_familiares_en_colegio( checked )
{   if( checked )
    {   document.getElementById( 'per_tiene_familiares_en_colegio' ).disabled = false;
    }
    else
    {   document.getElementById( 'per_tiene_familiares_en_colegio' ).disabled = true;
        document.getElementById( 'per_tiene_familiares_en_colegio' ).value = "";
    }
}
function js_enviarSolicitud_preadmision_anterior( checked )
{   if( checked )
    {   document.getElementById( 'cmb_per_preadmision_anterior' ).disabled = false;
    }
    else
    {   document.getElementById( 'cmb_per_preadmision_anterior' ).disabled = true;
        document.getElementById( 'cmb_per_preadmision_anterior' ).value = "";
    }
}
function js_enviarSolicitud_sector_change()
{   if( document.getElementById( 'cmb_sector_residencia' ).value === 'FUERA PAIS' )
        document.getElementById( 'per_sector_residencia_fuera' ).disabled = false;
    else
    {   document.getElementById( 'per_sector_residencia_fuera' ).disabled = true;
        document.getElementById( 'per_sector_residencia_fuera' ).value = "";    
    }
}
function js_enviarSolicitud_direccion_igual_a_postulante( obj )
{   var nombre = obj.attributes["id"].value;
    //funciona con nombres como 'ckb_repr1_per_dir_igual': pasa por 'ckb_' y toma los sgtes valores hasta el sgte '_'.
    //El nombre del objeto que se pasa no debe tener subguiones en la parte que se corta. ej: 'repr1' es aceptable, 'repr_1' no.
    var subnombre = nombre.split("_"); 
    if( !obj.checked )
    {   document.getElementById( subnombre[ 1 ] + '_dir' ).disabled = false;
        document.getElementById( subnombre[ 1 ] + '_telf' ).disabled = false;
    }
    else
    {   document.getElementById( subnombre[ 1 ] + '_dir' ).disabled = true;
        document.getElementById( subnombre[ 1 ] + '_telf' ).disabled = true;
        document.getElementById( subnombre[ 1 ] + '_dir' ).value = "";
        document.getElementById( subnombre[ 1 ] + '_telf' ).value = "";
    }
}
function js_enviarSolicitud_es_exalumno( obj )
{   var nombre = obj.attributes[ "id" ].value;
    var subnombre = nombre.split( "_" ); 
    if( obj.checked )
    {   document.getElementById( subnombre[ 1 ] + '_cmb_es_exalumno' ).disabled = false;
    }
    else
    {   document.getElementById( subnombre[ 1 ] + '_cmb_es_exalumno' ).disabled = true;
        document.getElementById( subnombre[ 1 ] + '_cmb_es_exalumno' ).value = "";
    }
}
function js_enviarSolicitud_es_extrabajador( obj )
{   var nombre = obj.attributes[ "id" ].value;
    var subnombre = nombre.split( "_" ); 
    if( obj.checked )
    {   document.getElementById( subnombre[ 1 ] + '_es_extrabajador_fecha_ini' ).disabled = false;
        document.getElementById( subnombre[ 1 ] + '_es_extrabajador_fecha_fin' ).disabled = false;
    }
    else
    {   document.getElementById( subnombre[ 1 ] + '_es_extrabajador_fecha_ini' ).disabled = true;
        document.getElementById( subnombre[ 1 ] + '_es_extrabajador_fecha_fin' ).disabled = true;
        document.getElementById( subnombre[ 1 ] + '_es_extrabajador_fecha_ini' ).value = "";
        document.getElementById( subnombre[ 1 ] + '_es_extrabajador_fecha_fin' ).value = "";
    }
}
function js_enviarSolicitud_guarda_formulario(url)
{     document.getElementById('modal_wait_body').innerHTML = '<div align="center" style="height:100%;">' + 
        'Por favor, espere<br><br><i style="color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        $('#modal_wait').modal('show');
        var data = new FormData();
        var alright = true;
        if ( document.getElementById('hd_main_soli_estado') )
        {   data.append('soli_estado' , document.getElementById('hd_main_soli_estado').value );
        }
        else if( document.getElementById('hd_soli_estado') )
        {   data.append('soli_estado' , document.getElementById('hd_soli_estado').value );
        }
        data.append('id_solicitud' , document.getElementById('hd_id_solicitud').value );
        data.append('per_codi' , document.getElementById('hd_per_codi').value );
        data.append('repr1_codi' , document.getElementById('repr1_codi').value );
        data.append('repr2_codi' , document.getElementById('repr2_codi').value );
        if ( document.getElementById('repr3_codi') )
        {   data.append('repr3_codi' , document.getElementById('repr3_codi').value );
        }
        if ( document.getElementById('repr4_codi') )
        {   data.append('repr4_codi' , document.getElementById('repr4_codi').value );
        }
        data.append('event' , 'form_save');
        /* INICIO DE FORMULARIO PARA PERSONA POSTULANTE COMO ESTUDIANTE DEL COLEGIO*/
        var soli_foto = document.getElementById( 'per_soli_foto' ).files[0];
        data.append( 'soli_foto', soli_foto );
        data.append( 'cmb_per_tipo_identificacion' , document.getElementById('cmb_per_tipo_identificacion').value );
        data.append( 'per_numero_identificacion' , document.getElementById('per_numero_identificacion').value );
        data.append( 'per_nomb' , document.getElementById('per_nomb').value );
        data.append( 'per_nomb_seg' , document.getElementById('per_nomb_seg').value );
        data.append( 'per_apel' , document.getElementById('per_apel').value );
        data.append( 'per_apel_mat' , document.getElementById('per_apel_mat').value );
        data.append( 'per_dir' , document.getElementById('per_dir').value );
        data.append( 'per_telf' , document.getElementById('per_telf').value );
        
        data.append( 'cmb_sector_residencia' , document.getElementById('cmb_sector_residencia').value );
        data.append( 'per_sector_residencia_fuera' , document.getElementById('per_sector_residencia_fuera').value );
        
        data.append( 'per_fecha_nac' , document.getElementById('per_fecha_nac').value );
        data.append( 'per_rdb_genero' , document.querySelector('input[id="per_rdb_genero"]:checked').value );
        data.append( 'per_email_personal' , document.getElementById('per_email_personal').value );
        data.append( 'cmb_pais_per_lugar_nac' , document.getElementById('cmb_pais_per_lugar_nac').value );
        data.append( 'cmb_provincia_per_lugar_nac' , document.getElementById('cmb_provincia_per_lugar_nac').value );
        data.append( 'cmb_ciudad_per_lugar_nac' , document.getElementById('cmb_ciudad_per_lugar_nac').value );
        
        data.append( 'cmb_curso_aplica' , document.getElementById('cmb_curso_aplica').value );
        data.append( 'cmb_pais_colegio_anterior' , document.getElementById('cmb_pais_colegio_anterior').value );
        data.append( 'cmb_provincia_colegio_anterior' , document.getElementById('cmb_provincia_colegio_anterior').value );
        data.append( 'cmb_ciudad_colegio_anterior' , document.getElementById('cmb_ciudad_colegio_anterior').value );
        data.append( 'cmb_colegio_anterior' , document.getElementById('cmb_colegio_anterior').value );
        data.append( 'ckb_colegio_no_encontrado' , document.getElementById('ckb_colegio_no_encontrado').checked );
        data.append( 'per_col_anterior' , document.getElementById('per_col_anterior').value );
        data.append( 'per_col_anterior_dir' , document.getElementById('per_col_anterior_dir').value );
        data.append( 'per_num_hermanos' , document.getElementById('per_num_hermanos').value );
        data.append( 'ckb_tiene_hermanos_en_colegio' , document.getElementById('ckb_tiene_hermanos_en_colegio').checked );
        data.append( 'per_tiene_hermanos_en_colegio' , document.getElementById('per_tiene_hermanos_en_colegio').value );
        data.append( 'ckb_tiene_familiares_en_colegio' , document.getElementById('ckb_tiene_familiares_en_colegio').checked );
        data.append( 'per_tiene_familiares_en_colegio' , document.getElementById('per_tiene_familiares_en_colegio').value );
        data.append( 'per_con_quien_vive' , document.getElementById('per_con_quien_vive').value );
        data.append( 'ckb_preadmision_anterior' , document.getElementById('ckb_preadmision_anterior').checked );
        data.append( 'cmb_per_preadmision_anterior' , document.getElementById('cmb_per_preadmision_anterior').value );
        data.append( 'ckb_matriculado_anteriormente' , document.getElementById('ckb_matriculado_anteriormente').checked );
        data.append( 'ckb_pruebas_psicologicas' , document.getElementById('ckb_pruebas_psicologicas').checked );
        data.append( 'per_vive_casa' , document.getElementById('per_vive_casa').value );
        data.append( 'per_tiempo_residencia' , document.getElementById('per_tiempo_residencia').value );
        data.append( 'per_como_se_entero' , document.getElementById('per_como_se_entero').value );
        /* FIN DE DATOS DE POSTULANTE COMO ESTUDIANTE DEL COLEGIO*/
        
        /* INICIO DE FORMULARIO PARA REPRESENTANTE 'PADRE' */
        data.append( 'cmb_repr1_tipo_identificacion' , document.getElementById('cmb_repr1_tipo_identificacion').value );
        data.append( 'repr1_numero_identificacion' , document.getElementById('repr1_numero_identificacion').value );
        data.append( 'repr1_nomb' , document.getElementById('repr1_nomb').value );
        data.append( 'repr1_nomb_seg' , document.getElementById('repr1_nomb_seg').value );
        data.append( 'repr1_apel' , document.getElementById('repr1_apel').value );
        data.append( 'repr1_apel_mat' , document.getElementById('repr1_apel_mat').value );
        data.append( 'ckb_repr1_per_dir_igual' , document.getElementById('ckb_repr1_per_dir_igual').checked );
        data.append( 'repr1_dir' , document.getElementById('repr1_dir').value );
        data.append( 'repr1_telf' , document.getElementById('repr1_telf').value );
        data.append( 'repr1_email_personal' , document.getElementById('repr1_email_personal').value );
        data.append( 'repr1_fecha_nac' , document.getElementById('repr1_fecha_nac').value );
        data.append( 'cmb_pais_repr1_lugar_nac' , document.getElementById('cmb_pais_repr1_lugar_nac').value );
        data.append( 'cmb_provincia_repr1_lugar_nac' , document.getElementById('cmb_provincia_repr1_lugar_nac').value );
        data.append( 'cmb_ciudad_repr1_lugar_nac' , document.getElementById('cmb_ciudad_repr1_lugar_nac').value );
        data.append( 'cmb_estado_civil_repr1' , document.getElementById('cmb_estado_civil_repr1').value );
        data.append( 'cmb_profesion_repr1' , document.getElementById('cmb_profesion_repr1').value );
        
        data.append( 'repr1_empr_codi' , document.getElementById('repr1_empr_codi').value );
        data.append( 'repr1_per_empr_codi' , document.getElementById('repr1_per_empr_codi').value );
        data.append( 'repr1_empr_nomb' , document.getElementById('repr1_empr_nomb').value );
        data.append( 'repr1_empr_ruc' , document.getElementById('repr1_empr_ruc').value );
        data.append( 'repr1_empr_dir' , document.getElementById('repr1_empr_dir').value );
        data.append( 'repr1_empr_cargo' , document.getElementById('repr1_empr_cargo').value );
        data.append( 'repr1_empr_ingreso_mensual' , document.getElementById('repr1_empr_ingreso_mensual').value );
        data.append( 'repr1_empr_telf' , document.getElementById('repr1_empr_telf').value );
        data.append( 'repr1_empr_mail' , document.getElementById('repr1_empr_mail').value );
                    
        data.append( 'ckb_repr1_es_exalumno' , document.getElementById('ckb_repr1_es_exalumno').checked );
        data.append( 'repr1_cmb_es_exalumno' , document.getElementById('repr1_cmb_es_exalumno').value );
        data.append( 'ckb_repr1_es_extrabajador' , document.getElementById('ckb_repr1_es_extrabajador').checked );
        data.append( 'repr1_es_extrabajador_fecha_ini' , document.getElementById('repr1_es_extrabajador_fecha_ini').value );
        data.append( 'repr1_es_extrabajador_fecha_fin' , document.getElementById('repr1_es_extrabajador_fecha_fin').value );
        /* FIN DE DATOS DE REPRESENTANTE 'PADRE'*/
        
        /* INICIO DE FORMULARIO PARA REPRESENTANTE 'MADRE' */
        data.append( 'cmb_repr2_tipo_identificacion' , document.getElementById('cmb_repr2_tipo_identificacion').value );
        data.append( 'repr2_numero_identificacion' , document.getElementById('repr2_numero_identificacion').value );
        data.append( 'repr2_nomb' , document.getElementById('repr2_nomb').value );
        data.append( 'repr2_nomb_seg' , document.getElementById('repr2_nomb_seg').value );
        data.append( 'repr2_apel' , document.getElementById('repr2_apel').value );
        data.append( 'repr2_apel_mat' , document.getElementById('repr2_apel_mat').value );
        data.append( 'ckb_repr2_per_dir_igual' , document.getElementById('ckb_repr2_per_dir_igual').checked );
        data.append( 'repr2_dir' , document.getElementById('repr2_dir').value );
        data.append( 'repr2_telf' , document.getElementById('repr2_telf').value );
        data.append( 'repr2_email_personal' , document.getElementById('repr2_email_personal').value );
        data.append( 'repr2_fecha_nac' , document.getElementById('repr2_fecha_nac').value );
        data.append( 'cmb_pais_repr2_lugar_nac' , document.getElementById('cmb_pais_repr2_lugar_nac').value );
        data.append( 'cmb_provincia_repr2_lugar_nac' , document.getElementById('cmb_provincia_repr2_lugar_nac').value );
        data.append( 'cmb_ciudad_repr2_lugar_nac' , document.getElementById('cmb_ciudad_repr2_lugar_nac').value );
        data.append( 'cmb_estado_civil_repr2' , document.getElementById('cmb_estado_civil_repr2').value );
        data.append( 'cmb_profesion_repr2' , document.getElementById('cmb_profesion_repr2').value );
                    
        data.append( 'repr2_empr_codi' , document.getElementById('repr2_empr_codi').value );
        data.append( 'repr2_per_empr_codi' , document.getElementById('repr2_per_empr_codi').value );
        data.append( 'repr2_empr_nomb' , document.getElementById('repr2_empr_nomb').value );
        data.append( 'repr2_empr_ruc' , document.getElementById('repr2_empr_ruc').value );
        data.append( 'repr2_empr_dir' , document.getElementById('repr2_empr_dir').value );
        data.append( 'repr2_empr_cargo' , document.getElementById('repr2_empr_cargo').value );
        data.append( 'repr2_empr_ingreso_mensual' , document.getElementById('repr2_empr_ingreso_mensual').value );
        data.append( 'repr2_empr_telf' , document.getElementById('repr2_empr_telf').value );
        data.append( 'repr2_empr_mail' , document.getElementById('repr2_empr_mail').value );
                    
        data.append( 'ckb_repr2_es_exalumno' , document.getElementById('ckb_repr2_es_exalumno').checked );
        data.append( 'repr2_cmb_es_exalumno' , document.getElementById('repr2_cmb_es_exalumno').value );
        data.append( 'ckb_repr2_es_extrabajador' , document.getElementById('ckb_repr2_es_extrabajador').checked );
        data.append( 'repr2_es_extrabajador_fecha_ini' , document.getElementById('repr2_es_extrabajador_fecha_ini').value );
        data.append( 'repr2_es_extrabajador_fecha_fin' , document.getElementById('repr2_es_extrabajador_fecha_fin').value );
        /* FIN DE DATOS DE REPRESENTANTE 'MADRE'*/
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState==4 && xhr.status==200)
            {   //alert(xhr.responseText);
                //$('#modal_wait').modal('hide');
                obj = JSON.parse(xhr.responseText);
                if( obj['MENSAJE'] )
                {   var n = obj['MENSAJE'].length;
                    if ( n > 0 )
                    {   js_enviarSolicitud_valida_tipo_growl_jc(obj['MENSAJE']);
                        document.getElementById('hd_per_codi').value = obj['PER_CODI'];
                        if( document.getElementById('hd_soli_estado').value === '' )
                            document.getElementById('hd_soli_estado').value = 'GUARDADA';
                    }
                    else
                    {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                        alright = false;
                    }    
                }
                else
                {   $.growl.error({ title: "Educalinks informa:",message: "Hubo un error al tratar de guardar los datos de la solicitud." });
                    alright = false;
                }
                if( obj['REPR1_MENSAJE'] )
                {   var n = obj['REPR1_MENSAJE'].length;
                    if ( n > 0 )
                    {   js_enviarSolicitud_valida_tipo_growl_jc(obj['REPR1_MENSAJE']);
                        document.getElementById('repr1_codi').value = obj['REPR1_CODI'];
                        document.getElementById('repr1_empr_codi').value = obj['REPR1_EMPR_CODI'];
                        document.getElementById('repr1_per_empr_codi').value = obj['REPR1_PER_EMPR_CODI'];
                    }
                    else
                    {   //$.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                        alright = false;
                    }
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "No ha ingresado datos del padre." });
                    alright = false;
                }
                if( obj['REPR2_MENSAJE'] )
                {   var n = obj['REPR2_MENSAJE'].length;
                    if ( n > 0 )
                    {   js_enviarSolicitud_valida_tipo_growl_jc(obj['REPR2_MENSAJE']);
                        document.getElementById('repr2_codi').value = obj['REPR2_CODI'];
                        document.getElementById('repr2_empr_codi').value = obj['REPR2_EMPR_CODI'];
                        document.getElementById('repr2_per_empr_codi').value = obj['REPR2_PER_EMPR_CODI'];
                    }
                    else
                    {   //$.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                        alright = false;
                    }    
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "No ha ingresado datos de la madre." });
                    alright = false;
                }
                document.getElementById('hd_id_solicitud').value = obj['ID_SOLICITUD'];
                var mensaje_final = "";
                if( alright )
                {   mensaje_final = "Sus datos fueron guardaros correctamente. Por favor, anote el código de su solicitud para poder entrar posteriormente al sistema a consultar sus datos. SU CÓDIGO DE SOLICITUD ES: <b>" + obj['ID_SOLICITUD'] + "</b>";
                }else
                {   mensaje_final = "Por favor, revisar su solicitud. No todos sus datos fueron ingresados correctamente. (Código de solicitud: <b>" + obj['ID_SOLICITUD'] + "</b>)";
                }
                document.getElementById('modal_wait_body').innerHTML =
                '<div align="center" style="height:100%;">' + mensaje_final +
                '<br><br><button type="button" onclick=\'$("#modal_wait").modal("hide");\'>Ocultar</button></div>';
                $("#repr1_fecha_nac").datepicker();
                $("#repr1_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                
                $("#repr2_fecha_nac").datepicker();
                $("#repr2_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            }
        };
        xhr.send(data);
}
function js_enviarSolicitud_guarda_formulario_repr( url )
{   var data = new FormData( );
    data.append( 'event' , 'set_repr_especifico' );
    data.append( 'id_solicitud' , document.getElementById('hd_id_solicitud').value );
    data.append( 'per_codi' , document.getElementById('hd_per_codi').value );
    data.append( 'repr3_codi' , document.getElementById('repr3_codi').value );
    data.append( 'cmb_persona_relacion' , document.getElementById('cmb_persona_relacion').value );
    data.append( 'cmb_repr3_tipo_identificacion' , document.getElementById('cmb_repr3_tipo_identificacion').value );
    data.append( 'repr3_numero_identificacion' , document.getElementById('repr3_numero_identificacion').value );
    data.append( 'repr3_nomb' , document.getElementById('repr3_nomb').value );
    data.append( 'repr3_nomb_seg' , document.getElementById('repr3_nomb_seg').value );
    data.append( 'repr3_apel' , document.getElementById('repr3_apel').value );
    data.append( 'repr3_apel_mat' , document.getElementById('repr3_apel_mat').value );
    data.append( 'ckb_repr3_per_dir_igual' , document.getElementById('ckb_repr3_per_dir_igual').checked );
    if( document.getElementById('ckb_repr3_per_dir_igual').checked )
    {   data.append( 'repr3_dir' , document.getElementById('per_dir').value );
        data.append( 'repr3_telf' , document.getElementById('per_telf').value );
    }
    else
    {   data.append( 'repr3_dir' , document.getElementById('repr3_dir').value );
        data.append( 'repr3_telf' , document.getElementById('repr3_telf').value );
    }
    data.append( 'repr3_email_personal' , document.getElementById('repr3_email_personal').value );
    data.append( 'repr3_fecha_nac' , document.getElementById('repr3_fecha_nac').value );
    data.append( 'cmb_pais_repr3_lugar_nac' , document.getElementById('cmb_pais_repr3_lugar_nac').value );
    data.append( 'cmb_provincia_repr3_lugar_nac' , document.getElementById('cmb_provincia_repr3_lugar_nac').value );
    data.append( 'cmb_ciudad_repr3_lugar_nac' , document.getElementById('cmb_ciudad_repr3_lugar_nac').value );
    data.append( 'cmb_estado_civil_repr3' , document.getElementById('cmb_estado_civil_repr3').value );
    data.append( 'cmb_profesion_repr3' , document.getElementById('cmb_profesion_repr3').value );
    
    data.append( 'repr3_empr_codi' , document.getElementById('repr3_empr_codi').value );
    data.append( 'repr3_per_empr_codi' , document.getElementById('repr3_per_empr_codi').value );
    data.append( 'repr3_empr_nomb' , document.getElementById('repr3_empr_nomb').value );
    data.append( 'repr3_empr_ruc' , document.getElementById('repr3_empr_ruc').value );
    data.append( 'repr3_empr_dir' , document.getElementById('repr3_empr_dir').value );
    data.append( 'repr3_empr_cargo' , document.getElementById('repr3_empr_cargo').value );
    data.append( 'repr3_empr_ingreso_mensual' , document.getElementById('repr3_empr_ingreso_mensual').value );
    data.append( 'repr3_empr_telf' , document.getElementById('repr3_empr_telf').value );
    data.append( 'repr3_empr_mail' , document.getElementById('repr3_empr_mail').value );
                
    data.append( 'ckb_repr3_es_exalumno' , document.getElementById('ckb_repr3_es_exalumno').checked );
    data.append( 'repr3_cmb_es_exalumno' , document.getElementById('repr3_cmb_es_exalumno').value );
    data.append( 'ckb_repr3_es_extrabajador' , document.getElementById('ckb_repr3_es_extrabajador').checked );
    data.append( 'repr3_es_extrabajador_fecha_ini' , document.getElementById('repr3_es_extrabajador_fecha_ini').value );
    data.append( 'repr3_es_extrabajador_fecha_fin' , document.getElementById('repr3_es_extrabajador_fecha_fin').value );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   obj = JSON.parse(xhr.responseText);
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl(obj['MENSAJE']);
                js_representantes_get_representantes( document.getElementById('hd_per_codi').value, 'div_representantes_principales', document.getElementById('ruta_html_common').value + '/representantes/controller.php', 'off' );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
            }
        }
    };
    xhr.send(data);
}
function js_enviarSolicitud_add_repr( url )
{   document.getElementById('modal_add_repr_body').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    var id_solicitud = document.getElementById('hd_id_solicitud').value;
    data.append( 'event' , 'form_repr' );
    data.append( 'reprX' , 'repr3' );
    data.append( 'id_solicitud' , id_solicitud );
    //data.append( 'repr_codi' , repr_codi );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById('modal_add_repr_body').innerHTML = xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_enviarSolicitud_editar_datos_admision( alum_codi, repr_codi, modal, url )
{   document.getElementById('modal_add_repr_body').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event' , 'get_repr_especifico' );
    data.append( 'reprX' , 'repr3' );
    data.append( 'alum_codi' , alum_codi );
    data.append( 'repr_codi' , repr_codi );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( modal ).innerHTML = xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_enviarSolicitud_valida_tipo_growl_jc(str)
{   "use strict";
    var str1 =  str;
    var wordsToFind = ["¡exito!", "*¡exito!*"];
    if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   str = str.replace("¡Exito!", "");
        //$.growl.notice({ title: "Educalinks informa", message: str});
        //no hace nada.
    }
    else
    {   wordsToFind = ["¡error!", "*¡error!*"];
        if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
        {   str = str.replace("¡Error!", "");
            $.growl.error({ title: "Educalinks informa", message: str});
        }
        else
        {   wordsToFind = ["¡advertencia!", "*¡advertencia!*"];
            if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
            {   str = str.replace("¡Advertencia!", "");
                $.growl.warning({ title: "Educalinks informa", message: str});
            }
            else
            {   $.growl({ title: "Educalinks informa", message: str});
            }
        }
    }
}
function vali_email(url,value,span_msj)
{   var data = new FormData();
	data.append('event' , 'validate_email');
	data.append('value' , value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{  obj = JSON.parse(xhr.responseText);
			if( obj.result=="success" )
			{	$('#'+span_msj).attr('style','color: green;');
			}
			else
			{	$('#'+span_msj).attr('style','color: red;');
			}
			document.getElementById(span_msj).innerHTML=obj.message;
		}
	};
	xhr.send(data);
}
function vali_identificacion(url,tipo,value,span_msj)
{   var data = new FormData();
	data.append('event' , 'validate_id');
	data.append('value' ,value);
	data.append('type' ,tipo);
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{  obj = JSON.parse(xhr.responseText);
			if( obj.result=="success" )
			{	$('#'+span_msj).attr('style','color: green;');
			}
			else
			{	$('#'+span_msj).attr('style','color: red;');
			}
			document.getElementById(span_msj).innerHTML=obj.message;
		}
	};
	xhr.send(data);
}
function vali_esnumerico(url,value,span_msj)
{   var data = new FormData();
	data.append('event' , 'validate_isnumeric');
	data.append('value' , value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{  obj = JSON.parse(xhr.responseText);
			if( obj.result=="success" )
			{	$('#'+span_msj).attr('style','color: green;');
			}
			else
			{	$('#'+span_msj).attr('style','color: red;');
			}
			document.getElementById(span_msj).innerHTML=obj.message;
		}
	};
	xhr.send(data);
}
function validarFormAspirante (ruta_html_admisiones)
{	if ($('#per_numero_identificacion').val().trim()=="")
	{	alert ("Ingrese el número de identificación del aspirante");
		$('#per_numero_identificacion').closest('.error').addClass('has-error');
		$('#per_numero_identificacion').focus();
		return false;
	}
	else
	{	$('#per_numero_identificacion').closest('.error').removeClass('has-error');
	}
	if ($('#per_nomb').val().trim()=="")
	{	alert ("Ingrese el primer nombre del aspirante");
		$('#per_nomb').closest('.error').addClass('has-error');
		$('#per_nomb').focus();
		return false;
	}
	else
	{	$('#per_nomb').closest('.error').removeClass('has-error');
	}
	if ($('#per_apel').val().trim()=="")
	{	alert ("Ingrese el primer apellido del aspirante");
		$('#per_apel').closest('.error').addClass('has-error');
		$('#per_apel').focus();
		return false;
	}
	else
	{	$('#per_apel').closest('.error').removeClass('has-error');
	}
	if ($('#per_email_personal').val().trim()=="")
	{	alert ("Ingrese el correo del aspirante");
		$('#per_email_personal').closest('.error').addClass('has-error');
		$('#per_email_personal').focus();
		return false;
	}
	else
	{	$('#per_email_personal').closest('.error').removeClass('has-error');
	}
	
	if ($('#per_dir').val().trim()=="")
	{	alert ("Ingrese la dirección del aspirante");
		$('#per_dir').closest('.error').addClass('has-error');
		$('#per_dir').focus();
		return false;
	}
	else
	{	$('#per_dir').closest('.error').removeClass('has-error');
	}
	if ($('#per_telf').val().trim()=="")
	{	alert ("Ingrese el número telefónico del aspirante");
		$('#per_telf').closest('.error').addClass('has-error');
		$('#per_telf').focus();
		return false;
	}
	else
	{	$('#per_telf').closest('.error').removeClass('has-error');
	}
	if ($('#per_fecha_nac').val().trim()=="")
	{	alert ("Ingrese la fecha de nacimiento del aspirante");
		$('#per_fecha_nac').closest('.error').addClass('has-error');
		$('#per_fecha_nac').focus();
		return false;
	}
	else
	{	$('#per_fecha_nac').closest('.error').removeClass('has-error');
	}
	if ($('#cmb_ciudad_per_lugar_nac').val()==-1)
	{	alert ("Escoja la ciudad de nacimiento del aspirante");
		$('#cmb_ciudad_per_lugar_nac').closest('.error').addClass('has-error');
		$('#cmb_ciudad_per_lugar_nac').focus();
		return false;
	}
	else
	{	$('#cmb_ciudad_per_lugar_nac').closest('.error').removeClass('has-error');
	}
	if ($('#per_tiempo_residencia').val().trim()=="")
	{	alert ("Ingrese el tiempo de residencia del aspirante");
		$('#per_tiempo_residencia').closest('.error').addClass('has-error');
		$('#per_tiempo_residencia').focus();
		return false;
	}
	else
	{	$('#per_tiempo_residencia').closest('.error').removeClass('has-error');
	}
	
	$('#btn_tab_1_next_button').prop('href','#tab_2');
	$('#li_1').removeClass('active');
	$('#li_2').addClass('active');
	$('html, body').animate({ scrollTop: 0 }, 'fast');
	js_enviarSolicitud_guarda_formulario(ruta_html_admisiones+'/enviarSolicitud/controller.php');
	return true;
}
function validarFormRepresentante (ruta_html_admisiones, ruta_html_common)
{	/*Padre*/
	if ($('#repr1_numero_identificacion').val().trim()=="")
	{	alert ("Ingrese el número de identificación del padre");
		$('#repr1_numero_identificacion').closest('.error').addClass('has-error');
		$('#repr1_numero_identificacion').focus();
		return false;
	}
	else
	{	$('#repr1_numero_identificacion').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_nomb').val().trim()=="")
	{	alert ("Ingrese el primer nombre del padre");
		$('#repr1_nomb').closest('.error').addClass('has-error');
		$('#repr1_nomb').focus();
		return false;
	}
	else
	{	$('#repr1_nomb').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_apel').val().trim()=="")
	{	alert ("Ingrese el apellido paterno del padre");
		$('#repr1_apel').closest('.error').addClass('has-error');
		$('#repr1_apel').focus();
		return false;
	}
	else
	{	$('#repr1_apel').closest('.error').removeClass('has-error');
	}
	
	if (!$('#ckb_repr1_per_dir_igual').is(':checked'))
	{	if ($('#repr1_dir').val().trim()=="")
		{	alert ("Ingrese la dirección del padre");
			$('#repr1_dir').closest('.error').addClass('has-error');
			$('#repr1_dir').focus();
			return false;
		}
		else
		{	$('#repr1_dir').closest('.error').removeClass('has-error');
		}
		if ($('#repr1_telf').val().trim()=="")
		{	alert ("Ingrese el teléfono del padre");
			$('#repr1_telf').closest('.error').addClass('has-error');
			$('#repr1_telf').focus();
			return false;
		}
		else
		{	$('#repr1_telf').closest('.error').removeClass('has-error');
		}
	}
	if ($('#repr1_email_personal').val().trim()=="")
	{	alert ("Ingrese el correo personal del padre");
		$('#repr1_email_personal').closest('.error').addClass('has-error');
		$('#repr1_email_personal').focus();
		return false;
	}
	else
	{	$('#repr1_email_personal').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_fecha_nac').val().trim()=="")
	{	alert ("Ingrese la fecha de nacimiento del padre");
		$('#repr1_fecha_nac').closest('.error').addClass('has-error');
		$('#repr1_fecha_nac').focus();
		return false;
	}
	else
	{	$('#repr1_fecha_nac').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_empr_nomb').val().trim()=="")
	{	alert ("Ingrese la empresa donde trabaja el padre");
		$('#repr1_empr_nomb').closest('.error').addClass('has-error');
		$('#repr1_empr_nomb').focus();
		return false;
	}
	else
	{	$('#repr1_empr_nomb').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_empr_cargo').val().trim()=="")
	{	alert ("Ingrese el cargo que ocupa el padre");
		$('#repr1_empr_cargo').closest('.error').addClass('has-error');
		$('#repr1_empr_cargo').focus();
		return false;
	}
	else
	{	$('#repr1_empr_cargo').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_empr_ingreso_mensual').val().trim()=="")
	{	alert ("Escriba el ingreso mensual del padre");
		$('#repr1_empr_ingreso_mensual').closest('.error').addClass('has-error');
		$('#repr1_empr_ingreso_mensual').focus();
		return false;
	}
	else
	{	$('#repr1_empr_ingreso_mensual').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_empr_telf').val().trim()=="")
	{	alert ("Ingrese el teléfono del trabajo del padre");
		$('#repr1_empr_telf').closest('.error').addClass('has-error');
		$('#repr1_empr_telf').focus();
		return false;
	}
	else
	{	$('#repr1_empr_telf').closest('.error').removeClass('has-error');
	}
	if ($('#repr1_empr_mail').val().trim()=="")
	{	alert ("Ingrese el correo del trabajo del padre");
		$('#repr1_empr_mail').closest('.error').addClass('has-error');
		$('#repr1_empr_mail').focus();
		return false;
	}
	else
	{	$('#repr1_empr_mail').closest('.error').removeClass('has-error');
	}
	/*Madre*/
	if ($('#repr2_numero_identificacion').val().trim()=="")
	{	alert ("Ingrese el número de identificación del madre");
		$('#repr2_numero_identificacion').closest('.error').addClass('has-error');
		$('#repr2_numero_identificacion').focus();
		return false;
	}
	else
	{	$('#repr2_numero_identificacion').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_nomb').val().trim()=="")
	{	alert ("Ingrese el primer nombre del madre");
		$('#repr2_nomb').closest('.error').addClass('has-error');
		$('#repr2_nomb').focus();
		return false;
	}
	else
	{	$('#repr2_nomb').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_apel').val().trim()=="")
	{	alert ("Ingrese el apellido paterno del madre");
		$('#repr2_apel').closest('.error').addClass('has-error');
		$('#repr2_apel').focus();
		return false;
	}
	else
	{	$('#repr2_apel').closest('.error').removeClass('has-error');
	}
	
	if (!$('#ckb_repr2_per_dir_igual').is(':checked'))
	{	if ($('#repr2_dir').val().trim()=="")
		{	alert ("Ingrese la dirección del madre");
			$('#repr2_dir').closest('.error').addClass('has-error');
			$('#repr2_dir').focus();
			return false;
		}
		else
		{	$('#repr2_dir').closest('.error').removeClass('has-error');
		}
		if ($('#repr2_telf').val().trim()=="")
		{	alert ("Ingrese el teléfono del madre");
			$('#repr2_telf').closest('.error').addClass('has-error');
			$('#repr2_telf').focus();
			return false;
		}
		else
		{	$('#repr2_telf').closest('.error').removeClass('has-error');
		}
	}
	if ($('#repr2_email_personal').val().trim()=="")
	{	alert ("Ingrese el correo personal del madre");
		$('#repr2_email_personal').closest('.error').addClass('has-error');
		$('#repr2_email_personal').focus();
		return false;
	}
	else
	{	$('#repr2_email_personal').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_fecha_nac').val().trim()=="")
	{	alert ("Ingrese la fecha de nacimiento del madre");
		$('#repr2_fecha_nac').closest('.error').addClass('has-error');
		$('#repr2_fecha_nac').focus();
		return false;
	}
	else
	{	$('#repr2_fecha_nac').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_empr_nomb').val().trim()=="")
	{	alert ("Ingrese la empresa donde trabaja el madre");
		$('#repr2_empr_nomb').closest('.error').addClass('has-error');
		$('#repr2_empr_nomb').focus();
		return false;
	}
	else
	{	$('#repr2_empr_nomb').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_empr_cargo').val().trim()=="")
	{	alert ("Ingrese el cargo que ocupa el madre");
		$('#repr2_empr_cargo').closest('.error').addClass('has-error');
		$('#repr2_empr_cargo').focus();
		return false;
	}
	else
	{	$('#repr2_empr_cargo').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_empr_ingreso_mensual').val().trim()=="")
	{	alert ("Escriba el ingreso mensual del madre");
		$('#repr2_empr_ingreso_mensual').closest('.error').addClass('has-error');
		$('#repr2_empr_ingreso_mensual').focus();
		return false;
	}
	else
	{	$('#repr2_empr_ingreso_mensual').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_empr_telf').val().trim()=="")
	{	alert ("Ingrese el teléfono del trabajo del madre");
		$('#repr2_empr_telf').closest('.error').addClass('has-error');
		$('#repr2_empr_telf').focus();
		return false;
	}
	else
	{	$('#repr2_empr_telf').closest('.error').removeClass('has-error');
	}
	if ($('#repr2_empr_mail').val().trim()=="")
	{	alert ("Ingrese el correo del trabajo del madre");
		$('#repr2_empr_mail').closest('.error').addClass('has-error');
		$('#repr2_empr_mail').focus();
		return false;
	}
	else
	{	$('#repr2_empr_mail').closest('.error').removeClass('has-error');
	}
	
	$('#btn_tab_2_next').prop('href','#tab_3');
	$('#li_2').removeClass('active');
	$('#li_3').addClass('active');
	$('html, body').animate({ scrollTop: 0 }, 'fast');
	js_enviarSolicitud_guarda_formulario(ruta_html_admisiones+'/enviarSolicitud/controller.php');
	js_representantes_get_representantes(document.getElementById('hd_per_codi').value, 'div_representantes_principales', ruta_html_common+'/representantes/controller.php', 'off');
	return true;
}