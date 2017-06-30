<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['agen_codi'])) 
		$agen_codi=$_POST['agen_codi'];
	
	$params = array($agen_codi);
	$sql="{call agen_info(?)}";
	$agen_info = sqlsrv_query($conn, $sql, $params);

	$row_agen_info= sqlsrv_fetch_array($agen_info);
?>
<div class="modal-header" id="modal-header" style="font-weight: bold !important;">
    <button
            type="button"
            class="close"
            data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
    </button>
    <h3 class="modal-title text-primary" id="modal-title"><?= $row_agen_info['agen_titu']; ?><br/>
        <small><?= $row_agen_info['mate_deta']; ?></small>
    </h3>
    <p class="text-muted"> <small><span class="fa fa-clock-o"></span> Publicado el <?=  date_format( $row_agen_info["agen_fech_regi"], 'd/M/Y' ); ?> a las <?=  date_format( $row_agen_info["agen_fech_regi"], 'h:s' ); ?></small>
    </p>
</div>
<div width="100%" id="modal-body" class="modal-body" style="height:300px;overflow-y:scroll;">

    <p class="text-danger"> <b><span class="fa fa-calendar"></span> Inicio:</b> <?=  date_format( $row_agen_info["agen_fech_ini"], 'd/M/Y' ); ?> &nbsp;
        <b><span class="fa fa-calendar"></span> Fin: </b> <?=  date_format( $row_agen_info["agen_fech_fin"], 'd/M/Y' ); ?>
    </p>
    <h4 class="text-info"> <b>Tipo de Agenda: </b>
        <?= $row_agen_info['agen_tipo']; ?>
    </h4>
    <p class="bg-success"> <b>Detalle: </b><br/>
        <?= $row_agen_info['agen_deta']; ?>
    </p>
    <?php if($row_agen_info['agen_tipo_codi']==2){ ?>
        <p class=""> <b>Criterios de Evaluación: </b><br/>
            <?= $row_agen_info['agen_crit']; ?>
        </p>
        <p class=""> <b>Indicadores de Evaluación: </b><br/>
            <?= $row_agen_info['agen_indi']; ?>
        </p>
        <p class=""> <b>Tiempo: </b>
            <span class="fa fa-clock-o"></span> <?= $row_agen_info['agen_tiempo']; ?>
        </p>
        <p class=""> <b>Materiales: </b><br/>
            <?= $row_agen_info['agen_mater']; ?>
        </p>
        <p class=""> <b>Retroalimentación: </b><br/>
            <?= $row_agen_info['agen_retr']; ?>
        </p>
    <?}?>
</div>
<div class="modal-footer" id="modal-footer">
    <?php if($row_agen_info['mater_codi']!=null){ ?>
        <div class="pull-left">
        <a  class="btn btn-success" target="_blank" title='Descargar Material Adjunto' onmouseover='$(this).tooltip("show")'
            href="<?= $_SESSION['ruta_materiales_carga'].$row_agen_info['mater_file'];?>">
            <span class="fa fa-download"> Material Adjunto</span>
        </a>
        </div>
    <?}?>
    <button
            type="button"
            class="btn btn-default"
            data-dismiss="modal">
        Cerrar
    </button>
</div>
