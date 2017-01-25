<!DOCTYPE html>
<html>
    <?php
    	session_start();   
    ?>
    <head>   
     <?php
		//Set no cachinh
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

        /*$domain=$_SERVER['HTTP_HOST'];
        $serverName = "certuslinks.com";         
        $Database= "Certuslinks_admin"; 
        $UID= "sa";$PWD= "R3dlink5";

        $connectionInfo = array("Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD, "CharacterSet"=>"UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn === false){
            echo "Error in connection.\n";
            die( print_r( sqlsrv_errors(), true));
        }*/
		include("framework/dbconf_main.php");
		include("framework/funciones.php");
		
        $params = array($domain);
        $sql="{call dbo.clie_info_domain(?)}";
        $resu_login = sqlsrv_query($conn, $sql, $params);  
        $row = sqlsrv_fetch_array($resu_login);
        $_SESSION['host']=$row['clie_instancia_db'];
        $_SESSION['user']=$row['clie_user_db'];
        $_SESSION['pass']=$row['clie_pass_db'];
        $_SESSION['dbname']=$row['clie_base'];

	?>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Educalinks </title>
    <link rel="shortcut icon" href="../favicon.ico"> 
    <?php include("head.php");?>
    <?php include("scripts.php");?>

    <link href="theme/css/main.css" rel="stylesheet" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="theme/js/select.js"></script>


    
</head>

    <body class="login" style="background:url(<?= background_index($_SESSION['codi']);?>); ">
        <div class="row">
            <img src="imagenes/clientes/<?= $_SESSION['directorio'];?>/logo_inicial_long.png" alt="">
        </div>
        <div class="row">

        </div>
        <div class="box box-solid box-default">
            
                

                <div class="container">
			
                <section class="main">
<div style="max-width:320px; align-content:center; margin:0 auto;">
                        
                     </div>
                 	 <h4></h4>
                    

                
                

                <section class="log">
                <div class="title">
                    <h4>Seleccione el módulo</h4>
                </div>

                <p style="background-color: #e74c3c;"> 

                            <?php 
				session_start();
				if (isset($_SESSION['erro'])){?>
                    <div class="comp_index">
                        <label><?php echo $_SESSION['erro']?></label>
                    </div>
                <?php }?>
                </p>
                    <form id="frm_modulo" method="POST">

                        <!--<table width="100%">
                            <tr>
                                <td><button onClick="SeleccionarModulo(1)">ACADÉMICO</button></td>
                                <td><?php if($_SESSION['rol_finan']==1){?><button onClick="SeleccionarModulo(2)">FINANCIERO</button><?php }?></td>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                            <tr>
                                <td><?php if($_SESSION['rol_medico']==1){?><button onClick="SeleccionarModulo(3)">MÉDICO</button><?php }?></td>
                                <td><?php if($_SESSION['rol_biblio']==1){?><button onClick="SeleccionarModulo(4)">BIBLIOTECA</button><?php }?></td>
                            </tr>
                        </table>-->
                        

                        <div class="row">
                            <div class="col-md-6">
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3>ACADÉMICO</h3>
                                        <p></p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <a href="admin/index.php" class="small-box-footer">
                                      Entrar<i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php if($_SESSION['rol_finan']==1){?>
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3>FINANCIERO</h3>
                                            <p></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-usd"></i>
                                        </div>
                                        <a href="main_finan.php" class="small-box-footer">
                                          Entrar<i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php if($_SESSION['rol_medico']==1){?>
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h3>MÉDICO</h3>
                                            <p></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-medkit"></i>
                                        </div>
                                        <a href="main_medic.php" class="small-box-footer">
                                          Entrar<i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="col-md-6">
                                <?php if($_SESSION['rol_biblio']==1){?>
                                    <div class="small-box bg-light-blue">
                                        <div class="inner">
                                            <h3>BIBLIOTECA</h3>
                                            <p></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <a href="main_biblio.php" class="small-box-footer">
                                          Entrar<i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                <?php }?>
                            </div>
                        </div>

                    </form>​                
                </section>
                </div>

        </div>


    <script>     

        function SeleccionarModulo (valor)
        {
            //valor= $("#sl_modulo").val();        
            if (valor==1)
            {
                $("#frm_modulo").attr("action", "admin/index.php");
            }

            if (valor==2)
            {
                $("#frm_modulo").attr("action", "main_finan.php");
            }
            if (valor==3)
            {
                $("#frm_modulo").attr("action", "main_medic.php");
            }
            if (valor==4)
            {
				$("#frm_modulo").attr("action", "main_biblio.php");
            }
        }
    </script>

	</body>
</html>