<?php
    include ('../framework/dbconf.php');
    if(isset($_POST['agen_codi'])){$agen_codi=$_POST['agen_codi'];}else{$agen_codi=0;}

    //Datos del agenda
    $params = array($agen_codi);
    $sql="{call agen_info (?)}";
    $agen_info = sqlsrv_query($conn, $sql, $params);
    $row_agen_info=sqlsrv_fetch_array($agen_info);

    $agen_fech_ini= ($row_agen_info['agen_fech_ini']==null ? date('d/m/Y') : date_format( $row_agen_info["agen_fech_ini"], 'd/m/Y' ) );
    $agen_fech_fin= ($row_agen_info['agen_fech_fin']==null ? date('d/m/Y') : date_format( $row_agen_info["agen_fech_fin"], 'd/m/Y' ) );

    $visible_dynamic= ($row_agen_info['agen_tipo_codi']==2 ? '' : 'display:none;');

    $mater_codi= ($row_agen_info['mater_codi']==null ? 0 :$row_agen_info['mater_codi']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">Agendar Nueva Actividad</h4>
</div>

<form class="form-horizontal">
    <div id="div_mate_edi" class="modal-body">
        <input type="hidden" id="hd_agen_codi" value="<?=$agen_codi;?>" name="hd_agen_codi" />
        <input type="hidden" id="hd_mater_codi" value="<?=$mater_codi;?>" name="hd_mater_codi" />
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
                        $selected = '';
                        if($row_agen_info['agen_tipo_codi']==$agen_tipo_view['agen_tipo_codi'])
                            $selected='selected';
                        else
                            $selected='';
                        echo '<option value="'.$agen_tipo_view["agen_tipo_codi"].'" '.$selected.'>'.$agen_tipo_view["agen_tipo_deta"].'</option>';
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
                <input class='form-control input-sm' id="agen_fech_ini" name="agen_fech_ini" type="text" value="<?= $agen_fech_ini;?>" >
            </div>

            <div class="col-md-2">Fecha Fin:</div>
            <div class="col-md-4">
                <input class='form-control input-sm'
                       id="agen_fech_fin"
                       name="agen_fech_fin"
                       type="text"
                       value="<?= $agen_fech_fin;?>">
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
                       value="<?=$row_agen_info['agen_titu'];?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2">Detalle:</div>
            <div class="col-md-10 ">
                <textarea class="form-control" style="min-width: 100%" name="agen_deta" id="agen_deta"  rows="5" ><?=$row_agen_info['agen_deta'];?></textarea>
            </div>
        </div>
        <div id="div_dynamic" style="<?=$visible_dynamic?>">
            <div class="form-group">
                <div class="col-md-2">Criterio de Evaluación:</div>
                <div class="col-md-10 ">
                    <textarea class="form-control" style="min-width: 100%" name="agen_crit" id="agen_crit" maxlength="200" rows="2" ><?=$row_agen_info['agen_crit'];?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">Indicador de Evaluación:</div>
                <div class="col-md-10 ">
                    <textarea class="form-control" style="min-width: 100%" name="agen_indi" id="agen_indi"  maxlength="200" rows="2" ><?=$row_agen_info['agen_indi'];?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">Tiempo:</div>
<!--                <div id="agen_tiempo" data-name="agen_tiempo" data-input="form-control agen_tiempo" class="col-md-4 bfh-timepicker" data-time="00:00">-->
<!---->
<!--                </div>-->
                <div class="col-md-10 ">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input id="agen_tiempo" type="text" value="<?=$row_agen_info['agen_tiempo']?>" class="form-control timepicker">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">Materiales:</div>
                <div class="col-md-10 ">
                    <textarea class="form-control" style="min-width: 100%" maxlength="200" name="agen_mater" id="agen_mater"  rows="2" ><?=$row_agen_info['agen_mater'];?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">Retroalimentación:</div>
                <div class="col-md-10 ">
                    <textarea class="form-control" style="min-width: 100%" maxlength="300" name="agen_retr" id="agen_retr"  rows="2" ><?=$row_agen_info['agen_retr'];?></textarea>
                </div>
            </div>
        </div>

    </div>
</form>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" onClick="agen_add('para_main','script_agen.php',<?= $_POST['curs_para_mate_prof_codi'];?>,<?= $_POST['curs_para_mate_codi'];?>)">Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>