<div role="main">
<!-- =============================== -->
	<div class="box box-default">
		<div class="box-header">
		  <h3 class="box-title">
			<div class="input-group">
				<span class="input-group-addon" id="nombre_ficha_addon">Nombre:</span>
				<select class="form-control" id="fic_codigo" name="fic_codigo">
					<option value="">Seleccione...</option>
				</select>
			</div></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div id="resultado">
			<img src="<?php echo $diccionario['rutas_head']['ruta_html_medic']."/".$_SESSION['print_dir_logo_cliente']; ?>"  style="max-width:75px;max-height:100px;">
				<?php include ("../tabla_atenciones.php");?>
			</div>
		</div>
	</div>
</div><!-- /container -->