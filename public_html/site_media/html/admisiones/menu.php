	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="{logo_institucion}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info" style='font-size:x-small;'>
					<p>Unidad Educativa<br>{nombre_institucion}</p>
				</div>
			</div>
			<!-- search form 
			<form action="#" method="get" class="sidebar-form">
				<div class="input-group">
					<input type="text" name="q" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>-->
			<!-- /.search form -->
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MÓDULO ADMISIONES</li>
				<li><a href="../../admisiones/general/"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				</li>
				<li>
				{adm_ing_solicitud}
				</li>
				<li class="{openSoli} treeview">
					<a href="#">
						<i class="fa fa-folder-open-o"></i>
						<span>Solicitudes</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="{menuSoli01}">{adm_band_recibida}</li>
						<li class="{menuSoli02}">{adm_band_pdte_pago}</li>
						<li class="{menuSoli03}">{adm_band_asignar_fecha}</li>
						<li class="{menuSoli04}">{adm_band_subir_sintesis}</li>
						<li class="{menuSoli05}">{adm_band_agregar_director}</li>
						<li class="{menuSoli06}">{adm_band_aprobar_comite}</li>
						<li class="{menuSoli07}">{adm_band_admitidos}</li>
						<li class="{menuSoli08}">{adm_band_guardadas}</li>
						<li class="{menuSoli09}">{adm_band_no_admitidos}</li>
						<li class="{menuSoli10}">{adm_band_administrar}</li>
					</ul>
				</li>
				<!--<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="fa fa-pie-chart"></i>
						<span>Informes</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-eye"></i>Estadística de admisiones</small></a></li>
						<li><a href="#"><i class="fa fa-eye"></i>Exámenes a rendir</small></a></li>
						<li><a href="#"><i class="fa fa-eye"></i>Horarios</small></a></li>
					</ul>
				</li>-->
				<!--<li class="{openSoliConfigUsua} treeview">
					<a href="#">
						<i class="fa fa-user"></i>
						<span>Configuración de Usuario</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="../../common/usuario/"><i class="fa fa-group"></i>Usuarios</a></li>
						<li><a href="../../common/rol/"><i class="fa fa-check-square"></i>Roles de usuarios</a></li>
						<li><a href="../../common/permisos/"><i class="fa fa-key"></i>Permisos</a></li>
					</ul>
				</li>-->
				<li class="{openSoliConfigSist} treeview">
					<a href="#">
						<i class="fa fa-gears"></i>
						<span>Configuración de sistema</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<!--<li class="{menuopenSoliConfigSist01}"><a href="../../admisiones/periodo/"><i class="fa fa-calendar-plus-o"></i>Períodos de admisión</a></li>-->
						<li class="{menuopenSoliConfigSist02}">{adm_doc_adjuntos}</li>
					</ul>
				</li>
				<li><a href="../../../manuales/Manual_Educalinks_financiero_2016_04_11_v041.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li><!-- {menu001} -->
				<li class="{open7}"><a href="../../common/acerca/"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>