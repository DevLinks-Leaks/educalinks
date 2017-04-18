<?php  
	session_start();    
    include ('../framework/funciones.php');  
    include ('../framework/dbconf.php');	
?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Periodo Activo: <?= $_SESSION['peri_deta']; ?></h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">
		<table class="table table-striped">
			<tr>
				<th width="78" height="30">Fecha</th>
				<th width="102">Usuario</th>
				<th width="104">Accion</th>    
				<th width="309">Detalle</th>   
			</tr>
		<?php 
			$params = array();
			$sql="{call admin_moni_general()}";
			$admin_moni_general = sqlsrv_query($conn, $sql, $params);  
			$row_admin_moni_general = sqlsrv_fetch_array($admin_moni_general);
			
			$admin_moni_general_new_cc =$row_admin_moni_general['audi_codi'];
		
		?>
		<?php  do {  ?>
			<tr>
				<td align="left" valign="middle"><?=  date_format( $row_admin_moni_general["audi_fech"], 'd/M/Y  h:i:s' ); ?> </td>
				<td align="center" valign="middle"><?= $row_admin_moni_general['usuario'];  ?></td>    
				<td align="center" valign="middle"><?= $row_admin_moni_general['audi_tipo_deta'];  ?></td>
				<td align="center" valign="middle"><?= $row_admin_moni_general['detalle'];  ?></td>
			</tr>
		<?php }while ($row_admin_moni_general = sqlsrv_fetch_array($admin_moni_general)); ?>
		</table>
		<input id="admin_moni_general_new_cc" value="<?= $admin_moni_general_new_cc  ?>"  type="hidden" />
	</div>
</div>