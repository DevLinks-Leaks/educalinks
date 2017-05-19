<?php 
session_start(); include("core/rutas.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>{proyecto} | {subtitulo}</title>
	
	<link href="{ruta_imagenes_common}/jquery/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="{ruta_imagenes_common}/plugins/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="{ruta_imagenes_common}/plugins/datepicker/datepicker3.css" />
	<link rel="shortcut icon" href="{ruta_imagenes_common}/favicon.png" />
	<link href="{ruta_imagenes_common}/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{ruta_imagenes_common}/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">
	
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{ruta_imagenes_common}/bootstrap/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{ruta_imagenes_common}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{ruta_includes_common}/dist/css/skins/_all-skins.min.css">
    <!-- Select 2 -->
	<link rel="stylesheet" href="{ruta_includes_common}/plugins/select2/select2.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{ruta_includes_common}/plugins/iCheck/flat/blue.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition {ui_skin} sidebar-mini {sidebar_status}">
    <div class="wrapper">
		{navbar}
		{menu}
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					{subtitulo}
					<small>{mensaje}</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-home"></i></a></li>
					<li class="active">{subtitulo}</li>
				</ol>
			</section>

			<section class="content">
				<!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
				<div class="box-header with-border">
				<h3 class="box-title">Periodos de admisión</h3>
				<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"></button>
				<!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> NO REMOVER-->
				</div>
				</div><!-- /.box-header -->
				<div class="box-body">
				<div id="formulario">
				{formulario}
				</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
				 Periodos.
				</div>
				</div>
			</section>
		<!-- Control Sidebar -->
		{menu_sidebar}
      </div><!-- /.content-wrapper -->
	  {footer}
	<form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
		{rutas_all}
		<input type="hidden" id="index" name="index" value="{tipoid}" />
	</form>
	</div><!-- ./wrapper -->
	<!-- jQuery 2.1.4 -->
	<!-- Para decimales -->
    <script src="{ruta_imagenes_common}/plugins/jQuery/numeric.js"></script>
    <script src="{ruta_imagenes_common}/plugins/jQuery/jStepper.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.5 -->
    <script src="{ruta_imagenes_common}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{ruta_imagenes_common}/plugins/select2/select2.full.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{ruta_imagenes_common}/plugins/morris/morris.min.js"></script>
	<!-- JSPDF para PDF-->
	<script src="http://mrrio.github.io/jsPDF/dist/jspdf.debug.js"></script>
	<!-- InputMask -->
    <script src="{ruta_imagenes_common}/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="{ruta_imagenes_common}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="{ruta_imagenes_common}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- Sparkline -->
    <script src="{ruta_imagenes_common}/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="{ruta_imagenes_common}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{ruta_imagenes_common}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="{ruta_imagenes_common}/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{ruta_imagenes_common}/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="{ruta_imagenes_common}/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{ruta_imagenes_common}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="{ruta_imagenes_common}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{ruta_imagenes_common}/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{ruta_imagenes_common}/dist/js/app.js"></script>
    <!-- iCheck -->
    <script src="{ruta_includes_common}/plugins/iCheck/icheck.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{ruta_imagenes_common}/dist/js/demo.js"></script>
	<script src="{ruta_includes_common}/shortcut.js"></script>
	
	<script src="{ruta_js_admisiones}/menu.js"></script>
	<script src="{ruta_js_common}/periodo.js"></script>
	<script src="{ruta_js_acad}/general.js"></script>
	<script src="{ruta_js_admisiones}/general.js"></script>
	<script src="{ruta_js_finan}/general.js"></script>
	<script src="{ruta_js_biblio}/general.js"></script>
	<script src="{ruta_js_medic}/general.js"></script>
	<script src="{ruta_js_common}/general.js"></script>
	<script src="{ruta_js_common}/mensajeria.js"></script>
</body>
</html>
