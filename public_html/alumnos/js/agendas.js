// JavaScript Document

function agen_view(div,agen_codi)
{
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append('agen_codi', agen_codi);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'agenda_modal.php' , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
    {   document.getElementById(div).innerHTML = xhr.responseText;
        $('#agenda_modal').modal();
    }
    };
    xhr.send(data);


}