<?php 

namespace component\GestoHTMLCRUD\Vista;


include_once ('core/builder/Mensaje.class.php');

include_once 'component/GestorHTMLCRUD/Modelo/Modelo.class.php';
use component\GestorHTMLCRUD\Modelo\Modelo as Modelo;

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}


class Tabla {

    var $miConfigurador;
    
    private $cliente;
    private $objeto;
    private $atributosObjeto;
    private $objetoId;
    private $objetoNombre;
    private $objetoAlias;
    private $mensaje;
    private $tipo;
    private $estado;
    private $permiso;
    private $categoria;
    private $objetoVisble;
    private $objetoCrear;
    private $objetoConsultar;
    private $objetoActualizar;
    private $objetoCambiarEstado;
    private $Objetoduplicar;
    private $objetoEliminar;
    private $columnas;
    private $listaParametros;
    private $listaAtributosParametros;
    private $proceso;
	private $lenguaje;
	private $listaElementos;
    
    function __construct($lenguaje = '') {

    	
        $this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );

        $this->mensaje = \Mensaje::singleton();
		$this->cliente  = new Modelo();
		
		if($lenguaje!='')$this->lenguaje = $lenguaje;
        
        	
			$this->objeto = $this->cliente->getListaObjetos();
           $this->columnas = $this->cliente->getListaColumnas();
        
        

    }
    
    public function setLenguaje($lenguaje){
    	if(is_object($lenguaje)) $this->lenguaje = $lenguaje;
    }
    
    public function setObjetoId($objetoId){
    	$this->objetoId = $objetoId;
		
		$this->objeto = $this->cliente->getListaObjetos();
           $this->columnas = $this->cliente->getListaColumnas();
    }
	
    
    private function getColumnaAliasPorNombre($nombre = ''){
    	foreach ($this->columnas as $columna){
    		
    		if($columna['nombre'] ==$nombre) return $columna['alias']; 
    		
    	}
    	return "no definido";
    }
	
    private function setBool($valor = ''){
    	if($valor=='t') return true;
    	return false;
    }
    
    
    private function getObjetoAliasPorId($objeto ='', $id = ''){
    	foreach ($this->$objeto as $elemento){
    		if($elemento['id']==$id) return $elemento['alias'];
    	}
    }
    
    private function setTextoTabla($valor = '', $nombre =''){
    	
    	$nombreSelect = '';
    	$aliasSelect = '';
    	foreach ($this->columnas as $columna){
    		
    		
    		
    		if($columna['nombre']==$nombre&&$columna['codificada']=='t'){
    			
    			return base64_decode($valor);
    		}
    		
    		if($columna['nombre']==$nombre&&$columna['input']=='select'){
    			$objeto = $columna['nombre'];
    			$id = $valor;
    			return $this->getObjetoAliasPorId($objeto , $id);
    		}
    		
    		
    	}
    	
    	return $valor;
    	
    	
    }
    
    private function getObjetoNombrePorId($objeto ='', $id = ''){
    	foreach ($this->$objeto as $elemento){
    		if($elemento['id']==$id) return $elemento['nombre'];
    	}
    }
	
	private function permitidoTabla($nombre){
		
		//rescata id de columna
		$idCol =  $this->cliente->getColumnas($nombre, 'nombre', 'id');
		if($idCol===false) return FALSE;
		
		return $this->setBool($this->cliente->getColumnas($idCol, 'id', 'requerido_tabla')); 
		
	}
    
    public function dibujarTabla($listaElementos){
    	
    	if(!is_array($listaElementos)) return false;
		$this->listaElementos = $listaElementos ;
		
    	$columnasFila = '';
    	$textoElemento = '';
    	
    	foreach ($this->listaElementos as $fila){
    		$textoElemento .= "<tr class=\"fila\">";
    		$columnasFila = '';
    		foreach ($fila as $g=>$f){
    			
				//determina si aparece en la tabla
				if($this->permitidoTabla($g)){
				  $textoElemento .= "<td>".ucfirst(strtolower($this->setTextoTabla($f,$g)))."</td>";;
    			  if(end($this->listaElementos)== $fila) $columnasFila .="<th>".ucfirst(strtolower($this->getColumnaAliasPorNombre($g)))."</th>";	
				}
    			
    		}
    		$textoElemento .= "</tr>";
    	}
    	
    	$cadena = '<table id="tabla" class="tabla">';
    	 
    	$cadena .= "<thead>";
    	$cadena .= "<tr>";
    	$cadena .= $columnasFila;
    	$cadena .= "</tr>";
    	$cadena .= "</thead>";
    	 
    	$cadena .= "<tfoot>";
    	$cadena .= "<tr>";
        $cadena .= $columnasFila;
    	$cadena .= "</tr>";
    	$cadena .= "</tfoot>";
    	
    	$cadena .= '<tbody>';
        $cadena .= $textoElemento;
    	$cadena .= '</tbody>';
    	$cadena .= "</table>";
    	return $cadena;
    	 
    }
    
}

?>