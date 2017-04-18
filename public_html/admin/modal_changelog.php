<?php
require_once ('../framework/dbconf_main.php');

$modulo = 'ACAD';
$params = array($modulo);
$sql="{call changelog_view(?)}";
$changelog_view = sqlsrv_query($conn, $sql, $params);  

// 
?> 
<div class="carousel" style="padding: 10px;">
    <?php while($row_changelog_view = sqlsrv_fetch_array($changelog_view)){
        setlocale(LC_ALL, "esp");
        $fecha_hoy=strftime("%B %d ,%Y", strtotime($row_changelog_view['chan_fech_regi']));
    ?>
        <div id="<?=$row_changelog_view?>" >
            <table style="width:100%;">
                <?php if($row_changelog_view['chan_img']!=null){ ?>
                <tr>
                    <td><img  style="" src="../imagenes/changelog/<?=$row_changelog_view['chan_img']?>" /></td>
                </tr>
                <?}?>
                <tr>
                    <td><b><h3 style="text-align: center; padding-bottom: 0px;"><?=$row_changelog_view['chan_titu']?></h3></b></td>
                </tr>
                <tr>
                    <td>
                        <b><i>Cambios en Educalinks- <span style="text-transform: capitalize;"> <?=$fecha_hoy?></span></i></b>
                    </td>
                </tr>
                <tr>
                    <td><p><?=$row_changelog_view['chan_desc']?></p></td>
                </tr>
            </table>
        </div>
    <?}?>
</div>
<style>

</style>