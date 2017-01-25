
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
		<nav class="navbar navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<!--<span class="logo-mini"><div style="margin-top:10px" id='div_nav_logo_small' name='div_nav_logo_small'><img src="../../includes/common/logos/LOGO_EDUCALINKS_red_small.png" alt="EL"></div></span>-->
					<span class="logo-lg"><div style="margin-top:10px;" id='div_nav_logo' name='div_nav_logo'><img src="{navbar_logo_educalinks}" alt="Educalinks">&nbsp;</div></span>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
						<i class="fa fa-bars"></i>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="../../biblio/general/"><span class="fa fa-home"></span>&nbsp;<span class="sr-only">(current)</span></a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Visitas <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="../visita_nueva.php">Nueva Visita</a></li>
								<li class="divider"></li>
								<li><a href="../visitas.php">Reporte de registros</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Libros <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="../libro.php">Nuevo Libro</a></li>
								<li class="divider"></li>
								<li><a href="../libros_Reportes.php">Reportes</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Prestamos <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="../Prestamo_nuevo.php">Nuevo Prestamo</a></li>
								<li class="divider"></li>
								<li><a href="../Prestamos.php">Reportes de prestamos</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mantenimiento <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="../libros.php">Libros</a></li>
								<li class="divider"></li>
								<li><a href="#">Autores</a></li>
								<li><a href="#">Coleciones</a></li>
								<li><a href="#">Materia</a></li>
								<li><a href="#">Descripcion</a></li> 
								<li><a href="#">Procedencia</a></li> 
							</ul>
						</li>
					</ul>
					<!--<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
						</div>
					</form>-->
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../{fotoUsuario}" class="user-image" alt="Imagen de usuario">
								<span class="hidden-xs">{usua_nombres} {usua_apellidos}</span>&nbsp;
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<!-- Menu Body -->
								<li class="user-header">
									<img src="../{fotoUsuario}" class="user-image" alt="Imagen de usuario">
									<p>{usua_nombres} {usua_apellidos}
										<span style="font-size:x-small;"><b>{usua_codigo}</b></span>
										<small>Usuario de sistema Educalinks.</small>
									</p>
								</li>
							  <!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post"><a href="#" onclick="document.getElementById('event').value='password';document.frm_menu.submit();" class="btn btn-default btn-flat">Contraseña</a>
										<a href="#" onclick="document.getElementById('event').value='datos';document.frm_menu.submit();" class="btn btn-default btn-flat">Perfil</a></form>
									</div>
									<div class="pull-right">
										<a href="../../../salir.php" class="btn btn-default btn-flat">Salir</a>
									</div>
								</li>
							</ul>
						</li>
						<!--<li title='Expandir'><a href="#" onclick="toggleFullScreen();"><i class="fa fa-television"></i>&nbsp;</a></li>-->
						<li><a href="#" data-toggle="control-sidebar"><i class="fa fa-globe"></i>&nbsp;</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	</header>