<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php
	include ('../framework/dbconf.php');
	session_start();
	extract($_GET);
	$params   = array($asp_id);
	$sql	  = "{call admisiones_representante_aspirante_show(?)}";
	$stmt 	  = sqlsrv_query($conn, $sql, $params);  
	?>
	<body>
		<div class="content">
			<section class="content-header">
				<h1>Admisiones online
					<small>Representante legal y financiero</small>
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
							<div class="col-md-10 col-offset-md-2">
								Escoja el representante legal y financiero:
							</div>
						</div>
					</div>
					<div class="box-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Identificación</th>
								<th>Representante</th>
								<th>Parentesco</th>
								<th>Legal</th>
								<th>Financiero</th>
							</tr>
						</thead>
						<tbody>
						<?php
						while ($row = sqlsrv_fetch_array($stmt)){
						?>
							<tr>
								<td><?= "(".$row["tipo_id"].")".$row["numero_id"] ?></td>
								<td><?= $row["apellido_1"]." ".$row["apellido_2"]." ".$row["nombre_1"]." ".$row["nombre_2"] ?></td>
								<td><?= $row["parentesco"] ?></td>
								<td><input type="radio" onclick="set_tipo_representante(<?= $row['aspirante_id']?>,<?= $row['representante_id']?>, 'L');" name="legal" <?= ($row["es_legal"]?"checked":"") ?>/></td>
								<td><input type="radio" onclick="set_tipo_representante(<?= $row['aspirante_id']?>,<?= $row['representante_id']?>, 'F');" name="financiero" <?= ($row["es_financiero"]?"checked":"") ?>/></td>
							</tr>
						<?php
						}
						?>
						</tbody>
					</table>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-2 col-md-offset-10">
							<a id="btn_continuar" name="btn_continuar" class="btn btn-primary active" href="adm_escoger_periodo.php?asp_id=<?= $asp_id?>"> <span class="fa fa-arrow-circle-o-right"></span> Continuar </a>
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
		<script type="text/javascript" src="js/funciones_familiar.js?<?= $rand?>"></script>
	</body>
</html>