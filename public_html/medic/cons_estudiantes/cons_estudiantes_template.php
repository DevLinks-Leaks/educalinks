<!DOCTYPE html>
<html lang="es">
    <?php include("../template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include("../template/navbar.php");?>
			<?php $Menu=101; include("../template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Atención médica estudiantil
						<small>Ingreso de nuevo registro</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Atención médica estudiantil</li>
					</ol>
				</section>
				<section class="content" id="formulario">
					<?php include("cons_estudiantes_main.php");?>
				</section>
				<?php include("../template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("../template/rutas.php");?>
			</form>
			<?php include("../template/footer.php");?>
		</div>
		<!-- =============================== -->
		        
		<?php include("../template/scripts.php");?>
		<script src="../../Clases/JS/Estudiantes.js"></script>
		<script src="../js/med_atenciones.js"></script>
		<script type="text/javascript">  
			var alum_codigo_old=0;
			var alum_codigo_new=0;
			$(document).ready(function(){  
				carga_modal_busq_alum_curs_para_codi('modal_busquedabody','../../../Clases/Ajax/Estudiantes.php','modal_busqueda','alum_codi','alum_nombre','alum_curso','curs_para_codi','alum_telf','alum_domi');
				$('#table_tratamientos').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				$('#table_atenciones').DataTable({
					dom: 'Bfrtip',
					buttons: [ 
						{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
						{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
						{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
						{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
						{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
						],
					select: true,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
				});
				mueveReloj();
			});
			$('#modal_busqueda').on('shown.bs.modal', function () {
				var table = $('#table_cons_estudiantes').DataTable();
				table.columns.adjust().draw();
				alum_codigo_old=document.getElementById('alum_codi').value
			});
			$('#modal_busqueda').on('hidden.bs.modal', function () {           
				alum_codigo_new=document.getElementById('alum_codi').value
				if(alum_codigo_new != alum_codigo_old){
					carga_materias('div_select_materias','../ajax_script/atenciones.php',alum_codigo_new,document.getElementById('curs_para_codi').value);
					$("#prof_codi").val("");
					$("#prof_nomb").val("");
					carga_alergias('alum_alergias_div','../ajax_script/atenciones.php',alum_codigo_new);
					document.getElementById("client_options").innerHTML = "<button type='button'  class='btn btn-sm btn-warning' " +
						"onclick='carga_ficha_medica(\"" + alum_codigo_new + "\","+'"modal_ficha_medica_body"'+",\"../ajax_script/Ficha_medica.php\")' aria-hidden='true' data-toggle='modal' data-target='#modal_ficha_medica'  "+
						"id='" + alum_codigo_new + "_verFichaMedica' onmouseover='$(this).tooltip("+'"show"'+")' " +
						" title='Ver fichas médicas' data-placement='left'><i class='fa fa-clipboard'></i>&nbsp;Fichas médicas</button>";
				}
			});
			
			var $input = $('#motivo');
			$.get('../enfermedades_json.php', function(data){
				$input.typeahead({
					source:JSON.parse(data),
					items:'all',
					autoSelect: true,
					displayText: function(item){ return item.name;}
				});
			});        
			$input.change(function() {
				var current = $input.typeahead("getActive");
				if (current) {
					// Some item from your model is active!
					if (current.name == $input.val()) {
						// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
						$("#motivo_id").val(current.id);
					} else {
						// This means it is only a partial match, you can either add a new item 
						// or take the active if you don't want new items
						$("#motivo_id").val("0");
					}
				} else {
					// Nothing is active so it is a new value (or maybe empty value)
					$("#motivo_id").val("0");
				}
			});
			$('#btn_guardar').on('click', function () {
				$(this).prop('disabled', true);
				agrega_atencion('atenciones_div','../ajax_script/atenciones.php','btn_guardar');
			});
			$('#btn_agregar').on('click', function () {
				$(this).button('loading');
				agrega_tratamiento('medicamentos','cant_med','stock_med','table_tratamientos','btn_agregar');
			});
			$('#cant_med').keyup(function(){
				this.value = (this.value + '').replace(/[^0-9]/g, '');
				var text = $(this).val();
				var textLength = text.length;
				if (parseInt(text) > parseInt($("#stock_med").val()) || parseInt(text)<=0){
					$(this).val(text.substring(0, (textLength)-1));
				}
			});
		</script>
	</body>
</html>