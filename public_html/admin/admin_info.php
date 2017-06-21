<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php
				if($_SESSION['modulo'] == 'acad')
					include("template/menu.php");
				if($_SESSION['modulo'] == 'finan')
					include("template/menu_finan.php");
				if($_SESSION['modulo'] == 'medic')
					include("../medic/template/menu.php");
			?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Informaci&oacute;n de usuario</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-user-circle-o"></i></a></li>
						<li class="active">Informaci&oacute;n de usuario</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<form name="frm_adm" id="frm_adm" action="" enctype="multipart/form-data" method="post">
						<?php
							if(isset($_POST['usua_mail'])){
								$usua_mail=$_POST['usua_mail'];
								$_SESSION['usua_mail']=$usua_mail;
								$usua_codi=$_SESSION['usua_codi'];
								$params = array($_SESSION['usua_codi'],$_SESSION['usua_nomb'],$_SESSION['usua_apel'],$usua_mail,$_SESSION['rol_codi']);
								$sql="{call usua_upd(?,?,?,?,?)}";
								$prof_info = sqlsrv_query($conn, $sql, $params);
								if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
							}
						?>
							<div class='form-horizontal'>
								<?php
								$ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['prof_codi'].".jpg";
								$file_exi=$ruta;
								if (file_exists($file_exi)) {
									$pp=$file_exi;
								} else {
									$pp=$_SESSION['foto_default'];
								}
								?>
								<div class="form-group">
									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="<?php echo $pp;?>" alt="Foto de perfil">

												<h3 class="profile-username text-center"><?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?></h3>

												<p class="text-muted text-center"><?= $_SESSION['USUA_DE']; ?></p>

												<ul class="list-group list-group-unbordered">
													<!--<li class="list-group-item">
													  <b class='fa fa-birthday-cake'></b> <span class="pull-right"><input type="text" id="usua_fechanac" name="usua_fechanac" value="<?php //echo $_SESSION['fecha_nac']; ?>"/></span>
													</li>-->
													<li class="list-group-item">
													  <b class='fa fa-envelope'></b> <span class="pull-right">
														<input type="text" id="usua_mail" name="usua_mail" value="<?= $_SESSION['usua_mail']; ?>"/></span>
													</li>
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Grabar cambio</b></a>
											</div>
										</div>
										<div class="box box-primary">
											<div class="box-header with-border">
												<h3 class="box-title">Permisos</h3>
											</div>
											<div class="box-body">
												<strong><i class="icon icon-logo"></i> Módulos</strong>
												<p>
													<span class="label label-warning">Académico</span>
													<span class="label label-success">Financiero</span>
													<span class="label label-primary">Biblioteca</span>
													<span class="label label-danger">Médico</span>
												</p>
												<strong><i class="fa fa-briefcase"></i> Rol</strong>
												<p>
													<span class="label label-info"><?= $_SESSION['USUA_DE']; ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div> 
						</form> 
		            </div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				
			} );
		</script>
	</body>
</html>