var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

$(document).ready(function(){
	// run test on initial page load
	checkSize();
	// run test on resize of the window
	$(window).resize(checkSize);
	
	var toggle = $('#ss_toggle');
	var menu = $('#ss_menu');
	var rot;
  
	$('#ss_toggle').on('click', function(ev) {
		rot = parseInt($(this).data('rot')) - 180;
		menu.css('transform', 'rotate(' + rot + 'deg)');
		menu.css('webkitTransform', 'rotate(' + rot + 'deg)');
		if ((rot / 180) % 2 == 0) {
		  //Moving in
		  toggle.parent().addClass('ss_active');
		  toggle.addClass('close');
		} else {
		  //Moving Out
		  toggle.parent().removeClass('ss_active');
		  toggle.removeClass('close');
		}
		$(this).data('rot', rot);
	});

	menu.on('transitionend webkitTransitionEnd oTransitionEnd', function() {
		if ((rot / 180) % 2 == 0) {
		  $('#ss_menu div i').addClass('ss_animate');
		} else {
		  $('#ss_menu div i').removeClass('ss_animate');
		}
	});
    actualiza_badge_sms();
	if(document.getElementById( 'hd_chan_flag' ))
	{   if( document.getElementById( 'hd_chan_flag' ).value > 0 )
		{   $('#modal_changelog').modal('show');
			$('#modal_changelog').on('shown.bs.modal',function(){
				$('.carousel').slick({
					dots: true,
					fade: true,
					speed: 500,
					autoplay: true,
					adaptiveHeight: true,
					prevArrow:'<span style="left: -15px;width: 20px;height: 18px;transform: translate(0, -50%);cursor: pointer;position: absolute;top: 50%;" class="fa fa-chevron-left fa-2x"></span>',
					nextArrow:'<span style="right: -15px;width: 20px;height: 18px;transform: translate(0, -50%);cursor: pointer;position: absolute;top: 50%;" class="fa fa-chevron-right fa-2x"></span>'
				});
			});
		}
	}
});
var spanish="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
var var_actualiza_badge = setInterval(function () {"use strict"; actualiza_badge_sms();}, 120000);
var gest=0;
function checkSize()
{
	if (window.matchMedia('(max-width:960px)').matches)
		$('body').addClass("fixed");

	if (window.matchMedia('(min-width:961px)').matches)
		$('body').removeClass("fixed");
}
function set_skin(logo, cls)
{   var data = new FormData();
    data.append( 'event', 'change_logo');
    data.append( 'logo', logo );    
    data.append( 'skin', cls );    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById('a_nav_main').innerHTML = xhr.responseText;
            document.getElementById('hd_ui_skin').value = cls;
        } 
    }
    xhr.send(data);
}
function go_home(url){
    "use strict";
    var data = new FormData();
    data.append('event', 'index');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.send(data);
}
function js_general_change_periodo(url,peri_codi)
{   var data = new FormData();
    var select_periodo = document.getElementById('cmb_sidebar_periodo');
    $("button[type=button]").attr("disabled", "disabled");
    data.append('event', 'change_periodo');
    data.append('peri_codi', peri_codi );
    data.append('peri_deta', $( '#btn_header_peri_' + peri_codi ).data("deta") );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   var n = xhr.responseText.length;
            if (n > 0)
            {   valida_tipo_growl(xhr.responseText);
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
            }
            //localStorage.setItem("Status",data.OperationStatus)
            //location.reload(); 
            setTimeout(function(){location.reload();},1000);
        } 
    };
    xhr.send(data);
}
function js_general_change_periodo_2( peri_codi, peri_deta, url )
{   var data = new FormData();
    var select_periodo =document.getElementById( 'periodo_select' );
    data.append('event', 'change_periodo' );
    data.append('peri_codi', peri_codi );
    data.append('peri_deta', peri_deta );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById( 'div_periodo' ).style.display = 'none';
            document.getElementById( 'div_opciones_principales' ).style.display = 'inline';
        } 
    };
    xhr.send(data);
}
function leer_mensaje(url, mens_codi, box, div)
{   var data = new FormData();
    data.append('event', 'leer');
    data.append('mens_codi', mens_codi);
    data.append('box', box);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function elimina_mensaje( mens_codi )
{   document.getElementById('hd_del_mes_codi').value = mens_codi;
	$('#modal_del_sms').modal("show");
}
function elimina_mensaje_followed( )
{   url='../../../admin/mensajes_nuevo_script_envio.php';
	var data = new FormData();
	data.append('mens_codi', document.getElementById('hd_del_mes_codi').value );
	data.append('op', document.getElementById('hd_op').value );
	data.append('DO', 'DEL' );
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onload = function ()
	{   //console.log(this.responseText);
	};
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   $.growl.notice({ title: "Educalinks informa ",message: "Mensaje eliminado"});
			$('.modal').modal('hide');
			mensaje_view( document.getElementById('hd_op').value );
		}
	};
	xhr.send(data);
}

function validar_envio()
{   tipo = document.getElementById('mens_tipo').value;
    cc = document.getElementById('mens_cc_usua').value;
    
    if ( document.getElementById('mens_titu').value === '' )
    {   alert('Debe existir un Titulo en el mensaje');
        return false;
    }
    
    mm=0;
    i=1;
    
    while (i<=cc)
    {   if (document.getElementById('ch_'+ tipo + '_' + i) != null)
        {   if (document.getElementById('ch_'+ tipo + '_' + i).checked)
            {   mm+=1;             
            }
        } 
        i+=1;
    }
    if (mm==0)
    {    alert('No hay Usuarios seleccionado');
        return false;
    }
 
    if (CKEDITOR.instances.mens_deta.getData()==''){
        if (confirm("No hay texto en el detalle del mensaje, ¿desea enviar de todas formas?")==false)  {
            $('#responder_mensaje').button('reset');
			return false;
        }
    }
    return true;   
}
function validar_envio_respuesta()
{   if (document.getElementById('mens_titu').value=='')
    {   alert('Debe existir un Titulo en el mensaje');
        return false;
    }
    if (CKEDITOR.instances.mens_deta.getData()=='')
    {   if (confirm("No hay texto en el detalle del mensaje, ¿desea enviar de todas formas?")==false)  {
            $('#responder_mensaje').button('reset');
			return false;
        }
    }
    return true;
}
function envio_mensaje_resp(mens_para,mens_para_tipo)
{   $('#responder_mensaje').button('loading');
	if (validar_envio_respuesta())
	{   url='../../../admin/mensajes_nuevo_script_envio.php';
	
		var data = new FormData();
		data.append('mens_de', document.getElementById('mens_de').value );
		data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
		data.append('mens_para', mens_para);
		data.append('mens_para_tipo', mens_para_tipo);
		data.append('mens_titu', document.getElementById('mens_titu').value);
		data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
		data.append('DO','RESP');
	
		var xhr_mensaje = new XMLHttpRequest();
		xhr_mensaje.open('POST', url , true);
		//xhr_mensaje.setRequestHeader("Content-Type", "application/json");
		xhr_mensaje.onload = function () {
			// do something to response
			console.log(this.responseText);
		};
		xhr_mensaje.onreadystatechange=function(){
			if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200)
			{   obj = JSON.parse(xhr_mensaje.responseText);
				if (obj.tipo == "error")
				{	$.growl.error({ title: "Error: ",message: obj.mensaje });
					$('#responder_mensaje').button('reset');
				}
				else //if(obj.tipo == "warning")
				{	
					var repr="";
					obj.forEach(function(entry){
						if (entry.tipo=="warning") {
							repr=repr+"</br>"+entry.repr+", ";
						}
					});
					if(repr=="")
					{   $.growl.notice({ title: "Información: ",message: "Mensajes enviados con éxito" });
						$('#responder_mensaje').button('reset');
						$('#mens_responder').modal('hide');	
					}
					else
					{   $.growl.warning({ title: "Advertencia: "
							,duration: 5600
							,message: "Mail no enviado al representante: <b>"+repr+"</b></br>verificiar formato de e-mail." });
						$('#responder_mensaje').button('reset');
						$('#mens_responder').modal('hide');
					}
				}
						 
			}
		};
		xhr_mensaje.send(data);
	}
}
function get_box(box, url, div)
{   var data = new FormData();
    data.append('event', 'get_box');
    data.append('box', box);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function get_badge_class(num)
{   //bg-light-blue,yellow,red,green
    var bg_class = '';
    if (num === 0)
        bg_class = 'label pull-right';
    if((num>0) && (num <=10))
        bg_class = 'label pull-right bg-light-blue';
    if((num>10) && (num <=30))
        bg_class = 'label pull-right bg-green';
    if((num>30) && (num <=100))
        bg_class = 'label pull-right bg-yellow';
    if(num>100)
        bg_class = 'label pull-right bg-red';
    return bg_class;
}
function get_menu_span_badge_class(num)
{   //bg-light-blue,yellow,red,green
    var bg_class = '';
    if (num === 0)
        bg_class = 'label';
    if((num>0) && (num <=10))
        bg_class = 'label label-info';
    if((num>10) && (num <=30))
        bg_class = 'label label-success';
    if((num>30) && (num <=100))
        bg_class = 'label label-warning';
    if(num>100)
        bg_class = 'label label-danger';
    return bg_class;
}
function get_progress_bar_badge_class(num)
{   //bg-light-blue,yellow,red,green
    var bg_class = '';
    if (num === 0)
        bg_class = 'progress-bar';
    if((num>0) && (num <=10))
        bg_class = 'progress-bar progress-bar-aqua';
    if((num>10) && (num <=30))
        bg_class = 'progress-bar progress-bar-green';
    if((num>30) && (num <=100))
        bg_class = 'progress-bar progress-bar-yellow';
    if(num>100)
        bg_class = 'progress-bar progress-bar-red';
    return bg_class;
}
function js_general_mensajes_read_from_navbar( div, url, data )
{
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if ( window.XMLHttpRequest )
		xmlhttp=new XMLHttpRequest();	// code for IE7+, Firefox, Chrome, Opera, Safari
	else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
	
	xmlhttp.onreadystatechange=function()
	{   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
		{   document.getElementById(div).innerHTML=xmlhttp.responseText;
			actualiza_badge_sms();
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_mens_responder(div,url,mens_codi){
	//document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data = new FormData();
	data.append('mens_codi', mens_codi );
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;	
			CKEDITOR.replace( 'mens_deta' );
		}
	}
	xmlhttp.open("POST", '../../../admin/' + url ,true);
	xmlhttp.send(data);	
}
function actualiza_badge_sms()
{   "use strict";
    var url='../../../modulos/common/mensajeria/controller.php';
    var data = new FormData();
    data.append('event', 'view_badge_sms');
    var xhrbadge_sms = new XMLHttpRequest();
    xhrbadge_sms.open('POST', url , true);
    xhrbadge_sms.onreadystatechange=function(){
        if (xhrbadge_sms.readyState === 4 && xhrbadge_sms.status === 200){
            if(xhrbadge_sms.responseText === '0'){
                if( document.getElementById('badge_sms_header1') )
                    document.getElementById('badge_sms_header1').innerHTML= "";
                if( document.getElementById('badge_sms_header2') )
                    document.getElementById('badge_sms_header2').innerHTML= "No tienes mensajes nuevos";
                $('#span_badge_sms_header1').removeClass().addClass(get_menu_span_badge_class(xhrbadge_sms.responseText));
            }else
            {   if(document.getElementById('badge_sms_header1'))
                {   if(document.getElementById('badge_sms_header1').innerHTML !== xhrbadge_sms.responseText)
                    {   document.getElementById('badge_sms_header1').innerHTML=xhrbadge_sms.responseText;
                        document.getElementById('badge_sms_header2').innerHTML="Tienes " + xhrbadge_sms.responseText + " mensaje(s)";
                        //$('#span_badge_sms_header1').removeClass().addClass(get_menu_span_badge_class(xhrbadge_sms.responseText));
						$('#span_badge_sms_header1').removeClass().addClass( 'label label-success' );
						
                    }
                }
            }
			
            //document.getElementById('badge_gest_fac').innerHTML=gest;
            //desbloquear si se hace sms en MENU//document.getElementById('badge_sms').innerHTML='<span class="' + get_badge_class(xhrbadge_sms.responseText) + '">' + xhrbadge_sms.responseText + '</span>';
            actualiza_badge_sms_detail();
        }
    };
    xhrbadge_sms.send(data);
}
function actualiza_badge_sms_detail()
{   "use strict";
    var url=document.getElementById('ruta_html_common').value+'/mensajeria/controller.php';
    var data = new FormData();
    data.append('event', 'view_badge_detail');
    var xhrbadge_sms = new XMLHttpRequest();
    xhrbadge_sms.open('POST', url , true);
    xhrbadge_sms.onreadystatechange=function(){
        if (xhrbadge_sms.readyState === 4 && xhrbadge_sms.status === 200){
            if( document.getElementById('badge_sms_detail') )
                document.getElementById('badge_sms_detail').innerHTML = xhrbadge_sms.responseText;
        }
    };
    xhrbadge_sms.send(data);
}
function toggleFullScreen_at_startup(  ) {
    var toggle = document.getElementById('hd_toggle_fullscreen').value;
    if ( toggle == 'true' )
    {   if (document.documentElement.requestFullScreen)
        {   document.documentElement.requestFullScreen();  
        }
        else if (document.documentElement.mozRequestFullScreen)
        {   document.documentElement.mozRequestFullScreen();  
        }
        else if (document.documentElement.webkitRequestFullScreen)
        {   document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
        }
    }
    if ( toggle == 'false' )
    {   if (document.cancelFullScreen)
        {   document.cancelFullScreen();  
        }
        else if (document.mozCancelFullScreen)
        {   document.mozCancelFullScreen();  
        }
        else if (document.webkitCancelFullScreen)
        {   document.webkitCancelFullScreen();  
        }
    }
}
function toggleFullScreen(  ) {
    var toggle = 'false';
    if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen))
    {   if (document.documentElement.requestFullScreen)
        {   document.documentElement.requestFullScreen();  
        }
        else if (document.documentElement.mozRequestFullScreen)
        {   document.documentElement.mozRequestFullScreen();  
        }
        else if (document.documentElement.webkitRequestFullScreen)
        {   document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
        } 
        toggle = 'true';
    }
    else 
    {   if (document.cancelFullScreen)
        {   document.cancelFullScreen();  
        }
        else if (document.mozCancelFullScreen)
        {   document.mozCancelFullScreen();  
        }
        else if (document.webkitCancelFullScreen)
        {   document.webkitCancelFullScreen();  
        }
        toggle = 'false';
    }
    var data = new FormData();
    data.append('event', 'toggle_fullscreen');
    data.append('toggle', toggle);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
            console.log(toggle);console.log(document.getElementById('hd_toggle_fullscreen').value)
            document.getElementById('hd_toggle_fullscreen').value = xhr.responseText;console.log(document.getElementById('hd_toggle_fullscreen').value)
        }
    };
    xhr.send(data);
}
function aumenta_porc(porc){
    "use strict";
    var div='prog_bar_deudas';
    var val_now= parseInt(document.getElementById(div).getAttribute('aria-valuenow'))+porc;
    if(val_now<=100){
        document.getElementById(div).setAttribute('aria-valuenow',val_now);
        document.getElementById(div).style.width=String(val_now)+'%';
        if(val_now<100){
            document.getElementById(div).innerHTML=String(val_now)+'%';
            document.getElementById('prog_bar_deudas').setAttribute('class','progress-bar progress-bar-striped active');
        }else{
            document.getElementById(div).innerHTML='Completado';
            document.getElementById('prog_bar_deudas').setAttribute('class','progress-bar progress-bar-striped');
        }
    }
}
function validaNumerosEnteros(e, field){
    "use strict";
    var nuevoValor = field.value+String.fromCharCode(e.which);
    nuevoValor = parseInt(nuevoValor);
    if(isNaN(nuevoValor)){
      return false;
    }else{
      return true;
    }
}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function validaNumeros(e, field){
    "use strict";
    var key = e.keyCode ? e.keyCode : e.which;
    if (key == 8){return true;}
    if (key > 47 && key < 58) {
      if (field.value == ""){return true;}
      var regexp1 = /.[0-9]{5}$/;
      return !(regexp1.test(field.value));
    }
    if (key == 46) {
      if (field.value == ""){return false;}
      var regexp2 = /^[0-9]+$/;
      return regexp2.test(field.value);
    }
    return false;
}

function permite(elEvento, permitidos)
{   "use strict";
    // Variables que definen los caracteres permitidos
    var numeros = "0123456789";
    var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    var numeros_caracteres = numeros + caracteres;
    var teclas_especiales = [8, 37, 39, 46];
    // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
    // Seleccionar los caracteres a partir del parámetro de la función
    switch(permitidos)
    {    case 'num':
            permitidos = numeros;
            break;
        case 'car':
            permitidos = caracteres;
            break;
        case 'num_car':
            permitidos = numeros_caracteres;
            break;
    }
    // Obtener la tecla pulsadas
    var evento = elEvento || window.event;
    var codigoCaracter = evento.charCode || evento.keyCode;
    var caracter = String.fromCharCode(codigoCaracter);

    // Comprobar si la tecla pulsada es alguna de las teclas especiales
    // (teclas de borrado y flechas horizontales)
    var tecla_especial = false;
    for(var i in teclas_especiales)
    {   if(codigoCaracter == teclas_especiales[i])
        {   tecla_especial = true;
            break;
        }
    }
    // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
    // o si es una tecla especial
    return permitidos.indexOf(caracter) != -1 || tecla_especial;
}
function activa_mascara(field){
    "use strict";
    $(function() {$('#'+field).maskMoney({thousands:'', decimal:'.', allowZero:false});});
}
function obtener_fecha_subfuncion(cuanto)
{   "use strict";
    var today = new Date();
    var dd = today.getDate() + cuanto;
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd;
    }
    if(mm<10){
        mm='0'+mm;
    }
    today = dd+'/'+mm+'/'+yyyy;
    return today;
}
function obtener_fecha(cuando)
{   "use strict";
    if(cuando=='ayer')
    {
        return obtener_fecha_subfuncion(-1);
    }
    if(cuando=='hoy')
    {
        return obtener_fecha_subfuncion(0);
    }
    if(cuando=='mañana')
    {
        return obtener_fecha_subfuncion(1);
    }
}
function check_fecha(){
    "use strict";
    var checked=document.getElementById('chk_fecha').checked;
    if(!checked)
    {
        document.getElementById('txt_fecha_ini').disabled = true;
        document.getElementById('txt_fecha_ini').value = '';
        document.getElementById('txt_fecha_fin').disabled = true;
        document.getElementById('txt_fecha_fin').value = '';
    }else
    {
        document.getElementById('txt_fecha_ini').disabled = false;
        document.getElementById('txt_fecha_fin').disabled = false;
        document.getElementById('txt_fecha_ini').value = obtener_fecha('ayer');
        document.getElementById('txt_fecha_fin').value = obtener_fecha('hoy');
    }
}
function spacebar_retorna_cero(e, field){
    "use strict";
    var key = e.keyCode ? e.keyCode : e.which;
    if (e.keyCode == 32) {
        field.value=parseFloat(field.value*10).toFixed(2);
        if (field.value === ""){ return true;}
        var regexp = /.[0-9]{5}$/;
        return !(regexp.test(field.value));
    }else
    {
        return validaNumeros(e, field);
    }
}
function valida_tipo_growl(str)
{   "use strict";
    var str1 =  str;
    var wordsToFind = ["¡exito!", "*¡exito!*"];
    if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   str = str.replace("¡Exito!", "");
        $.growl.notice({ title: "Educalinks informa", message: str});
    }
    else
    {   wordsToFind = ["¡error!", "*¡error!*"];
        if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
        {   str = str.replace("¡Error!", "");
            $.growl.error({ title: "Educalinks informa", message: str});
        }
        else
        {   wordsToFind = ["¡advertencia!", "*¡advertencia!*"];
            if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
            {   str = str.replace("¡Advertencia!", "");
                $.growl.warning({ title: "Educalinks informa", message: str});
            }
            else
            {   $.growl({ title: "Educalinks informa", message: str});
            }
        }
    }
}
function js_general_resultado_sql(str)
{   "use strict";
    var str1 =  str;
    var wordsToFind = ["¡exito!", "*¡exito!*"];
    if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   str = str.replace("¡Exito!", "");
        return 'exito';
    }
    else
    {   wordsToFind = ["¡error!", "*¡error!*"];
        if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
        {   str = str.replace("¡Error!", "");
            return 'error';
        }
        else
        {   wordsToFind = ["¡advertencia!", "*¡advertencia!*"];
            if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
            {   str = str.replace("¡Advertencia!", "");
                return 'advertencia';
            }
            else
            {   return 'nada';
            }
        }
    }
}
function js_general_compare_dates( fecha, fecha2 ) /* recibe el formato: dd/mm/aaaa y lo transforma en mm/dd/aaaa. */
{   
    fecha = fecha.substring(3, 5) + '/' + fecha.substring(0, 2) + '/' + fecha.substring(6, 10);
    fecha2 = fecha2.substring(3, 5) + '/' + fecha2.substring(0, 2) + '/' + fecha2.substring(6, 10);
    
    var primera = Date.parse(fecha);
    var segunda = Date.parse(fecha2);
     
    if ( primera == segunda ) {
        return 'OK';
    } else if ( primera > segunda ) {
        return 'NO';
    } else {
        return 'OK';
    }
}
function cerrar_changelog(){
    if($('#chk_mostrar').is(':checked')==true){
        registrar_changelog();
        $('#modal_changelog').modal('toggle');
    }else
        $('#modal_changelog').modal('toggle');
}
function registrar_changelog(){
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  var jsonC = [];
  $('.changelog_div').each(function(){ 
    jsonC.push({
        chan_codi: $(this).attr('id')
    });
  });
  var data = new FormData();
  data.append('opc', 'validate_changelog_show');
  data.append('jsonC', JSON.stringify(jsonC));
  xmlhttp.onreadystatechange=function()
  {
      if (xmlhttp.readyState==4 && xmlhttp.status==200){
          var json = JSON.parse(xmlhttp.responseText);
          
      }
  };
  xmlhttp.open("POST",'script_general.php',true);
  xmlhttp.send(data);
}
/*SHORTCUTS
shortcut.add("Shift+Space+M", function() {
	$('#modal_quick_access').modal("show");
});
shortcut.add("Shift+Space+S", function() {
	$('.control-sidebar').collapse()
});*/