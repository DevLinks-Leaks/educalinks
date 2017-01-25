<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php session_activa(); ?>
	<body>
		<div class="content">
			<section class="content-header">
				<h1>Admisiones online
					<small>Formulario de admisiones</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-plus"></i></a></li>
					<li class="active">Formulario</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-success box-solid">
					<div class="box-header with-border"> 
						<h4>Datos académicos</h4>
					</div>
				
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Curso aplicado: </div> 
								<div class="col-md-4">
									<select id="form_nivel_aplic" name="form_nivel_aplic" class="form-control">
										<option value="">ESCOJA</option>
										<?
										include ('../framework/dbconf.php');
										$params = array();
										$sql	= "{call nive_view()}";
										$stmt	= sqlsrv_query($conn, $sql, $params);
										while ($row = sqlsrv_fetch_array($stmt))
										{
										?>
											<option value="<?= $row["nive_codi"] ?>"><?= $row["nive_deta"] ?></option>
										<?
										}
										?>
									</select>
								</div> 
								<div class="col-md-2">
									<select id="form_curso_aplic" name="form_curso_aplic" class="form-control">
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Es repetidor de curso</div> 
								<div class="col-md-1"><input type="radio" name="rad_repetidor" id="rad_repetidor_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_repetidor" id="rad_repetidor_no" /> No</div> 
								<div class="col-md-2">
									<select id="form_curso_rep" name="form_curso_rep" class="form-control">
									</select>
								</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">¿Ha recibido su representado alguno de los siguientes servicios ?</div> 
								<div class="col-md-1"><input type="radio" name="rad_repetidor" id="rad_repetidor_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_repetidor" id="rad_repetidor_no" /> No</div> 
							</div>
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
		
			<script>
				$('#asp_fecha_nac').datetimepicker({
					format: 'YYYY-MM-DD',
					locale: 'es',
					defaultDate:'<?= date('Y/M/d'); ?>',
					showTodayButton: true,
					tooltips: {
						today: 'Ir al día actual',
						clear: 'Borrar selección',
						close: 'Cerrar el Seleccionador',
						selectMonth: 'Seleccione el Mes',
						prevMonth: 'Mes Anterior',
						nextMonth: 'Mes Siguiente',
						selectYear: 'Seleccione el Año',
						prevYear: 'Año Anterior',
						nextYear: 'Año Siguiente',
						selectDecade: 'Seleccione la Década',
						prevDecade: 'Década Anterior',
						nextDecade: 'Década Siguiente',
						prevCentury: 'Siglo Anterior',
						nextCentury: 'Siglo Siguiente'
					}
				});
		</script> 
		<script type="text/javascript" src="js/funciones_formulario.js?<?= $rand?>"></script> 
	</body>
</html>