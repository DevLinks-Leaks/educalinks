<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=6;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Visitas Médicas
						<small>Atenciones</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-medkit"></i></a></li>
						<li class="active">Visitas Médicas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<?php include ('visitas_medicas_main.php'); ?>
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
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				
			});
		</script>
	</body>
</html>