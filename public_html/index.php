<!DOCTYPE html>
<html lang="es">
    <?php
    session_start();
	require_once ('framework/switch.php');
	require_once ('framework/funciones.php');	
	get_database_params();
    ?>
    <head>   
	<?php
		//Set no cachinh
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	?>
	  <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
      <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- Bootstrap 3.3.6 -->
	  <link rel="stylesheet" href="includes/common/bootstrap/css/bootstrap.min.css">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	  <!-- Theme style -->
	  <link rel="stylesheet" href="includes/common/dist/css/AdminLTE.min.css">
	  <!-- iCheck -->
	  <link rel="stylesheet" href="includes/common/plugins/iCheck/square/blue.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <script type="text/javascript" src="../includes/common/shortcut.js"></script>
	  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	  <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
    <title>Educalinks | Unidad Educativa <?= para_sist(2);?></title>
    <link rel="shortcut icon" href="imagenes/logo_icon.png"> 
    

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="theme/js/select.js"></script>
	<script src="theme/js/bootstrap.js"></script>
    
</head>
	<body class="hold-transition login-page" style="background:url(<?= background_index($_SESSION['codi']);?>) no-repeat center center fixed;-webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;">
		<div class="login-box">
			<div class="login-logo">
				<img src="imagenes/clientes/<?= $_SESSION['directorio'];?>/logo_inicial_long.png" alt="Educalinks"  width="80%" height="80%">
			</div>
			<div class="login-box-body">
				<p class="login-box-msg">Ingreso de usuario Prueba git</p>

				<form  action="framework/main_valid.php" method="POST"  id="form_main">
					<div class="form-group has-feedback">
						<input class='form-control' type="text"  name="usua" id="usua" placeholder="Usuario" required>
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input class='form-control' type="password" name='pass' id="pass" placeholder="Contraseña" required> 
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form_element"><label>Perfil</label></div>
					<input type="hidden" id="que2" name="que2" value="IN_API">
					<input type="hidden" id="tipo" name="tipo" value="">
					<div class="form_element"></div>
					<div class="row">
						<div class="col-xs-12">
							<p style="background-color: #e74c3c;"> 
							<?php 
								//session_start();
								if (isset($_SESSION['erro'])){?>
								<div class="comp_index">
									<label style='color:red;'><?php echo $_SESSION['erro']; ?></label>
								</div>
							<?php }?>
							</p>
							<div class="btn-group" data-toggle="buttons">
								<label id='alumno' class=" <?php echo ( $_COOKIE['tipo'] == 1 ? 'btn btn-danger btn-block btn-flat active' : 'btn btn-default btn-block btn-flat'); ?>">
								<input type="radio" onChange="select_opc('alumno');" name="option" id="option1" autocomplete="off" value="1" <? if ($_COOKIE['tipo']==1) echo 'checked'; ?> >
								<span class="icon-pencil"></span> Alumnos </label>
								<label id='repr' class="<?php echo ( $_COOKIE['tipo'] == 2 ? 'btn btn-danger btn-block btn-flat active' : 'btn btn-default btn-block btn-flat'); ?>">
								<input type="radio" onChange="select_opc('repr');"name="option" id="option3" autocomplete="off" value="2" <? if ($_COOKIE['tipo']==2) echo 'checked'; ?> >
								<span class="icon-users"></span> Representantes</label>
								<label id='docente' class="<?php echo ( $_COOKIE['tipo'] == 3 ? 'btn btn-danger btn-block btn-flat active' : 'btn btn-default btn-block btn-flat'); ?>">
								<input type="radio" onChange="select_opc('docente');"name="option" id="option2" autocomplete="off" value="3" <? if ($_COOKIE['tipo']==3) echo 'checked'; ?> >
								<span class="icon-user"></span> Docentes </label>
								<label id='admin' class="<?php echo ( $_COOKIE['tipo'] == 4 ? 'btn btn-danger btn-block btn-flat active' : 'btn btn-default btn-block btn-flat'); ?>">
								<input type="radio" onChange="select_opc('admin');" name="option" id="option4" autocomplete="off" value="4" <? if ($_COOKIE['tipo']==4 or !isset($_COOKIE['tipo'])) echo 'checked';?> >
								<span class="icon-cog"></span> Administrativos</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12" style='text-align:center;'>
							<button id="btn_login" type="button" class="btn btn-primary btn-block btn-flat" onClick="main_in();"> Iniciar sesión</button>
						</div>
					</div>
				</form>
				<!--<div class="social-auth-links text-center">
					<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="icon icon-logo"></i> Página oficial</a>
				</div>
				<a href="recupera_clave.php">Olvidé mi contraseña</a><br>-->
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$('.select').fancySelect();
				// shortcut.add("Enter", function() {
				// 	main_in();
				// });
			});

			$('#usua').focus();
			
			function select_opc( active )
			{	$( '#alumno' ).removeClass('btn btn-danger').addClass('btn btn-default');
				$( '#repr' ).removeClass('btn btn-danger').addClass('btn btn-default');
				$( '#docente' ).removeClass('btn btn-danger').addClass('btn btn-default');
				$( '#admin' ).removeClass('btn btn-danger').addClass('btn btn-default');
				$( '#' + active ).addClass('btn btn-danger');
			}
			
			function main_in(){
				if (document.getElementById('option1').checked) document.getElementById('tipo').value=document.getElementById('option1').value;
				if (document.getElementById('option2').checked) document.getElementById('tipo').value=document.getElementById('option2').value;
				if (document.getElementById('option3').checked) document.getElementById('tipo').value=document.getElementById('option3').value;
				if (document.getElementById('option4').checked) document.getElementById('tipo').value=document.getElementById('option4').value;
				console.log(document.getElementById('usua').value);
				document.getElementById("form_main").submit();
				
			}

			// $('.login').keypress(function(e) {
			// 	if(e.which == 13) {
			// 		if (document.getElementById('option1').checked) document.getElementById('tipo').value=document.getElementById('option1').value;
			// 		if (document.getElementById('option2').checked) document.getElementById('tipo').value=document.getElementById('option2').value;
			// 		if (document.getElementById('option3').checked) document.getElementById('tipo').value=document.getElementById('option3').value;
			// 		if (document.getElementById('option4').checked) document.getElementById('tipo').value=document.getElementById('option4').value;
					
			// 		document.getElementById("form_main").submit();
			// 	}
			// });

			
		</script>
    </body>
</html>