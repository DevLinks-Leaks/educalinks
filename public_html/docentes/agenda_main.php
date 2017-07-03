<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>

    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=2;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Agenda</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-calendar"></i></a></li>
						<li class="active">Agenda</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a  href='agenda.php'
										class="btn btn-warning">
											<span class="fa fa-chevron-left"></span> Volver
									</a>
									<a  id="bt_agen_add"
										class="btn btn-primary"
										data-toggle="modal"
										data-target="#agen_nuev"
										onclick="load_modal_content('agen_modal_content',0,<?= $curs_para_mate_codi;?>,<?= $curs_para_mate_prof_codi;?>)">
											<span class="fa fa-plus"></span> Agenda
									</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
                                <script type="text/javascript" src="js/agenda.js?<?=$rand?>"></script>
								<div id="para_main">
									<?php include ('agenda_main_view.php'); ?>
								</div>
							</div>
						</div>
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
				$("#tbl_agenda_main_view").DataTable();
			} );
		</script>
	</body>
</html>
<div 
	class="modal fade" 
	id="agen_nuev" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="myModalLabel" 
	aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="agen_modal_content" class="modal-content">

	    </div>
    </div>
</div>