<?php
	
	include 'Classes/Representante.php';
	include 'Classes/Clientes.php';
	include 'Classes/Alumnos.php';
	include 'Classes/Agenda.php';
	include 'Classes/Notificaciones.php';
	include 'Classes/NotiUpdate.php';
	include 'Classes/Notificacionesall.php';
	include 'Classes/mensajesAll.php';
	include 'Classes/profesores.php';
	include 'Classes/mensajeNuevo.php';
	include 'Classes/mensajeEliminar.php';
	include 'Classes/mensajeUpdate.php';
        include 'Classes/facturasAutorizadas.php';
	
	if (isset($_POST["username"]))
		$username = $_POST["username"];
	else
		$username = "";
	
	if (isset($_POST["password"]))
		$password = $_POST["password"];
	else
		$password = "";
		
	if (isset($_POST["tipo_usua"]))
		$tipo_usua = $_POST["tipo_usua"];
	else
		$tipo_usua = "";
		
	if (isset($_POST["colegio"]))
		$colegio = $_POST["colegio"];
	else
		$colegio = "";
	
	if (isset($_POST["reprcodi"]))
		$reprcodi = $_POST["reprcodi"];
	else
		$reprcodi = "";
	
	if (isset($_POST["pericodi"]))
		$pericodi = $_POST["pericodi"];
	else
		$pericodi = "";
	
	if (isset($_POST["alumnocodi"]))
		$alumnocodi = $_POST["alumnocodi"];
	else
		$alumnocodi = "";
		
        if (isset($_POST["opci_codi"]))
		$opci_codi = $_POST["opci_codi"];
	else
		$opci_codi = "310";	
                
        if (isset($_POST["op"]))
		$op = $_POST["op"];
	else
		$op = "";
                
        if (isset($_POST["tipoMens"]))
		$tipoMens = $_POST["tipoMens"];
	else
		$tipoMens = "";
                
        if (isset($_POST["tipoMensPara"]))
		$tipoMensPara = $_POST["tipoMensPara"];
	else
		$tipoMensPara = "";
                
        if (isset($_POST["profcodi"]))
		$profcodi = $_POST["profcodi"];
	else
		$profcodi = "";
                
        if (isset($_POST["rowCount"]))
		$rowCount = $_POST["rowCount"];
	else
		$rowCount = "";
        
        if (isset($_POST["opcion"]))
		$opcion = $_POST["opcion"];
	else
		$opcion = "";
                
        if (isset($_POST["menstitu"]))
		$menstitu = $_POST["menstitu"];
	else
		$menstitu = "";
                
        if (isset($_POST["mensdeta"]))
		$mensdeta = $_POST["mensdeta"];
	else
		$mensdeta = "";
                
        if (isset($_POST["menscodi"]))
		$menscodi = $_POST["menscodi"];
	else
		$menscodi = "";
        
        if (isset($_POST["estadoElectronico"]))
		$estadoElectronico = $_POST["estadoElectronico"];
	else
		$estadoElectronico = "AUTORIZADO";
                
        if (isset($_POST["fechaemision_ini"]))
		$fechaemision_ini = $_POST["fechaemision_ini"];
	else
		$fechaemision_ini = " ";
                
        if (isset($_POST["fechaemision_fin"]))
		$fechaemision_fin = $_POST["fechaemision_fin"];
	else
		$fechaemision_fin = " ";


                
	$clientes = new Clientes();
	$clientes->getClientInfo($colegio);
        $clientes->getClients($opci_codi);
	
      
	$alumnos = new Alumnos();	
	$alumnos->user_db=$clientes->get_usuario();
	$alumnos->pass_db=$clientes->get_clave();
	$alumnos->host_db=$clientes->get_host();
	$alumnos->name_db=$clientes->get_dbname();
	
	$agenda = new Agenda();
	$agenda->user_db=$clientes->get_usuario();
	$agenda->pass_db=$clientes->get_clave();
	$agenda->host_db=$clientes->get_host();
	$agenda->name_db=$clientes->get_dbname();
        
        $notificaciones = new Notificaciones();
	$notificaciones->user_db=$clientes->get_usuario();
	$notificaciones->pass_db=$clientes->get_clave();
	$notificaciones->host_db=$clientes->get_host();
	$notificaciones->name_db=$clientes->get_dbname();
        
        $notiUpdate = new NotiUpdate();
	$notiUpdate->user_db=$clientes->get_usuario();
	$notiUpdate->pass_db=$clientes->get_clave();
	$notiUpdate->host_db=$clientes->get_host();
	$notiUpdate->name_db=$clientes->get_dbname();
        
        $notiAll= new Notificacionesall();
	$notiAll->user_db=$clientes->get_usuario();
	$notiAll->pass_db=$clientes->get_clave();
	$notiAll->host_db=$clientes->get_host();
	$notiAll->name_db=$clientes->get_dbname();
	
	
	$representantes = new Representante();
	$representantes->user_db=$clientes->get_usuario();
	$representantes->pass_db=$clientes->get_clave();
	$representantes->host_db=$clientes->get_host();
	$representantes->name_db=$clientes->get_dbname();
        
        $mensajes = new mensajesAll();
	$mensajes->user_db=$clientes->get_usuario();
	$mensajes->pass_db=$clientes->get_clave();
	$mensajes->host_db=$clientes->get_host();
	$mensajes->name_db=$clientes->get_dbname();
        
        $profesores = new profesores();
	$profesores->user_db=$clientes->get_usuario();
	$profesores->pass_db=$clientes->get_clave();
	$profesores->host_db=$clientes->get_host();
	$profesores->name_db=$clientes->get_dbname();
        
        $mensajeNuevo = new mensajeNuevo();
	$mensajeNuevo->user_db=$clientes->get_usuario();
	$mensajeNuevo->pass_db=$clientes->get_clave();
	$mensajeNuevo->host_db=$clientes->get_host();
	$mensajeNuevo->name_db=$clientes->get_dbname();
        
	$mensajeEliminar = new mensajeEliminar();
	$mensajeEliminar->user_db=$clientes->get_usuario();
	$mensajeEliminar->pass_db=$clientes->get_clave();
	$mensajeEliminar->host_db=$clientes->get_host();
	$mensajeEliminar->name_db=$clientes->get_dbname();
        
        $mensajeUpdate = new mensajeUpdate();
	$mensajeUpdate->user_db=$clientes->get_usuario();
	$mensajeUpdate->pass_db=$clientes->get_clave();
	$mensajeUpdate->host_db=$clientes->get_host();
	$mensajeUpdate->name_db=$clientes->get_dbname();
        
        $facturasAutorizadas = new facturasAutorizadas();
	$facturasAutorizadas->user_db=$clientes->get_usuario();
	$facturasAutorizadas->pass_db=$clientes->get_clave();
	$facturasAutorizadas->host_db=$clientes->get_host();
	$facturasAutorizadas->name_db=$clientes->get_dbname();
        
	switch ($opcion)
	{
		case "login_representante":
			$representantes->Login ($username, $password,$tipo_usua);
			echo json_encode($representantes->resultado);
		break;
		case "listar_clientes":
			
			$clientes->getClients($opci_codi);
			$json_colegios = array();
			foreach($clientes->rows as $cliente){
				$json_clientes[] = array("id"=>$cliente['clie_codi'],"texto"=>$cliente['clie_nomb'],"carpeta"=>$cliente['clie_carpeta']);
			}
			$array_users = array ("result"=>$json_clientes);
			echo json_encode($array_users);
		break;
		case "listar_alumnos":	
			$alumnos->getAlumnosRepr($reprcodi,$pericodi);		
			$json_alumnos = array();
			foreach($alumnos->rows as $alumno){
				$json_alumnos[] = array("codigo"=>$alumno['alum_codi'],"nombre"=>$alumno['alum_nomb'],"apellido"=>$alumno['alum_apel']);
			}
			$array_alumnos = array ("result"=>$json_alumnos);
			echo json_encode($array_alumnos);
		break;
		case "mostrar_agenda":	
			$agenda->getAgenda($alumnocodi,$pericodi);	
			$json_agenda = array();
			foreach($agenda->rows as $agendaAlum){
				$json_agenda[] = array("codigoAgenda"=>$agendaAlum['agen_codi'],"tituloAgenda"=>$agendaAlum['agen_titu'],"detalleAgenda"=>$agendaAlum['agen_deta'],"fechaIniAgenda"=>$agendaAlum['agen_fech_ini'],"fechaFinAgenda"=>$agendaAlum['agen_fech_fin'],"estadoAgenda"=>$agendaAlum['agen_esta'],"profcodi"=>$agendaAlum['prof_codi'],"detalleMateria"=>$agendaAlum['mate_deta'],"nombreProfesor"=>$agendaAlum['prof_nomb']);
			}
			$array_agenda = array ("result"=>$json_agenda);
			echo json_encode($array_agenda);
		break;
                case "mostrar_notificaciones":	
			$notificaciones->getNotificaciones($username,$tipo_usua);		
			$json_noti = array();
			foreach($notificaciones->rows as $notiall){
				$json_noti[] = array("noticodi"=>$notiall['noti_codi'],"notiDetaEsta"=>$notiall['noti_deta_esta'],"fechaRegistro"=>$notiall['noti_deta_fech_regi'],"fechaLectura"=>$notiall['noti_deta_fech_lect']);
			}
			$array_noti = array ("result"=>$json_noti);
			echo json_encode($array_noti);
		break;
                case "notificaciones_update":	
			$notiUpdate->updateNoti($username,$tipo_usua);			
			echo json_encode($notiUpdate->resultado);
		break;
                case "notificaciones_all":	
			$notiAll->getNotificacionesAll($username,$tipo_usua);		
			$json_notiall = array();
			foreach($notiAll->rows as $notiallAL){
				$json_notiall[] = array("noti_deta_fech_regi"=>$notiallAL['noti_deta_fech_regi'],"noti_deta_esta"=>$notiallAL['noti_deta_esta'],"noti_tipo_deta"=>$notiallAL['noti_tipo_deta'],"noti_deta"=>$notiallAL['noti_deta'],"noti_deta_codi"=>$notiallAL['noti_deta_codi']);
			}
			$array_notiall = array ("result"=>$json_notiall);
			echo json_encode($array_notiall);
		break;
                case "mensajes_all":	
			$mensajes->getMensajes($op,$reprcodi,$tipoMens,$rowCount);		
			$json_mensall = array();
			foreach($mensajes->rows as $mensajesTodo){
				$json_mensall[] = array("mensajeNombEmisor"=>$mensajesTodo['mens_nomb'],"codigoDe"=>$mensajesTodo['mens_de'],"mensajeTipoEmisor"=>$mensajesTodo['mens_usua_tipo_deta'],"mensajeTitulo"=>$mensajesTodo['mens_titu'],"mensajeDetalle"=>$mensajesTodo['mens_deta'],"mensajeFechaEnvio"=>$mensajesTodo['mens_fech_envi'],"mensajeFechaLect"=>$mensajesTodo['mens_fech_lect'],"mensajeCodigo"=>$mensajesTodo['mens_codi']);
			}
			$array_mensall = array ("result"=>$json_mensall);
			echo json_encode($array_mensall);
		break;
                case "profesores_lista":	
			$profesores->getListaProfesores($alumnocodi,$pericodi);		
			$json_profall = array();
			foreach($profesores->rows as $profesoresTodo){
				$json_profall[] = array("profcodi"=>$profesoresTodo['prof_codi'],"nombreProfesor"=>$profesoresTodo['prof_nombre'],"materia"=>$profesoresTodo['Materia']);
			}
			$array_profall = array ("result"=>$json_profall);
			echo json_encode($array_profall);
		break;
                case "add_message":	
			$mensajeNuevo->addMessage($reprcodi,$tipoMens,$profcodi,$tipoMensPara,$menstitu,$mensdeta);			
			echo json_encode($mensajeNuevo->resultado);
		break;
                case "erase_message":	
			$mensajeEliminar->eraseMessage($menscodi);			
			echo json_encode($mensajeEliminar->resultado);
		break;
                case "update_message":	
			$mensajeUpdate->mensajeLeido($menscodi);			
			echo json_encode($mensajeUpdate->resultado);
		break;
                case "facturas_Autorizadas":	
			$facturasAutorizadas->Facturas($estadoElectronico, $fechaemision_ini,$fechaemision_fin, $reprcodi, $username);	
			$json_facturasall = array();
			foreach($facturasAutorizadas->rows as $facturasTodo){
				$json_facturasall[] = array("codigoFactura"=>$facturasTodo['codigoFactura'],"totalNetoFactura"=>$facturasTodo['totalNetoFactura'],"nombresAlumno"=>$facturasTodo['nombresAlumno'],"codigoAlumno"=>$facturasTodo['codigoAlumno'],"fechaEmision"=>$facturasTodo['fechaEmision'],"estadoElectronico"=>$facturasTodo['estadoElectronico'],"prefijoSucursal"=>$facturasTodo['prefijoSucursal'],"prefijoPuntoVenta"=>$facturasTodo['prefijoPuntoVenta'],"numeroFactura"=>$facturasTodo['numeroFactura']);
			}
			$array_facturasall = array ("result"=>$json_facturasall);
			echo json_encode($array_facturasall);
		break;
	}
?>
