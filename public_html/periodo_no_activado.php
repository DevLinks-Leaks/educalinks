<!DOCTYPE html>
<?php session_start();?>
<html style="height: 100%">
    <head>
        <title>Página en mantenimiento.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'helvetica';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 25px;
                font-style: bold;
                margin-bottom: 40px;
                color: black;
            }
        </style>
    </head>
    <body style="background:url(theme/images/background/bg_web_login_0.jpg) no-repeat center center fixed;-webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;">
        <div class="container">
            <div class="content">
                <div class="login-logo">
                    <img src="imagenes/clientes/dev/logo_inicial_long.png" alt="Educalinks"  width="50%" height="80%">
                </div>
                <div class="title">Estimado<?php echo ' '.$_SESSION['repr_nomb'].' '.$_SESSION['repr_apel'];?>, la institución todavía no ha activado el uso del sistema<br>
					para los representantes y alumnos.<br>
					En caso de alguna duda o malestar, por favor, comunicarse con la institución.</div>
                <div class="login-logo">
                    <img src="imagenes/under_maintenance.png" alt="Educalinks"  width="80%" height="80%">
                </div>
                
            </div>
        </div>
    </body>
</html>