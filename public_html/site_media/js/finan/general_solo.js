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
    
    $('#tabla_rptDeudores').DataTable({
        dom: 'Bfrtip',
        buttons: [ 
            { extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
            { extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
            { extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
            { extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
            ],
        //"iDisplayLength": -1,
        "bPaginate": true,
        "bStateSave": false,
        "bAutoWidth": false,
        //true
        "bScrollAutoCss": true,
        "bProcessing": true,
        "bRetrieve": true,
        //"bJQueryUI": true,
        //"sDom": 't',
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
            { "sWidth": "150px", "targets": [0] },
            { "sWidth": "300px", "targets": [2] },
            {className: "dt-body-center", "targets": [0]},
            {className: "dt-body-center", "targets": [1]},
            {className: "dt-body-left"  , "targets": [2]}
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
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
            $('#tabla_rptDeudores').DataTable({
                dom: 'Bfrtip',
                buttons: [ 
                    { extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
                    { extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
                    { extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
                    { extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
                    ],
                //"iDisplayLength": -1,
                "bPaginate": true,
                "bStateSave": false,
                "bAutoWidth": false,
                //true
                "bScrollAutoCss": true,
                "bProcessing": true,
                "bRetrieve": true,
                //"bJQueryUI": true,
                //"sDom": 't',
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