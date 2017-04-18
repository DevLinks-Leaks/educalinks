<?php
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	if(isset($_POST['add_aula'])){
		if($_POST['add_aula']=='Y'){		
	 		$aula_deta=$_POST['aula_deta'];	 
			$params = array($aula_deta);
			$sql="{call aula_add(?)}";
			$aula_add = sqlsrv_query($conn, $sql, $params);  
			
			//Para auditoría
			$detalle="Descripción: ".$_POST['aula_deta'];
			registrar_auditoria (26, $detalle);
		}
	}
	if(isset($_POST['del_aula'])){
		if($_POST['del_aula']=='Y'){		
	 		$aula_codi=$_POST['aula_codi'];	 
			$params = array($aula_codi);
			$sql="{call aula_del(?)}";
			$aula_del = sqlsrv_query($conn, $sql, $params);  
			$row_aula_upd = sqlsrv_fetch_array($aula_upd);
			
			//Para auditoría
			$detalle="Código: ".$_POST['aula_codi'];
			registrar_auditoria (28, $detalle);
		}
	}
	$params = array();
	$sql="{call aula_view()}";
	$aula_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?> 
<div class="cursos_aulas_main_lista">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="77%"><strong>Listado de Aulas </strong></td>
				<th width="23%"><strong>Opciones</strong></td>
			</tr>
		</thead>
		<tbody>
			<?php  while ($row_aula_view = sqlsrv_fetch_array($aula_view)) { $cc +=1; ?>
			<tr >
				<td height="29">
					<div id="aula_<?= $row_aula_view["aula_codi"]; ?>">
						<input  type="text"  value="<?= $row_aula_view["aula_deta"]; ?>" id="aula_deta_<?= $row_aula_view["aula_codi"]; ?>" name="aula_deta_<?= $row_aula_view["aula_codi"]; ?>" style="width:100%; height=100%; border:none; background:none;  "  disabled="disabled" />
					</div>
				</td>
				<td>
					<?php if (permiso_activo(41)){?>
    				<a class="btn btn-default" id="bt_aula_edit_<?= $row_aula_view["aula_codi"]; ?>" 
						onclick="aula_upd(<?= $row_aula_view["aula_codi"]; ?>)"  ><span class="fa fa-pencil btn_opc_lista_editar"></span> Editar</a>
					<?php }if (permiso_activo(42)){?>
					<a class="btn btn-default" id="bt_aula_dele_<?= $row_aula_view["aula_codi"]; ?>" 
						onclick="aula_del(<?= $row_aula_view["aula_codi"]; ?>)" ><span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar</a>
					<?php }?>
					<script>
					function aula_upd(aula_codi){
						if (document.getElementById('bt_aula_edit_' + aula_codi).innerHTML == '<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar')
						{   document.getElementById('aula_deta_' + aula_codi).disabled = '';
							document.getElementById('aula_deta_' + aula_codi).style = 'width:100%; height=100%; border:none; background:#CADBF4;';
							document.getElementById('bt_aula_edit_' + aula_codi).innerHTML = '<span class="fa fa-floppy-o"></span> Actualizar';
							document.getElementById('bt_aula_dele_' + aula_codi).innerHTML = 'Cancelar'; 
							document.getElementById('aula_deta_' + aula_codi).select();
							document.getElementById('aula_deta_' + aula_codi).focus();
							$('#bt_aula_edit_' + aula_codi).toggleClass('btn-default btn-success');
						}
						else
						{   load_ajax('aula_'+ aula_codi,'script_aula.php','aula_codi=' + aula_codi + '&aula_deta=' + document.getElementById('aula_deta_' + aula_codi).value + '&upd_aula=Y'); 
							document.getElementById('bt_aula_edit_' + aula_codi).innerHTML = '<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar';
							document.getElementById('bt_aula_dele_' + aula_codi).innerHTML = '<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar';
							$('#bt_aula_edit_' + aula_codi).toggleClass('btn-default btn-success');
						}
						
					}
					function aula_del(aula_codi)
					{   if (document.getElementById('bt_aula_edit_' + aula_codi).innerHTML == '<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar')
						{   if (confirm("Esta seguro que desea Eliminar" + aula_codi )) 
							{   load_ajax('curs_aula_main','cursos_aulas_main_lista.php','aula_codi=' + aula_codi + '&del_aula=Y'); 					
							}				
						}
						else
						{   load_ajax('aula_'+ aula_codi,'script_aula.php','aula_codi=' + aula_codi );			 
							document.getElementById('bt_aula_edit_' + aula_codi).innerHTML = '<span class="fa fa-pencil btn_opc_lista_editar"></span> Editar';
							document.getElementById('bt_aula_dele_' + aula_codi).innerHTML = '<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar';
							$('#bt_aula_edit_' + aula_codi).toggleClass('btn-default btn-success');
						}
					}
					</script>
				</td>
			</tr>
 <?php  }?>
		</tbody>
		<tfoot>
			<tr  class="pager_table">
				<td colspan="2">
				<span class="icon-books icon"></span> Total de Cursos ( <?php echo $cc;?> )</td>
			</tr>
		</tfoot>
	</table>
</div>