<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->
<?php 
	//Set no cachinh
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
	session_start(); 
    
    include ('../framework/funciones.php');
    //Valida la Sesion este activa
    session_activa(1); 
     
    include ('../framework/dbconf.php');
   

	
?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Educalinks | <?php echo para_sist(2); ?></title> 
        <link rel="SHORTCUT ICON" href="http://108.179.196.99/educalinks/imagenes/logo_icon.png"/>
        <link href="../theme/css/base/bootstrap-combined.min.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/base/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/main.css" media="screen" rel="stylesheet" type="text/css">
<link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
        <link href="../framework/ckeditor/sample.css" rel="stylesheet">   
        <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
		<link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
        <link href="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.css" rel="stylesheet" type="text/css" />
         

        <script src="../framework/funciones.js"></script>
	    <script src="../framework/funciones_mensajes.js"></script> 
    	<script src="../framework/ckeditor/ckeditor.js"></script>
        <script src="../theme/js/modernizr.custom.js"></script>
		<script src="../theme/jquery1_11/external/jquery/jquery.js"></script>
        <script src="../theme/js/bootstrap.js"></script>
        <script src="../theme/js/moment.min.js"></script>
    
        <script src="../theme/js/effects.js"></script>
        <script src="../theme/jquery1_11/jquery-ui.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>
        
        <script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>
        
        
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=201;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
 
			<div class="section_side" id="sidePanel">
            
       <section class="main">
        
        <div class="ingenium">
          <img src="../theme/images/logo_ingenium.png">
        </div>

          <div class="contenedor">
        <div class="logo"> 
          <img src="<?= $_SESSION['ruta_foto_logo_web'];?>" alt="">
        </div>
        <h5>Unidad Educativa</h5>
        <h4><?php echo para_sist(3); ?></h4>
        </div>
      </section>
            	
				<? session_start();include ('../framework/dbconf.php');?>
				<ul class="menu_main">
					<li>
						<a href="index.php"  <? if ($Menu==0) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="active"  alt="Ir al inicio"> 
							<span class="icon-home icon"></span>
							<div class="text"><h4>Inicio</h4></div>
						</a>
					</li>
                    <?php if (permiso_activo(2)){?>
                    <li>
                    <div class=" panel-menu">
                        <div class="panel-heading ">
                          <div class="panel-title">
                            <a data-toggle="collapse"  data-parent="#accordion" href="#alumnos" class="collapsed">
                              <span class="icon-users icon"></span>
                            <div class="text"><h4>Alumnos</h4></div>
                            </a>
                          </div>
                        </div>
                        <div id="alumnos" class="panel-collapse collapse <? if (substr($Menu,0,1)<>1)  echo 'in'; ?>">
                          <div class="panel-body">
                            
                            <ul>
                            	<?php if (permiso_activo(7)){?>
                                <li>
                                            <a <? if ($Menu==101) echo 'class="active"'; ?>href="../admin/alumnos_add.php">Inscripcion </a> 
                                </li>
                                <?php }if (permiso_activo(8)){?>
                                <li>
                                            <a <? if ($Menu==102) echo 'class="active"'; ?>href="../admin/alumnos_main.php">Alumnos</a> 
                                </li>
                                <?php }if (permiso_activo(9)){?>
                                <li>
                                            <a <? if ($Menu==103) echo 'class="active"'; ?>href="../admin/alumnos_repre_main.php">Representantes</a> 
                                </li>
                                <?php }if (permiso_activo(77)){?>
                                <li>
                                <a <? if ($Menu==104) echo 'class="active"'; ?>href="../admin/alumnos_bloqueados_main.php">Bloquear Alumno</a> 
                                </li>
                                <?php }if (permiso_activo(83)){?>
                                <li>
                                <a <? if ($Menu==105) echo 'class="active"'; ?>href="../admin/alum_matri_deuda_main.php">Activar deuda</a> 
                                </li>
                                <?php }?>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
                    </li>
                    <?php }?>
                    <?php if (permiso_activo(3)){?>
					<li>
                    	<div class=" panel-menu">
                            <div class="panel-heading ">
                              <div class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#cursos" class="collapsed" >
                                  <span class="icon-books icon"></span>
                                <div class="text"><h4>Cursos</h4></div> 
                                </a>
                              </div>
                            </div>
                            <div id="cursos" class="panel-collapse collapse <? if (substr($Menu,0,1)<>2)  echo 'in'; ?> ">
                              <div class="panel-body">
                                
                                <ul>
                                	<?php if (permiso_activo(10)){?>
                                    <li>
                                                <a <? if ($Menu==201) echo 'class="active"'; ?> href="cursos_paralelo_main.php">Cursos Paralelo</a> 
                                    </li>
                                    <?php }if (permiso_activo(62)){?>
                                     <li>
                                                <a <? if ($Menu==206) echo 'class="active"'; ?> href="cursos_notas_permisos_main.php">Notas Permisos</a> 
                                    </li>
                                    <?php }if (permiso_activo(11)){?>
                                     <li>
                                                <a <? if ($Menu==202) echo 'class="active"'; ?> href="cursos_cursos_main.php">Cursos</a> 
                                    </li>
                                    <?php }if (permiso_activo(12)){?>
                                    <li>
                                                <a <? if ($Menu==203) echo 'class="active"'; ?>  href="cursos_materias_main.php">Materias</a> 
                                    </li>
                                   
                                    <?php }if (permiso_activo(13)){?>
                                    <li>
                                                <a <? if ($Menu==204) echo 'class="active"'; ?> href="cursos_aulas_main.php">Aulas</a> 
                                    </li>
                                    <?php }if (permiso_activo(14)){?>
                                     <li>
                                                <a <? if ($Menu==205) echo 'class="active"'; ?> href="cursos_admin_paralelo_main.php">Paralelos</a> 
                                    </li>
                                    
                                    <?php }if (permiso_activo(67)){?>
                                     <li>
                                                <a <? if ($Menu==207) echo 'class="active"'; ?> href="profesores_main.php">Profesores</a> 
                                    </li>
                                    <?php }?>
                                </ul>
                                
                                
                                
                              </div>
                            </div>
                      </div>
					</li>
                    <?php }?>
                    <?php if (permiso_activo(4)){?>
					<li>
						<div class=" panel-menu">
                        <div class="panel-heading ">
                          <div class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#administracion" class="collapsed">
                              <span class="icon-parent icon"></span>
                            <div class="text"><h4>Administracion</h4></div>
                            </a>
                          </div>
                        </div>
                        <div id="administracion" class="panel-collapse collapse <? if (substr($Menu,0,1)<>4)  echo 'in'; ?> ">
                          <div class="panel-body">
                            
                            <ul>
                            	<?php if (permiso_activo(15)){?>
                                <li>		<a <? if ($Menu==401) echo 'class="active"'; ?>  href="roles_main.php">Roles</a> 
                                </li>
                                <?php }if (permiso_activo(16)){?>
                                <li>		<a <? if ($Menu==402) echo 'class="active"'; ?>  href="usuarios_main.php">Usuarios</a> 
                                </li>
                                <?php }if (permiso_activo(71)){?>
                                <li>		<a <? if ($Menu==407) echo 'class="active"'; ?>  href="reset_pass.php">Reseteo de Clave</a> 
                                </li>
                                <?php }if (permiso_activo(17)){?>
                                <li>
                                            <a <? if ($Menu==403) echo 'class="active"'; ?>   href="admin_periodos.php">Periodos</a> 
                                </li>
                                <?php }if (permiso_activo(18)){?>
                              <li>
                                            <a <? if ($Menu==404) echo 'class="active"'; ?>   href="admin_parametos.php">Parametros Generales</a> 
                              </li>
                              <?php }if (permiso_activo(19)){?>
                                <li>
                                            <a <? if ($Menu==405) echo 'class="active"'; ?>   href="admin_auditoria.php">Auditoria</a> 
                                </li>
                                <?php }if (permiso_activo(20)){?>
                                <li>
                                            <a <? if ($Menu==406) echo 'class="active"'; ?>   href="admin_permisos.php">Permisos</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(72)){?>
                                <li>
                                            <a <? if ($Menu==408) echo 'class="active"'; ?>   href="comportamiento.php">Parámetros de comportamiento</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(86)){?>
                                <li>
                                            <a <? if ($Menu==409) echo 'class="active"'; ?>   href="importacion_datos.php">Importación de datos</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(84)){?>
                                <li>
                                            <a <? if ($Menu==410) echo 'class="active"'; ?>   href="para_sistema_main.php">Parámetros del sistema</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(87)){?>
                                <li>
                                            <a <? if ($Menu==411) echo 'class="active"'; ?>   href="usua_pass_main.php">Usuarios y Claves</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(159)){?>
                                <li>
                                            <a <? if ($Menu==412) echo 'class="active"'; ?>   href="cata_sistema_main.php">Catálogo del sistema</a> 
                                </li>
                                <?php }?>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
					</li>
			 		<?php }?>
                    
                    <?php if (permiso_activo(66)){?>
					<li>
						<div class=" panel-menu">
                        <div class="panel-heading ">
                          <div class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#reportes" class="collapsed">
                              <span class="icon-print icon"></span>
                            <div class="text"><h4>Reportes</h4></div>
                            </a>
                          </div>
                        </div>
                        <div id="reportes" class="panel-collapse collapse <? if (substr($Menu,0,1)<>6)  echo 'in'; ?> ">
                          <div class="panel-body">
                            
                            <ul>
                              <li>
                              	<a <? if ($Menu==602) echo 'class="active"'; ?>   href="cursos_paralelo_profe_listas_main.php">Reportes Profesores</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==603) echo 'class="active"'; ?>   href="cursos_paralelo_peri_listas_main.php">Reportes Cursos</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==604) echo 'class="active"'; ?>   href="hora_aten_repr_listas_main.php">Reportes Citas Profesores</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==605) echo 'class="active"'; ?>   href="alum_matri_main.php">Reportes Alumnos Matriculados</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==606) echo 'class="active"'; ?>   href="report_gene.php">Reportes Generales</a> 
                              </li>
                               <?php if (permiso_activo(76)){?>
                                <li>
                                  <a <? if ($Menu==607) echo 'class="active"'; ?>   href="report_gene_actas.php">Actas</a> 
                                </li>
                                <?php }?>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
					</li>
			 		<?php }?>
                    <?php if (permiso_activo(5)){?>
					<li>
						<a href="../help/MANUAL_ADM.pdf" target="_blank" class="section_califications link_menu" alt="Ver Calificaciones">
							<span class="icon-signup  icon"></span>
							<div class="text"><h4>Ayuda</h4></div> 
						</a>
					</li> 
                    <?php }?>
				</ul>
			</div> 

			<div id="mainPanel" class="section_main">
            
            <div class="header">

                <a id="btn" href="#" > <span class=" icon-menu"> </span> Mostrar / Ocultar Menu</a> 
                
 				
                 <div  style=" position:absolute;left: 35%;display:block;width: 150px;top:8px;">                  
                    <button   data-toggle="modal" data-target="#ModalPeriodoActivo" style=" width:200px; height:40px;">
                     Peridodo Activo <?= $_SESSION['peri_deta']; ?>
                    </button> 
                 </div>
 
                <div class="userbar dropdown">
						
							<ul>
								<li class="userProfile">
										<a class="profile" href="#" data-toggle="dropdown"  >
										
												<div class="photo">
													<img src="<?= $_SESSION['ruta_foto_usuario'];?>admin.jpg" alt="user" style=" height:60px; width:60px;">
												</div>
												<div class="username">
													<h5>Bienvenido,</h5>
													<?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?> <b>(<?= $_SESSION['usua_codi']; ?></b>)
												</div>
											
										</a>
										<ul class="dropdown-menu" role="menu" >
											<li><a href="admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li>								
											<li><a href="admin_pass.php"> <span class="li_pass">Cambiar password</span></a></li>
											<li><a href="admin_info.php"> <span class="li_user">Ver Información</span></a></li>
											<li><a href="../salir.php"><span class="li_logout">Cerrar Sesión</span></a></li>

										</ul>
									</li>

								<li class="userButtons">
                                	<ul>
                                    <li>
								 
											<div id="mens_alert" >
											<?php include ('script_mens_view.php'); ?>
                                       		</div>
                                    </li>
                                     <li>
								 
											<div id="mens_alert" >
											<a  id="link_cards" class="button" href="../finan/main.php" target="_blank">
                                                <img src="../theme/images/icons/ico_card.png" border="0" title="Sistema Financiero">
                                            </a>
                                       		</div>
                                    </li>
                                    </ul>
								</li>
							</ul>								
						</div>
            </div>
				
<!--
        <div class="optionbar">
        <span class="icon-earth icon"></span><span>Su ubicación:</span>
               <nav class="menu_breadcrumb">
                  <ul>
                    
                    <li><a href="">Inicio</a></li>
                    <li><a href="" class="active">CurrentPage</a></li>
                  </ul>
               </nav>
        </div>
-->
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
     <?php 	
				   
				   
				include ('../framework/dbconf.php');
				session_start();
				  
				  
				if(isset($_GET['curs_para_mate_codi'])){
					 $curs_para_mate_codi=$_GET['curs_para_mate_codi'];
				}
				
				$PERI_CODI = $_SESSION['peri_codi'];
						
			 	 
				$params = array($curs_para_mate_codi);
				$sql="{call curs_peri_mate_info(?)}";
				$curs_peri_mate_info = sqlsrv_query($conn, $sql, $params);
				$row_curs_peri_mate_info = sqlsrv_fetch_array($curs_peri_mate_info);
				
				  
			 ?>
			<div class="title" style="width: 100%;">
            	<h4><span class="icon-books icon"></span> <?= $row_curs_peri_mate_info['curs_deta'];?> - <?= $row_curs_peri_mate_info['para_deta'];?> - <?= $row_curs_peri_mate_info['mate_deta'];?></h4>
                
               </div>        
            <div class="options">

            <ul>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                          <script src="js/funciones_notas.js"></script>
                          <div  id="notas_view">
                            <?php 	include('cursos_paralelo_notas_mate_main_deta_view.php') ?>
                          </div>
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
    <!-- Modal SELECCION DE PERIODO -->
    <div class="modal fade" id="ModalPeriodoActivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">SELECCION DE PERIODO ACTIVO</h4>
          </div>
          <div class="modal-body">
           
                <table>
                    <tr>
                        <td>PERIODOS</td>                        
                        
                    </tr>
                            
                     <? 	
						$params = array();
						$sql="{call peri_view()}";
						$peri_view = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    
                     <? while($row_peri_view = sqlsrv_fetch_array($peri_view)){ ?>
                     <tr>    
     					<td height="50"><button type="button" class="btn btn-primary" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_deta"]; ?></button></td>
                    </tr>
                    <?php  } ?>


                     
                   
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
          </div>
        </div>
      </div>
    </div>
    
<!-- InstanceBeginEditable name="EditRegion4" -->EditRegion4<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>