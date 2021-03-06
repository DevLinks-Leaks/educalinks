<?php

	session_start();	 
	include ('../framework/dbconf.php');
	 
	$mens_de = $_SESSION['USUA_DE'];
	$mens_de_tipo = $_SESSION['USUA_TIPO'];
	 
 	$params = array($mens_de,$mens_de_tipo);
	$sql="{call mens_view_para_new(?,?)}";
	
	$mens_view_para_new = sqlsrv_query($conn, $sql, $params); 
	
	$row_mens_view_para_new = sqlsrv_fetch_array($mens_view_para_new);
	$row_count = $row_mens_view_para_new['row_count'];
	
	sqlsrv_next_result($mens_view_para_new);
	
	if ($row_mens_view_para_new = sqlsrv_fetch_array($mens_view_para_new))
	{   echo '	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  &nbsp;<i class="fa fa-envelope-o"></i>
				  <span id="span_badge_sms_header1" class="label label-success">'.$row_count.'</span>
				</a>
				<ul class="dropdown-menu">
					<li class="header" id="badge_sms_header2" >Tienes '.$row_count.' mensaje(s)</li>
					<li>
						<!-- inner menu: contains the actual data -->
						<ul id="badge_sms_detail" name="badge_sms_detail" class="menu">';
		do{ $cc +=1;
			if ($cc <= 5)
			{   
				switch ($row_mens_view_para_new['mens_de_tipo']){
					case 'A':
						$ruta=$_SESSION['ruta_foto_alumno'];
					break;
					case 'R':
						$ruta=$_SESSION['ruta_foto_repre'];
					break;
					case 'D':
						$ruta=$_SESSION['ruta_foto_docente'];
					break;
					case 'K':
						$ruta=$_SESSION['ruta_foto_admin'];
					break;
				}
				$imagen_user = $ruta.$row_mens_view_para_new['mens_de'].'.jpg';
				if (file_exists($imagen_user))
					$imagen_user = $ruta.$row_mens_view_para_new['mens_de'].'.jpg';
				else
					$imagen_user = $_SESSION['foto_default'];
				echo "
					<li>
						<a data-toggle='modal' style=\"cursor: pointer;\"
                          data-target='#modal_leer_ext' onclick=\"js_funciones_mensajes_read_from_navbar('modal_main_ext','mensajes_info.php','mens_codi=".$row_mens_view_para_new['mens_codi']."&op=2');\">
							<div class=\"pull-left\">
								<img src=\"".$imagen_user."?".$rand."\" class=\"img-circle\" alt=\"User Image\">
							</div>
							<h4>
								".$row_mens_view_para_new['mens_titu']."
								<small><i class='fa fa-clock-o'></i>".date_format($row_mens_view_para_new['mens_fech_envi'],'d/m/Y')."</small>
							</h4>
							<p>".$row_mens_view_para_new['mens_para_nomb']."</p>
						</a>
					</li>";
			}
		}while ($row_mens_view_para_new = sqlsrv_fetch_array($mens_view_para_new) );
		echo 			'</ul>
					</li>
					<li class="footer"><a href="mensajes.php">Ver todos los mensajes</a></li>
				</ul>';
	}
	else
	{   echo '
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  &nbsp;<i class="fa fa-envelope-o"></i>
				  <span id="span_badge_sms_header1" class="label"><span id="badge_sms_header1"></span></span>
				</a>
				<ul class="dropdown-menu">
					<li class="header" id="badge_sms_header2" >No tienes mensajes nuevos</li>
					<li>
					</li>
					<li class="footer"><a href="mensajes.php">Ver todos los mensajes</a></li>
				</ul>';
	}