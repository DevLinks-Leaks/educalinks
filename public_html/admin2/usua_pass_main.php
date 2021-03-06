<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=411;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Usuarios y claves</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-key"></i></a></li>
						<li class="active">Usuarios y claves</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title"></h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div class="alumnos_main_lista">
									<table class="table table-striped" id="alum_table">
									 <tbody>
									 <? 
									 if (permiso_activo(88))
									 {
									 ?>
									 <tr>
										<td><img src="../imagenes/repo_icon.png" style="width:60px;"></td>
										<td><h3>Alumnos</h3></td>
										<td>
										<label>Curso:</label>
											<?
												include ('select_cursos_usua_pass.php');
											?>
										</td>
										<td>
											<div id="lbl_paralelo">
											<label>Paralelo:</label>
												<select class='form-control input-sm' id="sl_paralelos" name="sl_paralelos"  disabled="disabled">
													<option value="*">Seleccione</option>
												</select>
											</div>
										</td>
										<td>
											<a href="JavaScript:getURLAlumnos();" >
												<img src="../imagenes/report_to_pdf.png" style="width:45px;">
											</a>
										</td>
									 </tr>
									 <? 
									 } 
									 if (permiso_activo(89))
									 {
									 ?>
									 <tr>
										<td><img src="../imagenes/repo_icon.png" style="width:60px;"></td>
										<td><h3>Profesores</h3></td>
										<td>
										</td>
										<td>
										</td>
										<td>
											<a target="_blank" href="reportes_generales/usuarios_claves_profesores.php" >
												<img src="../imagenes/report_to_pdf.png" style="width:45px;">
											</a>
										</td>
									 </tr>
									  <? 
									 } 
									 if (permiso_activo(90))
									 {
									 ?>
									  <tr>
										<td><img src="../imagenes/repo_icon.png" style="width:60px;"></td>
										<td><h3>Administrativos</h3></td>
										<td>
										</td>
										<td>
										</td>
										<td>
											<a target="_blank" href="reportes_generales/usuarios_claves_administrativos.php" >
												<img src="../imagenes/report_to_pdf.png" style="width:45px;">
											</a>
										</td>
									 </tr>
									  <? 
									 } 
									 ?>
									 </tbody>
									</table>
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
				$('#rol_table').DataTable() ;
			} );
		</script>
	</body>
</html>