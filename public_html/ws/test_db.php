<?php	
	$serverName = "certuslinks.com";         
    $db = "Certuslinks_admin"; 
    $uid = "sa";
    $pwd = "R3dlink51981";
    $charset = "UTF-8";
    $connectionInfo = array("Database"=>$db, 
                            "UID"=>$uid, 
                            "PWD"=>$pwd, 
                            "CharacterSet"=>$charset);
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if(!$conn)
    {
        echo "La conexión no se pudo establecer.<br/>";
        die( print_r( sqlsrv_errors(), true));
    }
    try{
    	$params = array(1);
	    $sql = '{call clie_info (?)}';
	    $stmt = sqlsrv_query($conn, $sql, $params); 

	    while($row= sqlsrv_fetch_array($stmt)){
	        $array_res = array('client_nomb'=>$row['clie_base'],'client_codi'=>$row['clie_base']);
	    }

	    //sqlsrv_close($conn);
	    var_dump($array_res);
    }catch(Exception $e){
    	echo $e->getMessage();
    }
    

    
	
	//$json_clientes[] = array('client_nomb'=>'asd','client_codi'=>'123');
	//$json_clientes[] = array('client_nomb'=>'asda','client_codi'=>count($clientes->rows));
	

	var_dump(array('client_nomb'=>'AMBIENTE DESARROLLO','client_codi'=>'AMBIENTE DESARROLLO'));

?>