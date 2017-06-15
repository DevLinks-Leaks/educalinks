<style >
	#sortable { margin: 0; padding: 0; width: 100%; }
	#div_campos li { cursor:move; }
	#div_campos li.fixed { cursor:default; color:#959595; opacity:0.5;}
	a.hover {
		text-decoration: none;
	}

	a.hover:hover {
		text-decoration: underline;
	}
</style>
<br>
<button type="button" class="btn btn-warning" onclick="js_debitosAutomaticos_genera_file_ajax();"><li class="fa fa-chevron-left"></li> Repetir proceso desde el inicio</button>
<br>
<br>
<div id='facturasGeneradas' class='form-group'>
	<div class="alert alert-success" role="alert">
		<h4><i class="icon fa fa-check"></i> Subida de archivo con valores de pagos completado</h4>
		<ul>
			<li><strong>{pagado}</strong> pagos fueron registrados correctamente. <a href='../../../finan/pagos/'>Ir a pagos realizados</a> <span class='fa fa-list'></span>.</li>
			<li><strong>{saldoafavor}</strong> pagos ya estaban saldados. Los valores fueron registrados como <a href='../../../finan/saldoaFavor/'>saldo a favor</a> <span class='fa fa-balance-scale'></span>.</li>
		</ul>
   </div>
</div>