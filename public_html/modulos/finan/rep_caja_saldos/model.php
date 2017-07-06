<?php
require_once('../../../core/db_abstract_model.php');
session_start();
class Pagos extends DBAbstractModel{
    #propiedades
    public $numero;
    public $codigo;
    public $codigoCliente;
    public $nombreTitular;
    public $direccionTitular;
    public $telefonoTitular;
    public $emailTitular;
	public $estado;
	
	public function get_PagosRealizados($codigo_pago=0, $fechavenc_ini = '', $fechavenc_fin = '', $forma_pago = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $num_factura = '', $cat_codigo = '', $prod_codigo = '', 
		$estado = '', $tpago_ini = 0, $tpago_fin = 0, $usua_codi = '-1', $periodo = 0, $grupoEconomico = 0, $nivelEconomico = 0, $curso = 0, $deuda = '-1' )
	{
		$this->parametros = array($_SESSION['peri_codi'], $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
		$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
		$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $cat_codigo, $prod_codigo, 
		$estado, $tpago_ini, $tpago_fin, $usua_codi, $periodo, $grupoEconomico, $nivelEconomico, $curso, $deuda );
        $this->sp = "str_consultaPagosRealizados";
        $this->executeSPConsulta();

        if (count($this->rows)>1)
		{   $this->mensaje="¡Exito! Pagos realizados encontradas.";
        }else
		{   $this->mensaje="¡Error! Pagos realizados no encontradas.";
        }
        return $this->rows;
    }
	public function get_formaPagoSelectFormat_caja($busq='')
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaFormaPago_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{   $this->mensaje="No existen formas depago en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => '- Seleccione forma de pago -',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }
		else
		{   $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => '- Seleccione forma de pago -',
                                   3 => ''));
            foreach($this->rows as $formasPago)
			{   array_push($bypass, array_values($formasPago));
            }
            $this->rows = $bypass;
            unset($bypass);
        }
    }
	public function get_formaPagoSelectFormat($busq='')
	{   $this->parametros = array($busq);
        $this->sp = "str_consultaFormaPago_busq";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{   $this->mensaje="No existen formas depago en la BD.";
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => '- Seleccione forma de pago -',
                                   3 => ''));
            $this->rows = $bypass;
            unset($bypass);
        }
		else
		{   $bypass = array();
            array_pop($bypass);
            array_push($bypass, array(0 => '', 
                                   1 => '- Seleccione forma de pago -',
                                   3 => ''));
			array_push($bypass, array(0 => '8', 1 => 'DEBITO BANCARIO', 3 => ''));
			array_push($bypass, array(0 => '10', 1 => 'CONVENIO DE PAGO', 3 => ''));
			array_push($bypass, array(0 => '11', 1 => 'PAGO POR VENTANILLA', 3 => ''));
            foreach($this->rows as $formasPago)
			{   array_push($bypass, array_values($formasPago));
            }
            $this->rows = $bypass;
            unset($bypass);
        }
    }
	public function revertir_factura( $codigo )
	{   $this->parametros = array( $codigo, $_SESSION['usua_codi'] );
		$this->sp = "str_factura_revertirPago";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   if ( $this->rows[0]['Estado'] == 'OK' )
				$this->mensaje='¡Exito! Pago eliminado. Deuda revertida a Estado: "Por cobrar".</div>
						<br><div class="row">
						<div class="col-md-12" style="text-align:right"><button class="btn btn-default" id="btn_modal_revert_dismiss" name="btn_modal_revert_dismiss" data-dismiss="modal">Entendido</button></div></div>';
			else if ( $this->rows[0]['Estado'] == 'WORKABLE' )
				$this->mensaje="¡Advertencia! ".
					'<div class="row"><div class="col-md-12">
					 	El sistema ha detectado que la(s) factura(s) relacionada(s) a este pago tienen uno de los siguientes estados
					    electrónico: ERROR, NO AUTORIZADO, AUTORIZADO, DEVUELTA, EN PROCESO;<br>
					    <br>
					    por lo que puede que su factura ya esté registrada en el sistema del SRI, por lo que el sistema de Educalinks
					    no puede completar el proceso de reverso de pago normalmente.<br>
					    <br>
					    Si desea, puede continuar con el proceso de pago, pero la información referente a facturación electrónica (incluyendo el número secuencial
						de factura) no serán reseteados.<br>
						<br>
						¿Desea continuar?</div></div></div>
						<br><div>
						<div class="row"><div class="col-md-6" style="text-align:center"><button class="btn btn-default" id="btn_modal_revert_followed" name="btn_modal_revert_followed" onclick="js_Pago_revertir_followed_keep_e_info( '. $this->rows[0]['cabePago_codigo'].' );" ><li class="fa fa-history btn_opc_lista_editar"></li>&nbsp;Revertir de todos modos</button></div>'.
						'<div class="col-md-6" style="text-align:center"><button class="btn btn-default" id="btn_modal_revert_dismiss" name="btn_modal_revert_dismiss" data-dismiss="modal"><li style="color:red;" class="fa fa-ban"></li>&nbsp;No revertir</button></div></div>';
			else if ( $this->rows[0]['Estado'] == 'NO OK' )
				$this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b><br>Pago no encontrado.";
			else
				$this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b><br>Puede que la factura haya sido autorizada. Los pagos de facturas autorizadas no se pueden revertir.";
        }
		else
		{   $this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b><br>Puede que la factura haya sido autorizada. Los pagos de facturas autorizadas no se pueden revertir.";
        }
		return $this;
    }
	public function revertir_factura_keep_e_info( $codigo )
	{   $this->parametros = array( $codigo, $_SESSION['usua_codi'] );
		$this->sp = "str_factura_revertirPago_ex";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
		{   if ( $this->rows[0]['Estado'] == 'OK' )
				$this->mensaje='¡Exito! Pago eliminado. Deuda revertida a Estado: "Por cobrar". <b>Información electrónica</b> y <b>número secuencial</b> preservados.</div>
						<br><div class="row">
						<div class="col-md-12" style="text-align:right"><button class="btn btn-default" id="btn_modal_revert_dismiss" name="btn_modal_revert_dismiss" data-dismiss="modal">Entendido</button></div></div>';
			else if ( $this->rows[0]['Estado'] == 'NO OK' )
				$this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b>";
			else
				$this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b>";
        }
		else
		{   $this->mensaje="¡Error! <b>No se pudo eliminar el pago.</b>";
        }
		return $this;
    }
	public function get_caja_cierre_fp($codigo_pago=0, $fechavenc_ini = '', $fechavenc_fin = '', $forma_pago = '',
		$cod_titular = '', $id_titular = '', $cod_estudiante = '', $nombre_estudiante = '',
		$nombre_titular = '', $ptvo_venta = '', $sucursal = '', $num_factura = '', $cat_codigo = '', $prod_codigo = '', 
		$estado = '', $tpago_ini = 0, $tpago_fin = 0, $usua_codi = '-1', $periodo = 0, $grupoEconomico = 0, $nivelEconomico = 0, $curso = 0, $orden_reporte = null )
	{   
	    $this->parametros = array( $_SESSION['peri_codi'], $codigo_pago, $fechavenc_ini, $fechavenc_fin, $forma_pago,
		$cod_titular, $id_titular, $cod_estudiante, $nombre_estudiante,
		$nombre_titular, $ptvo_venta, $sucursal, $num_factura, $cat_codigo, $prod_codigo, 
		$estado, $tpago_ini, $tpago_fin, $usua_codi, $periodo, $grupoEconomico, $nivelEconomico, $curso, $orden_reporte ); 
        $this->sp = "str_consultaCajaCierre_rep_fp";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="Transacciones encontradas";
        }else{
            $this->mensaje="No existen transacciones realizadas";
        }
    }
    # Método constructor
    function __construct() {
        //$this->db_name = 'URBALINKS_FINAN';
    }

    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
?>