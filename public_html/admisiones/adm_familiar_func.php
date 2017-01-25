<?php
//$method = $_GET['method'];
extract ($_GET);
switch ($method)
{	case "show":
		show ($tipo_id, $numero_id, $aspirante_id);
	break;
	case "save":
		save ($json);
	break;
	case "set_tipo_representante":
		set_tipo_representante ($aspirante_id, $representante_id, $tipo);
	break;
	case "check_id":
		check_id ($tipo_id, $numero_id);
	break;
}
function show ($tipo_id, $numero_id, $aspirante_id)
{ 	session_start();
	include ('../framework/dbconf.php');
	
	$params   = array($tipo_id, $numero_id, $aspirante_id);
	$sql	  = "{call admisiones_familiar_aspirante_show(?,?,?)}";
	$options  = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	$stmt 	  = sqlsrv_query($conn, $sql, $params, $options);  
	
	if (sqlsrv_num_rows($stmt)===false)
	{	$result= json_encode(array ('state'=>'error',
					'result'=>'Sin resultados.' ));
	}
	else
	{	$result= json_encode(array ('state'=>'success',
					'result'=>'Con resultados.' ));
		$json = array();
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		$json[] = $row;
	}
	print json_encode($json);
	
}
function save ($json)
{	session_start();
	include ('../framework/dbconf.php');
	$obj_json = json_decode($json,true);
	/*Creación de XML*/
	$xml_familiar = new DOMDocument("1.0","UTF-8");
	/*Creación del root*/
	$root_familiar = $xml_familiar->createElement("root");
	/*Creación del elemento familiar*/
	$familiar = $xml_familiar->createElement("familiar");
	/*Creación de atributos a familiar*/
	$familiar->setAttribute('id',($obj_json['id']!=""?$obj_json['id']:-1));
	$familiar->setAttribute('tipo_id',$obj_json['tipo_id']);
	$familiar->setAttribute('numero_id',$obj_json['numero_id']);
	$familiar->setAttribute('nombre_1',utf8_encode($obj_json['nombre_1']));
	$familiar->setAttribute('nombre_2',utf8_encode($obj_json['nombre_2']));
	$familiar->setAttribute('apellido_1',utf8_encode($obj_json['apellido_1']));
	$familiar->setAttribute('apellido_2',utf8_encode($obj_json['apellido_2']));
	$familiar->setAttribute('genero',$obj_json['genero']);
	$familiar->setAttribute('fecha_ncto',$obj_json['fecha_ncto']);
	$familiar->setAttribute('profesion',utf8_encode($obj_json['profesion']));
	$familiar->setAttribute('nacionalidad',utf8_encode($obj_json['nacionalidad']));
	$familiar->setAttribute('direccion',utf8_encode($obj_json['direccion']));
	$familiar->setAttribute('num_convencional',$obj_json['num_convencional']);
	$familiar->setAttribute('num_celular',$obj_json['num_celular']);
	$familiar->setAttribute('correo',utf8_encode($obj_json['correo']));
	$familiar->setAttribute('empresa_trabaja',utf8_encode($obj_json['empresa_trabaja']));
	$familiar->setAttribute('cargo',utf8_encode($obj_json['cargo']));
	$familiar->setAttribute('direccion_trabajo',utf8_encode($obj_json['direccion_trabajo']));
	$familiar->setAttribute('convencional_trabajo',$obj_json['convencional_trabajo']);
	$familiar->setAttribute('celular_trabajo',$obj_json['celular_trabajo']);
	$familiar->setAttribute('correo_trabajo',utf8_encode($obj_json['correo_trabajo']));
	$familiar->setAttribute('colegio',utf8_encode($obj_json['colegio']));
	$familiar->setAttribute('universidad',utf8_encode($obj_json['universidad']));
	$familiar->setAttribute('parentesco',utf8_encode($obj_json['parentesco']));
	$familiar->setAttribute('motivo',utf8_encode($obj_json['motivo']));
	$familiar->setAttribute('aspirante_id',utf8_encode($obj_json['aspirante_id']));
	
	/*Adjunto familiar a la raiz*/
	$root_familiar->appendChild($familiar);
	/*Adjunto la raiz al documento principal*/
	$xml_familiar->appendChild($root_familiar);
	
	$params   = array($xml_familiar->saveXML());
	$sql	  = "{call admisiones_familiar_save(?)}";
	$stmt 	  = sqlsrv_query($conn, $sql, $params);  
	
	if ($stmt === false)
	{	$result = array ('state'=>'error',
					'result'=>'Un error ha ocurrido');
	}
	else
	{	$res = sqlsrv_fetch_array($stmt);
		$result = array ('state'=>'success',
					'result'=>'Todo OK', 'id'=>$res['id']);
	}
	print json_encode($result);
}
function set_tipo_representante ($aspirante_id, $representante_id, $tipo)
{ 	session_start();
	include ('../framework/dbconf.php');
	
	$params   = array($aspirante_id, $representante_id, $tipo);
	$sql	  = "{call admisiones_set_tipo_representante(?,?,?)}";
	$stmt 	  = sqlsrv_query($conn, $sql, $params);  
	if ($stmt)
		$json	  = array ("result"=>"success", "message"=>"Correcto");
	else
		$json	  = array ("result"=>"error", "message"=>"Ocurrió un error");
	print json_encode($json);
}
function check_id ($tipo_identificacion,$num_identificacion)
{	$strCedula = $num_identificacion;
	$tipo_iden = $tipo_identificacion;
	$result		= "";
	$message	= "";
	if(is_null($strCedula) || empty($strCedula))
	{	//compruebo si que el numero enviado es vacio o null
		$message = "Por favor ingrese la cédula";
		$result	 = "error";
	}
	else
	{	//caso contrario sigo el proceso
		if ($tipo_iden=='PAS'){
			$message = "Correcto";
			$result	 = "success";
		}elseif(is_numeric($strCedula))
		{	$total_caracteres=strlen($strCedula);// se suma el total de caracteres
			if($tipo_iden=='CI')
			{
				if($total_caracteres==10)
				{	//compruebo que tenga 10 digitos la cedula
					$nro_region=substr($strCedula, 0,2);//extraigo los dos primeros caracteres de izq a der
					if($nro_region>=1 && $nro_region<=24)
					{	// compruebo a que region pertenece esta cedula//
						$ult_digito=substr($strCedula, -1,1);//extraigo el ultimo digito de la cedula
						//extraigo los valores pares//
						$valor2=substr($strCedula, 1, 1);
						$valor4=substr($strCedula, 3, 1);
						$valor6=substr($strCedula, 5, 1);
						$valor8=substr($strCedula, 7, 1);
						$suma_pares=($valor2 + $valor4 + $valor6 + $valor8);
						//extraigo los valores impares//
						$valor1=substr($strCedula, 0, 1);
						$valor1=($valor1 * 2);
						if($valor1>9){ $valor1=($valor1 - 9); }else{ }
						$valor3=substr($strCedula, 2, 1);
						$valor3=($valor3 * 2);
						if($valor3>9){ $valor3=($valor3 - 9); }else{ }
						$valor5=substr($strCedula, 4, 1);
						$valor5=($valor5 * 2);
						if($valor5>9){ $valor5=($valor5 - 9); }else{ }
						$valor7=substr($strCedula, 6, 1);
						$valor7=($valor7 * 2);
						if($valor7>9){ $valor7=($valor7 - 9); }else{ }
						$valor9=substr($strCedula, 8, 1);
						$valor9=($valor9 * 2);
						if($valor9>9){ $valor9=($valor9 - 9); }else{ }

						$suma_impares=($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
						$suma=($suma_pares + $suma_impares);
						$dis=substr($suma, 0,1);//extraigo el primer numero de la suma
						$dis=(($dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
						$digito=($dis - $suma);
						if($digito==10){ $digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
						if ($digito==$ult_digito)
						{	//comparo los digitos final y ultimo
							$message 	= "Cédula correcta";
							$result		= "success";
						}
						else
						{	$message 	= "Cédula incorrecta";
							$result		= "error";
						}
					}else
					{	//echo "Este Nro de Cedula no corresponde a ninguna provincia del ecuador";
						$message 	= "Cédula correcta";
						$result		= "success";
					}
					//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".$total_caracteres."";

				}else //numero 10
				{	//echo "Es un Numero y tiene solo".$total_caracteres;
					$message 	= "Cédula incorrecta";
					$result		= "error";
				}
			} elseif ($tipo_iden=='RUC')
			{
				if($total_caracteres==13)
				{	//compruebo que tenga 10 digitos la cedula
					$nro_region=substr($strCedula, 0,2);//extraigo los dos primeros caracteres de izq a der
					if($nro_region>=1 && $nro_region<=24)
					{	
						$valor3=(int)$strCedula[2];
						if($valor3>=0 && $valor3<=5){ //Persona natural
							$primeros_digitos = substr($strCedula, 0, 9);
							$array_coeficientes = array(2, 1, 2, 1, 2, 1, 2, 1, 2);
							$digito_verificador = (int)$strCedula[9];
							$primeros_digitos = str_split($primeros_digitos);

							$total = 0;
							foreach ($primeros_digitos as $key => $value) {
								$valor_Posicion = ( (int)$value * $array_coeficientes[$key] );
								if ($valor_Posicion >= 10) {
									$valor_Posicion = str_split($valor_Posicion);
									$valor_Posicion = array_sum($valor_Posicion);
									$valor_Posicion = (int)$valor_Posicion;
								}
								$total = $total + $valor_Posicion;
							}
							$residuo =  $total % 10;
							if ($residuo == 0) {
								$resultado = 0;        
							} else {
								$resultado = 10 - $residuo;
							}
							if ($resultado != $digito_verificador) {
								$message 	= "RUC incorrecto";
								$result		= "error";
							}else{
								$message 	= "RUC correcto";
								$result		= "success";
							}
						}elseif ($valor3==6){ // Entidad Publica
							$primeros_digitos = substr($strCedula, 0, 8);
							$array_coeficientes = array(3, 2, 7, 6, 5, 4, 3, 2);
							$digito_verificador = (int)$strCedula[8];
							$primeros_digitos = str_split($primeros_digitos);

							$total = 0;
							foreach ($primeros_digitos as $key => $value) {
								$valor_Posicion = ( (int)$value * $array_coeficientes[$key] );
								$total = $total + $valor_Posicion;
							}
							$residuo =  $total % 11;
							if ($residuo == 0) {
								$resultado = 0;        
							} else {
								$resultado = 11 - $residuo;
							}
							if ($resultado != $digito_verificador) {
								$message 	= "RUC incorrecto";
								$result		= "error";
							}else{
								$message 	= "RUC correcto";
								$result		= "success";
							}
						}elseif ($valor3==9){ // Sociedad Privada
							
							$primeros_digitos = substr($strCedula, 0, 9);
							$array_coeficientes = array(4, 3, 2, 7, 6, 5, 4, 3, 2);
							$digito_verificador = (int)$strCedula[9];
							$primeros_digitos = str_split($primeros_digitos);

							$total = 0;
							foreach ($primeros_digitos as $key => $value) {
								$valor_Posicion = ( (int)$value * $array_coeficientes[$key] );
								$total = $total + $valor_Posicion;
							}
							$residuo =  $total % 11;
							if ($residuo == 0) {
								$resultado = 0;        
							} else {
								$resultado = 11 - $residuo;
							}
							if ($resultado != $digito_verificador) {
								$message 	= "RUC incorrecto";
								$result		= "error";
							}else{
								$message 	= "RUC correcto";
								$result		= "success";
							}
						}else {
							$message 	= "RUC incorrecto";
							$result		= "error";
						}
							
					}else
					{	//echo "Este Nro de RUC no corresponde a ninguna provincia del ecuador";
						$message 	= "RUC incorrecto";
						$result		= "error";
					}
					//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".$total_caracteres."";

				}else //numero 10
				{	//echo "Es un Numero y tiene solo".$total_caracteres;
					$message 	= "RUC incorrecto";
					$result		= "error";
				}
			}
		}else
		{	$message 	= "La cédula o RUC no es válido";
			$result		= "error";
			//echo "Incorrecto"
		}
	}
	print json_encode(array("result"=>$result,"message"=>$message));
}
?>