<?php
	// because we don't have a WSDL file
	$options = array("location" => "http://desarrollo.educalinks.com.ec/ws/server_ws.php?wsdl",
				"uri" => "http://desarrollo.educalinks.com.ec");
	$client = new SoapClient('http://desarrollo.educalinks.com.ec/ws/server_ws.php?wsdl');

	$params = array(
	  "clie_codi" => 1
	);
	//$response = $client->listarClientes($params);
	
	var_dump($client->getFunctions());
?>