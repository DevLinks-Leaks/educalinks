<?php 
	session_start();	 
	include ('../framework/dbconf.php');
?>
<div class="zones">
	<div class="zone">
		<table class="table_striped" id="auditoria_table">
			<thead>
				<th>Tipo de Auditor&iacute;a</th>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="auditoriaTipo"> 
							<select id='cmb_modulo' name='cmb_modulo' onchage='js_funciones_auditoria_modulo_change();'>
								<option value= 'ACA' selected='selected'>ACADEMICO</option>
								<option value= 'FIN'>FINANCIERO</option>
							</select>
							<ul>
								<li><a class="all" href="javascript:seleccionar_todos_acciones()"><label>TODOS</label></a></li>
								<li><a class="none" href="javascript:deseleccionar_todos_acciones()"><label>NINGUNO</label></a></li>
								<li class="list">
									<ul id='audi_inner_list' name='audi_inner_list'>
										<?
										$sql="{call acci_audi_view ()}";
										$audi_cons = sqlsrv_query($conn, $sql);  
										while ($row_audi_view = sqlsrv_fetch_array($audi_cons))
										{   echo "<li><input type='checkbox' name='acciones[]' value='".$row_audi_view['audi_tipo_codi']."' />".$row_audi_view['audi_tipo_deta']."</li>";
										}
										?>
									</ul>
								</li>
							</ul>
						</div>   
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="zone-last">
		<table class="table_striped" id="auditoria_table">
			<thead>
				<th width="45%">Auditor&iacute;a</th>
			</thead>
			<tbody>
				<tr >
					<td width="45%">
						<div class="auditoriaTipo"> 
							<ul>
								<li><a class="all" href="javascript:seleccionar_todos_usuarios()"><label>TODOS</label></a></li>
								<li><a class="none" href="javascript:deseleccionar_todos_usuarios()"><label>NINGUNO</label></a></li>
								<li class="list">
									<ul>
										<?
										$sql="{call usua_audi_view ()}";
										$usua_cons = sqlsrv_query($conn, $sql);  
										while ($row_usua_view = sqlsrv_fetch_array($usua_cons))
										{
											echo "<li><input type='checkbox' name='usuarios[]' value='".$row_usua_view['usua_codi']."'>".$row_usua_view['nombres']."</li>";
										}
										?>
									</ul>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>