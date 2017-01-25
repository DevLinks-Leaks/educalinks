function js_funciones_auditoria_modulo_change(  )
{   document.getElementById( 'audi_inner_list' ).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('cmb_modulo', document.getElementById( 'cmb_modulo' ).value );
	
	if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open( "POST", "script_audit.php", true );
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.onreadystatechange=function()
	{   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
		{   document.getElementById( 'audi_inner_list' ).innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.send( data );
}