<?php
include ('../framework/dbconf.php');
extract($_GET);
$params   = array($peri_codi,$asp_id);
$sql	  = "{call admisiones_documentos_periodos_show(?,?)}";
$stmt 	  = sqlsrv_query($conn, $sql, $params);  
?>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="30%">Documento</th>
			<th width="40%">Observación</th>
			<th width="10%">Buscar archivo</th>
			<th width="10%"></th>
			<th width="10%">Estado</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while ($row = sqlsrv_fetch_array($stmt)){
	?>
		<tr>
			<td><?= $row["nombre"] ?></td>
			<td><?= $row["descripcion"] ?></td>
			<td><input id="doc_<?= $asp_id ?>_<?= $row['docu_peri_codi'] ?>" type="file" /></td>
			<td><button id="btn_subir_<?= $row['docu_peri_codi'] ?>" onclick="upload_doc(<?= $asp_id ?>,<?= $row['docu_peri_codi'] ?>, <?= $peri_codi ?>);" title="Haga click para subir el archivo" class="btn btn-primary"><span id="span_<?= $row['docu_peri_codi'] ?>" class="fa fa-upload"></span> Subir</button></td>
			<td><?= ($row["extension"]!=NULL?"<a title='Haga click para descargar' target='_blank' class='label-success' href='uploaded_docs/doc_".$asp_id."_".$row["docu_peri_codi"].".".$row["extension"]."'><span class='fa fa-download'></span> Descargar</a>":"<span class='label-warning'>NO SUBIDO</span>") ?></td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>