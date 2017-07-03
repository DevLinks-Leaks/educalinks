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
	
      <!-- MENU-->
	  {menu}
	  <!-- Left side column. contains the logo and sidebar -->
      <!-- /.MENU-->
	   <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
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
        <!-- Main content -->
        <section class="content" id="formulario">
			{formulario}
        </section>
		<!-- Control Sidebar -->
		{menu_sidebar}
      </div><!-- /.content-wrapper -->
	<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
            {rutas_all}
            <input type="hidden" id="index" name="index" value="{tipoid}" />
	</form>
	{footer}
	</div>
	{js_all}
	<script src="{ruta_js_finan}/general.js"></script>
	<script src="{ruta_js_finan}/puntos_emision.js"></script>
</body>
</html>