<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php
	include ('../framework/dbconf.php');
	extract($_GET);
	$params   = array("Y");
	$sql	  = "{call peri_acti_etap(?)}";
	$stmt 	  = sqlsrv_query($conn, $sql, $params);  
	?>
	<body>
		<div class="content">
			<section class="content-header">
				<h1>Admisiones online
					<small>Periodos abiertos</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-plus"></i></a></li>
					<li class="active">Familiares</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-success box-solid">
					<div class="box-header with-border"> 
						<div class="row">
							<div class="col-md-12">
								<h4><b>Escoja periodo al que desea aplicar</b></h4>
							</div>
						</div>
					</div>
					<div class="box-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="30%">Periodo</th>
								<th width="30%">Inicio</th>
								<th width="30%">Fin</th>
								<th width="10%"></th>
							</tr>
						</thead>
						<tbody>
						<?php
						while ($row = sqlsrv_fetch_array($stmt)){
						?>
							<tr>
								<td><?= $row["peri_deta"] ?></td>
								<td><?= date_format($row["peri_fech_ini"],'d-m-Y') ?></td>
								<td><?= date_format($row["peri_fech_fin"],'d-m-Y') ?></td>
								<td>
									<a id="btn_aplicar" name="btn_aplicar" class="btn btn-primary active" href="adm_subir_docs.php?peri_codi=<?= $row["peri_codi"] ?>&asp_id=<?= $asp_id ?>"> 
										<span class="fa fa-arrow-circle-o-right"></span> Aplicar 
									</a>
								</td>
							</tr>
						<?php
						}
						?>
						</tbody>
					</table>
					</div>
				</div>
			</section>
		</div>
		<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
			<?php include("Templates/rutas.php");?>
		</form>
			<?php include("Templates/footer.php");?>
		
		<?php include("Templates/scripts.php");?>
		<script type="text/javascript" src="js/funciones_familiar.js?<?= $rand?>"></script>
	</body>
</html>