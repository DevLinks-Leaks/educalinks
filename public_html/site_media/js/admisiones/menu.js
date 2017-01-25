function js_verSolicitud_submit( estado, submenu )
{   var f = document.createElement('form');
	f.action = '../../admisiones/verSolicitud/';
	f.method = 'POST';
	//f.target = '_blank';
	var i = document.createElement( 'input' );
	i.type = 'hidden';
	i.name = 'soli_estado';
	i.id = 'soli_estado';
	i.value = estado;
	f.appendChild(i);
	var j = document.createElement( 'input' );
	j.type = 'hidden';
	j.name = 'submenu';
	j.id = 'submenu';
	j.value = submenu;
	f.appendChild(j);
	document.body.appendChild(f);
	f.submit();
}
/*
function js_verSolicitud_enviada( )
{   js_verSolicitud_submit('ENVIADA', '{menuSoli01}');
}
function js_verSolicitud_pdte_pago( )
{   js_verSolicitud_submit('PDTE. PAGO', '{menuSoli02}');
}
function js_verSolicitud_pagada( )
{   js_verSolicitud_submit('PAGADA', '{menuSoli03}' );
}
function js_verSolicitud_fecha_asignada( )
{   js_verSolicitud_submit('FECHA ASIGNADA', '{menuSoli04}' );
}
function js_verSolicitud_ex_aprobado( )
{   js_verSolicitud_submit('EX. APROBADO', '{menuSoli05}' );
}
function js_verSolicitud_aprobado_directores( )
{   js_verSolicitud_submit('APROBADO DIRECTORES', '{menuSoli06}' );
}
function js_verSolicitud_admitido( )
{   js_verSolicitud_submit('ADMITIDO', '{menuSoli07}' );
}
function js_verSolicitud_guardada( )
{   js_verSolicitud_submit('GUARDADA', '{menuSoli08}' );
}
function js_verSolicitud_no_admitido( )
{   js_verSolicitud_submit('NO ADMITIDO', '{menuSoli09}' );
}
function js_verSolicitud_mantenimiento( )
{   js_verSolicitud_submit('MANT', '{menuSoli10}' );
}*/