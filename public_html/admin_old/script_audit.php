<?php

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
		 
	if( isset( $_POST[ 'cmb_modulo' ] ) )
		$cmb_modulo = $_POST[ 'cmb_modulo' ];
	
	// Actualizacion de Valores (Comportamiento)
	if( isset( $_POST[ 'cmb_modulo' ] ) )
	{   $cmb_modulo = $_POST[ 'cmb_modulo' ];
		$sql="{call acci_audi_view (".$cmb_modulo.")}";
		$audi_cons = sqlsrv_query($conn, $sql);  
		while ( $row_audi_view = sqlsrv_fetch_array( $audi_cons ) )
		{   echo "<li><input type='checkbox' name='acciones[]' value='".$row_audi_view['audi_tipo_codi']."' />".$row_audi_view['audi_tipo_deta']."</li>";
		}
	}
?>