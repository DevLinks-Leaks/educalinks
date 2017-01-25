<?php
extract($_POST);
switch ($method)
{	case "upload_doc":
		save_file($asp_id, $docu_peri_id);
	break;
}
function save_file ($asp_id, $docu_peri_id)
{ 	if ($_FILES['file']['error'])
	{	$result = array("state"=>"error", "message"=>"Ocurrió un error al subir el archivo al servidor.");
	}
	else
	{	$target_path = "uploaded_docs/";
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$target_path = $target_path . "doc_".$asp_id."_".$docu_peri_id.".".$ext; 
		if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) 
		{ 	$result = array("state"=>"error", "message"=>"Ocurrió un error al subir el archivo al servidor");
		}
		else
		{	$result = save_db ($asp_id, $docu_peri_id, $ext);
		}
	}
	print json_encode($result);
}
function save_db ($asp_id, $docu_peri_id, $ext)
{ 	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	$params   = array($asp_id, $docu_peri_id, $ext);
	$sql	  = "{call admisiones_aspirante_documento_save(?,?,?)}";
	$stmt 	  = sqlsrv_query($conn, $sql, $params);  
	
	if ($stmt === false)
	{	$result= array ('state'=>'error', 'message'=>'Ocurrió un error al guardar en la base de datos.' );
	}
	else
	{	$result= array ('state'=>'success',	'result'=>'¡Carga del documento exitosa!' );
	}
	return $result;
}
?>