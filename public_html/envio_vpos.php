<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejemplo de Envío de Datos V-POS - Integración V-POS</title>
    </head>
    <body>
        <?php 
            include("includes/common/vpos_plugin.php");

            //Componentes de Seguridad
            //Vector Hexadecimal
            $vector = "F1A06EE948DC5B9B";

            //Llave Publica Crypto de Alignet. Nota olvidar ingresar los saltos de linea detallados con el valor \n
			//Publica de ellos
			//Privada de ellos nunca usamos
            $llaveVPOSCryptoPub = "-----BEGIN PUBLIC KEY-----\n". 
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
            "TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
            "Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
            "DRr1jPeilfsiFwiO8wIDAQAB\n".
            "-----END PUBLIC KEY-----";

            //Llave Firma Privada del Comercio. Nota olvidar ingresar los saltos de linea detallados con el valor \n
			//Privada nuestra
            $llaveComercioFirmaPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
			"MIICXgIBAAKBgQDlwEgQZQZu3dT9WNTrOSA+nMZ6hj4HbY1qz7aEhbS6fs3mgLeS\n".
			"ED++JQyQbgxlEeto8Jy9mGQtXzZ4lIB0ejUCgXYvQi5RQS2yqSkrvWuNeR80jFPP\n".
			"2xwZwjPqxv/nFv+C/8KrTMXuuiz/mjhCNJhuHET1PZbhtPcid50XKR4B/wIDAQAB\n".
			"AoGBAN63/mP+OzVAUFfkREtejnaD7hgaiIkU11Fi2FExeFiN0jYQM2Qh4lkGe16L\n".
			"f/J+Y5HQJnHZB8vAEALmGnxPd5AGqq51LNBKIeA+RhW5F4MCOBFESClIYM3XEn7c\n".
			"xHcGbKXwmNBvQ7B8ugC4K9EOmfyDilGJMXggq96CGgFBZz1xAkEA/M23AhrEIgIt\n".
			"mLk1QEAruxgib8VNEiGK9ex3es/0XSgim6rqNo4AJX5ey0tN6Is6K0NivqELYfCx\n".
			"q7OUkwNgtwJBAOin8wz/OXT1P6KDtzJIo8qYbQ112Q8j+wDfBHCvebtSS7wRA0Ff\n".
			"zh4Css2wvoBNY4g1+uD6g6I/7uaX95UCkPkCQBTlSBAzeCy7c1thS6aA51xylT4Z\n".
			"19H81ciYABQ1piQhEiM90FgsCpUOyfURx2HGSEuVKU9Kbm9s/rKLiGdSaycCQQCH\n".
			"l5JUac7ftisvGNrE6IblBS7RYHRvmYWo/VEGJ46nuI/A/J1MFXz4CpSQwkhUWEYA\n".
			"1YzwX7Al+GLQa5L0ejlpAkEAyX5C5KLx9XmbgiKQC9l71YpsqB50wc8208Ccup1c\n".
			"5gmC3NiYMgBLvOAcmeHo3c2PRk4zmoW9rqGWsr7vfhprKQ==\n".
			"-----END RSA PRIVATE KEY-----";

            //Envío de Parametros a V-POS
            $array_send['acquirerId'] = '107';//no cambia
            $array_send['commerceId'] = '7822';
            $array_send['purchaseOperationNumber']='00000150';
            //Monto incluido con impuestos
            $array_send['purchaseAmount']='6000';
            $array_send['purchaseCurrencyCode']='840';
            $array_send['commerceMallId']='0';
            $array_send['language']='SP';
            $array_send['billingFirstName']='Juan';
            $array_send['billingLastName']='Perez';
            $array_send['billingEMail']='test@test.com';
            $array_send['billingAddress']='Direccion ABC';
            $array_send['billingZIP']='1234567890';
            $array_send['billingCity']='Quito';
            $array_send['billingState']='Quito';
            $array_send['billingCountry']='EC';
            $array_send['billingPhone']='123456789';
            $array_send['shippingAddress']='Direccion ABC';
            $array_send['terminalCode']='00000000';
            $array_send['reserved11']='Valor Reservado ABC'; //Monto Grava VIA
            
            //Parametros Taxes Sobre Inclusión de Impuestos IVA
            $array_send['tax_1_name']='Adicional';
            $array_send['tax_1_amount']='000';
            $array_send['tax_2_name']='Monto Fijo';
            $array_send['tax_2_amount']='000';
            $array_send['tax_3_name']='Monto IVA';
            $array_send['tax_3_amount']='000';
            $array_send['tax_4_name']='Adicional';
            $array_send['tax_4_amount']='000';
            $array_send['tax_5_name']='Adicional';
            $array_send['tax_5_amount']='000';
            $array_send['tax_6_name']='Adicional';
            $array_send['tax_6_amount']='000';
            $array_send['tax_7_name']='Adicional';
            $array_send['tax_7_amount']='000';
            $array_send['tax_8_name']='Adicional';
            $array_send['tax_8_amount']='000';
            $array_send['tax_9_name']='Monto No Grava IVA';
            $array_send['tax_9_amount']='6000';
            $array_send['tax_10_name']='Monto Grava IVA';
            $array_send['tax_10_amount']='000';
            
            //Ejemplo envío campos reservados en parametro reserved1.
            $array_send['reserved1']='SP';
            $array_send['reserved2']='000'; //Monto Grava IVA
            $array_send['reserved3']='000'; //Monto IVA
            $array_send['reserved4']='000';
            $array_send['reserved5']='000';
            $array_send['reserved9']='000';
            $array_send['reserved10']='000'; //Monto Grava VIA
            
            //Parametros de Solicitud de Autorización a Enviar
            $array_get['XMLREQ']="";
            $array_get['DIGITALSIGN']="";
            $array_get['SESSIONKEY']="";

            //Ejecución de Creación de Valores para la Solicitud de Autorización
            VPOSSend($array_send,$array_get,$llaveVPOSCryptoPub,$llaveComercioFirmaPriv,$vector);
        ?>

        <form name="frmVPOS" method="POST" action="https://integracion.alignetsac.com/VPOS/MM/transactionStart20.do">
            <INPUT TYPE="text" NAME="IDACQUIRER" value="<?php echo $array_send['acquirerId'];?>">
            <INPUT TYPE="text" NAME="IDCOMMERCE" value="<?php echo $array_send['commerceId'];?>">
            <INPUT TYPE="text" NAME="XMLREQ" value="<?php echo $array_get['XMLREQ'];?>">
            <INPUT TYPE="text" NAME="DIGITALSIGN" value="<?php echo $array_get['DIGITALSIGN'];?>">
            <INPUT TYPE="text" NAME="SESSIONKEY" value="<?php echo $array_get['SESSIONKEY'];?>">
            <input type="submit" text="Comprar"/>
        </form>
    </body>
</html>