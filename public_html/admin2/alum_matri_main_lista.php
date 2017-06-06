<?
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');

	if (isset($_POST["alum_codi"]))
	{	$alum_codi = $_POST["alum_codi"];
	}
	else
	{	$alum_codi = "";
	}
	
	if (isset($_POST["alum_apel"]))
	{	$alum_apel = $_POST["alum_apel"];
	}
	else
	{	$alum_apel = "";
	}
	
	if (isset($_POST["curs_para_codi"]))
	{	$curs_para_codi = $_POST["curs_para_codi"];
	}
	else
	{	$curs_para_codi = "0";
	}
	
	if (isset($_POST["alum_estado"]))
	{	$alum_estado = $_POST["alum_estado"];
	}
	else
	{	$alum_estado = "-1";
	}
  
	$params = array($alum_codi,$alum_apel,$curs_para_codi,$alum_estado,$_SESSION['peri_codi']);
	$sql="{call alumnos_main_lista2(?,?,?,?,?)}";
	$alum_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>
<div class="alumnos_main_lista">
<style>
	.rTable {
		display: table;
		width: 100%;
	}
	.rTableRow {
		display: table-row;
	}
	.rTableHeading {
		display: table-header-group;
		background-color: #ddd;
	}
	.rTableCell, .rTableHead {
		display: table-cell;
		padding: 3px 10px;
		width: 33%;
		/*border: 1px solid #999999;*/
	}
	.rTableCell, .rTableHead {
		display: table-cell;
		padding: 3px 10px;
		width: 33%;
		/*border: 1px solid #999999;*/
	}
	.rTableHeading {
		display: table-header-group;
		background-color: #ddd;
		font-weight: bold;
	}
	.rTableFoot {
		display: table-footer-group;
		font-weight: bold;
		background-color: #ddd;
	}
	.rTableBody {
		display: table-row-group;
	}
	a,
	a label {
		cursor: pointer;
		text-decoration: none !important;
	}
</style>

<table class="table table-striped" id="alum_table">
 <thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
  <tr>
    <th width="5%" class="sort"><span class="icon-sort icon"></span>&nbsp;Código </th>
    <th width="25%" class="sort"><span class="icon-sort icon"></span>&nbsp;Nombre</th>
    <th width="20%" class="sort"><span class="icon-sort icon"></span>&nbsp;Curso</th>
    <th width="15%" class="sort"><span class="icon-sort icon"></span>&nbsp;Estado</th>
  </tr>
 </thead>
 
	<?php 
		
		$perm_22='N';
		$perm_81='N';
		$perm_23='N';
		$perm_24='N';
		if (permiso_activo(22)){  
			$perm_22='A';	
	  	}
		if (permiso_activo(81)){ 
			$perm_81='A';
   	 	}	 
		if (permiso_activo(23)){ 
			$perm_23='A';
   	 	}
		if (permiso_activo(24)){
			$perm_24='A';	
		}	
		if (permiso_activo(91)){
			$perm_91='A';	
		}	
		if (permiso_activo(515)){
			$perm_515='A';
		}
	 ?>
 <tbody>
 <?php  
	while ($row_alum_busq = sqlsrv_fetch_array($alum_busq)) 
	{
		// $params_estado = array($row_alum_busq["alum_curs_para_codi"]);
		// $sql_estado="{call alum_info_alum_est_info(?)}";
		// $stmt_estado = sqlsrv_query($conn, $sql_estado, $params_estado);
		// if( $stmt_estado === false )
		// {
		// 	echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
		// }
		// $alum_est_view= sqlsrv_fetch_array($stmt_estado);
		$nombre_completo = validarTildeHTML($row_alum_busq["alum_apel"])." ".validarTildeHTML($row_alum_busq["alum_nomb"]);
		$cc +=1; ?>
		<tr>
			<td><?php echo $row_alum_busq["alum_codi"]; ?></td>
			<td><?php echo $nombre_completo; ?></td>
			<td><?php echo $row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"]; ?></td>
			<td><?php echo $row_alum_busq["esta_deta"]; ?></td>
		</tr>
	<?php  
	
	}
	?>
	</tbody>
	<tfoot>
		<tr class="pager_table" >
			<td colspan="2"><span class="icon-users icon"></span> Total de Alumnos ( <?php echo $cc; ?> )</td>
			<td colspan="1" class="right"><div class="paging"></div></td>
		</tr>
	</tfoot>
</table>
</div>
<?php
function alumnos_main_genera_tabla_por_columnas($array_con_td, $num_columnas=2, $border=0, $width='100%', $align='center')
{	$aux = 0;
	$c = count($array_con_td);
	$body = "";
	$body.='<div class="rTableRow">';
	$tr = 1;
	while ($aux < $c)
	{	$body.=  $array_con_td[$aux];
		$aux+=1;
		if (fmod($aux, $num_columnas)==0) 
		{	$body.='</div><div class="rTableRow">';
			$tr++;
		}
	}
	$tr = $tr * $num_columnas;
	$td_faltantes = $tr - $c;
	
	for ( $aux2=0; $aux2<$td_faltantes; $aux2++ )
	   $body.='<div class="rTableCell"></div>';
	$body.='</div>';
	
	$table= "<div class='rTable' style='text-align:".$align."; width:".$width."' >";
	$table.= $body;
	$table.= "</div>";
	
	return $table;
}
?>