<?php
	
	function listarClientes($clie_codi){
		

		//$clientes->getClientInfo($clie_codi);
		
		require_once("Classes/conf/dbconf_certus.php");

		$params = array($clie_codi);
		$sql = '{call clie_info (?)}';
		$stmt = sqlsrv_query($conn, $sql, $params); 

		while($row= sqlsrv_fetch_array($stmt)){
			$array_res = array('client_nomb'=>$row['clie_base'],'client_codi'=>$row['clie_base']);
		}

		sqlsrv_close($conn);

		return json_encode(array('client_nomb'=>'AMBIENTE DESARROLLO','client_codi'=>'AMBIENTE DESARROLLO'));
		//$array_clientes = array ("result"=>$json_clientes);
		//$json_clientes[] = array('client_nomb'=>'asd','client_codi'=>'123');
		//$json_clientes[] = array('client_nomb'=>'asda','client_codi'=>count($clientes->rows));
		//return array('client_nomb'=>$clientes->get_dbname(),'client_codi'=>$clientes->get_dbname());
		
		// $clientes = new Clientes();
		// $clientes->getClientInfo($clie_codi);
		// $json_clientes = array();
		// foreach($clientes->rows as $cliente){
		// 	$json_clientes[] = array('client_nomb'=>$cliente['clie_nomb'],'client_codi'=>$cliente['clie_nomb']);
		// }
		//$array_clientes = array ("result"=>$json_clientes);
		//$json_clientes[] = array('client_nomb'=>'asd','client_codi'=>'123');
		//$json_clientes[] = array('client_nomb'=>'asda','client_codi'=>count($clientes->rows));
		//return json_encode($json_clientes[0]);
	}

	require_once('../includes/common/nusoap/lib/nusoap.php'); 
	//include('Classes/Clientes.php');
	error_reporting(E_ALL);
	// header('Content-Type: application/json');
	header('Content-Type:  text/xml'); 
	//http://desarrollo.educalinks.com.ec/ws/server_ws.php?wsdl
	$server = new nusoap_server;
	$server->configureWSDL('LinksWS');
	//$server->soap_defencoding = 'utf-8';
	$namespace = 'urn:server';
	//$server->wsdl->schemaTargetNamespace = 'urn:server';
	$server ->wsdl->schemaTargetNamespace = $namespace;
	//$server->soap_encoding = 'UTF-8';
	//SOAP complex type return type (an array/struct)
	$server->wsdl->addComplexType(
	    'Client',
	    'complexType',
	    'struct',
	    'all',
	    '',
	    array(
	        //'host_client' => array('name' => 'host_client', 'type' => 'xsd:string'),
	        //'db_client' => array('name' => 'db_client', 'type' => 'xsd:string'),
	        //'uid_client' => array('name' => 'uid_client', 'type' => 'xsd:string'),
	        //'pwd_client' => array('name' => 'pwd_client', 'type' => 'xsd:string'),
	        'client_nomb' => array('name' => 'client_nomb', 'type' => 'xsd:string'),
	        'client_codi' => array('name' => 'client_codi', 'type' => 'xsd:string')
	    )
	);

	// $server->wsdl->addComplexType(
	//     'Client_array',
	//     'complexType',
	//     'array',
	//     '',
	//     'SOAP-ENC:Array',
	//     array(
	//         array(
	//         	'ref' => 'SOAP-ENC:arrayType',
	//         	'wsdl:arrayType' => 'tns:Client[]'
	//         )
	//     )
	// );

	$server->wsdl->addComplexType(
	    'Person',
	    'complexType',
	    'struct',
	    'all',
	    '',
	    array(
	        'id_user' => array('name' => 'id_user', 'type' => 'xsd:int'),
	        'fullname' => array('name' => 'fullname', 'type' => 'xsd:string'),
	        'email' => array('name' => 'email', 'type' => 'xsd:string'),
	        'level' => array('name' => 'level', 'type' => 'xsd:int')
	    )
	);

	//first simple function
	$server->register('hello',
				array('username' => 'xsd:string'),  //parameter
				array('return' => 'xsd:string'),  //output
				'urn:server',   //namespace
				'urn:server#helloServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Just say hello');  //description

	//this is the second webservice entry point/function 
	$server->register('login',
				array('username' => 'xsd:string', 'password'=>'xsd:string'),  //parameters
				array('return' => 'tns:Person'),  //output
				'urn:server',   //namespace
				'urn:server#loginServer',  //soapaction
				'rpc', // style
				'encoded', // use
				'Check user login');  //description

	//this is the second webservice entry point/function 
	

	//first function implementation
	function hello($username) {
	        return 'Howdy, '.$username.'!';
	}

	//second function implementation 
	function login($username, $password) {
	        //should do some database query here
	        // .... ..... ..... .....
	        //just some dummy result
	        return array(
			'id_user'=>1,
			'fullname'=>'John Reese',
			'email'=>'john@reese.com',
			'level'=>99
		);
	}
	$server->register('listarClientes',
				array('clie_codi' => 'xsd:int'),  //parameters
				array('return' => 'xsd:string'),  //output
				'urn:server',   //namespace
				'urn:server#listarClientes',  //soapaction
				'rpc',
				'encoded', // use
				'Check user login'
				);  //description
	//
	

	//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

	$server->service(file_get_contents("php://input"));

	//descomente raw_post_data = -1 en xampp
?>