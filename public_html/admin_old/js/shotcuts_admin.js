/*Alumnos*/
shortcut.add("Alt+A", function() {
	$('#acc_alumnos').trigger('click');
});
shortcut.add("Alt+I", function() {
	if($('#acc_alumnos').attr('aria-expanded')=='true'){
		$('#acc_alum_insc')[0].click();
	}
},{'disable_in_input':true});
shortcut.add("Alt+L", function() {
	if($('#acc_alumnos').attr('aria-expanded')=='true'){
		$('#acc_alum_alum')[0].click();
	}
});
shortcut.add("Alt+P", function() {
	if($('#acc_alumnos').attr('aria-expanded')=='true'){
		$('#acc_alum_repr')[0].click();
	}
});
shortcut.add("Alt+Q", function() {
	if($('#acc_alumnos').attr('aria-expanded')=='true'){
		$('#acc_alum_bloq')[0].click();
	}
});
shortcut.add("Alt+B", function() {
	if($('#acc_alumnos').attr('aria-expanded')=='true'){
		$('#acc_alum_black')[0].click();
	}
});
/*Cursos*/
shortcut.add("Alt+C", function() {
	$('#acc_cursos').trigger('click');
});
shortcut.add("Alt+P", function() {
	if($('#acc_cursos').attr('aria-expanded')=='true'){
		$('#acc_cursos_para')[0].click();
	}
});
shortcut.add("Alt+N", function() {
	if($('#acc_cursos').attr('aria-expanded')=='true'){
		$('#acc_cursos_perm')[0].click();
	}
});
/*Administracion*/
shortcut.add("Alt+D", function() {
	$('#acc_admin').trigger('click');
});
shortcut.add("Alt+P", function() {
	if($('#acc_admin').attr('aria-expanded')=='true'){
		$('#acc_admin_peri')[0].click();
	}
});
shortcut.add("Alt+S", function() {
	if($('#acc_admin').attr('aria-expanded')=='true'){
		$('#acc_admin_para_sist')[0].click();
	}
});
/*Reportes*/
shortcut.add("Alt+R", function() {
	$('#acc_repo').trigger('click');
});
shortcut.add("Alt+G", function() {
	if($('#acc_repo').attr('aria-expanded')=='true'){
		$('#acc_repo_gene')[0].click();
	}
});
shortcut.add("Alt+S", function() {
	if($('#acc_repo').attr('aria-expanded')=='true'){
		$('#acc_repo_acta')[0].click();
	}
});
/*Mensajes*/
shortcut.add("Alt+M", function() {
	$('#acc_mens')[0].click();
});
function close_others(id){
	if($('#acc_alumnos').attr('aria-expanded')=='true' && id!='acc_alumnos')
		$('#acc_alumnos').trigger('click');
	if($('#acc_cursos').attr('aria-expanded')=='true' && id!='acc_cursos')
		$('#acc_cursos').trigger('click');
	if($('#acc_admin').attr('aria-expanded')=='true' && id!='acc_admin')
		$('#acc_admin').trigger('click');
	if($('#acc_repo').attr('aria-expanded')=='true' && id!='acc_repo')
		$('#acc_repo').trigger('click');
}