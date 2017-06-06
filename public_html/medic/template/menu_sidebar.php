<!-- Modal Módulos-->
<div class="modal fade" id="ModalEducalinksMoludos" tabindex="-1" role="dialog" aria-labelledby="modal_configBoton" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#E55A2F'>
				<h4 class="modal-title" id="ModalEducalinksMoludos_head" style='color:white;text-align:center;'>
					<i style="font-size:large;color:white;" class="fa fa-briefcase"></i>&nbsp;Módulos del sistema</h4>
			</div>
			<div class="modal-body" id="ModalEducalinksMoludos_body" style='background-color:#F5F5F5;'>
				<div class="row">
					<div class="col-xs-12">
						<?php if($_SESSION['certus_acad']){ ?>
							<a href="../../../admin/index.php" title="Ir al módulo académico" style='width:100%' class='btn btn-warning'>
								<i class='fa fa-graduation-cap'></i>&nbsp;Académico
							</a><br><br><?php }?>
						<?php if($_SESSION['certus_finan']){ if($_SESSION['rol_finan']==1){?>
							<a href="../../../main_admisiones.php" title="Ir al módulo admisiones" style='width:100%' class='btn btn-success'>
								<i class='fa fa-dollar'></i>&nbsp;Financiero
							</a><br><br><?php }}?>
						<?php if($_SESSION['certus_biblio']){ if($_SESSION['rol_biblio']==1){?>
							<a href="../../../main_finan.php" title="Ir al módulo financiero" style='width:100%' class='btn btn-primary'>
								<i class='fa fa-book'></i>&nbsp;Biblioteca
							</a><br><br><?php }}?>
						<?php if($_SESSION['certus_medic']){ if($_SESSION['rol_medico']==1){?>
							<a href="../../../biblio/index.php" title="Ir al módulo biblioteca" style='width:100%' class='btn btn-danger'>
							<i class='fa fa-medkit'></i>&nbsp;Médico
							</a><br><br><?php }}?>
					</div>
				</div>
			</div>
			<div class="modal-footer" style='background-color:#F5F5F5;text-align:center'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>