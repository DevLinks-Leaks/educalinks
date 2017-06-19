<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php
				if($_SESSION['modulo'] == 'acad')
					include("template/menu.php");
				if($_SESSION['modulo'] == 'finan')
					include("template/menu_finan.php");
				if($_SESSION['modulo'] == 'medic')
					include("../medic/template/menu.php");
			?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php  
						session_start();
                        include ('../framework/dbconf.php');
						if(isset($_POST['current_pass']))
						{   $params = array($_SESSION['usua_codi']);
							$sql="{call usua_info(?)}";
							$stmt = sqlsrv_query($conn, $sql, $params);
							if( $stmt === false )
							{
								echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
							} 
							$usua_view= sqlsrv_fetch_array($stmt);
							if($usua_view['usua_pass']==$_POST['current_pass'])
							{
									if ($_POST['new_pass_1']==$_POST['new_pass_2']){
									$params_usua = array($_SESSION['usua_codi'],$_POST['new_pass_1']);
									$sql_usua="{call usua_pass_upd(?,?)}";
									$stmt_usua = sqlsrv_query($conn, $sql_usua, $params_usua);
									if( $stmt_usua === false )
									{	
										echo "<input type='hidden' id='hd_status_post' name='hd_status_post' value='-1' />";
										echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
									}
									else
									{ 	
										echo "<input type='hidden' id='hd_status_post' name='hd_status_post' value='1' />";
									}
								}
								else
								{	
									echo "<input type='hidden' id='hd_status_post' name='hd_status_post' value='2' />";
								}
							}
							else
							{	
								echo "<input type='hidden' id='hd_status_post' name='hd_status_post' value='3' />";
							}
						}?>
					<h1>Cambio de contraseña</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-key"></i></a></li>
						<li class="active">Cambio de contraseña</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<form id="usua_pass_form" name="usua_pass_form" enctype="multipart/form-data" action="" method="post">
									<div class="form-group">
										<input type="hidden" class="form-control" name="usua_codigo" id="usua_codigo" value='{usua_codigo}'>
										<label for="current_pass">Contraseña anterior</label>
										<input type="password" class="form-control" name="current_pass" id="current_pass" placeholder="Ingrese su contraseña anterior" 
											required="required">
									</div>
									<div class="form-group">
										<label for="new_pass_1">Contraseña Nueva</label>
										<input type="password" class="form-control" name="new_pass_1" id="new_pass_1" placeholder="Ingrese su contraseña nueva" required="required">
									</div>
									<div class="form-group">
										<label for="new_pass_2">Reingrese Contraseña Nueva</label>
										<input type="password" class="form-control" name="new_pass_2" id="new_pass_2" placeholder="Reingrese su contraseña nueva" required="required">
									</div>
									<div class="form-group">
										<button class='btn btn-success' id="pass_guardar" name="pass_guardar" type="submit" ><span class='fa fa-save'></span> Guardar Cambios</button>
									</div>
								</form>
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
				if ( document.getElementById( 'hd_status_post' ) )
				{
					if ( document.getElementById( 'hd_status_post' ).value === '-1' )
						$.growl.error({ title: "<b>Educalinks informa</b>",message: "No se pudo completar su requerimiento. Por favor, inténtelo de nuevo." });
					if ( document.getElementById( 'hd_status_post' ).value === '1' )
						$.growl.notice({ title: "Educalinks informa",message: "Se actualiz&oacute; la contrase&ntilde;a correctamente." });
					if ( document.getElementById( 'hd_status_post' ).value === '2' )
						$.growl.warning({ title: "<b>Educalinks informa</b>",message: "Las contraseñas no coinciden." });
					if ( document.getElementById( 'hd_status_post' ).value === '3' )
						$.growl.warning({ title: "<b>Educalinks informa</b>",message: "Las contraseña ingresada no es la correcta." });
				}
				else
					console.log("not post");
				
				console.log(document.getElementById( 'hd_status_post' ).value);
			} );
		</script>
	</body>
</html>