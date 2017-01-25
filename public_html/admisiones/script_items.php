<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':
		$recu_codi=$_POST['recu_codi'];	
		$item_edic=$_POST['item_edic'];	
		$item_fech_ing=$_POST['item_fech_ing'];
		$item_prec=$_POST['item_prec'];	
		$item_proc_codi=$_POST['item_proc_codi'];	
		$item_cant=$_POST['item_cant'];
		$params = array($recu_codi,$item_edic,$item_fech_ing,$item_prec,$item_proc_codi,$item_cant);
		$sql="{call lib_item_add(?,?,?,?,?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el item.'));
		}else{
			
				$result= json_encode(array ('state'=>'success',
						'result'=>'Item agregado con éxito.' ));
		} 

		echo $result;
	break;
	case 'edit':
		$item_codi=$_POST['item_codi'];	
		$item_edic=$_POST['item_edic'];	
		$item_fech_ing=$_POST['item_fech_ing'];
		$item_prec=$_POST['item_prec'];	
		$item_proc_codi=$_POST['item_proc_codi'];	
		$params = array($item_codi,$item_edic,$item_fech_ing,$item_prec,$item_proc_codi);
		$sql="{call lib_item_edit(?,?,?,?,?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al editar el item.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Item editado con éxito.' ));
		} 

		echo $result;
	break;

	case 'del':
		$item_codi=$_POST['item_codi']; 
		$params = array($item_codi);
		$sql="{call lib_item_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);  
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el item.' ));
		}else{
			
			$result= json_encode(array ('state'=>'success',
					'result'=>'Item eliminado con éxito.' ));
		} 

		echo $result;
	break;
}
?>