<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
        <!-- Logo <a href="../general/controller.php" class="logo" id='a_nav_main' name='a_nav_main'> -->
		<a href="·" class="logo" id='a_nav_main' name='a_nav_main' data-toggle="offcanvas" role="button">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><div style="margin-top:10px" id='div_nav_logo_small' name='div_nav_logo_small'><img src="{navbar_logo_educalinks_small}" alt="EL"></div></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><div style="margin-left:-10px;margin-top:10px" id='div_nav_logo' name='div_nav_logo'><img src="{navbar_logo_educalinks}" alt="Educalinks"></div></span>
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
					<!-- Tasks: style can be found in dropdown.less -->
					<li title="Seleccionar período activo">
						<a href="#" data-toggle="modal" data-target="#ModalPeriodoActivo"><i class="fa fa-calendar"></i>&nbsp;Período: {peri_deta}</a>
					</li>
					<!-- User Account: style can be found in dropdown.less -->
					{select_alumno}
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="{ruta_foto_header}" class="user-image" alt="">
							<span class="hidden-xs"><small>{usua_nombres} {usua_apellidos}</small></span>&nbsp;
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<!-- Menu Body -->
							<li class="user-header">
								<img src="{ruta_foto_header}" class="user-image" alt="">
								<p>
									{usua_nombres} {usua_apellidos}
									<small>Usuario de sistema Educalinks.</small>
								</p>
							</li>
						  <!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="#" onclick="document.getElementById('event').value='password';document.frm_menu.submit();" class="btn btn-default btn-flat">Contraseña</a>
									<a href="#" onclick="document.getElementById('event').value='datos';document.frm_menu.submit();" class="btn btn-default btn-flat">Perfil</a>
								</div>
								<div class="pull-right">
									<a href="../../../salir.php" class="btn btn-default btn-flat">Salir</a>
								</div>
							</li>
						</ul>
					</li>
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  &nbsp;<i class="fa fa-envelope-o"></i>
						  <span id="span_badge_sms_header1" class="label"><span id="badge_sms_header1"></span></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header" id="badge_sms_header2" ></li>
							<li>
								<!-- inner menu: contains the actual data -->
								<ul id='badge_sms_detail' name='badge_sms_detail' class="menu">
								</ul>
							</li>
							<li class="footer"><a href="../../../alumnos/mensajes.php">Ver todos los mensajes</a></li>
						</ul>
					</li>
				</ul>
			</div>
        </nav>
    </header>
</form>