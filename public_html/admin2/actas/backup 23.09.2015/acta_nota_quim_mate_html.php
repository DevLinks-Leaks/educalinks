<?php
	//Importando librerías necesarias
	require_once ('funciones.php');
	require_once ('../../framework/dbconf.php');	
	require_once ('../../framework/funciones.php');	
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="estilos.css" />
	<title>Educalinks | <?php echo para_sist(2); ?></title>
</head>
<body>
<?php
	//Iniciando sesión
	session_start();
	
	//Constantes necesarias para este reporte
	define ('PORC_PARCIAL', 0.80);
	define ('PORC_EXAMEN', 0.20);
	
	//Obteniendo parámetros
	$curs_para_codi=$_GET['curs_para_codi'];
	$curs_para_mate_codi=$_GET['curs_para_mate_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	
	$una=true;
	if ($curs_para_mate_codi==-1)
	{
		$una=false;
		$curs_para_codi_aux=$curs_para_codi;
	}
	else
	{
		$curs_para_codi_aux=-1;
	}
		
	//Consulta de calificaciones
	$sql="{call curs_peri_mate_view (?)}";
	$params = array($curs_para_codi_aux);
	$stmt_all = sqlsrv_query($conn, $sql, $params);
	
	while (($row_all=sqlsrv_fetch_array($stmt_all)) or ($una))
	{
		if ($una)
			$una=false;
		else
			$curs_para_mate_codi=$row_all['curs_para_mate_codi'];
	
	
		//Consulta de calificaciones
		$sql="{call acta_nota_quim_mate (?,?)}";
		$params = array($curs_para_mate_codi, $peri_dist_codi);
		$stmt = sqlsrv_query($conn, $sql, $params);
	
		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
	
		
		//Columnas y filas
		$row=array();
		unset($datos);
		unset($aux_col);
		unset($aux_fil);
		$i=0;
		while ($row = sqlsrv_fetch_array($stmt))
		{
			$aux_col[$i][0] = $row['peri_dist_codi'];
			$aux_col[$i][1] = $row['peri_dist_deta'];
			$aux_col[$i][2] = $row['nota_final'];
			$aux_fil[$i][0] = $row['alum_curs_para_mate_codi'];
			$aux_fil[$i][1] = $row['alum_apel'];
			$aux_fil[$i][2] = $row['alum_nomb'];
			$datos[]=$row;
			$i++;
		}
		
		//Columnas finales
		$columnas = arrayUnique ($aux_col);
		
		//Filas finales
		$filas = arrayUnique ($aux_fil);
		
		//Quimestre y Parcial
		$params = array($peri_dist_codi);
		$sql="{call peri_dist_peri_codi (?)}";
		$cab_view = sqlsrv_query($conn, $sql, $params);  
		$cab_row=sqlsrv_fetch_array($cab_view);
		
		//Datos del profesor
		$params = array($curs_para_mate_codi);
		$sql="{call prof_curs_para_mate_cons (?)}";
		$dat_profesor = sqlsrv_query($conn, $sql, $params);  
		$prof_row=sqlsrv_fetch_array($dat_profesor);
		
		//Datos de la materia
		$params = array($curs_para_mate_codi);
		$sql="{call curs_para_mate_info(?)}";
		$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
		$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
		
		//Datos del curso
		$params = array($curs_para_codi);
		$sql="{call curs_para_info(?)}";
		$curs_info = sqlsrv_query($conn, $sql, $params);
		$row_curs_info = sqlsrv_fetch_array($curs_info);
		
		//Tabla de notas cualitativas
		$params = array('C', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
?>
<page>
	<h1 class="titulo_1">UNIDAD EDUCATIVA <?= $_SESSION['cliente']; ?></h1> 
    <h2 class="titulo_2">ACTA DE CALIFICACIONES DEL <? echo $cab_row['nivel_2']; ?></h2>
    <h2 class="titulo_2">AÑO LECTIVO <? echo $_SESSION['peri_deta']; ?></h2>
    <table id="info_header" class="informacion">
        <tr>
	        <td width="70%"><strong>NIVEL:</strong> <? echo $row_curs_info['nive_deta']; ?></td>
            <td><strong>FECHA:</strong> <? echo date("d/m/y"); ?></td>
        </tr>
        <tr>
	        <td><? echo $row_curs_peri_info['curs_deta'].' '.$row_curs_peri_info['para_deta']; ?></td>
            <td></td>
        </tr>
        <tr>
	        <td><strong>ASIGNATURA:</strong> <? echo $row_curs_peri_info['mate_deta']; ?></td>
            <td><strong>PROFESOR:</strong><? echo $prof_row["prof_nomb"]." ".$prof_row["prof_apel"]; ?></td>
        </tr>
    </table>
    <table id="matriz">
        <thead>
        <tr>
            <th rowspan="2" width="2%">#</th>
            <th rowspan="2" width="20%">Nombres</th>
            <? 
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]!='EXAMEN')
                {
            ?>
                    <th class="rotate" <? echo 'colspan="2"'; ?> width="6%">
                        <div>
                            <span>
                                <? echo $columnas[$i][1]; ?>
                            </span>
                        </div>
                    </th>
            <?
                }
            }
            ?>
            <th class="rotate" colspan="2" width="6%">
                <div>
                    <span>PROMEDIO<br/>PARCIAL</span>
                </div>
            </th>

            <th class="rotate" rowspan="2" width="6%">
                <div>
                    <span>PORC. PROM.<br/> PARCIAL 80%</span>
                </div>
            </th>
             <? 
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]=='EXAMEN')
                {
            ?>
                <th class="rotate" width="6%" <? echo 'colspan="2"'; ?> width="3%">
                    <div>
                        <span>
                            <? echo $columnas[$i][1]; ?>
                        </span>
                    </div>
                </th>
            <?
                }
            }
            ?>
            <th class="rotate" rowspan="2" width="6%">
                <div>
                    <span>PORC. PROM.<br/> EXAMEN 20%</span>
                </div>
            </th>

            <th class="rotate" colspan="2" width="6%">
                <div>
                    <span>NOTA DEL<br /> QUIMESTRE</span>
                </div>
            </th>

            <th rowspan="2" width="10%">FALTAS INJUSTIFICADAS</th>
            <th rowspan="2">RECOMENDACIONES</th>
            <th rowspan="2">PLAN DE MEJORAMIENTO</th>
        </tr>
        <tr>
            <? 
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]!='EXAMEN')
                {
                    echo '<th>C</th>';
                    echo '<th>N</th>';
                }
            }
            ?>
            <th>C</th>
            <th>N</th>
            <? 
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]=='EXAMEN')
                {
                    echo '<th>N</th>';
                    echo '<th>C</th>';
                }
            }
            ?>
            <th>C</th>
            <th>N</th>
         </tr>
         </thead>
         <? 
         $sum_curso=0;
         $prom_curso=0;
         $cont_alumnos=0;
		 unset($notas_prom);
         for ($i=0;$i<count($filas);$i++) 
         {
         ?>
         <tr>
            <td class="centrar"><? echo $i+1; ?></td>
            <td><? echo $filas[$i][1].' '.$filas[$i][2]; ?></td>
            <? 
            $nota_final=0;
            $acum_parcial=0;
            $cont_parcial=0;
            for ($j=0;$j<count($columnas);$j++) 
            {
                if ($columnas[$j][1]!='EXAMEN')
                {
                    $nota_parcial=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_curs_para_mate_codi', 'peri_dist_codi');
                    echo '<td class="sombreado centrar" style="text-align: center;">'.notas_prom_quali(1,'C',$nota_parcial).'</td>';
                    echo '<td class="centrar">'.number_format($nota_parcial,2,'.',',').'</td>';
                    $cont_parcial++;
                    $acum_parcial=$acum_parcial+$nota_parcial;
                }
            }
            echo '<td class="sombreado centrar">'.notas_prom_quali(1,'C',($acum_parcial/$cont_parcial)).'</td>';
            echo '<td class="centrar">'.round(($acum_parcial/$cont_parcial),2).'</td>';

            $nota_final_parcial=($acum_parcial/$cont_parcial)*PORC_PARCIAL;
            echo '<td class="centrar">'.round($nota_final_parcial,2).'</td>';

            for ($j=0;$j<count($columnas);$j++) 
            {
                if ($columnas[$j][1]=='EXAMEN')
                {
                    $nota_examen=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_curs_para_mate_codi', 'peri_dist_codi');
                    echo '<td class="sombreado centrar">'.notas_prom_quali(1,'C',$nota_examen).'</td>';
                    echo '<td class="centrar">'.number_format($nota_examen,2,'.',',').'</td>';
                }
            }
            $nota_final_examen=$nota_examen*PORC_EXAMEN;
            echo '<td class="centrar">'.number_format($nota_final_examen,2,'.',',').'</td>';

            $nota_final=round($nota_final_examen,2)+round($nota_final_parcial,2);
            echo '<td class="sombreado centrar">'.notas_prom_quali(1,'C',$nota_final).'</td>';
            echo '<td class="centrar">'.number_format($nota_final,2,'.',',').'</td>';		
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';

			$cont_alumnos++;
			$sum_curso=$sum_curso+$nota_final;
			
			$notas_prom[]=$nota_final;
            ?>
         </tr>
         <?
         }
         $prom_curso=$sum_curso/$cont_alumnos;
         ?>
        <tr>
            <td colspan="10"></td>
            <td colspan="4">
            	<strong>PROMEDIO DEL CURSO:</strong>
			</td>
            <td class="sombreado centrar">
            	<strong><? echo notas_prom_quali(1,'C',$prom_curso); ?></strong>
			</td>
            <td class="centrar">
            	<strong><? echo number_format(round($prom_curso,2),2,'.',','); ?></strong>
			</td>
            <td colspan="3"></td>
        </tr>
    </table>
    <table id="equi_cuali">
        <thead>
			<tr>
                <th>CUALITATIVA</th>
                <th>CUANTITATIVA</th>
                <th>ABREV.</th>
                <th>Nº ESTUDIANTES</th>
                <th>PORCENTAJE</th>
			</tr>
        </thead>
        <tbody>
			<?php  
			while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) 
			{ 
			?>
          <tr>
            <td>
				<?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']; ?>
			</td>
            <td class="centrar">
				<?= number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], 2, '.', ''); ?> - <?= number_format($row_nota_peri_cual_tipo_view['nota_peri_cual_fin'], 2, '.', ''); ?>
			</td>
            <td class="centrar">
				<?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?>
            </td>
            <td class="centrar">
				<? echo contar_notas_num($notas_prom, $row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], $row_nota_peri_cual_tipo_view['nota_peri_cual_fin']); ?>
			</td>
            <td class="centrar">
				<? echo round(contar_notas_porc($notas_prom, $row_nota_peri_cual_tipo_view['nota_peri_cual_ini'], $row_nota_peri_cual_tipo_view['nota_peri_cual_fin']),2).' %'; ?>
			</td>
          </tr>
          <? } ?>
        </tbody>
       </table>
       <table id="info_footer" class="informacion">
        <tr>
	        <td>
            	<strong>Profesor:</strong>
                ........................................................
			</td>
            <td>
            	<strong>Fecha:</strong>
                ........................................................
			</td>
		</tr>
		</table>
</page>
<div class="page-break"></div>
<? 
	} 
?>
</body>
</html>