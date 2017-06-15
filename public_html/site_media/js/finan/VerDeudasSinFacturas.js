$(document).ready(function() {
    $("#txt_fecha_ini").datepicker();
    $("#txt_fecha_fin").datepicker();
    $("#txt_fecha_deuda_ini").datepicker();
    $("#txt_fecha_deuda_fin").datepicker();
    $("#txt_fecha_aut_ini").datepicker({ format: 'yyyy-mm-dd' });
    $("#txt_fecha_aut_fin").datepicker({ format: 'yyyy-mm-dd' });
    $("#txt_fecha_aut_ini").inputmask({
        mask: "y-1-2", 
        placeholder: "yyyy-mm-dd", 
        leapday: "-02-29", 
        separator: "-", 
        alias: "yyyy/mm/dd"
    });
    $("#txt_fecha_aut_fin").inputmask({
        mask: "y-1-2", 
        placeholder: "yyyy-mm-dd", 
        leapday: "-02-29", 
        separator: "-", 
        alias: "yyyy/mm/dd"
    });
    $("#cmb_producto").select2();
    $("#txt_tneto_ini").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
    $("#txt_tneto_fin").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
    $("#boton_busqueda").click(function(){
        $("#desplegable_busqueda").slideToggle(200);
    });
});
function js_verDeudasSinFacturas_to_excel_tipoDocumentoAutorizado( evento, tipo_reporte )
{   document.getElementById( 'evento' ).value = evento;
    document.getElementById( 'tipo_reporte' ).value = tipo_reporte;
    document.getElementById( 'file_form' ).submit();
}
function js_verDeudasSinFacturas_carga_DSF(div)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    var fechavenc_ini = document.getElementById("txt_fecha_ini").value;
    var fechavenc_fin = document.getElementById("txt_fecha_fin").value;
    var data = new FormData();
    data.append('event', 'get_all_data');
    data.append('tipoDocumentoAutorizado', 'FAC');
    data.append('fechavenc_ini', fechavenc_ini);
    data.append('fechavenc_fin', fechavenc_fin);
    var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
    data.append('ckb_opc_adv', ckb_opc_adv);
    if(ckb_opc_adv)
    {   data.append('estadoElectronico', document.getElementById("cmb_estadoElectronico").value);
        data.append('id_titular', document.getElementById("txt_id_titular").value);
        data.append('cod_estudiante', document.getElementById("txt_cod_cliente").value);
        data.append('nombre_estudiante', document.getElementById("txt_nom_cliente").value);
        data.append('nombre_titular', document.getElementById("txt_nom_titular").value);
        data.append('ptvo_venta', document.getElementById("txt_ptoVenta").value);
        data.append('sucursal', document.getElementById("txt_sucursal").value);
        data.append('ref_factura', document.getElementById("txt_ref_factura").value);
        var productos = []; 
        $('#cmb_producto :selected').each(function(i, selected){ 
          productos[i] = $(selected).val(); 
        });
        data.append('prod_codigo', JSON.stringify( productos ) );
        console.log(JSON.stringify( productos ));
        data.append('estado', document.getElementById("cmb_estado").value);
        var chk_tneto = document.getElementById("chk_tneto").checked;
        if(chk_tneto)
        {   data.append('tneto_ini', document.getElementById("txt_tneto_ini").value);
            data.append('tneto_fin', document.getElementById("txt_tneto_fin").value);
        }
        var chk_fechadeuda = document.getElementById("chk_fecha_deuda").checked;
        if(chk_fechadeuda)
        {   data.append('fechadeuda_ini', document.getElementById("txt_fecha_deuda_ini").value);
            data.append('fechadeuda_fin', document.getElementById("txt_fecha_deuda_fin").value);
        }
        var chk_fechaAut = document.getElementById("chk_fecha_aut").checked;
        if(chk_fechaAut)
        {   data.append('fechaAut_ini', document.getElementById("txt_fecha_aut_ini").value);
            data.append('fechaAut_fin', document.getElementById("txt_fecha_aut_fin").value);
        }
        data.append('periodo', document.getElementById("periodos").value);
        data.append('grupoEconomico', document.getElementById("cmb_grupoEconomico").value);
        data.append('nivelEconomico', document.getElementById("cmb_nivelesEconomicos").value);
        data.append('curso', document.getElementById("curso").value);
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/verDeudasSinFacturas/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $(".detalle").tooltip({
                'html':         true,
                'selector':     '',
                'placement':     'bottom',
                'container':     'body',
                'tooltipClass': 'detalleTooltip'
            });
            var table = $('#facturasPendiente_table').DataTable({
                "bPaginate": true,
                "bStateSave": false,
                "bAutoWidth": false,
                "bScrollAutoCss": true,
                "bProcessing": true,
                "bRetrieve": true,
                "sDom": '<"H"CTrf>t<"F"lip>',
                "aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
                "sScrollX": "100%", 
                "bScrollCollapse": true,
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
                    {className: "dt-body-right"  , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-center" , "targets": [5]},
                    {className: "dt-body-center" , "targets": [6]},
                    {className: "dt-body-center" , "targets": [7]}
                ]
            });
            table.page.len(10).draw();
            table.column( '5:visible' ).order( 'desc' );
            $('#facturasPendiente_table tbody').on('click', 'td.details-control', function ()
            {   var tr = $(this).closest('tr');
                var row = table.row(tr);
                if ( row.child.isShown() )
                {   // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
                    $(this).find('i').css("color", "green");
                }
                else
                {   $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
                    $(this).find('i').css("color", "red");
                    var facturaCliente = [];
                    facturaCliente = row.data();
                    cabefact_codigo  = facturaCliente[1];
                    cabefact_codigo  = cabefact_codigo.replace('<div style="font-size:11px;">','');
                    cabefact_codigo  = cabefact_codigo.replace('</div>','');
                    if( facturaCliente )
                    {   $("#modal_wait").modal('show');
                        var data2 = new FormData();
                        data2.append('event', 'get_payments');
                        data2.append('num_factura', cabefact_codigo);
                        data2.append('bandeja_factura', 'SI');
                        var xhrII = new XMLHttpRequest();
                        xhrII.open('POST',document.getElementById('ruta_html_finan').value+'/pagos/controller.php', true);
                        xhrII.onreadystatechange=function()
                        {   if ( xhrII.readyState === 4 && xhrII.status === 200 )
                            {   // Open this row
                                $("#modal_wait").modal('hide');
                                row.child(xhrII.responseText).show();
                                tr.addClass('shown');
                                var table_deuda = $( '#pagosRealizados_table_' + cabefact_codigo ).DataTable({
                                    language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                                    "lengthChange": false,
                                    searching: false,
                                    paging:false,
                                    info:false,
                                    "order":[[4, 'asc']],
                                    "columnDefs": [
                                        {className: "dt-body-center" , "targets": [0]},
                                        {className: "dt-body-center" , "targets": [1], "visible": false},
                                        {className: "dt-body-right"  , "targets": [2]},
                                        {className: "dt-body-right"  , "targets": [3]},
                                        {className: "dt-body-center" , "targets": [4], "visible": false},
                                        {className: "dt-body-center" , "targets": [5], "visible": false},
                                        {className: "dt-body-center" , "targets": [6], "visible": false},
                                        {className: "dt-body-center" , "targets": [7], "visible": false},
                                        {className: "dt-body-center" , "targets": [8]},
                                        {className: "dt-body-center" , "targets": [9]},
                                        {className: "dt-body-center" , "targets":[12], "visible": false}
                                    ],
                                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                        $('td', nRow).css('background-color', '#d6f9da');
                                    }
                                });    
                            }
                        };
                        xhrII.send(data2);
                    }
                }
            });
        }
    };
    xhr.send(data);
}
function js_verDeudasSinFacturas_convertToFAC( codigo )
{   document.getElementById( 'hd_codigoFactura_convertToFAC' ).value = codigo;
    document.getElementById( 'txt_num_sucursal' ).value = '';
    $( '#txt_num_sucursal' ).data('sucu_codigo','');
    document.getElementById( 'txt_num_ptoVenta' ).value = '';
    $( '#txt_num_ptoVenta' ).data('puntvent_codigo','');
    document.getElementById( 'txt_num_factura' ).value = '';
    
    document.getElementById( 'modal_convertToFac_step1' ).innerHTML = '¿Está seguro que desea convertir la deuda en factura?<br><br>'+
                    'Esto hará que aparezca una factura más en la bandeja de gestión factura para enviarla al SRI.';
    
    document.getElementById( 'modal_convertToFac_step1' ).style.display = 'inline';
    document.getElementById( 'btn_convertToFac_step1' ).style.display = 'inline';
    
    document.getElementById( 'modal_convertToFac_step2' ).style.display = 'none';
    document.getElementById( 'btn_convertToFac_step2' ).style.display = 'none';
}
function js_verDeudasSinFacturas_convertToFAC_followed( )
{   document.getElementById( 'modal_convertToFac_step1' ).style.display = 'none';
    document.getElementById( 'btn_convertToFac_step1' ).style.display = 'none';
    
    document.getElementById( 'modal_convertToFac_step2' ).style.display = 'inline';
    document.getElementById( 'btn_convertToFac_step2' ).style.display = 'inline';
}
function js_verDeudasSinFacturas_convertToFAC_followed2(  )
{   var letdoit = 'yes';
    
    if (document.getElementById( 'txt_num_sucursal' ).value == '' )
        letdoit = 'no'
    if ( document.getElementById( 'txt_num_ptoVenta' ).value == '' )
        letdoit = 'no'
    if ( document.getElementById( 'txt_num_factura' ).value == '' )
        letdoit = 'no'
    
    if ( letdoit === 'yes' )
    {   document.getElementById( 'modal_convertToFac_step1' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>';
        document.getElementById( 'modal_convertToFac_step1' ).style.display = 'inline';
        document.getElementById( 'btn_convertToFac_step1' ).style.display = 'none';
        
        var data = new FormData();
        data.append( 'event', 'convert_to_fac' );
        data.append( 'codigoDocumento', document.getElementById( 'hd_codigoFactura_convertToFAC' ).value );
        data.append( 'sucursal', document.getElementById( 'txt_num_sucursal' ).value );
        data.append( 'ptoVenta', document.getElementById( 'txt_num_ptoVenta' ).value );
        data.append( 'puntoVenta_codigo', $( '#txt_num_ptoVenta' ).data('puntvent_codigo') );
        data.append( 'numeroFactura', document.getElementById( 'txt_num_factura' ).value );
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', document.getElementById('ruta_html_finan').value + '/verDeudasSinFacturas/controller.php' , true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   var n = xhr.responseText.length;
                if (n > 0)
                    valida_tipo_growl(xhr.responseText);
                else
                    $.growl.warning({ title: "Educalinks informa",message: "Proceso realizado." });
                $('#modal_convertToFac').modal('hide');
				js_verDeudasSinFacturas_carga_DSF('tabla_consulta_tipoDocumentoAutorizado');
            }
        };
        xhr.send(data);
    }
    else
        $.growl.warning({ title: "Educalinks informa",message: "Los campos de No. Factura son obligatorios" });
}
function js_verDeudasSinFacturas_fechaAut()
{   var chk_tneto = document.getElementById("chk_fecha_aut").checked;
    if(chk_tneto)
    {   document.getElementById("txt_fecha_aut_ini").disabled = false;
        document.getElementById("txt_fecha_aut_fin").disabled = false;
    }
    else
    {   document.getElementById("txt_fecha_aut_ini").disabled = true;
        document.getElementById("txt_fecha_aut_fin").disabled = true;
        document.getElementById("txt_fecha_aut_ini").value = "";
        document.getElementById("txt_fecha_aut_fin").value = "";
    }
}
function check_opc_avanzadas()
{   var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
    if(ckb_opc_adv)
    {   $("#div_opc_adv").collapse(200).collapse('show');
    }
    else
    {   $("#div_opc_adv").collapse(200).collapse('hide');
    }
}
function check_tneto()
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

function js_verDeudasSinFacturas_check_fechadeuda()
{    var chk_tneto = document.getElementById("chk_fecha_deuda").checked;
    if(chk_tneto)
    {   document.getElementById("txt_fecha_deuda_ini").disabled = false;
        document.getElementById("txt_fecha_deuda_fin").disabled = false;
    }
    else
    {   document.getElementById("txt_fecha_deuda_ini").disabled = true;
        document.getElementById("txt_fecha_deuda_fin").disabled = true;
        document.getElementById("txt_fecha_deuda_ini").value = "";
        document.getElementById("txt_fecha_deuda_fin").value = "";
    }
}

function js_verDeudasSinFacturas_select_sucursal()
{   $('#modal_select_sucursal').modal("show");
}
function js_verDeudasSinFacturas_select_ptoVenta()
{   if( $('#txt_num_sucursal').val() != '' )
    {   var data = new FormData();
        data.append('event', 'get_ptoventas');
        data.append('sucursal', $('#txt_num_sucursal').data("sucu_codigo") );
        var xhr = new XMLHttpRequest();
        xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200 )
            {   var boton = '<span class="input-group-btn">'+
                                '<button type="button" class="btn btn-info btn-flat" onclick="js_verDeudasSinFacturas_select_ptoVenta_followed();">Seleccionar</button>'+
                            '</span>';
                document.getElementById("div_cmb_ptoVenta").innerHTML = xhr.responseText + boton;
                $('#modal_select_ptoVenta').modal("show");
            }
        };
        xhr.send(data);
    }
    else
        $.growl.error({ title: "Educalinks informa", message: "Seleccione primero una sucursal" });
}
function js_verDeudasSinFacturas_select_numeroFactura()
{   if( $('#txt_num_ptoVenta').val() != '' )
    {   var data = new FormData();
        data.append('event', 'get_numerosfacturas');
        data.append('puntoVenta', $('#txt_num_ptoVenta').data("puntvent_codigo") );
        var xhr = new XMLHttpRequest();
        xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200 )
            {   var boton = '<span class="input-group-btn">'+
                                '<button type="button" class="btn btn-info btn-flat" onclick="js_verDeudasSinFacturas_select_numeroFactura_followed();">Seleccionar</button>'+
                            '</span>';
                document.getElementById("div_cmb_numeroFactura").innerHTML = xhr.responseText + boton;
                $('#modal_select_numeroFactura').modal("show");
            }
        };
        xhr.send(data);
    }
    else
        $.growl.error({ title: "Educalinks informa", message: "Seleccione primero un punto de venta" });
}
function js_verDeudasSinFacturas_select_sucursal_followed()
{   $('#modal_select_sucursal').modal("hide");
    document.getElementById('txt_num_sucursal').value = document.getElementById('pto_sucursal').value;
    $('#txt_num_sucursal').data("sucu_codigo", $('#pto_sucursal').find(':selected').data("sucu_codigo") );
}
function js_verDeudasSinFacturas_select_ptoVenta_followed()
{   $('#modal_select_ptoVenta').modal("hide");
    document.getElementById('txt_num_ptoVenta').value = document.getElementById('cmb_ptoVenta').value;
    $('#txt_num_ptoVenta').data("puntvent_codigo", $('#cmb_ptoVenta').find(':selected').data("puntvent_codigo") );
}
function js_verDeudasSinFacturas_select_numeroFactura_followed()
{   $('#modal_select_numeroFactura').modal("hide");
    document.getElementById('txt_num_factura').value = document.getElementById('cmb_numeroFactura').value;
}