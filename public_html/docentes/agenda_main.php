<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <link href="../theme/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../theme/BootstrapFormHelpers/dist/css/bootstrap-formhelpers.min.css" media="screen" rel="stylesheet">
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=2;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Agenda</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-calendar"></i></a></li>
						<li class="active">Agenda</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a  href='agenda.php'
										class="btn btn-warning">
											<span class="fa fa-chevron-left"></span> Volver
									</a>
									<a  id="bt_agen_add"
										class="btn btn-primary"
										data-toggle="modal"
										data-target="#agen_nuev"
										onclick="refresh_modal_agenda();">
											<span class="fa fa-plus"></span> Agenda
									</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="js/agenda.js?<?=$rand?>">
								</script>
								<div id="para_main">
									<?php include ('agenda_main_view.php'); ?>
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
        <script type="text/javascript" src="../theme/BootstrapFormHelpers/dist/js/bootstrap-formhelpers.min.js"></script>
        <script type="text/javascript" src="../theme/BootstrapFormHelpers/js/bootstrap-formhelpers-timepicker.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$("#agen_fech_ini").datepicker();
				$("#agen_fech_fin").datepicker();
				$("#tbl_agenda_main_view").DataTable();
				
			} );
			function refresh_modal_agenda(){
				$("#agen_fech_ini").val(obtener_fecha('hoy'));
				$("#agen_fech_fin").val(obtener_fecha('hoy'));
				$('#agen_titu').val('');
				$('#agen_deta').val('');
			}
		</script>
	</body>
</html>
<div 
	class="modal fade" 
	id="agen_nuev" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="myModalLabel" 
	aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">
				    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
		        </button>
		        <h4 class="modal-title" id="myModalLabel">Agendar Nueva Actividad</h4>
	        </div>
            <form class="form-horizontal">
                <div id="div_mate_edi" class="modal-body">
                    <div class="form-group">
                        <div class="col-md-2">Tipo de Agenda:</div>
                        <div class="col-md-4">
                            <select class='form-control' onchange="cambiar_por_tipo(this.value);" id="agen_tipo_codi" name="agen_tipo_codi">
                            <?php
                            $params = array();
                            $sql="{call agen_tipo_view()}";
                            $stmt = sqlsrv_query($conn, $sql, $params);
                            while($agen_tipo_view= sqlsrv_fetch_array($stmt))
                            {
                                echo '<option value="'.$agen_tipo_view["agen_tipo_codi"].'" >'.$agen_tipo_view["agen_tipo_deta"].'</option>';
                            }
                            ?>
                            </select>
                        </div>
                        <div class="col-md-2">Material Adjunto</div>
                        <div class="col-md-4">
                            <input  class='form-control input-sm' type="file" name="mater_codi" id="mater_codi"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-2">Fecha Inicio:</div>
                        <div class="col-md-4">
                            <input class='form-control input-sm' id="agen_fech_ini" name="agen_fech_ini" type="text" value="<?= date('d/m/Y');?>" >
                        </div>

                        <div class="col-md-2">Fecha Fin:</div>
                        <div class="col-md-4">
                            <input class='form-control input-sm'
                                   id="agen_fech_fin"
                                   name="agen_fech_fin"
                                   type="text"
                                   value="<?= date('d/m/Y');?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">Título:</div>
                        <div class="col-md-10 ">
                            <input class='form-control input-sm'
                                   name="agen_titu"
                                   maxlength="30"
                                   type="text"
                                   id="agen_titu"
                                   value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">Detalle:</div>
                        <div class="col-md-10 ">
                            <textarea class="form-control" style="min-width: 100%" name="agen_deta" id="agen_deta"  rows="5" ></textarea>
                        </div>
                    </div>
                    <div id="div_dynamic" style="display:none;">
                        <div class="form-group">
                            <div class="col-md-2">Criterio de Evaluación:</div>
                            <div class="col-md-10 ">
                                <textarea class="form-control" style="min-width: 100%" name="agen_crit" id="agen_crit" maxlength="200" rows="2" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">Indicador de Evaluación:</div>
                            <div class="col-md-10 ">
                                <textarea class="form-control" style="min-width: 100%" name="agen_indi" id="agen_indi"  maxlength="200" rows="2" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">Tiempo:</div>
                            <div id="agen_tiempo" data-name="agen_tiempo" data-input="form-control agen_tiempo" class="col-md-4 bfh-timepicker" data-time="00:00">

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">Materiales:</div>
                            <div class="col-md-10 ">
                                <textarea class="form-control" style="min-width: 100%" maxlength="200" name="agen_mater" id="agen_mater"  rows="2" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">Retroalimentación:</div>
                            <div class="col-md-10 ">
                                <textarea class="form-control" style="min-width: 100%" maxlength="300" name="agen_retr" id="agen_retr"  rows="2" ></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden"
                           id="curs_para_mate_codi"
                           name="curs_para_mate_codi"
                           value="<?= $_GET['curs_para_mate_prof_codi'];?>">
                </div>
            </form>

	  <div class="modal-footer">
		 <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="agen_add('para_main','script_agen.php','<?= $_GET['curs_para_mate_prof_codi'];?>','<?= $_GET['curs_para_mate_codi'];?>') ">Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	   
	  </div>
	</div>
  </div>
</div>