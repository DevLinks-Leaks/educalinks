<header class="main-header">
	 <a href="·" class="logo" id='a_nav_main' name='a_nav_main' data-toggle="offcanvas" role="button">
		<span class="logo-mini"><div style="" id='div_nav_logo_small' name='div_nav_logo_small'><img src="../../includes/common/logos/LOGO_EDUCALINKS_white_small.png" alt="EL"></div></span>
		<span class="logo-lg"><div style="margin-left:-10px;" id='div_nav_logo' name='div_nav_logo'><img src="../../includes/common/logos/LOGO_EDUCALINKS_white.png" alt="Educalinks"></div></span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button -->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo "../".$_SESSION['ruta_foto_usuario'].'admin.jpg'; ?>" class="user-image" alt="Imagen de usuario">
						<span class="hidden-xs"><?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?></span>&nbsp;
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<!-- Menu Body -->
						<li class="user-header">
							<img src="<?php echo "../".$_SESSION['ruta_foto_usuario'].'admin.jpg'; ?>" class="user-image" alt="Imagen de usuario">
							<p><?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?><!-- <br>
								<span style="font-size:x-small;"><b><?= $_SESSION['usua_codi']; ?></b></span> -->
								<small>Usuario de sistema Educalinks.</small>
							</p>
						</li>
					  <!-- Menu Footer-->
						<li class="user-footer">
							<!-- <div class="pull-left">
								<a href="#" onclick="document.getElementById('event').value='password';document.frm_menu.submit();" class="btn btn-default btn-flat">Contraseña</a>
								
							</div> -->
							<div class="pull-right">
								<a href="../../../salir.php" class="btn btn-default btn-flat">Salir</a>
							</div>
						</li>
					</ul>
				</li>
				<!--<li title='Expandir'><a href="#" onclick="toggleFullScreen();"><i class="fa fa-television"></i>&nbsp;</a></li>-->
				<li title='Ver módulos del sistema' >
					<a onmouseover='$(this).tooltip("show");' href="#" data-toggle="modal" data-target="#ModalEducalinksMoludos"><i class="fa fa-briefcase"></i>&nbsp;</a>
				</li>
			</ul>
		</div>
	</nav>
</header>
<script src="../../../framework/ckeditor/ckeditor.js"></script>
<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
<!-- Modal Vista mensaje-->
<div class="modal fade bd-example-modal-lg" id="modal_leer_ext" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="modal_main_ext" width="100%" class="modal-content">
            
        </div>
    </div>
</div>
<!-- Modal Responder-->
<div class="modal fade bs-example-modal-lg" id="mens_responder" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div id="div_mens_resp" class="modal-content">
		  
		</div>
	</div>
</div>
<!-- Modal eliminar-->
<div class="modal fade bs-example-modal-sm" id="modal_del_sms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Educalinks</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						¿Eliminar mensaje? Pasará a la bandeja de mensajes eliminados.
					</div>
				</div>
				<input type='hidden' id='hd_del_mes_codi' name='hd_del_mes_codi' value=''></input>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" type="button" onclick="elimina_mensaje_followed( )">
					<span class="fa fa-trash"></span>&nbsp;Eliminar</button>
				<button class="btn btn-default" data-dismiss="modal"><li style="color:red;" class="fa fa-ban"></li>&nbsp;No Eliminar</button>
			</div>
		</div>
	</div>
</div>