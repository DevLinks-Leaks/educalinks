<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>{proyecto} | {subtitulo}</title>
	
	{css_all}
	<style >
		td.details-control {
			background: url('{ruta_imagenes_common}/details_open.png') no-repeat center center;
			cursor: pointer;
		}
		tr.shown td.details-control {
			background: url('{ruta_imagenes_common}/details_close.png') no-repeat center center;
		}
		.input{
			padding: 0;
			margin: 0;
		}
		div.to0ltip-inner {
			max-width: 300px;
		}
		div.tooltip
		{
			word-wrap: break-word;
		}
		.detalleTooltip{
			background: #fff;
			color: #fff;
			border-radius:4px;
			box-shadow: 5px 5px 8px #CCC;
		}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini {sidebar_status}">
    <div class="wrapper">
		{navbar}
		{menu}
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					{subtitulo}
					<small>{mensaje}</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-home"></i> Supervisor</a></li>
					<li class="active">{subtitulo}</li>
				</ol>
			</section>
			<section class="content" id="formulario">
				{formulario}
			</section>
			{menu_sidebar}
		</div>
		<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
			{rutas_all}
		</form>
		{footer}
	</div>
	{js_all}
	<script src="{ruta_js_finan}/general.js"></script>
	<script src="{ruta_js_finan}/clientes.js"></script>
	<script src="{ruta_js_finan}/pagos.js"></script>
	<script src="{ruta_js_common}/representantes.js"></script>
	
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		var table = $('#tabla_estadoCuenta').DataTable();
		//Si no da click al boton cerrar, sino que da click fuera del modal, las tablas no se reseteaban.
		//Esta funcion arregla eso.
		$('#modal_showDebtState').on('hidden.bs.modal', function () {
			table.destroy();
			$('#tabla_estadoCuenta').empty();
		})
		$(document).ready(function(){
			$(".detalle").tooltip({
				'selector': '',
				'placement': 'bottom',
				'container': 'body',
				'tooltipClass': 'detalleTooltip'
			});
			$("#txt_fecha_nac_ini").datepicker();
			$("#txt_fecha_nac_fin").datepicker();	
			$("#txt_fecha_matri_ini").datepicker({ format: 'yyyy-mm-dd' });
			$("#txt_fecha_matri_fin").datepicker({ format: 'yyyy-mm-dd' });
			
			$("#txt_fecha_nac_ini").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			$("#txt_fecha_nac_fin").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
				
			$("#txt_fecha_matri_ini").inputmask({
				mask: "y-1-2", 
				placeholder: "yyyy-mm-dd", 
				leapday: "-02-29", 
				separator: "-", 
				alias: "yyyy/mm/dd"
			});
			$("#txt_fecha_matri_fin").inputmask({
				mask: "y-1-2", 
				placeholder: "yyyy-mm-dd", 
				leapday: "-02-29", 
				separator: "-", 
				alias: "yyyy/mm/dd"
			});
						
			$("#boton_busqueda").click(function(){
				$("#desplegable_busqueda").slideToggle(200);
			});
			$("#desplegable_busqueda").show();
			$('[rel=tooltip]').tooltip({container: 'body'});
			shortcut.add("Enter", function() {$('#btn_search').trigger("click");});
		});
	});
	</script>
</body>
</html>