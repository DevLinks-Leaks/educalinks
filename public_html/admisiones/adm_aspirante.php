<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php session_activa(); ?>
	<body>
		<div class="content">
			<section class="content-header">
				<h1>Admisiones online
					<small>Datos del aspirante</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-plus"></i></a></li>
					<li class="active">Aspirante</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-success box-solid">
					<div class="box-header with-border"> 
						<div class="row">
							<div class="col-md-2">
								Identificación:
							</div>
							<div class="col-md-2">
								<input type="text" class="form-control" id="asp_num_identificacion" name="asp_num_identificacion" />
							</div>
							<div class="col-md-2">
								<select class="form-control" id="asp_tipo_identificacion" name="asp_tipo_identificacion">
									<option value="CI">Cédula</option>
									<option value="PAS">Pasaporte</option>
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-info" onclick="validar_identificacion();" id="btn_buscar_asp" name="btn_buscar_asp"><span id="wait_buscar_asp" class="fa fa-search"></span> Buscar</button>
							</div>
							<div class="col-md-3 col-md-offset-1">
								<span id="msg_info" class="label"></span>
							</div>
						</div>
					</div>
				
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Primer nombre: (*)</div> 
								<input id="asp_persona_id" name="asp_persona_id" type="hidden" />
								<div class="col-md-4"><input id="asp_nombre_1" name="asp_nombre_1" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Segundo nombre:</div>
								<div class="col-md-4"><input id="asp_nombre_2" name="asp_nombre_2" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Apellido paterno: (*)</div>
								<div class="col-md-4"><input id="asp_apellido_1" name="asp_apellido_1" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Apellido materno:</div>
								<div class="col-md-4"><input id="asp_apellido_2" name="asp_apellido_2" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Fecha Nacimiento: (*)</div>
								<div class="col-md-2"><input id="asp_fecha_nac" name="asp_fecha_nac" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Género:</div>
								<div class="col-md-2">
									<select id="asp_genero" name="asp_genero" class="form-control" disabled="true">
										<option value="Hombre">Hombre</option>
										<option value="Mujer">Mujer</option>
									</select>
								</div>
								<div class="col-md-2">Religión: (*)</div>
								<div class="col-md-2"><input id="asp_religion" name="asp_religion" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">País de nacimiento: (*)</div>
								<div class="col-md-2"><input id="asp_pais_nac" name="asp_pais_nac" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Provincia de nacimiento: (*)</div>
								<div class="col-md-2"><input id="asp_provincia_nac" name="asp_provincia_nac" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Ciudad de nacimiento: (*)</div>
								<div class="col-md-2"><input id="asp_ciudad_nac" name="asp_ciudad_nac" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Dirección donde vive: (*)</div>
								<div class="col-md-10"><input id="asp_direccion" name="asp_direccion" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Teléfono convencional: (*)</div>
								<div class="col-md-2"><input id="asp_num_convencional" name="asp_num_convencional" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Teléfono celular: </div>
								<div class="col-md-2"><input id="asp_num_celular" name="asp_num_celular" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Correo electrónico: </div>
								<div class="col-md-2"><input id="asp_correo" name="asp_correo" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Vive con:</div>
								<div class="col-md-2">
									<select id="asp_vive_con" name="asp_vive_con" class="form-control" disabled="true">
										<option value="Papá y mamá">Papá y mamá</option>
										<option value="Papá">Papá</option>
										<option value="Mamá">Mamá</option>
										<option value="Abuelos">Abuelos</option>
										<option value="Otros">Otros(Especifique)</option>
									</select>
								</div>
								<div class="col-md-2">Especifique:</div>
								<div class="col-md-6"><input id="asp_vive_con_especifique" name="asp_vive_con_especifique" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Facebook:</div>
								<div class="col-md-2">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-facebook"></span></span>
										<input id="asp_facebook" name="asp_facebook" type="text" class="form-control" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status" disabled="true">
									</div>
								</div>
								<div class="col-md-2">Instagram:</div>
								<div class="col-md-2">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-instagram"></span></span>
										<input id="asp_instagram" name="asp_instagram" type="text" class="form-control" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status" disabled="true">
									</div>
								</div>
								<div class="col-md-2">Twitter:</div>
								<div class="col-md-2">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-twitter"></span></span>
										<input id="asp_twitter" name="asp_twitter" type="text" class="form-control" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status" disabled="true">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-1 col-md-offset-10">
									<button id="btn_guardar_asp" name="btn_guardar_asp" class="btn btn-primary active" onclick="save();" disabled="true"><span id="wait_guardar_asp" class="fa fa-save"></span> Guardar</button>
								</div>
								<div class="col-md-1">
									<a id="btn_continuar" name="btn_continuar" class="btn btn-primary active" href="adm_familiar.php?step=1&asp_id=" style="display:none;"> <span class="fa fa-arrow-circle-o-right"></span> Seguir </a>
								</div>
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
		<script type="text/javascript" src="js/funciones_aspirante.js?<?= $rand?>"></script> 
	</body>
</html>