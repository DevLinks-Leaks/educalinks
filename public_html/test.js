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
                $("#frm_modulo").attr("action", "biblio/index.php");
            }
            if (valor==5)
            {
                $("#frm_modulo").attr("action", "main_admisiones.php");
            }
        }
        $(document).keypress(function(e) {
            console.log(e.keyCode);
            if ( e.keyCode === 65 || e.keyCode === 97 ) // a
                SeleccionarModulo(1);
            if ( e.keyCode === 70 || e.keyCode === 102) // f
                SeleccionarModulo(2);
            if ( e.keyCode === 66 || e.keyCode === 98) // b
                SeleccionarModulo(4);
            if ( e.keyCode === 77 || e.keyCode === 109) // m
                SeleccionarModulo(3);
            if ( e.keyCode === 68 || e.keyCode === 100) // d
                SeleccionarModulo(5);
        });