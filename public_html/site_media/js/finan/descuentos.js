// JavaScript Document
$(document).ready(function() {
    $('#descuento_table').DataTable({
        dom: 'Bfrtip',
        buttons: [ 
            { extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
            { extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
            { extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
            { extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
            { extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
            ],
        "bPaginate": true,
        "bStateSave": false,
        "bAutoWidth": false,
        "bScrollAutoCss": true,
        "bProcessing": true,
        "bRetrieve": true,
        "aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
        "sScrollXInner": "110%",
        "fnInitComplete": function() {
            this.css("visibility", "visible");
        },
        paging: true,
        lengthChange: true,
        searching: true,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center" , "targets": [0]},
            {className: "dt-body-center" , "targets": [1]},
            {className: "dt-body-center" , "targets": [2]},
            {className: "dt-body-center" , "targets": [3]},
            {className: "dt-body-center" , "targets": [4]},
            {className: "dt-body-center" , "targets": [5]}
        ]
    });
});
function js_tipo_descuento_busca( busq, div )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'get_all_data');
    data.append('busq', busq);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/tipo_descuento/controller.php' , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#descuento_table').DataTable({
                "bPaginate": true,
                "bStateSave": false,
                "bAutoWidth": false,
                "bScrollAutoCss": true,
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
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-center" , "targets": [1]},
                    {className: "dt-body-center" , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-center" , "targets": [5]}
                ]
            });
        }
    }
    xhr.send(data);
}
function js_tipo_descuento_del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar la descuento?"))
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('event', 'delete');
        data.append('desc_codigo', codigo);    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState==4 && xhr.status==200)
            {   var n = xhr.responseText.length;
                if (n > 0)
                    valida_tipo_growl(xhr.responseText);
                else
                    $.growl.warning({ title: "Educalinks informa", message: "Sin mensaje de confirmación. Por favor, verificar que todo esté en orden." });
                js_tipo_descuento_busca( 0, div );
            } 
        };
        xhr.send(data);
    }
}
function js_tipo_descuento_edit(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'get');
    data.append('desc_codigo', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
            $(function() {$('#porcentaje_mod').maskMoney({thousands:'', decimal:'.', allowZero:false});;})
            $('[data-toggle="popover"]').popover({html:true});    
            $( "#cmb_tipo_descuento" ).on('change', function(){
                console.log( this.value );
            });
        } 
    };
    xhr.send(data);
}
function js_tipo_descuento_carga_add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'agregar');    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $(function() {$('#porcentaje_add').maskMoney({thousands:'', decimal:'.', allowZero:false});;})
            $('[data-toggle="popover"]').popover({html:true});
            $( "#cmb_tipo_descuento" ).on('change', function() {
              console.log( this.value );
            });
        } 
    };
    xhr.send(data);
}
function js_tipo_descuento_add(div,url)
{   var bandera = 1;
    if ( document.getElementById('descripcion_add').value.length === 0 )
    {   bandera = 0;
        $.growl.warning({ title: "Educalinks informa",message: "Debe indicar la descripción del descuento." });
    }
    if ( document.getElementById('porcentaje_add').value.length === 0 )
    {   bandera = 0;
        $.growl.warning({ title: "Educalinks informa",message: "Debe indicar el porcentaje de descuento." });
    }
    if ( document.getElementById('porcentaje_add').value > 100 )
    {   bandera = 0;
        $.growl.warning({ title: "Educalinks informa",message: "Porcentaje no puede ser mayor a 100%." });
    }
    if ( bandera === 1 )
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('event', 'set');
        data.append('desc_porcentaje', document.getElementById('porcentaje_add').value);
        data.append('desc_descripcion', document.getElementById('descripcion_add').value);
        data.append('desc_tipo', document.getElementById('cmb_tipo_descuento').value);
        data.append('prontopago', document.getElementById('aplicaprontopago_add').checked);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function(){
            if (xhr.readyState==4 && xhr.status==200)
            {   $('#modal_add').modal('hide');
                var n = xhr.responseText.length;
				if (n > 0)
                    valida_tipo_growl(xhr.responseText);
                else
                    $.growl.warning({ title: "Educalinks informa", message: "Sin mensaje de confirmación. Por favor, verificar que todo esté en orden." });
                js_tipo_descuento_busca( 0, div );
            }
        }
        xhr.send(data);
    }
}
function js_tipo_descuento_save_edited( rol_codigo, div, url )
{   var bandera = 1;
    if ( document.getElementById('descripcion_mod').value.length === 0 )
    {   bandera = 0;
        $.growl.warning({ title: "Educalinks informa",message: "Debe indicar la descripción del descuento." });
    }
    if ( document.getElementById('porcentaje_mod').value.length === 0 )
    {   bandera = 0;
        $.growl.warning({ title: "Educalinks informa",message: "Debe indicar el porcentaje de descuento." });
    }
    if ( document.getElementById('porcentaje_mod').value > 100 )
    {   bandera = 0;
        $.growl.warning({ title: "Educalinks informa",message: "Porcentaje no puede ser mayor a 100%." });
    }
    if ( bandera === 1 )
    {   if(confirm("¿Está seguro que desea editar la información de la descuento?"))
        {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
            var data = new FormData();
            data.append('event', 'edit');
            data.append('desc_codigo', document.getElementById('codigo_mod').value);
            data.append('desc_descripcion', document.getElementById('descripcion_mod').value);
            data.append('desc_porcentaje', document.getElementById('porcentaje_mod').value);
            data.append('prontopago', document.getElementById('aplicaprontopago_mod').checked);
            data.append('desc_estado', 'A');
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', url , true);
            xhr.onreadystatechange=function()
            {   if (xhr.readyState==4 && xhr.status==200)
                {   $('#modal_edit').modal('hide');
                    var n = xhr.responseText.length;
                    if (n > 0)
                        valida_tipo_growl(xhr.responseText);
                    else
                        $.growl.warning({ title: "Educalinks informa", message: "Sin mensaje de confirmación. Por favor, verificar que todo esté en orden." });
                    js_tipo_descuento_busca( 0, div );
                } 
            };
            xhr.send(data);
        }
    }
}