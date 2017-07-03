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
				<li><a href="#"><span class="icon icon-ctfco"></span> Supervisor</a></li>
				<li class="active">{subtitulo}</li>
			</ol>
		</section>
		<section class="content" id="formulario">
			{formulario}
		</section>
		{menu_sidebar}
		</div><!-- /.content-wrapper -->
		<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
		{rutas_all}
		<input type="hidden" id="cate_codigo" name="cate_codigo" value="{codigo}" />
		<input type="hidden" id="apikey" name="apikey" value="{apikey}" />
		</form>
		{footer}
	</div>
    {js_all}
	<script src="{ruta_js_finan}/contabilidad.js"></script>
	<script src="{ruta_js_finan}/general.js"></script>
</body>
</html>
