<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php session_activa(); ?>
	<?php
		 extract($_GET);
		 $parentesco = "";
		 $es_financiero = 0;
		 $es_academico = 0;
		 $parentesco_editable = 1;
		 $next = "";
		 switch ($step)
		 {	case 1:
				$rol = "padre";
				$parentesco = "Papá";
				$parentesco_editable = 0;
				$next = "adm_familiar.php?asp_id=".$asp_id."&step=2";
			break;
			case 2:
				$rol = "madre";
				$parentesco = "Mamá";
				$parentesco_editable = 0;
				$next = "adm_familiar.php?asp_id=".$asp_id."&step=3";
			break;
			case 3:
				$rol = "Representante: en caso de no ser el papá o la mamá. Si es el papá o la mamá haga click en omitir";
				$next = "adm_escoger_repr.php?asp_id=".$asp_id;
			break;
			default:
				$rol = "Error#No especifica";
			break;
		 }
	?>
	<body>
		<div class="content">
			<section class="content-header">
				<h1>Admisiones online
					<small>Datos <?=($rol=="madre"?"de la":"del").' '.$rol ?></small>
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
							<div class="col-md-2">
								Identificación:
							</div>
							<div class="col-md-2">
								<input type="text" class="form-control" id="fam_num_identificacion" name="fam_num_identificacion" />
								<input type="hidden" id="asp_persona_id" name="asp_persona_id" value="<?= $asp_id; ?>"/>
								<input type="hidden" id="fam_persona_id" name="fam_persona_id" value=""/>
							</div>
							<div class="col-md-2">
								<select class="form-control" id="fam_tipo_identificacion" name="fam_tipo_identificacion">
									<option value="CI">Cédula</option>
									<option value="PAS">Pasaporte</option>
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-info" onclick="validar_identificacion();" id="btn_buscar_fam" name="btn_buscar_fam"><span id="wait_buscar_fam" class="fa fa-search"></span> Buscar</button>
							</div>
							<div class="col-md-3 col-md-offset-1">
								<span id="msg_info" class="label"></span>
							</div>
						</div>
					</div>
					<div class="box-body">
						<div class="form-group ">
							<div class="row">
								<div class="col-md-2">Primer nombre: ( * )</div> 
								<div class="col-md-4"><input id="fam_nombre_1" name="fam_nombre_1" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Segundo nombre:</div>
								<div class="col-md-4"><input id="fam_nombre_2" name="fam_nombre_2" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Apellido paterno: ( * )</div>
								<div class="col-md-4"><input id="fam_apellido_1" name="fam_apellido_1" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Apellido materno:</div>
								<div class="col-md-4"><input id="fam_apellido_2" name="fam_apellido_2" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Fecha Nacimiento: ( * )</div>
								<div class="col-md-2"><input id="fam_fecha_nac" name="fam_fecha_nac" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Género:</div>
								<div class="col-md-2">
									<select id="fam_genero" name="fam_genero" class="form-control" disabled="true">
										<option value="Hombre">Hombre</option>
										<option value="Mujer">Mujer</option>
									</select>
								</div>
								<div class="col-md-1">Profesión:(*)</div>
								<div class="col-md-3"><input id="fam_profesion" name="fam_profesion" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Nacionalidad: ( * )</div>
								<div class="col-md-4"><input id="fam_nacionalidad" name="fam_nacionalidad" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
					</div>
				</div>
										
				<div class="box box-success box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Dirección domicilio y trabajo</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Dirección donde vive: ( * )</div>
								<div class="col-md-10"><input id="fam_direccion" name="fam_direccion" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Teléfono convencional: ( * )</div>
								<div class="col-md-2"><input id="fam_num_convencional" name="fam_num_convencional" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Teléfono celular:</div>
								<div class="col-md-2"><input id="fam_num_celular" name="fam_num_celular" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Correo electrónico: ( * )</div>
								<div class="col-md-2"><input id="fam_correo" name="fam_correo" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Institución donde trabaja: (*) </div>
								<div class="col-md-4"><input id="fam_empresa_trabaja" name="fam_empresa_trabaja" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Cargo:</div>
								<div class="col-md-4"><input id="fam_cargo" name="fam_cargo" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Dirección donde trabaja: (*)</div>
								<div class="col-md-10"><input id="fam_direccion_trabaja" name="fam_direccion_trabaja" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Teléfono del trabajo: (*)</div>
								<div class="col-md-2"><input id="fam_convencional_trabajo" name="fam_convencional_trabajo" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Celular del trabajo:</div>
								<div class="col-md-2"><input id="fam_celular_trabajo" name="fam_celular_trabajo" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Correo del trabajo:</div>
								<div class="col-md-2"><input id="fam_correo_trabajo" name="fam_correo_trabajo" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Colegio donde se graduó:</div>
								<div class="col-md-4"><input id="fam_colegio" name="fam_colegio" type="text" class="form-control" disabled="true"/></div>
								<div class="col-md-2">Universidad donde se graduó/estudia:</div>
								<div class="col-md-4"><input id="fam_universidad" name="fam_universidad" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">Parentesco</div>
								<div class="col-md-4">
								<?	if ($parentesco_editable==1)
								{?>
									<select id="fam_parentesco" name="fam_parentesco" class="form-control" disabled="true">
										<option value=""></option>
										<option value="Abuelo/a">Abuelo/a</option>
										<option value="Tío/a">Tío/a</option>
										<option value="Otros">Otros(Especifique)</option>
									</select>
								<?
								}
								else
								{?>
									<input type="text" id="fam_parentesco" name="fam_parentesco" value="<?= $parentesco?> " class="form-control" disabled="true" />
								<?
								}
								?>
								<input type="hidden" id="fam_parentesco_editable" name="fam_parentesco_editable" value="<?= $parentesco_editable ?>"/>
								</div>
								<div class="col-md-2">¿Por qué representa?</div>
								<div class="col-md-4"><input id="fam_motivo" name="fam_motivo" type="text" class="form-control" disabled="true"/></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-1 col-md-offset-9">
									<button id="btn_guardar_fam" name="btn_guardar_fam" class="btn btn-primary active" onclick="save();" disabled="true"><span id="wait_guardar_fam" class="fa fa-save"></span> Guardar</button>
								</div>
								<?	if ($parentesco_editable==1)
								{?>
								<div class="col-md-1">
									<a id="btn_omitir" name="btn_omitir" class="btn btn-primary active" href="<?= $next; ?>"> <span class="fa fa-arrow-circle-o-right"></span> Omitir </a>
								</div>
								<?
								}?>
								<div class="col-md-1">
									<a id="btn_continuar" name="btn_continuar" class="btn btn-primary active" href="<?= $next; ?>" style="display:none;"> <span class="fa fa-arrow-circle-o-right"></span> Seguir </a>
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
				$('#fam_fecha_nac').datetimepicker({
					format: 'YYYY-MM-DD',
					locale: 'es',
					defaultDate:'<?= date('d/M/Y'); ?>',
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
		<script type="text/javascript" src="js/funciones_familiar.js?<?= $rand?>"></script>
	</body>
</html>