<?php
extract($_GET);
switch ($method)
{	case "show_cursos_niv":
		show_cursos_niv ($nive_codi);
	break;
	case "show_cursos":
		show_cursos ();
	break;
	case "save":
		$json 	= $_GET['json'];
		save ($json);
	break;
	case "check_id":
		$tipo_id 	= $_GET['tipo_id'];
		$numero_id 	= $_GET['numero_id'];
		check_id ($tipo_id, $numero_id);
	break;
}
function show_cursos_niv ($nive_codi)
{ 	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$params   = array($nive_codi);
	$sql	  = "{call curs_nive_cons(?)}";
	$stmt 	  = sqlsrv_query($conn, $sql, $params);  
	
	$json = array();
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
	{
		$json[] = $row;
	}
	print json_encode($json);	
}
function show_cursos ()
{ 	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$params   = array();
	$sql	  = "{call curs_view()}";
	$stmt 	  = sqlsrv_query($conn, $sql, $params);  
	
	$json = array();
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
	{
		$json[] = $row;
	}
	print json_encode($json);	
}
function save ($json)
{	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	$obj_json = json_decode($json,true);
	/*Creación de XML*/
	$xml_solicitud = new DOMDocument("1.0","UTF-8");
	/*Creación del root*/
	$root_solicitud = $xml_solicitud->createElement("root");
	/*Creación del elemento aspirante*/
	$solicitud = $xml_solicitud->createElement("solicitud");
	/*Creación de atributos a aspirante*/
	$solicitud->setAttribute('id',($obj_json['id']!=""?$obj_json['id']:-1));
	$solicitud->setAttribute('peri_codi',$obj_json['peri_codi']);
	$solicitud->setAttribute('asp_codi',$obj_json['asp_codi']);
	$solicitud->setAttribute('nivel_aplic',$obj_json['nivel_aplic']);
	$solicitud->setAttribute('curso_aplic',$obj_json['curso_aplic']);
	$solicitud->setAttribute('es_repetidor',$obj_json['es_repetidor']);
	$solicitud->setAttribute('curs_repite',$obj_json['curs_repite']);
	$solicitud->setAttribute('apoyo_acad',$obj_json['apoyo_acad']);
	$solicitud->setAttribute('apoyo_social',$obj_json['apoyo_social']);
	$solicitud->setAttribute('apoyo_ingles',$obj_json['apoyo_ingles']);
	$solicitud->setAttribute('apoyo_otro',utf8_encode($obj_json['apoyo_otro']));
	$solicitud->setAttribute('apoyo_aspectos',$obj_json['apoyo_aspectos']);
	$solicitud->setAttribute('programa_terapia_ext',$obj_json['programa_terapia_ext']);
	$solicitud->setAttribute('programa_drogas',$obj_json['programa_drogas']);
	$solicitud->setAttribute('otros_programas',utf8_encode($obj_json['otros_programas']));
	$solicitud->setAttribute('pertenece_grupo_cat',$obj_json['pertenece_grupo_cat']);
	$solicitud->setAttribute('grupo_cat',utf8_encode($obj_json['grupo_cat']));
	$solicitud->setAttribute('es_deportista',$obj_json['es_deportista']);
	$solicitud->setAttribute('deporte',utf8_encode($obj_json['deporte']));
	$solicitud->setAttribute('familiares_est',utf8_encode($obj_json['familiares_est']));
	$solicitud->setAttribute('retiro_sug',$obj_json['retiro_sug']);
	$solicitud->setAttribute('probl_acad',$obj_json['probl_acad']);
	$solicitud->setAttribute('probl_discip',utf8_encode($obj_json['probl_discip']));
	$solicitud->setAttribute('historial_ue',utf8_encode($obj_json['historial_ue']));
	$solicitud->setAttribute('es_enfermo',$obj_json['es_enfermo']);
	$solicitud->setAttribute('enfermedad',utf8_encode($obj_json['enfermedad']));
	$solicitud->setAttribute('es_alergico',$obj_json['es_alergico']);
	$solicitud->setAttribute('alergia',utf8_encode($obj_json['alergia']));
	$solicitud->setAttribute('dato_com_1',utf8_encode($obj_json['dato_com_1']));
	$solicitud->setAttribute('dato_com_2',utf8_encode($obj_json['dato_com_2']));
	$solicitud->setAttribute('dato_com_3',utf8_encode($obj_json['dato_com_3']));
	/*Adjunto aspirante a la raiz*/
	$root_solicitud->appendChild($solicitud);
	/*Adjunto la raiz al documento principal*/
	$xml_solicitud->appendChild($root_solicitud);
	
	$params   = array($xml_solicitud->saveXML());
	$sql	  = "{call admisiones_form_save(?)}";
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