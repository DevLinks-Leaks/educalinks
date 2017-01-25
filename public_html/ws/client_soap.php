<?php
// We must define the location of the service in the client
// because we don't have a WSDL file
$options = array("location" => "http://desarrollo.educalinks.com.ec/ws/server_ws_rest.php",
				"uri" => "http://desarrollo.educalinks.com.ec");
				
try{

// Provides a client to read from the service
// It either receives a WSDL file, or null and the options
$client = new SoapClient(null, $options);

// Call the function in the Students class
$clients = $client->getClients(1);

echo $clients;

}

catch(SoapFault $ex){

var_dump($ex);

}

?>