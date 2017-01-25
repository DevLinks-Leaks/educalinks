<?php
	session_start();
    include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html style="-webkit-print-color-adjust:exact;">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Educalinks |  <?php echo para_sist(2); ?></title>
        <link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
        <link href="../theme/css/main.css" rel="stylesheet" type="text/css" />
        <link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css" />
        <script src="../framework/funciones.js"></script>

</head>
<body>
  <table id="example" class="display" cellspacing="0" width="100%">
<?php

	$curs_para_codi=$_GET['curs_para_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];

	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);
	$cab_row=sqlsrv_fetch_array($cab_view);

	$params_est = array($curs_para_codi);
	$sql_est="{call alum_curs_para_view(?)}";
	$alumnos_view = sqlsrv_query($conn, $sql_est, $params_est);

	/*Alumnos*/
  $params = array($curs_para_codi);
  $sql ="{call alum_curs_para_view(?)}";
  $alumnos_view = sqlsrv_query($conn, $sql, $params); 
  while ($alumno = sqlsrv_fetch_array($alumnos_view))
  { $alum_codi=$alumno['alum_codi'];
    if( $alumno['alum_curs_para_estado'] != 'I' )
    {  unset($prom);
        unset($prom_cc);
        /*Alumnos*/
        $params = array($alum_codi);
        $sql="{call alum_info(?)}";
        $alum_info = sqlsrv_query($conn, $sql, $params);
        $row_alum_info = sqlsrv_fetch_array($alum_info);
        
        /*Notas*/
        $params = array($peri_dist_codi, 'C');
        $sql="{call peri_dist_padr_libr_view(?,?)}";
        $peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
        $peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);
        $params = array($alum_codi,$peri_dist_codi,'C');
        $sql="{call alum_nota_peri_dist_view(?,?,?)}";
        $alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
        $row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view);
        $num_cols = $row_alum_nota_peri_dist_view['CC_COLUM'];
        $CC_COLUM=$row_alum_nota_peri_dist_view['CC_COLUM'];
        sqlsrv_next_result($alum_nota_peri_dist_view);
        sqlsrv_next_result($alum_nota_peri_dist_view); 
        
        /*Ancho de asignaturas*/
        $asign_ancho = 100-($num_cols*6)-13;
        /*Calificaciones*/
        $calificaciones = '
        <table width="100%" border="1" cellpadding="1" cellspacing="0">
          <tr>
          <td class="cabecera_notas" align="center" width="'.$asign_ancho.'%">ASIGNATURAS</td>';
        $cabecera = array();
        while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view)) 
        {   $calificaciones.='<td class="cabecera_notas centrar" width="6%">'.$row_peri_dist_padr_view['peri_dist_deta'].'</td>';
          if( $row_peri_dist_padr_view['peri_dist_nota_tipo'] == 'VW' )
          {   $cabecera[] = str_replace('%', '', $row_peri_dist_padr_view['peri_dist_abre'] );
          }else
          { $cabecera[] = 100;
          }
        }
        $calificaciones.='<td class="cabecera_notas centrar" width="6%">CUALITATIVA</td>';
        $calificaciones.='</tr>';
        while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) 
        { 
          $cc +=1;
          $calificaciones.='<tr><td class="cuerpo_notas">';
          if ($row_alum_nota_peri_dist_view["mate_padr"] >0)
            $calificaciones.='   ';
            if ($row_alum_nota_peri_dist_view["mate_padr"]>0)
            { $calificaciones.= ucwords(mb_strtolower($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8'));
            }
            else
            { $calificaciones.= ' '.mb_strtoupper($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8');
            } 
          $calificaciones.='</td>';
          $CC_COLUM_index =0; 
          while($CC_COLUM_index <= $CC_COLUM )  
          {   $calificaciones.='<td width="6%" class="cuerpo_notas centrar ';
            if ($row_alum_nota_peri_dist_view['mate_tipo']=='C')
            { $perc = (int)$cabecera[ $CC_COLUM_index ];
              $mayor_aceptable = ( ( 7 * $perc ) / 100 );
              if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12] ) < $mayor_aceptable )
              {   $calificaciones.= ' mala_nota';
              }
            }
            $calificaciones.= '">';
            if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0 and $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<>null)
            { switch ($row_alum_nota_peri_dist_view['mate_tipo'])
              { case "C":
                $calificaciones.= (truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12])==0)?'':truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
                if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0) and ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<$mayor_aceptable))
                { $calificaciones.= '*';
                }
                break;
                case "D":
                $calificaciones.= notas_prom_quali($_SESSION['peri_codi'],'D',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
                break;
                case "P":
                $calificaciones.= notas_prom_quali($_SESSION['peri_codi'],'P',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
                break;
              }
            }
                
            if ($row_alum_nota_peri_dist_view["mate_prom"] =='A')
            { $prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1; 
              $prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
             }
            $calificaciones.='</td>';
            $CC_COLUM_index+=1;
          }
          $calificaciones.='<td class="cuerpo_notas centrar" width="6%">'.$row_alum_nota_peri_dist_view['nota_peri_cual_refe'].'</td>';
          $calificaciones.='</tr>';
        }
        /*Promedios en columna*/
        $calificaciones.='<tr>';
        $calificaciones.='<td class="cuerpo_notas"> <b>PROMEDIO</b></td>';
        $CC_COLUM_index =0; 
        while($CC_COLUM_index <= $CC_COLUM )  
        { $calificaciones.='<td class="cuerpo_notas centrar';
          $perc = (int)$cabecera[ $CC_COLUM_index ];
          $mayor_aceptable = ( ( 7 * $perc ) / 100 );
          if( ( $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12] ) < $mayor_aceptable )
          {   $calificaciones.=' mala_nota_escuela_liceopanamericano';
          }
          $calificaciones.='">';
          $calificaciones.= (truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]))==0)?'':truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]));
          $prom_rend=$prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index];
          $calificaciones.='</td>';
          $CC_COLUM_index+=1;
        }
        $calificaciones.='<td class="cuerpo_notas centrar">'.notas_prom_quali($_SESSION['peri_codi'],'C',$prom_rend).'</td>';
        $calificaciones.='</tr>';
        $calificaciones.='</table>';

        $pdf->setCodigo($row_alum_info['alum_codi']);
        $pdf->setNombre($row_alum_info['alum_nomb']);
        $pdf->setApellido($row_alum_info['alum_apel']);
        $pdf->setPeriodo($cab_row['nivel_2']);
        $pdf->setCurso($row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"');
        $pdf->AddPage();
}