<?php
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'repr_upd':
		$es_colaborador = ($_POST['repr_escolaborador']=='true' ? 1 : 0 );
		$repr_ex_alum = ($_POST['repr_ex_alum']=='true' ? 1 : 0 );
		$repr_fech_promoc = substr($_POST['repr_fech_promoc'],6,4)."".substr($_POST['repr_fech_promoc'],3,2)."".substr($_POST['repr_fech_promoc'],0,2);
		$repr_fech_naci = substr($_POST['repr_fech_naci'],6,4)."".substr($_POST['repr_fech_naci'],3,2)."".substr($_POST['repr_fech_naci'],0,2);
		$sql	= "{call preins_repr(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params	= array($_POST['repr_codi'],
						$_POST['repr_nomb'],
						$_POST['repr_apel'],
						$_POST['repr_email'],
						$_POST['repr_telf'],
						$_POST['repr_domi'],
						$_POST['repr_estado_civil'],
						$_POST['repr_celular'],
						$_POST['repr_profesion'],
						$_POST['repr_nacionalidad'],
						$_POST['repr_lugar_trabajo'],
						$_POST['repr_direc_trabajo'],
						$_POST['repr_cargo'],
						$_POST['repr_religion'],
						$_POST['repr_estudios'],
						$_POST['repr_institucion'],
						$_POST['repr_motivo_representa'],
						$es_colaborador,
						$_POST['repr_telf_trab'],
						$repr_fech_promoc,
						$repr_ex_alum,
						$repr_fech_naci,
						$_POST['repr_pais_naci'],
						$_POST['repr_prov_naci'],
						$_POST['repr_ciud_naci'],
						$_POST['identificacion_niv_1'],
                        $_POST['identificacion_niv_2'],
                        $_POST['identificacion_niv_3']);
		$stmt_rep	= sqlsrv_query($conn,$sql,$params);
		if ($stmt_rep===false){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al actualizar datos del representante.',
						'console'=> sqlsrv_errors() ));
		}else{
			$result= json_encode(array ('state'=>'success',
						'result'=>'Datos de representante actualizado con éxito.' ));
		}
		echo $result;
	break;
	case 'res_add':
		$alum_resp_form_banc_tarj_nume = $_POST['alum_resp_form_banc_tarj_nume'];
		if($alum_resp_form_banc_tarj_nume==''){
			$alum_resp_form_banc_tarj_nume_encrypt='';
		
		}else{
			 if(strpos($alum_resp_form_banc_tarj_nume, 'X') ===false){
				/*Codigo de encriptado de Número de tarjeta de crédito*/
				$iv = base64_decode($_SESSION['clie_iv']);
				$alum_resp_form_banc_tarj_nume_encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume, MCRYPT_MODE_CBC, $iv);
				$alum_resp_form_banc_tarj_nume_encrypt =base64_encode($alum_resp_form_banc_tarj_nume_encrypt);
				/*FIN*/
			}else{
				$alum_resp_form_banc_tarj_nume_encrypt=null;
			}
		}
		$alum_fech_naci = substr($_POST['alum_fech_naci'],6,4)."".substr($_POST['alum_fech_naci'],3,2)."".substr($_POST['alum_fech_naci'],0,2);
		$alum_genero = ($_POST['alum_genero']=='Hombre'?1:0);
		$alum_resp_tarj_banco_emisor = ($_POST['alum_resp_tarj_banco_emisor']==0?'':$_POST['alum_resp_tarj_banco_emisor']);
		$alum_resp_form_fech_vcto = substr($_POST['alum_resp_form_fech_vcto'],6,4)."".substr($_POST['alum_resp_form_fech_vcto'],3,2)."".substr($_POST['alum_resp_form_fech_vcto'],0,2);
		$alum_resp_form_banc_tipo = ($_POST['alum_resp_form_banc_tipo'] =='CORRIENTE'?'C':'A');
		$sql	= "{call preins_add(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params	= array($_SESSION['alum_codi'],
						$_SESSION['alum_curs_para_codi'],
						$_SESSION['peri_codi_dest'],
						$_POST['alum_nomb'],
						$_POST['alum_apel'],
						$alum_fech_naci,
						$alum_genero,
						$_POST['alum_cedu'],
						$_POST['alum_tipo_iden'],
						$_POST['alum_mail'],
						$_POST['alum_celu'],
						$_POST['alum_domi'],
						$_POST['alum_telf'],
						$_POST['alum_ciud'],
						$_POST['alum_parroquia'],
						$_POST['alum_pais'],
						$_POST['alum_nacionalidad'],
						$_POST['alum_religion'],
						$_POST['alum_vive_con'],
						$_POST['alum_parentesco_vive_con'],
						$_POST['alum_estado_civil_padres'],
						$_POST['alum_movilizacion'],
						$_POST['alum_activ_deportiva'],
						$_POST['alum_activ_artistica'],
						$_POST['alum_enfermedades'],
						$_POST['alum_telf_emerg'],
						$_POST['alum_parentesco_emerg'],
						$_POST['alum_pers_emerg'],
						$_POST['alum_tipo_sangre'],
						$_POST['alum_resp_form_pago'],
						$_POST['alum_resp_form_banc_tarj'],
						$alum_resp_tarj_banco_emisor,
						$alum_resp_form_banc_tarj_nume_encrypt,
						$alum_resp_form_fech_vcto,
						$alum_resp_form_banc_tipo,
						$_POST['alum_resp_form_cedu'],
						$_POST['alum_resp_form_tipo_iden'],
						$_POST['alum_resp_form_nomb'],
						$_POST['alum_prov_naci'],
						$_POST['alum_ciud_naci'],
						$_POST['alum_parr_naci'],
						$_POST['alum_sect_naci'],
						$_POST['alum_ex_plantel'],
						$_POST['alum_ex_plantel_dire'],
						$_POST['alum_repr_finan'],
						$_POST['alum_prov']);
		$stmt_al	= sqlsrv_query($conn,$sql,$params);
		if ($stmt_al===false){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al realizar la reservación de cupo.',
						'console'=> sqlsrv_errors() ));
		}else{
			$result= json_encode(array ('state'=>'success',
						'result'=>'Reservación de cupo realizada con éxito.' ));
		}
		echo $result;
	break;
	case 'cargar_idenficacion_nivel_2':
        $data = array(); $res = ""; $msj = "";
        $sql = "{call identificaciones_niv2_view(?)}";
        $params = array($_POST['id']);
        $stmt = sqlsrv_query( $conn, $sql,$params);
        if( $stmt === false ){
            $res = "error";
            $msj = "Error en la conexión";
        }
        else{
            $res = "success";
            $msj = "Todo Ok";
            while ($row = sqlsrv_fetch_array($stmt))
                array_push($data,array("id"=>$row["id"], "nombre"=>$row["nombre"]));
        }
        print json_encode(array("res"=>$res, "msj"=>$msj, "data"=>$data));
    break;
    case 'cargar_idenficacion_nivel_3':
        $data = array(); $res = ""; $msj = "";
        $sql = "{call identificaciones_niv3_view(?)}";
        $params = array($_POST['id']);
        $stmt = sqlsrv_query( $conn, $sql,$params);
        if( $stmt === false ){
            $res = "error";
            $msj = "Error en la conexión";
        }
        else{
            $res = "success";
            $msj = "Todo Ok";
            while ($row = sqlsrv_fetch_array($stmt))
                array_push($data,array("id"=>$row["id"], "nombre"=>$row["nombre"]));
        }
        print json_encode(array("res"=>$res, "msj"=>$msj, "data"=>$data));
    break;
    case 'repr_info_search':
		$sql_opc = "{call repr_info_search(?)}";
		$params_opc= array($_POST['repr_cedu']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if ($stmt_opc===false){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al consultar datos del representante.',
						'console'=> sqlsrv_errors() ));
		}else{
			$result= json_encode(array ('state'=>'success',
						'result'=>'Se encontraron coincidencias con el número de identificación.' ));
		}
		$row_repr_view=sqlsrv_fetch_array($stmt_opc);
		
	break;
	case 'alum_cuen_add':
		$alum_cuen_nume = $_POST['alum_cuen_nume'];
		if($alum_cuen_nume==''){
			$alum_cuen_nume_encrypt='';
		
		}else{
			/*Codigo de encriptado de Número de tarjeta de crédito*/
			$iv = base64_decode($_SESSION['clie_iv']);
			$alum_cuen_nume_encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_cuen_nume, MCRYPT_MODE_CBC, $iv);
			$alum_cuen_nume_encrypt =base64_encode($alum_cuen_nume_encrypt);
			/*FIN*/
		}
		$alum_cuen_banc_emis = ($_POST['alum_cuen_banc_emis']==0 ? null : $_POST['alum_cuen_banc_emis']);
		$alum_codi = ($_POST['alum_codi']==0 ? null : $_POST['alum_codi']);
		$alum_cuen_fech_venc = ($_POST['alum_cuen_fech_venc']=='' ? null : substr($_POST['alum_cuen_fech_venc'],6,4)."".substr($_POST['alum_cuen_fech_venc'],3,2)."".substr($_POST['alum_cuen_fech_venc'],0,2) );
		$sql_opc = "{call alum_cuentas_add(?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array($alum_codi,
							$_POST['alum_cuen_form_pago'],
							$_POST['alum_cuen_banc_tarj'],
							$alum_cuen_banc_emis,
							$alum_cuen_fech_venc,
							$alum_cuen_nume_encrypt,
							$_POST['alum_cuen_tipo'],
							$_POST['alum_cuen_nomb'],
							$_POST['alum_cuen_cedu'],
							$_POST['alum_cuen_tipo_iden'],
							'P'); //Estado por aprobar.
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la cuenta de pago.',
						'console'=> sqlsrv_errors() ));
		}else{
			//Para auditoría
			$detalle="Código alumno: ".$_POST['alum_codi'];
			$detalle.=" Banco/Tarjeta: ".$_POST['alum_cuen_banc_tarj'];
			$detalle.=" alum_cuen_codi: ".$_POST['alum_cuen_codi'];
			// iNFO NUMERO CUENTA
			if(strpos($alum_cuen_nume, 'X') ===true)
				$detalle.=" # Banco/Tarjeta: ".$_POST['alum_cuen_nume'];
			else{ 
				if (is_numeric($_POST['alum_cuen_nume']))
					$detalle.=" # Banco/Tarjeta: ".$alum_cuen_nume_encrypt;
				else
					$detalle.=" # Banco/Tarjeta: ".$_POST['alum_cuen_nume'];
			}
			$detalle.=" Proceso: Preinscripción";
			registrar_auditoria (121, $detalle);
			$result= json_encode(array ('state'=>'success',
					'result'=>'Cuenta de pago agregada con éxito.' ));
		}
		echo $result;
	break;
}
?>