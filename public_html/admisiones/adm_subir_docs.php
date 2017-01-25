<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<body>
		<div class="content">
			<section class="content-header">
				<h1>Admisiones online
					<small>Documentos solicitados</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-plus"></i></a></li>
					<li class="active">Documentos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-success box-solid">
					<div class="box-header with-border"> 
						<div class="row">
							<div class="col-md-12">
								<h4><b>Documentos requeridos</b></h4>
							</div>
						</div>
					</div>
					<div id="div_tabla_docs" class="box-body">
					<?
					include_once "adm_tabla_subir_docs.php";
					?>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1 col-md-offset-11">
							<a id="btn_continuar" name="btn_continuar" class="btn btn-primary active" href="adm_formulario.php?asp_id=<?= $_GET['asp_id']?>&peri_codi=<?= $_GET['peri_codi'] ?>"> <span class="fa fa-arrow-circle-o-right"></span> Seguir </a>
						</div>
					</div>
				</div>
			</section>
		</div>
		<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
			<?php include("Templates/rutas.php");?>
		</form>
			<?php include("Templates/footer.php");?>
		
		<?php include("Templates/scripts.php");?>
		<script type="text/javascript" src="js/funciones_subir_documentos.js?<?= $rand?>"></script>
	</body>
</html>