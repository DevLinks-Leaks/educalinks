<?php
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'alum_upd':

		if($uploadOk!=0){
			$alum_fech_naci = substr($_POST['alum_fech_naci'],6,4)."".substr($_POST['alum_fech_naci'],3,2)."".substr($_POST['alum_fech_naci'],0,2);
			$alum_genero = ($_POST['alum_genero']=='Hombre'?1:0);
			$sql	= "{call actualiza_estudiante(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
			$params	= array($_SESSION['alum_codi'],
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
							$_POST['alum_parroq'],
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
							$_POST['alum_prov_naci'],
							$_POST['alum_ciud_naci'],
							$_POST['alum_parr_naci'],
							$_POST['alum_sect_naci'],
							$_POST['alum_ex_plantel'],
							$_POST['alum_ex_plantel_dire'],
							$_POST['alum_prov'],
							$_POST['alum_etnia'],
							$_POST['alum_tiene_seguro'],
							$_SESSION['repr_codi']);
			$stmt_al	= sqlsrv_query($conn,$sql,$params);
			if ($stmt_al===false){
				$result= json_encode(array ('state'=>'error',
							'result'=>'No se pueden actualizar los datos.',
							'console'=> sqlsrv_errors() ));
			}else{
				$_SESSION['alum_upd']=1;
				$_SESSION['repr_upd']=1;
				$result= json_encode(array ('state'=>'success',
							'result'=>'¡Los datos del alumno fueron actualizados!' ));
			}
		}
		echo $result;
	break;
}
?>