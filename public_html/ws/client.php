<?php	
	require_once('../includes/common/nusoap/lib/nusoap.php'); 
	
	// header('Content-Type: application/json');
	//This is your webservice server WSDL URL address
	//header('Content-Type: text/html;  text/xml'); 
	$wsdl = "http://desarrollo.educalinks.com.ec/ws/server_ws.php?wsdl";

	//create client object
	$client = new nusoap_client($wsdl, 'wsdl');

	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Constructor error</h2>' . $err;
		// At this point, you know the call that follows will fail
	        exit();
	}

	//calling our first simple entry point
	$result1=$client->call('hello', array('username'=>'achmad'));
	print_r($result1); 

	//call second function which return complex type
	$result2 = $client->call('login', array('username'=>'john', 'password'=>'doe') );
	//$result2 would be an array/struct
	print_r(json_encode($result2));

	$result3 = $client->call('listarClientes', array('clie_codi'=>1) );
	//$result2 would be an array/struct
	if ($client->fault) {
		echo '<h2>Fault</h2><pre>';
		print_r($result3);
		echo '</pre>';
	} else {
		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			echo '<h2>Error</h2><pre>' . $err . '</pre>';		
		} else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print_r($result3);
		echo '</pre>';
		}
	}
	

?>