<aside class="control-sidebar control-sidebar-dark">
	<div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Módulos del sistema</h3>
            <ul class="control-sidebar-menu">
			<?php
			$acad = '	<li>
							<a href="../../../admin/index.php" title="Ir al módulo académico">
								<i class="menu-icon fa fa-graduation-cap bg-yellow"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Académico</h4>
									<p>Notas, tutoría, clase virtual</p>
								</div>
							</a>
						</li>';
			$admisiones = '	<li>
							<a href="../../../main_admisiones.php" title="Ir al módulo admisiones">
								<i class="menu-icon fa fa-child bg-orange"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Admisiones</h4>
									<p>Proceso de solicitudes, ingreso de documentos</p>
								</div>
							</a>
						</li>';
			$finan = '<li>
							<a href="../../../main_finan.php" title="Ir al módulo financiero">
								<i class="menu-icon fa fa-usd bg-green"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Financiero</h4>
									<p>Colecturía, cobranza y facturación electrónica</p>
								</div>
							</a>
						</li>';
			$biblio = '<li>
							<a href="../../../biblio/index.php" title="Ir al módulo biblioteca">
							  <i class="menu-icon fa fa-book bg-light-blue"></i>
							  <div class="menu-info">
								<h4 class="control-sidebar-subheading">Biblioteca</h4>
								<p>Mantenimiento de inventario de biblioteca</p>
							  </div>
							</a>
						</li>';
			$medico = '<li>
							<a href="../../../main_medic.php" title="Ir al módulo médico">
							  <i class="menu-icon fa fa-medkit bg-red"></i>
							  <div class="menu-info">
								<h4 class="control-sidebar-subheading">Médico</h4>
								<p>Inventario médico y ficha médica ocupacional</p>
							  </div>
							</a>
						</li>';
				
			echo $acad;
			//echo $admisiones;
			if($_SESSION['rol_finan']==1)
				echo $finan;
			if($_SESSION['rol_biblio']==1)
				echo $biblio;
			if($_SESSION['rol_medico']==1)
				echo $medico;
			?>
            </ul>
			<!--<h3 class="control-sidebar-heading">Notificaciones Educalinks</h3>
			<ul class="control-sidebar-menu">
				<li>
					<a href="../../biblio/index.php">
					  <i class="menu-icon fa fa-usd bg-green"></i>
					  <div class="menu-info">
						<h4 class="control-sidebar-subheading">Actualización del módulo financiero</h4>
						<p>Cambios de entorno y nuevas opciones</p>
					  </div>
					</a>
				</li>
			</ul>-->
        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
		<!-- Settings tab content -->
		<div class="tab-pane" id="control-sidebar-settings-tab">
			<form method="post">
				<h3 class="control-sidebar-heading">Configuración general</h3>
				<div class="form-group">
					<label class="control-sidebar-subheading">
						Per&iacute;odo activo
						<button type="button" class="pull-right btn btn-warning btn-xs glyphicon glyphicon-refresh"
							onclick="js_general_change_periodo(document.getElementById('ruta_html_common').value + '/general/controller.php' )"></button>
					</label>
					<?php echo $_SESSION['cmb_sidebar_periodo']; ?>
				</div><!-- /.form-group -->
				<!-- /.form-group
				<div class="form-group">
					<label class="control-sidebar-subheading">
						Mostrar nombre de usuario y fecha en reportes
						<input type="checkbox" class="pull-right" checked>
					</label>
					<p>
						Permite que los reportes se impriman con los datos del usuario.
					</p>
				</div> --><!-- /.form-group -->
            </form>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>