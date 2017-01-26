<?php
if(!class_exists('DB_Abstract_ws')){include 'db_abstract_ws.php';}
class Alumnos extends DB_Abstract_ws
{
	private $codigoAlumno;
	private $nombreAlumno;
	private $apellidoAlumno;
	public $resultado=array();
	
	public function set_codigoAlumno($value){
		$this->codigoAlumno = $value;
	}
	public function set_nombreAlumno($value){
		$this->nombreAlumno = $value;
	}
	public function set_apellidoAlumno($value){
		$this->codigoAlumno = $value;
	}	
	public function get_codigoAlumno(){
		return $this->codigoAlumno;
	}
	public function get_nombreAlumno(){
		return $this->nombreAlumno;
	}
	public function get_apellidoAlumno(){
		return $this->apellidoAlumno;
	}
	
	
	public function getAlumnosRepr($alum_codi)
	{
        $this->parametros = array($alum_codi);
        $this->sp = "alum_info";
        $this->executeSPConsulta();
        if ($this->filasDevueltas>0){
			$this->codigoAlumno=$this->rows[0]['alum_codi'];
			$this->nombreAlumno=$this->rows[0]['alum_nomb'];
			$this->apellidoAlumno=$this->rows[0]['alum_apel'];
			$this->resultado = array("codigoAlum"=>$this->codigoAlumno,"nombreAlumno"=>$this->nombreAlumno,"apellidoAlumno"=>$this->apellidoAlumno);
        }
		else{
            $this->mensaje="Clientes no encontrados";
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