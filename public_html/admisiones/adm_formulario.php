<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php session_activa(); ?>
	<?php
	extract($_GET);
	?>
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
				<!--Ocultos-->
				<input type="hidden" id="form_asp_id" value="<?= $asp_id?>" />
				<input type="hidden" id="form_peri_codi" value="<?= $peri_codi?>" />
				
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Curso aplicado: </div> 
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
								<div class="col-md-4">Es repetidor de curso</div> 
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
								<div class="col-md-12"><b>¿Ha recibido su representado alguno de los siguientes servicios?</b></div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Apoyo académico</div> 
								<div class="col-md-1"><input type="radio" name="rad_apoy_acad" id="rad_apoy_acad_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_apoy_acad" id="rad_apoy_acad_no" /> No</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Apoyo social/psicológico</div> 
								<div class="col-md-1"><input type="radio" name="rad_apoy_social" id="rad_apoy_social_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_apoy_social" id="rad_apoy_social_no" /> No</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Apoyo en inglés</div> 
								<div class="col-md-1"><input type="radio" name="rad_apoy_ingles" id="rad_apoy_ingles_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_apoy_ingles" id="rad_apoy_ingles_no" /> No</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Otro</div> 
								<div class="col-md-4"><input type="text" class="form-control" id="form_otro_apoyo" /> </div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Por favor, explicar y colocar las fechas de los aspectos anteriores</div> 
								<div class="col-md-4"><textarea class="form-control" id="form_apoyo_aspectos"/></textarea></div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12"><b>¿El apsirante ha asistido a alguno de los siguientes programas?</b></div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Terapia externa, por problemas en su proceso de aprendizaje?</div> 
								<div class="col-md-1"><input type="radio" name="rad_terapia_ext" id="rad_terapia_ext_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_terapia_ext" id="rad_terapia_ext_no" /> No</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Atención por consumo de drogas o sustancias estupefacientes?</div> 
								<div class="col-md-1"><input type="radio" name="rad_drogas" id="rad_drogas_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_drogas" id="rad_drogas_no" /> No</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Otros: ¿Cuáles? Favor, escríbalas</div> 
								<div class="col-md-4"><input type="text" class="form-control" id="form_otros_programas" /> </div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Pertenece algun grupo católico o de formación?</div> 
								<div class="col-md-1"><input type="radio" name="rad_grupo_cat" id="rad_grupo_cat_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_grupo_cat" id="rad_grupo_cat_no" /> No</div> 
								<div class="col-md-2"><input type="text" class="form-control" id="form_grupo_cat" placeholder="¿Cuál?"/> </div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Practica alguna actividad extracurricular deportiva?</div> 
								<div class="col-md-1"><input type="radio" name="rad_deportista" id="rad_deportista_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_deportista" id="rad_deportista_no" /> No</div> 
								<div class="col-md-2"><input type="text" class="form-control" id="form_deporte" placeholder="¿Cuál?"/> </div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Estudian Familiares en la institución? Mencione sus nombres</div> 
								<div class="col-md-4"><textarea class="form-control" id="form_familiares_est"/></textarea></div> 
							</div>
						</div>
					</div>
				</div>
				<div class="box box-success box-solid">
					<div class="box-header with-border"> 
						<h4>Datos disciplinarios</h4>
					</div>
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿En alguna oportunidad, le han sugerido, que retire a su hijo del plantel?</div> 
								<div class="col-md-1"><input type="radio" name="rad_retiro_sug" id="rad_retiro_sug_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_retiro_sug" id="rad_retiro_sug_no" /> No</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿En alguna oportunidad, el estudiante  ha sido reportado por aspectos relacionados con lo académico o de comportamiento?</div> 
								<div class="col-md-1"><input type="radio" name="rad_probl_acad" id="rad_probl_acad_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_probl_acad" id="rad_probl_acad_no" /> No</div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Explíquelo</div> 
								<div class="col-md-4"><textarea class="form-control" id="form_probl_discip"/></textarea></div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Escriba las Unidades Educativas en las que ha estudiado el aspirante</div> 
								<div class="col-md-4"><textarea class="form-control" id="form_historial_ue"/></textarea></div> 
							</div>
						</div>
					</div>
				</div>
				<div class="box box-success box-solid">
					<div class="box-header with-border"> 
						<h4>Datos médicos</h4>
					</div>
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Padece alguna enfermedad</div> 
								<div class="col-md-1"><input type="radio" name="rad_es_enfermo" id="rad_es_enfermo_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_es_enfermo" id="rad_es_enfermo_no" /> No</div> 
								<div class="col-md-2"><input type="text" class="form-control" id="form_enfermedad" placeholder="¿Cuál?"/> </div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">Es alérgico algun medicamento</div> 
								<div class="col-md-1"><input type="radio" name="rad_es_alergico" id="rad_es_alergico_si" /> Sí</div> 
								<div class="col-md-1"><input type="radio" name="rad_es_alergico" id="rad_es_alergico_no" /> No</div> 
								<div class="col-md-2"><input type="text" class="form-control" id="rad_alergia" placeholder="¿Cuál?"/> </div> 
							</div>
						</div>
					</div>
				</div>
				<div class="box box-success box-solid">
					<div class="box-header with-border"> 
						<h4>Datos comerciales</h4>
					</div>
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Por qué escogió esta Unidad Educativa?</div> 
								<div class="col-md-4"><input type="text" class="form-control" id="form_dato_com_1" /> </div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Cómo se enteró?</div> 
								<div class="col-md-4"><input type="text" class="form-control" id="form_dato_com_2" /> </div> 
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">¿Por qué decidió inscribir a su hijo en esta Unidad Educativa?</div> 
								<div class="col-md-4"><input type="text" class="form-control" id="form_dato_com_3" /> </div> 
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-1 col-md-offset-10">
					<button id="btn_guardar_form" name="btn_guardar_form" class="btn btn-primary active" onclick="save();"><span id="wait_guardar_asp" class="fa fa-save"></span> Guardar</button>
				</div>
				<div class="col-md-1">
					<a id="btn_continuar" name="btn_continuar" class="btn btn-primary active" href="adm_familiar.php?step=1&asp_id=" style="display:none;"> <span class="fa fa-arrow-circle-o-right"></span> Seguir </a>
				</div>
			</div>
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