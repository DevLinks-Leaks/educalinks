<!DOCTYPE html>
<html lang="es">
    <?php
    	session_start();   
    ?>
    <head>   
     <?php
		//Set no cachinh
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

        /*$domain=$_SERVER['HTTP_HOST'];
        $serverName = "certuslinks.com";         
        $Database= "Certuslinks_admin"; 
        $UID= "sa";$PWD= "R3dlink5";

        $connectionInfo = array("Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD, "CharacterSet"=>"UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn === false){
            echo "Error in connection.\n";
            die( print_r( sqlsrv_errors(), true));
        }*/
		include("framework/dbconf_main.php");
		include("framework/funciones.php");
		
        $params = array($domain);
        $sql="{call dbo.clie_info_domain(?)}";
        $resu_login = sqlsrv_query($conn, $sql, $params);  
        $row = sqlsrv_fetch_array($resu_login);
        $_SESSION['host']=$row['clie_instancia_db'];
        $_SESSION['user']=$row['clie_user_db'];
        $_SESSION['pass']=$row['clie_pass_db'];
        $_SESSION['dbname']=$row['clie_base'];
		$_SESSION['menu_institucion'] = para_sist(3);
	?>
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

	  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	  <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
	  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script type="text/javascript" src="includes/common/shortcut.js"></script>
    <script src="theme/js/select.js"></script>
    <style>
	</style>
</head>
	<body class="hold-transition login-page" style="background:url(<?= background_index($_SESSION['codi']);?>) no-repeat center center fixed;-webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;">
	<br>
		<div class="login-box">
			<div class="login-logo">
				<img src="imagenes/clientes/<?= $_SESSION['directorio'];?>/logo_inicial_long.png" alt="Educalinks"  width="80%" height="80%">
			</div>
			<div class="login-box-body">
				<p class="login-box-msg">- Módulos -</p>
				<form  method="POST"  id="frm_modulo">
					<div class="row">
						<div class="col-xs-12">
							<p style="background-color: #e74c3c;"> 
							<?php 
								//session_start();
								if (isset($_SESSION['erro'])){?>
								<div class="comp_index">
									<label><?php echo $_SESSION['erro']; ?></label>
								</div>
							<?php }?>
							</p>
							<?php if($_SESSION['certus_acad']){ ?><button style='width:100%' type='submit' class='btn btn-warning' id="btn_acad" onClick="SeleccionarModulo(1)" title="Presione [A] para ir a módulo Académico"><i class='fa fa-graduation-cap'></i>&nbsp;<span style='text-decoration: underline;'>A</span>cadémico</button><br><br><?php }?>
							<?php if($_SESSION['certus_finan']){ if($_SESSION['rol_finan']==1){?><button style='width:100%' type='submit' class='btn btn-success' id="btn_finan" onclick="SeleccionarModulo(2)" title="Presione [F] para ir a módulo Financiero"><i class='fa fa-dollar'></i>&nbsp;<span style='text-decoration: underline;'>F</span>inanciero</button><br><br><?php }}?>
							<?php if($_SESSION['certus_biblio']){ if($_SESSION['rol_biblio']==1){?><button style='width:100%' type='submit' class='btn btn-primary' id="btn_biblio" onClick="SeleccionarModulo(4)" title="Presione [B] para ir a módulo Biblioteca"><i class='fa fa-book'></i>&nbsp;<span style='text-decoration: underline;'>B</span>iblioteca</button><br><br><?php }}?>
							<?php if($_SESSION['certus_medic']){ if($_SESSION['rol_medico']==1){?><button style='width:100%' type='submit' class='btn btn-danger' id="btn_medic" onClick="SeleccionarModulo(3)" title="Presione [M] para ir a módulo Médico"><i class='fa fa-medkit'></i>&nbsp;<span style='text-decoration: underline;'>M</span>édico</button><br><br><?php }}?>
						</div>
					</div>
				</form>
			</div>
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
		<script>
			shortcut.add("A", function() {
				$('#btn_acad').trigger('click');
			});
			shortcut.add("F", function() {
				$('#btn_finan').trigger('click');
			});
			shortcut.add("B", function() {
				$('#btn_biblio').trigger('click');
			});
			shortcut.add("M", function() {
				$('#btn_medic').trigger('click');
			});
			shortcut.add("D", function() {
				$('#btn_adm').trigger('click');
			});
			function SeleccionarModulo (valor)
			{	console.log("brok");
				//valor= $("#sl_modulo").val();
				if (valor==1)
				{
					$("#frm_modulo").attr("action", "admin/index.php");
				}

				if (valor==2)
				{
					$("#frm_modulo").attr("action", "main_finan.php");
				}
				if (valor==3)
				{
					$("#frm_modulo").attr("action", "main_medic.php");
				}
				if (valor==4)
				{
					$("#frm_modulo").attr("action", "biblio/index.php");
				}
				if (valor==5)
				{
					$("#frm_modulo").attr("action", "main_admisiones.php");
				}
			}
			/*$(document).keypress(function(e) {
				console.log(e.keyCode);
				if ( e.keyCode === 65 || e.keyCode === 97 ) // a
					$('#btn_acad').trigger('click');
				if ( e.keyCode === 70 || e.keyCode === 102) // f
					$('#btn_finan').trigger('click');
				if ( e.keyCode === 66 || e.keyCode === 98) // b
					$('#btn_biblio').trigger('click');
				if ( e.keyCode === 77 || e.keyCode === 109) // m
					$('#btn_medic').trigger('click');
				if ( e.keyCode === 68 || e.keyCode === 100) // d
					$('#btn_adm').trigger('click');
			});*/
		</script>
	</body>
</html>