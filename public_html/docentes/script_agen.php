<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc']))
{
	$opc=$_POST['opc'];
}
else
{
	$opc="";
}
switch($opc)
{
	case 'agen_add':

        $agen_tiempo=($_POST['agen_tiempo']==''? null : $_POST['agen_tiempo']);
        $agen_mater=($_POST['agen_mater']==''? null : $_POST['agen_mater']);
        $agen_retr=($_POST['agen_retr']==''? null : $_POST['agen_retr']);
        $agen_crit=($_POST['agen_crit']==''? null : $_POST['agen_crit']);
        $agen_indi=($_POST['agen_indi']==''? null : $_POST['agen_indi']);

		$params_form = array($_POST['curs_para_mate_prof_codi'],
							$_POST['agen_titu'],
							$_POST['agen_deta'],
							$_POST['agen_fech_fin'],
							$_POST['agen_fech_ini'],
                            $_POST['agen_tipo_codi'],
                            $agen_tiempo,
                            $agen_mater,
                            $agen_retr,
                            $agen_crit,
                            $agen_indi);

		$sql_form="{call agen_add(?,?,?,?,?,?,?,?,?,?,?)}";
		$stmp_form = sqlsrv_query($conn, $sql_form, $params_form);	
		if( $stmp_form === false)
		{
			echo "Error in connection.\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$veri=lastId($stmp_form);

		if($_FILES['mater_codi']!=''){
            $archivo = $_FILES['mater_codi'];
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);

            if ($extension!='exe' and $_FILES["mater_codi"]["size"]>0)
            {	$nombre = $archivo['name'];
                if(!file_exists($_SESSION['ruta_materiales_carga']))
                {
                    mkdir($_SESSION['ruta_materiales_carga'],0777,TRUE);
                }

                $sql_opc = "{call curs_para_mate_mater_add(?,?,?,?)}";
                $params_opc= array($_POST['agen_titu'],
                    $_POST['agen_deta'],
                    $extension,
                    $_POST['curs_para_mate_prof_codi']);

                $stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);

                if( $stmt_opc === false )
                {
                    echo "Material no subido";
                }else{
                    $mater_view_opc=lastId($stmt_opc);
                    if (move_uploaded_file($archivo['tmp_name'], $_SESSION['ruta_materiales_carga'].$mater_view_opc.".".$extension))
                    {
                        $params_form = array($veri,$mater_view_opc);
                        $sql_form="{call agen_mater_upd(?,?)}";
                        $stmp_form = sqlsrv_query($conn, $sql_form, $params_form);

                        //Para auditoría
                        $params = array($_POST['curs_para_mate_prof_codi']);
                        $sql="{call curs_para_mate_prof_info(?)}";
                        $curs_para_mate_prof_info = sqlsrv_query($conn, $sql, $params);
                        $row_curs_para_mate_prof_info= sqlsrv_fetch_array($curs_para_mate_prof_info);

                        $detalle="Curso paralelo : ".$row_curs_para_mate_prof_info['curs_deta'].' "'.$row_curs_para_mate_prof_info['para_deta'].'"';
                        $detalle.=" Nivel : ".$row_curs_para_mate_prof_info['nive_deta'];
                        $detalle.=" Materia : ".$row_curs_para_mate_prof_info['mate_deta'];
                        $detalle.=" Material título: ".$_POST['mater_titu'];
                        $detalle.=" Material detalle: ".$_POST['mater_deta'];
                        $detalle.=" Extensión: ".$extension;
                        registrar_auditoria (40, $detalle);

                    }
                }

            }
        }

		$params = array($_POST['curs_para_mate_prof_codi']);
		$sql="{call curs_para_mate_prof_info(?)}";
		$curs_para_mate_prof_info = sqlsrv_query($conn, $sql, $params);
		$row_curs_para_mate_prof_info= sqlsrv_fetch_array($curs_para_mate_prof_info);

		//Para auditoría
		$detalle="Curso paralelo : ".$row_curs_para_mate_prof_info['curs_deta'].' "'.$row_curs_para_mate_prof_info['para_deta'].'"';
		$detalle.=" Nivel : ".$row_curs_para_mate_prof_info['nive_deta'];
		$detalle.=" Materia : ".$row_curs_para_mate_prof_info['mate_deta'];
		$detalle.=" Agenda título: ".$_POST['agen_titu'];
		$detalle.=" Agenda detalle: ".$_POST['agen_deta'];
		$detalle.=" Agenda fecha inicio: ".$_POST['agen_fech_ini'];
		$detalle.=" Agenda fecha fin: ".$_POST['agen_fech_fin'];
        $detalle.=" Agenda tipo: ".$_POST['agen_tipo_codi'];
        $detalle.=" Agenda tiempo: ".$_POST['agen_tiempo'];
        $detalle.=" Agenda materiales: ".$_POST['agen_mater'];
        $detalle.=" Agenda retroalimentación: ".$_POST['agen_retr'];
        $detalle.=" Agenda criterios: ".$_POST['agen_crit'];
        $detalle.=" Agenda indicadores: ".$_POST['agen_indi'];
        $detalle.=" Agenda material codigo: ".$_POST['mater_codi'];
		registrar_auditoria (38, $detalle);
		
		if ($veri>0)
		{
			echo "OK";
		}
		else
		{
			echo "KO";
		}
	break;
	case 'agen_view':
		include ('agenda_main_view.php');
	break;
	
	case 'agen_del':
		$params_form = array($_POST['agen_codi']);
		$sql_form="{call agen_del(?)}";
		sqlsrv_query($conn, $sql_form, $params_form);	
				
		echo "OK";
		
	break;

    case 'agen_edit':

        $agen_tiempo=($_POST['agen_tiempo']==''? null : $_POST['agen_tiempo']);
        $agen_mater=($_POST['agen_mater']==''? null : $_POST['agen_mater']);
        $agen_retr=($_POST['agen_retr']==''? null : $_POST['agen_retr']);
        $agen_crit=($_POST['agen_crit']==''? null : $_POST['agen_crit']);
        $agen_indi=($_POST['agen_indi']==''? null : $_POST['agen_indi']);

        $params_form = array($_POST['agen_codi'],
            $_POST['agen_titu'],
            $_POST['agen_deta'],
            $_POST['agen_fech_fin'],
            $_POST['agen_fech_ini'],
            $_POST['agen_tipo_codi'],
            $agen_tiempo,
            $agen_mater,
            $agen_retr,
            $agen_crit,
            $agen_indi);

        $sql_form="{call agen_edit(?,?,?,?,?,?,?,?,?,?,?)}";
        $stmp_form = sqlsrv_query($conn, $sql_form, $params_form);
        if( $stmp_form === false)
        {
            echo "KO";
            die( print_r( sqlsrv_errors(), true));
        }else{
            $veri=$_POST['agen_codi'];

            if($_FILES['mater_codi']!=''){
                $archivo = $_FILES['mater_codi'];
                $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);

                if ($extension!='exe' and $_FILES["mater_codi"]["size"]>0)
                {	$nombre = $archivo['name'];
                    if(!file_exists($_SESSION['ruta_materiales_carga']))
                    {
                        mkdir($_SESSION['ruta_materiales_carga'],0777,TRUE);
                    }

                    if($_POST['mater_codi_edit']==0){
                        $sql_opc = "{call curs_para_mate_mater_add(?,?,?,?)}";
                        $params_opc= array($_POST['agen_titu'],
                            $_POST['agen_deta'],
                            $extension,
                            $_POST['curs_para_mate_prof_codi']);

                        $stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);

                        if( $stmt_opc === false )
                        {
                            echo "Material no subido";
                        }else{
                            $mater_view_opc=lastId($stmt_opc);
                            if (move_uploaded_file($archivo['tmp_name'], $_SESSION['ruta_materiales_carga'].$mater_view_opc.".".$extension))
                            {
                                $params_form = array($veri,$mater_view_opc);
                                $sql_form="{call agen_mater_upd(?,?)}";
                                $stmp_form = sqlsrv_query($conn, $sql_form, $params_form);

                                //Para auditoría
                                $params = array($_POST['curs_para_mate_prof_codi']);
                                $sql="{call curs_para_mate_prof_info(?)}";
                                $curs_para_mate_prof_info = sqlsrv_query($conn, $sql, $params);
                                $row_curs_para_mate_prof_info= sqlsrv_fetch_array($curs_para_mate_prof_info);

                                $detalle="Curso paralelo : ".$row_curs_para_mate_prof_info['curs_deta'].' "'.$row_curs_para_mate_prof_info['para_deta'].'"';
                                $detalle.=" Nivel : ".$row_curs_para_mate_prof_info['nive_deta'];
                                $detalle.=" Materia : ".$row_curs_para_mate_prof_info['mate_deta'];
                                $detalle.=" Material título: ".$_POST['mater_titu'];
                                $detalle.=" Material detalle: ".$_POST['mater_deta'];
                                $detalle.=" Extensión: ".$extension;
                                registrar_auditoria (40, $detalle);

                            }
                        }
                        echo 'OK';
                    }else{

                        if (move_uploaded_file($archivo['tmp_name'], $_SESSION['ruta_materiales_carga'].$mater_view_opc.".".$extension))
                        {
                            $sql_opc = "{call curs_para_mate_mater_edit(?,?,?,?)}";
                            $params_opc= array(
                                $_POST['mater_codi_edit'],
                                $_POST['agen_titu'],
                                $_POST['agen_deta'],
                                $extension);

                            $stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
                            if( $stmt_opc === false)
                            {
                                echo "KO";
                                die( print_r( sqlsrv_errors(), true));
                            }
                        }

                        echo 'OK';
                    }

                }
            }

            echo 'OK';
        }
    break;
}
?>