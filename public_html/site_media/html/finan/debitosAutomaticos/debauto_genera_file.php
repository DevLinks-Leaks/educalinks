<div class='nav-tabs-custom'>
    <ul class="nav nav-tabs" id="myTabs">
        <li {tab_class1}><a data-toggle="tab" href="#home">
            <div id='div_file_status_top' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'></div>
            <span class='glyphicon glyphicon-list-alt'></span><span class='hidden-xs'> Crear formato</span></a></li>
        <li {tab_class2}><a data-toggle="tab" href="#menu2"><span class='glyphicon glyphicon-import'></span><span class='hidden-xs'> Importar archivo</span></a></li>
        <li {tab_class3}><a data-toggle="tab" href="#menu3">
            <div id='menu3_loader' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'></div>
            </span><span class='glyphicon glyphicon-list'></span><span class='hidden-xs'> Listado</span></a></li>
		<li {tab_class4}><a data-toggle="tab" href="#menu4"><span class='fa fa-clipboard'></span><span class='hidden-xs'> Reportes de débito</span></a></li>
		<li class='pull-right'>
			<a href="#" class="text-muted"
				aria-hidden="true" data-toggle="modal" data-target="#modal_infoSaf"><i class="fa fa-info-circle" title='Ayuda' onmouseover='$(this).tooltip("show");'></i></a>
		</li>
		<li class='pull-right'>
			<a href="#" class="text-muted" onclick="js_debtAut_get_config( );" 
				aria-hidden="true" data-toggle="modal" data-target="#modal_configSaf"><i class="fa fa-gear" title='Opciones' onmouseover='$(this).tooltip("show");'></i></a>
		</li>
    </ul>
    <form id="file_form" action="{ruta_html_finan}/debitosAutomaticos/controller.php" enctype="multipart/form-data" method="post" target="_blank">
		<input type='hidden' id='hd_exp_opc_ant'  name='hd_exp_opc_ant' value='{hd_exp_opc_ant}'></input>
		<input type='hidden' id='hd_exp_opc_ctas' name='hd_exp_opc_ctas' value='{hd_exp_opc_ctas}'></input>
		<!-- Modal cargar archivo-->
		<div class="modal fade bs-example-modal-sm" id="modal_ask_load_file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#5cb85c">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" style='color:white;'><span class="fa fa-upload"></span> Subida de archivo</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12" style='text-align:center;'>
								¿Cargar archivo ahora?
							</div>
						</div>
						<input type='hidden' id='hd_del_mes_codi' name='hd_del_mes_codi' value=''></input>
					</div>
					<div class="modal-footer" style='text-align:center;'>
						<button class="btn btn-success" type="button" onclick="js_debtAuto_subirarchivo_followed( )">Continuar</button>
						<button class="btn btn-default" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Información-->
		<div class="modal fade" id="modal_infoSaf" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-question-circle'></span>&nbsp;Acerca de débito bancarios/exportación de archivos</h4>
					</div>
					<div class="modal-body" id="modal_infoSaf_body">
						<p>Esta ventana tiene la función de crear formatos que permitan al usuario exportar información del sistema relacionada a:</p>
						
						<ul>
							<li>Alumnos con débito bancario.</li>
							<li>Alumnos/Clientes con deudas.</li>
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Entendido</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /. Modal Información-->
		<!-- Modal Configuraciòn-->
		<div class="modal fade" id="modal_configSaf" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-cog'></span>&nbsp;Configuración de exportación de archivos<h4>
					</div>
					<div class="modal-body" id="modal_configSaf_body">
					
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" data-loading='Espere...'
							id='btn_debtAuto_set_config' name='btn_debtAuto_set_config' onClick='js_debtAut_set_config( );'>
							<span class='fa fa-floppy-o'></span>&nbsp;Guardar Cambios</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /. Modal Configuraciòn-->
		<!-- Modal Guardar-->
		<div class="modal fade" id="modal_formato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Nuevo Formato de Archivo</h4>
					</div>
					<div class="modal-body" id="modal_formato_body">
						<div class="row" style="width:100%; padding-left:20px;">
							<div class="form-group col-sm-8" style="float:left; padding-left:5px;">
								<label id='lbl_forma_descripccion_add' name='lbl_forma_descripccion_add' for="forma_descripccion_add" class='control-label'><b>Nombre del Formato</b></label>
								<input type="text" class="form-control" name="forma_descripccion_add" id="forma_descripccion_add" placeholder="Escriba aquí el nombre del formato nuevo"></input>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-success" onclick="guarda_formato('file_form','{ruta_html_finan}/debitosAutomaticos/controller.php');">
							<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.Modal Guardar-->
		<!-- Modal Cargar-->
		<div class="modal fade" id="modal_cargarFormatoArchivo" tabindex="-1" role="dialog" aria-labelledby="mymodal_cargarFormatoArchivo" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="mymodal_cargarFormatoArchivo">Cargar formato de archivo</h4>
					</div>
					<div class="modal-body" id="modal_cargarFormatoArchivo_body">
						<div class="grid">
							<div class="row">
								<div class='col-sm-9'>
									<label id='lbl_cmb_formatos_copyPaste' name='lbl_cmb_formatos_copyPaste' for="cmb_formatos_copyPaste" class='control-label'><b>Esriba el nombre del formato</b></label>
									<div id="div_cmb_carga_formato" name="div_cmb_carga_formato">{cmb_carga_formato}</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button id='btn_formato_cargar_followed' name='btn_formato_cargar_followed' 
								class="btn btn-info" type="button" 
								onclick="carga_archivo(document.getElementById('formatos_add').value,'div_campos','{ruta_html_finan}/debitosAutomaticos/controller.php');">
							<span style='color:#FFDC89;' class='glyphicon glyphicon-folder-open'></span>&nbsp;&nbsp;Cargar archivo
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.Modal Cargar-->
		<!-- Modal Copiar/Pegar-->
		<div class="modal fade" id="modal_copy_paste" tabindex="-1" role="dialog" aria-labelledby="mymodal_copy_paste" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="mymodal_copy_paste">Copiar y pegar formato de archivo</h4>
					</div>
					<div class="modal-body" id="modal_copy_paste_body">
						<div class="grid">
							<div class="row" >
								<div class='col-sm-12'>
									<label id='forma_descripccion_copy_paste' name='forma_descripccion_copy_paste'></label>
								</div>
							</div>
							<div class="row" >
								<div class='col-sm-12'>
									<hr style="padding:3px;margin:0px;"/>
									<br>
								</div>
							</div>
							<div class="row" style='display:none;'>
								<div class='col-sm-3'>
									<label id='lbl_cmb_formatos_copyPaste' name='lbl_cmb_formatos_copyPaste' 
											for="cmb_formato_copyPaste" class='control-label'><small>Nombre del Formato anterior</small></label>
								</div>
								<div class="col-sm-8">
									<div id="div_cmb_formato_copyPaste" name="div_cmb_formato_copyPaste">{cmb_copyPaste_formato}</div>
								</div>
							</div>
							<div class="row">
								<div class='col-sm-3'>
									<label id='lbl_forma_descripccion_copyPaste' name='lbl_forma_descripccion_copyPaste' 
											for="txt_forma_descripccion_copyPaste" class='control-label'><small>Nombre del nuevo Formato</small></label>
								</div>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="txt_forma_descripccion_copyPaste" id="txt_forma_descripccion_copyPaste" placeholder="Escriba aquí el nombre del formato nuevo"></input>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button id='btn_formato_nuevo_generar' name='btn_formato_nuevo_generar' 
								class="btn btn-success" type="button" 
								onclick="js_debtAut_copiar_archivo_copy(document.getElementById('cmb_formato_copyPaste').value,'div_tbl_format','{ruta_html_finan}/debitosAutomaticos/controller.php');">
							<span style='color:white;' class='glyphicon glyphicon-copy cursorlink'></span>&nbsp;Copiar formato
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /.Modal Copiar/Pegar-->
		<!-- Modal Exportar-->
		<div class="modal fade" id="modal_exportarFormatoArchivo" tabindex="-1" role="dialog" aria-labelledby="mymodal_exportarFormatoArchivo" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="mymodal_exportarFormatoArchivo">
							Exportando archivo con el formato de <span id='forma_descripccion_exp' name='forma_descripccion_exp'></span>
						</h4>
					</div>
					<div class="modal-body" id="modal_exportarFormatoArchivo_body">
						<div id='div_step_1' name='div_step_1' class="form-horizontal" style='display:inline'>
							<input type='hidden' id='hd_id_formato_exp' name='hd_id_formato_exp' value=''></input>
							<input type='hidden' id='hd_opc_ctas_ant' name='hd_opc_ctas_ant' value='2'></input>
							<input type='hidden' id='hd_opc_ctas_inl' name='hd_opc_ctas_inl' value='2'></input>
							<div class="form-group" >
								<div class='col-sm-3'>
									<label id='lbl_nombre_exp' name='lbl_nombre_exp' for="txt_nombre_exp" 
											class='control-label'><small>Nombre de archivo</small></label>
								</div>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="txt_nombre_exp" id="txt_nombre_exp"
											placeholder="debitosAutomaticos"></input>
								</div>
							</div>
							<div class="form-group">
								<div class='col-sm-3'>
									<label id='lbl_tipo_formato' name='lbl_tipo_formato' for="cmb_tipo_formato" 
											class='control-label'><small>Extensi&oacute;n</small></label>
								</div>
								<div class='col-sm-7'>
									<select id='cmb_tipo_formato' name='cmb_tipo_formato' class="form-control"
										onchange='js_debtAuto_cmb_tipo_formato_onchange(this,"div_formato_separador");'>
										<option value='xlsx' selected='selected'>Libro de excel (*.xlsx)</option>
										<option value='txt'>TEXTO (MS-DOS) (*.txt)</option>
										<option value='csv'>CSV (delimitado por caracteres) (*.csv)</option>
									</select>
								</div>
							</div>
							<div id='div_formato_separador' name='div_formato_separador'  class="collapse">
								<div class="form-group" >
									<div class='col-sm-3'>
										<label id='lbl_tipo_formato_delimitador' name='lbl_tipo_formato_delimitador' 
												for="cmb_tipo_formato_delimitador" 
												class='control-label'><small>Separador de campo</small></label>
									</div>
									<div class='col-sm-5' >
										<select id='cmb_tipo_formato_delimitador' name='cmb_tipo_formato_delimitador' class="form-control">
											<option value='' selected='selected'>Sin separador</option>
											<option value='&#32;' selected='selected'> (Un espacio)</option>
											<option value='.'>"." (punto)</option>
											<option value=','>"," (coma)</option>
											<option value=':'>";" (dos puntos)</option>
											<option value=';'>";" (punto y coma)</option>
											<option value='|'>"|" (pipe o barra lateral)</option>
											<option value="&#09;">"\t" (espacio tabulado)</option>
										</select>
									</div>
								</div>
								<div class="form-group" >
									<div class='col-sm-3'>
										<label id='lbl_tipo_formato_cercado' name='lbl_tipo_formato_cercado' for="cmb_tipo_formato_cercado" 
												class='control-label'><small>Cercado</small>
										
											<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
												<a href='#' data-placement="top" onmouseover='$(this).tooltip("show")' 
													title='Caracter con el que se encierra cada campo. Ej. 1: Campo sin cercado; Ej. 2: "Campo con comillas dobles".' data-placement='right'>
													<span class='glyphicon glyphicon-question-sign'></span></a>
											</div>
										</label>
									</div>
									<div class='col-sm-4' >
										<select id='cmb_tipo_formato_cercado' name='cmb_tipo_formato_cercado'  class="form-control">
											<option value='' selected='selected'>Sin cercado</option>
											<option value='"'>" (comilla doble)</option>
											<option value="'">' (comilla simple)</option>
										</select>
									</div>
								</div>
								<div class="form-group" >
									<div class='col-sm-3'>
										<label id='lbl_tipo_formato_fin_de_linea' name='lbl_tipo_formato_fin_de_linea' for="cmb_tipo_formato_fin_de_linea" 
												class='control-label'><small>Fin de l&iacute;nea</small></label>
									</div>
									<div class='col-sm-8' >
										<select id='cmb_tipo_formato_fin_de_linea' name='cmb_tipo_formato_fin_de_linea'  class="form-control">
											<option value='&#10;' selected='selected'>"\r\n" (salto de linea)</option>
											<option value='.&#10;'>".\r\n" (punto, seguido de salto de línea)</option>
											<option value=',&#10;'>",\r\n" (coma, seguida de salto de línea)</option>
											<option value=':&#10;'>";\r\n" (dos puntos, seguidos de salto de línea)</option>
											<option value=';&#10;'>";\r\n" (punto y coma, seguidos de salto de línea)</option>
											<option value='|&#10;'>"|" (pipe o barra lateral, seguido de salto de línea)</option>
											<option value='&#09;&#10;'>"\t\r\n" (espacio tabulado, seguido de salto de línea)</option>
											<option value='.'>"." (punto)</option>
											<option value=','>"," (coma)</option>
											<option value=':'>";" (dos puntos)</option>
											<option value=';'>";" (punto y coma)</option>
											<option value='|'>"|" (pipe o barra lateral)</option>
											<option value="&#09;">"\t" (espacio tabulado)</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<span style="font-size:small;font-weight:bold;">FILTROS</span>
									<hr style="padding:3px;margin:0px;">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3">
									<span style="font-size:small;">Estado facturas</span>
								</div>
								<div class="col-sm-7">
									<select class='form-control' id='cmb_fac_estado' name='cmb_fac_estado'>
										<option value=''>- Seleccione estado -</option>
										<option value='P'>Pagado</option>
										<option value='PC' selected='selected'>Por cobrar</option>
										<option value='PV'>Por validar</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-3">
									<span style="font-size:small;">Producto</span>
								</div>
								<div class="col-sm-9">
									{cmb_producto}
								</div>
							</div>
							<div id='div_filtros_debitoBancario' name='div_filtros_debitoBancario' style='display:none;'>
								<div class="form-group">
									<div class="col-sm-3">
										<span style="font-size:small;">Banco</span>
										<input type="radio" id='rb_filtro' name='rb_filtro' value='banco'
											onclick="js_debtAut_toggle_readonly_tarj_banco( );"/>
									</div>
									<div class="col-sm-7">
										{cmb_banco}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3">
										<span style="font-size:small;">Tarjeta de crédito</span>
										<input type="radio" id='rb_filtro' name='rb_filtro' value='tarjeta'
											onclick="js_debtAut_toggle_readonly_tarj_banco(  );"/>
									</div>
									<div class="col-sm-7">
										{cmb_tarjCredito}
									</div>
								</div>
							</div>
						</div>
						<div id='div_step_2' name='div_step_2' class="form-horizontal" style='display:none'>
							<div class="form-group" >
								<div class="col-sm-12">
									<div class="alert alert-default" role="alert">
										<p><span class="fa fa-upload" aria-hidden="true"></span>
											¡Aviso!
											<hr style="padding:3px;margin:0px;">
											Parece ser que en el plan de cobros (Períodos anuales), éste no es el primer ítem de cobro. 
											Hay items con fecha de inicio cobro menor, y hay alumno(s), los cuales, estás intentando obtener información para cobrar este ítem,
											pero que tiene(n) deuda(s) pendiente(s) de items anteriores.
										</p>
									</div>
								</div>
							</div><div class="form-group" >
								<div class="col-sm-12">
									¿Qué desea hacer?
								</div>
							</div>
							<div class="form-group" >
								<div class="col-sm-12">
									<ol type=”1” start=”11”>
										<li> Ver la lista de plan de pago a la que hace referencia este mensaje, según el período actual. </li>
										<li> Descargar lista de los alumnos con deudas vencidas con información de la deuda. </li>
										<li> Exportar archivo, pero obtener la deuda más antigua de los alumnos deudores de ítems anteriores según el plan de pago. </li>
										<li> Exportar archivo normalmente </li>
										<li onclick="js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );"><span class='fa fa-arrow-left'></span> Volver.</li>
									</ol>
								</div>
							</div>
						</div>
						<div id="div_step_3" name="div_step_3" class="form-horizontal" style="display:none">
							<div class="form-group" >
								<div class="col-sm-12">
									<div class="alert alert-default" role="alert">
										<p><span class="fa fa-upload" aria-hidden="true"></span>
											¡Aviso!
											<hr style="padding:3px;margin:0px;">
											Hay clientes con intento fallido de débito automático por falta de liquidez en la cuenta principal.<br>
											<br>
											Los clientes con intento fallido dejarán de generar este mensaje una vez que tengan un pago exitoso (ya sea caja, ventanilla, debito, etc.).
										</p>
									</div>
								</div>
							</div>
							<div class="form-group" >
								<div class="col-sm-12">
									¿Qué desea hacer?
								</div>
							</div>
							<div class="form-group" >
								<div class="col-sm-12">
									<ol type=”1” start=”11”>
										<li>Generar archivo de débito de todos los clientes y a los deudores con intento fallido de débito, obtener información de cuenta secundaria.
										<li>Generar archivo de débito de todos los clientes y a los deudores con intento fallido de débito, obtener información de cuenta principal.
										<li>Generar archivo de débito sólo de deudores con intento fallido de débito, con información de cuenta secundaria.
										<li>Generar archivo de débito sólo de deudores con intento fallido de débito, con información de cuenta principal.
										<li>Generar archivo de débito sólo de deudores SIN intento fallido de débito
										<li>Borrar lista de deudores con cuentas impagas pendientes de confirmar pago para que no vuelvan a generar este aviso
											<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
												<a href='#' data-placement="top" onmouseover='$(this).tooltip("show")'
													title='Si en una futura importación de datos hay deudores con intentos de débito fallido, este mensaje volverá a aparecer.' data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
											</div>
										<li>Ver listado de personas con historial de cuentas sin liquidez que tienen una operación pendiente con una cuenta secundaria.
										<li onclick="js_debtAut_genera_archivo_manage_divs ( 'inline', 'none', 'none' );"><span class='fa fa-arrow-left'></span> Volver al primer paso.</li>
									</ol>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button id="btn_formato_exportar_followed" name="btn_formato_exportar_followed" 
								class="btn btn-info" type="button"
								style="display:inline"
								onclick="return js_debtAut_genera_archivo_followed('file_form');">
							<span class='glyphicon glyphicon-export'></span>&nbsp;Exportar archivo
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal cargar archivo-->
		<div class="modal fade bs-example-modal-sm" id="modal_delete_ctas_inl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#dd4b39">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" style='color:white;'><span class="fa fa-eraser"></span> Educalinks informa</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12" style='text-align:center;'>
								¿Borrar lista de deudores con cuentas impagas pendientes de confirmar pago?<br>
								<br>
								De ahora en adelante, a los deudores de esta lista se les exportará información de la cuenta principal.
							</div>
						</div>
						<input type='hidden' id='hd_del_mes_codi' name='hd_del_mes_codi' value=''></input>
					</div>
					<div class="modal-footer" style='text-align:center;'>
						<button class="btn btn-danger" type="button" onclick="js_debtAuto_reset_ctas_inl_pdtes_confirm( )"><span class='fa fa-eraser'></span> Confirmar</button>
						<button class="btn btn-default" data-dismiss="modal"><li style="color:red;" class="fa fa-ban"></li> No borrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal cargar archivo-->
		<!-- /.Modal Exportar-->
        <div class="tab-content">
            <div id="home" class="tab-pane fade {active1}">
                <br/>
                <div id="div_formato" class="grid">
                    <div class="row">
                        <div class='col-sm-8'>
                            <div class='col-sm-8' style='display:inline;'>
                                <input type="hidden" name="event" id="evento" value="subir_archivo"></input>
                                
								<button id='btn_crear_formato_new' name='btn_crear_formato_new'
                                        class="btn bg-orange btn-flat fa fa-file" type="button"
                                        onclick="return nuevo_formato();"
                                        title='Nuevo formato'
										style='margin-top:2px;height:34px'>&nbsp;<i class='fa fa-plus'></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn bg-purple btn-flat dropdown-toggle glyphicon glyphicon-floppy-disk" data-toggle="dropdown"
                                            id='btn_formato_nuevo_guardar' name='btn_formato_nuevo_guardar' disabled='disabled'
                                            data-placement="top"
                                            title='Guardar cambios'
											style='margin-top:1px;height:34px'><span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" onclick="return create_file_guardar('file_form','{ruta_html_finan}/debitosAutomaticos/controller.php');">Guardar</a></li>
                                            <li><a href="#" onclick="$('#modal_formato').modal('show');">Guardar como...</a></li>
                                        </ul>
                                </div>
                                <button id='btn_crear_formato_reset' name='btn_crear_formato_reset'
                                        class="btn btn-danger btn-flat glyphicon glyphicon-erase" type="button"
                                        onclick="limpia_crear_formato();"
                                        title='Limpiar todo'
										style='margin-top:1px;height:34px'>
                                </button>
                                <button id='btn_formato_cargar' name='btn_formato_cargar' 
										class="btn btn-success btn-flat" type="button"
                                        onclick="$('#modal_cargarFormatoArchivo').modal('show');"
                                        data-placement="bottom"
                                        title='Abrir'
                                        onfocus='$(this).tooltip("show")'
                                        onmouseover='$(this).tooltip("show")'
										style='margin-top:2px;height:34px'>
                                    <span style='color:#FFDC89;' aria-hidden='true' class='glyphicon glyphicon-folder-open cursorlink'></span>
                                </button>
                                <button id='btn_formato_exportar' name='btn_formato_exportar' 
                                        class="btn btn-info btn-flat glyphicon glyphicon-export" type="button"
                                        onclick="return js_debtAut_genera_archivo();"
                                        data-placement="bottom"
                                        title='Exportar informaci&oacute;n'
                                        onfocus='$(this).tooltip("show")'
                                        onmouseover='$(this).tooltip("show")'
										style='margin-top:1px;height:34px'>
								</button>
                            </div>
                        </div>
                        <div class='col-sm-4' style='text-align:right;'>
                            <div id='div_file_status' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'></div><span id='span_info_formato' name='span_info_formato' style='font-size:x-small;'></span>
                            <input type='hidden' id='hd_id_cabecera' name='hd_id_cabecera' value=''></input>
                            <input type='hidden' id='hd_nombreformato' name='hd_nombreformato' value=''></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-12'>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                         <div class='col-sm-4'>
                         	<input type='hidden' id='hd_vista' name='hd_vista' value='V_DatosAlumnosDebitos_Detalle' />
                            <div id='grp_input_sec' class="input-group" data-placement="bottom"
                                    title='Dependiendo de los datos con los que quiera trabajar, se cargarán los campos.'
                                    onfocus='$(this).tooltip("show")'
                                    onmouseover='$(this).tooltip("show")'>
                                <span class="input-group-addon"><small>Ver</small></span>
                                <select id='cmb_vista' name='cmb_vista' class='form-control'>
                                	<option value='V_DatosAlumnosDebitos_Detalle' selected='selected'>Campos para débito bancario</option>
                                	<option value='V_DatosAlumnos_CobroVentanilla_Detalle'>Campos para cobro por ventanilla</option>
                                	<!--<option value=''>- Datos personales de Alumnos -</option>
                                	<option value=''>- Datos personales de Representantes -</option>-->
                                </select>
                                <span class="input-group-btn">
                                	<button class="btn btn-info" type="button" id='btn_choose_view' name='btn_choose_view'
                                    	onclick="js_debtAut_change_view();">Ir</button>
                                </span>
                            </div>
                        </div>
                        <div class='col-sm-3'>
                            <div id='grp_input_sec' class="input-group" data-placement="bottom"
                                    title='Dependiendo de los datos con los que quiera trabajar, se cargarán los campos.'
                                    onfocus='$(this).tooltip("show")'
                                    onmouseover='$(this).tooltip("show")'>
                                <span class="input-group-addon"><small>Campos</small></span>
                                <div id='div_cmb_campos' name='div_cmb_campos'>{combo_campos_file}</div>
                                <span class="input-group-btn">
                                	<button class="btn btn-primary" type="button" id='btn_add_field' name='btn_add_field'
                                    	onclick="add_field(document.getElementById('campos_add'),'div_campos','{ruta_html_finan}/debitosAutomaticos/controller.php',this);"><span class='fa fa-plus'></span>&nbsp;</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div id='grp_input_sec' class="input-group" data-placement="bottom"
                                    title='N&uacute;mero de columnas agregadas por el usuario en el formulario actual.'>
                                <span class="input-group-addon"><small>No. columnas</small></span>
                                <input type="number" style="font-size:small;" min="0" class="form-control" name="lbl_num_total_campos" id="lbl_num_total_campos" disabled='disabled' placeholder="0"></input>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4 col-md-3">
                            <div id='grp_input_sec' class="input-group" data-placement="bottom"
                                    title='Inicio secuencial. Ej.: 1.'
                                    onfocus='$(this).tooltip("show")'
                                    onmouseover='$(this).tooltip("show")'>
                                <span class="input-group-addon"><small>Secuencia</small></span>
                                <input type="number" style="font-size:small;" min="0" class="form-control input-sm" name="secuencia" id="secuencia" disabled='disabled'
                                	onkeypress="validate_save_button_followed(false);"
                                	placeholder="0"></input>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div id='grp_input_sec' class="input-group" data-placement="bottom"
                                    title='Ej. Si pone "4", el secuencial saldrá en la columna numero 4 del archivo, desplazando las demás columnas a partir de su ubicación.'
                                    onfocus='$(this).tooltip("show")'
                                    onmouseover='$(this).tooltip("show")'>
                                <span class="input-group-addon "><small>Ubicar en col. no.</small></span>
                                <input type="number" min="1" class="form-control input-sm" name="ubicacion" id="ubicacion" disabled='disabled' 
                                	onkeypress="validate_save_button_followed(false);"
                                	placeholder="1"></input>
                            </div>
                        </div>
                        <div class="checkbox checkbox-primary col-sm-3" style='text-align:right;'>
                            <input type="checkbox" name="secuencial " id="secuencial" onclick='return cambia_check_sec(this);'></input>
                            <label class='control-label' for='secuencial'>Agregar Campo Secuencial
                                <div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
                                    <a href='#' data-placement="top" onmouseover='$(this).tooltip("show")' title='Dar clic si desea que su formato incluya en una columna un n&uacute;mero id. secuencial.' data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
                                </div>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class='col-sm-12'>
                            <div id='div_consejo' name='div_consejo' style='font-size:x-small;'>Para poder guardar espacios en blanco, 
								escriba los caracteres 'nbsp' sin las comillas, en los campos 'Izq.' o 'Der.'.</div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div>
                                <ul id="div_campos" class='col-sm-12 ui-sortable'>
                                </ul>
                                <div id="div_campos_load_gif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade {active2}">
                <br/>
				<div class="grid">
                </div>
                <div id="procesar" name="procesar" class="grid">
					<input type='hidden' id='hd_caja_abierta' name='hd_caja_abierta' value='{hd_caja_abierta}'></input>
                    <div class="row">
                        <div class='col-sm-12'>
							<div class="alert alert-default" role="alert">
								<p><span class="fa fa-upload" aria-hidden="true"></span>
									Subida de archivo de respuesta del banco
									<hr style="padding:3px;margin:0px;">
									Cargue el archivo recibido del banco/instituci&oacute;n financiera. El archivo debe tener la siguiente informaci&oacute;n:
								<ul>
									<li><b><i>C&oacute;digo de deuda</i></b></li>
									<li><b><i>Valor de pago</i></b></li>
									<li><b><i>Estado del proceso en el banco</i></b></li>
								</ul>
								</p>
							</div>
                        </div>
                    </div>
					<div class="row">
                        <br>
                        <div class='col-sm-3' style='text-align:left;'>
                            <div id='div_fecha_debito' name='div_fecha_debito' class='input-group'>
                                <span id='span_fecha_debito' name='span_fecha_debito' class="input-group-addon"><small>Fecha de débito</small></span>
                                <input class="form-control" name="txt_fecha_debito" id="txt_fecha_debito"
                                        data-placement="top"
                                        title='Fecha en la que el banco procesó el débito.'
                                        onfocus='$(this).tooltip("show")'
                                        onmouseover='$(this).tooltip("show")'
                                        type="text" required="required">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <br>
                        <div class='col-sm-3'  style='text-align:left;'>
                            <div id='div_ig_filainicia' name='div_ig_filainicia' class='input-group'>
                                <span id='span_ig_filainicia' name='span_ig_filainicia' class="input-group-addon"><small>Cabecera inicia en fila</small></span>
                                <input class="form-control" name="filainicia" id="filainicia"
                                        data-placement="top"
                                        title='Escriba el no. de la fila donde se encuentra la cabecera de datos.'
                                        onfocus='$(this).tooltip("show")'
                                        onmouseover='$(this).tooltip("show")'
                                        type="number" min="0" step="1" max="999999999"
                                        placeholder="0" required="required">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
					<div class="row">
                        <div class='col-sm-3' style='text-align:right;'>
                            <br>
                        </div>
                    </div>
					<div class="row">
                        <div class='col-sm-3' style='text-align:left;'>
                            <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-12'>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-7'>
                            <div class='col-sm-7' style='display:inline;'>
                                    <button id='btn_formato_nuevo_generar' name='btn_formato_nuevo_generar' 
											class="btn btn-success btn-flat" type="button"
											onclick="js_debtAuto_subirarchivo();"
                                            data-placement="right"
                                            title='Importar archivo de respuesta del banco al sistema.'
                                            onfocus='$(this).tooltip("show")'
                                            onmouseover='$(this).tooltip("show")'><span class='fa fa-upload'></span> Importar archivo
                                    </button>
                            </div>
                        </div>
                        <div class='col-sm-5' style='text-align:right;'>
                            <div id='div_maint_file_status' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'></div><span id='span_info_formato' name='span_info_formato' style='font-size:x-small;'></span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu3" class="tab-pane fade {active3}">
                <br/>
                <div class="grid">
                    <div class="row">
                        <div class='col-sm-7'>
                            <div class='col-sm-7' style='display:inline;'>
                                    <button id='btn_maint_buscar_todos' name='btn_maint_buscar_todos' class="btn btn-link" type="button"
                                            onclick="return js_debtAuto_mantenimiento_buscar_todos('div_tbl_format','{ruta_html_finan}/debitosAutomaticos/controller.php');">
                                        <span class='glyphicon glyphicon-folder-close'></span>
                                    </button>
									 Cargar listado de formatos
                            </div>
                        </div>
                        <div class='col-sm-5' style='text-align:right;'>
                            <div id='div_maint_file_status' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'></div><span id='span_info_formato' name='span_info_formato' style='font-size:x-small;'></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-12'>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-12' id='div_tbl_format' name='div_tbl_format'>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu4" class="tab-pane fade {active4}">
                <br/>
				<table class='table table-hover table-striped'>
					<tr class='clickable-row' data-href='../../../finan/rep_debito/'>
						<td>Listado de alumnos con información de débito en el sistema</td>
						<td>
							<a href='../../../finan/rep_debito/' class="btn btn-link" type="button" style='color:green;'>
								<span class='fa fa-file-excel-o fa-2x'></span>
							</a>
						</td>
					</tr>
					<tr class='clickable-row' data-href='url://'>
						<td>Lista histórica de clientes sin liquidez</td>
						<td>
							<button class="btn btn-link" type="button"  style='color:green;'
									onclick="return js_debtAuto_listado_clientes_sin_liquidez('div_tbl_format','{ruta_html_finan}/debitosAutomaticos/controller.php');"
									data-placement="right">
								<span class='fa fa-file-excel-o fa-2x'></span>
							</button>
						</td>
					</tr>
					<tr class='clickable-row' data-href='url://'>
						<td></td>
						<td></td>
					</tr>
				</table>
                <div class="form-horizontal">
                    <div class='form-group'>
                        <div class='col-sm-7'>
							
                        </div>
						<div class='col-sm-5'>
							
						</div>
					</div>
					<div class='form-group'>
                        <div class='col-sm-7'>
							.
                        </div>
						<div class='col-sm-5'>
							
						</div>
					</div>
                </div>
            </div>
        </div>
    </form>
</div>