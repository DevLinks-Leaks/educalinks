<?php
session_start();
# Importar modelo de abstracción de base de datos
require_once('../../../core/db_abstract_model.php');

class DebitosAutomaticos extends DBAbstractModel
{   #propiedades
    public $campo;
    public $descripcion;
    public $contadorpagados;
    public $contadornopagados;
    public $contadorsaldoafavor; 
    
    public function get_all_campos( $vista )
	{	$this->parametros = array( $vista );
        $this->sp = "str_consultaDebitosAutomaticos_campos";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
        {    $this->mensaje="No existen campos en la Vista";
        }
        else
        {   $debito = array();
            foreach($this->rows as $debitos)
            {    array_push($debito, array_values($debitos));
            }
			array_pop($debito);
            array_push($debito, array_values(array('otro','Otro')));
            array_push($debito, array_values(array()));
            $this->rows = $debito;
            unset($debito);
        }
    }
    public function setpagodebito_sinliquidez ($codigo, $valor, $usuario, $nombredoc, $fecha_debito, $id_formaPago )
	{	$this->parametros = array($codigo, $valor, $usuario, $nombredoc, $fecha_debito, $_SESSION['puntVent_codigo'], $_SESSION['caja_codi'], $id_formaPago );
        $this->sp = "str_ingresaPagodebito_sinliquidez";
        $this->executeSPConsulta();
        if (count($this->rows)>=1)
        {   foreach($this->rows[0] as $propiedad=>$valor)
            {   $this->$propiedad=$valor;
            }
        }
    }
    public function setpagodebito ($codigo, $valor, $usuario, $nombredoc, $fecha_debito, $id_formaPago )
	{	$this->parametros = array($codigo, $valor, $usuario, $nombredoc, $fecha_debito, $_SESSION['puntVent_codigo'], $_SESSION['caja_codi'], $id_formaPago );
        $this->sp = "str_ingresaPagodebito";
        $this->executeSPConsulta();
        if (count($this->rows)>=1)
        {   foreach($this->rows[0] as $propiedad=>$valor)
            {   $this->$propiedad=$valor;
            }
        }
    }
    public function get_all_formatos()
	{	$this->sp = "str_consultaDebitosAutomaticos_formatos";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
        {   $this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione un formato -',
                                   3 => ''));
        }
        else
        {   $rol = array();

            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione un formato -',
                                   3 => ''));
            foreach($this->rows as $categorias)
            {    array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_all_formatos_maint()
	{	$this->sp = "str_consultaDebitosAutomaticos_formatos_maint";
        $this->executeSPConsulta();
        if (count($this->rows)>=1)
		{	$this->mensaje="¡Exito! Formato(s) encontrada(s).";
        }else
		{	$this->mensaje="¡Error! Formato(s) no encontrado(s).";
        }
        return $this->rows;
    }
    public function delete_specific_format($form_debi_codigo)
	{	$this->parametros = array($form_debi_codigo);
        $this->sp = "str_consultaDebitosAutomaticos_formatos_del";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
        {    $this->mensaje="¡Exito! Formato eliminado correctamente";
        }else
        {    $this->mensaje="¡Error! No se pudo eliminar el formato seleccionado";
        }
		return $this;
    }
	public function get_all_deudas_for_unsaved_file($campos,$ultcol)
	{	$this->parametros = array($campos,$ultcol);
        $this->sp = "str_consultaDebitosAutomaticos_deudas_for_unsaved";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
        {    $this->mensaje="¡Exito! Formato(s) encontrado(s)";
        }else
        {    $this->mensaje="¡Error! Formato(s) no encontrado(s)";
        }
		return $this;
    }
	public function get_all_deudas($campos , $ultcol , $xml_productos , $fac_estado , $banco , $tarjCredito , $peri_codi , $opc_ctas_ant, $opc_ctas_inl )
	{	$this->parametros = array( $campos , $ultcol , $xml_productos , $fac_estado , $banco , $tarjCredito , $peri_codi , $opc_ctas_ant, $opc_ctas_inl );
        $this->sp = "str_consultaDebitosAutomaticos_deudas";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
        {    $this->mensaje="¡Exito! Formato(s) encontrado(s)";
        }else
        {    $this->mensaje="¡Error! Formato(s) no encontrado(s)";
        }
		return $this;
    }
    public function get_formato($campos)
	{	$this->parametros = array($campos);
        $this->sp = "str_consultaDebitosAutomaticos_formatoindi";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {    $this->mensaje="¡Exito! Formato(s) encontrado(s)";
        }
        else
        {    $this->mensaje="¡Error! Formato(s) no encontrado(s)";
        }
		return $this;
    }
	public function copy_formato($form_debi_codigo, $form_debi_descripcion, $user)
	{	$this->parametros = array($form_debi_codigo, $form_debi_descripcion, $user);
        $this->sp = "str_consultaDebitosAutomaticos_formatos_copy";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {    $this->mensaje="¡Exito! Formato copiado correctamente";
        }
        else
        {    $this->mensaje="¡Error! Formato no se pudo copiar";
        }
		return $this;
    }
    public function setdebito ($datosPago = '')
	{	$this->id_cabecera_out = 0;
		$this->nombreformato_out = "";
		$this->parametros =	array($datosPago);
        $this->sp = "str_ingresadebitos";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Formato guardado como: '".$this->rows[0]['CABECERA']."'.";
			$this->id_cabecera_out = $this->rows[0]['ID'];
			$this->nombreformato_out = $this->rows[0]['CABECERA'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al intentar guardar formato";
        }
		return $this;
    }
	public function set_debitoautomatico_config( $check_exp_opc_ant, $check_exp_opc_ctas )
	{	$this->parametros = array( $check_exp_opc_ant, $check_exp_opc_ctas );
        $this->sp = "str_consultaDebitoautomatico_config_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{	$this->mensaje="¡Exito! Su configuración ha sido cambiada.";
        }
		else
		{	$this->mensaje="¡Error! Ocurrió un problema con el cambio de la configuración";
        }
    }
	public function get_debitoautomatico_config()
	{   $this->parametros = array();
        $this->sp = "str_consultaDebitoautomatico_config_info";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	$this->mensaje="OK";
        }
		else
		{	$this->mensaje="KO";
        }
		return $this;
    }
	public function get_deudores_ctas_antiguas( $xml_productos , $peri_codi , $codcab , $fac_estado , $banco , $tarjCredito )
	{   $this->parametros = array( $xml_productos , $peri_codi , $codcab , $fac_estado , $banco , $tarjCredito );
        $this->sp = "str_consultaDebitoautomatico_get_ctas_antiguas";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	$this->mensaje="OK";
        }
		else
		{	$this->mensaje="KO";
        }
		return $this;
    }
	public function get_deudores_ctas_inliquidas( $codcab , $peri_codi )
	{   $this->parametros = array( $codcab , $peri_codi );
        $this->sp = "str_consultaDebitoautomatico_get_ctas_inliquidas";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	$this->mensaje="OK";
        }
		else
		{	$this->mensaje="KO";
        }
		return $this;
    }
	public function reset_deudores_ctas_inliquidas( $usuario )
	{   $this->parametros = array( $usuario );
        $this->sp = "str_consultaDebitoautomatico_reset_ctas_inliquidas";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	$this->mensaje="¡Exito! Deudores fueron inactivados para uso de cuenta secundaria";
        }
		else
		{	$this->mensaje="¡Error! No se pudo completar la transacción";
        }
		return $this;
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