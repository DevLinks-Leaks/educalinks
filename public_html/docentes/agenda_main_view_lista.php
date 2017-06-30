<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
	
	if (isset($_POST['curs_para_mate_prof_codi']))
	{
		$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi'];
	}
	else
	{
		if(isset($_GET['curs_para_mate_prof_codi']))  
		{
			$curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
		}
		else
		{
			$curs_para_mate_prof_codi=0;
		}
	} 

	if (isset($_POST['curs_para_mate_codi']))
	{
		$curs_para_mate_codi=$_POST['curs_para_mate_codi'];
	}
	else
	{
		if(isset($_GET['curs_para_mate_codi']))  
		{
			$curs_para_mate_codi=$_GET['curs_para_mate_codi'];
		}
		else
		{
			$curs_para_mate_codi=0;
		}
	} 			 
	
	$params_lista = array( $curs_para_mate_prof_codi, $tipo);
	$sql_lista="{call agen_curs_para_mate_view(?,?)}";
	$agen_curs_para_mate_view = sqlsrv_query($conn, $sql_lista, $params_lista);  
	$cc = 0; 
	
	
?>
<input type="hidden"
       id="curs_para_mate_codi"
       name="curs_para_mate_codi"
       value="<?= $_GET['curs_para_mate_codi'];?>">
<input type="hidden"
       id="curs_para_mate_prof_codi"
       name="curs_para_mate_prof_codi"
       value="<?= $_GET['curs_para_mate_prof_codi'];?>">
<table id='tbl_agenda_main_view' class="table table-striped">
<thead>
  <tr>
    <th width="9%" align="left">Fecha Inicio</th>
    <th width="9%" align="left">Fecha Fin&nbsp;</th>
      <th width="15%" align="left">Tipo de Agenda</th>
    <th width="47%" align="left">Detalles</th>
     <th width="20%"  style='text-align: center;'>Opciones</th>
  </tr>
</thead> 
<tbody>
   <?php  while ($row_agen_curs_para_mate_view = sqlsrv_fetch_array($agen_curs_para_mate_view)) { $cc +=1; ?>
  <tr>
    <td align="left"><?=  date_format( $row_agen_curs_para_mate_view["agen_fech_ini"], 'd/M/Y' ); ?></td>
    <td align="left"><?=  date_format( $row_agen_curs_para_mate_view["agen_fech_fin"], 'd/M/Y' ); ?> </td>
      <td align="left"><?= $row_agen_curs_para_mate_view["agen_tipo"]; ?> </td>
    <td align="left">
    	<h4><b><?= $row_agen_curs_para_mate_view["agen_titu"]; ?></b></h4>
        <h5><?= $row_agen_curs_para_mate_view["agen_deta"] ?> ...</h5>
    </td>
      <td style='text-align:right'>
          <?php if($row_agen_curs_para_mate_view['mater_codi']!=null){ ?>
          <a  class="btn btn-success" target="_blank" title='Descargar Material Adjunto' onmouseover='$(this).tooltip("show")'
              href="<?= $_SESSION['ruta_materiales_carga'].$row_agen_curs_para_mate_view['mater_file'];?>">
              <span class="fa fa-download"></span>
          </a>
          <?}?>
          <?php if($row_agen_curs_para_mate_view['agen_tipo_codi']==2){ ?>
              <a title='Imprimir formato planificación de tareas' onmouseover='$(this).tooltip("show")' href="../admin/reportes_generales/planificacion_tareas.php?agen_codi=<?=$row_agen_curs_para_mate_view['agen_codi'];?>&curs_para_mate_prof_codi=<?=$curs_para_mate_prof_codi;?>" target="_blank" class="btn btn-info">
                  <span class="fa fa-print"> </span>
              </a>
          <?}?>
          <a class="btn btn-default" onclick="load_modal_content('agen_modal_content',<?=$row_agen_curs_para_mate_view['agen_codi'];?>)"
             title='Editar' onmouseover='$(this).tooltip("show")'>
              <span class="fa fa-pencil btn_opc_lista_editar"></span> </a>
		<a class="btn btn-default" onclick="agen_del('para_main','script_agen.php',<?= $curs_para_mate_prof_codi;?>,<?= $curs_para_mate_codi;?>,<?= $row_agen_curs_para_mate_view["agen_codi"]; ?>)"
			title='Eliminar' onmouseover='$(this).tooltip("show")'>
			<span class="fa fa-trash btn_opc_lista_eliminar"></span> </a></td>
  </tr>
  <? } ?> 
  </tbody>
</table>
<style>
	div.dataTables_length { display: none !important; }
</style>