// JavaScript Document
$(document).ready(function(){
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    $(".clickable-row").css("cursor", "pointer");

    $("#txt_fecha_debito").datepicker();
    $("#cmb_producto").select2();
    $( "#div_campos" ).sortable({
        axis: 'y',
        cursor: 'move',
        containment: 'parent',
        tolerance: "pointer",
        change: function(event, ui)
        {   validate_save_button_followed(false);
        }
    });
    $( "#div_campos" ).disableSelection();
    $('#modal_formato').on('hidden.bs.modal', function () {
        document.getElementById('forma_descripccion_add').style.border = "1px solid #CCCCCC";
        document.getElementById('lbl_forma_descripccion_add').style.color = "black";
    });
	/*$('#modal_exportarFormatoArchivo').on('hidden.bs.modal', function () {
        document.getElementById('cmb_producto').style.border = "1px solid #CCCCCC";
        document.getElementById('cmb_producto').style.color = "black";
    });*/

    $('#modal_cargarFormatoArchivo').on('show.bs.modal', function () {
        get_formatos('div_cmb_carga_formato',document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php');
    });
    $('#modal_exportarFormatoArchivo').on('hidden.bs.modal', function () {
        $(this).find("input,textarea").end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        $(this).find(".collapse").collapse('hide').end();
        $(this).find("#cmb_tipo_formato").val('xlsx').end();
    });
	$('#formatos_add').select2({
		maximumSelectionLength: 1,
		language: "es"
	}).on('select2-opening', function(e) {
		if ($(this).select2('val').length > 0) {
			e.preventDefault();
		}
	});
});
var num_campos = 0;
var num_total_campos = 0;
function nuevo_formato()
{   var r = false;
    if($('#span_status_disk').hasClass('glyphicon glyphicon-floppy-saved'))
    {   r = true;
    }
    else
    {   r = confirm("¿Terminar edición de formato actual? Los cambios no guardados se perderán.");
    }
    if (r)
    {   limpia_crear_formato();
        document.getElementById('hd_nombreformato').value = "";
        document.getElementById('hd_id_cabecera').value = "";
        document.getElementById('span_info_formato').innerHTML = "";
        document.getElementById('btn_choose_view').disabled = false;
        document.getElementById('cmb_vista').disabled = false;
    }
}
function limpia_crear_formato()
{   num_campos = 0;
    num_total_campos = 0;
    validate_save_button(num_total_campos);
    document.getElementById('secuencial').checked = false;
    cambia_check_sec(document.getElementById('secuencial'));
    document.getElementById('div_campos').innerHTML = "";
    document.getElementById('div_file_status').innerHTML = "";
    document.getElementById('div_file_status_top').innerHTML = "";
    document.getElementById('lbl_num_total_campos').value = "0";
}
function validate_save_button(num_total_campos)
{   if(num_total_campos === 0)
    {   validate_save_button_followed(true);
    }
    else
    {   validate_save_button_followed(false);
    }
}
function validate_save_button_followed(toggle)
{   var nombre = document.getElementById('hd_nombreformato').value;
    if (nombre)
    {   var title = " title='Modificado: \"" + nombre + "\"' ";
    }
    else
    {   var title = " title='Modificado: [nuevo formato]' ";
        toggle = false;
    }
    if(toggle)
    {   document.getElementById('div_file_status').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='left' title='Modificado' style='color:green;' class='glyphicon glyphicon-floppy-saved'></span>";
        document.getElementById('div_file_status_top').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='right' " + title + " style='color:green;' class='glyphicon glyphicon-floppy-saved'></span>";
        document.getElementById('btn_formato_nuevo_guardar').disabled = toggle;
        document.getElementById('cmb_vista').value = document.getElementById('hd_vista').value;
    }
    else
    {   document.getElementById('div_file_status').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='left' title='Modificado' style='color:red;' class='glyphicon glyphicon-floppy-remove'></span>";
        document.getElementById('div_file_status_top').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='right' " + title + " style='color:red;' class='glyphicon glyphicon-floppy-remove'></span>";
        document.getElementById('btn_formato_nuevo_guardar').disabled = toggle;
        document.getElementById('cmb_vista').value = document.getElementById('hd_vista').value;
    }
}
function remove_column(obj)
{   var obj_name = obj.attributes["name"].value;
    var wordsToFind = ["quitar_", "*quitar_*"];
    if (obj_name.toLowerCase().indexOf(wordsToFind[0]) === 0 || obj_name.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   var nombre = obj_name.replace("quitar_", "");
        $("#li_campo_" + nombre).remove();
        num_total_campos = num_total_campos - 1;
        document.getElementById("lbl_num_total_campos").value = num_total_campos;
        $.growl.error({title: 'Educalinks Informa', message: 'Campo eliminado.'});
        validate_save_button(num_total_campos);
    }
}
function carga_archivo(field, div, url)
{   nuevo_formato();
    document.getElementById(div + '_load_gif').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Cargando formato. Por favor, espere...</div>';
    var data = new FormData();
    data.append('event', 'carga_formato');
    data.append('formatos_add', field);
    var xhraf = new XMLHttpRequest();
    xhraf.open('POST', url , true);
    xhraf.onreadystatechange=function()
    {   if (xhraf.readyState==4 && xhraf.status==200)
        {   $('#modal_cargarFormatoArchivo').modal('hide');
            obj = JSON.parse(xhraf.responseText);
            if(obj['secuencial']===1)
            {   document.getElementById('secuencial').checked = true;
            }
            else
            {   document.getElementById('secuencial').checked = false;
            }
            cambia_check_sec(document.getElementById('secuencial'));
            document.getElementById('secuencia').value = obj['secuencia']; //numero del secuencial
            document.getElementById('ubicacion').value = obj['ubicacion']; //columna en la que va ubicado el secuencial en el documento
            document.getElementById('cmb_vista').value = obj['vista']; //vista
            document.getElementById('hd_vista').value = obj['vista']; //vista
            document.getElementById('lbl_num_total_campos').value = (obj['numrows']-1);
            document.getElementById(div).style.display='none';
            document.getElementById('btn_choose_view').disabled = true;
            document.getElementById('cmb_vista').disabled = true;
            js_debtAut_carga_archivo_followed ( div, url, obj, 0, obj.form_debi_deta_codigos.length );

            var dataII = new FormData();
            dataII.append('event', 'cambiar_vista');
            dataII.append('vista', obj['vista']);
            var xhrafII = new XMLHttpRequest();
            xhrafII.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php', true);
            xhrafII.onreadystatechange=function()
            {   if ( xhrafII.readyState === 4 && xhrafII.status === 200 )
                {   document.getElementById('div_cmb_campos').innerHTML = xhrafII.responseText;
                }
            };
            xhrafII.send(dataII);
        }
    };
    xhraf.send(data);
}
function js_debtAut_carga_archivo_followed(div, url, obj, indice, obj_len )
{   if( ( indice < obj_len ) )
    {   var data = new FormData();
        data.append('event', 'carga_formato_campo');
        data.append('text', obj.form_debi_deta_codigos[indice]['text']);
        data.append('value', obj.form_debi_deta_codigos[indice]['value'] );
        data.append('num_campo', obj.form_debi_deta_codigos[indice]['num_campo'] );
        data.append('text_predif', obj.form_debi_deta_codigos[indice]['text_predif'] );
        data.append('num_caracteres', obj.form_debi_deta_codigos[indice]['num_caracteres'] );
        data.append('val_izq', obj.form_debi_deta_codigos[indice]['val_izq'] );
        data.append('text_izq', obj.form_debi_deta_codigos[indice]['text_izq'] );
        data.append('val_der', obj.form_debi_deta_codigos[indice]['val_der'] );
        data.append('text_der', obj.form_debi_deta_codigos[indice]['text_der'] );
        var xhraf = new XMLHttpRequest();
        xhraf.open('POST', url , true);
        xhraf.onreadystatechange=function()
        {   if (xhraf.readyState==4 && xhraf.status==200)
            {   var container = document.createElement("div");
                container.innerHTML = xhraf.responseText;
                document.getElementById(div).appendChild(container);
                js_debtAut_carga_archivo_followed(div, url, obj, indice + 1, obj_len );
            }
        };
        xhraf.send(data);
    }
    else
    {   document.getElementById(div).style.display='block';
        document.getElementById(div + '_load_gif').innerHTML="";
        num_campos = (obj['numrows']-1);
        num_total_campos = (obj['numrows']-1);
        cuadro_guardado_sin_modificacion(obj['hd_nombreformato'], obj['hd_id_cabecera']);
        $.growl.notice({title: 'Educalinks Informa', message: 'Formato "' + obj['hd_nombreformato'] + '" cargado correctamente'});
    }
}
function js_debtAut_copiar_archivo_open_modal(codigo, url)
{   $('#modal_copy_paste').modal('show');
    document.getElementById('cmb_formato_copyPaste').value = codigo;
    var sel = document.getElementById('cmb_formato_copyPaste');
    var nombre_formato = sel.options[sel.selectedIndex].text;
    document.getElementById('forma_descripccion_copy_paste').innerHTML = "<small>Realizando copia del formato '<b>" + nombre_formato + "</b>'.</small>";
}
function js_debtAut_copiar_archivo_copy(codigo, div, url)
{   var f = document.getElementById('txt_forma_descripccion_copyPaste').value;
    if(f.length>0)
    {   var data = new FormData();
        data.append('event', 'copy_file');
        data.append('form_debi_codigo', codigo);
        data.append('form_debi_descripcion', f);
        var xhraf = new XMLHttpRequest();
        xhraf.open('POST', url , true);
        xhraf.onreadystatechange=function()
        {   if (xhraf.readyState==4 && xhraf.status==200)
            {   var n = xhraf.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhraf.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks Informa",message: "Proceso realizado." });
                }
                js_debtAuto_mantenimiento_buscar_todos(div,url);
                $('#modal_copy_paste').modal('hide');
            }
        };
        xhraf.send(data);
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el nombre del formato."});
        document.getElementById('txt_forma_descripccion_copyPaste').style.border = "1px solid #A94442";
        document.getElementById('lbl_forma_descripccion_copyPaste').style.color = "#A94442";
    }
}
function add_field(field, div, url, obj)
{   var obj_id = obj.attributes["id"].value;
    document.getElementById(obj_id).disabled = true;
    document.getElementById(div + '_load_gif').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    var combo=field;
    var valor=combo.value;
    var texto = combo.options[combo.selectedIndex].text;
    var data = new FormData();
    data.append('event', 'get_campos');
    data.append('text',texto);
    data.append('value',valor);
    data.append('num_campo', parseInt(num_campos)+parseInt(1));
    var xhraf = new XMLHttpRequest();
    xhraf.open('POST', url , true);
    xhraf.onreadystatechange=function()
    {   if (xhraf.readyState==4 && xhraf.status==200)
        {   num_campos = num_campos+1;
            num_total_campos = num_total_campos+1;
            document.getElementById(div + '_load_gif').innerHTML="";
            var container = document.createElement("div");
            container.innerHTML = xhraf.responseText;
            document.getElementById(div).appendChild(container); //De esta forma no se borra el contenido del formulario al agregar o quitar.
            document.getElementById(obj_id).disabled = false;
            document.getElementById("lbl_num_total_campos").value = num_total_campos;
            $.growl.notice({title: 'Educalinks Informa', message: 'Campo "' + texto + '" agregado.'});
            validate_save_button(num_total_campos);
        }
    };
    xhraf.send(data);
}
function get_formatos(div,url)
{   var data = new FormData();
    data.append('event', 'get_formatos');
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML = xhrafe.responseText;
			$('#formatos_add').select2({
				maximumSelectionLength: 1,
				language: "es"
			}).on('select2-opening', function(e) {
				if ($(this).select2('val').length > 0) {
					e.preventDefault();
				}
			});
        }
    };
    xhrafe.send(data);
}
function get_formatos_copy_paste(div,url)
{   var data = new FormData();
    data.append('event', 'get_formatos_copy_paste');
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML = xhrafe.responseText;
        }
    };
    xhrafe.send(data);
}
function js_debtAut_del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar el formato seleccionado? Una vez eliminado no se podrá recuperar más."))
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('event', 'delete');
        data.append('form_debi_codigo', codigo);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState==4 && xhr.status==200)
            {   var n = xhr.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhr.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks Informa",message: "Proceso realizado." });
                }
                js_debtAuto_mantenimiento_buscar_todos('div_tbl_format',document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php');
            }
        };
        xhr.send(data);
    }
}
function js_debtAuto_mantenimiento_buscar_todos(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    document.getElementById('menu3_loader').innerHTML = '<span title="Cargando consulta"><br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div></span>';
    var data = new FormData();
    data.append('event', 'get_maint');
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML = xhrafe.responseText;
            $('#table_formato').addClass( 'nowrap' ).DataTable({
                "bPaginate": true,
                "bStateSave": false,
                "bAutoWidth": false,
                "bScrollAutoCss": true,
				"bSort" : false,
                "bProcessing": true,
                "bRetrieve": true,
                "sDom": '<"H"CTrf>t<"F"lip>',
                "aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
                "sScrollXInner": "110%",
                "fnInitComplete": function() {
                    this.css("visibility", "visible");
                },
                paging: true,
                lengthChange: true,
                searching: true,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
            });
            var table = $('#table_formato').DataTable();
            table.column( '1:visible' ).order( 'asc' );
            $('#btn_maint_buscar_todos').find(".glyphicon").removeClass("glyphicon-folder-close").addClass("glyphicon-folder-open");
            document.getElementById('menu3_loader').innerHTML = "";
            get_formatos_copy_paste('div_cmb_formato_copyPaste',document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php');
            $('#modal_copy_paste').on('hidden.bs.modal', function () {
                document.getElementById('txt_forma_descripccion_copyPaste').style.border = "1px solid #CCCCCC";
                document.getElementById('lbl_forma_descripccion_copyPaste').style.color = "black";
            });
        }
    };
    xhrafe.send(data);
}
function js_debtAut_toggle_readonly_tarj_banco(  )
{   var rb_filtro = document.querySelector('input[id="rb_filtro"]:checked').value;
    if( rb_filtro == 'banco' )
    {   document.getElementById( 'cmb_banco' ).disabled = false;
        document.getElementById( 'cmb_banco' ).value = "-1";
		document.getElementById( 'cmb_tarjCredito' ).disabled = true;
        document.getElementById( 'cmb_tarjCredito' ).value = "";
    }
    if( rb_filtro == 'tarjeta' )
    {   document.getElementById( 'cmb_tarjCredito' ).disabled = false;
        document.getElementById( 'cmb_tarjCredito' ).value = "-1";
		document.getElementById( 'cmb_banco' ).disabled = true;
        document.getElementById( 'cmb_banco' ).value = "";
    }
}
function create_file_guardar(formulario, url)
{   var nombre = document.getElementById('hd_nombreformato').value;
    var id = document.getElementById('hd_id_cabecera').value;
    if(nombre.length > 0) //guardar directamente
    {   guarda_formato_como(formulario, url, nombre, id);
    }
    else //llamar modal primero
    {   $('#modal_formato').modal('show');
    }
}
function procesar_Archivo( div, url )
{   document.getElementById('btn_procesar_carga_xls').disabled = true;
    var data = new FormData();
    data.append( 'event',   'procesar_archivo' );
    data.append( 'textook', document.getElementById( 'textook' ).value);
	data.append( 'textonook', document.getElementById( 'textonook' ).value);
    data.append( 'codeuda', document.getElementById( 'coddeuda' ).options[document.getElementById( 'coddeuda' ).selectedIndex].text );
    data.append( 'estado',  document.getElementById( 'estado' ).options[document.getElementById( 'estado' ).selectedIndex].text );
    data.append( 'valor',   document.getElementById( 'valor' ).options[document.getElementById( 'valor' ).selectedIndex].text );
    data.append( 'fecha_debito', document.getElementById( 'fecha_debito' ).value );
    data.append( 'id_formaPago', document.getElementById( 'cmb_formaPago' ).value );
    document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Cargando pagos al sistema. Por favor, espere... Esta tarea puede tardar unos minutos.</div>';
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML=xhrafe.responseText;            
        }
    };
    xhrafe.send(data);
}
function js_debtAuto_get_procesar( )
{   var data = new FormData();
    data.append( 'event', 'get_procesar' );
    data.append( 'filainicia', document.getElementById('filainicia').value );
    data.append( 'txt_fecha_debito', document.getElementById('txt_fecha_debito').value );

    document.getElementById( 'menu2' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Cargando archivo. Por favor, espere...</div>';
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById( 'menu2' ).innerHTML=xhrafe.responseText;
			$('[data-toggle="popover"]').popover({html:true});
			console.log("reaches");
        }
    };
    xhrafe.send(data);
}
function validasubirarchivo(formulario,div,url)
{   subirarchivo(formulario,div,url);
    return false;
}
function js_debitosAutomaticos_genera_file_ajax ()
{   document.getElementById( 'menu2' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Cargando formato. Por favor, espere...</div>';
    var data = new FormData();
    data.append( 'event', 'genera_file_ajax' );
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState === 4 && xhrafe.status === 200 )
        {   document.getElementById( 'menu2' ).innerHTML = xhrafe.responseText;
            $("#txt_fecha_debito").datepicker();
        }
    };
    xhrafe.send(data);
}
function js_debtAuto_subirarchivo( )
{   if ( document.getElementById('hd_caja_abierta').value ==  'false' )
    {   document.getElementById('procesar').innerHTML='<button type="button" class="btn btn-warning" onclick="js_debitosAutomaticos_genera_file_ajax();"><li class="fa fa-chevron-left"></li> Volver</button><br><br>'+
                    '<div class="callout callout-info">'+
                        '<h4><strong><li class="fa fa-exclamation"></li> Carga de archivo de débito bancario</strong></h4>'+
                        ' Usuario debe ser un usuario con rol <a target=\'_blank\' href=\'../../../admin/usuarios_main.php\'><b>caja</b></a>, estar <a target="_blank" href="../../../finan/puntos_emision/"><b>asignado a una caja</b></a> y/o'+
                        ' estar trabajando con una <a target="_blank" href="../../../finan/cierre_caja/"><b>caja abierta</b></a> para poder realizar esta operación.'+
                    '</div>';
    }
    else
    {   var file = document.getElementById( 'fileToUpload' ).value;
        var row = document.getElementById( 'filainicia' ).value;
        if(file)
        {   if(row)
            {   $('#modal_ask_load_file').modal("show");
            }
            else
            {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el inicio de la cabecera."});
                document.getElementById('filainicia').style.border = "1px solid #A94442";
                document.getElementById('span_ig_filainicia').style.color = "#A94442";
                document.getElementById('span_ig_filainicia').style.background = "#F2DEDE";
                document.getElementById('span_ig_filainicia').style.border = "1px solid #A94442";
            }
        }
        else
        {   $.growl.warning({title: 'Educalinks Informa', message: "Seleccione un archivo de su equipo, primero, para continuar"});
        }
    }
}
function js_debtAuto_subirarchivo_followed( )
{   $('#modal_ask_load_file').modal("hide");
    var data = new FormData();
    data.append('event', 'subir_archivo' );
    data.append('fileToUpload', document.getElementById( 'fileToUpload' ).files[0] );

    document.getElementById( 'btn_formato_nuevo_generar' ).disabled = true;

    var xhrej = new XMLHttpRequest();
    xhrej.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhrej.onreadystatechange=function()
    {   if ( xhrej.readyState === 4 && xhrej.status === 200 )
        {   console.log( xhrej.responseText );
            js_debtAuto_get_procesar( );
        }
    };
    xhrej.send(data);
}
function closeself()
{    self.close;
}
function guarda_formato_como(formulario, url, formatonombre, id)
{   var f = formatonombre;
    var frm = document.getElementById(formulario);
    var nombre = "";
    var valor = "";
    var tipo = "";
    var formato = {};
    formato['nombre_formato'] = f;
    formato['id_formato'] = id;
    formato['detalles'] = [];
    var numero = 0;
    var numero_old = 1;
    var detalle = {};
    var i = 0;
    var orden = 1;
    for (i=0;i<frm.elements.length;i++)
    {   nombre=frm.elements[i].name;
        valor=frm.elements[i].value;
        var activado=frm.elements[i].checked;
        tipo=frm.elements[i].type;
        if((tipo=="checkbox" || tipo=="text" || tipo=="number") && ((nombre.substring(0,4)=="camp") || (nombre.substring(0,4)=="cabe") || (nombre.substring(0,4)=="nmax") || (nombre.substring(0,4)=="orde") || (nombre.substring(0,4)=="izqi") || (nombre.substring(0,4)=="dere") || (nombre.substring(0,4)=="cade") || (nombre.substring(0,4)=="caiz"))){
            numero=parseInt(nombre.substring(parseInt(nombre.indexOf("__"))+parseInt(2)));
            if(numero!=numero_old)
            {   numero_old=numero;
                formato['detalles'].push(detalle);
                detalle={};
            }
            var campo = nombre.substring(5,nombre.indexOf("__"));
            switch(nombre.substring(0,4))
            {   case 'cabe':
                    detalle['orden'] = orden;
                    detalle['cabecera'] = valor;
                    orden = orden + 1;
                break;
                case 'camp':
                    detalle['campo'] = campo;
                    detalle['text_predif'] = valor;
                break;
                case 'nmax':
                    detalle['num_caracteres'] = valor;
                break;
                case 'izqi':
                    if(activado){detalle['izquierda'] = 1;}else{detalle['izquierda'] = 0;}
                break;
                case 'dere':
                    if(activado){detalle['derecha'] = 1;}else{detalle['derecha'] = 0;}
                break;
                case 'cade':
                    detalle['caracder'] = valor;
                break;
                case 'caiz':
                    detalle['caracizq'] = valor;
                break;
            }
        }
    }
    formato['detalles'].push(detalle);
    var data = new FormData();
    var check=0,secuencia1=0,ubicacion=0;
    
    if(document.getElementById('secuencial').checked)
        check = 1;
    else
        check = 0;
    if(document.getElementById('secuencia').value!=='')
        secuencia1 = document.getElementById('secuencia').value;
    else
        secuencia1 = 0;
    if(document.getElementById('ubicacion').value!=='')
        ubicacion = document.getElementById('ubicacion').value;
    else
        ubicacion = 0;
    
    data.append('event', 'save_format' );
    data.append('formato', JSON.stringify( formato ) );
    data.append('check', check );
    data.append('iniciosecuencial', secuencia1 );
    data.append('ubicasecuencia', ubicacion );
    data.append('vista', document.getElementById('cmb_vista').value );
    var xhrej = new XMLHttpRequest();
    xhrej.open('POST', url , true);
    xhrej.onreadystatechange=function()
    {   if ( xhrej.readyState === 4 && xhrej.status === 200 )
        {   obj = JSON.parse(xhrej.responseText);
            var n = obj['mensaje'].length;
            if (n > 0)
            {   valida_tipo_growl(obj['mensaje']);
            }
            else
            {   $.growl.warning({ title: "Educalinks Informa",message: "Proceso realizado." });
            }
            $('#modal_formato').modal('hide');
            cuadro_guardado_sin_modificacion(obj['hd_nombreformato'], obj['hd_id_cabecera']);
        }
    };
    xhrej.send(data);
}
function cuadro_guardado_sin_modificacion(nombreformato, id_cabecera)
{   document.getElementById('span_info_formato').innerHTML = ' "' + nombreformato + '"'; //nombre del formato
    document.getElementById('hd_nombreformato').value = nombreformato; //nombre del formato
    document.getElementById('hd_id_cabecera').value = id_cabecera; //nombre del formato
    document.getElementById('cmb_vista').disabled = true;
    validate_save_button_followed(true); //icono de guardado a green.
}
function guarda_formato(formulario,url)
{   if (!js_debtAuto_validar_formulario())
    {   var f = document.getElementById('forma_descripccion_add').value;
        var id = -1;
        if(f.length>0)
        {   guarda_formato_como(formulario, url, f, id);
        }
        else
        {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el nombre del formato."});
            document.getElementById('forma_descripccion_add').style.border = "1px solid #A94442";
            document.getElementById('lbl_forma_descripccion_add').style.color = "#A94442";
        }
    }
    else
    {   $('#modal_formato').modal('toggle');
        var mensaje = "Ning&uacute;n campo 'Nombre cabecera' puede ir vac&iacute;o. Por favor, complete.";
        $.growl.error({title: 'Educalinks Informa', message: "No se realizaron los cambios, faltan datos importantes."});
    }
}
function js_debtAuto_validar_formulario()
{   var validador=false;
    var i = 0;
    for (i = 1; i <= num_campos; i++)
    {   if(document.getElementById( 'cabe_campo_'+ i +'__'+ i ))
        {   if(document.getElementById( 'cabe_campo_'+ i +'__'+ i ).value.length<=0)
            {   validador=true;
            }
        }
    }
    return validador;
}
function js_debtAuto_cmb_tipo_formato_onchange(obj, div)
{   var formato = obj.value;
    if (formato != 'xlsx')
    {   $(document.getElementById(div)).collapse(200).collapse('show');
    }
    else
    {   $(document.getElementById(div)).collapse(200).collapse('hide');
    }
}
function js_debtAut_genera_archivo()
{   js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
	if($('#span_status_disk').hasClass('glyphicon glyphicon-floppy-saved'))
    {   $('#modal_exportarFormatoArchivo').modal('show');
        document.getElementById('rb_filtro').checked = false;
        $("#cmb_banco option[value='']").remove();
        $("#cmb_tarjCredito option[value='']").remove();
        document.getElementById('cmb_banco').disabled = true;
        document.getElementById('cmb_tarjCredito').disabled = true;
        document.getElementById('cmb_banco').value = "";
        document.getElementById('cmb_tarjCredito').value = "";
        document.getElementById('forma_descripccion_exp').innerHTML = "'<b>" + document.getElementById('hd_nombreformato').value + "</b>'";
        document.getElementById('hd_id_formato_exp').value = document.getElementById('hd_id_cabecera').value;

		if( document.getElementById('cmb_vista').value == 'V_DatosAlumnosDebitos_Detalle' )
		{	document.getElementById( 'div_filtros_debitoBancario' ).style.display='inline';
		}
		else
			document.getElementById( 'div_filtros_debitoBancario' ).style.display='none';
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: 'Debe guardar los cambios para realizar esta acción'});
    }
}
function js_debtAut_genera_archivo_followed(formulario)
{
var bandera = 0; var counter = 1; var mensaje = "";
	if ( document.getElementById( 'div_filtros_debitoBancario' ).style.display == 'none' ) /*none: ventanilla; inline: debito bancario. */
	{
		$('#cmb_producto :selected').each(function(i, selected){
			bandera++;
		});

		if ( bandera === 0 )
			mensaje = "Debe seleccionar el/los producto(s).";

		if ( bandera > 0 )
		{
			document.getElementById( formulario ).submit();
		}
		else
		{   $.growl.error({title: 'Educalinks Informa', message: mensaje});
		}
	}
	else
	{
        $('#cmb_producto :selected').each(function(i, selected){
			bandera++;
		});

		if ( bandera === 0 )
			mensaje = "Debe seleccionar el/los producto(s).<br>";




		document.getElementById( 'hd_exp_opc_ant' ).value

		if ( bandera > 0 )
		{
			document.getElementById('evento').value='create_file';

			if ( document.getElementById( 'div_step_1' ).style.display == 'inline' )
			{   if ( document.getElementById( 'hd_exp_opc_ant' ).value == 'S' )
				{
					js_debtAut_genera_archivo_manage_divs ( 'none', 'inline', 'none');
					js_debtAut_genera_archivo_ask_opc_ant( formulario );
				}
				else if ( document.getElementById( 'hd_exp_opc_ctas' ).value  == 'S' )
				{
					js_debtAut_genera_archivo_manage_divs ( 'none', 'none', 'inline');
					js_debtAut_genera_archivo_ask_opc_ctas( formulario );
				}
				else
				{
					if ( confirm( "¿Exportar formato ahora?" ) )
						document.getElementById( formulario ).submit();

					js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
				}
			}
			else if ( document.getElementById( 'div_step_2' ).style.display == 'inline' )
			{
				if ( document.getElementById( 'hd_exp_opc_ctas' ).value  == 'S' )
				{
					js_debtAut_genera_archivo_manage_divs ( 'none', 'none', 'inline');
					js_debtAut_genera_archivo_ask_opc_ctas( formulario );
				}
				else
				{
					if ( confirm( "¿Exportar formato ahora?" ) )
						document.getElementById( formulario ).submit();

					js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
				}
			}
			else if ( document.getElementById( 'div_step_3' ).style.display == 'inline' )
			{
				if ( confirm( "¿Exportar formato ahora?" ) )
					document.getElementById( formulario ).submit();

				js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
			}
		}
		else
		{   $.growl.error({title: 'Educalinks Informa', message: mensaje});
		}
	}
}
function js_debtAut_genera_archivo_manage_divs( div1 , div2 , div3 )
{	$( '#btn_formato_exportar_followed' ).button( "reset" );
	if ( div1 === 'inline' )
	{
		document.getElementById( 'hd_opc_ctas_ant' ).value = '2';
		document.getElementById( 'hd_opc_ctas_inl' ).value = '2';
	}
	document.getElementById( 'div_step_1' ).style.display = div1;
	document.getElementById( 'div_step_2' ).style.display = div2;
	document.getElementById( 'div_step_3' ).style.display = div3;
}
function js_debtAut_genera_archivo_ask_opc_ant ( formulario )
{
	//consulta deudores de cuentas antiguas.
	$( '#btn_formato_exportar_followed' ).button( "loading" );
	document.getElementById( 'div_step_2' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Verificando deudores con cuentas por cobrar antiguas. Por favor, espere...</div>';
	var data = new FormData();
    data.append( 'event', 'get_deudores_ctas_antiguas' );
	var productos = [];
	$('#cmb_producto :selected').each(function(i, selected){
	  productos[i] = $(selected).val();
	});
	data.append('cmb_producto', JSON.stringify( productos ) );
	data.append('hd_id_formato_exp', document.getElementById( 'hd_id_formato_exp' ).value );

	data.append('cmb_fac_estado', 	document.getElementById( 'cmb_fac_estado' ).value );
	data.append('cmb_banco', 		document.getElementById( 'cmb_banco' ).value );
	data.append('cmb_tarjCredito', 	document.getElementById( 'cmb_tarjCredito' ).value );

    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   if( xhr.responseText > 0 ) //si tiene registros de ctas. antiguas pendientes...
			{
				$( '#btn_formato_exportar_followed' ).button( "reset" );
				get_div_step_2_body();
			}
			else //caso contrario, cargar step 3.
			{
				if ( document.getElementById( 'hd_exp_opc_ctas' ).value  == 'S' )
				{
					js_debtAut_genera_archivo_manage_divs ( 'none', 'none', 'inline');
					js_debtAut_genera_archivo_ask_opc_ctas( formulario );
				}
				else
				{
					if ( confirm( "¿Exportar formato ahora?" ) )
						document.getElementById( formulario ).submit();

					js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
				}
			}
        }
    };
    xhr.send(data);
}
function get_div_step_2_body()
{
	document.getElementById( 'div_step_2' ).innerHTML = '<div class="form-group" >'+
								'<div class="col-sm-12">'+
									'<div class="alert alert-default" role="alert">'+
										'<p><span class="fa fa-upload" aria-hidden="true"></span>'+
											'¡Aviso!'+
											'<hr style="padding:3px;margin:0px;">'+
											'Parece ser que en el plan de cobros (Períodos anuales), éste no es el primer ítem de cobro. '+
											'Hay items con fecha de inicio cobro menor, y hay alumno(s), los cuales, estás intentando obtener información para cobrar este ítem,'+
											'pero que tiene(n) deuda(s) pendiente(s) de items anteriores.'+
										'</p>'+
									'</div>'+
								'</div>'+
							'</div><div class="form-group" >'+
								'<div class="col-sm-12">'+
									'¿Qué desea hacer?'+
								'</div>'+
							'</div>'+
							'<div class="form-group" >'+
								'<div class="col-sm-12">'+
									'<ol type=”1” start=”11”>'+
										'<li> Ver la lista de plan de pago a la que hace referencia este mensaje, según el período actual. </li>'+
										'<li> Descargar lista de los alumnos con deudas vencidas con información de la deuda. </li>'+
										'<li> Exportar archivo, pero obtener la deuda más antigua de los alumnos deudores de ítems anteriores según el plan de pago. </li>'+
										'<li> Exportar archivo normalmente </li>'+
										'<li> Volver </li>'+
									'</ol>'+
								'</div>'+
							'</div>';
}
function js_debtAut_genera_archivo_ask_opc_ctas( formulario )
{
	//consulta deudores con cuentas inliquidas.
	$( '#btn_formato_exportar_followed' ).button( "loading" );
	document.getElementById( 'div_step_3' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Verificando deudores con cuentas bancarias sin liquidez. Por favor, espere...</div>';

	var data = new FormData();
    data.append( 'event', 'get_deudores_ctas_inliquidas' );
	data.append('hd_id_formato_exp', document.getElementById( 'hd_id_formato_exp' ).value );

    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{
			if( xhr.responseText > 0 ) //si tiene registro activo de de historico de personas que tuvieron cuentas sin liquidez...
			{
				$( '#btn_formato_exportar_followed' ).button( "reset" );
				get_div_step_3_body();
			}
			else //caso contrario, cargar step 3.
			{
				if ( confirm( "¿Exportar formato ahora?" ) )
						document.getElementById( formulario ).submit();

					js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
			}
        }
    };
    xhr.send(data);
}
function get_div_step_3_body()
{
	document.getElementById( 'div_step_3' ).innerHTML = '<div class="form-group" >'+
								'<div class="col-sm-12">'+
									'<div class="alert alert-default" role="alert">'+
										'<p><span class="fa fa-upload" aria-hidden="true"></span>'+
											'¡Aviso!'+
											'<hr style="padding:3px;margin:0px;">'+
											'Hay clientes con intento fallido de débito automático por falta de liquidez en la cuenta principal.<br>'+
											'<br>'+
											'Los clientes con intento fallido dejarán de generar este mensaje una vez que tengan un pago exitoso (ya sea caja, ventanilla, debito, etc.).'+
										'</p>'+
									'</div>'+
								'</div>'+
							'</div><div class="form-group" >'+
								'<div class="col-sm-12">'+
									'¿Qué desea hacer?'+
								'</div>'+
							'</div>'+
							'<div class="form-group" >'+
								'<div class="col-sm-12" style="font-size:small;" >'+
									'<ol type=”1” start=”11”>'+
										"<li><a href='#' class='li_opc_ctas_inl' id='li_opc_ctas_inl_1' >Generar archivo de débito de todos los clientes y a los deudores con intento fallido de débito, obtener información de cuenta secundaria.</a></li>"+
										"<li><a href='#' class='li_opc_ctas_inl' id='li_opc_ctas_inl_2'>Generar archivo de débito de todos los clientes y a los deudores con intento fallido de débito, obtener información de cuenta principal.</a></li>"+
										"<li><a href='#' class='li_opc_ctas_inl' id='li_opc_ctas_inl_3'>Generar archivo de débito sólo de deudores con intento fallido de débito, con información de cuenta secundaria.</a></li>"+
										"<li><a href='#' class='li_opc_ctas_inl' id='li_opc_ctas_inl_4'>Generar archivo de débito sólo de deudores con intento fallido de débito, con información de cuenta principal.</a></li>"+
										"<li><a href='#' class='li_opc_ctas_inl' id='li_opc_ctas_inl_5'>Generar archivo de débito sólo de deudores que no tienen intento fallido de débito.</a></li>"+
									'</ol>'+
									'<br>'+
									'<ul>'+
										"<li><a href='#' data-toggle='modal' data-target='#modal_delete_ctas_inl' class='li_opc_ctas_inl' id='li_opc_ctas_inl_6'><span class='fa fa-trash btn_opc_lista_eliminar'></span> Borrar lista de deudores con cuentas impagas pendientes de confirmar pago para que no vuelvan a generar este aviso&nbsp;"+
											"<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>"+
												"<a href='#' data-placement='top' onmouseover='$(this).tooltip(\"show\")'"+
													"title='Si en una futura importación de datos hay deudores con intentos de débito fallido, este mensaje volverá a aparecer.' data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>"+
											"</div></a></li>"+
										"<li><a href='#' class='li_opc_ctas_inl' id='li_opc_ctas_inl_7'><span style='color:#17ca34' class='fa fa-file-excel-o'></span> Ver listado de personas con historial de cuentas sin liquidez que tienen una operación pendiente con una cuenta secundaria.</a></li>"+
										"<li ><a href='#' onclick=\"js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );\"><span class='fa fa-arrow-left'></span> Volver al primer paso.</a></li>"+
									'</ul>'+
								'</div>'+
							'</div>';

	$("#li_opc_ctas_inl_1").on("click",function() {
		$(".li_opc_ctas_inl").removeClass("Highlight");
		$(this).addClass("Highlight");
		document.getElementById("hd_opc_ctas_inl").value = 1;
	});
	$("#li_opc_ctas_inl_2").on("click",function() {
		$(".li_opc_ctas_inl").removeClass("Highlight");
		$(this).addClass("Highlight");
		document.getElementById("hd_opc_ctas_inl").value = 2;
	});
	$("#li_opc_ctas_inl_3").on("click",function() {
		$(".li_opc_ctas_inl").removeClass("Highlight");
		$(this).addClass("Highlight");
		document.getElementById("hd_opc_ctas_inl").value = 3;
	});
	$("#li_opc_ctas_inl_4").on("click",function() {
		$(".li_opc_ctas_inl").removeClass("Highlight");
		$(this).addClass("Highlight");
		document.getElementById("hd_opc_ctas_inl").value = 4;
	});
	$("#li_opc_ctas_inl_5").on("click",function() {
		$(".li_opc_ctas_inl").removeClass("Highlight");
		$(this).addClass("Highlight");
		document.getElementById("hd_opc_ctas_inl").value = 5;
	});
	$("#li_opc_ctas_inl_6").on("click",function() {
		$(".li_opc_ctas_inl").removeClass("Highlight");
		$(this).addClass("Highlight");
		//Borrar lista de deudores con cuentas impagas pendientes de confirmar pago para que no vuelvan a generar este aviso
		//seguro? -- lista eleminada: exportar formato ahora (value = 2).
	});
	$("#li_opc_ctas_inl_7").on("click",function() {
		$(".li_opc_ctas_inl").removeClass("Highlight");
		$(this).addClass("Highlight");
		//Ver listado de personas con historial de cuentas sin liquidez que tienen una operación pendiente con una cuenta secundaria
	});
}
function js_debtAut_genera_archivoind( codigo_formato )
{   js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
	$('#modal_exportarFormatoArchivo').modal('show');
	document.getElementById('rb_filtro').checked = false;
	$("#cmb_banco option[value='']").remove();
	$("#cmb_tarjCredito option[value='']").remove();
	document.getElementById('cmb_banco').disabled = true;
	document.getElementById('cmb_tarjCredito').disabled = true;
	document.getElementById('cmb_banco').value = "";
	document.getElementById('cmb_tarjCredito').value = "";
    document.getElementById('cmb_formato_copyPaste').value = codigo_formato;
    var sel = document.getElementById('cmb_formato_copyPaste');
    var nombre_formato = sel.options[sel.selectedIndex].text;
	document.getElementById('forma_descripccion_exp').innerHTML = "'<b>" + nombre_formato + "</b>'";
    document.getElementById('hd_id_formato_exp').value = codigo_formato;

	$('#table_formato tbody tr').each(function(){
		if($(this).find('td').eq(0).attr('data-codigo') == codigo_formato )
		{
			if( $(this).find('td').eq(1).attr('data-source') == 'V_DatosAlumnosDebitos_Detalle' )
			{	document.getElementById( 'div_filtros_debitoBancario' ).style.display='inline';
			}
			else
				document.getElementById( 'div_filtros_debitoBancario' ).style.display='none';
		}
	});
}
function cambia_check(obj)
{   "use strict";
    var chk_nombre = obj.attributes["name"].value;
    var wordsToFind = ["izqi_", "*izqi_*"];
    var nombre = "";
    if (chk_nombre.toLowerCase().indexOf(wordsToFind[0]) === 0 || chk_nombre.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   nombre = chk_nombre.replace("izqi_", "");
        if(obj.checked)
        {   document.getElementById("caiz_" + nombre).disabled = false;
            document.getElementById("cade_" + nombre).disabled = true;
            document.getElementById("cade_" + nombre).value = "";
            document.getElementById("dere_" + nombre).checked = false;
        }else
        {   document.getElementById("caiz_" + nombre).disabled = true;
            document.getElementById("caiz_" + nombre).value = "";
        }
    }
    wordsToFind = ["dere_", "*dere_*"];
    if (chk_nombre.toLowerCase().indexOf(wordsToFind[0]) === 0 || chk_nombre.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   nombre = chk_nombre.replace("dere_", "");
        if(obj.checked)
        {   document.getElementById("cade_" + nombre).disabled = false;
            document.getElementById("caiz_" + nombre).disabled = true;
            document.getElementById("caiz_" + nombre).value = "";
            document.getElementById("izqi_" + nombre).checked = false;
        }else
        {   document.getElementById("cade_" + nombre).disabled = true;
            document.getElementById("cade_" + nombre).value = "";
        }
    }
}
function cambia_check_sec(obj)
{   "use strict";
    if(obj.checked)
    {   document.getElementById("secuencia").disabled=false;
        document.getElementById("ubicacion").disabled=false;
    }
    else
    {   document.getElementById("secuencia").disabled=true;
        document.getElementById("ubicacion").disabled=true;
        document.getElementById("secuencia").value="";
        document.getElementById("ubicacion").value="";
    }
    validate_save_button_followed(false);
}
function js_debtAut_change_view()
{   var vista = document.getElementById('cmb_vista').value;
    var r= confirm("Cambiar el recurso de datos implica iniciar un formato nuevo. ¿Terminar edición de formato actual? Los cambios no guardados se perderán.");
    if (r)
    {   limpia_crear_formato();
        document.getElementById('hd_nombreformato').value = "";
        document.getElementById('hd_id_cabecera').value = "";
        document.getElementById('span_info_formato').innerHTML = "";
    }
    var data = new FormData();
    data.append('event', 'cambiar_vista');
    data.append('vista', vista);
    var xhraf = new XMLHttpRequest();
    xhraf.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php', true);
    xhraf.onreadystatechange=function()
    {   if ( xhraf.readyState === 4 && xhraf.status === 200 )
        {   //$('#modal_cargarFormatoArchivo').modal('hide');
            document.getElementById('div_cmb_campos').innerHTML = xhraf.responseText;
            document.getElementById('hd_vista').value = vista;
            document.getElementById('cmb_vista').value = vista;
        }
    };
    xhraf.send(data);
}
function js_debitosAutomaticos_procesa_reprobados( e )
{
	if( e.checked )
	{   document.getElementById('textonook').disabled = false;
		document.getElementById('textonook').value = "";
	}
	else
	{   document.getElementById('textonook').disabled = true;
		document.getElementById('textonook').value = "";
	}
}
function js_debtAut_get_config()
{   var data = new FormData();
    data.append( 'event', 'get_debt_aut_settings' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById( 'modal_configSaf_body' ).innerHTML = xhr.responseText;
        }
    };
    xhr.send(data);
}

function js_debtAut_set_config ()
{   var data = new FormData();
	$( '#btn_debtAuto_set_config' ).button("loading");
    data.append( 'event', 'set_debt_aut_settings' );
	data.append( 'check_exp_opc_ant',  document.getElementById( 'check_exp_opc_ant' ).checked );
	data.append( 'check_exp_opc_ctas', document.getElementById( 'check_exp_opc_ctas' ).checked );
	var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   $('#modal_configSaf').modal('hide');
			var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
				document.getElementById( 'hd_exp_opc_ctas' ).value = ( document.getElementById( 'check_exp_opc_ctas').checked ? 'S' : 'N' );
				document.getElementById( 'hd_exp_opc_ant' ).value  = ( document.getElementById( 'check_exp_opc_ant' ).checked ? 'S' : 'N' );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa",message: "Hubo un problema al intentar comunicarse con el servicio." });
			}
			$( '#btn_debtAuto_set_config' ).button("reset");
        }
    };
    xhr.send(data);
}
function js_debtAuto_reset_ctas_inl_pdtes_confirm ()
{   $( '#btn_debtAuto_set_config' ).button("loading");
	$('#modal_delete_ctas_inl').modal('hide');
	document.getElementById( 'div_step_3' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Reseteando deudores.<br><br>Por favor, espere...</div>';

	var data = new FormData();
    data.append( 'event', 'reset_ctas_inl' );
	var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa",message: "Hubo un problema al intentar comunicarse con el servicio." });
			}
			js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );
        }
    };
    xhr.send(data);
}