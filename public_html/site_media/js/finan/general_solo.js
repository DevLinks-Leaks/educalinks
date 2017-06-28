$(document).ready(function() {
    actualiza_badge_gest_fact();
    $("#txt_fecha_ini").datepicker();
    $("#txt_fecha_fin").datepicker();
    //$("#cmb_producto").select2();
	
	let $select2 = $('#cmb_producto').select2();

	/**
	 * defaults: Cache order of the initial values
	 * @type {object}
	 */
	let defaults = $select2.select2('data');
	defaults.forEach(obj=>{
		let order = $select2.data('preserved-order') || [];
		order[ order.length ] = obj.id;
		$select2.data('preserved-order', order)
	});

	$select2.on('select2:select select2:unselect', selectionHandler);

	//runDemo($select2);
	
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).text(); //$(e.target).attr("href") 
        //console.log(target);
        if( target == ' Tablas' )
            document.getElementById('div_cmb_producto').style.display = 'block';
        else
            document.getElementById('div_cmb_producto').style.display = 'none';
    });
    
    $("#boton_busqueda").click(function(){
        $("#desplegable_busqueda").slideToggle(200);
    });
    $("#desplegable_busqueda").show();
    
    $('#tabla_rptDeudores').addClass( 'nowrap' ).DataTable({
		dom: '<"toolbar">Bfrtip',
		buttons: [
			{ text: '<i style="color:#3c8dbc" class="fa fa-search"></i>',
			  action: function ( e, dt, node, config ) {
				js_general_cargaDeudores('deudas_tablas',document.getElementById('ruta_html_finan').value + '/general/controller.php');
			  }
			},
			{ text: '<span class="hidden-sm hidden-xs">PDF </span><i style="color:red;" class="fa fa-file-pdf-o"></i>',
			  action: function ( e, dt, node, config ) {
				carga_reports_deudores('modal-deudoresbody',document.getElementById('ruta_html_finan').value + '/general/controller.php','print_deudores');
			  }
			},
			{ extend: 'excel', 	text: '<span class="hidden-sm hidden-xs">Excel </span><i style="color:green" class="fa fa-file-excel-o"></i>' },
			{ extend: 'copy', 	text: '<span class="hidden-sm hidden-xs">Copiar </span><i class="fa fa-copy"></i>' },
			{ extend: 'print', 	text: '<span class="hidden-sm hidden-xs">Imprimir </span><i style="color:#428bca" class="fa fa-print"></i>' },
			{ extend: 'colvis', text: '<span class="hidden-sm hidden-xs">Columnas </span><i class="fa fa-eye"></i>' },
		]
	});
    $('#tbl_reportes_generales').DataTable({
        lengthChange: false,
        searching: false,
        paging:false,
        bInfo: false,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-head-left", "targets": [0]},
            {className: "dt-head-center", "targets": [1]},
            {className: "dt-head-center", "targets": [2]},
            {className: "dt-body-left"    , "targets": [0]},
            {className: "dt-body-center", "targets": [1]},
            {className: "dt-body-center", "targets": [2]}
        ]
    });
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
        var table = $('#tabla_rptDeudores').DataTable();
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    });
});
/**
 * select2_renderselections
 * @param  {jQuery Select2 object}
 * @return {null}
 */
function select2_renderSelections($select2){
	const order      = $select2.data('preserved-order') || [];
	const $container = $select2.next('.select2-container');
	const $tags      = $container.find('li.select2-selection__choice');
	const $input     = $tags.last().next();

	// apply tag order
	order.forEach(val=>{
		let $el = $tags.filter(function(i,tag){
			return $(tag).data('data').id === val;
		});
		$input.before( $el );
	});
}


/**
 * selectionHandler
 * @param  {Select2 Event Object}
 * @return {null}
 */
function selectionHandler(e){
	const $select2  = $(this);
	const val       = e.params.data.id;
	const order     = $select2.data('preserved-order') || [];

	switch (e.type){
		case 'select2:select':      
			order[ order.length ] = val;
		break;
		case 'select2:unselect':
			let found_index = order.indexOf(val);
			if (found_index >= 0 )
				order.splice(found_index,1);
		break;
	}
	$select2.data('preserved-order', order); // store it for later
	select2_renderSelections($select2);
}
function js_general_cargaDeudores( div, url )
{   "use strict";
	$('#li_deudas_reportes').removeClass('active');
	$('#li_deudas_tablas').addClass('active');
	document.getElementById('div_cmb_producto').style.display = 'block';
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:#E55A2F;" class="fa fa-cog fa-spin"></i></div>';
    var comboCursos = document.getElementById("curso");
    var comboNivelEcon = document.getElementById("cmb_nivelesEconomicos");
    var comboPeriodos = document.getElementById("periodos");
    var dtpfechavenc_ini = document.getElementById("txt_fecha_ini");
    var dtpfechavenc_fin = document.getElementById("txt_fecha_fin");
    var quienes = document.querySelector('input[id="rdb_quienes"]:checked').value;
    var data = new FormData();
    data.append('curs_codi', comboCursos.value);
    data.append('nivelEcon_codi', comboNivelEcon.value);
    data.append('peri_codi', comboPeriodos.value);
    data.append('fechavenc_ini', dtpfechavenc_ini.value);
    data.append('fechavenc_fin', dtpfechavenc_fin.value);
    data.append('quienes', quienes);
    var productos = []; 
    let $select2 = $('#cmb_producto').select2();
	select2_renderSelections($select2);
	
    $('#cmb_producto :selected').each(function(i, selected){ 
		productos[i] = $(selected).val();
    });
    data.append('prod_codigo', JSON.stringify( $select2.data('preserved-order') ) );
    //console.log(JSON.stringify( productos ));
    data.append('event', 'get_deudores');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#tabla_rptDeudores').addClass( 'nowrap' ).DataTable({
                dom: '<"toolbar">Bfrtip',
				buttons: [
					{ text: '<i style="color:#3c8dbc" class="fa fa-search"></i>',
					  action: function ( e, dt, node, config ) {
						js_general_cargaDeudores('deudas_tablas',document.getElementById('ruta_html_finan').value + '/general/controller.php');
					  }
					},
					{ text: '<span class="hidden-sm hidden-xs">PDF </span><i style="color:red;" class="fa fa-file-pdf-o"></i>',
					  action: function ( e, dt, node, config ) {
						carga_reports_deudores('modal-deudoresbody',document.getElementById('ruta_html_finan').value + '/general/controller.php','print_deudores');
					  }
					},
					{ extend: 'excel', 	text: '<span class="hidden-sm hidden-xs">Excel </span><i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'copy', 	text: '<span class="hidden-sm hidden-xs">Copiar </span><i class="fa fa-copy"></i>' },
					{ extend: 'print', 	text: '<span class="hidden-sm hidden-xs">Imprimir </span><i style="color:#428bca" class="fa fa-print"></i>' },
					{ extend: 'colvis', text: '<span class="hidden-sm hidden-xs">Columnas </span><i class="fa fa-eye"></i>' },
				],
				"bPaginate": true,
				"bStateSave": false,
				"bAutoWidth": false,
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
				"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
				"sScrollXInner": "110%",
				"sScrollY": "450px",
				"fnInitComplete": function() {
					this.css("visibility", "visible");
				},
				paging: true,
				lengthChange: true,
				searching: true,
				lengthChange: false,
				responsive: true,
				orderClasses: true,
				"bFilter": false,
				"sScrollX": "100%",
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{ "sWidth": "150px", "targets": [0] },
					{ "sWidth": "300px", "targets": [2] },
					{className: "dt-body-center", "targets": [0]},
					{className: "dt-body-center", "targets": [1]},
					{className: "dt-body-left"  , "targets": [2]}
				]
            });
            
            $("#boton_columnas").click(function(){
                $("#desplegable").slideToggle(200);
            });
            $("#desplegable").show();
            $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();
                var table = $('#tabla_rptDeudores').DataTable();
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
                // Toggle the visibility
                column.visible( ! column.visible() );
            });
        }
    };
    xhr.send(data);
}
function carga_reports_deudores( div, url, evento ) //PDF DE LA TABLA PRINCIPAL CON TOTALES VERTICALES Y HORIZONTALES
{   "use strict";
    var doit = 'yes';
    if ( ( document.getElementById('curso').value == -1 ) || ( document.getElementById('curso').value == 0 ) )
    {   $('#modal_msg').modal('show');
        document.getElementById('modal_msg_body').innerHTML='¡Debe seleccionar un curso para poder imprimir esta opción!';
        doit = 'no';
    }
	console.log(doit);
    if( doit === 'yes' )
    {   var curso =0;
        var fecha_ini='';
        var fecha_fin='';
        var nivelEcon='';
        if(document.getElementById('txt_fecha_ini').value.length>0)
        {    fecha_ini= document.getElementById('txt_fecha_ini').value;
        }
        else
        {    fecha_ini='';
        }
        if(document.getElementById('txt_fecha_fin').value.length>0)
        {    fecha_fin= document.getElementById('txt_fecha_fin').value;
        }
        else
        {    fecha_fin='';
        }
        if(document.getElementById('curso').value!=-1)
        {    curso= document.getElementById('curso').value;
        }
        else
        {    curso='';
        }
        if(document.getElementById('cmb_nivelesEconomicos').value!=-1)
        {    nivelEcon= document.getElementById('cmb_nivelesEconomicos').value;
        }
        else
        {    nivelEcon='';
        }
        var periodos= document.getElementById('periodos').value;
        var quienes = document.querySelector('input[id="rdb_quienes"]:checked').value;
        var productos = $("#cmb_producto").val();
        var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin+'&quienes='+quienes+'&productos='+productos;
        console.log(url2);
        window.open(url2);
    }
}
function carga_reports_deudores_rept(div,url,evento)
{   "use strict";
    var doit = 'yes';
    if(evento == 'print_deudores_curso_detalle' || (evento == 'print_deudores_mensual_detalle'))
    {   if ( ( document.getElementById('curso').value == -1 ) || ( document.getElementById('curso').value == 0 ) )
        {   $('#modal_msg').modal('show');
            document.getElementById('modal_msg_body').innerHTML='¡Debe seleccionar un curso para poder imprimir esta opción!';
            doit = 'no';
        }
    }
    if( doit === 'yes' )
    {   var curso =0;
        var fecha_ini='';
        var fecha_fin='';
        var nivelEcon='';
        if(document.getElementById('txt_fecha_ini').value.length>0)
        {    fecha_ini= document.getElementById('txt_fecha_ini').value;
        }
        else
        {    fecha_ini='';
        }
        if(document.getElementById('txt_fecha_fin').value.length>0)
        {    fecha_fin= document.getElementById('txt_fecha_fin').value;
        }
        else
        {    fecha_fin='';
        }
        if(document.getElementById('curso').value!=-1)
        {    curso= document.getElementById('curso').value;
        }
        else
        {    curso='';
        }
        if(document.getElementById('cmb_nivelesEconomicos').value!=-1)
        {    nivelEcon= document.getElementById('cmb_nivelesEconomicos').value;
        }
        else
        {    nivelEcon='';
        }
        var periodos = document.getElementById('periodos').value;
        var productos = $("#cmb_producto").val();
        var quienes = document.querySelector('input[id="rdb_quienes"]:checked').value;
        var url2=url+'?event=print_deuda_rept&eventox='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin+'&quienes='+quienes+'&productos='+productos;
        window.open(url2);
    }
}

function carga_reports_deudores_rept_xls(div,url,evento)
{   "use strict";
    var curso =0;
    var fecha_ini='';
    var fecha_fin='';
    var nivelEcon='';
    if(document.getElementById('txt_fecha_ini').value.length>0)
    {    fecha_ini= document.getElementById('txt_fecha_ini').value;
    }
    else
    {    fecha_ini='';
    }
    if(document.getElementById('txt_fecha_fin').value.length>0)
    {    fecha_fin= document.getElementById('txt_fecha_fin').value;
    }
    else
    {    fecha_fin='';
    }
    if(document.getElementById('curso').value!=-1)
    {    curso= document.getElementById('curso').value;
    }
    else
    {    curso='';
    }
    if(document.getElementById('cmb_nivelesEconomicos').value!=-1)
    {    nivelEcon= document.getElementById('cmb_nivelesEconomicos').value;
    }
    else
    {    nivelEcon='';
    }
    var periodos = document.getElementById('periodos').value;
    var quienes = document.querySelector('input[id="rdb_quienes"]:checked').value;
    var url2=url+'?event=print_deuda_rept_xls&eventox='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin+'&quienes='+quienes;
    window.open(url2);
}

function js_general_close_and_open_cash()
{   var prev = document.getElementById( 'div_caja_antigua_abierta' ).innerHTML;

	document.getElementById( 'div_caja_antigua_abierta' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:white;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'close_and_open_cash' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   if( xhr.responseText == 'OK' )
			{   document.getElementById( 'div_caja_antigua_abierta' ).style.display = 'none';
				$.growl.notice({title: 'Educalinks Informa', message: 'Caja anterior cerrada y caja de hoy abierta'});
			}
			if( xhr.responseText == 'KO' )
			{
				document.getElementById( 'div_caja_antigua_abierta' ).innerHTML = prev;
				$.growl.error({title: 'Educalinks Informa', message: 'No se pudo realizar el proceso'});
			}
        }
    };
    xhr.send(data);
}