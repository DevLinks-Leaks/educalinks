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
	#sortable { margin: 0; padding: 0; width: 100%; }
	#div_campos li { cursor:move; }
	#div_campos li.fixed { cursor:default; color:#959595; opacity:0.5;}
	.Highlight {
		background-color: rgba(255, 165, 0, 0.11);
		font-weight: bold;
	}
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
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
					<li><a href="#"><span class="glyphicon glyphicon-import"></span> Supervisor</a></li>
					<li class="active">{subtitulo}</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div id="formulario">
							{formulario}
						</div>
					</div>
				</div>
			</section><!-- /.content -->
			{menu_sidebar}
		</div>
		<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
				{rutas_all}
				<input type="hidden" id="index" name="index" value="{tipoid}" />
		</form>
		{footer}
	</div>
	{js_all}
	<script src="{ruta_js_finan}/debitosAutomaticos.js?"></script>
	<script src="{ruta_js_finan}/general.js"></script>
</body>
</html>