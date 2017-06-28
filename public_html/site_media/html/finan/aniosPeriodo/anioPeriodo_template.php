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
  .disabled_a {
	   pointer-events: none;
	   cursor: default;
	}
</style>

</head>
<body class="hold-transition skin-blue sidebar-mini {sidebar_status}">
    <div class="wrapper">
		{navbar}
		{menu}
		<div class="content-wrapper">
			<section class="content-header">
				<h1>{subtitulo}
					<small>{mensaje}</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-home"></i> Supervisor</a></li>
					<li class="active">{subtitulo}</li>
				</ol>
			</section>
			<section id="formulario" class="content">
				{formulario}
			</section>
			{menu_sidebar}
		</div><!-- /.content-wrapper -->
		<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
			{rutas_all}
		</form>
		{footer}
	</div>
	{js_all}
	
	<script src="{ruta_js_finan}/aniosPeriodo.js"></script>
	<script src="{ruta_js_finan}/general.js"></script>
</body>
</html>