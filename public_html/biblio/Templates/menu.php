	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?= $_SESSION['ruta_foto_logo_web'];?>" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info" style='font-size:x-small;'>
					<p>Unidad Educativa<br>
					<?php if ( !isset( $_SESSION['menu_institucion'] ) ) $_SESSION['menu_institucion'] = para_sist(3); 
						echo $_SESSION['menu_institucion'];
					?></p>
				</div>
			</div>
			
			<? session_start();include ('../framework/dbconf.php');?>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MÓDULO BIBLIOTECA</li>
				<li class='<? if (substr($Menu,0,1)==0) echo 'active'; ?>'><a href="../../biblio/index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<li class="<? if (substr($Menu,0,1)==1) echo 'active'; ?> treeview">
					<a href="#">
						<i class="fa fa-book"></i>
						<span>Recursos</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <? if($Menu==101) echo 'class="active"'; ?>><a href="recurso_new.php"><i class="fa fa-plus-square"></i>Nuevo Recurso</small></a></li>
						<li <? if($Menu==102) echo 'class="active"'; ?>><a href="recurso.php"><i class="fa fa-tv"></i>Control de Recursos</small></a></li>
						<li <? if($Menu==103) echo 'class="active"'; ?>><a href="recurso_reportes.php"><i class="fa fa-bookmark-o"></i>Reportes Recursos</small></a></li>
						<li <? if($Menu==104) echo 'class="active"'; ?>><a href="recurso_item_reportes.php"><i class="fa fa-bookmark-o"></i>Reportes Items</small></a></li>
					</ul>
				</li>
				<li class="<? if (substr($Menu,0,1)==2) echo 'active'; ?> treeview">
					<a href="#">
						<i class="fa fa-hand-lizard-o"></i>
						<span>Pr&eacute;stamos</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <? if($Menu==201) echo 'class="active"'; ?>><a href="prestamo_new.php"><i class="fa fa-plus-square"></i>Nuevo Pr&eacute;stamo</small></a></li>
						<li <? if($Menu==202) echo 'class="active"'; ?>><a href="prestamo.php"><i class="fa fa-tv"></i>Control de Pr&eacute;stamos</small></a></li>
						<li <? if($Menu==203) echo 'class="active"'; ?>><a href="prestamo_reportes.php"><i class="fa fa-bookmark-o"></i>Reportes Pr&eacute;stamos</small></a></li>
						<li <? if($Menu==204) echo 'class="active"'; ?>><a href="prestamo_item_reportes.php"><i class="fa fa-bookmark-o"></i>Rep. Pr&eacute;stamos Detalle</small></a></li>
					</ul>
				</li>
				<li class="<? if (substr($Menu,0,1)==3) echo 'active'; ?> treeview">
					<a href="#">
						<i class="fa fa-wrench"></i>
						<span>Mantenimiento</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <? if($Menu==301) echo 'class="active"'; ?>><a href="autor.php"><i class="fa fa-users"></i>Autores</small></a></li>
						<li <? if($Menu==302) echo 'class="active"'; ?>><a href="categoria.php"><i class="fa fa-sitemap"></i>Categor&iacute;as</small></a></li>
						<li <? if($Menu==303) echo 'class="active"'; ?>><a href="descriptor.php"><i class="fa fa-tags"></i>Descriptores</small></a></li>
						<li <? if($Menu==304) echo 'class="active"'; ?>><a href="tipo.php"><i class="fa fa-th-large"></i>Tipos</small></a></li>
						<li <? if($Menu==305) echo 'class="active"'; ?>><a href="coleccion.php"><i class="fa fa-object-group"></i>Colecciones</small></a></li>
						<li <? if($Menu==306) echo 'class="active"'; ?>><a href="editorial.php"><i class="fa fa-newspaper-o"></i>Editoriales</small></a></li>
						<li <? if($Menu==307) echo 'class="active"'; ?>><a href="procedencia.php"><i class="fa fa-institution"></i>Procedencias</small></a></li>
					</ul>
				</li>
				<li class="<? if (substr($Menu,0,1)==4) echo 'active'; ?> treeview">
					<a href="#">
						<i class="fa fa-upload"></i>
						<span>Importación Datos</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <? if($Menu==401) echo 'class="active"'; ?>><a href="importacion.php"><i class="fa fa-database"></i>Principales</small></a></li>
						<li <? if($Menu==402) echo 'class="active"'; ?>><a href="importacion_recursos.php"><i class="fa fa-database"></i>Recursos</small></a></li>
					</ul>
				</li>
				<li><a href="../help/EDUCALINKS_BIBLIOTECA.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li>
				<li class="<? if ($Menu==800) echo 'active'; ?>"><a href="acerca.php"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>