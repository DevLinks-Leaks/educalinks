/**
 * Created by Robert on 10/06/2015.
 */
function js_rep_caja_saldos_carga_reports( evento )
{   document.getElementById( 'evento' ).value = evento;
    document.getElementById( 'tipo_reporte' ).value = tipo_reporte;
	document.getElementById( 'file_form' ).submit();
}
function js_rep_caja_saldos_carga_PagosRealizados(div )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    
	var data = new FormData();
    data.append('event', 'print_saf');
    data.append('fechavenc_ini', document.getElementById("txt_fecha_ini").value);
    data.append('fechavenc_fin', document.getElementById("txt_fecha_fin").value);
    var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
	data.append('ckb_opc_adv', ckb_opc_adv);
    if(ckb_opc_adv)
    {   data.append('codigo_pago', document.getElementById("txt_codigo_pago").value);
        data.append('id_titular', document.getElementById("txt_id_titular").value);
        data.append('cod_estudiante', document.getElementById("txt_cod_cliente").value);
        data.append('nombre_estudiante', document.getElementById("txt_nom_cliente").value);
        data.append('nombre_titular', document.getElementById("txt_nom_titular").value);
        data.append('ptvo_venta', document.getElementById("txt_ptoVenta").value);
        data.append('sucursal', document.getElementById("txt_sucursal").value);
        data.append('num_factura', document.getElementById("txt_num_factura").value);
        data.append('categoria_codigo', document.getElementById("cmb_categoria").value);
		var productos = []; 
		$('#cmb_producto :selected').each(function(i, selected){ 
		  productos[i] = $(selected).val(); 
		});
        data.append('prod_codigo', JSON.stringify( productos ) );
        data.append('forma_pago', document.getElementById("cmb_forma_pago").value);
        data.append('tneto_fin', document.getElementById("txt_tneto_fin").value);
        data.append('tneto_ini', document.getElementById("txt_tneto_ini").value);
        data.append('usuario_cajero', document.getElementById("cmb_usuario_cajero").value);
        data.append('periodo', document.getElementById("periodos").value);
        data.append('grupoEconomico', document.getElementById("cmb_grupoEconomico").value);
        data.append('nivelEconomico', document.getElementById("cmb_nivelesEconomicos").value);
        data.append('cursos', document.getElementById("curso").value);
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/cierre_caja/controller.php' , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
			
			var table_pagos = $('#pagosRealizados_table').DataTable({
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
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
			});
			if (!tipo_visual)
				table_pagos.column( '6:visible' ).order( 'desc' );
			if (tipo_visual == 1)
				table_pagos.column( '6:visible' ).order( 'desc' );
			if (tipo_visual == 2)
				table_pagos.column( '5:visible' ).order( 'desc' );
			$('#pagosRealizados_table tbody').on('click', 'td.details-control', function ()
			{   var tr = $(this).closest('tr');
				var row = table_pagos.row(tr);
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
					var pagoCliente = [];
					pagoCliente = row.data();
					console.log(pagoCliente[1]);
					cabePago_codigo  = pagoCliente[1];
					if( pagoCliente )
					{   $("#modal_wait").modal('show');
						var data2 = new FormData();
						data2.append('event', 'get_facturas_by_payment');
						data2.append('cabePago_codigo', cabePago_codigo);
						var xhrII = new XMLHttpRequest();
						xhrII.open('POST', document.getElementById('ruta_html_finan').value + '/verDocumentosAutorizados/controller.php' , true);
						xhrII.onreadystatechange=function()
						{   if ( xhrII.readyState === 4 && xhrII.status === 200 )
							{   // Open this row
								$("#modal_wait").modal('hide');
								row.child(xhrII.responseText).show();
								tr.addClass('shown');
								
								$(".detalle").tooltip({
									'html':         true,
									'selector':     '',
									'placement':     'bottom',
									'container':     'body',
									'tooltipClass': 'detalleTooltip'
								});
							}
						};
						xhrII.send(data2);
					}
				}
			});
        }
    }
    xhr.send(data);
}
function js_rep_caja_saldos_check_opc_avanzadas()
{   var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
    if(ckb_opc_adv)
    {   $("#div_opc_adv").collapse(200).collapse('show');
    }
    else
    {   $("#div_opc_adv").collapse(200).collapse('hide');
    }
}
function js_rep_caja_saldos_check_tneto()
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